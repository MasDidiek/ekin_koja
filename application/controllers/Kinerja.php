<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Kinerja extends CI_Controller
{
	public function __construct()
	{

		parent::__construct();
		$this->Auth_model->cekAuthLogin();
		$this->load->model('Laporan_model');
		$this->load->helper('form');
	}

	function index()
	{
		$id_pegawai = $this->session->userdata('id_pegawai');

		$periode_bulan = $this->session->userdata('periode_bulan');
		$periode_tahun = $this->session->userdata('periode_tahun');

		if ($periode_bulan == '') {
			$bulan = date('m');
			$tahun = date('Y');
			$this->session->set_userdata('periode_bulan', $bulan);
			$this->session->set_userdata('periode_tahun', $tahun);
		} else {
			$bulan = $periode_bulan;
			$tahun = $periode_tahun;
		}


		$data['dataAktifitasPegawai'] = $this->Kinerja_model->getAktifitasPegawai($id_pegawai);


		redirect('kinerja/kalender');

		//$this->load->view('kinerja/main', $data);
	}

	function kalender()
	{
		$bulan = $this->input->get('bulan') ?: date('m');
		$tahun = $this->input->get('tahun') ?: date('Y');
		$id_pegawai = $this->session->userdata('id_pegawai');

		// timestamp awal bulan
		$firstDay = strtotime($tahun . '-' . $bulan . '-01');

		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$data['jumlah_hari'] = date('t', $firstDay);
		$data['hari_pertama'] = date('N', $firstDay); // 1 (Senin) - 7 (Minggu)

		// prev & next
		$data['prev_bulan'] = date('m', strtotime('-1 month', $firstDay));
		$data['prev_tahun'] = date('Y', strtotime('-1 month', $firstDay));
		$data['next_bulan'] = date('m', strtotime('+1 month', $firstDay));
		$data['next_tahun'] = date('Y', strtotime('+1 month', $firstDay));

		// ambil data kinerja
		$awal  = sprintf('%04d-%02d-01', $tahun, $bulan);
		$akhir = date('Y-m-t', strtotime($awal));
		$this->db->select('
				tgl,
				SUM(total) AS total_menit,
				MAX(status) AS status_max,
				MIN(status) AS status_min
			');
		$this->db->from('ts_kinerja');
		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->where('tgl >=', $awal);
		$this->db->where('tgl <=', $akhir);
		$this->db->group_by('tgl');


		$query = $this->db->get()->result();

		// ubah jadi array [tanggal => total]
		$kinerja = [];

		foreach ($query as $row) {

			// default hijau
			$bg = 'bg-success';

			if ($row->status_max == 2) {
				$bg = 'bg-danger';
			} elseif ($row->status_min == 0) {
				$bg = 'bg-warning';
			}

			$kinerja[$row->tgl] = [
				'total' => $row->total_menit,
				'bg'    => $bg
			];
		}


		$periode = date('Y-m', strtotime($akhir));

		$totalInput   = $this->Kinerja_model->getSummaryInput($id_pegawai, $periode);
		$disetujui    = $this->Kinerja_model->getSummaryDisetujui($id_pegawai, $periode);

		if (!empty($totalInput)) {
			$jumlahinput =  $totalInput->jumlah;
			$menitinput =  $totalInput->menit;
		} else {
			$jumlahinput =  0;
			$menitinput =  0;
		}


		if (!empty($disetujui)) {
			$jumlahDisetujui =  $disetujui->jumlah;
			$menitDisetujui =  $disetujui->menit;
		} else {
			$jumlahDisetujui =  0;
			$menitDisetujui =  0;
		}

		$data['summary'] = [
			'total_input' => [
				'jumlah' => $jumlahinput,
				'menit'  => $menitinput
			],
			'disetujui' => [
				'jumlah' =>  $jumlahDisetujui,
				'menit'  =>  $menitDisetujui
			]
		];

		$data['kinerja'] = $kinerja;

		$this->load->view('kinerja/kalender', $data);
	}

	public function view_form_input_aktifitas()
	{
		$data['tgl'] = $this->input->post('tgl');
		$this->load->view('kinerja/form_input', $data);
	}

	public function view_list_input_aktifitas()
	{
		$tgl = $this->input->post('tgl');
		$this->db->select('a.*, b.nama_kegiatan as indikator');
		$this->db->where('tgl', $tgl);
		$this->db->where('id_pegawai', $this->session->userdata('id_pegawai'));
		$this->db->from('ts_kinerja a');
		$this->db->join('mst_indikator_kegiatan b', 'a.id_indikator = b.id', 'left');

		$data['list'] = $this->db->get()->result();

		$data['tgl'] = $tgl;


		$this->load->view('kinerja/list', $data);
	}



	function getInputanAktifitas()
	{
		$id_pegawai = $this->session->userdata('id_pegawai');
		$tgl        = $this->input->post('tanggal');

		$detail_pegawai   = $this->Pegawai_model->getDataEditPegawai($id_pegawai);
		$nip = $detail_pegawai[0]->nip;
		$pin = substr($nip, -4);


		$tanggal = format_db($tgl);
		$data['dataAktifitas'] = $this->Kinerja_model->getDataInputAktifitas($id_pegawai, $tanggal);
		$data['absensiHarian'] = $this->Presensi_model->getDataAbsensi($pin, $tanggal);
		$data['tanggal'] = $tanggal;

		$this->load->view('kinerja/view_inputan_aktifitas', $data);
	}

	function getDataEditAktifitas()
	{

		$id = $this->input->post('id');

		$data['dataAktifitas'] = $this->Kinerja_model->getDataEditAktifitas($id);
		$this->load->view('kinerja/view_edit_aktifitas', $data);
	}

	function cekTanggalAktifitas()
	{
		$tanggal        = $this->input->post('tanggal');
		//echo 'allowed';
		$bulanNow       = date('m');
		$bulanAktifitas = date('m', strtotime($tanggal));
		//echo 'allowed';

		//print_array($this->session->userdata());

		$id_pegawai = $this->session->userdata('id_pegawai');

		$tanggal = format_db($tanggal);
		$cekCuti       = $this->Cuti_model->cekCutiPegawai($tanggal, $id_pegawai);

		$cekIzinSakit  = $this->Cuti_model->cekIzinSakitPegawai($tanggal, $id_pegawai);


		if (count($cekCuti) > 0) {
			echo 'restricted3';
			exit;
		}

		if (count($cekIzinSakit) > 0) {
			echo 'restricted4';
			exit;
		}

		$tgl_now = date('d');

		if ($bulanAktifitas < $bulanNow) {
			if ($tgl_now < 6) {
				echo 'allowed';
			} else {
				echo 'allowed';
			}
		} else {
			echo 'allowed';
		}
	}



	function ajaxSearchIndikator()
	{
		$keyword = $this->input->post('keyword');
		$sql = "Select kode_subkegiatan, nama_kegiatan, satuan FROM mst_indikator_kegiatan WHERE nama_kegiatan like '%$keyword%' AND kode_subkegiatan != 0";
		$qry = $this->db->query($sql);
		$row = $qry->result();
		for ($i = 0; $i < count($row); $i++) {
			$nama_kegiatan = $row[$i]->nama_kegiatan;
			$satuan = $row[$i]->satuan;
			$kode_subkegiatan = $row[$i]->kode_subkegiatan;
			echo '<div class="list-indikator" id="' . $kode_subkegiatan . '-+-' . $nama_kegiatan . '"> ' . $nama_kegiatan . ' <br>  Satuan : <strong>' . $satuan . '</strong> </div>';
		}

		echo '<script>
				
				$(".list-indikator").click(function(){
					$("#ajaxlist_indikator").hide();
					var data_indikator = $(this).attr("id");
					var pecah = data_indikator.split("-+-");
					var kode = pecah[0];
					var nama_indikator = pecah[1];
					$("#indikator").val(nama_indikator);
				});


		  </script>';
	}

	function ajaxGetKeteranganAktifitas()
	{
		$id_pegawai = $this->session->userdata('id_pegawai');
		$sql = "Select ket FROM ts_kinerja WHERE id_pegawai = '$id_pegawai' GROUP BY ket";
		$qry = $this->db->query($sql);
		$row = $qry->result();

		for ($i = 0; $i < count($row); $i++) {
			$ket = $row[$i]->ket;

			echo '<div class="list-keterangan" id="' . $ket . '"> ' . $ket . '</div>';
		}

		echo '<script>
				
				$(".list-keterangan").click(function(){
					$("#list_keterangan").hide();
					var keterangan = $(this).attr("id");
		
					$("#keterangan").val(keterangan);
				

				});


		  </script>';
	}

	function ajaxGetFrequentAktifitas()
	{
		$id_pegawai = $this->session->userdata('id_pegawai');
		$sql = "Select nama_kegiatan, waktu_efektif FROM ts_kinerja WHERE id_pegawai = '$id_pegawai' GROUP BY nama_kegiatan ";
		$qry = $this->db->query($sql);
		$row = $qry->result();

		for ($i = 0; $i < count($row); $i++) {
			$nama_kegiatan = $row[$i]->nama_kegiatan;
			$waktu = $row[$i]->waktu_efektif;

			echo '<div class="list-aktifitas" id="' . $nama_kegiatan . '--+--' . $waktu . '"> ' . $nama_kegiatan . ' <br>  waktu : <strong>' . $waktu . '</strong> menit</div>';
		}

		echo '<script>
				
				$(".list-aktifitas").click(function(){
					$("#ajaxlist_aktifitas").hide();
					var data_aktifitas = $(this).attr("id");
					var pecah = data_aktifitas.split("--+--");
					var nama_aktifitas = pecah[0];
					var waktu_efektif = pecah[1];
					$("#aktifitas").val(nama_aktifitas);
					$("#waktu_efektif").val(waktu_efektif);

					$("#jam_mulai").focus();

				});


		  </script>';
	}

	function ajaxSearchAktifitas()
	{

		$keyword = $this->input->post('keyword');
		$sql = "Select nama_kegiatan, waktu FROM mst_kegiatan WHERE nama_kegiatan like '%$keyword%'";
		$qry = $this->db->query($sql);
		$row = $qry->result();

		for ($i = 0; $i < count($row); $i++) {
			$nama_kegiatan = $row[$i]->nama_kegiatan;
			$waktu = $row[$i]->waktu;

			echo '<div class="list-aktifitas" id="' . $nama_kegiatan . '--+--' . $waktu . '"> ' . $nama_kegiatan . ' <br>  waktu : <strong>' . $waktu . '</strong> menit</div>';
		}

		echo '<script>
				
				$(".list-aktifitas").click(function(){
					$("#ajaxlist_aktifitas").hide();
					var data_aktifitas = $(this).attr("id");
					var pecah = data_aktifitas.split("--+--");
					var nama_aktifitas = pecah[0];
					var waktu_efektif = pecah[1];
					$("#aktifitas").val(nama_aktifitas);
					$("#waktu_efektif").val(waktu_efektif);

					$("#jam_mulai").focus();

				});


		  </script>';
	}

	// function insert_aktifitas()
	// {
	// 	$action = $this->input->post('action');
	// 	$id_aktifitas = $this->input->post('id_aktifitas');


	// 	if ($id_aktifitas == '') {
	// 		$this->Kinerja_model->insertAktifitas();
	// 		echo 'aktifitas berhasil disimpan';
	// 	} else {
	// 		$this->Kinerja_model->updateAktifitas($id_aktifitas);
	// 		echo 'aktifitas berhasil diubah';
	// 	}

	// 	$tgl        = $this->input->post('tanggal');
	// 	$periode    = date('Y-m', strtotime($tgl));
	// 	$id_pegawai = $this->session->userdata('id_pegawai');
	// 	$jmlhInput  = $this->Kinerja_model->getJumlahInputPerBulan($id_pegawai, $periode);

	// 	$cekRekapInput = $this->Kinerja_model->rekap_input_kinerja($id_pegawai, $periode);
	// 	if ($cekRekapInput == 0) {
	// 		$newData = array(
	// 			'id_pegawai' => $id_pegawai,
	// 			'periode' => $periode,
	// 			'total_input' => $jmlhInput,
	// 			'disetujui' => 0,
	// 			'ditolak' => 0
	// 		);

	// 		$this->db->insert('rekap_input_kinerja', $newData);
	// 	} else {
	// 		$id = $cekRekapInput;
	// 		$this->db->where('id', $id);
	// 		$this->db->set('total_input',  $jmlhInput);
	// 		$this->db->update('rekap_input_kinerja');
	// 	}
	// }

	public function insert_aktifitas()
	{
		$id_pegawai = $this->session->userdata('id_pegawai');
		$tgl        = $this->input->post('tanggal');
		$periode    = date('Y-m', strtotime($tgl));

		$id_aktifitas = $this->input->post('id_aktifitas');

		if ($id_aktifitas == '') {
			$this->Kinerja_model->insertAktifitas();
		} else {
			$this->Kinerja_model->updateAktifitas($id_aktifitas);
		}

		// 🔹 total per tanggal (buat kalender)
		$totalTanggal = $this->Kinerja_model
			->getTotalMenitPerTanggal($id_pegawai, $tgl);

		// 🔹 summary bulan
		$totalInput = $this->Kinerja_model
			->getSummaryInput($id_pegawai, $periode);

		$disetujui = $this->Kinerja_model
			->getSummaryDisetujui($id_pegawai, $periode);

		echo json_encode([
			'status' => true,
			'tgl' => $tgl,
			'calendar' => [
				'total_menit' => $totalTanggal
			],
			'summary' => [
				'total_input' => [
					'jumlah' => isset($totalInput->jumlah) ? $totalInput->jumlah : 0,
					'menit'  => isset($totalInput->menit) ? $totalInput->menit : 0

				],
				'disetujui' => [
					'jumlah' => isset($disetujui->jumlah) ? $disetujui->jumlah : 0,
					'menit'  => isset($disetujui->menit) ? $disetujui->menit : 0

				]
			]
		]);
	}



	function ajaxDeleteAktifitas()
	{
		$id_aktifitas = $this->input->post('id');

		$this->db->where('id', $id_aktifitas);
		$this->db->delete('ts_kinerja');
		echo 'aktifitas telah dihapus';
	}


	function hitung_volume()
	{
		$waktu_efektif = $this->input->post('waktu_efektif');
		$jam_mulai = $this->input->post('jam_mulai');
		$jam_selesai = $this->input->post('jam_selesai');

		$to_time   = strtotime($jam_mulai);
		$from_time = strtotime($jam_selesai);
		$diff      = round(abs($to_time - $from_time) / 60, 2);


		$wktu = number_format($diff / $waktu_efektif, 2);

		$expl = explode(".", $wktu);
		$ex1  = $expl[0];
		$ex2  = $expl[1];

		if ($ex2 < 60) {
			$volume = $ex1;
		} else {

			$volume = $ex1 + 1;
		}

		echo $volume;
	}





	function tarik_data_aktifitas()
	{
		$nip = $this->session->userdata('nip');
		$id_pegawai = $this->session->userdata('id_pegawai');

		$data_ekin = $this->Kinerja_model->getIDPegawaiekin($nip);

		$id_pegawai_ekin = $data_ekin[0]->id_pegawai;


		$getInputan = $this->Kinerja_model->getInputan($id_pegawai_ekin);


		if (count($getInputan) > 0) {
			foreach ($getInputan as $akt) {

				$tgl = $akt->tgl;
				$jns_kegiatan = $akt->jns_kegiatan;
				$id_kegiatan = $akt->id_kegiatan;
				$jam_mulai = $akt->jam_mulai;
				$jam_selesai = $akt->jam_selesai;
				$volume = $akt->volume;
				$ket  = $akt->ket;
				$nama_kegiatan  = $akt->nama_kegiatan;
				$waktu  = $akt->waktu;

				$total = $waktu * $volume;


				$new_data = array(
					'id_pegawai' => $id_pegawai,
					'tgl' => $tgl,
					'jns_kegiatan' => $jns_kegiatan,
					'id_indikator' => 0,
					'nama_kegiatan' => $nama_kegiatan,
					'jam_mulai' => $jam_mulai,
					'jam_selesai' => $jam_selesai,
					'volume' => $volume,
					'waktu_efektif' => $waktu,
					'total' =>  $total,
					'ket' =>  $ket
				);

				$this->db->insert('ts_kinerja', $new_data);
			}



			echo '
			<h3>Success tarik data kinerja</h3>
			<a href="' . base_url() . 'kinerja/index">Kembali</a>';
		} else {
			echo '
			<h3>Gagal Tarik data</h3>
			<a href="' . base_url() . 'kinerja/index">Kembali</a>';
		}
	}



	// function delete_aktifitas($id_pegawai)
	// {
	// 	$sql = "SELECT id FROM ts_kinerja where id_pegawai = $id_pegawai AND tgl like '2024-01%'";
	// 	$qry = $this->db->query($sql);
	// 	$row = $qry->result();

	// 	for ($i = 0; $i < count($row); $i++) {
	// 		$this->db->where('id', $row[$i]->id);
	// 		$this->db->delete('ts_kinerja');
	// 	}
	// 	#print_array($row);


	// 	$this->session->set_flashdata('message', '<strong>Success!!! </strong> Data aktifitas  telah dihapus');
	// 	redirect('admin/pegawai/data_pegawai/non_pns');
	// }

	public function delete_aktifitas()
	{
		$id  = $this->input->post('id');
		$tgl = $this->input->post('tgl');

		$this->db->where('id', $id)->delete('ts_kinerja');

		$id_pegawai = $this->session->userdata('id_pegawai');
		$periode    = date('Y-m', strtotime($tgl));

		// total per tanggal
		$totalTanggal = $this->Kinerja_model->getTotalMenitPerTanggal($id_pegawai, $tgl);

		// summary
		$totalInput = $this->Kinerja_model->getSummaryInput($id_pegawai, $periode);
		$disetujui  = $this->Kinerja_model->getSummaryDisetujui($id_pegawai, $periode);

		echo json_encode([
			'status' => true,
			'tgl' => $tgl,
			'calendar' => [
				'total' => isset($totalTanggal->total) ? $totalTanggal->total : 0,
				'bg'    => isset($totalTanggal->bg) ? $totalTanggal->bg : ''
			],
			'summary' => [
				'total_input' => [
					'jumlah' => isset($totalInput->jumlah) ? $totalInput->jumlah : 0,
					'menit'  => isset($totalInput->menit) ? $totalInput->menit : 0
				],
				'disetujui' => [
					'jumlah' => isset($disetujui->jumlah) ? $disetujui->jumlah : 0,
					'menit'  => isset($disetujui->menit) ? $disetujui->menit : 0
				]
			]
		]);
	}

	function capaian()
	{

		$id_pegawai = $this->session->userdata('id_pegawai');
		$nip  = $this->session->userdata('nip');

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
		$periode = date('Y-m', strtotime($periode));;



		$data['detail_pegawai']   = $this->Pegawai_model->getDetailPegawai($id_pegawai);
		$data['dataRekap'] = $this->Presensi_model->getRekapAbsensiPegawai($id_pegawai, $periode);
		$data['rekapTKD'] = $this->Laporan_model->getRekapTKDPegawai($nip, $periode);

		$data['master_cuti'] = $this->Master_model->getlistCuti();
		$this->load->view('kinerja/capaian_kinerja', $data);
	}

	function renkin()
	{

		$id_pegawai = $this->session->userdata('id_pegawai');
		$nip  = $this->session->userdata('nip');

		$data['renkin'] = $this->Kinerja_model->getDataRenkinPegawai($nip);
		$this->load->view('kinerja/renkin', $data);
	}
}
