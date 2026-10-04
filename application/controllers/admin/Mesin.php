<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mesin extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        // Load model 'My_model'
		$this->load->model('Sinkron_model');
        $this->load->model('Master_model');
		$this->load->model('Admin_cuti_model', 'acm');
    }

	public function index()
	{

		$data['mesin'] = $this->Master_model->getListMesin();
		$this->load->view('mesin/index', $data);
	}

	function  refresh_mesin($ip_address){
		$cekStatusOnlineMesin = $this->Sinkron_model->cekKoneksi($ip_address);

		if($cekStatusOnlineMesin){
			$statusMesin = 1;
		}else{
			$statusMesin = 0;
		}

		$this->db->where('ip_address', $ip_address);
		$this->db->set('status', $statusMesin);
		$this->db->update('tbl_mesin_absensi');


		redirect('admin/mesin/index');
	}

	public function insert_user($sn, $ip_address)
    {
		$pin = $this->input->post('pin');
		$nama = $this->input->post('nama');
		
		$this->Sinkron_model->insertUser($ip_address, $pin, $nama);
		
		$this->session->set_flashdata('message', 'Data  user Berhasil ditambahkan');

		redirect('admin/setting/list_user/'.$sn.'/'.$ip_address);

    }

	public function list_user($serial_number, $ip_address)
	{
		$data['detail_mesin'] = $this->Master_model->detailMesin($serial_number);
		$data['list_user']    = $this->Sinkron_model->getListUserMesin($ip_address);
		$this->load->view('mesin/list_user', $data);


	}

	function clear_data_absensi($pin, $url_nama, $ip_address) {
		
		$status_delete = $this->Sinkron_model->deleteDataAbsensi($pin, $ip_address);



		echo $status_delete;

	}

	function detail_user($pin, $url_nama,  $ip_address) {
		
		$data['sidik_jari']    = $this->Sinkron_model->getSidikJari($ip_address, $pin);
		$data['detail_user'] = $this->Sinkron_model->getUserinfo($pin, $ip_address);
		$data['absensi']    = $this->Sinkron_model->getDataAbsenMesin($ip_address, $pin);
		$this->load->view('mesin/detail_user', $data);
	}

	function edit_user(){
		$pin        = $this->input->post('pin');
		$nama = $this->input->post('nama');

		echo '   <div class="mb-3">
                    <label for="userId" class="inline-block mb-2 text-base font-medium">PIN / ID</label>
                    <input type="text" name="pin" id="pin" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"  value="'.$pin.'" required="">
                </div>
            
                <div class="mb-3">
                    <label for="userNameInput" class="inline-block mb-2 text-base font-medium">Nama</label>
                    <input type="text"  name="nama" id="userNameInput" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" value="'.$nama.'" required="">
                </div>';
	}



	function update_data_user($ip_address, $sn)  {
		

		$pin = $this->input->post('pin');
		$nama = $this->input->post('nama');
		$this->Sinkron_model->insertUser($ip_address, $pin, $nama);

		redirect('admin/mesin/list_user/'.$sn.'/'.$ip_address);
	}

	// function detail_user($pin, $ip_address)  {
	// 	$data['absensi']    = $this->Sinkron_model->getDataAbsenMesin($ip_address, $pin);
	// 	$data['detail_user'] = $this->Sinkron_model->getUserinfo($pin,$ip_address);
	// 	$data['sidik_jari'] = $this->Sinkron_model->getSidikJari($ip_address, $pin);
	// 	$this->load->view('mesin/detail_user', $data);
	// }

	function lihat_absensi($pin, $ip_address)
	{
		$data['absensi']     = $this->Sinkron_model->getDataAbsenMesin($ip_address, $pin);
		$data['detail_user'] = $this->Master_model->detailUser($pin);
		$this->load->view('mesin/lihat_absensi', $data);
	}


	function insertSidikJari($nama='')  {

		$ip_address = $this->input->post('ip_address');
		$pin = $this->input->post('pin'); 
		$template = $this->input->post('template'); 
		$fn = $this->input->post('FingerID'); 

		

		$this->Sinkron_model->insertSidikJari($ip_address, $pin, $template, $fn);
		$this->session->set_flashdata('message', 'Data sidik jari  berhasil ditambahkan');
		redirect('admin/mesin/detail_user/'.$pin.'/'.$nama.'/'.$ip_address);

	}


	function save_user($ip_address, $sn)
	{
		$list_user  = $this->Sinkron_model->getListUserMesin($ip_address);

	//print_array($list_user);

		for ($i=0; $i < count($list_user) ; $i++) {
			$pin = $list_user[$i]['pin'];
			$nama = $list_user[$i]['nama'];

				 $newData = array(
					 'pin' => $pin,
					 'nama'=> $nama,
					 'sn_mesin'=> $sn
				 );


				if($nama !=''){
					//print_array($newData);

					$sry = $this->db->get_where('mst_user', array('pin' => $pin));
					$row = $sry->row();
					if(empty($row)){
						$this->db->insert('mst_user', $newData);
					}else{
						$this->db->where('pin', $pin);
						$this->db->update('mst_user', $newData);
					}

				}



//			$this->db->where('pin', $pin);
//			$this->db->set('sn_mesin', $sn);
//			$this->db->update('mst_user');
			

		}

		echo 'selesai';
	}

	
	function tarik_data($ip_address)
	{
		//$dataAbsensi = $this->Sinkron_model->getDataPresensi($ip_address, '2256');
		//print_array($dataAbsensi);

		$data['list_user']    = $this->Sinkron_model->getListUserMesin($ip_address);
		$this->load->view('pilih_user', $data);
	}

	function delete_user($pin,  $sn, $ip_address )
	{

		$status = $this->Sinkron_model->deleteUser($pin, $ip_address);
		$this->session->set_flashdata('message', 'Data user berhasil dihapus');
		
		redirect('admin/setting/list_user/'.$sn);
		//redirect('admin/mesin/list_user/'.$sn.'/'.$ip_address);
	}

	
	function insert_mesin()  {
		
		$data = array(
			'nama_mesin'  => $this->input->post('nama'),
			'ip_address' 		=> $this->input->post('ip_addr'),
			'serial_number'=> $this->input->post('sn'),
		);
		$this->db->insert('tbl_mesin_absensi', $data);
		redirect('admin/mesin/index');
	}

	

	function update_data_mesin()  {
		$sn =  $this->input->post('sn');
		$data = array(
			'nama_mesin'  => $this->input->post('nama'),
			'ip_address' 		=> $this->input->post('ip_addr'),
		);


		// print_array($data);
		// exit;
	
		$this->db->where('serial_number', $sn);
		$this->db->update('tbl_mesin_absensi', $data);
		redirect('admin/mesin/index');
	}

	function process_tarik_data($ip_address, $pin)
	{

//$pin_pegawai = $this->input->post('pin');

		$new_array = array();
		$num = 0;

		$buffer = $this->Sinkron_model->getDataPresensi($ip_address, $pin);
		for($a=0; $a < count($buffer);$a++){
			$data=$this->Sinkron_model->Parse_Data($buffer[$a],"<Row>","</Row>");
			$PIN_absen=$this->Sinkron_model->Parse_Data($data,"<PIN>","</PIN>");
			$DateTime = $this->Sinkron_model->Parse_Data($data,"<DateTime>","</DateTime>");
			$Verified = $this->Sinkron_model->Parse_Data($data,"<Verified>","</Verified>");
			$Status   = $this->Sinkron_model->Parse_Data($data,"<Status>","</Status>");

			$bulan = date('m', strtotime($DateTime));
			if($bulan == 8){
				if($PIN_absen != ''){
					$new_array[] = array(
						'pin' => $PIN_absen,
						'DateTime' => $DateTime,
						'Status'  => $Status,
						'Verified'  => $Verified
					);


					$num = $num+1;
					$this->Sinkron_model->insertDataAbsensiImport($DateTime, $pin, $Status, $method_absen='fingerprint');
				}
			}

		}

		//echo $num.' Rows inserted';
		$absensi = $this->Master_model->getDataAbsensiOffline($pin);

		$json_data = json_encode($absensi);

		// Contoh penggunaan fungsi
		$url = 'https://ekin.puskesmascilincing.id/api/receiveJsonData';
		$data = array(
			'data_post' => $json_data,
			'pin' => $pin
		);
		
		$response = $this->Sinkron_model->sendJsonData($url, $data);

		$tanggal = $absensi[0]->tanggal;
		$this->db->where('pin', $pin);
		$this->db->set('last_upload', $tanggal);
		$this->db->update('mst_user');

		$this->session->set_flashdata('message', 'Data absensi berhasil disinkron dan diupload');
		$this->session->set_flashdata('status', 'success');


		redirect('admin/mesin/tarik_data/'.$ip_address);
		//print_array($pin_pegawai);

	}
}
