<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Renkin_model extends CI_Model{

    function getListIndikator($id_jabatan =null){
        //$qry = $this->db->get('mst_indikator_kinerja');

        $this->db->select('ik.*, j.nama AS jabatan');
		$this->db->from('mst_indikator_kinerja ik');
		$this->db->join('mst_jabatan j', 'ik.profesi = j.id', 'left');
        if($id_jabatan!=null){
            $this->db->where('profesi', $id_jabatan);
        }
		$qry = $this->db->get();
		$row = $qry->result();
        return $row;

    }

    // Menambah data indikator kinerja baru
    public function insert_indikator($data) {
        return $this->db->insert('mst_indikator_kinerja', $data);
    }

    // Ambil list indikator + filter profesi jika dipilih
    public function get_all_indikator($profesi = NULL) {
        $this->db->select('a.*, b.nama as jabatan');
        $this->db->from('mst_indikator_kinerja a');
        $this->db->join('mst_jabatan b', 'b.id = a.profesi', 'left');

        if (!empty($profesi)) {
            $this->db->where('a.profesi', $profesi);
        }

        $this->db->order_by('a.id', 'DESC');
        return $this->db->get()->result();
    }

    // Ambil 1 data indikator berdasarkan ID
    public function get_indikator_by_id($id) {
        return $this->db->get_where('mst_indikator_kinerja', ['id' => $id])->row();
    }

    // Update
    public function update_indikator($id, $data) {
        return $this->db->where('id', $id)->update('mst_indikator_kinerja', $data);
    }

    // Delete
    public function delete_indikator($id) {
        return $this->db->where('id', $id)->delete('mst_indikator_kinerja');
    }

    // Import Batch
    public function insert_batch_indikator($data) {
        return $this->db->insert_batch('mst_indikator_kinerja', $data);
    }

    function getIndikatorByProfesi($profesi){
        return $this->db->get_where('mst_indikator_kinerja', ['profesi' => $profesi, 'publish'=> 1])->result();
    }

    function getlistRenkinPegawai($id_pegawai, $tahun){
        $qry = $this->db->get_where('ts_renkin', ['id_pegawai'=> $id_pegawai, 'tahun'=> $tahun]);
        $row = $qry->result();
        return $row;

    }

    function getRenkinDetail($id_renkin){
        return $this->db->get_where('ts_renkin_detail', ['id_renkin' => $id_renkin])->result();
    }

    function insertRenkin($id_pegawai, $tahun, $id_indikator){

        $indikator = $this->get_indikator_by_id($id_indikator);

        $data = [
            'id_pegawai' => $id_pegawai,
            'tahun' => $tahun,
            'id_indikator' => $id_indikator,
            'indikator' => $indikator->indikator,
            'satuan' => $indikator->satuan,
            'target_tahunan' => $indikator->target_tahunan,
            'auto_fill_target' => $indikator->auto_fill_target,
        ];
         $this->db->insert('ts_renkin', $data);
         $id = $this->db->insert_id();
         return $id;
    }

    function updateOrInsertDetail($id_renkin, $bulan,  $target, $realisasi){
      
         $data = [
                'target'    => $target,
                'realisasi' => $realisasi,
            ];

        $this->db->where('id_renkin', $id_renkin);
        $this->db->where('bulan', $bulan);
        $this->db->update('ts_renkin_detail', $data);  
        return true;
    }



   function insertRenkinDetail($id_renkin, $id_indikator)
    {
        $indikator = $this->get_indikator_by_id($id_indikator);

        $target_tahunan = (int) $indikator->target_tahunan;
        $auto_fill = $indikator->auto_fill_target;

      

        // Hitung jarak bulan jika target tahunan <= 12 (misal: 4, 6, 12)
        $jarak_bulan = 0;
        if ($target_tahunan <= 12 && $target_tahunan > 0) {
            $jarak_bulan = 12 / $target_tahunan;
        }

        // SELALU LOOP 12 BULAN (1 sampai 12)
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            
            $target_value = 0; // Default 0 untuk bulan yang tidak ada target

            if ($target_tahunan <= 12 && $target_tahunan > 0) {
                // Cek apakah bulan ini adalah akhir periode (kelipatan jarak bulan)
                // Contoh: target 4 -> jarak = 3. Bulan yang dapat target: 3, 6, 9, 12
                if ($bulan % $jarak_bulan == 0) {
                    $target_value = 1; // Atau sesuaikan pembagian target per periode
                }
            } else {
                // Jika target tahunan > 12, bagi rata ke 12 bulan
                $target_value = $target_tahunan / 12;
            }

            $data = [
                'id_renkin' => $id_renkin,
                'bulan'     => $bulan,
                'target'    => $target_value,
                'status'    => 0
            ];

            $this->db->insert('ts_renkin_detail', $data);
        }

        return true;
    }

    

}