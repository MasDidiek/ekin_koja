<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RiwayatGaji_model extends CI_Model{
   

  protected $table = 'tbl_riwayat_gaji_baru';


        public function getLatestPerPegawai()
        {
        return $this->db->query("
           SELECT 
                rg.*,
                p.nama AS nama_pegawai,
                p.nip,
                j.nama AS jabatan
            FROM tbl_riwayat_gaji_baru rg
            JOIN (
                SELECT id_pegawai, MAX(tmt) AS tmt_terakhir
                FROM tbl_riwayat_gaji_baru
                GROUP BY id_pegawai
            ) x 
                ON rg.id_pegawai = x.id_pegawai 
                AND rg.tmt = x.tmt_terakhir
            JOIN mst_pegawai p 
                ON p.id_pegawai = rg.id_pegawai
            LEFT JOIN mst_jabatan j 
                ON j.id = p.id_jabatan;

        ")->result();
        }


    public function getByTahun($tahun)
    {
        return $this->db
            ->where('start <=', $tahun)
            ->where('end >', $tahun)
            ->get('mst_masa_kerja')
            ->row();
    }

    public function getGajiPokok($id_masa_kerja, $id_pendidikan)
    {
        return $this->db
            ->where('id_masa_kerja', $id_masa_kerja)
            ->where('id_pendidikan', $id_pendidikan)
            ->where('id_status', 4)
            ->get('mst_gaji')
            ->row();
    }

    public function exists($id_pegawai, $tmt)
    {
        return $this->db
            ->where('id_pegawai', $id_pegawai)
            ->where('tmt', $tmt)
            ->count_all_results($this->table) > 0;
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function getKategori($tahun)
    {
        return $this->db
            ->where('start <=', $tahun)
            ->where('end >', $tahun)
            ->get('mst_masa_kerja')
            ->row();
    }

    



    function getDataGajiPegawai($id_pegawai){

          return $this->db
            ->where('id_pegawai', $id_pegawai)
            ->get($this->table)
            ->result();


    }
   
}
