<?php


class Laporan_model extends CI_Model {


    public function getDatalist()
    {      
            $this->db->select('mst_driver.*, mst_user.nama AS petugas');
            $this->db->from('mst_driver');
            $this->db->join('mst_user', 'mst_driver.id_petugas = mst_user.id', 'left');
            $query = $this->db->get();

            return $query->result();
    }
    
    public function get_laporan_checklist($tanggal, $terminal = 'Semua')
    {
        
       $this->db->select("
                d.nama,
                d.tgl_lahir,
                d.jns_kel,
                p.nama_terminal,
                p.date_time,
            
                CASE WHEN p.status_ht = 1 THEN 1 ELSE 0 END AS ht_normal,
                CASE WHEN p.status_ht = 2 THEN 1 ELSE 0 END AS ht_ringan,
                CASE WHEN p.status_ht = 3 THEN 1 ELSE 0 END AS ht_sedang,
                CASE WHEN p.status_ht = 4 THEN 1 ELSE 0 END AS ht_berat,
           
                CASE WHEN p.gds BETWEEN 80 AND 200 THEN 1 ELSE 0 END AS gds_normal,
                CASE WHEN p.gds > 200 AND p.ada_gejala = '0' THEN 1 ELSE 0 END AS gds_tanpa_gejala,
                CASE WHEN p.gds > 200 AND p.ada_gejala = '1' THEN 1 ELSE 0 END AS gds_dengan_gejala,
            
                CASE WHEN fr.tes_urine = 1 THEN 1 ELSE 0 END AS amph_negatif,
                CASE WHEN fr.tes_urine = 0 THEN 1 ELSE 0 END AS amph_tdk_diperiksa,
                CASE WHEN fr.tes_urine = 2 THEN 1 ELSE 0 END AS amph_positif,
           
                CASE WHEN p.status_laik = 1 THEN 1 ELSE 0 END AS laik,
                CASE WHEN p.status_laik = 2 THEN 1 ELSE 0 END AS laik_catatan,
                CASE WHEN p.status_laik = 3 THEN 1 ELSE 0 END AS tidak_laik,
                CASE WHEN p.rujuk = 1 THEN 1 ELSE 0 END AS dirujuk
            ", FALSE);
            
            $this->db->from('ts_pemeriksaan p');
            $this->db->join('mst_driver d', 'd.id = p.id_driver');
            $this->db->join(
                'tbl_faktor_resiko fr',
                'fr.id_pemeriksaan = p.id',
                'LEFT'
            );
            
            $this->db->where('DATE(p.date_time)', $tanggal);
            
            if (!empty($terminal) && $terminal != 'Semua') {
                $this->db->where('p.nama_terminal', $terminal);
            }
            
            $this->db->order_by('d.nama', 'ASC');
            
            return $this->db->get()->result();
    }
    

    public function getDataLaporan($tgl, $terminal)
    {
       
        if($terminal == ''){ 
            $and_terminal = '';
        }else{
            $and_terminal = " AND a.nama_terminal = '$terminal'";
        }


       $sql = "SELECT a.*, b.nama, b.tgl_lahir, b.jns_kel, b.nama_po, c.tes_keseimbangan, c.tes_urine
       FROM ts_pemeriksaan  a
       LEFT JOIN mst_driver  b ON a.id_driver =  b. id
       LEFT JOIN tbl_faktor_resiko  c ON a.id =  c. id_pemeriksaan
       WHERE date_time like '$tgl%'  $and_terminal";

       $qry = $this->db->query($sql);
       $row = $qry->result();

      # echo $sql;

       return $row;
    }


}


?>