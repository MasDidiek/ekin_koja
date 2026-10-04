<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Laporan_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}




	function getListPegawai()
	{
		$thn_anggaran = '2024';
		$this->db->order_by('nama', 'ASC');
		$this->db->select('nama, id_pegawai, nip');
		$this->db->from('mst_pegawai');
		$this->db->where('tahun_anggaran', $thn_anggaran);
		$this->db->where('jns_pegawai', 'non_pns');

		$query = $this->db->get();
		return $query->result();
	}




	function getRekapTelat($jns_absensi_filter, $periode, $id_pegawai = 0)
	{


		$this->db->select($jns_absensi_filter);
		$this->db->from('ts_rekap_absensi');
		$this->db->where('periode', $periode);
		$this->db->where('id_pegawai', $id_pegawai);
		$query = $this->db->get();
		$row =  $query->result();

		if (!empty($row)) {

			if ($jns_absensi_filter == 'telat') {
				$telat = $row[0]->telat;
			} else if ($jns_absensi_filter == 'izin') {
				$telat = $row[0]->izin;
			} else if ($jns_absensi_filter == 'sakit') {
				$telat = $row[0]->sakit;
			} else {
				$telat = $row[0]->cuti;
			}
		} else {
			$telat = 0;
		}

		return $telat;
	}


	function getCapaianKinerjaPegawai($nip, $periode)
	{
		$this->db->select('total_capaian');
		$qry = $this->db->get_where('ts_rekap_capaian', array('nip' => $nip, 'periode' => $periode));
		$row = $qry->result();

		if (count($row) > 0) {
			$total_capaian = $row[0]->total_capaian;
		} else {
			$total_capaian = 0;
		}

		return $total_capaian;
	}

	function getListingTKD($periode)
	{

		$this->db->select('*');
		$this->db->from('ts_rekap_tkd');
		$this->db->where('periode', $periode);
		$query = $this->db->get();
		return $query->result();
	}


	function getRekapTKDPegawai($nip, $periode)
	{

		$this->db->select('*');
		$this->db->from('ts_rekap_tkd');
		$this->db->where('nip', $nip);
		$this->db->where('periode', $periode);
		$query = $this->db->get();
		return $query->result();
	}


	function potongan_thr()
	{

		$this->db->select('*');
		$this->db->from('pot_thr');
		$query = $this->db->get();
		$row = $query->result();

		return $row;
	}

	function getPotonganTHR($id_pegawai)
	{

		$this->db->select('*');
		$this->db->from('pot_thr');
		$this->db->where('id_pegawai', $id_pegawai);
		$query = $this->db->get();
		$row = $query->result();

		return $row;
	}



	function getDataPegawai_detail()
	{

		$this->db->select('*');
		$this->db->from('mst_pegawai_detail');
		$this->db->limit(400, 0);
		$query = $this->db->get();
		$row = $query->result();

		return $row;
	}

	function getDataTblDetail($id_pegawai)
	{

		$this->db->select('*');
		$this->db->from('mst_pegawai_detail');
		$this->db->where('id_pegawai2', $id_pegawai);
		$query = $this->db->get();
		$row = $query->result();

		return $row;
	}

	function getDataPajak($nama)
	{

		$this->db->select('*');
		$this->db->from('tbl_import_pajak');
		$this->db->where('nama', $nama);
		$query = $this->db->get();
		$row = $query->result();


		return $row;
	}



	function getDendaSTR($id_pegawai, $bulan, $tahun)
	{
		$bulanTahun = $bulan . '-' . $tahun;
		$this->db->select('*');
		$this->db->from('ts_penambahan');
		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->where('debet_kredit', 2);
		$this->db->where('bulan_tahun', $bulanTahun);
		//$this->db->where('Denda 15% STR/SIP Kadaluarsa/tidak ada');
		$query = $this->db->get();
		$row = $query->result();


		return $row;
	}



	function cekPenambahPengurang($id_pegawai, $bulan, $tahun)
	{

		$bulanTahun = $bulan . '-' . $tahun;

		$this->db->select('*');
		$this->db->from('ts_penambahan');
		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->where('bulan_tahun', $bulanTahun);
		$query = $this->db->get();
		$row = $query->result();


		return $row;
	}

	function createDataDetailPegawai($id_pegawai, $nama, $nik, $jabatan, $tgl_masuk, $status, $Pendidikan)
	{

		$array = array(
			'id_pegawai' => $id_pegawai,
			'id_pegawai2' => $id_pegawai,
			'nama' => $nama,
			'nik' => $nik,
			'jabatan' => $jabatan,
			'pendidikan' => $Pendidikan,
			'tgl_masuk' => $tgl_masuk,
			'status' => $status
		);


		$this->db->insert('mst_pegawai_detail', $array);
		return true;
	}


	function createDataPerhitunganTKD($id_pegawai)
	{

		$array = array(
			'id_pegawai' => $id_pegawai,
			'gaji_pokok' => 0,
			'pengali' => 0,
			'total' => 0,
			'bpjs_kes' => 0,
			'bpjs_kerja' => 0
		);


		$this->db->insert('perhitungan_tkd', $array);
		return true;
	}



	function cekDataTempTkd($id_pegawai, $bulan, $tahun)
	{

		$this->db->select('id');
		$this->db->from('ts_temp_tkd');
		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $tahun);
		$query = $this->db->get();
		$row = $query->result();


		return $row;
	}

	function updateTableRekapTKD($id_pegawai)
	{

		$tahun 		 = $this->session->userdata('periode_tahun');
		$bulan 		 = $this->session->userdata('periode_bulan');
		$totalJam    = $this->master_model->getTotalJamkerjaPerbulan($bulan, $tahun);
		$rekap_tkd   = $this->master_model->getDataRekapTKD($id_pegawai, $bulan, $tahun);
		$perilaku   = $this->master_model->getPenilaianPerilaku($id_pegawai, $bulan, $tahun);


		$id 		 = $rekap_tkd[0]->id;
		$cuti 		 = $rekap_tkd[0]->cuti;
		$izin 		 = $rekap_tkd[0]->izin;
		$sakit 		 = $rekap_tkd[0]->sakit;
		$telat 		 = $rekap_tkd[0]->telat;
		$total_menit = $rekap_tkd[0]->total_menit;
		$pdp 		 = $rekap_tkd[0]->pdp;

		$serapan 	 = SERAPAN;

		$totalMenitIzin  = $izin * 300;
		$totalMenitSakit = $sakit * 300;
		$totalMenitCuti  = $cuti * 300;
		$totalMenitPDP  = $pdp * 300;

		$waktuEfektif  = $totalJam - $total_menit;

		$tgl_dari        = $tahun . '-' . $bulan . '-01';
		$LastDate        = date('t', strtotime($tgl_dari));
		$tgl_sampai      = $tahun . '-' . $bulan . '-' . $LastDate;
		$input_accept    = $this->master_model->countTotalInputKinerja($id_pegawai, $tgl_dari, $tgl_sampai, 1);

		$jumlahAktifitas = $input_accept + $totalMenitCuti + $totalMenitPDP;

		$min = $waktuEfektif;
		if ($waktuEfektif > $jumlahAktifitas) {
			$min = $input_accept;
		}


		$nilaiAktifitas  = round(($min / $totalJam) * 100, 2);
		$AktifitasBobot  = round(($nilaiAktifitas * 70) / 100, 2);

		$totalCapaian = $AktifitasBobot + $serapan + $perilaku;


		$newArray =  array(
			'perilaku'  => $perilaku,
			'bobot_aktifitas'  => $AktifitasBobot,
			'serapan'  => $serapan,
			'total'  => $totalCapaian,
		);
		$this->db->where('id', $id);
		$this->db->update('ts_rekap_tkd', $newArray);

		return true;
	}

	function updateDataLaporanPerPegawai($id_pegawai)
	{
		$tahun = $this->session->userdata('periode_tahun');
		$bulan = $this->session->userdata('periode_bulan');
		$bpjs_kes_val      = 0;
		$bpjs_kerja_val    = 0;
		$today 			   = date('Y-m-d');
		$pph21      	   = 0.05; //pph21
		$bpjskes    	   = 0; //bpjskes
		$jamsostek  	   = 0; //jamsostek

		$totalMenit 	   = 0;

		$totalPPH 		   = 0;
		$totalBPJSKES      = 0;
		$totalTKDALL       = 0;
		$totalTKDPOKOK     = 0;
		$date_update       = date('Y-m-d H:i:s');
		$totalJam          = $this->master_model->getTotalJamkerjaPerbulan($bulan, $tahun);
		$data_pegawai      = $this->master_model->detailPegawai($id_pegawai);

		$nama 		       = $data_pegawai[0]->nama;
		$jabatan 		   = $data_pegawai[0]->jabatan;
		$status_kerja 	   = $data_pegawai[0]->status_kerja;

		$gp 	           = $data_pegawai[0]->gaji_pokok;
		$pengali           = $data_pegawai[0]->pengali;

		$total_gp          = $gp * $pengali;



		$data_pegawai2     = $this->Laporan_model->getDataDetailPegawai($id_pegawai);
		$tgl_masuk 		   = $data_pegawai2[0]->tgl_masuk;

		$masaKerja         = datediff('m', $tgl_masuk, $today); //dalam hari

		$getRakapTKD = $this->master_model->getDataRekapTKD($id_pegawai, $bulan, $tahun);
		if (!empty($getRakapTKD)) {
			$nilaiAktifitas  = $getRakapTKD[0]->nilai_aktifitas;
			$bobot_aktifitas = $getRakapTKD[0]->bobot_aktifitas;
			$perilaku 		 = $getRakapTKD[0]->perilaku;
			$serapan 		 = $getRakapTKD[0]->serapan;
			$cuti		     = $getRakapTKD[0]->cuti;
			$izin 			 = $getRakapTKD[0]->izin;
			$sakit 		 	 = $getRakapTKD[0]->sakit;
			$telat 		 	 = $getRakapTKD[0]->telat;
			$totalTelat 	 = $getRakapTKD[0]->total_menit;
		} else {
			$nilaiAktifitas  = 0;
			$bobot_aktifitas = 0;
			$perilaku 		 = 0;
			$serapan 		 = 0;
			$cuti		     = 0;
			$izin 			 = 0;
			$sakit 		 	 = 0;
			$telat 		 	 = 0;
			$totalTelat 	 = 0;
		}


		if ($status_kerja == 1) {
			$total   = $bobot_aktifitas + $perilaku + $serapan; //total capaian

			if ($id_pegawai == 391) {
				$total = 0;
			}
		} else if ($status_kerja == 2) {
			$total   = 0; //pegawai yang tidak aktif/keluar
		} else {
			$total   = 50; //pegawai yang hamil dapet 50%
		}


		$getDataTKD = $this->master_model->getDataTKD($id_pegawai);


		if (!empty($getDataTKD)) {
			//$gp         = $getDataTKD[0]->gaji_pokok;
			//$total_gp   = $getDataTKD[0]->total;// total stelah hitung pengali
			$bpjs_kerja = $getDataTKD[0]->bpjs_kerja;
			$bpjs_kes   = $getDataTKD[0]->bpjs_kes;


			if ($masaKerja < 3) {

				$totalHitung = $total_gp * 0.75;
				//total TKD
				$tkd_bruto     = ($totalHitung * $total) / 100; //total sebelum pemotongan
			} else {
				//total TKD
				$tkd_bruto     = ($total_gp * $total) / 100; //total sebelum pemotongan
			}

			$totalTKDPOKOK = $totalTKDPOKOK + $tkd_bruto;

			//5% dari total pengali TKD
			if ($id_pegawai == 249) {
				$pajak_pph21      = 0; //karna gaji nya di bawah PTKP
			} else {
				$pajak_pph21      = round($tkd_bruto * $pph21);
			}


			if ($bpjs_kes == 1) {
				//2% dari gaji pokok
				$bpjskes = round($gp * 0.02);
			}

			if ($bpjs_kerja == 1) {
				//3% dari gaji pokok
				$jamsostek = round($gp * 0.03);
			}

			$total_potongan = $pajak_pph21 + $bpjskes + $jamsostek;

			//penerimaan = total tkd-total potongan
			$totalPenerimaan = $tkd_bruto - $total_potongan;
		} else {
			$total_gp = 0;
			$total1   = 0;
			$pajak    = 0;
			$total_potongan = $pajak;
			$totalPenerimaan = $total_gp - $pajak;
		}




		$data = array(
			'id_pegawai' => $id_pegawai,
			'nama' => strtoupper($nama),
			'Jabatan' => $jabatan,
			'Cuti' => $cuti,
			'izin' => $izin,
			'sakit' => $sakit,
			'telat' => $totalTelat,
			'total' => $totalMenit,
			'tkd_pokok' => $total_gp,
			'kinerja' => $bobot_aktifitas,
			'perilaku' => $perilaku,
			'serapan' => $serapan,
			'total_kinerja' => $total,
			'total_tkd' => $tkd_bruto,
			'pph' => $pajak_pph21,
			'bpjs_kes' => $bpjskes,
			'jamsostek' => $jamsostek,
			'thp' => $totalPenerimaan,
			'masa_kerja' => $masaKerja,
			'bulan' => $bulan,
			'tahun' => $tahun,
			'date_update' => $date_update
		);


		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $tahun);
		$this->db->update('ts_temp_tkd', $data);


		//print_array($data);
		return true;
	}

	function getDataLaporan($bulan, $tahun, $id_pegawai)
	{

		$this->db->select('*');
		$this->db->from('ts_temp_tkd');
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $tahun);
		$this->db->where('id_pegawai', $id_pegawai);
		$query = $this->db->get();
		$row = $query->result();
		return $row;
	}

	function getNorekPegawai($id_pegawai)
	{

		$this->db->select('no_rekening, npwp');
		$this->db->from('mst_pegawai');
		$this->db->where('id_pegawai', $id_pegawai);
		$query = $this->db->get();
		$row = $query->result();
		return $row;
	}

	function getCapaianTerendah($id_validator, $bulan, $tahun, $offset = 0)
	{
		if ($id_validator == 355) {
			$AND_validator = "";
		} else {
			$AND_validator = " AND  a.id_validator = '$id_validator'";
		}
		$sql = "SELECT a.id_pegawai, a.nama, b.total, b.tahun, b.bulan
		FROM mst_pegawai a
		LEFT JOIN ts_rekap_tkd b ON a.id_pegawai=b.id_pegawai
		WHERE  b.tahun = $tahun AND bulan = $bulan $AND_validator
		ORDER BY total ASC LIMIT 10 OFFSET $offset";

		$query = $this->db->query($sql);
		$row = $query->result();
		return $row;
	}



	function getTelatTertinggi($id_validator, $bulan, $tahun, $offset = 0, $case = 'terlambat')
	{
		if ($id_validator == 355) {
			$AND_validator = "";
		} else {
			$AND_validator = " AND  a.id_validator = '$id_validator'";
		}
		$sql = "SELECT a.id_pegawai, a.nama, b.terlambat, b.pc, b.sakit, b.izin
		FROM mst_pegawai a
		LEFT JOIN ts_rekap_absensi b ON a.id_pegawai=b.id_pegawai
		WHERE  b.tahun = $tahun AND bulan = $bulan $AND_validator
		ORDER BY $case DESC LIMIT 10 OFFSET $offset";

		$query = $this->db->query($sql);
		$row = $query->result();
		return $row;
	}




	// function getLaporanCapaian($id_validator, $bulan, $tahun)
	// {

	// 	if ($id_validator == 355) //272 id pegawai (bu Nur)
	// 	{
	// 		$andWhere = '';
	// 	} else {
	// 		$andWhere = "AND a.id_validator = $id_validator";
	// 	}
	// 	//$andWhere = '';

	// 	$sql = "SELECT a.nama, a.id_pegawai, a.nip, a.status_kerja, b.*
	// 	FROM mst_pegawai a
	// 	LEFT JOIN ts_rekap_tkd b ON a.id_pegawai = b.id_pegawai
	// 	WHERE  (b.bulan='$bulan' AND b.tahun = '$tahun') $andWhere";


	// 	$query = $this->db->query($sql);
	// 	$row = $query->result();
	// 	return $row;
	// }


	function getLaporanCapaian($id_validator, $bulan, $tahun)
	{



		if ($id_validator == 355) //272 id pegawai (bu Nur)
		{
			$andWhere = '';
		} else {
			$andWhere = "AND a.id_validator = $id_validator";
		}


		$sql = "SELECT a.nama, a.id_pegawai, a.nip, a.status_kerja
		FROM mst_pegawai a WHERE  status_kerja <> 2 $andWhere  AND status_pegawai = 2 ORDER BY nama ASC";

		$query = $this->db->query($sql);
		$row = $query->result();
		return $row;
	}


	function getTotalCapaian($id_pegawai, $bulan, $tahun)
	{

		$this->db->select('*');
		$this->db->from('ts_rekap_tkd');
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $tahun);
		$this->db->where('id_pegawai', $id_pegawai);
		$query = $this->db->get();
		$row = $query->result();

		#print_array($row);

		if (!empty($row)) {
			$totalCapaian = $row[0]->total;
		} else {
			$totalCapaian = 0;
		}

		return $totalCapaian;
	}

	function insertDataTKD($rowdata)
	{

		$keterangan = '';
		$bulan 		   = $rowdata->bulan;
		$tahun 		   = $rowdata->tahun;
		$tgl_masuk     = $rowdata->tgl_masuk;
		$gaji_pokok    = $rowdata->gaji_pokok;
		$tkd_pokok     = $rowdata->tkd_pokok;
		$total         = $rowdata->total;
		$nip           = $rowdata->nip;
		$bpjs_kes      = $rowdata->bpjs_kes;
		$bpjs_tk       = $rowdata->bpjs_kerja;
		$status_kerja  = $rowdata->status_kerja;
		$id_jabatan    = $rowdata->id_jabatan;

		$today = '2021-10-30';

		$masaKerja       = datediff('d', $tgl_masuk, $today);


		$periode = $tahun . '-' . $bulan;

		if ($status_kerja == 3) {
			$capaian = 50.00;
			$keterangan = 'Cuti Nifas';
		} else {
			$capaian = $total;
		}

		$total_tkd = round(($tkd_pokok * $capaian) / 100); //bruto



		if ($masaKerja < 90) {
			$total_tkd = round(($tkd_pokok * 75) / 100);
			$keterangan = 'Masa Kerja dibawah 3 bulan';
		}




		$pph21        = 0.05; //pph21

		$pajak_pph21  = round($total_tkd * $pph21);


		if ($bpjs_kes == 1) {
			//2% dari gaji pokok
			$pot_bpjs_kes = round($gaji_pokok * 0.02);
		} else {
			$pot_bpjs_kes = 0;
		}

		if ($bpjs_tk == 1) {
			//3% dari gaji pokok
			$jamsostek = round($gaji_pokok * 0.03);
		} else {
			$jamsostek = 0;
		}


		$potongan = $pajak_pph21 + $pot_bpjs_kes + $jamsostek;
		$thp = $total_tkd - $pajak_pph21 - $potongan;


		$nama_pegawai = strtoupper($rowdata->nama);

		$cekListing = $this->cekDatalistingTKD($nama_pegawai, $periode);

		if (!empty($cekListing)) {
			//data udah ada
			$dataUpdate = array(
				'periode' => $periode,
				'nip' => $nip,
				'nama' =>  $nama_pegawai,
				'jabatan' => $rowdata->jabatan,
				'npwp' => $rowdata->npwp,
				'tkd_pokok' => $tkd_pokok,
				'capaian' => $capaian,
				'total_tkd' => $total_tkd,
				'pph21' => $pajak_pph21,
				'bpjs_kes' => $pot_bpjs_kes,
				'jamsostek' => $jamsostek,
				'thp' => $thp,
				'no_rekening' => $rowdata->no_rekening,
				'status_kerja' => $status_kerja,
				'id_jabatan' => $id_jabatan,
				'masa_kerja' => $masaKerja,
				'keterangan' => $keterangan

			);


			$id = $cekListing[0]->id;
			$this->db->where('id', $id);
			$this->db->update('ts_listing_tkd', $dataUpdate);
		} else {

			$dataInsert = array(
				'id' => $this->getlastIDListing(),
				'periode' => $periode,
				'nip' => $nip,
				'nama' =>  $nama_pegawai,
				'jabatan' => $rowdata->jabatan,
				'npwp' => $rowdata->npwp,
				'tkd_pokok' => $tkd_pokok,
				'capaian' => $capaian,
				'total_tkd' => $total_tkd,
				'pph21' => $pajak_pph21,
				'bpjs_kes' => $pot_bpjs_kes,
				'jamsostek' => $jamsostek,
				'thp' => $thp,
				'no_rekening' => $rowdata->no_rekening,
				'status_kerja' => $status_kerja,
				'id_jabatan' => $id_jabatan,
				'masa_kerja' => $masaKerja,
				'keterangan' => $keterangan

			);

			$this->db->insert('ts_listing_tkd', $dataInsert);
		}


		return true;
	}

	function cekDataRekapGajiPjlp($id_pjlp, $periode)
	{
		$qry = $this->db->get_where('ts_rekap_gaji_pjlp', array('id_pjlp' => $id_pjlp, 'periode' => $periode));
		$row = $qry->result();
		return $row;
	}

	function detailRekapGajiPjlp($id)
	{
		$qry = $this->db->get_where('ts_rekap_gaji_pjlp', array('id' => $id));
		$row = $qry->result();
		return $row;
	}

	function cekDatalistingTKD($nama, $periode)
	{
		$qry = $this->db->get_where('ts_listing_tkd', array('nama' => $nama, 'periode' => $periode));
		$row = $qry->result();


		return $row;
	}


	function getlastIDListing()
	{


		$this->db->order_by('id', 'DESC');
		$qry = $this->db->get('ts_listing_tkd', 1, 0);
		$row = $qry->result();


		if (!empty($row)) {
			$lastID = $row[0]->id;
			$new_id = $lastID + 1;

			return $new_id;
		} else {

			return 1;
		}
	}


	function getDataCapaian($periode)
	{
		$periode = date('Y-m', strtotime($periode));
		$sql = "SELECT * FROM ts_listing_tkd WHERE periode ='$periode'  ORDER BY id_jabatan ASC, masa_kerja DESC";
		$query = $this->db->query($sql);
		$row = $query->result();
		return $row;
	}

	/* function getDataCapaian($bulan, $tahun){

		$sql = "SELECT a.nama, a.status_kerja, a.tgl_masuk, a.npwp, a.no_rekening, a.id_pegawai, a.nip, a.status_kerja, b.total AS total_capaian, c.nama as jabatan, d.*
		FROM mst_pegawai a
		LEFT JOIN ts_rekap_tkd b ON a.id_pegawai = b.id_pegawai
		LEFT JOIN mst_jabatan c ON a.jabatan = c.id
		LEFT JOIN perhitungan_tkd d ON a.id_pegawai = d.id_pegawai
		WHERE b.bulan='$bulan' AND b.tahun = '$tahun' ORDER BY a.jabatan ASC";
		$query = $this->db->query($sql);
		$row = $query->result();
		return $row;

	}
	 */






	function cekDataTKDPegawai($id_pegawai, $bulan, $tahun)
	{
		$sql = "SELECT id FROM ts_temp_tkd WHERE id_pegawai = $id_pegawai AND bulan = '$bulan' AND tahun = '$tahun' ";
		$query = $this->db->query($sql);
		$row = $query->num_rows();

		if ($row == 0) {
			return false;
		} else {
			return true;
		}
	}


	function getDataTKDPegawai($id_pegawai, $bulan, $tahun)
	{
		$sql = "SELECT a.*, b.id AS id_jabatan, c.npwp, c.no_rekening
		FROM ts_temp_tkd a
		LEFT JOIN mst_jabatan b ON a.Jabatan = b.nama
		LEFT JOIN mst_pegawai c ON a.id_pegawai = c.id_pegawai
		WHERE a.id_pegawai = $id_pegawai AND bulan = '$bulan' AND tahun = '$tahun' ";

		$query = $this->db->query($sql);
		$row = $query->result();

		return $row;
	}

	function getListTKD($bulan, $tahun, $orderBy = 'total', $sortBy = 'DESC')
	{
		$id_user   = $this->session->userdata('id_user');
		if ($id_user == 272) //272 id pegawai (bu Nur)
		{
			$andWhere = '';
		} else {
			$andWhere = "AND c.id_validator = $id_user";
		}

		$sql = "SELECT a.*, b.id AS id_jabatan, c.npwp, c.no_rekening, c.gaji_pokok, c.pengali, c.tgl_masuk
		FROM ts_temp_tkd a
		LEFT JOIN mst_jabatan b ON a.Jabatan = b.nama
		LEFT JOIN mst_pegawai c ON a.id_pegawai = c.id_pegawai
		WHERE bulan = '$bulan' AND tahun = '$tahun' $andWhere
		GROUP BY a.nama ORDER BY $orderBy $sortBy, tgl_masuk ASC ";

		$query = $this->db->query($sql);
		$row = $query->result();
		return $row;
	}


	function getListPegawaiByValidator($id_validator)
	{
		$sql = "SELECT a.nama, b.nama AS jabatan, a.status_kerja, a.id_pegawai, a.nip, a.tgl_masuk, a.id_puskesmas as puskesmas
		FROM mst_pegawai a
		LEFt JOIN mst_jabatan b ON a.jabatan = b.id
		WHERE id_validator = $id_validator  AND status_pegawai = 2 AND status_kerja != 2 ORDER BY a.jabatan ASC";

		$query = $this->db->query($sql);
		$row = $query->result();
		return $row;
	}



	function getListTKDValid($bulan, $tahun, $orderBy = 'total', $sortBy = 'DESC')
	{
		$sql = "SELECT a.*, b.id AS id_jabatan
		FROM ts_temp_tkd a
		LEFT JOIN mst_jabatan b ON a.Jabatan = b.nama
		LEFT JOIN mst_pegawai c ON a.id_pegawai = c.id_pegawai
		WHERE bulan = '$bulan' AND tahun = '$tahun'
		GROUP BY a.nama ORDER BY $orderBy $sortBy, masa_kerja DESC ";


		$query = $this->db->query($sql);
		$row = $query->result();
		return $row;
	}


	/*function getListTKD($bulan, $tahun)
	{

		$this->db->select('*');
		$this->db->from('ts_temp_tkd');
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $tahun);
		$this->db->order_by('Jabatan ASC, masa_kerja DESC');
		$query = $this->db->get();
		$row = $query->result();
		return $row;
	}
	*/


	function getDataDetailPegawai($id_pegawai)
	{

		$sql = "SELECT  a.*, a.pendidikan AS id_pendidikan, b.nama as jabatan, c.pendidikan
			    FROM mst_pegawai_detail a
				LEFT JOIN mst_jabatan b ON a.jabatan = b.id
				LEFT JOIN mst_pendidikan c ON a.pendidikan=c.id
				WHERE id_pegawai2 = $id_pegawai";


		$qry = $this->db->query($sql);
		$row = $qry->result();
		return $row;
	}

	function updateListingTKDPegawai($nip)
	{

		$tahun        = $this->session->userdata('periode_tahun');
		$bulan        = $this->session->userdata('periode_bulan');
		$today         = date('Y-m-d');

		$ta           = '2023'; //tahun anggaran
		$periode      = $tahun . '-' . $bulan;
		$periode      = date('Y-m', strtotime($periode));

		$this->db_gaji = $this->load->database('db_penggajian', TRUE);
		$query         = $this->db_gaji->get_where('mst_pegawai', array('nip' => $nip, 'tahun_anggaran' =>  $ta));
		$data_pegawai  = $query->result();


		$bpjs_kes      = $data_pegawai[0]->bpjs;
		$tgl_masuk     = $data_pegawai[0]->tgl_masuk;
		$nama          = $data_pegawai[0]->nama;
		$npwp          = $data_pegawai[0]->npwp;
		$no_rekening   = $data_pegawai[0]->no_rekening;
		$id_pegawai    = $data_pegawai[0]->id_pegawai;
		$pengali       = $data_pegawai[0]->pengkalian;
		$gaji_pokok    = $data_pegawai[0]->gaji_pokok;
		$id_jabatan    = $data_pegawai[0]->jabatan;
		$tkd_pokok     = $gaji_pokok * $pengali;

		$jabatan       = $this->master_model->getNamaJabatan($id_jabatan);

		$masaKerja       = datediff('d', $tgl_masuk, $today);

		$cekDataExist    =  $this->Laporan_model->cekDatalistingTKD($nama, $periode);

		$totalCapaian    = $this->Laporan_model->getTotalCapaian($id_pegawai, $bulan, $tahun);
		$tkd_bruto       = ($tkd_pokok * $totalCapaian) / 100;

		if (!empty($cekDataExist)) {
			$pph21       = $cekDataExist[0]->pph21;
			$bpjs_tk     = $cekDataExist[0]->jamsostek;
			$bpjs_kes    = $cekDataExist[0]->bpjs_kes;

			$kurang_bayar = $cekDataExist[0]->kurang_bayar;
			$lebih_bayar  = $cekDataExist[0]->lebih_bayar;

			$potongan        = $pph21 + $bpjs_tk + $bpjs_kes + $lebih_bayar;
			$thp             = ($tkd_bruto - $potongan) + $kurang_bayar;

			$dataUpdate = array(
				'periode' => $periode,
				'nip' => $nip,
				'nama' =>  $nama,
				'jabatan' => $jabatan,
				'npwp' => $npwp,
				'tkd_pokok' => $tkd_pokok,
				'capaian' => $totalCapaian,
				'total_tkd' => $tkd_bruto,
				'thp' => $thp,
				'no_rekening' => $no_rekening,
				'status_kerja' => $data_pegawai[0]->status_kerja,
				'id_jabatan' => $data_pegawai[0]->jabatan,
				'masa_kerja' => $masaKerja,
				'keterangan' => ''

			);

			$id = $cekDataExist[0]->id;
			$this->db->where('id', $id);
			$this->db->update('ts_listing_tkd', $dataUpdate);

			#print_array($dataUpdate);
		} else {
			$pph21        = $data_pegawai[0]->pph21;
			$bpjs_tk      = $data_pegawai[0]->bpjs_tk;
			$potongan        = $pph21 + $bpjs_kes + $bpjs_tk;
			$thp             = $tkd_bruto - $potongan;

			$dataInsert = array(
				'id' => $this->Laporan_model->getlastIDListing(),
				'periode' => $periode,
				'nip' => $nip,
				'nama' =>  $nama,
				'jabatan' => $jabatan,
				'npwp' => $npwp,
				'tkd_pokok' => $tkd_pokok,
				'capaian' => $totalCapaian,
				'total_tkd' => $tkd_bruto,
				'pph21' => $pph21,
				'bpjs_kes' => $bpjs_kes,
				'jamsostek' => $bpjs_tk,
				'thp' => $thp,
				'no_rekening' => $no_rekening,
				'status_kerja' =>  $data_pegawai[0]->status_kerja,
				'id_jabatan' => $data_pegawai[0]->jabatan,
				'masa_kerja' => $masaKerja,
				'keterangan' => ''

			);

			$this->db->insert('ts_listing_tkd', $dataInsert);
			// print_array($dataInsert);
		}

		return true;
	}


	function updateRekapTKD($id_pegawai)
	{


		$tahun = $this->session->userdata('periode_tahun');
		$bulan = $this->session->userdata('periode_bulan');

		$totalJam        = $this->master_model->getTotalJamkerjaPerbulan($bulan, $tahun);
		$getRakapAbsensi = $this->Ekin_model->getRakapAbsensi($id_pegawai, $bulan, $tahun);

		$getDataPDP      = $this->master_model->getJmlhPDP($id_pegawai, $bulan, $tahun);
		$menitPDP        = $getDataPDP * 300;

		//print_array($getRakapAbsensi);

		if (!empty($getRakapAbsensi)) {
			$cuti 		       = $getRakapAbsensi[0]->cuti;
			$sakit 	           = $getRakapAbsensi[0]->sakit;
			$izin 		       = $getRakapAbsensi[0]->izin;
			$alpa 		       = $getRakapAbsensi[0]->alpa;
			$total_dl 		   = $getRakapAbsensi[0]->dl;
			$totalTelat 	   = $getRakapAbsensi[0]->terlambat;

			//echo $totalTelat;
			//exit;

			$menitAlpa = $alpa * 600;
			$totalJamPengurang = ($sakit * 300) + ($izin * 300) + $totalTelat + $menitAlpa;
			$totalJamPenambah  = ($cuti * 300) + $menitPDP;

			$totalWaktuEfektif = $totalJam - $totalJamPengurang;

			$total = $this->Ekin_model->totalValidasi($id_pegawai, $bulan, $tahun);

			$totalKinerja = $total + $totalJamPenambah;


			if ($totalKinerja > $totalWaktuEfektif) {
				$persenAktifitas = ($totalWaktuEfektif / $totalJam) * 100;
			} else {
				$persenAktifitas = ($totalKinerja / $totalJam) * 100;
			}



			$capaian       = round($persenAktifitas, 2);
			$bobotAktifias =  round(($capaian * 70) / 100, 2);

			$perilaku      = $this->master_model->getPenilaianPerilaku($id_pegawai, $bulan, $tahun);
			$status_kerja  = $this->master_model->cekStatusKerjaPegawai($id_pegawai);

			if ($status_kerja == 3) {

				//cuti melahirkan
				$capaian       = 0;
				$bobotAktifias = 30;
				$perilaku      = 0;
			}

			$this->db->select('id');
			$query = $this->db->get_where('ts_rekap_tkd', array('bulan' => $bulan, 'tahun' => $tahun, 'id_pegawai' => $id_pegawai));
			$row   = $query->result();

			$query2 = $this->db->get_where('ts_temp_tkd', array('bulan' => $bulan, 'tahun' => $tahun, 'id_pegawai' => $id_pegawai));
			$row2   = $query2->result();

			$serapan = SERAPAN;
			$totalKinerja  = $bobotAktifias + $perilaku + $serapan;


			if (!empty($row)) {
				$id = $row[0]->id;

				$newArray = array(
					'nilai_aktifitas' => $capaian,
					'bobot_aktifitas' => $bobotAktifias,
					'perilaku' => $perilaku,
					'serapan' => $serapan,
					'total' => $totalKinerja,
					'pdp' => $getDataPDP,
					'cuti' => $getRakapAbsensi[0]->cuti,
					'sakit' => $getRakapAbsensi[0]->sakit,
					'izin' => $getRakapAbsensi[0]->izin,
					'telat' => $totalTelat,
					'alpa' => $getRakapAbsensi[0]->alpa,
					'total_menit' => $totalJamPengurang,


				);

				$this->db->where('id', $id);
				$this->db->update('ts_rekap_tkd', $newArray);
			}



			if (!empty($row2)) {
				$id2 = $row2[0]->id;

				$newArray2 = array(
					'kinerja' => $bobotAktifias,
					'perilaku' => $perilaku,
					'serapan' => $serapan,
					'total_kinerja' => $totalKinerja,
					'pdp' => $getDataPDP,
					'Cuti' => $getRakapAbsensi[0]->cuti,
					'sakit' => $getRakapAbsensi[0]->sakit,
					'izin' => $getRakapAbsensi[0]->izin,
					'telat' => $totalTelat,
					'total' => $totalJamPengurang,


				);

				$this->db->where('id', $id2);
				$this->db->update('ts_temp_tkd', $newArray2);
			}
		}


		return true;
	}

	// //ambil data dari aplikasi penggajian
	// function getDataPerhitunganTKDPegawai($nip, $bulan, $tahun){
	//     	ini_set("allow_url_fopen", 1);
	// 		$url = 'http://puskesmascilincing.id/e-penggajian/cek_gaji/getDataPerhitunganTKD/'.$nip.'/'.$bulan.'/'.$tahun;
	// 		$ch = curl_init();
	// 		// IMPORTANT: the below line is a security risk, read https://paragonie.com/blog/2017/10/certainty-automated-cacert-pem-management-for-php-software
	// 		// in most cases, you should set it to true
	// 		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	// 		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// 		curl_setopt($ch, CURLOPT_URL, $url);
	// 		$result = curl_exec($ch);
	// 		curl_close($ch);


	// 		$obj = json_decode($result);

	//     	return $obj;

	// }



	public function getTKDPegawai($no_rekening, $periode)
	{

		$query = $this->db->get_where('ts_listing_tkd', array('no_rekening' => $no_rekening, 'periode' => $periode), 1);
		$row = $query->result();
		return $row;
	}


	function getDataSTRSIP($jns_dokumen = 'SIP')
	{
		$query = $this->db->get_where('tbl_sip_str', array('jns_dokumen' => $jns_dokumen));
		$row = $query->result();
		return $row;
	}

	function lastDataTKDPegawai($nip, $periode)
	{
		$periode = date('Y-m', strtotime($periode));
		$this->db->order_by('id', 'DESC');

		$query = $this->db->get_where('ts_listing_tkd', array('nip' => $nip, 'periode' => $periode), 1);
		$row = $query->result();

		return $row;
	}

	function getDataPerhitunganTKDPegawai($nip, $periode)
	{

		$periode = date('Y-m', strtotime($periode));

		$query = $this->db->get_where('ts_listing_tkd', array('nip' => $nip, 'periode' => $periode));
		$row = $query->result();

		return $row;
	}
}
