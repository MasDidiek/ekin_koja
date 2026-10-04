	<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends CI_Controller
{
	public function __construct()
	{

		parent::__construct();
		$this->Auth_model->cekAuthLogin();
		$this->Auth_model->createSessionPeriode();
		$this->load->model('Laporan_model');
		$this->load->helper('text');
	}

	function index()
	{



		$id_puskesmas = $this->session->userdata('id_puskesmas');
		$usergroup    = $this->session->userdata('usergroup');
		$id_pegawai    = $this->session->userdata('id_pegawai');

		$periode_bulan = $this->session->userdata('periode_bulan');
		$periode_tahun = $this->session->userdata('periode_tahun');
		if($periode_bulan=='') {
		  $bulan = date('m')-1;
		  $tahun = date('Y');

		}else{
		  $bulan = $periode_bulan;
		  $tahun = $periode_tahun;
		}


		$periode = $tahun.'-'.$bulan;
		$periode = date('Y-m', strtotime($periode));

		$nip  = $this->session->userdata('nip');

		#$data['cutiPegawai'] = $this->Cuti_model->getDataCutiPegawaiKasatpel($id_pegawai);
		$data['pengajuanDL'] = $this->Presensi_model->pengajuanDinasLuarPegawai($id_pegawai);

					#print_array($pengajuanDL);
		if($usergroup==3 || $usergroup==4 ){
			$data['cutiPegawai'] = $this->Cuti_model->getDataCutiPegawaiPending('PEND1', $id_pegawai);
			$this->load->view('dashboard/kapuskel', $data);
		}else if($usergroup==1){ //Kapuskec
			$data['cutiPegawai'] = $this->Cuti_model->getDataCutiPegawaiPending('PEND3');
			$this->load->view('dashboard/kapuskec', $data);
		}else if($usergroup==2){
			$data['cutiPegawai'] = $this->Cuti_model->getDataCutiPegawaiPending('PEND2', 0);
			$data['cutiPegawaiAdmen'] = $this->Cuti_model->getDataCutiPegawaiPending('PEND1', $id_pegawai);
			$data['pengajuanDL'] = $this->Presensi_model->pengajuanDinasLuarPegawai(0, 0);
			$this->load->view('dashboard/kasubbag_tu', $data);
		}else{
			$data['totalAktifitas']   = $this->Kinerja_model->getAktifitasApprove($id_pegawai, $periode);
			$data['dataRekap']        = $this->Presensi_model->getRekapAbsensiPegawai($id_pegawai, $periode);
			$data['rekapTKD']         = $this->Laporan_model->getRekapTKDPegawai($nip, $periode);
			
			redirect('dashboard/my_dashboard');

			//$this->load->view('dashboard/user', $data);
		}


    }

	function ktu_dashboard(){
		$periode_bulan = $this->session->userdata('periode_bulan'); 
		$periode_tahun = $this->session->userdata('periode_tahun'); 
		$id_pegawai    = $this->session->userdata('id_pegawai');
		$nip  		   = $this->session->userdata('nip');
		$usergroup     = $this->session->userdata('usergroup');

		$pin           = substr($nip, -4);


		if($periode_bulan=='') {
			$day = date('d');
			$tahun = date('Y');
			if($day > 10){
				$bulan = date('m');
				
			}else{
				$bulan = date('m')-1;
			}

			$this->session->set_userdata('periode_bulan', $bulan);
			$this->session->set_userdata('periode_tahun', $tahun);

			redirect('dashboard/my_dashboard');
		

		}else{
		  $bulan = $periode_bulan;
		  $tahun = $periode_tahun;
		}

		
		$periode = $tahun.'-'.$bulan;
		$periode = date('Y-m', strtotime($periode));;

			
		$sql = "SELECT a.*, b.nama, b.id_validator
		FROM ts_cuti a LEFT JOIN mst_pegawai b ON a.id_pegawai = b.id_pegawai 
		WHERE ( status = 'PEND1' OR status = 'PEND2' OR status = 'PEND3') ORDER BY tgl_dari DESC  LIMIT 300 OFFSET 0";
		$qry = $this->db->query($sql);
		$row = $qry->result();

		$data['list_cuti']        = $row;
		$data['pengajuanDL']        = $this->Presensi_model->getPengajuanDlPending();
		$data['pengajuanSakit']        = $this->Presensi_model->getDataIzinSakit(0);
        $data['penggantian_cuti'] = $this->Cuti_model->getPermohonanPengganti($id_pegawai);


		$this->load->view('dashboard/ktu_dashboard', $data);
	}

	function kapuskel_dashboard(){
		$periode_bulan = $this->session->userdata('periode_bulan'); 
		$periode_tahun = $this->session->userdata('periode_tahun'); 
	
		if($periode_bulan=='') {
			$day = date('d');
			$tahun = date('Y');
			if($day > 10){
				$bulan = date('m');
				
			}else{
				$bulan = date('m')-1;
			}

			$this->session->set_userdata('periode_bulan', $bulan);
			$this->session->set_userdata('periode_tahun', $tahun);

			redirect('dashboard/my_dashboard');
		

		}else{
		  $bulan = $periode_bulan;
		  $tahun = $periode_tahun;
		}

		$thn_anggaran = $tahun;

		$periode = $tahun.'-'.$bulan;
		$periode = date('Y-m', strtotime($periode));

		$tgl = $periode.'-01';

		$id_validator    = $this->session->userdata('id_pegawai');
		
		$data['pegawai'] = $this->Pegawai_model->getAllPegawaiByValidator($id_validator, $thn_anggaran);
		$data['cuti_pending'] = $this->Cuti_model->getDataCutiPegawai('PEND1', $id_validator);
		$data['dinas_luar'] = $this->Absensi_model->getPengajuanDLbyValidator($id_validator, $tgl);

		$this->load->view('dashboard/kapuskel_dashboard', $data);
	}



    function user_dashboard(){
        $id_pegawai    = $this->session->userdata('id_pegawai');
        $data['penggantian_cuti'] = $this->Cuti_model->getPermohonanPengganti($id_pegawai);

		$this->load->view('dashboard/user_dashboard', $data);
	}
	function my_dashboard(){
		//print_array($this->session->userdata);

	
		$periode_bulan = $this->session->userdata('periode_bulan'); 
		$periode_tahun = $this->session->userdata('periode_tahun'); 
		$id_pegawai    = $this->session->userdata('id_pegawai');
		$nip  		   = $this->session->userdata('nip');
		$usergroup     = $this->session->userdata('usergroup');

		$pin           = substr($nip, -4);


		
		if($periode_bulan=='' || $periode_tahun=='') {
			$day = date('d');
			$tahun = date('Y');
			if($day > 10){
				$bulan = date('m');
				
			}else{
				
				$bulan = date('m');

				if($bulan==1){
					$bulan = 12;
					$tahun = date('Y')-1;
				}else{
					$bulan = $bulan-1;
					$tahun = date('Y');
				}

			}

			$this->session->set_userdata('periode_bulan', $bulan);
			$this->session->set_userdata('periode_tahun', $tahun);

			//redirect('dashboard/my_dashboard');
		

		}else{
		  $bulan = $periode_bulan;
		  $tahun = $periode_tahun;
		}

		
		$periode = $tahun.'-'.$bulan;
		$periode = date('Y-m', strtotime($periode));;

		//echo $periode;

		
		if($usergroup==3 || $usergroup==4 ){
			redirect('dashboard/kapuskel_dashboard');
		}

        $data['penggantian_cuti'] = $this->Cuti_model->getPermohonanPengganti($id_pegawai);
		$data['rekapAbsensi'] = $this->Presensi_model->getRekapAbsensiPegawai($id_pegawai, $periode);
		$data['getLastAbsensi'] = $this->Presensi_model->getLastAbsensi($pin);
		$data['rekap_capaian_kinerja']  = $this->Laporan_model->getRekapTKDPegawaipertahun($nip, $tahun);
		$data['pengajuan_dinas_luar'] = $this->Absensi_model->getListPengajuanDL($id_pegawai, $periode);
		$data['dataCuti'] = $this->Cuti_model->getCutiPegawai($id_pegawai, $periode);
		$data['dataIzinSakit'] = $this->Presensi_model->getDataIzinSakitPegawai($id_pegawai);
		$data['rekapTKD']  = $this->Laporan_model->getRekapTKDPegawai($nip, $periode);
		$data['totalAktifitas'] =  $this->Kinerja_model->getAktifitasApprove($id_pegawai, $periode);

		$data['poinPerilaku']     =  $this->Kinerja_model->getPoinPerilaku($id_pegawai, $bulan, $tahun);
		$data['master_cuti'] = $this->Master_model->getlistCuti();

		$pegawai = $this->Pegawai_model->getDataEditPegawai($id_pegawai);
        $id_jabatan = $pegawai[0]->id_jabatan;
		$data['listPegawaiPengganti']   = $this->Cuti_model->getListPegawaiPenggantiCuti( $id_pegawai, $id_jabatan) ;

		$this->load->view('dashboard/user_dashboard', $data);
	}


	function set_session_periode($prev_next){

		// $bulan = $this->input->post('bulan');
		// $tahun = $this->input->post('tahun');

		  
        $periode_bulan = $this->session->userdata('periode_bulan'); 
        $periode_tahun = $this->session->userdata('periode_tahun'); 
        
        if($periode_bulan==''){
            $periode_bulan = date('m');
           $periode_tahun = date('Y');
        }
        
    
		if($prev_next=='next'){
			$next_month = $periode_bulan+1;
			if($next_month==13){
				$bulan = 1;
				$tahun = $periode_tahun+1;
			}else{
				$bulan = $next_month;
				$tahun = $periode_tahun;
			}
			
			
		}else{
			$prev_month = $periode_bulan-1;
			

			if($prev_month == 0){
				$bulan = 12;
				$tahun = $periode_tahun-1;
			}else{
				$bulan = $prev_month;
				$tahun = $periode_tahun;
			}
		}

		$this->session->set_userdata('periode_bulan', $bulan);
		$this->session->set_userdata('periode_tahun', $tahun);

		redirect('dashboard/index');

	

		#$this->session->set_userdata($this->input->post());
		#redirect('admin/presensi/index');
	}


	function pengajuan_dinas_luar($status=''){
        $id_pegawai    = $this->session->userdata('id_pegawai');
        $usergroup    = $this->session->userdata('usergroup');

        // if($usergroup==3 || $usergroup==4 ){
        //     $data['pengajuanDL'] = $this->Presensi_model->pengajuanDinasLuarPegawai($id_pegawai);
		// 	$this->load->view('admin/presensi/pengajuan_dinas_luar_pegawai', $data);
		// }else if($usergroup==1){ //Kapuskec
        //     $data['pengajuanDL'] = $this->Presensi_model->pengajuanDinasLuarPegawai($id_pegawai);
		// 	$this->load->view('admin/presensi/pengajuan_dinas_luar_pegawai', $data);
		// }else if($usergroup==2){
		// 	$data['cutiPegawai'] = $this->Cuti_model->getDataCutiPegawaiPending('PEND2', 0);
		// 	$data['pengajuanDL'] = $this->Presensi_model->pengajuanDinasLuarPegawai(0, $status);
		// 	$this->load->view('admin/presensi/pengajuan_dinas_luar_pegawai', $data);
		// }

		$data['pengajuanDL']        = $this->Presensi_model->getPengajuanDlPending();
		$this->load->view('admin/presensi/pengajuan_dinas_luar_pegawai', $data);
    }

	function detail_pengajuan_dl($id,  $id_pegawai){

        $data['pengajuan_dinas_luar'] = $this->Absensi_model->getDetailPengajuanDL($id);
		$data['detail_pegawai'] = $this->Pegawai_model->getDetailPegawai($id_pegawai);
        $this->load->view('admin/presensi/detail_dinas_luar', $data);
	}


	function setujui_pengajuan_dl($id,  $id_pegawai){


		$qry = $this->db->get_where('pengajuan_dinas_luar', array('id' => $id));
		$dinasLuar = $qry->result();

		$jns_dl     = $dinasLuar[0]->jns_dl;
		$keterangan = $dinasLuar[0]->keterangan;
		$tanggal    = $dinasLuar[0]->tanggal;

		$nip = $this->Pegawai_model->getNipPegawaiByID($id_pegawai);
		$pin = substr($nip, -4);



		$this->Presensi_model->insertAbsensiDL($pin, $tanggal, $jns_dl, $keterangan);

		$this->db->where('id', $id);
		$this->db->set('status', 1);
		$this->db->update('pengajuan_dinas_luar');

		
		$this->session->set_flashdata('message', 'Pengajuan cuti telah disetujui');
		redirect('dashboard/pengajuan_dinas_luar');
		#redirect('admin/presensi/index');
	}

	
	function delete_pengajuan_dl($id){

		$this->db->where('id', $id);
		$this->db->delete('pengajuan_dinas_luar');
		redirect('dashboard/pengajuan_dinas_luar');
		
	}


	
    function ajax_detail_pengajuan_dl()
    {
		$id = $this->input->post('id');

        $data['pengajuan_dinas_luar'] = $this->Absensi_model->getDetailPengajuanDL($id);
        $this->load->view('dashboard/detail_dinas_luar', $data);
    }

	

	function change_theme(){
		$theme = $this->input->post('theme');

		$this->session->set_userdata('theme', $theme);
		return true;
	}

	function tarikDataAbsensiMesin(){

		$data['mesin_absensi'] = $this->Master_model->getlistMesin();
		$this->load->view('dashboard/tarik_data_absensi', $data);
	}

	function list_user($id_puskesmas, $serial_number){
		$this->db->select('*');
		$qry = $this->db->get_where('mst_pegawai', array('id_puskesmas'=> $id_puskesmas,'tahun_anggaran'=> '2024','jns_pegawai'=> 'non_pns'));
		$row = $qry->result();



		$data['pegawai'] = $row;
		$data['mesin_absensi'] = $this->Master_model->getDetMesinAbsensi($serial_number);
		$this->load->view('dashboard/list_user', $data);
	}

	function change_date($tgl) {

		$this->session->set_userdata('tgl_hari_ini', $tgl);
		redirect('dashboard/user_dashboard');

	}

	function sinkron_absensi() {
		

		$id_pegawai    = $this->session->userdata('id_pegawai');
		$id_puskesmas  = $this->session->userdata('id_puskesmas');
		$nip  		   = $this->session->userdata('nip');

		$tgl           = $this->input->post('tgl');

		
		$pin 		   = substr($nip, -4);
		//$ip_address    = '10.20.170.102';
		$ip_address    = $this->Pegawai_model->getIpAddresPegawai($id_pegawai);

		$dataPresensi  = $this->Sinkron_model->getDataAbsenMesin($ip_address, $pin);

		//print_array($dataPresensi);
		$absensiexits = false;
		$masuk = '00:00:00';
		$pulang = '00:00:00';
		for ($i=0; $i < count($dataPresensi) ; $i++) { 

			$DateTime  = $dataPresensi[$i]['DateTime'];
			$Status    = $dataPresensi[$i]['Status'];
			$dateAbsen = format_db($DateTime);
			$jamAbsen  = date('H:i:s',strtotime($DateTime));

			if($dateAbsen==$tgl){
				
				$absensiexits = true;
				
				$cekAbsen = $this->Presensi_model->cekAbsenExist($dateAbsen, $pin);
				if($cekAbsen==0){

					$id = $this->Presensi_model->insertShiftPegawai($pin, $tgl, 'REG');
	
					if($Status==0){
						$masuk = $jamAbsen;
						$pulang = '';
					
			
					}else{
						$masuk = '';
						$pulang =$jamAbsen;
					

					}

					$newArray = array(
						'masuk' => $masuk,
						'pulang' => $pulang,
						'telat' => 0,
						'p_awal' => 0,
						'keterangan' => ''
					);
					$this->db->insert('tbl_absensi', $newArray);
	
				}else{

					if($Status==0){
						$masuk = $jamAbsen;
					
						$this->db->where('id', $cekAbsen);
						$this->db->set('masuk', $masuk);
						$this->db->update('tbl_absensi');
					}else{
						
						$pulang =$jamAbsen;
						$this->db->where('id', $cekAbsen);
						$this->db->set('pulang', $pulang);
						$this->db->update('tbl_absensi');

					}//close if status

				}//close if cekAbsen

			} //close if $dateAbsen==$tgl

		}// close loop

	
		echo $masuk.'/'.$pulang;


	}

	function ajaxTarikDataAbsensi(){

		$serial_number = $this->input->post('serial_number');
		$detail_mesin = $this->Presensi_model->detailMesin($serial_number);
        $ip_address   = $detail_mesin[0]->ip_address;

		$dataPresensi = $this->Sinkron_model->getDataAbsenMesin($ip_address, $pin='');
		#print_array($dataPresensi);

		$last_update   = $detail_mesin[0]->last_update;

		for ($i=0; $i < count($dataPresensi) ; $i++) {

			$DateTime = $dataPresensi[$i]['DateTime'];
			$pin      = $dataPresensi[$i]['pin'];
			$Status   = $dataPresensi[$i]['Status'];

			//$periode_db = date('Y-m', strtotime($DateTime));

			#echo 'Periode DB '.$periode_db;

			#print_array($dataPresensi);

			if($DateTime >= $last_update){
				$this->Presensi_model->insertAbsensi($DateTime, $pin, $Status);
			}


		}


		// echo $DateTime;

		// echo $serial_number.' -------'.$DateTime;
		$this->db->where('serial_number', $serial_number);
		$this->db->set('last_update', $DateTime);
		$this->db->update('tbl_mesin_absensi');

		echo '<h4>
		        <span class="text-success"><i class="fas fa-check-circle"></i></span> Data absensi berhasil ditarik
				</h4>';
		//redirect('dashboard/list_user/'.$serial_number);

	}


	function list_pengajuan_izin(){
		$jns_absensi = $this->session->set_userdata('jenis_absensi');
		$status = $this->session->set_userdata('status');
		$data['izin_sakit'] = $this->Absensi_model->getDataPengjuanIzinSakit($jns_absensi, $status);
		$this->load->view('dashboard/list_pengajuan_izin', $data);
	}

	function filter_jns_absensi(){
		$jns_absensi = $this->input->post('jenis_absensi');
		$status = $this->input->post('status');

		$this->session->set_userdata($this->input->post());
		$izin_sakit = $this->Absensi_model->getDataPengjuanIzinSakit($jns_absensi, $status);

		for ($i=0; $i < count($izin_sakit); $i++) {
			$id = $izin_sakit[$i]->id;
			$id_pegawai = $izin_sakit[$i]->id_pegawai;
			$tanggal = $izin_sakit[$i]->tanggal;
			$jenis_absen = $izin_sakit[$i]->jenis_absen;
			$keterangan = $izin_sakit[$i]->keterangan;
			$nama = $this->Pegawai_model->getNamaPegawaiByID($id_pegawai);
			$status = $izin_sakit[$i]->status;
			$file_image = $izin_sakit[$i]->file_image;
			if($status==0){
			  $status_flag = '<span class="badge bg-warning-subtle text-warning">Belum diperiksa</span>';
			}else{
			  $status_flag = '<span class="badge bg-success-subtle text-success">Sudah diperiksa</span>';
			}

			echo '
			 <tr>
			  <td>'.($i+1).'</td>

			  <td>'.$jenis_absen.'</td>
			  <td> <a href="'.base_url().'uploads/surat_izin/'.$file_image.'" target="_blank">'.$nama.'</a></td>
			  <td>'.format_view($tanggal).'</td>
			  <td>'.$keterangan.'</td>
			  <td>'.$status_flag .'</td>

			  <td> <a href="'.base_url().'uploads/dashboard/change_status/'.$id.'"> Acc</a></td>
			 </tr>
			';
			# code...
		}
	}
}
