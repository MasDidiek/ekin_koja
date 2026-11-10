<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Renkin_model extends CI_Model{


 // Definisikan konstanta agar kode mudah dibaca
    const STATUS_DRAFT    = 0;
    const STATUS_DIAJUKAN  = 1;
    const STATUS_DISETUJUI = 2;
    const STATUS_DITOLAK   = 3;
    const STATUS_REVISI    = 4;


     public function get_status_list() {
        return [
            self::STATUS_DRAFT    => ['label' => 'Draft', 'class' => 'bg-secondary'],
            self::STATUS_DIAJUKAN  => ['label' => 'Diajukan', 'class' => 'bg-warning text-white'],
            self::STATUS_DISETUJUI => ['label' => 'Disetujui', 'class' => 'bg-success'],
            self::STATUS_DITOLAK   => ['label' => 'Ditolak', 'class' => 'bg-danger'],
            self::STATUS_REVISI    => ['label' => 'Revisi', 'class' => 'bg-warning text-dark']
        ];
    }

    function getListIndikator($id_jabatan = null){
        //$qry = $this->db->get('mst_indikator_kinerja');

        $this->db->select('ik.*, j.nama AS jabatan');
		$this->db->from('mst_indikator_kinerja ik');
		$this->db->join('mst_jabatan j', 'ik.profesi = j.id', 'left');
        if (!empty($id_jabatan)) {
            $this->db->where('ik.profesi', $id_jabatan);
        }
		$this->db->order_by('ik.id', 'DESC');
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

    function getIndikatorAktif(){
        $this->db->select('ik.*, j.nama AS jabatan');
        $this->db->from('mst_indikator_kinerja ik');
        $this->db->join('mst_jabatan j', 'ik.profesi = j.id', 'left');
        $this->db->where('ik.publish', 1);
        $this->db->order_by('ik.indikator', 'ASC');
        return $this->db->get()->result();
    }

    function tambahIndikatorRenkin($id_pegawai, $tahun, $id_indikator){
        $indikator = $this->db->get_where('mst_indikator_kinerja', ['id' => $id_indikator, 'publish' => 1])->row();
        if (!$indikator) {
            return ['success' => false, 'message' => 'Indikator tidak ditemukan atau tidak aktif.'];
        }

        $renkin = $this->getlistRenkinPegawai($id_pegawai, $tahun);
        foreach ($renkin as $row) {
            if ((int) $row->status !== self::STATUS_DRAFT) {
                return ['success' => false, 'message' => 'Indikator tidak dapat ditambahkan karena Renkin sudah diajukan.'];
            }
            if ((int) $row->id_indikator === (int) $id_indikator) {
                return ['success' => false, 'message' => 'Indikator sudah ada pada Renkin tahun tersebut.'];
            }
        }

        $this->db->trans_begin();
        $id_renkin = $this->insertRenkin($id_pegawai, $tahun, $id_indikator);
        if (!$id_renkin || !$this->insertRenkinDetail($id_renkin, $id_indikator) || $this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return ['success' => false, 'message' => 'Indikator gagal ditambahkan. Silakan coba kembali.'];
        }
        $this->db->trans_commit();
        return ['success' => true, 'message' => 'Indikator berhasil ditambahkan.'];
    }

    function getlistRenkinPegawai($id_pegawai, $tahun){
        $qry = $this->db->get_where('ts_renkin', ['id_pegawai'=> $id_pegawai, 'tahun'=> $tahun]);
        $row = $qry->result();
        return $row;

    }

    function getDataRenkinPegawai($id_pegawai, $tahun = null){

        $this->db->where('id_pegawai', $id_pegawai);
        if ($tahun !== null) {
            $this->db->where('tahun', $tahun);
        }
        $this->db->order_by('id', 'ASC');
        return $this->db->get('ts_renkin')->result();
    }

    function createRenkinPegawai($id_pegawai, $tahun){
        $pegawai = $this->db->get_where('mst_pegawai', ['id_pegawai' => $id_pegawai])->row();
        if (empty($pegawai)) {
            return ['success' => false, 'message' => 'Data pegawai tidak ditemukan.'];
        }

        if (!empty($this->getlistRenkinPegawai($id_pegawai, $tahun))) {
            return ['success' => false, 'message' => 'Renkin untuk tahun tersebut sudah dibuat.'];
        }

        $indikator_list = $this->getIndikatorByProfesi($pegawai->id_jabatan);
        if (empty($indikator_list)) {
            return ['success' => false, 'message' => 'Tidak ada indikator aktif untuk jabatan Anda.'];
        }

        $this->db->trans_begin();
        foreach ($indikator_list as $indikator) {
            $id_renkin = $this->insertRenkin($id_pegawai, $tahun, $indikator->id);
            if (empty($id_renkin) || !$this->insertRenkinDetail($id_renkin, $indikator->id)) {
                $this->db->trans_rollback();
                return ['success' => false, 'message' => 'Renkin gagal dibuat. Silakan coba kembali.'];
            }
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return ['success' => false, 'message' => 'Renkin gagal dibuat. Silakan coba kembali.'];
        }

        $this->db->trans_commit();
        return ['success' => true, 'message' => count($indikator_list) . ' indikator berhasil dibuat.'];
    }

    function getRenkinDetail($id_renkin){
        return $this->db->get_where('ts_renkin_detail', ['id_renkin' => $id_renkin])->result();
    }

    function getRenkinDetailByMonth($id_renkin, $bulan){
        return $this->db->get_where('ts_renkin_detail', [
            'id_renkin' => $id_renkin,
            'bulan' => $bulan
        ])->row();
    }

    function updateValidasiRenkinDetail($id_renkin, $bulan, $validasi){
        $this->db->where('id_renkin', $id_renkin);
        $this->db->where('bulan', $bulan);
        $this->db->where('status !=', 1);
        $updated = $this->db->update('ts_renkin_detail', [
            'validasi' => $validasi,
            'status' => 1
        ]);

        return $updated && $this->db->affected_rows() > 0;
    }

    function getRenkinPegawaiById($id_renkin, $id_pegawai){
        return $this->db->get_where('ts_renkin', [
            'id' => $id_renkin,
            'id_pegawai' => $id_pegawai
        ])->row();
    }

    function updateTargetRenkin($id_renkin, $id_pegawai, $target_tahunan, $target_bulanan){
        if (count($target_bulanan) !== 12 || !$this->getRenkinPegawaiById($id_renkin, $id_pegawai)) {
            return false;
        }

        $detail = $this->getRenkinDetail($id_renkin);
        $bulan_tersedia = array();
        foreach ($detail as $row) {
            $bulan_tersedia[(int) $row->bulan] = true;
        }
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            if (!isset($bulan_tersedia[$bulan]) || !array_key_exists($bulan, $target_bulanan)) {
                return false;
            }
        }

        $renkin_header = $this->getRenkinPegawaiById($id_renkin, $id_pegawai);
        if($renkin_header->status==4){
            $new_status = 1; 
        }else{
             $new_status = 0; 
        }

        $this->db->trans_begin();
        $this->db->where('id', $id_renkin);
        $this->db->where('id_pegawai', $id_pegawai);
        $parent_updated = $this->db->update('ts_renkin', ['target_tahunan' => $target_tahunan, 'status'=> $new_status]);

        if (!$parent_updated) {
            $this->db->trans_rollback();
            return false;
        }

        foreach ($target_bulanan as $bulan => $target) {
            $this->db->where('id_renkin', $id_renkin);
            $this->db->where('bulan', $bulan);
            if (!$this->db->update('ts_renkin_detail', ['target' => $target])) {
                $this->db->trans_rollback();
                return false;
            }
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_commit();
        return true;
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
            'jns_indikator' => $indikator->jns_indikator,
        ];
         if (!$this->db->insert('ts_renkin', $data)) {
             return false;
         }
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
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $data = [
                'id_renkin' => $id_renkin,
                'bulan'     => $bulan,
                'target'    => 0,
                'realisasi' => 0,
                'status'    => 0
            ];

            if (!$this->db->insert('ts_renkin_detail', $data)) {
                return false;
            }
        }

        return true;
    }

    function update_status($id, $status){
        $this->db->where('id', $id);
        $this->db->set('status', $status);
         $this->db->set('catatan', "");
        $update =$this->db->update('ts_renkin');
        return $update;

    }

       function update_revisi($id, $status, $alasan){
        $this->db->where('id', $id);
        $this->db->set('status', $status);
        $this->db->set('catatan', $alasan);
        
        $update =$this->db->update('ts_renkin');
        return $update;

    }

    
    

}