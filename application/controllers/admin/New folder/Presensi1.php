<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Presensi  extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();


		$this->load->model('Laporan_model');
		$this->load->model('Admin_cuti_model', 'acm');
		$this->load->helper('text');
		$this->Auth_model->cekAuthLogin();
	}


	public function index()
	{

		$id_user   = $this->session->userdata('id_user');
		$usergroup = $this->session->userdata('usergroup');
		$jabatan      = $this->session->userdata('jabatan');
		$id_validator = $this->session->userdata('id_pegawai');

		// Jika ada parameter GET dari form filter, simpan/update ke Session
		if ($this->input->get()) {
			$filter = [
				'periode'       => $this->input->get('periode'),
				'id_validator'  => $this->input->get('id_validator'),
				'jenis_pegawai' => $this->input->get('jenis_pegawai')
			];
			$this->session->set_userdata('filter_presensi', $filter);
		}
		// Jika tidak ada parameter GET, ambil dari Session yang tersimpan sebelumnya
		else if ($this->session->userdata('filter_presensi')) {
			$filter = $this->session->userdata('filter_presensi');
		}
		// Default jika session juga belum ada
		else {
			$filter = [
				'periode'       => date('Y-m'),
				'id_validator'  => $id_validator,
				'jenis_pegawai' => ''
			];
		}


		$data['puskesmas']        = $this->Presensi_model->getListPuskesmas();
		$data['data_shift_kerja'] = $this->Presensi_model->getShiftKerja();
		$data['pegawai']  = $this->Pegawai_model->getDataListpegawaiAbsen($filter);
		$data['validator'] = $this->Pegawai_model->getValidator();

		//   print_array($data['pegawai']);
		// exit;

		//redirect('admin/presensi/DataRekapAbsensi');
		$this->load->view('admin/presensi/main', $data);
	}


	function update_absensi_pegawai($id_pegawai, $pin)
	{
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
		$detailPegawai = $this->Pegawai_model->getDataEditPegawai($id_pegawai);

		// $id_mesin = $detailPegawai[0]->id_mesin;
		// if ($id_mesin != '') {
		// 	$pin = $id_mesin;
		// }



		$jam_kerja    = $detailPegawai[0]->jns_jam_kerja;
		$lastDate = date('t', strtotime($periode)) + 1;


		for ($t = 1; $t < $lastDate; $t++) {
			$tanggal = $periode . '-' . $t;
			$formatDate = date('Y-m-d', strtotime($tanggal));

			if ($jam_kerja == 'non_shift') {
				$id_pegawai = 0;
				$shift = $this->Presensi_model->getDatashiftKerja($id_pegawai, $formatDate, 'shift');
			} else {
				$shift = $this->Presensi_model->generate_shift_kerja($pin, $formatDate);
			}



			//echo $id_pegawai;
			if ($jam_kerja == 'non_shift') {
				$id_pegawai = 0;
			}

			$shift = $this->Presensi_model->getDatashiftKerja($id_pegawai, $formatDate, 'shift');
			if ($shift == '-') {
				$shift = $this->Presensi_model->generate_shift_kerja($pin, $formatDate);
			}



			$id = $this->Presensi_model->cekAbsenExist($formatDate, $pin);

			if ($id == 0) {

				$this->Presensi_model->insertShiftPegawai($pin, $formatDate, $shift);
			} else {
				$this->Presensi_model->updateShiftPegawai($pin, $formatDate, $shift, $id);
			}
		}



		$dataAbsensi  = $this->Presensi_model->getAbsenBulanan($pin, $periode);




		//print_array($dataAbsensi);
		//exit;
		for ($a = 0; $a < count($dataAbsensi); $a++) {


			$datetime       = $dataAbsensi[$a]->tanggal;
			$status_absen   = $dataAbsensi[$a]->status;
			$id_absen       = $dataAbsensi[$a]->id;

			$explode = explode(" ", $datetime);
			$tanggal = $explode[0];
			$jam     = $explode[1];

			if ($jam_kerja == 'non_shift') {
				$status_absen = cekStatusAbsen($jam);
			}



			if ($status_absen == 0) {

				$newArray = array(
					'tanggal' => $tanggal,
					'pin' => $pin,
					'masuk' => $jam,
					'telat' => 0,
					'keterangan' => ''
				);
			} else {
				$newArray = array(
					'tanggal' => $tanggal,
					'pin' => $pin,
					'pulang' => $jam,
					'p_awal' => 0,
					'keterangan' => ''
				);
			}


			print_array($newArray);

			$cekAbsenExist = $this->Presensi_model->cekAbsenExist($tanggal, $pin);
			$id_absen = $cekAbsenExist;

			if ($id_absen == 0) {
				$this->db->insert('tbl_absensi', $newArray);
			} else {
				$this->db->where('id', $id_absen);
				$this->db->update('tbl_absensi', $newArray);
			}
		}

		//exit;
		redirect('admin/presensi/index');
		//print_r($detailPegawai);
	}

	function set_session_validator()
	{
		$id_pj = $this->input->post('id_pj');

		$this->session->set_userdata('id_pj', $id_pj);
		return true;
	}

	function reupdate_absensi_cuti($id_cuti, $pin, $id_pegawai)
	{

		$jamKerja     = $this->Pegawai_model->checkJenisJamKerja($id_pegawai);
		$data_cuti = 	$this->Cuti_model->getDetailCuti($id_cuti);

		$jns_cuti    = $data_cuti[0]->jns_cuti;
		$alasan_cuti = $data_cuti[0]->alasan_cuti;

		$tgl_dari     = $data_cuti[0]->tgl_dari;
		$tgl_sampai     = $data_cuti[0]->tgl_sampai;
		$hari_cuti    = $data_cuti[0]->hari_cuti;

		#print_array($data_cuti);
		if ($hari_cuti == 1) {
			$this->Presensi_model->insertAbsensiCuti($tgl_dari, $pin);
		} else {
			$list_hari = $this->Cuti_model->getListHariCuti($id_cuti);


			$selisihhari =  datediff('d', $tgl_dari, $tgl_sampai);
			//selesih hari jika cuti yang  hari dianggap 0 hari, maka dari itu harus ditambah 1 hari
			$selisihhari = $selisihhari + 1;


			if ($jamKerja == 'non_shift') {
				$dataCuti = $this->Cuti_model->getHariCuti($selisihhari, $tgl_dari);
				$hariCuti = $dataCuti[0];
				$list_hari = $dataCuti[1];
			} else {
				$list_hari = array();
				$datetime1 = date_create($tgl_dari);
				$datetime2 = date_create($tgl_sampai);
				// Calculates the difference between DateTime objects
				$interval = date_diff($datetime1, $datetime2);
				$hariCuti =  $interval->format('%a') + 1;
				$newDate      = $tgl_dari;
				for ($a = 0; $a < $hariCuti; $a++) {


					$list_hari[] = $newDate;
					$newDate = addDaysToDate($newDate, 1);
				}
			}


			// print_array($list_hari);
			// exit;
			for ($c = 0; $c < count($list_hari); $c++) {
				$tgl_cuti = $list_hari[$c];
				$this->Presensi_model->insertAbsensiCuti($tgl_cuti, $pin, $alasan_cuti);
			}
		}


		$this->session->set_flashdata('message', '<strong>Success!!! </strong> Data cuti telah ditambahkan ke absensi');
		redirect('admin/presensi/absensi_raw/' . $pin . '/' . $id_pegawai);
	}

	function tarik_data_absensi()
	{
		//tarik data dari mesin absensi
		$id_pkm        = $this->session->userdata('id_pkm');
		$this->db->where('id_puskesmas', $id_pkm);
		$qry = $this->db->get('tbl_mesin_absensi');
		$row = $qry->result();

		// print_array( $row);
		// print_array( $this->session->userdata);
		// exit;
		$ip_address = $row[0]->ip_address;
		$periode_bulan = $this->session->userdata('periode_bulan');
		$periode_tahun = $this->session->userdata('periode_tahun');
		if ($periode_bulan == '') {
			$bulan = date('m');
			$tahun = date('Y');
			$this->session->set_userdata('periode_bulan', $bulan);
			$this->session->set_userdata('periode_tahun', $tahun);
			$this->session->set_userdata('id_pkm', 1);
		} else {
			$bulan = $periode_bulan;
			$tahun = $periode_tahun;
		}


		$periode = $tahun . '-' . $bulan;
		$periode = date('Y-m', strtotime($periode));

		$dataPresensi = $this->Sinkron_model->getDataAbsenMesin($ip_address, $pin = '');



		for ($i = 0; $i < count($dataPresensi); $i++) {

			$DateTime = $dataPresensi[$i]['DateTime'];
			$pin      = $dataPresensi[$i]['pin'];
			$Status   = $dataPresensi[$i]['Status'];

			$periode_db = date('Y-m', strtotime($DateTime));

			#echo 'Periode DB '.$periode_db;
			if ($periode == $periode_db) {
				$this->Presensi_model->insertAbsensi($DateTime, $pin, $Status);
			}
		}
		echo 'selesai';
		#print_array($dataPresensi);
	}

	function sinkron_dinas_luar($id, $id_pegawai, $pin)
	{
		$data_dinas_luar = $this->Presensi_model->getDetailPengajuanDinasLuar($id);

		$tanggal = $data_dinas_luar->tanggal;
		$jns_dl  = trim($data_dinas_luar->jns_dl);

		$absenId = $this->Presensi_model->cekAbsenExist($tanggal, $pin);

		if (!$absenId) {
			return;
		}

		// mapping perubahan berdasarkan jenis
		$dataUpdate = [
			'keterangan' => $data_dinas_luar->keterangan
		];

		switch ($jns_dl) {

			case 'DLA':
				$dataUpdate += [
					'masuk' => $jns_dl,
					'telat' => 0
				];
				break;

			case 'DLP':
				$dataUpdate += [
					'masuk'  => $jns_dl,
					'pulang' => $jns_dl,
					'telat'  => 0,
					'p_awal' => 0
				];
				break;

			default:
				$dataUpdate += [
					'pulang' => $jns_dl,
					'p_awal' => 0
				];
				break;
		}

		$this->db->where('id', $absenId);
		$this->db->update('tbl_absensi', $dataUpdate);

		//exit;

		//$this->Presensi_model->sinkronDinasLuar($tanggal, $jam_mulai, $jam_selesai, $pin);
		redirect('admin/presensi/lihat_absensi_pegawai/' . $id_pegawai . '/' . $pin);
	}



	// function sinkron_absensi($pin, $id_pegawai = 0)
	// {

	// 	$id_pkm        = $this->session->userdata('id_pkm');
	// 	//$pegawai      = $this->Presensi_model->getListPegawaiKelurahan($id_pkm);
	// 	$data_pegawai  = $this->Pegawai_model->getDataEditPegawai($id_pegawai);
	// 	$periode_bulan = $this->session->userdata('periode_bulan');
	// 	$periode_tahun = $this->session->userdata('periode_tahun');
	// 	$jns_jam_kerja = $data_pegawai[0]->jns_jam_kerja;


	// 	if ($periode_bulan == '') {
	// 		$bulan = date('m');
	// 		$tahun = date('Y');


	// 		$this->session->set_userdata('periode_bulan', $bulan);
	// 		$this->session->set_userdata('periode_tahun', $tahun);
	// 		$this->session->set_userdata('id_pkm', 1);
	// 	} else {
	// 		$bulan = $periode_bulan;
	// 		$tahun = $periode_tahun;
	// 	}


	// 	$periode = $tahun . '-' . $bulan;
	// 	$periode = date('Y-m', strtotime($periode));

	// 	$id_mesin      = $data_pegawai[0]->id_mesin;
	// 	$jns_jam_kerja = $data_pegawai[0]->jns_jam_kerja;


	// 	$dataAbsensi = $this->Presensi_model->getRawAbensi($pin, $periode);

	// 	//print_array($dataAbsensi);

	// 	//echo $id_mesin;

	// 	// $sql = "SELECT * FROM `import_absen` WHERE `pin`= '$id_mesin' AND tanggal like '$periode%' ORDER BY `tanggal` DESC";
	// 	// $qry = $this->db->query($sql);
	// 	// $dataAbsensi = $qry->result();

	// 	// if (empty($dataAbsensi)) {
	// 	// 	$sql = "SELECT * FROM `import_absen` WHERE `pin`= '$pin' AND tanggal like '$periode%' ORDER BY `tanggal` DESC";
	// 	// 	$qry = $this->db->query($sql);
	// 	// 	$dataAbsensi = $qry->result();
	// 	// }
	// 	#$dataAbsensi  = $this->Presensi_model->getDataImportAbsensi($id_mesin, $periode);

	// 	if (count($dataAbsensi) > 100) {
	// 		echo  'Warning! Data terlalu banyak, lakukan clean data absensi<br>
	// 		<a href="' . base_url() . 'admin/presensi/cleanAbsensi/' . $pin . '/' . $id_pegawai . '" target="_blank">Clean Data</a>';
	// 		exit;
	// 	}

	// 	// print_array($dataAbsensi);
	// 	// exit;
	// 	if (!empty($dataAbsensi)) {
	// 		$tgl_awal = '';
	// 		for ($a = 0; $a < count($dataAbsensi); $a++) {

	// 			$id_absen = $dataAbsensi[$a]->id;
	// 			$datetime       = $dataAbsensi[$a]->tanggal;
	// 			$status_absen   = $dataAbsensi[$a]->status;
	// 			$id_absen       = $dataAbsensi[$a]->id;


	// 			$date = format_db($datetime);
	// 			$jam  = date('H:i:s', strtotime($datetime));

	// 			$cekAbsensiExist = $this->Presensi_model->cekAbsenExist($date, $pin);


	// 			//echo $datetime . '-' . $status_absen . '<br>';
	// 			$explode = explode(":", $jam);
	// 			$hour    = $explode[0];




	// 			if ($tgl_awal == $datetime) {
	// 			} else {
	// 				//echo '<p>' . $date . ' - ' . $jam . '  -- ' . $status_absen . '</p>';
	// 				if ($jns_jam_kerja == 'shift') {

	// 					if ($cekAbsensiExist > 0) {
	// 						//udah ada row



	// 						if ($status_absen == 0) {
	// 							$this->db->where('id', $cekAbsensiExist);
	// 							$this->db->set('masuk', $jam);
	// 							$this->db->update('tbl_absensi');
	// 						} else {
	// 							$this->db->where('id', $cekAbsensiExist);
	// 							$this->db->set('pulang', $jam);
	// 							$this->db->update('tbl_absensi');
	// 						}
	// 					} else {
	// 						//belum ada
	// 						if ($status_absen == 0) {
	// 							//absen masuk

	// 							if ($hour < 9) {
	// 								$shiftKerja = 'P';
	// 								$jamMasuk = '07:30';
	// 							} else if ($hour > 12 && $hour < 15) {
	// 								$shiftKerja = 'SM';
	// 								$jamMasuk = '14:00';
	// 							} else {
	// 								$shiftKerja = 'M';
	// 								$jamMasuk = '21:00';
	// 							}



	// 							$newArray = array(
	// 								'tanggal' => $date,
	// 								'pin' => $pin,
	// 								'shift' => $shiftKerja,
	// 								'jam_masuk' => $jamMasuk,
	// 								'jam_pulang' => '00:00:00',
	// 								'masuk' => $jam,
	// 								'pulang' => '',
	// 								'telat' => 0,
	// 								'p_awal' => 0,
	// 								'keterangan' => ''
	// 							);
	// 						} else {

	// 							$shiftKerja = 'L-OFF';
	// 							$jamPulang  = '07:30';

	// 							$newArray = array(
	// 								'tanggal' => $date,
	// 								'pin' => $pin,
	// 								'shift' => $shiftKerja,
	// 								'jam_masuk' => '00:00:00',
	// 								'jam_pulang' => $jamPulang,
	// 								'masuk' => '',
	// 								'pulang' => $jam,
	// 								'telat' => 0,
	// 								'p_awal' => 0,
	// 								'keterangan' => ''
	// 							);
	// 						}

	// 						$this->db->insert('tbl_absensi', $newArray);
	// 					}
	// 				} else {

	// 					if ($hour > 5 && $hour < 10) {
	// 						//$status = 'Masuk';

	// 						if ($cekAbsensiExist > 0) {
	// 							//udah ada row
	// 							$this->db->where('id', $cekAbsensiExist);
	// 							$this->db->set('masuk', $jam);
	// 							$this->db->update('tbl_absensi');
	// 						} else {
	// 							//belum ada
	// 							$this->Presensi_model->createinitialShift2($pin, $date, $jam, '');
	// 						}
	// 					} else {
	// 						//$status = 'Pulang';

	// 						if ($cekAbsensiExist > 0) {
	// 							//udah ada row
	// 							$this->db->where('id', $cekAbsensiExist);
	// 							$this->db->set('pulang', $jam);
	// 							$this->db->update('tbl_absensi');
	// 						} else {
	// 							//belum ada
	// 							$this->Presensi_model->createinitialShift($pin, $date, '', $jam);
	// 						}
	// 					}
	// 				} //close if shift




	// 				// if ($hour > 5 && $hour < 10) {
	// 				// 	//$status = 'Masuk';

	// 				// 	if ($cekAbsensiExist > 0) {
	// 				// 		//udah ada row
	// 				// 		$this->db->where('id', $cekAbsensiExist);
	// 				// 		$this->db->set('masuk', $jam);
	// 				// 		$this->db->update('tbl_absensi');
	// 				// 	} else {
	// 				// 		//belum ada
	// 				// 		$this->Presensi_model->createinitialShift2($pin, $date, $jam, '');
	// 				// 	}
	// 				// } else {
	// 				// 	//$status = 'Pulang';

	// 				// 	if ($cekAbsensiExist > 0) {
	// 				// 		//udah ada row
	// 				// 		$this->db->where('id', $cekAbsensiExist);
	// 				// 		$this->db->set('pulang', $jam);
	// 				// 		$this->db->update('tbl_absensi');
	// 				// 	} else {
	// 				// 		//belum ada
	// 				// 		$this->Presensi_model->createinitialShift($pin, $date, '', $jam);
	// 				// 	}
	// 				// }
	// 			}

	// 			//print_array($newArray);

	// 			$tgl_awal = $datetime;
	// 		}
	// 	}

	//exit;
	// 	redirect('admin/presensi/lihat_absensi_pegawai/' . $id_pegawai . '/' . $pin);
	// }

	function cleanAbsensi($pin, $id_pegawai)
	{
		$id_pkm        = $this->session->userdata('id_pkm');
		//$pegawai      = $this->Presensi_model->getListPegawaiKelurahan($id_pkm);
		$data_pegawai  = $this->Pegawai_model->getDataEditPegawai($id_pegawai);
		$periode_bulan = $this->session->userdata('periode_bulan');
		$periode_tahun = $this->session->userdata('periode_tahun');
		$jns_jam_kerja = $data_pegawai[0]->jns_jam_kerja;

		if ($periode_bulan == '') {
			$bulan = date('m');
			$tahun = date('Y');


			$this->session->set_userdata('periode_bulan', $bulan);
			$this->session->set_userdata('periode_tahun', $tahun);
			$this->session->set_userdata('id_pkm', 1);
		} else {
			$bulan = $periode_bulan;
			$tahun = $periode_tahun;
		}


		$periode = $tahun . '-' . $bulan;
		$periode = date('Y-m', strtotime($periode));

		$id_mesin      = $data_pegawai[0]->id_mesin;
		$jns_jam_kerja = $data_pegawai[0]->jns_jam_kerja;

		echo $periode;

		//echo $id_mesin;

		$sql = "SELECT * FROM `import_absen` WHERE `pin`= '$id_mesin' AND tanggal like '$periode%' ORDER BY `tanggal` DESC";
		$qry = $this->db->query($sql);
		$dataAbsensi = $qry->result();

		if (empty($dataAbsensi)) {
			$sql = "SELECT * FROM `import_absen` WHERE `pin`= '$pin' AND tanggal like '$periode%' ORDER BY `tanggal` DESC";
			$qry = $this->db->query($sql);
			$dataAbsensi = $qry->result();
		}
		#$dataAbsensi  = $this->Presensi_model->getDataImportAbsensi($id_mesin, $periode);

		if (!empty($dataAbsensi)) {
			$tgl_awal = $dataAbsensi[0]->tanggal;
			for ($a = 0; $a < count($dataAbsensi); $a++) {

				$id_absen = $dataAbsensi[$a]->id;
				$datetime       = $dataAbsensi[$a]->tanggal;
				$status_absen   = $dataAbsensi[$a]->status;
				$id_absen       = $dataAbsensi[$a]->id;




				if ($tgl_awal == $datetime) {
					echo $a . '-' . $datetime . '  Hapus <br>';
					$this->db->where('id', $id_absen);
					$this->db->delete('import_absen');
				} else {
					echo $a . '-' . $datetime . '<br>';
				}

				//print_array($newArray);

				$tgl_awal = $datetime;
			}
		}


		//print_array($dataAbsensi);
		exit;
	}



	function set_session_periode()
	{

		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');


		$no_bulan = getIDBulan($bulan); //rubah dari nama bulan jadi urutan bulan ( Maret = 3)

		$this->session->set_userdata('periode_bulan', $no_bulan);
		$this->session->set_userdata('periode_tahun', $tahun);

		return true;

		#$this->session->set_userdata($this->input->post());
		#redirect('admin/presensi/index');
	}


	function set_session_puskesmas()
	{
		$id_pkm = $this->input->post('id_pkm');

		$this->session->set_userdata('id_pkm', $id_pkm);


		return true;
	}

	function hitung_telat($id_pegawai, $pin, $tanggal)
	{

		$absensiHarian  = $this->Presensi_model->getDataAbsensi($pin, $tanggal);
		if (!empty($absensiHarian)) {
			$id         = $absensiHarian[0]->id;
			$jamMasukKerja     = $absensiHarian[0]->jam_masuk;
			$jamKeluarKerja    = $absensiHarian[0]->jam_pulang;

			$absenMasuk         = $absensiHarian[0]->masuk;
			$absenPulang        = $absensiHarian[0]->pulang;
			$keterangan_absen   = $absensiHarian[0]->keterangan;

			$telat  = getHourDifference($jamMasukKerja, $absenMasuk);
			$p_awal = getHourDifference($jamKeluarKerja, $absenPulang, 'p.awal');


			$newArray = array(
				'telat' => $telat,
				'p_awal' => $p_awal,
			);

			$this->db->where('id', $id);
			$this->db->update('tbl_absensi', $newArray);
		}


		redirect('admin/presensi/lihat_absensi_pegawai/' . $id_pegawai . '/' . $pin);
	}

	function edit_id_pin($id_pegawai, $pin)
	{

		$id_mesin = $this->input->post('id_mesin');
		$this->db->where('pin', $id_mesin);
		$this->db->set('pin', $pin);
		$this->db->update('import_absen');

		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->set('id_mesin', $id_mesin);
		$this->db->update('mst_pegawai');

		$this->session->set_flashdata('message', '<strong>Success!!! </strong> Data status absensi berhasil diupdate');
		redirect('admin/presensi/absensi_raw/' . $pin . '/' . $id_pegawai);
	}

	function view_import_absensi($pin = '')
	{

		if ($pin != '') {
			$this->db->where('pin', $pin);
		}
		$this->db->order_by('tanggal', 'DESC');
		$qry = $this->db->get('import_absen', 1000, 0);

		$data['import'] = $qry->result();
		$this->load->view('admin/presensi/view_import_absensi', $data);
	}
	public function delete_import_absen($pin, $id)
	{
		$this->db->where('pin', $pin);
		$this->db->delete('import_absen');
		redirect('admin/presensi/view_import_absensi/' . $pin);
	}

	public function delete_list_absensi($id_pegawai, $pin, $id)
	{
		$this->db->where('id', $id);
		$this->db->delete('tbl_absensi');
		redirect('admin/presensi/lihat_absensi_pegawai/' . $id_pegawai . '/' . $pin);
	}

	function sinkron_to_absensi($id_cuti, $pin, $periode)
	{

		$this->db->select('id_pegawai, alasan_cuti');
		$qry = $this->db->get_where('ts_pengajuan_cuti', ['id' => $id_cuti]);
		$row = $qry->row();


		$qry = $this->db->get_where('ts_pengajuan_cuti_detail', ['id_pengajuan_cuti' => $id_cuti]);
		$list_hari = $qry->result();


		//print_array($list_hari);

		foreach ($list_hari as $ls) {

			$this->Presensi_model->update_absensi_cuti($pin, $ls->tgl_cuti, $row->alasan_cuti);
		}

		redirect('admin/presensi/lihat_absensi_pegawai/' . $row->id_pegawai . '/' . $pin);
	}

	function lihat_absensi_pegawai($id_pegawai, $pin)
	{

		$filter = $this->session->userdata('filter_presensi');
		$periode       = $filter['periode'];

		$tahun = date('Y', strtotime($periode));
		$bulan = date('m', strtotime($periode));
		$periode = $tahun . '-' . $bulan;
		$periode = date('Y-m', strtotime($periode));

		$data['data_pegawai'] = $this->Pegawai_model->getDetailPegawai($id_pegawai);
		$data['data_shift_kerja'] = $this->Presensi_model->getShiftKerja();
		$data['dataRekap'] = $this->Presensi_model->getRekapAbsensiPegawai($id_pegawai, $periode);
		$data['dataCuti'] = $this->acm->getCutiPegawai($id_pegawai, $bulan, $tahun);
		$data['absensiRaw'] = $this->Presensi_model->getRawAbensi($pin, $periode);
		//$data['numCuti'] = $this->Presensi_model->getjumlahCuti($id_pegawai, $periode);
		$data['pengajuan_dinas_luar'] = $this->Presensi_model->getDataPengajuanDLPerbulan($id_pegawai, $periode);
		$this->load->view('admin/presensi/lihat_absensi', $data);
	}


	public function cetak_absensi($pin = NULL, $id_pegawai = NULL, $periode = NULL)
	{
		if (!$pin || !$id_pegawai) {
			show_404();
		}

		// Default periode jika kosong
		if (!$periode) {
			$filter = $this->session->userdata('filter_presensi');
			$periode = isset($filter['periode']) ? $filter['periode'] : date('Y-m');
		}

		// Fetch data pegawai
		$data_pegawai = $this->Pegawai_model->getDataEditPegawai($id_pegawai); // Sesuaikan method model Anda
		if (empty($data_pegawai)) {
			show_404();
		}

		$data['pegawai']       = $data_pegawai[0];
		$data['puskesmas']     = $this->Presensi_model->getNamaPuskesmas($data['pegawai']->id_puskesmas);
		$data['periode']       = $periode;
		$data['pin']           = $pin;
		$data['id_pegawai']    = $id_pegawai;
		$data['absensiHarian'] = $this->Presensi_model->getAbsensiPegawai($pin, $periode);
		//$data['dataRekap']     = $this->Presensi_model->getRekapByPin($pin, $periode); // Sesuaikan jika ada method rekap

		// Load view khusus cetak
		$this->load->view('admin/presensi/cetak_absensi_view', $data);
	}


	function update_shift_harian($pin, $id_pegawai)
	{
		#print_array($this->input->post());
		$tgl = $this->input->post('tgl_shift');
		$shift = $this->input->post('shift');

		$tgl = format_db($tgl);

		$id_absen = $this->Presensi_model->cekAbsenExist($tgl, $pin);


		$JamKerjaShift = $this->Presensi_model->detailShiftByKode($shift);
		$jamMasuk      = $JamKerjaShift->jam_masuk;
		$jamPulang     = $JamKerjaShift->jam_pulang;

		$newArray = array(
			'shift' => $shift,
			'jam_masuk' => $jamMasuk,
			'jam_pulang' => $jamPulang,

		);

		#print_array($newArray);
		$this->db->where('id', $id_absen);
		$this->db->update('tbl_absensi', $newArray);



		$this->session->set_flashdata('message', '<strong>Success!!! </strong> Data shift absensi berhasil diupdate');
		redirect('admin/presensi/lihat_absensi_pegawai/' . $id_pegawai . '/' . $pin);
	}

	function getDataPengajuanDL()
	{
		$id_pegawai   = $this->input->post('id_pegawai');
		$pin      = $this->input->post('pin');
		$tanggal      = $this->input->post('tanggal');

		$tanggal = format_db($tanggal);
		$dataDl = $this->Presensi_model->getDataPengajuanDL($id_pegawai, $tanggal);

		echo '
		<table class="table">
			<tr>
			  <th>Tanggal</th>
			  <th>Jenis DL</th>
			  <th>Keterangan</th>
			  <th>Status</th>
			  <th>Surat Tugas</th>
			  <th>Action</th>
			</tr>';

		for ($i = 0; $i < count($dataDl); $i++) {
			$id_dl = $dataDl[$i]->id;
			$tanggal = $dataDl[$i]->tanggal;
			$jns_dl = $dataDl[$i]->jns_dl;
			$keterangan = $dataDl[$i]->keterangan;
			$status = $dataDl[$i]->status;
			$surtug = $dataDl[$i]->surtug;

			if ($status == 0) {
				$flag = '<span class="badge bg-warning-subtle text-warning">Pending</span>';
			} else {
				$flag = '<span class="badge bg-success-subtle text-success">Valid</span>';
			}

			echo '	<tr>
							<td>' . format_slash($tanggal) . '</td>
							<td>' . $jns_dl . '</td>
							<td>' . $keterangan . '</td>
							<td>' . $flag . '</td>
							<td><a href="' . base_url() . 'uploads/surat_tugas/' . $surtug . '" target="_blank" class="btn-link">Lihat</a></td>
							<td><a href="' . base_url() . 'admin/presensi/setujui_pengajuan_dl/' . $id_dl . '/1/' . $pin . '/' . $id_pegawai . '" class="btn btn-sm btn-info">Setujui</a></td>
						</tr>';
		}


		echo '</table>';
	}



	function edit_shift($pin, $id_pegawai)
	{
		$tahun = $this->session->userdata('periode_tahun');
		$bulan = $this->session->userdata('periode_bulan');


		$periode = $tahun . '-' . $bulan;
		$periode = date('Y-m', strtotime($periode));


		$data['data_pegawai'] = $this->Pegawai_model->getDataEditPegawai($id_pegawai);
		$data['data_shift_kerja'] = $this->Presensi_model->getShiftKerja();
		$data['dataRekap'] = $this->Presensi_model->getRekapAbsensiPegawai($id_pegawai, $periode);
		$this->load->view('admin/presensi/edit_shift', $data);
	}

	// function insert_shift_kerja(){
	// 	$id_pegawai   = $this->input->post('id_pegawai');
	// 	$tanggal   = $this->input->post('tanggal');
	// 	$kode_shift   = $this->input->post('id_shift');


	// 	$cekShift = $this->Presensi_model->cekDataShift($id_pegawai, $tanggal);
	// 	if(!empty($cekShift)){
	// 		//update
	// 		$id = $cekShift[0]->id;
	// 		$this->Presensi_model->updateShiftPegawai($id, $kode_shift);

	// 	}else{
	// 		//insert baru
	// 		$this->Presensi_model->insertShiftPegawai($id_pegawai, $tanggal, $kode_shift);

	// 	}

	// }

	function check_ok($pin, $id_pegawai, $id_rekap)
	{
		$this->Presensi_model->updateStatusAbsensiRekap($id_rekap);

		$this->session->set_flashdata('message', '<strong>Success!!! </strong> Data status absensi berhasil diupdate');
		redirect('admin/presensi/lihat_absensi_pegawai/' . $id_pegawai . '/' . $pin);
	}


	function insert_user()
	{

		$this->Presensi_model->insertDataPegawai();


		$this->session->set_flashdata('message', '<strong>Success!!! </strong> Data user berhasil ditambahkan');
		redirect('admin/presensi/index');
	}

	function detail_absensi_harian()
	{
		$datapost    = $this->input->post('data_post');
		$explo       = explode("/", $datapost);
		$pin         = $explo[0];
		$id_pegawai  = $explo[1];
		$tanggal     = $explo[2];

		$data['tanggal'] = $tanggal;

		$periode = date('Y-m', strtotime($tanggal));

		$data['absensi_raw'] = $this->Presensi_model->getRawAbensiPertanggal($pin, $tanggal);
		$data['data_shift_kerja'] = $this->Presensi_model->getShiftKerja();
		$data['shift_kerja'] = $this->Presensi_model->getShiftPegawai($id_pegawai, $tanggal);
		$data['detail_pegawai'] = $this->Pegawai_model->getDataEditPegawai($id_pegawai);
		$data['absensiHarian'] = $this->Presensi_model->getDataAbsensi($pin, $tanggal);
		$data['dinasLuar'] = $this->Presensi_model->getDataPengajuanDL($id_pegawai, $tanggal);
		$data['izinSakit'] = $this->Presensi_model->cekIzinSakit($id_pegawai, $tanggal);
		$data['cuti'] = $this->Cuti_model->getCutiPegawai($id_pegawai, $periode);

		$this->load->view('admin/presensi/view_ajax_detail_absensi', $data);
	}

	function edit_data_pegawai($pin, $id_pegawai)
	{
		$data['data_pegawai'] = $this->Presensi_model->getDetPegawai($pin);
		$data['puskesmas'] = $this->Presensi_model->getListPuskesmas();

		$this->load->view('admin/presensi/edit_data_pegawai', $data);
	}

	function insert_absen_cuti($id_cuti, $id_pegawai)
	{
		$periode_bulan = $this->session->userdata('periode_bulan');
		$detail_cuti  = $this->Cuti_model->getDetailCuti($id_cuti);
		$hari_cuti    = $detail_cuti[0]->hari_cuti;
		$tgl_dari     = $detail_cuti[0]->tgl_dari;
		$alasan_cuti  = $detail_cuti[0]->alasan_cuti;
		$jns_cuti     = $detail_cuti[0]->jns_cuti;



		$nip          = $this->Pegawai_model->getNipPegawaiByID($id_pegawai);
		$pin          = substr($nip, -4);

		if ($jns_cuti == 2) {
			//cuti melahirkan
			$thn_cuti = date('Y', strtotime($tgl_dari));
			$bln_cuti = date('m', strtotime($tgl_dari));
			$tgl = date('d', strtotime($tgl_dari));
			$lastDate = date('t', strtotime($tgl_dari));
			$periode = $thn_cuti . '-' . $bln_cuti;


			if ($periode_bulan == $bln_cuti) {

				for ($i = $tgl; $i <=  $lastDate; $i++) {

					$tanggal = $periode . '-' . $i;
					$tgl_cuti = format_db($tanggal);

					$this->Presensi_model->insertAbsensiCuti($tgl_cuti, $pin, $alasan_cuti);
				}
			}
		}


		if ($hari_cuti == 1) {
			$this->Presensi_model->insertAbsensiCuti($tgl_dari, $pin, $alasan_cuti);
		} else {
			$list_hari = $this->Cuti_model->getListHariCuti($id_cuti);
			for ($c = 0; $c < count($list_hari); $c++) {
				$tgl_cuti = $list_hari[$c]->tanggal;
				$this->Presensi_model->insertAbsensiCuti($tgl_cuti, $pin, $alasan_cuti);
			}
		}
		redirect('admin/presensi/index');
	}


	function update_data_rekap($pin, $id_pegawai, $periode)
	{

		$data_pegawai  = $this->Pegawai_model->getDataEditPegawai($id_pegawai);
		// $periode_bulan = $this->session->userdata('periode_bulan');
		// $periode_tahun = $this->session->userdata('periode_tahun');
		$jns_jam_kerja = $data_pegawai[0]->jns_jam_kerja;

		// if ($periode_bulan == '') {
		// 	$bulan = date('m');
		// 	$tahun = date('Y');


		// 	$this->session->set_userdata('periode_bulan', $bulan);
		// 	$this->session->set_userdata('periode_tahun', $tahun);
		// 	$this->session->set_userdata('id_pkm', 1);
		// } else {
		// 	$bulan = $periode_bulan;
		// 	$tahun = $periode_tahun;
		// }


		// $periode = $tahun . '-' . $bulan;
		// $periode = date('Y-m', strtotime($periode));
		$last_date = date('t', strtotime($periode));

		//echo $periode;



		$this->db->where('pin', $pin);
		$this->db->like('tanggal', '2026-08', 'after');
		$qry = $this->db->get('tbl_absensi');
		$res = $qry->result();

		//echo $this->db->last_query();


		$numSakit = 0;
		$numIzin = 0;
		$numCuti = 0;
		$numDLP = 0;
		$numDLA = 0;
		$numDLH = 0;
		$numSakitDgnSK = 0;

		$arrayshift = ['P', 'S', 'PS', 'REG', 'REG-JUM'];
		$arrayshift2 = ['SM', 'M', 'PSM']; // Shift awal (masuk saja)
		$shiftLepas  = ['L-OFF'];
		// Akumulasi total rekap
		$totalTelat = 0;
		$totalPAwal = 0;
		$totalHadir = 0;
		$numAlpha = 0;

		$arrayStatus = ['CUTI', 'IZIN', 'SAKIT', 'DLP'];


		foreach ($res as $absen) {
			$shift  = $absen->shift;
			$masuk  = $absen->masuk;
			$pulang = $absen->pulang;
			$jamMasuk = $absen->jam_masuk;
			$jamPulang = $absen->jam_pulang;
			$tanggal  = $absen->tanggal;


			if (in_array($shift, $arrayshift, true)) {

				// Cek jika jam masuk dan pulang terisi dua-duanya
				if (!empty($masuk) && !empty($pulang)) {

					$selisihDetik = abs(strtotime($pulang) - strtotime($masuk));

					// Jika selisih masuk & pulang KURANG DARI 5 MENIT (300 detik)
					// Dianggap sebagai double scan di waktu yang bersamaan
					if ($selisihDetik <= 300) {

						$jamScan = (int) date('H', strtotime($masuk));

						// Jika scan terjadi jam 12 siang ke atas -> anggap ABSEN PULANG
						if ($jamScan >= 12) {
							$masuk        = null;
							$absen->masuk = null;
						}
						// Jika scan pagi hari -> anggap ABSEN MASUK (ambil scan pertama, pulangnya null)
						else {
							$pulang        = null;
							$absen->pulang = null;
						}
					}
				}

				// Properti objek diperbarui agar sync
				$absen->masuk  = $masuk;
				$absen->pulang = $pulang;
			}

			// 1. KASUS SHIFT OVERNIGHT (SM, M, PSM) -> Masuk ada, Pulang NULL
			if (in_array($shift, $arrayshift2, true)) {

				$updateColmn = ['p_awal' => 0];
				//echo 'ID :' . $absen->id . '-Tanggal : ' . $tanggal . ' - ' . $shift . ' Jam absen masuk ' . $absen->masuk . ' Jam absen pulang ' . $absen->pulang . '<br>';

				// Jika jam pulang ternyata terisi (karena double tap / scan salah), kosongkan pulangnya

				if (!is_null($pulang)) {
					$absen->pulang = null;
					$updateColmn['pulang'] = null;
				}

				$this->db->where('id', $absen->id);
				$this->db->update('tbl_absensi', $updateColmn);
			} elseif ($shift == 'L-OFF') {

				// 1. Jika jam masuk terisi (atau duplikat dengan pulang)
				// Pindahkan nilainya ke 'pulang' jika pulangnya kosong, lalu kosongkan 'masuk'
				if (!empty($masuk)) {
					if (empty($pulang) || $masuk === $pulang) {
						$pulang = $masuk; // Masukkan ke pulang
					}
					$masuk = null; // KOSONGKAN MASUK (variabel lokal)
					$absen->masuk  = null;
					$absen->pulang = $pulang;
				}

				//	if (empty($pulang)) {
				//	$pAwal = 150;
				//}



				// 2. KHUSUS L-OFF: Jam masuk selalu NULL, jadi TELAT PASTI 0
				$telat = 0;

				// 3. Hitung Pulang Awal untuk L-OFF (jika ada jam pulang standar & jam scan pulang)
				$pAwal = 150;
				if (!empty($pulang) && !empty($jamPulang)) {
					$timePulang    = strtotime($pulang);
					$timeJadwalPlg = strtotime($jamPulang);

					if ($timePulang < $timeJadwalPlg) {
						$pAwal = floor(($timeJadwalPlg - $timePulang) / 60);
					}
				}

				// 4. Update ke Database (Gunakan NULL murni)
				$this->db->where('id', $absen->id);
				$this->db->update('tbl_absensi', [
					'masuk'  => null,
					'pulang' => $pulang,
					'telat'  => $telat,
					'p_awal' => $pAwal
				]);

				// Update properti objek agar saat di-print nilainya sudah yang baru
				$absen->telat  = $telat;
				$absen->p_awal = $pAwal;

				// Cetak hasil yang sudah diperbarui
				//echo $absen->tanggal . ' - ' . $shift . '<br>';
				//print_array($absen); 
			}


			// ==========================================
			// PROSES 2: HITUNG TELAT & PULANG AWAL
			// ==========================================
			$telat = 0;
			$pAwal = 0;


			// 1. Hitung Telat
			if (!empty($masuk) && !empty($jamMasuk)) {
				$timeMasuk    = strtotime($masuk);
				$timeJadwalMsk = strtotime($jamMasuk);

				if ($timeMasuk > $timeJadwalMsk) {
					$telat = floor(($timeMasuk - $timeJadwalMsk) / 60);
				}
			}

			// 2. Hitung Pulang Awal
			if (!empty($pulang) && !empty($jamPulang)) {
				$timePulang    = strtotime($pulang);
				$timeJadwalPlg = strtotime($jamPulang);


				if ($timePulang < $timeJadwalPlg) {
					$pAwal = floor(($timeJadwalPlg - $timePulang) / 60);
				}
			} else {

				if (in_array($shift, $arrayshift, true)) {
					if ($pulang == null) {
						$pAwal = 150;
					}
				}

				if ($shift == 'L-OFF' && $pulang == null) {
					$pAwal = 150;
				}

				// if ($shift != 'OFF' && $shift != 'L-OFF') {
				// 	$cekDLAK = $this->Presensi_model->getDataPengajuanDLByJenis($id_pegawai, $absen->tanggal, 'DLAK');
				// 	// print_array($cekDLAK);
				// 	if (!empty($cekDLAK)) {
				// 		$pulang = 'DLAK';
				// 		$pAwal = 0;
				// 		$keterangan = $cekDLAK->keterangan;
				// 	} else {
				// 		if ($masuk == null) {
				// 			$pAwal = 0;
				// 			$numAlpha++;
				// 		} else {
				// 			$pAwal = 150;
				// 		}
				// 	}
				// }

				if ($shift != 'OFF' && $shift != 'L-OFF') {
					if ($masuk == null && $pulang == null) {
						$pAwal = 0;
						$numAlpha++;
					}
				}
			}


			//echo $absen->tanggal.' - '.$pulang.'<br>';
			if (in_array($masuk, $arrayStatus, true)) {
				$pAwal = 0;
				$numAlpha--;

				if ($masuk == 'IZIN') {
					$numIzin++;
				}

				if ($masuk == 'SAKIT') {
					$numSakit++;
				}
				if ($masuk == 'CUTI') {
					$numCuti++;
				}
			}


			if ($pulang == 'DLAK') {
				$pAwal = 0;
			}
			// Akumulasi ke total rekap
			if (!empty($masuk) || !empty($pulang)) {
				$totalHadir++;
			}


			$totalTelat += $telat;
			$totalPAwal += $pAwal;

			$updateAbsensi = [
				'telat'  => $telat,
				'p_awal' => $pAwal
			];

			// ==========================================
			// PROSES 3: UPDATE DB HARI INI
			// ==========================================

			$this->db->where('id', $absen->id);
			$this->db->update('tbl_absensi', $updateAbsensi);


			// echo $absen->tanggal;
			// 	print_array($updateAbsensi);

		}

		// sakit dengan surat keterangan
		$tgl_now = date('Y-m-d');


		$id_rekap = $this->Presensi_model->cekDataRekapAbsensi($id_pegawai, $periode);

		if ($id_rekap == 0) {
			$this->Presensi_model->rekapAbsensi($id_pegawai, $periode, $totalTelat, $totalPAwal, $numIzin, $numSakit, $numDLP, $numDLA, $numDLH);
		} else {


			$dataRekap = array(
				'telat' => $totalTelat,
				'pulang_awal' => $totalPAwal,
				'izin' => $numIzin,
				'sakit' => $numSakit,
				'alpha' => max(0, $numAlpha),
				'isoman' => 0,
				'dl_penuh' => $numDLP,
				'dl_awal' => $numDLA,
				'dl_akhir' => $numDLH,
				'cuti' => $numCuti,
				'sakit_dgn_sk' => $numSakitDgnSK,
			);

			$this->db->where('id', $id_rekap);
			$this->db->update('ts_rekap_absensi', $dataRekap);
		}

		// echo $id_rekap;
		// print_array($dataRekap);

		// exit;

		$this->session->set_flashdata('message', ' Data berhasil direkap');
		redirect('admin/presensi/lihat_absensi_pegawai/' . $id_pegawai . '/' . $pin);
	}



	function update_data_pegawai($pin, $id_pegawai)
	{
		$this->Presensi_model->updateDataPegawai($id_pegawai);
		$this->session->set_flashdata('message', '<strong>Success!!! </strong> Data berhasil update');
		redirect('admin/presensi/edit_data_pegawai/' . $pin . '/' . $id_pegawai);
	}




	// $totalTelat = 0;
	// $totalPawal = 0;

	// $numSakit = 0;
	// $numIzin = 0;
	// $numCuti = 0;
	// $numAlpha = 0;
	// $numDLP = 0;
	// $numDLA = 0;
	// $numDLH = 0;
	// $numSakitDgnSK = 0;  // sakit dengan surat keterangan
	// $tgl_now = date('Y-m-d');

	// for ($d = 0; $d < $last_date; $d++) {

	// 	$tgl = $d + 1;
	// 	$date = $periode . '-' . $tgl;
	// 	$fulldate = format_db($date);

	// 	//$day = date('l', strtotime($fulldate));
	// 	$hari = getNamahari($fulldate);

	// 	$data_absensi = $this->Presensi_model->getDataAbsensi($pin, $fulldate, 'ts_absensi');
	// 	print_array($data_absensi);

	// 	if (!empty($data_absensi)) {
	// 		$id = $data_absensi[0]->id;
	// 		$shift = $data_absensi[0]->shift;
	// 		$absenMasuk = $data_absensi[0]->masuk;
	// 		$absenPulang = $data_absensi[0]->pulang;

	// 		$jamMasukKerja     = $data_absensi[0]->jam_masuk;
	// 		$jamKeluarKerja    = $data_absensi[0]->jam_pulang;

	// 		$telat  = $data_absensi[0]->telat;
	// 		$p_awal = $data_absensi[0]->p_awal;

	// 		$hari_libur = false;
	// 		$hariLibur  = $this->Presensi_model->cekHariLibur($fulldate);

	// 		#print_array($hariLibur );

	// 		if (!empty($hariLibur)) {
	// 			$hari_libur = true;
	// 			$telat = 0;
	// 			$p_awal = 0;
	// 		} else {

	// 			if ($absenMasuk == '' && $shift != 'OFF') {
	// 				if ($fulldate < $tgl_now) {
	// 					$telat          = 300;
	// 				} else {
	// 					$telat          = 0;
	// 				}
	// 			} else {
	// 				#$telat          = hitungTelat($jamMasukKerja, $absenMasuk);
	// 				if (strpos($absenMasuk, ':') !== false) {
	// 					$telat          = hitungTelat($jamMasukKerja, $absenMasuk);
	// 				} else {
	// 					$telat          = 0;
	// 				}
	// 			}

	// 			if ($absenPulang == '' && $shift != 'OFF') {

	// 				if ($fulldate < $tgl_now) {
	// 					$p_awal         = 150;
	// 				} else {
	// 					$p_awal         = 0;
	// 				}
	// 			} else {
	// 				if (strpos($absenPulang, ':') !== false) {
	// 					$p_awal          = hitungPulangCepat($jamKeluarKerja, $absenPulang);
	// 				} else {
	// 					$p_awal          = 0;
	// 				}
	// 			}

	// 			$this->db->where('id', $id);
	// 			$this->db->set('telat', $telat);
	// 			$this->db->set('p_awal', $p_awal);
	// 			$this->db->update('tbl_absensi');
	// 		}

	// 		if ($absenMasuk == 'SAKIT') {
	// 			$numSakit = $numSakit + 1;
	// 		}

	// 		if ($absenMasuk == 'IZIN') {
	// 			$numIzin = $numIzin + 1;
	// 		}

	// 		if ($absenMasuk == 'DLP') {
	// 			$numDLP = $numDLP + 1;
	// 		}

	// 		if ($absenMasuk == 'DLA') {
	// 			$numDLA = $numDLA + 1;
	// 		}

	// 		if ($absenPulang == 'DLAK') {
	// 			$numDLH = $numDLH + 1;
	// 		}

	// 		if ($absenMasuk == 'SAKIT DGN SURAT') {
	// 			$numSakitDgnSK = $numSakitDgnSK + 1;
	// 		}

	// 		if ($absenMasuk == 'CUTI') {
	// 			$numCuti = $numCuti + 1;
	// 		}


	// 		$numAlpha = 0;

	// 		if ($jns_jam_kerja == 'shift') {
	// 			$off_shift = strpos($shift, 'L-OFF');
	// 			$sm_shift  = strpos($shift, 'SM');
	// 			$m_shift   = strpos($shift, 'M');

	// 			if ($off_shift !== false) {
	// 				$telat = 0;
	// 			}

	// 			if ($sm_shift !== false) {
	// 				$p_awal = 0;
	// 			}


	// 			if ($m_shift !== false) {
	// 				$p_awal = 0;
	// 			}

	// 			$this->db->where('id', $id);
	// 			$this->db->set('telat', $telat);
	// 			$this->db->set('p_awal', $p_awal);
	// 			$this->db->update('tbl_absensi');
	// 		}

	// 		$totalTelat = $totalTelat + $telat;
	// 		$totalPawal = $totalPawal + $p_awal;
	// 	}
	// }

	// // echo $totalPawal;

	// $id_rekap = $this->Presensi_model->cekDataRekapAbsensi($id_pegawai, $periode);

	// if ($id_rekap == 0) {
	// 	$this->Presensi_model->rekapAbsensi($id_pegawai, $periode, $totalTelat, $totalPawal, $numIzin, $numSakit, $numDLP, $numDLA, $numDLH);
	// } else {


	// 	$this->Presensi_model->updateRekapAbsensi($id_rekap, $totalTelat, $totalPawal, $numIzin, $numSakit, $numDLP, $numDLA, $numDLH, $numSakitDgnSK, $numCuti);
	// }


	// $cuti = $this->Cuti_model->getCutiPegawai($id_pegawai, $periode);


	// //	print_array($cuti);

	// for ($i = 0; $i < count($cuti); $i++) {
	// 	$hari_cuti = $cuti[$i]->hari_cuti;
	// 	$status = $cuti[$i]->status;
	// 	$jns_cuti = $cuti[$i]->jns_cuti;
	// 	$id_cuti = $cuti[$i]->id;


	// 	if ($status == 'APPROVE') {
	// 		$cekData = $this->Presensi_model->cekDataRekapCuti($id_cuti);
	// 		if ($cekData == 0) {
	// 			$newArray = array(
	// 				'id_pegawai' => $id_pegawai,
	// 				'periode' => $periode,
	// 				'id_cuti' => $id_cuti,
	// 				'jns_cuti' => $jns_cuti,
	// 				'jml_hari' => $hari_cuti
	// 			);

	// 			$this->db->insert('ts_rekap_cuti', $newArray);
	// 		}
	// 	}
	// }


	// exit;

	function insert_absen_manual($pin, $tanggal)
	{

		$jam_masuk     = $this->input->post('jam_masuk');
		$jam_pulang    = $this->input->post('jam_pulang');
		$id_pegawai    = $this->input->post('id_pegawai');
		$tgl_absensi_edit    = $this->input->post('tgl_absensi_edit');

		if ($tgl_absensi_edit != '') {
			$tanggal = format_db($tgl_absensi_edit);
		}

		if ($jam_masuk != '') {

			$this->Presensi_model->insertJamAbsen($tanggal, $jam_masuk, $pin, 0);
		}

		if ($jam_pulang != '') {
			$this->Presensi_model->insertJamAbsen($tanggal, $jam_pulang, $pin, 1);
		}


		$dataAbsensi = $this->Presensi_model->getRawAbensiPertanggal($pin, $tanggal);

		for ($a = 0; $a < count($dataAbsensi); $a++) {


			$datetime       = $dataAbsensi[$a]->tanggal;
			$status_absen  = $dataAbsensi[$a]->status;
			$id_absen  = $dataAbsensi[$a]->id;

			$explode = explode(" ", $datetime);
			$tanggal = $explode[0];
			$jam     = $explode[1];




			if ($status_absen == 0) {

				$newArray = array(
					'tanggal' => $tanggal,
					'pin' => $pin,
					'masuk' => $jam,
					'telat' => 0,
					'keterangan' => ''
				);
			} else {
				$newArray = array(
					'tanggal' => $tanggal,
					'pin' => $pin,
					'pulang' => $jam,
					'p_awal' => 0,
					'keterangan' => ''
				);
			}



			$cekAbsenExist = $this->Presensi_model->cekAbsenExist($tanggal, $pin);
			if ($cekAbsenExist == false) {

				$this->db->insert('tbl_absensi', $newArray);
			} else {


				$this->db->where('pin', $pin);
				$this->db->where('tanggal', $tanggal);
				$this->db->update('tbl_absensi', $newArray);
			}
		}

		//redirect('admin/presensi/lihat_absensi_pegawai/'.$id_pegawai.'/'.$pin);
		redirect('admin/presensi/index');
	}

	function insert_absen_ketidakhadiran($pin, $id_pegawai)
	{


		$tanggal    = $this->input->post('tanggal'); // YYYY-MM-DD
		$jamMasuk   = $this->input->post('jam_masuk');
		$jamPulang  = $this->input->post('jam_pulang');
		$status     = $this->input->post('status');
		$keterangan = $this->input->post('keterangan');

		// Ambil data awal (optional, kalau ingin log/cek dulu)
		$absen = $this->db->get_where('tbl_absensi', [
			'tanggal' => $tanggal,
			'pin'     => $pin
		])->row();

		if (!$absen) {
			// Jika tidak ada data, buat baru atau return error
			show_error('Data absensi tidak ditemukan');
			return;
		}

		$dataUpdate = [];

		/* ==============================
			PRIORITAS 1 : JAM MANUAL
			============================== */
		if (!empty($jamMasuk) || !empty($jamPulang)) {

			if (!empty($jamMasuk)) {
				$dataUpdate['masuk'] = $jamMasuk . ':00';
			}

			if (!empty($jamPulang)) {
				$dataUpdate['pulang'] = $jamPulang . ':00';
			}

			// Optional: bisa set telat / p_awal kalau mau
		}
		/* ==============================
			PRIORITAS 2 : STATUS / TIDAK HADIR
			============================== */ elseif (!empty($status)) {

			switch ($status) {

				case 'DL-AWAL': // Dinas Luar Awal
					$dataUpdate['masuk'] = 'DLA';
					// optional: update telat = 0
					break;

				case 'DL-AKHIR': // Dinas Luar Akhir
					$dataUpdate['pulang'] = 'DLAK';
					// optional: update p_awal = 0
					break;

				case 'DL-PENUH': // Dinas Luar Penuh
					$dataUpdate['masuk']  = 'DLP';
					$dataUpdate['pulang'] = 'DLP';
					// optional: telat = 0, p_awal = 0
					break;

				default: // Izin / Sakit / Alpha
					$dataUpdate['masuk']  = $status;
					$dataUpdate['pulang'] = $status;
					break;
			}

			// Tambahkan keterangan jika ada
			if (!empty($keterangan)) {
				$dataUpdate['keterangan'] = $keterangan;
			}
		}

		// Jika ada data yang akan diupdate
		if (!empty($dataUpdate)) {
			$this->db->where('tanggal', $tanggal);
			$this->db->where('pin', $pin);
			$this->db->update('tbl_absensi', $dataUpdate);
		}

		// Redirect kembali ke halaman sebelumnya
		redirect($_SERVER['HTTP_REFERER']);
	}


	function ajaxSetujuiIzin()
	{
		$dataPost = $this->input->post('data_post');
		$explod   = explode("/", $dataPost);
		$status_acc = $explod[0];
		$id_izin    = $explod[1];
		$pin        = $explod[2];



		$qry = $this->db->get_where('pengajuan_izin_sakit', array('id' => $id_izin));
		$izinSakit = $qry->result();

		$tanggal 	 = $izinSakit[0]->tanggal;
		$jenis_absen = $izinSakit[0]->jenis_absen;
		$id_pegawai  = $izinSakit[0]->id_pegawai;
		$ket         = $izinSakit[0]->keterangan;


		if ($status_acc == 1) {
			//pengajuan di ACC
			$this->Presensi_model->insertAbsensiIzinSakit($pin, $tanggal, $jenis_absen, $ket);
			$this->db->where('id', $id_izin);
			$this->db->set('status', 1);
			$this->db->update('pengajuan_izin_sakit');
			echo 'Pengajuan izin/sakit telah disetujui';
		} else {
			$this->db->where('id', $id_izin);
			$this->db->set('status', 0);
			$this->db->update('pengajuan_izin_sakit');
			echo 'Pengajuan izin/sakit  tidak disetujui';
		}
	}

	function setujui_pengajuan_dl2($id, $status_acc,  $pin)
	{
		//acc pengajuan DL dari halaman index

		$qry = $this->db->get_where('pengajuan_dinas_luar', array('id' => $id));
		$dinasLuar = $qry->result();

		$jns_dl = $dinasLuar[0]->jns_dl;
		$keterangan = $dinasLuar[0]->keterangan;
		$tanggal = $dinasLuar[0]->tanggal;


		if ($status_acc == 1) {
			$this->Presensi_model->insertAbsensiDL($pin, $tanggal, $jns_dl, $keterangan);

			$this->db->where('id', $id);
			$this->db->set('status', 1);
		} else {
			$this->db->where('id', $id);
			$this->db->set('status', 2);
		}

		$this->db->update('pengajuan_dinas_luar');
		redirect('admin/presensi/index');
		#redirect('admin/presensi/index');
	}


	function setujui_pengajuan_dl($id, $status_acc,  $pin, $id_pegawai)
	{


		$qry = $this->db->get_where('pengajuan_dinas_luar', array('id' => $id));
		$dinasLuar = $qry->result();

		$jns_dl = $dinasLuar[0]->jns_dl;
		$keterangan = $dinasLuar[0]->keterangan;
		$tanggal = $dinasLuar[0]->tanggal;

		if ($status_acc == 1) {
			$this->Presensi_model->insertAbsensiDL($pin, $tanggal, $jns_dl, $keterangan);

			$this->db->where('id', $id);
			$this->db->set('status', 1);
		} else {
			$this->db->where('id', $id);
			$this->db->set('status', 2);
		}

		$this->db->update('pengajuan_dinas_luar');
		redirect('admin/presensi/absensi_raw/' . $pin . '/' . $id_pegawai);
		#redirect('admin/presensi/index');
	}

	function absensi_raw($pin, $id_pegawai)
	{

		$tahun = $this->session->userdata('periode_tahun');
		$bulan = $this->session->userdata('periode_bulan');


		$periode = $tahun . '-' . $bulan;
		$periode = date('Y-m', strtotime($periode));

		$data['data_pegawai'] = $this->Pegawai_model->getDataEditPegawai($id_pegawai);
		$data['absensi'] = $this->Presensi_model->getRawAbensi($pin, $periode);
		$data['pengajuan_dinas_luar'] = $this->Presensi_model->getDataPengajuanDLPerbulan($id_pegawai, $periode);
		$data['data_cuti'] = $this->Presensi_model->getDataCutiPegawai($id_pegawai);
		$this->load->view('admin/presensi/view_absensi_raw', $data);
	}

	// function sinkron_data($pin, $id_pegawai){

	//     $this->Presensi_model->insertDataAbsen($pin);
	// 	$this->session->set_flashdata('message','<strong>Success!!! </strong> Data berhasil disinkron');
	// 	redirect('admin/presensi/absensi_raw/'.$pin.'/'.$id_pegawai);

	// }


	function getDataCutiPegawai()
	{

		$pin = $this->input->post('pin');
		$id_pegawai_absen = $this->input->post('id_pegawai');


		$id_pegawai = $this->Cuti_model->getIdPegawaiByPIN($pin);


		$data['data_cuti'] = $this->Cuti_model->cekCutiPegawai($id_pegawai);
		$data['pin'] = $pin;
		$data['id_pegawai'] = $id_pegawai_absen;

		$this->load->view('admin/presensi/data_cuti_pegawai', $data);
	}



	function ajaxGetCutiPertanggal()
	{
		$tanggal      = $this->input->post('tanggal');
		$id_puskesmas = $this->session->userdata('id_puskesmas');

		$numPegawaiNonPNS = $this->Pegawai_model->numPegawaiPerPuskesmas($id_puskesmas);
		$jumlahNonPNS = count($numPegawaiNonPNS);

		$PegawaiPNS = $this->Cuti_model->getDataPegawaiPNSPerpuskesmas($id_puskesmas);
		$jumlahPNS = count($PegawaiPNS);

		$totalPegawai = $jumlahNonPNS + $jumlahPNS;


		$data_cuti = $getCuti = $this->Cuti_model->getCutiPertanggal($tanggal, $id_puskesmas);
		$numCuti = count($data_cuti);

		$persen = round(($numCuti / $totalPegawai) * 100);

		$hari = getNamahari($tanggal);
		echo '  <h2> ' . $hari . ', ' . format_full($tanggal) . '</h2>


		<table class="table table-bordered text-center">
			<tr>
			  <th>Jumlah Pegawai</th>
			  <th>Pegawai Cuti</th>
			  <th>Persentase</th>
			</tr>
			<tr>
		     	 <td><strong>' . $totalPegawai . '</strong></td>
				 <td><strong>' . count($data_cuti) . '</strong></td>
				 <td><strong>' . $persen . ' %</strong>  </td>
			</tr>

		</table>';

		echo '<table class="table table-hover">';
		for ($i = 0; $i < count($data_cuti); $i++) {
			$status = $data_cuti[$i]->status;
			if ($status == 1) {
				$flag_status = '<div class="badge bg-success">Disetujui</div>';
			} else {
				$flag_status = '<div class="badge bg-warning">Pending</div>';
			}

			echo '
				<tr>
				<td>' . ($i + 1) . '</td>
				<td>
				<a href="' . base_url() . 'admin/cuti/detail_cuti/' . $data_cuti[$i]->id_cuti . '" class="text-dark">
					<strong>' . $data_cuti[$i]->nama . '</strong> <br> ' . $data_cuti[$i]->alasan_cuti . ' <br>
					<small>' . format_view($data_cuti[$i]->tgl_dari) . ' &nbsp;  s/d &nbsp; ' . format_view($data_cuti[$i]->tgl_sampai) . '</small> <br>
					' . $flag_status . '
					</a>
				</td>
				<td><strong>' . $data_cuti[$i]->hari_cuti . ' Hari</strong> </td>
			</tr>

			';
		}
		echo '</table>';
	}


	function send_data_cuti($pin, $id_pegawai, $id_cuti)
	{
		$data_cuti = 	$this->Cuti_model->getDataDetailCuti($id_cuti);
		$list_hari = 	$this->Cuti_model->getListHariCuti($id_cuti);

		$jns_cuti    = $data_cuti[0]->jns_cuti;
		$alasan_cuti = $data_cuti[0]->alasan_cuti;


		for ($i = 0; $i < count($list_hari); $i++) {

			$newArray[] = array(
				'id_pegawai' => $id_pegawai,
				'tanggal' => $list_hari[$i]->tanggal,
				'jns_cuti' => $jns_cuti,
				'keterangan' => $alasan_cuti
			);
		}




		$this->Presensi_model->insertDataCuti($newArray);
		$this->session->set_flashdata('message', '<strong>Success!!! </strong> Data berhasil disimpan');
		redirect('admin/presensi/lihat_absensi/' . $pin . '/' . $id_pegawai);
	}


	function data_rekap($pin, $id_pegawai)
	{

		$data['data_pegawai'] = $this->Presensi_model->getDetPegawai($pin);
		$data['rekap_absensi'] = $this->Presensi_model->getDataRekapAbsensiPegawai($id_pegawai);
		$this->load->view('admin/presensi/data_rekap', $data);
	}
	function ubah_status_absen()
	{
		$id = $this->input->post('id');
		$this->Presensi_model->EditRawAbsen($id);
	}

	function delete_cuti($pin, $id_pegawai, $id_cuti)
	{
		$this->Presensi_model->deleteAbsenCuti($id_cuti);
		$this->session->set_flashdata('message', '<strong>Success!!! </strong> Data cuti berhasil dihapus');
		redirect('admin/presensi/absensi_raw/' . $pin . '/' . $id_pegawai);
	}


	function delete_absensi($tanggal, $pin, $id_pegawai, $status)
	{
		if ($status == 0) {
			//absen masuk

			$this->db->where('pin', $pin);
			$this->db->where('tanggal', $tanggal);
			$this->db->set('masuk', "");
			$this->db->update('tbl_absensi');
		} else {
			//absen pulang
			$this->db->where('pin', $pin);
			$this->db->where('tanggal', $tanggal);
			$this->db->set('pulang', "");
			$this->db->update('tbl_absensi');
		}

		$this->session->set_flashdata('message', '<strong>Success!!! </strong> Data absensi berhasil dihapus');
		redirect('admin/presensi/lihat_absensi_pegawai/' . $id_pegawai . '/' . $pin);
	}

	function delete_absensi_raw()
	{
		$id = $this->input->post('id');

		$this->db->where('id', $id);
		$qry = $this->db->get('import_absen');
		$row = $qry->result();

		$pin = $row[0]->pin;

		$tanggal = $row[0]->tanggal;
		$status  = $row[0]->status;


		$tgl = format_db($tanggal);
		if ($status == 0) {
			//absen masuk

			$this->db->where('pin', $pin);
			$this->db->where('tanggal', $tgl);
			$this->db->set('masuk', "");
			$this->db->update('tbl_absensi');
		} else {
			//absen pulang
			$this->db->where('pin', $pin);
			$this->db->where('tanggal', $tgl);
			$this->db->set('pulang', "");
			$this->db->update('tbl_absensi');
		}

		$this->Presensi_model->deleteRawAbsensi($id);
		echo '<span class="badge bg-light text-muted">DELETED</span>';
	}

	public function generate_shift($pin, $id_pegawai, $jenis_pegawai, $periode)
	{
		$lastDate = date('t', strtotime($periode)); // jumlah hari dalam bulan

		// Ambil semua jadwal shift sebulan (untuk pegawai shift)
		if ($jenis_pegawai != 'non_shift') {
			$jadwal = $this->Presensi_model->getShiftSebulan($id_pegawai, $periode);
			$shiftByTanggal = [];
			foreach ($jadwal as $row) {
				$shiftByTanggal[$row->tanggal] = $row->shift;
			}
		}



		for ($t = 1; $t <= $lastDate; $t++) {

			$tanggal = date('Y-m-d', strtotime("$periode-$t"));
			$day = date('D', strtotime($tanggal));

			// ===== Tentukan shift =====
			if ($jenis_pegawai == 'non_shift') {

				// cek hari libur
				$libur = $this->Presensi_model->cekHariLibur($tanggal);
				if (!empty($libur) || $day == 'Sat' || $day == 'Sun') {
					$shiftKerja = 'OFF';
				} elseif ($day == 'Fri') {
					$shiftKerja = 'REG-JUM';
				} else {
					$shiftKerja = 'REG';
				}
			} else {
				// pegawai shift
				$shiftKerja = isset($shiftByTanggal[$tanggal]) ? $shiftByTanggal[$tanggal] : 'OFF';
			}



			//echo $shiftKerja . ' - ' . $tanggal . '<br>';
			//print_array($shiftKerja);
			//exit;


			// ===== Insert / Update ke tbl_absensi =====
			//$this->Presensi_model->insertShiftPegawai($pin, $tanggal, $shiftKerja, null, null);
			$shiftDetail = $this->Presensi_model->detailShiftByKode($shiftKerja);
			$jamMasukShift = isset($shiftDetail->jam_masuk) ? $shiftDetail->jam_masuk : null;
			$jamPulangShift = isset($shiftDetail->jam_pulang) ? $shiftDetail->jam_pulang : null;

			// Insert ke tbl_absensi
			$this->Presensi_model->insertShiftPegawai(
				$pin,
				$tanggal,
				$shiftKerja,
				null,       // jam real dari mesin
				null,      // jam real dari mesin
				$jamMasukShift,  // jam shift
				$jamPulangShift
			);


			$rekap = $this->Presensi_model->getRekapImportSebulan($pin, $periode);

			foreach ($rekap as $row) {
				$jamMasuk = $row->jam_masuk;
				$jamPulang = $row->jam_pulang;

				// update ke tbl_absensi, shift tetap tidak berubah
				$this->Presensi_model->insertShiftPegawai($pin, $row->tanggal, null, $jamMasuk, $jamPulang);
			}
		}


		$this->session->set_flashdata('message', 'Data shift kerja pegawai berhasil diupdate.');
		//exit;
		redirect('admin/presensi/lihat_absensi_pegawai/' . $id_pegawai . '/' . $pin);
	}



	public function importAbsensi($pin, $periode)
	{
		$rekap = $this->Presensi_model->getRekapImportSebulan($pin, $periode);

		foreach ($rekap as $row) {
			$jamMasuk = $row->jam_masuk;
			$jamPulang = $row->jam_pulang;

			// update ke tbl_absensi, shift tetap tidak berubah
			$this->Presensi_model->insertShiftPegawai($pin, $row->tanggal, null, $jamMasuk, $jamPulang);
		}
	}



	function sinkron_absensi($pin, $id_pegawai, $periode)
	{

		$rekap = $this->Presensi_model->getRekapImportSebulan($pin, $periode);

		foreach ($rekap as $row) {
			$jamMasuk = $row->jam_masuk;
			$jamPulang = $row->jam_pulang;

			// update ke tbl_absensi, shift tetap tidak berubah
			$this->Presensi_model->insertShiftPegawai($pin, $row->tanggal, null, $jamMasuk, $jamPulang);
		}

		redirect('admin/presensi/lihat_absensi_pegawai/' . $id_pegawai . '/' . $pin);
	}


	// 	function generate_shift()
	// {
	//     $periode_bulan = $this->session->userdata('periode_bulan');
	//     $periode_tahun = $this->session->userdata('periode_tahun');

	//     $bulan = $periode_bulan ?: date('m');
	//     $tahun = $periode_tahun ?: date('Y');

	//     $periode = date('Y-m', strtotime($tahun . '-' . $bulan));

	//     $datapost    = $this->input->post('data_post');
	//     $explo       = explode("/", $datapost);
	//     $pin         = $explo[0];
	//     $id_pegawai  = $explo[1];

	//     $lastDate = date('t', strtotime($periode));
	// 		$rekapSebulan = $this->Presensi_model->getRekapImportSebulan($pin, $periode);

	// 		//print_array($rekapSebulan);exit;

	// 		$dataByTanggal = [];
	// 		foreach ($rekapSebulan as $row) {
	// 			$dataByTanggal[$row->tanggal] = $row;
	// 		}

	// 		$lastDate = date('t', strtotime($periode));

	// 		for ($t = 1; $t <= $lastDate; $t++) {

	// 			$tanggal = date('Y-m-d', strtotime($periode . '-' . $t));

	// 			$jamMasuk  = isset($dataByTanggal[$tanggal]) ? $dataByTanggal[$tanggal]->jam_masuk : null;
	// 			$jamPulang = isset($dataByTanggal[$tanggal]) ? $dataByTanggal[$tanggal]->jam_pulang : null;

	// 			// ====== LOGIC SHIFT ======
	// 			if (!$jamMasuk && !$jamPulang) {
	// 				$shiftKerja = 'OFF';
	// 			}
	// 			elseif ($jamMasuk && !$jamPulang) {

	// 				$jam = date('H', strtotime($jamMasuk));

	// 				if ($jam < 9) {
	// 					$shiftKerja = 'PSM';
	// 				} elseif ($jam > 12 && $jam < 15) {
	// 					$shiftKerja = 'SM';
	// 				} elseif ($jam >= 15 && $jam < 18) {
	// 					$shiftKerja = 'SM-RUS';
	// 				} else {
	// 					$shiftKerja = 'M';
	// 				}
	// 			}
	// 			elseif ($jamMasuk && $jamPulang) {

	// 				$jam  = date('H', strtotime($jamMasuk));
	// 				$jam2 = date('H', strtotime($jamPulang));

	// 				if ($jam < 9) {
	// 					$shiftKerja = ($jam2 < 17) ? 'P' : 'PS';
	// 				} elseif ($jam > 13 && $jam < 18) {
	// 					$shiftKerja = 'S';
	// 				} else {
	// 					$shiftKerja = 'M';
	// 				}
	// 			}
	// 			else {
	// 				$shiftKerja = 'L-OFF';
	// 			}

	// 			// 🔥 Insert pakai ON DUPLICATE
	// 			$this->Presensi_model->insertShiftPegawai($pin, $tanggal, $shiftKerja, $jamMasuk, $jamPulang);
	// 		}

	//     redirect('admin/presensi/lihat_absensi_pegawai/' . $id_pegawai . '/' . $pin);
	// }




	function edit_shift_kerja()
	{
		$tanggal      = $this->input->post('tanggal');
		$list_id    = $this->input->post('list_id');
		$id_pegawai   = $this->input->post('id_pegawai');
		$kode_shift   = $this->input->post('kode_shift');


		$data['tanggal'] = $tanggal;
		$data['id_pegawai'] = $id_pegawai;
		$data['list_id'] = $list_id;
		$data['kode_shift'] = $kode_shift;
		$data['data_shift_kerja'] = $this->Presensi_model->getShiftKerja();

		$this->load->view('admin/presensi/list_edit_shift', $data);
	}

	function update_shift_pegawai($pin, $id_pegawai)
	{
		$tgl   = $this->input->post('tanggal');
		$shift_kerja = $this->input->post('shift');

		for ($i = 0; $i < count($tgl); $i++) {
			$tanggal = $tgl[$i];
			$shift   = $shift_kerja[$i];

			$dataAbsensi = $this->Presensi_model->getDataAbsensiHarian($tanggal, $pin);

			if (!empty($dataAbsensi)) {

				$id_absen = $dataAbsensi[0]->id;
				$shift_db = $dataAbsensi[0]->shift;

				if ($shift_db != $shift) {
					//klo shift yang sudah ada ga sama editan

					$JamKerjaShift = $this->Presensi_model->detailShiftByKode($shift);
					$jamMasuk      = $JamKerjaShift->jam_masuk;
					$jamPulang     = $JamKerjaShift->jam_pulang;


					$dataUpdate = array(
						'shift' => $shift,
						'jam_masuk' => $jamMasuk,
						'jam_pulang' => $jamPulang
					);

					$this->db->where('id', $id_absen);
					$this->db->update('tbl_absensi', $dataUpdate);
				}
			}
		}



		$this->session->set_flashdata('message', ' Data shift berhasil disimpan');
		redirect('admin/presensi/lihat_absensi_pegawai/' . $id_pegawai . '/' . $pin);
	}


	function delete_shift($pin, $id_pegawai)
	{
		//hapus semua shift dalam 1 bulan


		$tahun = $this->session->userdata('periode_tahun');
		$bulan = $this->session->userdata('periode_bulan');


		$periode = $tahun . '-' . $bulan;
		$periode = date('Y-m', strtotime($periode));

		$this->Presensi_model->deleteDataShift($id_pegawai, $periode);

		$this->session->set_flashdata('message', '<strong>Success!!! </strong> Data shift telah dihapus');
		redirect('admin/presensi/lihat_absensi/' . $pin . '/' . $id_pegawai);
	}


	function update_rekap_absensi()
	{
		$id_pegawai   = $this->input->post('id_pegawai');
		$data_post   = $this->input->post('data_post');

		$tahun      = $this->session->userdata('periode_tahun');
		$bulan      = $this->session->userdata('periode_bulan');
		$periode 	= $tahun . '-' . $bulan;
		$periode    = date('Y-m', strtotime($periode));

		$cekRekap = $this->Presensi_model->cekDataRekapAbsensi($id_pegawai, $periode);
		if ($cekRekap == 0) {
			//belum ada
			$this->Presensi_model->insertDataRekapAbsensi($id_pegawai, $periode, $data_post);
		} else {
			//udah ada
			$this->Presensi_model->updateDataRekapAbsensi($cekRekap, $data_post);
		}

		return true;
	}

	function delete_absensi_izin_sakit($id, $pin, $id_pegawai)
	{

		$this->Presensi_model->deleteAbsenIzinSakit($id);
		$this->session->set_flashdata('message', '<strong>Success!!! </strong> Data berhasil dihapus');
		redirect('admin/presensi/lihat_absensi/' . $pin . '/' . $id_pegawai);
	}



	function delete_absensi_dl($pin, $id_pegawai, $tgl)
	{

		$tanggal = format_db($tgl);

		$dataDl = $this->Presensi_model->getDataPengajuanDL($id_pegawai, $tanggal);
		$id = $dataDl[0]->id;
		$this->Presensi_model->deleteAbsenDL($id);

		$cekAbsenExist = $this->Presensi_model->cekAbsenExist($tanggal, $pin);
		$id_absen = $cekAbsenExist;
		$newArray = array(
			'masuk' => '',
			'pulang' => '',
			'telat' => 300,
			'p_awal' => 150,
			'keterangan' => ''
		);

		$this->db->where('id', $id_absen);
		$this->db->update('tbl_absensi', $newArray);

		$this->session->set_flashdata('message', '<strong>Success!!! </strong> Data berhasil dihapus');
		redirect('admin/presensi/lihat_absensi_pegawai/' . $id_pegawai . '/' . $pin);
	}


	function DataRekapAbsensi($order_by = 'telat')
	{


		$periode_bulan = $this->session->userdata('periode_bulan');
		$periode_tahun = $this->session->userdata('periode_tahun');

		$periode 	= $periode_tahun . '-' . $periode_bulan;
		$periode    = date('Y-m', strtotime($periode));

		$thn_anggaran = 2024;


		$id_validator = $this->session->userdata('id_pegawai');
		$id_pj_sess = $this->session->userdata('id_pj');


		if ($id_pj_sess != '') {
			$id_validator = $id_pj_sess;
		}


		$data['validator'] = $this->Pegawai_model->getValidator();
		$data['absensiSesuai'] = $this->Presensi_model->countAbsenSesuai($periode, 1);
		$data['absensiBlmSesuai'] = $this->Presensi_model->countAbsenSesuai($periode);
		//$data['pegawai']  = $this->Pegawai_model->getListPegawaiByValidator($id_validator, $thn_anggaran);

		$data['pegawai']  = $this->Pegawai_model->getPegawaiforListingTKD($thn_anggaran);
		$this->load->view('admin/presensi/data_rekap_absensi', $data);
	}

	function lihat_data_rekapan_absensi()
	{
		$thn_anggaran = 2024;
		//$data['pegawai']  = $this->Pegawai_model->getPegawaiforListingTKD($thn_anggaran, 15);
		$id_validator = $this->session->userdata('id_pegawai');
		$id_pj_sess = $this->session->userdata('id_pj');


		if ($id_pj_sess != '') {
			$id_validator = $id_pj_sess;
		}

		$data['pegawai']  = $this->Pegawai_model->getListPegawaiByValidator($id_validator, $thn_anggaran);
		$this->load->view('admin/presensi/lihat_data_rekapan_absensi', $data);
	}

	function importDataAbsensi()
	{
		$this->load->view('admin/presensi/import_absensi');
	}


	public function import_process()
	{
		$data_import   = $this->input->post('data_import');
		$dataParse     = explode("\n", $data_import);

		#print_array($dataParse);

		#$id_puskesmas = $this->session->userdata('id_puskesmas');
		$id_puskesmas = 1;

		for ($i = 0; $i < count($dataParse); $i++) {
			$dataRow = $dataParse[$i];
			$dataRaw = preg_replace('/\s/', '', $dataRow);
			$revString = strrev($dataRaw);

			#echo $revString;
			$revtime    = substr($revString, 2, 8);  // returns "1111"
			$revdate    = substr($revString, 10, 10);  // returns "1111"
			$revPin    = substr($revString, 20, 5);
			$revStatus    = substr($revString, 0, 1);

			$pin  =  strrev($revPin);
			$date =  strrev($revdate);
			$time =  strrev($revtime);
			$status =  strrev($revStatus);

			$dateTime = $date . ' ' . $time;



			$this->Presensi_model->insertDataAbsensiImport($dateTime, $pin, $status);
		}

		echo '<span class="text-success"> <i class="fa fa-check "></i> &nbsp; ' . $i . ' Rows </strong> has been inserted</span>';

		echo '<br><br>
				<a href="' . base_url() . 'masteradmin/home/index">Back to home</a>';
	}

	function lihat_data_absensi_mesin()
	{

		$pin   = $this->input->post('pin');
		$id_pegawai   = $this->input->post('id_pegawai');
		$tahun     = $this->session->userdata('periode_tahun');
		$bulan     = $this->session->userdata('periode_bulan');

		$periode = $tahun . '-' . $bulan;
		$periode = date('Y-m', strtotime($periode));

		$detailPegawai = $this->Presensi_model->getDetPegawai($pin);
		$id_puskesmas  = $detailPegawai[0]->id_puskesmas;
		$shift  = $detailPegawai[0]->shift;


		if ($id_puskesmas == 6) {
			//puskesmas kel Kalibaru
			if ($shift == 1) {
				//klo dia shift berarti bidan RB
				$ket = 'RB';
			} else {
				// pegawai reguler di puskesmas
				$ket = '';
			}
		} else {
			$ket = '';
		}


		$ip_address = $this->Presensi_model->getIpaddressByPuskesmas($id_puskesmas, $ket);
		$getDataAbsensi = $this->Sinkron_model->getDataPresensi($ip_address,  $pin);



		echo '  <table  class="table table-sm table-center text-nowrap table-bordered">

				<tr>
					<th>Tanggal</th>
					<th>Status</th>
				</tr>';



		for ($i = 0; $i < count($getDataAbsensi); $i++) {
			$stringAbsen  = strip_tags($getDataAbsensi[$i]);

			$tgl = substr($stringAbsen, 4, 10);
			$thn_bulan = date('Y-m', strtotime($tgl));

			if ($thn_bulan == $periode) {

				$jamAbsen = substr($stringAbsen, 15, 8);
				$status = substr($stringAbsen, 24, 1);
				$datetime = $tgl . ' &nbsp;&nbsp;&nbsp;&nbsp;' . $jamAbsen;

				$date = date('d', strtotime($tgl));
				if ($date % 2 == 0) {
					$class = "class='bg-info'";
				} else {
					$class = "";
				}


				echo '<tr ' . $class . '>

					   <td>' . $datetime . '</td>
					   <td>' . $status . '</td>
					</tr>';
			}
		}


		echo '</table>';
	}



	function laporan_absensi()
	{
		$data['pegawai'] = $this->Laporan_model->getListPegawai();

		$this->load->view('admin/laporan/index', $data);
	}

	function update_absensi()
	{


		$tahun     = $this->session->userdata('periode_tahun');
		$bulan     = $this->session->userdata('periode_bulan');

		$periode = $tahun . '-' . $bulan;
		$periode = date('Y-m', strtotime($periode));

		$pin   = $this->input->post('pin');
		$id_pegawai   = $this->input->post('id_pegawai');

		$detailPegawai = $this->Presensi_model->getDetPegawai($pin);
		$id_puskesmas  = $detailPegawai[0]->id_puskesmas;
		$shift  = $detailPegawai[0]->shift;


		if ($id_puskesmas == 6) {
			//puskesmas kel Kalibaru
			if ($shift == 1) {
				//klo dia shift berarti bidan RB
				$ket = 'RB';
			} else {
				// pegawai reguler di puskesmas
				$ket = '';
			}
		} else {
			$ket = '';
		}


		$ip_address = $this->Presensi_model->getIpaddressByPuskesmas($id_puskesmas, $ket);

		$getDataAbsensi = $this->Sinkron_model->getDataPresensi($ip_address,  $pin);
		#print_array($getDataAbsensi);

		for ($i = 0; $i < count($getDataAbsensi); $i++) {
			$stringAbsen  = strip_tags($getDataAbsensi[$i]);

			$tgl = substr($stringAbsen, 4, 10);
			$thn_bulan = date('Y-m', strtotime($tgl));

			if ($thn_bulan == $periode) {

				$jamAbsen = substr($stringAbsen, 15, 8);
				$status = substr($stringAbsen, 24, 1);
				$datetime = $tgl . ' ' . $jamAbsen;

				$this->Presensi_model->insertAbsensi($datetime, $pin, $status);
			}
		}

		#echo $ip_address ;
		echo '<div class="alert alert-success">Data Absensi berhasil ditarik dari mesin absensi</div> <br>

		<a href="' . base_url() . 'admin/presensi/lihat_absensi/' . $pin . '/' . $id_pegawai . '" class="btn btn-info">Close</a>';

		#$this->session->set_flashdata('message','<strong>Success!!! </strong> Data berhasil dihapus');
		#redirect('admin/presensi/lihat_absensi/'.$pin.'/'.$id_pegawai);

	}


	function getDataCuti()
	{
		$url           = 'https://e-cuti.puskesmascilincing.id/cuti/test_api';
		$ch            = curl_init($url);

		$jsonData = array(
			'nip' => '1020',
			'data_cuti' => '3 hari'

		);

		//Encode the array into JSON.
		$jsonDataEncoded = json_encode($jsonData);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);


		$obj = json_decode($result);

		print_array($obj);
	}


	function clear_duplicate($tanggal, $pin, $id_pegawai)
	{
		$tanggal  = format_db($tanggal);
		$sql = "SELECT * FROM ts_absensi WHERE tanggal like '$tanggal%' AND pin = '$pin' ORDER BY tanggal ASC";
		$qry = $this->db->query($sql);
		$row = $qry->result();


		for ($i = 0; $i < count($row); $i++) {
			$tgl_absen = $row[$i]->tanggal;
			$id = $row[$i]->id;


			$checkData = $this->Presensi_model->cekAbsensi($tgl_absen, $pin);


			if ($checkData > 1) {
				$this->Presensi_model->deleteRawAbsensi($id);
			}
			echo $checkData . '<br>';
		}

		redirect('admin/presensi/absensi_raw/' . $pin . '/' . $id_pegawai);
	}

	function pengajuan_dinas_luar_pegawai()
	{

		$id_pegawai    = $this->session->userdata('id_pegawai');
		$data['pengajuan_dinas_luar'] = $this->Presensi_model->pengajuanDinasLuarPegawai($id_pegawai);
		$this->load->view('dashboard/pengajuan_dinas_luar_pegawai', $data);
		#print_array($data['pengajuanDL'] );
	}



	function purgeDataAbsensi($id_pegawai, $pin = 0)
	{

		$tahun      = $this->session->userdata('periode_tahun');
		$bulan      = $this->session->userdata('periode_bulan');
		$periode 	= $tahun . '-' . $bulan;
		$periode    = date('Y-m', strtotime($periode));



		//$tanggal = '2024-07';
		$sql = "SELECT * FROM tbl_absensi WHERE tanggal like '$periode%' AND pin = '$pin' ORDER BY tanggal ASC";
		$qry = $this->db->query($sql);
		$row = $qry->result();


		$tglAwal = $row[0]->tanggal;

		echo 'ini tanggal awal = ' . $tglAwal;
		for ($i = 0; $i < count($row); $i++) {

			$tanggalAbsen = $row[$i]->tanggal;
			$id = $row[$i]->id;


			//echo '<br>ini tanggal selanjutnya = ' . $tanggalAbsen;

			if ($tglAwal == $tanggalAbsen) {
				//hapus

				echo 'ini hapus';
				$this->db->where('id', $id);
				$this->db->delete('tbl_absensi');
			}
			$tglAwal = $tanggalAbsen;
		}
		//print_array($row);

		redirect('admin/presensi/update_absensi_pegawai/' . $id_pegawai . '/' . $pin);
	}
}
