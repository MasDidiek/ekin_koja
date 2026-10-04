<?php ob_start();
defined('BASEPATH') or exit('No direct script access allowed');
class Kinerja_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		#$this->db2 = $this->load->database('ekin1', true);

	}


	public function getSummaryKinerjaLengkap($id_pegawai, $periode)
	{
		$this->db->select("
			COUNT(id) AS total_input_jumlah,
			COALESCE(SUM(total), 0) AS total_input_menit,

			COUNT(CASE WHEN status = 1 THEN 1 END) AS disetujui_jumlah,
			COALESCE(SUM(CASE WHEN status = 1 THEN total ELSE 0 END), 0) AS disetujui_menit,

			COUNT(CASE WHEN status = 0 THEN 1 END) AS pending_jumlah,
			COALESCE(SUM(CASE WHEN status = 0 THEN total ELSE 0 END), 0) AS pending_menit,

			COUNT(CASE WHEN status = 2 THEN 1 END) AS ditolak_jumlah,
			COALESCE(SUM(CASE WHEN status = 2 THEN total ELSE 0 END), 0) AS ditolak_menit
		");
		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->where("DATE_FORMAT(tgl, '%Y-%m') =", $periode);
		return $this->db->get('ts_kinerja')->row();
	}


	function getCapaianPegawai($nip, $periode)
	{

		$this->db->select('a.*, b.nama, b.id_pegawai');
		$this->db->where('a.nip', $nip);
		$this->db->where('periode', $periode);
		$this->db->from('ts_rekap_capaian a');
		$this->db->join('mst_pegawai b', 'a.nip = b.nip', 'left');

		return  $this->db->get()->row();
	}

	public function getListPegawaiWithRekapAktivitas($id_validator, $periode, $thn_anggaran)
	{
		$this->db->select("
            p.id_pegawai,
            p.nama,
            p.nip,
            j.nama AS jabatan,

            COALESCE(r.total_input, 0) AS total_input,
            COALESCE(r.disetujui, 0) AS disetujui,
            COALESCE(r.ditolak, 0) AS ditolak,

            CASE
                WHEN COALESCE(r.total_input, 0) > 0
                THEN CEIL(((COALESCE(r.disetujui,0) + COALESCE(r.ditolak,0)) / r.total_input) * 100)
                ELSE 0
            END AS persen_validasi
        ", false);

		$this->db->from('mst_pegawai p');
		$this->db->join('mst_jabatan j', 'p.id_jabatan = j.id', 'left');

		$this->db->join(
			'rekap_input_kinerja r',
			'r.id_pegawai = p.id_pegawai
            AND r.periode = ' . $this->db->escape($periode),
			'left'
		);

		$this->db->where('p.id_validator', $id_validator);
		$this->db->where_in('p.jns_pegawai', ['non_pns', 'pppk_pw']);
		$this->db->where('p.tahun_anggaran', $thn_anggaran);
		$this->db->where('p.status_kerja >', 0);

		$this->db->order_by('p.nama', 'ASC');

		return $this->db->get()->result();
	}


	function getListPegawaiByValidatorWithPerilaku(
		$id_validator,
		$thn_anggaran,
		$bulan,
		$tahun
	) {


		$this->db->select("
            mst_pegawai.nama,
            mst_pegawai.id_pegawai,
            mst_pegawai.nip,
            mst_jabatan.nama AS jabatan,
            COALESCE(ROUND((SUM(pp.poin) / 250) * 100, 2), 0) AS nilai_perilaku
        ", false);

		$this->db->from('mst_pegawai');

		$this->db->join(
			'mst_jabatan',
			'mst_pegawai.id_jabatan = mst_jabatan.id',
			'left'
		);

		$this->db->join(
			'tbl_penilaian_perilaku pp',
			'pp.id_pegawai = mst_pegawai.id_pegawai
            AND pp.periode_bulan = ' . (int)$bulan . '
            AND pp.periode_tahun = ' . (int)$tahun,
			'left'
		);

		// filter pegawai
		$this->db->where('mst_pegawai.id_validator', $id_validator);
		$this->db->where_in('mst_pegawai.jns_pegawai', ['non_pns', 'pppk_pw']);
		$this->db->where('mst_pegawai.tahun_anggaran', $thn_anggaran);
		$this->db->where('mst_pegawai.status_kerja >', 0);

		$this->db->group_by('mst_pegawai.id_pegawai');

		$this->db->order_by('mst_pegawai.nama', 'ASC');

		return $this->db->get()->result();
	}




	function getIDPegawaiekin($nip)
	{

		$this->db2->where('nip', $nip);

		$qry = $this->db2->get('mst_pegawai');
		$row = $qry->result();
		return $row;
	}

	function getInputan($id_pegawai)
	{
		$tgl = '2024-01-01';
		$this->db2->where('id_pegawai', $id_pegawai);
		$this->db2->where('tgl >=', $tgl);

		$this->db2->select('ts_kinerja.*, mst_kegiatan.nama_kegiatan, mst_kegiatan.waktu');
		$this->db2->from('ts_kinerja');
		$this->db2->join('mst_kegiatan', 'ts_kinerja.id_kegiatan = mst_kegiatan.id');

		$qry = $this->db2->get();
		$row = $qry->result();

		return $row;
	}


	function getDataPerilkuEkin1($id_pegawai)
	{
		$query = $this->db2->get_where('penilaian_perilaku', array('id_pegawai' => $id_pegawai, 'periode_bulan' => 1, 'periode_tahun' => 2024));
		$row = $query->result();
		return $row;
	}
	//mengecek data aktifitas
	function cekDataAktifitasPending($id_pegawai, $tanggal)
	{
		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->where('tgl', $tanggal);
		$this->db->where('status', 0);
		$this->db->select('status');
		$qry = $this->db->get('ts_kinerja');
		$row = $qry->result();
		return $row;
	}


	function getAktifitasApprove($id_pegawai, $periode)
	{
		$sql = "SELECT sum(total) as total_aktifitas FROM ts_kinerja WHERE id_pegawai = $id_pegawai AND tgl like '$periode%' AND status = 1 ";
		$qry = $this->db->query($sql);
		$row = $qry->result();
		$aktiftias = $row[0]->total_aktifitas;



		return $aktiftias;
	}


	function delete_inputan($id_pegawai)
	{

		$sql = "DELETE FROM ts_kinerja WHERE id_pegawai = $id_pegawai AND tgl < '2024-02-01' ";
		$this->db->query($sql);
		return true;
	}

	function getDataInputAktifitas($id_pegawai, $tanggal)
	{
		$this->db->order_by('jam_mulai', 'ASC');
		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->where('tgl', $tanggal);
		$this->db->select('ts_kinerja.*, mst_indikator_kegiatan.nama_kegiatan AS indikator, mst_indikator_kegiatan.indikator_kegiatan');
		$this->db->from('ts_kinerja');
		$this->db->join('mst_indikator_kegiatan', 'ts_kinerja.id_indikator = mst_indikator_kegiatan.id', 'LEFT');

		$qry = $this->db->get();

		$row = $qry->result();
		return $row;
	}


	function getAktifitasPegawaiPerBulan($id_pegawai, $periode)
	{
		// $this->db->order_by('tgl', 'ASC');
		// $this->db->select('id, nama_kegiatan, tgl, jam_mulai, jam_selesai, total, status');
		// $qry = $this->db->get_where('ts_kinerja', array('id_pegawai'=> $id_pegawai));


		$sql = "SELECT * FROM ts_kinerja WHERE id_pegawai = $id_pegawai AND tgl like '$periode%' ORDER BY tgl ASC";
		$qry = $this->db->query($sql);


		return $qry->result();
	}

	function getAktifitasPegawai($id_pegawai)
	{
		$this->db->order_by('tgl', 'ASC');
		$this->db->select('id, nama_kegiatan, tgl, jam_mulai, jam_selesai, total, status');
		$qry = $this->db->get_where('ts_kinerja', array('id_pegawai' => $id_pegawai));
		return $qry->result();
	}


	function getRekapKinerjaPerPeriode($id_validator, $periode)
	{
		$sql = "
            SELECT
                k.id_pegawai,
                SUM(k.total) AS total_input,
                SUM(CASE WHEN k.status = 1 THEN k.total ELSE 0 END) AS disetujui,
                SUM(CASE WHEN k.status = 2 THEN k.total ELSE 0 END) AS ditolak
            FROM ts_kinerja k
            JOIN mst_pegawai p ON p.id_pegawai = k.id_pegawai
            WHERE k.tgl LIKE ?
            AND p.id_validator = ?
            GROUP BY k.id_pegawai
            ";


		return $this->db->query($sql, [
			$periode . '%',
			$id_validator
		])->result();
	}


	function getHariKerjaByPeriode($periode)
	{
		$tahun = date('Y', strtotime($periode . '-01'));
		$bulan = date('m', strtotime($periode . '-01'));

		return $this->db
			->where('bulan', $bulan)
			->where('tahun', $tahun)
			->get('ts_hari_kerja')
			->row();
	}


	function getTotalKinerja($id_pegawai, $periode, $status = null)
	{
		$this->db->select_sum('total', 'jmlh_input');
		$this->db->from('ts_kinerja');
		$this->db->where('id_pegawai', $id_pegawai);

		// Filter periode (YYYY-MM)
		$start = $periode . '-01';
		$end   = date('Y-m-t', strtotime($start));
		$this->db->where('tgl >=', $start);
		$this->db->where('tgl <=', $end);

		// Filter status jika ada
		if ($status !== null) {
			$this->db->where('status', $status);
		}

		$row = $this->db->get()->row();

		return ($row && $row->jmlh_input) ? $row->jmlh_input : 0;
	}



	function getJumlahInputPerBulan($id_pegawai, $periode)
	{

		$sql = "SELECT SUM(total) as jmlh_input FROM ts_kinerja WHERE id_pegawai = $id_pegawai AND tgl like '$periode%'";
		$qry = $this->db->query($sql);
		$row = $qry->result();
		//$total = 8000;
		$total = $row[0]->jmlh_input;
		return $total;
	}


	function getAktifitasByStatus($id_pegawai, $periode, $status = 0)
	{
		$sql = "SELECT SUM(total) as jmlh_input FROM ts_kinerja WHERE id_pegawai = $id_pegawai AND tgl like '$periode%' AND status = $status";
		$qry = $this->db->query($sql);
		$row = $qry->result();

		$total = $row[0]->jmlh_input;

		if ($total == '') {
			$total = 0;
		}
		//$total = 0;
		return $total;
	}



	function getDataEditAktifitas($id)
	{
		$this->db->where('ts_kinerja.id', $id);
		$this->db->select('ts_kinerja.*, mst_indikator_kegiatan.nama_kegiatan AS indikator, mst_indikator_kegiatan.indikator_kegiatan');
		$this->db->from('ts_kinerja');
		$this->db->join('mst_indikator_kegiatan', 'ts_kinerja.id_indikator = mst_indikator_kegiatan.id', 'LEFT');

		$qry = $this->db->get();

		$row = $qry->result();
		return $row;
	}




	function insertAktifitas()
	{
		$tgl           =  $this->input->post('tanggal');
		$indikator     =  $this->input->post('indikator');
		$vol           =  $this->input->post('vol');
		$waktu_efektif =  $this->input->post('waktu_efektif');

		$total = $waktu_efektif * $vol;
		// 'id_indikator' => $this->getKodeIndikator($indikator),

		$new_data = array(
			'id_pegawai' => $this->session->userdata('id_pegawai'),
			'tgl' => format_db($tgl),
			'jns_kegiatan' => $this->input->post('jns_kegiatan'),
			'id_indikator' => $this->getKodeIndikator($indikator),
			'nama_kegiatan' => $this->input->post('aktifitas'),
			'jam_mulai' => $this->input->post('jam_mulai'),
			'jam_selesai' => $this->input->post('jam_selesai'),
			'volume' => $vol,
			'waktu_efektif' => $waktu_efektif,
			'total' =>  $total,
			'date_in' => date('Y-m-d H:i:s'),
			'ket' =>  $this->input->post('keterangan')
		);

		$this->db->insert('ts_kinerja', $new_data);

		return true;
	}


	function getRekapHarian($id_pegawai, $tgl)
	{
		return $this->db
			->select('SUM(total) as total_menit, MAX(status) as status_max')
			->where('id_pegawai', $id_pegawai)
			->where('tgl', $tgl)
			->get('ts_kinerja')
			->row();
	}


	public function getSummaryInput($id_pegawai, $periode)
	{
		$this->db->select('COUNT(id) as jumlah, SUM(total) as menit');
		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->like('tgl', $periode); // YYYY-MM
		return $this->db->get('ts_kinerja')->row();
	}


	public function getSummaryDisetujui($id_pegawai, $periode)
	{
		$this->db->select('COUNT(id) as jumlah, SUM(total) as menit');
		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->where('status', 1);
		$this->db->like('tgl', $periode);
		return $this->db->get('ts_kinerja')->row();
	}

	public function getTotalMenitPerTanggal($id_pegawai, $tgl)
	{
		$this->db->select('SUM(total) as total');
		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->where('tgl', $tgl);
		$row = $this->db->get('ts_kinerja')->row();

		return $row->total;
	}


	public function getRekapPegawaiByValidator($id_validator, $periode)
	{
		$this->db->select("
			p.id,
			p.nama_pegawai,

			COUNT(k.id) AS total_input,

			SUM(CASE WHEN k.status = 1 THEN 1 ELSE 0 END) AS disetujui,
			SUM(CASE WHEN k.status = 2 THEN 1 ELSE 0 END) AS ditolak
		");
		$this->db->from('mst_pegawai p');
		$this->db->join(
			'ts_kinerja k',
			"k.id_pegawai = p.id
			 AND DATE_FORMAT(k.tgl,'%Y-%m') = '$periode'",
			'left'
		);
		$this->db->where('p.id_validator', $id_validator);
		$this->db->group_by('p.id');
		$this->db->order_by('p.nama_pegawai', 'ASC');

		return $this->db->get()->result();
	}


	function updateAktifitas($id)
	{
		$indikator     =  $this->input->post('indikator');
		$vol           =  $this->input->post('vol');
		$waktu_efektif =  $this->input->post('waktu_efektif');

		$total = $waktu_efektif * $vol;

		//'id_indikator' => $this->getKodeIndikator($indikator),

		$new_data = array(
			'jns_kegiatan' => $this->input->post('jns_kegiatan'),
			'id_indikator' => $this->getKodeIndikator($indikator),
			'nama_kegiatan' => $this->input->post('aktifitas'),
			'jam_mulai' => $this->input->post('jam_mulai'),
			'jam_selesai' => $this->input->post('jam_selesai'),
			'volume' => $vol,
			'waktu_efektif' => $waktu_efektif,
			'total' =>  $total,
			'ket' =>  $this->input->post('keterangan')
		);

		$this->db->where('id', $id);
		$this->db->update('ts_kinerja', $new_data);

		return true;
	}


	function getKodeIndikator($indikator)
	{
		$this->db->where('nama_kegiatan', $indikator);
		$qry = $this->db->get('mst_indikator_kegiatan');
		$row = $qry->result();

		return $row[0]->id;
	}

	function getPoinPerilaku($id_pegawai, $bulan, $tahun)
	{

		$sql = "SELECT SUM(poin) as total FROM tbl_penilaian_perilaku WHERE id_pegawai  = $id_pegawai AND periode_bulan = $bulan AND periode_tahun = $tahun";
		$qry = $this->db->query($sql);
		$row = $qry->result();

		$total  = ($row[0]->total / 250) * 10;

		return $total;
	}




	function getListKategoriPenilaianPerilaku()
	{
		$qry = $this->db->get('mst_kategori_penilaian');
		$row = $qry->result();

		return $row;
	}

	function getDaftarPertanyaan($id_kat)
	{
		$this->db->where('id_kategori', $id_kat);
		$qry = $this->db->get('daftar_pertanyaan');
		$row = $qry->result();
		return $row;
	}




	function getJawaban($id_pegawai, $id, $bulan, $tahun)
	{
		$query = $this->db->get_where('tbl_penilaian_perilaku', array('id_pegawai' => $id_pegawai, 'id_pertanyaan' => $id, 'periode_bulan' => $bulan, 'periode_tahun' => $tahun), 1, 0);
		$row = $query->result();
		return $row;
	}

	function rekap_input_kinerja($id_pegawai, $periode)
	{
		$query = $this->db->get_where('rekap_input_kinerja', array('id_pegawai' => $id_pegawai, 'periode' => $periode), 1, 0);
		$row = $query->result();
		if (!empty($row)) {
			$id = $row[0]->id;
			return $id;
		} else {
			return 0;
		}
	}

	function getRekapInputKinerjaPegawai($id_pegawai, $periode)
	{
		$query = $this->db->get_where('rekap_input_kinerja', array('id_pegawai' => $id_pegawai, 'periode' => $periode), 1, 0);
		$row = $query->result();
		return $row;
	}

	function cekPenilaianPegawai($id_pegawai, $bulan, $tahun)
	{
		$query = $this->db->get_where('tbl_penilaian_perilaku', array('id_pegawai' => $id_pegawai, 'periode_bulan' => $bulan, 'periode_tahun' => $tahun), 1, 0);
		$row = $query->result();
		if (!empty($row)) {
			$jawaban = $row[0]->jawaban;
			return true;
		} else {
			return false;
		}
	}


	function insertInitialPerilaku($id_pegawai, $bulan, $tahun)
	{
		$datalist = $this->getListKategoriPenilaianPerilaku();
		$tgl = date('Y-m-d');

		for ($a = 0; $a < count($datalist); $a++) {
			$id_kat = $datalist[$a]->id;
			$daftar = $this->getDaftarPertanyaan($id_kat);

			for ($i = 0; $i < count($daftar); $i++) {
				$id         = $daftar[$i]->id;
				$jns_item   = $daftar[$i]->jns_item;

				$this->insertPenilaianPerilaku($id_pegawai, $bulan, $tahun, $tgl, $id, $jns_item, 0, 0);
			}
		}

		return true;
	}

	function insertPenilaianPerilaku($id_pegawai, $bulan, $tahun, $tgl, $id_item, $jns_item, $jawaban, $poin)
	{
		$data = array(
			'id_pegawai' => $id_pegawai,
			'periode_bulan' => $bulan,
			'periode_tahun' => $tahun,
			'tgl_input' => $tgl,
			'id_pertanyaan' => $id_item,
			'jns_item' => $jns_item,
			'jawaban' => $jawaban,
			'poin' => $poin,

		);

		$this->db->insert('tbl_penilaian_perilaku', $data);
	}

	public function getRekapCutiBulanan($idPegawai, $bulan, $tahun)
	{
		$awal  = "$tahun-$bulan-01";
		$akhir = date('Y-m-t', strtotime($awal));

		$sql = "
			SELECT
				jns_cuti,
				status,
				SUM(
					DATEDIFF(
						LEAST(tgl_sampai, ?),
						GREATEST(tgl_dari, ?)
					) + 1
				) AS total_hari
			FROM ts_cuti
			WHERE id_pegawai = ?
			AND tgl_dari <= ?
			AND tgl_sampai >= ?
			GROUP BY jns_cuti, status
		";


		return $this->db->query($sql, [
			$akhir,
			$awal,
			$idPegawai,
			$akhir,
			$awal
		])->result();
	}


	function updateCapaianKinerja($id_pegawai, $bulan, $tahun)
	{
		// $bulan = $this->session->userdata('periode_bulan');
		// $tahun = $this->session->userdata('periode_tahun');
		$periode = date('Y-m', strtotime("$tahun-$bulan"));

		$lastDay = date('t', strtotime($periode));

		$peg = $this->Pegawai_model->getDetailPegawai($id_pegawai)[0];

		$nip   = $peg->nip;
		$gaji  = $peg->gaji_pokok;
		$kali  = $peg->pengkalian;
		$pph21 = $peg->pph21;
		$bpjsK = $peg->bpjs_kes;
		$bpjsT = $peg->bpjs_tk;

		$serapan = SERAPAN;

		$start  = $periode . '-01';
		$end    = $periode . '-' . $lastDay;
		/* ================= HITUNG CAPAIAN ================= */

		if ($peg->status_kerja == 1) {

			$rekap = $this->Presensi_model->getRekapAbsensiPegawai($id_pegawai, $periode);
			//$cuti  = $this->Cuti_model->getCutiPegawai($id_pegawai, $periode);

			$cuti = $this->Cuti_model->getCutiPegawaiPerPeriode($id_pegawai, $start, $end);
			$menitCuti = 0;
			$menitBersalin = 0;


			//print_array($cuti);
			foreach ($cuti as $c) {
				if ($c->status_akhir != 'disetujui') continue;

				if ($c->jenis_cuti == 2) { // bersalin
					$start = new DateTime($c->tgl_dari);
					if ($start->format('m') == $bulan) {
						$end = new DateTime($tahun . '-' . $bulan . '-' . $lastDay);
						$menitBersalin = ($start->diff($end)->days + 1) * 300;
					}
				} else {
					$menitCuti += $c->lama_cuti * 300;
				}
			}

			$totalMenitCuti = $menitCuti + $menitBersalin;

			//echo $totalMenitCuti;

			/* ========== ABSENSI ========== */
			$pengurangAbsen = 0;
			if (!empty($rekap)) {
				$r = $rekap[0];
				$pengurangAbsen =
					($r->izin * 300) +
					($r->sakit * 300) +
					($r->sakit_dgn_sk * 180) +
					($r->alpha * 450) +
					$r->telat +
					$r->pulang_awal;
			}

			/* ========== AKTIFITAS ========== */
			$inputKinerja = $this->Kinerja_model->getAktifitasByStatus($id_pegawai, $periode, 1);
			$hariKerja = $this->Master_model->getMenitEfektifBulan($bulan, $tahun);
			$waktuEfektif = $hariKerja * 300;

			//echo $inputKinerja;

			if ($waktuEfektif == 0) $waktuEfektif = 1; // safety

			// Bobot dari absensi
			$max1 = max(1, $waktuEfektif - $pengurangAbsen);
			$bobot1 = round((($max1 / $waktuEfektif) * 100) * 0.7, 2);

			// Bobot dari input kinerja
			$max2 = max(1, $waktuEfektif - $totalMenitCuti);
			$bobot2 = round((($inputKinerja / $max2) * 100) * 0.7, 2);
			$bobot2 = min($bobot2, 70);

			$bobotFinal = min($bobot1, $bobot2);

			$nilaiPerilaku = $this->Kinerja_model->getPoinPerilaku($id_pegawai, $bulan, $tahun);

			$totalCapaian = round($bobotFinal + $nilaiPerilaku + $serapan, 2);
		} else {
			$totalCapaian = 50;
			$bobotFinal = 0;
			$nilaiPerilaku = 0;
		}

		/* ================= TKD ================= */

		$tkdPokok = ceil($gaji * $kali);
		$bruto = round(($tkdPokok * $totalCapaian) / 100);
		$thp = $bruto - ($pph21 + $bpjsK + $bpjsT);

		$this->db->where(['periode' => $periode, 'nip' => $nip])
			->update('ts_rekap_tkd', [
				'tkd_pokok' => $tkdPokok,
				'capaian'   => $totalCapaian,
				'bruto'     => $bruto,
				'pph21'     => $pph21,
				'bpjs'      => $bpjsK,
				'bpjs_tk'   => $bpjsT,
				'thp'       => $thp,
				'update_on' => date('Y-m-d H:i:s')
			]);

		/* ================= REKAP CAPAIAN ================= */

		$rekapCapaian = [
			'periode'        => $periode,
			'nip'            => $nip,
			'bobot_aktifitas' => $bobotFinal,
			'perilaku'       => $nilaiPerilaku,
			'serapan'        => $serapan,
			'total_capaian'  => $totalCapaian,
			'created_at'     => date('Y-m-d H:i:s')
		];


		// print_array($rekapCapaian);
		// exit;

		$this->db->where(['periode' => $periode, 'nip' => $nip]);
		if ($this->db->get('ts_rekap_capaian')->num_rows() == 0) {
			$this->db->insert('ts_rekap_capaian', $rekapCapaian);
		} else {
			$this->db->where(['periode' => $periode, 'nip' => $nip])
				->update('ts_rekap_capaian', $rekapCapaian);
		}

		return true;
	}
}
