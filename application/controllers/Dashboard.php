<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends CI_Controller
{
	public function __construct()
	{

		parent::__construct();
		$this->Auth_model->cekAuthLogin();
		$this->load->model('Laporan_model');
		$this->load->model('Admin_cuti_model', 'ACM');
		$this->load->helper('text');
	}

	function index()
	{


	///print_array($this->session->userdata());

	
		$id_puskesmas = $this->session->userdata('id_puskesmas');
		$usergroup    = $this->session->userdata('usergroup');
		$id_pegawai    = $this->session->userdata('id_pegawai');

		$periode_bulan = $this->session->userdata('periode_bulan');
		$periode_tahun = $this->session->userdata('periode_tahun');
		if ($periode_bulan == '') {
			$bulan = date('m');
			$tahun = date('Y');
		} else {
			$bulan = $periode_bulan;
			$tahun = $periode_tahun;
		}


		$periode = $tahun . '-' . $bulan;
		$periode = date('Y-m', strtotime($periode));

		$nip  = $this->session->userdata('nip');

		#$data['cutiPegawai'] = $this->Cuti_model->getDataCutiPegawaiKasatpel($id_pegawai);
		$data['pengajuanDL'] = $this->Presensi_model->pengajuanDinasLuarPegawai($id_pegawai);

		#print_array($pengajuanDL);

		if ($usergroup < 3) {

			$id_pegawai_login = $this->session->userdata('id_pegawai');
			$usergroup        = $this->session->userdata('usergroup');

			// Query untuk mengambil pengajuan cuti yang PENDING di level atasan yang sedang login
			$this->db->select('cuti.*, p.nama as nama_pemohon, p.id_jabatan as jabatan_pemohon, app.role_approval, app.id as id_approval');
			$this->db->from('ts_pengajuan_cuti cuti');
			$this->db->join('mst_pegawai p', 'p.id_pegawai = cuti.id_pegawai', 'left');
			$this->db->join('ts_pengajuan_cuti_approval app', 'app.id_pengajuan_cuti = cuti.id', 'left');

			// Syarat: Step pengajuan saat ini sama dengan level approval item tersebut & statusnya pending
			$this->db->where('app.level_approval = 3');
			$this->db->where('app.status', 'pending');

			// Hanya untuk id_pegawai_approval yang sesuai ATAU jika Superadmin
			if ($usergroup >= 2) {
				$this->db->where('app.id_pegawai_approval', $id_pegawai_login);
			}

			$data['pending_approval_list'] = $this->db->get()->result_array();
			//$data['nuPengajuanCuti']       = count($data['pending_approval_list']);
			//pj klaster / pj pustu

			$this->load->view('dashboard/kapuskel', $data);
		} else if ($usergroup == 3) {

			$id_pegawai_login = $this->session->userdata('id_pegawai');
			$usergroup        = $this->session->userdata('usergroup');

			// Query untuk mengambil pengajuan cuti yang PENDING di level atasan yang sedang login
			$this->db->select('cuti.*, p.nama as nama_pemohon, p.id_jabatan as jabatan_pemohon, app.role_approval, app.id as id_approval');
			$this->db->from('ts_pengajuan_cuti cuti');
			$this->db->join('mst_pegawai p', 'p.id_pegawai = cuti.id_pegawai', 'left');
			$this->db->join('ts_pengajuan_cuti_approval app', 'app.id_pengajuan_cuti = cuti.id', 'left');

			// Syarat: Step pengajuan saat ini sama dengan level approval item tersebut & statusnya pending
			$this->db->where('app.level_approval = cuti.current_step');
			$this->db->where('app.status', 'pending');

			// Hanya untuk id_pegawai_approval yang sesuai ATAU jika Superadmin
			if ($usergroup >= 2) {
				$this->db->where('app.id_pegawai_approval', $id_pegawai_login);
			}

			$data['pending_approval_list'] = $this->db->get()->result_array();
			//$data['nuPengajuanCuti']       = count($data['pending_approval_list']);
			//pj klaster / pj pustu
			$data['nuPengajuanCuti'] = $this->ACM->getNumCutiPending($id_pegawai);
			$this->load->view('dashboard/kapuskel', $data);
		} else {

			// Cek apakah ada pengajuan cuti yang menunjuk user ini sebagai pengganti & statusnya pending
			$this->db->select('cuti.*, p.nama as nama_pemohon, p.id_jabatan as jabatan_pemohon');
			$this->db->from('ts_pengajuan_cuti cuti');
			$this->db->join('mst_pegawai p', 'p.id_pegawai = cuti.id_pegawai', 'left');
			$this->db->join('ts_pengajuan_cuti_approval app', 'app.id_pengajuan_cuti = cuti.id', 'left');
			$this->db->where('cuti.id_pengganti', $id_pegawai);
			$this->db->where('app.level_approval', 1); // Level 1 = Pengganti
			$this->db->where('app.status', 'pending');

			$data['pending_pengganti'] = $this->db->get()->result_array();


			$this->load->view('dashboard/user', $data);
		}
		// if ($usergroup == 3 || $usergroup == 4) {
		// 	$data['nuPengajuanCuti'] = $this->ACM->getNumCutiPending($id_pegawai);
		// 	$this->load->view('dashboard/kapuskel', $data);
		// } else if ($usergroup == 1) { //Kapuskec
		// 	$data['cutiPegawai'] = $this->Cuti_model->getDataCutiPegawaiPending('PEND3');
		// 	$this->load->view('dashboard/kapuskec', $data);
		// } else if ($usergroup == 2) {
		// 	$data['nuPengajuanCuti'] = $this->ACM->getNumCutiPending($id_pegawai);
		// 	$data['cutiPegawaiAdmen'] = $this->Cuti_model->getDataCutiPegawaiPending('PEND1', $id_pegawai);
		// 	$data['pengajuanDL'] = $this->Presensi_model->pengajuanDinasLuarPegawai(0, 0);
		// 	$this->load->view('dashboard/kasubbag_tu', $data);
		// } else {
		// 	$data['totalAktifitas']   = $this->Kinerja_model->getAktifitasApprove($id_pegawai, $periode);
		// 	$data['dataRekap']        = $this->Presensi_model->getRekapAbsensiPegawai($id_pegawai, $periode);
		// 	$data['rekapTKD']         = $this->Laporan_model->getRekapTKDPegawai($nip, $periode);

		// 	$this->load->view('dashboard/user', $data);
		// }
	}


	function dashboard_user()
	{
		$id_pegawai    = $this->session->userdata('id_pegawai');
		$periode_bulan = $this->session->userdata('periode_bulan');
		$periode_tahun = $this->session->userdata('periode_tahun');
		if ($periode_bulan == '') {
			$bulan = date('m');
			$tahun = date('Y');
		} else {
			$bulan = $periode_bulan;
			$tahun = $periode_tahun;
		}


		$periode = $tahun . '-' . $bulan;
		$periode = date('Y-m', strtotime($periode));

		$nip  = $this->session->userdata('nip');
		$data['dataRekap']        = $this->Presensi_model->getRekapAbsensiPegawai($id_pegawai, $periode);
		$data['rekapTKD']         = $this->Laporan_model->getRekapTKDPegawai($nip, $periode);

		$this->load->view('dashboard/dashboard_user', $data);
	}
	function set_session_periode()
	{

		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');


		$this->session->set_userdata('periode_bulan', $bulan);
		$this->session->set_userdata('periode_tahun', $tahun);

		return true;

		#$this->session->set_userdata($this->input->post());
		#redirect('admin/presensi/index');
	}


	function pengajuan_dinas_luar_pegawai($status = '')
	{
		$id_pegawai    = $this->session->userdata('id_pegawai');
		$usergroup    = $this->session->userdata('usergroup');

		if ($usergroup == 3 || $usergroup == 4) {
			$data['pengajuanDL'] = $this->Presensi_model->pengajuanDinasLuarPegawai($id_pegawai);
			$this->load->view('admin/presensi/pengajuan_dinas_luar_pegawai', $data);
		} else if ($usergroup < 2) { //Kapuskec


			$data['pengajuanDL'] = $this->Presensi_model->pengajuanDinasLuarPegawai($id_pegawai, $status);

			//	print_array($data['pengajuanDL']);
			$this->load->view('admin/presensi/pengajuan_dinas_luar_pegawai', $data);
		} else if ($usergroup == 2) {
			$data['cutiPegawai'] = $this->Cuti_model->getDataCutiPegawaiPending('PEND2', 0);
			$data['pengajuanDL'] = $this->Presensi_model->pengajuanDinasLuarPegawai(0, $status);
			$this->load->view('admin/presensi/pengajuan_dinas_luar_pegawai', $data);
		}
	}

	function detail_pengajuan_dl($id,  $id_pegawai)
	{

		$data['pengajuan_dinas_luar'] = $this->Absensi_model->getDetailPengajuanDL($id);
		$data['detail_pegawai'] = $this->Pegawai_model->getDetailPegawai($id_pegawai);
		$this->load->view('admin/presensi/detail_dinas_luar', $data);
	}

	function setujuiIzinSakit($id_izin, $status_acc)
	{

		$qry = $this->db->get_where('pengajuan_izin_sakit', array('id' => $id_izin));
		$izinSakit = $qry->result();

		$tanggal 	 = $izinSakit[0]->tanggal;
		$jenis_absen = $izinSakit[0]->jenis_absen;
		$id_pegawai  = $izinSakit[0]->id_pegawai;
		$ket         = $izinSakit[0]->keterangan;


		if ($jenis_absen == 'IZIN') {
			$jenis_absen = 'IZIN';
		} else {
			$jenis_absen = 'SAKIT DGN SURAT';
		}


		$nip = $this->Pegawai_model->getNipPegawaiByID($id_pegawai);
		$pin = substr($nip, -4);

		if ($status_acc == 1) {
			//pengajuan di ACC 
			$this->Presensi_model->insertAbsensiIzinSakit($pin, $tanggal, $jenis_absen, $ket);
			$this->db->where('id', $id_izin);
			$this->db->set('status', 1);
			$this->db->update('pengajuan_izin_sakit');
			//echo 'Pengajuan izin/sakit telah disetujui';
		} else {
			$this->db->where('id', $id_izin);
			$this->db->set('status', 0);
			$this->db->update('pengajuan_izin_sakit');
			//echo 'Pengajuan izin/sakit  tidak disetujui';
		}

		redirect('dashboard/list_pengajuan_izin');
	}


	function approval_dinas_luar($id,  $id_pegawai)
	{


		$status = $this->input->post('status');

		$qry = $this->db->get_where('pengajuan_dinas_luar', array('id' => $id));
		$dinasLuar = $qry->result();

		$jns_dl     = $dinasLuar[0]->jns_dl;
		$keterangan = $dinasLuar[0]->keterangan;
		$tanggal    = $dinasLuar[0]->tanggal;

		$this->db->select('nip, id_mesin');
		$qry = $this->db->get_where('mst_pegawai', array('id_pegawai' => $id_pegawai));
		$pegawai = $qry->row();


		$pin = $pegawai->id_mesin;

		$this->Presensi_model->insertAbsensiDL($pin, $tanggal, $jns_dl, $keterangan);

		$this->db->where('id', $id);
		$this->db->set('status', $status);
		$this->db->update('pengajuan_dinas_luar');
		if ($status == 1) {
			$this->session->set_flashdata('message', 'Pengajuan Dinas Luar telah disetujui');
		} else {
			$this->session->set_flashdata('message', 'Pengajuan Dinas Luar telah ditolak');
		}


		redirect('dashboard/pengajuan_dinas_luar_pegawai/0');
		#redirect('admin/presensi/index');
	}


	function setujui_pengajuan_dl($id,  $id_pegawai)
	{


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
		redirect('dashboard/pengajuan_dinas_luar_pegawai/0');
		#redirect('admin/presensi/index');
	}


	function change_theme()
	{
		$theme = $this->input->post('theme');

		$this->session->set_userdata('theme', $theme);
		return true;
	}

	function tarikDataAbsensiMesin()
	{

		$data['mesin_absensi'] = $this->Master_model->getlistMesin();
		$this->load->view('dashboard/tarik_data_absensi', $data);
	}

	function list_user($id_puskesmas, $serial_number)
	{
		$this->db->select('*');
		$qry = $this->db->get_where('mst_pegawai', array('id_puskesmas' => $id_puskesmas, 'tahun_anggaran' => '2024', 'jns_pegawai' => 'non_pns'));
		$row = $qry->result();



		$data['pegawai'] = $row;
		$data['mesin_absensi'] = $this->Master_model->getDetMesinAbsensi($serial_number);
		$this->load->view('dashboard/list_user', $data);
	}

	function ajaxTarikDataAbsensi()
	{

		$serial_number = $this->input->post('serial_number');
		$detail_mesin = $this->Presensi_model->detailMesin($serial_number);
		$ip_address   = $detail_mesin[0]->ip_address;

		$dataPresensi = $this->Sinkron_model->getDataAbsenMesin($ip_address, $pin = '');
		#print_array($dataPresensi);

		$last_update   = $detail_mesin[0]->last_update;

		for ($i = 0; $i < count($dataPresensi); $i++) {

			$DateTime = $dataPresensi[$i]['DateTime'];
			$pin      = $dataPresensi[$i]['pin'];
			$Status   = $dataPresensi[$i]['Status'];

			//$periode_db = date('Y-m', strtotime($DateTime));

			#echo 'Periode DB '.$periode_db;

			#print_array($dataPresensi);

			if ($DateTime >= $last_update) {
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


	function list_pengajuan_izin()
	{
		$jns_absensi = $this->session->set_userdata('jenis_absensi');
		$status = $this->session->set_userdata('status');
		$data['izin_sakit'] = $this->Absensi_model->getDataPengjuanIzinSakit($jns_absensi, $status);
		$this->load->view('dashboard/list_pengajuan_izin', $data);
	}

	function filter_jns_absensi()
	{
		$jns_absensi = $this->input->post('jenis_absensi');
		$status = $this->input->post('status');

		$this->session->set_userdata($this->input->post());
		$izin_sakit = $this->Absensi_model->getDataPengjuanIzinSakit($jns_absensi, $status);

		for ($i = 0; $i < count($izin_sakit); $i++) {
			$id = $izin_sakit[$i]->id;
			$id_pegawai = $izin_sakit[$i]->id_pegawai;
			$tanggal = $izin_sakit[$i]->tanggal;
			$jenis_absen = $izin_sakit[$i]->jenis_absen;
			$keterangan = $izin_sakit[$i]->keterangan;
			$nama = $this->Pegawai_model->getNamaPegawaiByID($id_pegawai);
			$status = $izin_sakit[$i]->status;
			$file_image = $izin_sakit[$i]->file_image;
			if ($status == 0) {
				$status_flag = '<span class="badge bg-warning-subtle text-warning">Belum diperiksa</span>';
			} else {
				$status_flag = '<span class="badge bg-success-subtle text-success">Sudah diperiksa</span>';
			}

			echo '
			 <tr>
			  <td>' . ($i + 1) . '</td>

			  <td>' . $jenis_absen . '</td>
			  <td> <a href="' . base_url() . 'uploads/surat_izin/' . $file_image . '" target="_blank">' . $nama . '</a></td>
			  <td>' . format_view($tanggal) . '</td>
			  <td>' . $keterangan . '</td>
			  <td>' . $status_flag . '</td>

			  <td> <a href="' . base_url() . 'dashboard/setujuiIzinSakit/' . $id . '/1" class="btn btn-sm btn-success" onClick="return confirm(\'Apakah anda ingin menyetujui pengajuan izin/sakit pegawai ini?\');"> Setujui</a>
			  <a href="' . base_url() . 'dashboard/setujuiIzinSakit/' . $id . '/2" class="btn btn-sm btn-danger"  onClick="return confirm(\'Apakah anda ingin menyetujui pengajuan izin/sakit pegawai ini?\');"> Tolak</a>
			  </td>
			 </tr>
			';
			# code...
		}
	}
}
