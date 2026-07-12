<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_driver extends CI_Controller {

	public function index()
	{
		$tgl_daftar = $this->session->userdata('tgl_daftar');
		
	
		if($tgl_daftar==''){
			//$tgl = date('Y-m-d');
		//	$this->session->set_userdata('tgl_daftar', $tgl);
			$data['driver'] = $this->Driver_model->getAllDriver();
		}else{
			$tgl = $tgl_daftar;
				$data['driver'] = $this->Driver_model->get_list_driver($tgl);
		}
		
	
		
		$this->load->view('admin/driver/main', $data);
	}

	function add_driver(){
		$this->load->view('admin/driver/add_driver');
	}

	function insert_driver(){
		$this->load->library('form_validation');
        $this->form_validation->set_rules('no_ktp', 'No KTP', array('required', 'min_length[16]', 'numeric'));
        $this->form_validation->set_rules('nama_lengkap', 'Nama', 'required');
        $this->form_validation->set_rules('gender', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('no_hp', 'No Handphone', 'required');
        $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('nama_po', 'Nama PO', 'required');
		$this->form_validation->set_rules('pendidikan', 'Pendidikan', 'required');
		$this->form_validation->set_rules('status_pernikahan', 'Status Pernikahan', 'required');

		
        if ($this->form_validation->run() == FALSE) {
			$this->load->view('admin/driver/add_driver');
        } else {
			$tgl_lahir = $this->input->post('tgl_lahir');
			$d = str_replace("/", "-", $tgl_lahir);
			$tgl_lahir = format_db($d);

			$kode_reg = generateRegistrationCode(6);

			$data = array(
				'tgl_daftar' => date('Y-m-d'),
				'kode_registrasi'=> $kode_reg,
				'no_ktp' => $this->input->post('no_ktp'),
				'nama' => $this->input->post('nama_lengkap'),
				'tgl_lahir' => $tgl_lahir,
				'jns_kel' => $this->input->post('gender'),
				'no_hp' => $this->input->post('no_hp'),
				'pekerjaan' => $this->input->post('pekerjaan'),
				'pendidikan' => $this->input->post('pendidikan'),
				'status_kawin' => $this->input->post('status_pernikahan'),
				'alamat' => $this->input->post('alamat'),
				'nama_po' => $this->input->post('nama_po'),
				'status_supir' => $this->input->post('status_supir'),
				'status_pemeriksaan' => 0, #belum diperiksa
				'rekomendasi' => 0,
				'tgl_periksa' => '0000-00-00',
				'id_petugas' => 0,
				'nama_terminal' => ''

			);

		 $this->db->insert('mst_driver', $data);
          #echo 'berhasil, data berhasil disimpan';


          redirect('admin/admin_driver/index');
        }
	}


	public function ubah_data_pengemudi($id_driver)
	{
		$data['data_detail'] =  $this->Driver_model->get_data_edit($id_driver);
		$this->load->view('admin/driver/ubah_data_pengemudi', $data);
	}

    public function update_driver($id)
	{
	    	$tgl_lahir = $this->input->post('tgl_lahir');
			$d = str_replace("/", "-", $tgl_lahir);
			$tgl_lahir = format_db($d);
		
			$data = array(
				'no_ktp' => $this->input->post('no_ktp'),
				'nama' => $this->input->post('nama_lengkap'),
				'tgl_lahir' => $tgl_lahir,
				'jns_kel' => $this->input->post('gender'),
				'no_hp' => $this->input->post('no_hp'),
				'pekerjaan' => $this->input->post('pekerjaan'),
				'pendidikan' => $this->input->post('pendidikan'),
				'status_kawin' => $this->input->post('status_pernikahan'),
				'alamat' => $this->input->post('alamat'),
				'nama_po' => $this->input->post('nama_po'),
				'status_supir' => $this->input->post('status_supir'),
			);

		 
		$this->db->where('id', $id);
		$this->db->update('mst_driver', $data);
		$this->session->set_flashdata('success', 'Data pengemudi berhasil diubah');
		redirect('admin/admin_driver/ubah_data_pengemudi/'.$id);
	}



	function create_session_date(){
		$tgl = $this->input->post('tgl');

		$tgl = format_db($tgl);
		$this->session->set_userdata('tgl_daftar', $tgl);
		return true;
	}

    public function delete($id)
	{
	
		$this->db->where('id', $id);
		$this->db->delete('mst_driver');
		$this->session->set_flashdata('success', 'Data user berhasil diubah');
		redirect('admin/admin_driver/index');
	}



	public function update($id)
	{
		$data = array(
			'nama' => $this->input->post('nama'),
			'puskesmas' => $this->input->post('puskesmas'),
			'no_hp' => $this->input->post('no_hp'),
			'username' => $this->input->post('username')

		);
		$this->db->where('id_user', $id);
		$this->db->update('mst_user', $data);
		$this->session->set_flashdata('success', 'Data user berhasil diubah');
		redirect('admin/admin_user/index');
	}

	public function detail($id_driver)
	{
	    
	    
		$data['data_detail'] =  $this->Driver_model->get_data_edit($id_driver);
		$data['history'] =  $this->Driver_model->getHistoryPemeriksaanPengemudi($id_driver);
		$this->load->view('admin/driver/detail', $data);
	}

	// function getHistoryPemeriksaanPengemudi($id_driver){

	// }

	public function periksa($id)
	{
		$data['data_detail'] =  $this->Driver_model->get_data_edit($id);
		$data['petugas'] = $this->Petugas_model->get_all();
		$this->load->view('admin/driver/periksa', $data);
	}

	public function detail_pemeriksaan()
	{
	     $id_pemeriksaan = $this->input->post('id');
		$data['detail_pemeriksaan'] =  $this->Driver_model->get_detail_pemeriksaan($id_pemeriksaan);
		$this->load->view('admin/driver/detail_pemeriksaan', $data);
	}

	public function insert_pemeriksaan($id_driver)
	{

		#print_array($this->input->post());
		$tgl = $this->input->post('tgl_periksa');
		$jam = $this->input->post('waktu_periksa');
		$nilai_gds = $this->input->post('gds');
		$gejala_penyerta = $this->input->post('gejala_penyerta');

		if($gejala_penyerta==1){
			$penyerta=1;
		}else{
			$penyerta=0;
		}


		$date_time = format_db($tgl).' '.$jam;

		$gds  = $this->input->post('gds');
		$gejala_penyerta = $this->input->post('gejala_penyerta');
		$narkoba = $this->input->post('narkoba');
		$tensi   = $this->input->post('tensi');
		
		if($gejala_penyerta==1){
			$gejala=1;
		}else{
			$gejala=0;
		}
		
		
		$expl = explode("/", $tensi);
		$sistol = $expl[0];
		$diastol = $expl[1];

		$hipertensi = getStatusHipertensi($sistol, $diastol);
		$statusGDS  = getStatusGDS($nilai_gds, $penyerta);
		$statusHT   = $hipertensi[0];// status dalam text
		$ht         = $hipertensi[1];// status dalam angka


		$statusLaik = getStatusLaik($ht, $gds, $gejala, $narkoba);

		$konseling_rokok = $this->input->post('konseling_rokok');
		$konseling_diet = $this->input->post('konseling_diet');
		$rujuk = $this->input->post('rujuk');

		if($konseling_rokok==''){
			$kons_berhnt_rokok = 0;
		}else{
			$kons_berhnt_rokok = 1;
		}

		if($konseling_diet==''){
			$kons_diet_sehat = 0;
		}else{
			$kons_diet_sehat = 1;
		}

		
		if($rujuk==''){
			$dirujuk = 0;
		}else{
			$dirujuk = 1;
			
		}


        $id_user =  $this->session->userdata('id_user');
        
   
         if($id_user ==''){
            redirect('admin/login/index');
        }
        
        
		$data = array(
			'date_time' => $date_time,
			'nama_terminal' => $this->input->post('terminal'),
			'id_driver' => $id_driver,
			'id_petugas' => $id_user,
			'nama_dokter' =>  $this->input->post('dokter'),
			'bb' => $this->input->post('bb'),
			'tb' => $this->input->post('tb'),
			'lp' => $this->input->post('lp'),
			'tensi_sistol' => $sistol,
			'tensi_diastol' => $diastol,
			'gds' => $this->input->post('gds'),
			'ada_gejala' => $gejala,
			'catatan' => $this->input->post('ket_gejala_penyerta'), //catatan gejala
			'kons_berhnt_rokok' => $kons_berhnt_rokok, //konsultasi berhenti merokok
			'kons_diet_sehat'=> $kons_diet_sehat,
			'rujuk' => $dirujuk,
			'status_laik' => $statusLaik,
			'status_ht' => $ht,
			'status_gds' => $statusGDS
		);

		$this->db->insert('ts_pemeriksaan', $data);

		$id_pemeriksaan = $this->Driver_model->getlastIDPemeriksaan();
		
		$data_ptm = array(
			'id_pemeriksaan' => $id_pemeriksaan,
			'id_driver' => $id_driver,
			'dm' => $this->input->post('dm'),
			'hipertensi' => $this->input->post('ht'),
			'jantung' => $this->input->post('jantung'),
			'stroke' => $this->input->post('stroke'),
			'asma' => $this->input->post('asma'),
			'kanker' => $this->input->post('kanker'),
			'kolesterol' => $this->input->post('kolesterol')
		);

		$this->db->insert('tbl_ptm', $data_ptm);


		$data_ptm_kel = array(
			'id_pemeriksaan' => $id_pemeriksaan,
			'id_driver' => $id_driver,
			'dm' => $this->input->post('dm_kel'),
			'hipertensi' => $this->input->post('ht_kel'),
			'jantung' => $this->input->post('jantung_kel'),
			'stroke' => $this->input->post('stroke_kel'),
			'asma' => $this->input->post('asma_kel'),
			'kanker' => $this->input->post('kanker_kel'),
			'kolesterol' => $this->input->post('kolesterol_kel')
		);

		$this->db->insert('tbl_ptm_keluarga', $data_ptm_kel);

		$data_faktor_resiko = array(
			'id_pemeriksaan' => $id_pemeriksaan,
			'id_driver' => $id_driver,
			'merokok' => $this->input->post('rokok'),
			'krng_aktf_fisik' => $this->input->post('aktf_fisik'),
			'krng_sayur_buah' => $this->input->post('sayur_buah'),
			'alkohol' => $this->input->post('alkohol'),
			'tes_keseimbangan' => $this->input->post('keseimbangan'),
			'tes_urine' => $this->input->post('narkoba'),
			'alkohol_respirasi' => $this->input->post('alkohol_respirasi')
		);

		$this->db->insert('tbl_faktor_resiko', $data_faktor_resiko);

		if($dirujuk==1){
			
			$this->Driver_model->insertRujukan($id_pemeriksaan);
		}
		
		
		$update = array(
		        'status_pemeriksaan' => 1,
		        'rekomendasi' => 1,
		        'tgl_periksa' => date('Y-m-d'),
		        'id_petugas' => $id_user
		    );
		    
		    $this->db->where('id',$id_driver);
		    $this->db->update('mst_driver', $update);
		

		redirect('admin/admin_driver/detail/'.$id_driver);
	}

	public function ubah_data_pemeriksaan($id_pemeriksaan)
	{
		   
		$data['dataPemeriksaan'] = $this->Driver_model->getDataEditPemeriksaan($id_pemeriksaan);
		$data['riwayatPTMKeluarga'] = $this->Driver_model->getDataPemeriksaan($id_pemeriksaan, 'tbl_ptm_keluarga');

		$data['riwayatPTMDiri'] = $this->Driver_model->getDataPemeriksaan($id_pemeriksaan, 'tbl_ptm');
		$data['faktorResiko']   = $this->Driver_model->getDataPemeriksaan($id_pemeriksaan, 'tbl_faktor_resiko');
	  
		
		$this->load->view('admin/driver/ubah_data_pemeriksaan', $data);
	}

	function save_edit_pemeriksaan($id_pemeriksaan)
	{
		#print_array($this->input->post());
		$tgl = $this->input->post('tgl_periksa');
		$jam = $this->input->post('waktu_periksa');
		$nilai_gds = $this->input->post('gds');
		$gejala_penyerta = $this->input->post('gejala_penyerta');

		if($gejala_penyerta==1){
			$penyerta=1;
		}else{
			$penyerta=0;
		}


		$date_time = format_db($tgl).' '.$jam;

		$gds  = $this->input->post('gds');
		$gejala_penyerta = $this->input->post('gejala_penyerta');
		$narkoba = $this->input->post('narkoba');
		$tensi   = $this->input->post('tensi');
		
		if($gejala_penyerta==1){
			$gejala=1;
		}else{
			$gejala=0;
		}
		
		
		$expl = explode("/", $tensi);
		$sistol = $expl[0];
		$diastol = $expl[1];

		$hipertensi = getStatusHipertensi($sistol, $diastol);
		$statusGDS  = getStatusGDS($nilai_gds, $penyerta);
		$statusHT   = $hipertensi[0];// status dalam text
		$ht         = $hipertensi[1];// status dalam angka


		$statusLaik = getStatusLaik($ht, $gds, $gejala, $narkoba);

		$konseling_rokok = $this->input->post('konseling_rokok');
		$konseling_diet = $this->input->post('konseling_diet');
		$rujuk = $this->input->post('rujuk');

		if($konseling_rokok==''){
			$kons_berhnt_rokok = 0;
		}else{
			$kons_berhnt_rokok = 1;
		}

		if($konseling_diet==''){
			$kons_diet_sehat = 0;
		}else{
			$kons_diet_sehat = 1;
		}

		
		if($rujuk==''){
			$dirujuk = 0;
		}else{
			$dirujuk = 1;
			
		}


        $id_user =  $this->session->userdata('id_user');
        
   
         if($id_user ==''){
            redirect('admin/login/index');
        }
        
        
		$data = array(
			'nama_terminal' => $this->input->post('terminal'),
			'id_petugas' => $id_user,
			'bb' => $this->input->post('bb'),
			'tb' => $this->input->post('tb'),
			'lp' => $this->input->post('lp'),
			'tensi_sistol' => $sistol,
			'tensi_diastol' => $diastol,
			'gds' => $this->input->post('gds'),
			'ada_gejala' => $gejala,
			'catatan' => $this->input->post('ket_gejala_penyerta'), //catatan gejala
			'kons_berhnt_rokok' => $kons_berhnt_rokok, //konsultasi berhenti merokok
			'kons_diet_sehat'=> $kons_diet_sehat,
			'rujuk' => $dirujuk,
			'status_laik' => $statusLaik,
			'status_ht' => $ht,
			'status_gds' => $statusGDS,
			'updateAt' => $date_time,
		);

		$this->db->where('id', $id_pemeriksaan);
		$this->db->update('ts_pemeriksaan', $data);

		$id_pemeriksaan = $this->Driver_model->getlastIDPemeriksaan();
		
		$data_ptm = array(
			'dm' => $this->input->post('dm'),
			'hipertensi' => $this->input->post('ht'),
			'jantung' => $this->input->post('jantung'),
			'stroke' => $this->input->post('stroke'),
			'asma' => $this->input->post('asma'),
			'kanker' => $this->input->post('kanker'),
			'kolesterol' => $this->input->post('kolesterol')
		);

		$this->db->where('id_pemeriksaan', $id_pemeriksaan);
		$this->db->update('tbl_ptm', $data_ptm);


		$data_ptm_kel = array(
			'dm' => $this->input->post('dm_kel'),
			'hipertensi' => $this->input->post('ht_kel'),
			'jantung' => $this->input->post('jantung_kel'),
			'stroke' => $this->input->post('stroke_kel'),
			'asma' => $this->input->post('asma_kel'),
			'kanker' => $this->input->post('kanker_kel'),
			'kolesterol' => $this->input->post('kolesterol_kel')
		);

		$this->db->where('id_pemeriksaan', $id_pemeriksaan);
		$this->db->update('tbl_ptm_keluarga', $data_ptm_kel);

		$data_faktor_resiko = array(
			'merokok' => $this->input->post('rokok'),
			'krng_aktf_fisik' => $this->input->post('aktf_fisik'),
			'krng_sayur_buah' => $this->input->post('sayur_buah'),
			'alkohol' => $this->input->post('alkohol'),
			'tes_keseimbangan' => $this->input->post('keseimbangan'),
			'tes_urine' => $this->input->post('narkoba')
		);

		$this->db->where('id_pemeriksaan', $id_pemeriksaan);
		$this->db->update('tbl_faktor_resiko', $data_faktor_resiko);

		// if($dirujuk==1){
			
		// 	$this->Driver_model->insertRujukan($id_pemeriksaan);
		// }
		
		
		$this->session->set_flashdata('success', 'Berhasil update');
		redirect('admin/admin_driver/ubah_data_pemeriksaan/'.$id_pemeriksaan);

	}

	function submit_rujuk(){
		$id_driver = $this->input->post('id_driver');
		$umur = $this->input->post('umur');
		$yth = $this->input->post('yth');
		$catatan_kondisi_kesehatan = $this->input->post('catatan_kondisi_kesehatan');

		$new_session = array(
			'id_driver_rujuk' => $id_driver,
			'umur' => $umur,
			'yth' => $yth,
			'catatan' => $catatan_kondisi_kesehatan
		);
		$this->session->set_userdata($new_session);
		echo '

		<script>
		var tutup_formulir = document.getElementById("close_modal_rujuk");
		tutup_formulir.onclick = function() {
			  modal.style.display = "none";
		}
		
		</script>
		 <div class="alert-success">
		 	<strong>Formulir rujukan berhasil dikirim.</strong>
			<br>
			jangan lupa menyimpan hasil pemeriksaan!!
		 </div><br>

		<button type="button" id="close_modal_rujuk" class="button btn-info"> Tutup </button>
		';
	}

	function cetak_surat_keterangan_laik($id_pemeriksaan){

		$data['detail_pemeriksaan'] =  $this->Driver_model->get_detail_pemeriksaan($id_pemeriksaan);
		$this->load->view('admin/driver/cetak_surat_keterangan_laik', $data);
	}

	function cetak_rujuk($id_pemeriksaan){
		$data['detail_pemeriksaan'] =  $this->Driver_model->getDataRujukan($id_pemeriksaan);
		$this->load->view('admin/driver/cetak_rujukan', $data);
	
    }
 

}

