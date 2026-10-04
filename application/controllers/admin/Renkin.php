<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Renkin extends CI_Controller
{
	public function __construct()
	{

		parent::__construct();
	
		$this->load->model('Renkin_model','rm');
		$this->load->helper('text');
		$this->Auth_model->cekAuthLogin();

	}

	function index()
	{

    //print_array($this->session->userdata());
		
		$id_jabatan =  $this->input->get('id_jabatan');
		$usergroup   = $this->session->userdata('usergroup');
		$id_pegawai =  $this->session->userdata('id_pegawai');

	
		if($usergroup >=4){

			$tahun = $this->input->get('tahun');
            $data['tahun'] = $tahun;
            $data['list_renkin'] = $this->rm->getlistRenkinPegawai($id_pegawai, $tahun);
			$this->load->view('renkin/my_renkin', $data);
			exit;
		}else if($usergroup == 3){
            $tahun = $this->input->get('tahun');
            $data['tahun'] = $tahun;
            $data['list_pegawai'] = $this->getlistPegawai();
			$this->load->view('admin/renkin/list_pegawai', $data);
			exit;
        }

		$data['list_jabatan'] 	   = $this->Master_model->getlistJabatan();
		$data['list_indikator'] = $this->rm->getListIndikator($id_jabatan);
		$this->load->view('admin/renkin/index', $data);
		
       
    }


    function getlistPegawai(){
       
        $id_validator =  $this->session->userdata('id_pegawai');
        $thn_anggaran = 2024;

        $this->db->select('a.id_pegawai, a.nama, a.nip, j.nama as jabatan, a.jns_pegawai');
		$this->db->from('mst_pegawai a');
        $this->db->join('mst_jabatan j', 'a.id_jabatan = j.id', 'left');
		$this->db->where('a.id_validator', $id_validator);
		$this->db->where_in('a.jns_pegawai', ['non_pns', 'pppk_pw']);
		$this->db->where('a.tahun_anggaran', $thn_anggaran);
		$this->db->where('a.status_kerja >', 0);

		$this->db->order_by('nama', 'ASC');

		return $this->db->get()->result();
    }




	function add_indikator(){

		$data['list_jabatan'] 	   = $this->Master_model->getlistJabatan();
		$this->load->view('admin/renkin/add_indikator', $data);
		
	}

	function simpan_indikator_kinerja(){

		$data = [
			'indikator' => $this->input->post('indikator'),
			'satuan' => $this->input->post('satuan'),
			'target_tahunan' => $this->input->post('target_tahunan'),
			'profesi' => $this->input->post('profesi'),
			'auto_fill_target' => $this->input->post('auto_fill_target'),
		];

		$this->rm->insert_indikator($data) ;
		$this->session->set_flashdata('success', 'Data indikator berhasil disimpan');

		redirect('admin/renkin/index');
	}

	function edit_indikator($id){


		$data['data_edit']     = $this->rm->get_indikator_by_id($id);
		$data['list_jabatan']  = $this->Master_model->getlistJabatan();
		$this->load->view('admin/renkin/edit_indikator', $data);
	}

	function hapus_indikator($id){

	    $this->db->where('id', $id);
	    $this->db->delete('mst_indikator_kinerja');
		$this->session->set_flashdata('success', 'Data indikator berhasil dihapus');

		redirect('admin/renkin/index');
	}
    function renkin_saya(){
        $this->load->view('kinerja/renkin');
    }


	 function buat_renkin(){

         $tahun = $this->input->get('tahun');
         $id_pegawai = $this->session->userdata('id_pegawai');
         $list_renkin  = $this->rm->getlistRenkinPegawai($id_pegawai, $tahun);

         if(!empty($list_renkin)){
             $this->session->set_flashdata('error', 'Rencana kinerja tahun '.$tahun.' sudah ada');
             redirect('admin/renkin/index?tahun='.$tahun);
         }else{
            $this->db->select('id_jabatan');
            $qry =  $this->db->get_where('mst_pegawai', array('id_pegawai' => $id_pegawai));
            $pegawai = $qry->row();

            $indikator = $this->rm->getIndikatorByProfesi($pegawai->id_jabatan);



            if(empty($indikator)){
                $this->session->set_flashdata('error', 'Data Indikator Rencana kinerja tidak ditemukan');
                redirect('admin/renkin/index?tahun='.$tahun);
            }else{
                foreach($indikator as $row){
                    $id_renkin = $this->rm->insertRenkin($id_pegawai, $tahun, $row->id);
                    $this->rm->insertRenkinDetail($id_renkin, $row->id);
                }

                $this->session->set_flashdata('success', 'Data Indikator Rencana kinerja berhasil ditambahkan');
                redirect('admin/renkin/index?tahun='.$tahun);
            }
         }


    }

   public function simpan_validasi_massal() {
    $bulan = $this->input->post('bulan_validasi');
    $tahun = $this->input->post('tahun_validasi');
    $id_pegawai = $this->input->post('id_pegawai_validasi');
    $status_list = $this->input->post('status');   // Array [id_renkin => status]
    $catatan_list = $this->input->post('catatan'); // Array [id_renkin => catatan]
    $status_values = [
        'pending' => 0,
        'approved' => 1,
        'rejected' => 2
    ];

    if (!empty($id_pegawai) && !empty($tahun) && !empty($status_list) && is_array($status_list)) {
        $this->db->trans_start();

        foreach ($status_list as $id_renkin => $status) {
            $renkin = $this->db->get_where('ts_renkin', [
                'id' => $id_renkin,
                'id_pegawai' => $id_pegawai,
                'tahun' => $tahun
            ])->row();

            if (empty($renkin) || !array_key_exists($status, $status_values)) {
                continue;
            }

            $catatan = isset($catatan_list[$id_renkin]) ? $catatan_list[$id_renkin] : null;

            $data_update = array(
                'status'  => $status_values[$status],
                'catatan' => $catatan
            );

            $this->db->where('id_renkin', $id_renkin);
            $this->db->where('bulan', $bulan);
            $this->db->update('ts_renkin_detail', $data_update);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->session->set_flashdata('success', 'Validasi massal bulan ' . $bulan . ' berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan validasi massal.');
        }
    }

    redirect('admin/renkin/validasi_renkin?id_pegawai=' . urlencode($id_pegawai) . '&tahun=' . urlencode($tahun));
}

    function get_detail_ajax($id_renkin){

      $renkinDetail = $this->rm->getRenkinDetail($id_renkin);
      
      echo  json_encode($renkinDetail);
    }

	public function update_detail() {
        $tahun = 2026;
        $id_renkin  = $this->input->post('id_renkin');
        $targets    = $this->input->post('target');
        $realisasis = $this->input->post('realisasi');
        $target_tahunan    = $this->input->post('target_tahunan');



        $this->db->where('id', $id_renkin);
        $this->db->set('target_tahunan', $target_tahunan);
        $this->db->update('ts_renkin');
        // Ambil bulan saat ini dalam format angka (1 - 12)
        $current_month = (int) date('n');

        for ($bln = 1; $bln <= 12; $bln++) {
            // 1. Target selalu diproses untuk bulan 1-12
            $target = (isset($targets[$bln]) && $targets[$bln] !== '') ? $targets[$bln] : 0;

            // 2. Realisasi hanya diproses jika bulan <= bulan saat ini
            if ($bln <= $current_month) {
                if (isset($realisasis[$bln]) && $realisasis[$bln] !== '') {
                    $realisasi = $realisasis[$bln]; // Angka (termasuk 0)
                } else {
                    $realisasi = NULL; // Belum diisi
                }
            } else {
                // Jika bulan yang akan datang, paksa tetap NULL (atau pertahankan nilai lama)
                $realisasi = NULL; 
            }

            // Simpan / update ke database
            $this->rm->updateOrInsertDetail($id_renkin, $bln, $target, $realisasi);
        }

        $this->session->set_flashdata('success', 'Data Target & Realisasi berhasil diperbarui.');
       redirect('admin/renkin/index?tahun='.$tahun);
    }

    public function get_massal_ajax() {
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        $id_pegawai = $this->input->get('id_pegawai');

        if ($bulan === null || $tahun === null || $id_pegawai === null) {
            echo json_encode([]);
            return;
        }

        $this->db->select('tr.id AS id_renkin, tr.indikator, tr.target_tahunan AS target, rd.realisasi, rd.status, rd.catatan, rd.bulan');
        $this->db->from('ts_renkin tr');
        $this->db->join('ts_renkin_detail rd', 'rd.id_renkin = tr.id', 'left');
        $this->db->where('tr.tahun', $tahun);
        $this->db->where('tr.id_pegawai', $id_pegawai);
        $this->db->where('rd.bulan', $bulan);
        $this->db->order_by('tr.indikator', 'ASC');
        $rows = $this->db->get()->result_array();

        foreach ($rows as &$row) {
            $status = $row['status'];
            if ($status === null || $status === '') {
                $row['status'] = 'pending';
            } elseif (is_numeric($status)) {
                $status = (int) $status;
                $row['status'] = ($status === 1) ? 'approved' : (($status === 2) ? 'rejected' : 'pending');
            } elseif (!in_array($status, ['pending', 'approved', 'rejected'], true)) {
                $row['status'] = 'pending';
            }

            $row['target'] = ($row['target'] === null || $row['target'] === '') ? null : (float) $row['target'];
            $row['realisasi'] = ($row['realisasi'] === null || $row['realisasi'] === '') ? null : (float) $row['realisasi'];
            $row['catatan'] = $row['catatan'] ?? '';
        }

        echo json_encode($rows);
    }

    function validasi_renkin(){
        $id_pegawai = $this->input->get('id_pegawai');
        $tahun = $this->input->get('tahun');

        $data['id_pegawai'] = $id_pegawai;
        $data['tahun'] = $tahun;
        $data['list_renkin'] = $this->rm->getlistRenkinPegawai($id_pegawai, $tahun);
        $this->load->view('admin/renkin/validasi_renkin', $data);
    }

}