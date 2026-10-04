<?php
defined("BASEPATH") or exit("No direct script access allowed");
class Cuti_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function getNumCutiPending($id_validator = 0)
    {
        $approval = $this->db
            ->select("id")
            ->from("ts_pengajuan_cuti_approval")
            ->where("id_pegawai_approval", $id_validator)
            ->where("status", "pending")
            ->order_by("level_approval", "ASC")
            ->get()
            ->num_rows();

        return $approval;
    }

    // function getDataCutiPegawaiPending($id_validator = 0)
    // {

    //         $approval = $this->db
    //             ->select('*')
    //             ->from('ts_pengajuan_cuti_approval')
    //             ->where('id_pegawai_approval', $id_validator)
    //             ->where('status', 'pending')
    //             ->order_by('level_approval','ASC')
    //             ->get()
    //             ->result_array();

    //         return $approval;

    // }

    public function getPengajuanCutiPegawai(
        $id_pegawai,
        $role_approval = "kapustu"
    ) {
        return $this->db
            ->select(
                '
                 c.tgl_pengajuan,
                c.lama_cuti,
                c.alamat_cuti,
                c.delegasi_tugas,
                c.id,
                c.id_pengganti,
                c.id_pegawai,
                p.nama,
                mc.jenis_cuti,
                c.tgl_mulai,
                c.tgl_selesai,
                c.alasan_cuti,
                c.created_at,
                a.status as status_approval
            '
            )
            ->from("ts_pengajuan_cuti_approval a")
            ->join("ts_pengajuan_cuti c", "c.id = a.id_pengajuan_cuti")
            ->join("mst_pegawai p", "p.id_pegawai = c.id_pegawai")
            ->join("mst_cuti mc", "mc.id = c.jenis_cuti")
            ->where("a.id_pegawai_approval", $id_pegawai)
            ->where("a.role_approval", $role_approval)
            ->where("a.status", "pending")
            ->order_by("c.created_at", "ASC")
            ->get()
            ->result();

        //   echo $this->db->last_query();
    }

    function updateNextRoleApproval($id_pengajuan, $next_approval)
    {
        $this->db
            ->where("id_pengajuan_cuti", $id_pengajuan)
            ->where("role_approval", $next_approval)
            ->update("ts_pengajuan_cuti_approval", [
                "status" => "pending",
            ]);
        return true;
    }

    public function getSisaCutiTahunan($id_pegawai, $tahun, $jns_hak_cuti = 'tahunan')
    {

        if ($jns_hak_cuti == 'tahunan') {
            $table = 'ts_hak_cuti_pegawai';
        } else {
            $table = 'ts_hak_cuti_bersama';
        }
        $row = $this->db
            ->where("id_pegawai", $id_pegawai)
            ->where("tahun", $tahun)
            ->get($table)
            ->row();



        if (!$row) {
            return 0;
        }

        return $row->hak_total - ($row->hak_terpakai + $row->hak_reserved);
    }

    public function get_rekap_cuti_pegawai_by_id(
        $id_pegawai,
        $tahunList = [2025, 2026]
    ) {
        $data = [];

        foreach ($tahunList as $th) {
            $row = $this->db
                ->where("id_pegawai", $id_pegawai)
                ->where("tahun", $th)
                ->get("ts_hak_cuti_pegawai")
                ->row();

            if (!$row) {
                $data[$th] = [
                    "hak" => 0,
                    "terpakai" => 0,
                    "reserved" => 0,
                    "sisa" => 0,
                ];
                continue;
            }

            $hak_total = (int) $row->hak_total;
            $terpakai = (int) $row->hak_terpakai;
            $reserved = (int) $row->hak_reserved;
            $sisa = $hak_total - ($terpakai + $reserved);

            $data[$th] = [
                "hak" => $hak_total,
                "terpakai" => $terpakai,
                "reserved" => $reserved,
                "sisa" => $sisa,
            ];
        }

        return $data;
    }

    public function releaseHakCuti($id_pengajuan, $id_pegawai)
    {
        $logs = $this->db
            ->where("id_pengajuan_cuti", $id_pengajuan)
            ->where("tipe", "reserve")
            ->get("ts_log_mutasi_cuti")
            ->result();

        foreach ($logs as $log) {
            // Ambil saldo terakhir
            $row = $this->db
                ->where("id_pegawai", $id_pegawai)
                ->where("tahun", $log->tahun)
                ->get("ts_hak_cuti_pegawai")
                ->row();

            $sebelum =
                $row->hak_total - ($row->hak_terpakai + $row->hak_reserved);
            $sesudah = $sebelum + $log->jumlah;

            // Log release
            $this->db->insert("ts_log_mutasi_cuti", [
                "id_pegawai" => $id_pegawai,
                "tahun" => $log->tahun,
                "id_pengajuan_cuti" => $id_pengajuan,
                "tipe" => "release",
                "jumlah" => $log->jumlah,
                "saldo_sebelum" => $sebelum,
                "saldo_sesudah" => $sesudah,
                "keterangan" => "Pengajuan ditolak oleh pengganti",
            ]);

            // Update hak_reserved
            $this->db->where("id", $row->id)->update("ts_hak_cuti_pegawai", [
                "hak_reserved" => $row->hak_reserved - $log->jumlah,
            ]);
        }
    }

    public function get_rekap_cuti_pegawai($tahunList = [2025, 2026])
    {
        // Ambil semua pegawai
        $pegawai = $this->db->get("mst_pegawai")->result_array();

        $result = [];

        foreach ($pegawai as $p) {
            $row = [
                "id_pegawai" => $p["id_pegawai"],
                "nama" => $p["nama"],
                "jabatan" => $p["jabatan"],
                "cuti" => [],
            ];

            foreach ($tahunList as $th) {
                // 1. Ambil hak cuti
                $hak = $this->db
                    ->select("hak_cuti")
                    ->where("id_pegawai", $p["id_pegawai"])
                    ->where("tahun", $th)
                    ->get("ts_master_cuti")
                    ->row();

                $hak_cuti = $hak ? (int) $hak->hak_cuti : 0;

                // 2. Ambil mutasi
                $mutasi = $this->db
                    ->select(
                        "
                            SUM(CASE WHEN tipe = 'USED' THEN ABS(jumlah) ELSE 0 END) as used,
                            SUM(CASE WHEN tipe = 'HOLD' THEN ABS(jumlah) ELSE 0 END) as hold
                        "
                    )
                    ->where("id_pegawai", $p["id_pegawai"])
                    ->where("tahun", $th)
                    ->get("ts_log_mutasi_cuti")
                    ->row();

                $used = (int) $mutasi->used;
                $hold = (int) $mutasi->hold;

                $sisa = $hak_cuti - ($used + $hold);

                $row["cuti"][$th] = [
                    "hak" => $hak_cuti,
                    "terpakai" => $used,
                    "hold" => $hold,
                    "sisa" => $sisa,
                ];
            }

            $result[] = $row;
        }

        return $result;
    }

    function getApprovalCuti($id_pengajuan)
    {
        $approval = $this->db
            ->select("a.*, p.nama")
            ->from("ts_pengajuan_cuti_approval a")
            ->join(
                "mst_pegawai p",
                "p.id_pegawai = a.id_pegawai_approval",
                "left"
            )
            ->where("a.id_pengajuan_cuti", $id_pengajuan)
            ->order_by("a.level_approval", "ASC")
            ->get()
            ->result_array();

        return $approval;
    }

    function getPermohonanPengganti($id_pegawai)
    {
        return $this->db
            ->select(
                '
                c.id,
                c.id_pegawai,
                p.nama,
                c.jenis_cuti,
                c.tgl_mulai,
                c.tgl_selesai,
                c.alasan_cuti,
                c.created_at,
                c.lama_cuti,
                a.status as status_approval
            '
            )
            ->from("ts_pengajuan_cuti_approval a")
            ->join("ts_pengajuan_cuti c", "c.id = a.id_pengajuan_cuti")
            ->join("mst_pegawai p", "p.id_pegawai = c.id_pegawai")
            ->where("a.id_pegawai_approval", $id_pegawai)
            ->where("a.role_approval", "pengganti")
            ->where("a.status", "pending")
            ->order_by("c.created_at", "ASC")
            ->get()
            ->result();
    }

    // function getDetailPengajuanCuti($id_pengajuan, $role_approval = "pengganti")
    // {
    //     return $this->db
    //         ->select(
    //             '

    //             c.*,
    //             p.nama,
    //             mc.jenis_cuti,
    //             a.status as status_approval,
    //             a.id_pegawai_approval,
    //             a.role_approval
    //         ',
    //         )
    //         ->from("ts_pengajuan_cuti_approval a")
    //         ->join("ts_pengajuan_cuti c", "c.id = a.id_pengajuan_cuti")
    //         ->join("mst_pegawai p", "p.id_pegawai = c.id_pegawai")
    //         ->join("mst_cuti mc", "mc.id = c.jenis_cuti")
    //         ->where("a.id_pengajuan_cuti", $id_pengajuan)
    //         ->where("a.role_approval", $role_approval)
    //         ->order_by("c.created_at", "ASC")
    //         ->get()
    //         ->result();
    // }

    function getListTanggalCuti(
        $tgl_cuti_dari,
        $tgl_cuti_sampai,
        $jns_cuti,
        $jamKerja,
        $hariLibur
    ) {
        $listTanggal = [];

        $start = new DateTime($tgl_cuti_dari);
        $end = new DateTime($tgl_cuti_sampai);
        $end->modify("+1 day"); // supaya tanggal akhir ikut

        $period = new DatePeriod($start, new DateInterval("P1D"), $end);

        foreach ($period as $dt) {
            $tgl = $dt->format("Y-m-d");
            $hari = $dt->format("N"); // 6 = sabtu, 7 = minggu

            // default: hari dihitung
            $hitung = true;

            // jika BUKAN bersalin
            if ($jns_cuti != 2) {
                // jika pegawai reguler
                if ($jamKerja == "non_shift") {
                    // skip sabtu & minggu
                    if ($hari >= 6) {
                        $hitung = false;
                    }

                    // skip hari libur nasional
                    if (in_array($tgl, $hariLibur)) {
                        $hitung = false;
                    }
                }
            }

            if ($hitung) {
                $listTanggal[] = $tgl;
            }
        }

        return $listTanggal;
    }

    function getHariLibur($skipHariLibur, $tgl_cuti_dari, $tgl_cuti_sampai)
    {
        $hariLibur = [];

        if ($skipHariLibur) {
            $libur = $this->db
                ->select("tgl")
                ->from("ts_hari_libur")
                ->where("tgl >=", $tgl_cuti_dari)
                ->where("tgl <=", $tgl_cuti_sampai)
                ->get()
                ->result_array();

            $hariLibur = array_column($libur, "tgl");
        }

        return $hariLibur;
    }

    public function getApproverCuti($id_pegawai, $id_pengganti)
    {
        // kapustu
        $pegawai = $this->db
            ->select("id_validator")
            ->from("mst_pegawai")
            ->where("id_pegawai", $id_pegawai)
            ->get()
            ->row();

        // ktu
        $ktu = $this->db
            ->select("id_pegawai")
            ->from("mst_pegawai")
            ->where("usergroup", 2)
            ->limit(1)
            ->get()
            ->row();

        // kapus
        $kapus = $this->db
            ->select("id_pegawai")
            ->from("mst_pegawai")
            ->where("usergroup", 1)
            ->where("status_kerja", 1)
            ->limit(1)
            ->get()
            ->row();

        return [
            "pengganti" => $id_pengganti,
            "kapustu" => $pegawai->id_validator,
            "ktu" => $ktu->id_pegawai,
            "kapus" => $kapus->id_pegawai,
        ];
    }

    function hitungHariInklusif($start, $end, $format = "Y-m-d")
    {
        $startDate = new DateTime($start);
        $endDate = new DateTime($end);

        // supaya tanggal akhir ikut dihitung
        // $endPlus = (clone $endDate)->modify("+1 day");
        $endPlus = clone $endDate;
        $endPlus->modify('+1 day');

        $period = new DatePeriod($startDate, new DateInterval("P1D"), $endPlus);

        $listTgl = [];
        foreach ($period as $date) {
            $listTgl[] = $date->format($format);
        }

        $jumlah = count($listTgl);

        return [$jumlah, $listTgl];
    }

    public function hitungHariKerja($start, $end, $jenis_jam_kerja)
    {
        $jumlah = 0;

        // $start = new DateTime($start);
        // $end = new DateTime($end);

        $interval = new DateInterval("P1D");
        $daterange = new DatePeriod($start, $interval, $end->modify("+1 day"));

        $arrayTglCuti = [];

        foreach ($daterange as $date) {
            $tgl = $date->format("Y-m-d");
            $dayOfWeek = (int) $date->format("N");

            //N = Non Shift (reguler)
            if ($jenis_jam_kerja == "N") {
                if ($dayOfWeek >= 6) {
                    continue;
                } // Sabtu/Minggu
                if ($this->isLibur($tgl)) {
                    continue;
                } // Hari libur nasional

                array_push($arrayTglCuti, $tgl);
                $jumlah++;
            } elseif ($jenis_jam_kerja === "S") {
                $jumlah++;
                array_push($arrayTglCuti, $tgl);
            }
        }

        //print_array($arrayTglCuti);
        //  exit;
        $this->session->set_userdata("list_tgl_cuti", $arrayTglCuti);
        return $jumlah;
    }

    public function isLibur($tanggal)
    {
        $this->db->where("tgl", $tanggal);
        $query = $this->db->get("ts_hari_libur");
        return $query->num_rows() > 0;
    }

    function getInfoPenggantiCuti($id_pengganti)
    {
        $this->db->where("mst_pegawai.id_pegawai", $id_pengganti);
        $this->db->select(
            "mst_pegawai.nama, mst_pegawai.nip, mst_jabatan.nama AS jabatan, mst_puskesmas.nama AS puskesmas"
        );
        $this->db->from("mst_pegawai");
        $this->db->join(
            "mst_jabatan",
            "mst_pegawai.id_jabatan = mst_jabatan.id"
        );
        $this->db->join(
            "mst_puskesmas",
            "mst_pegawai.id_puskesmas = mst_puskesmas.id_puskesmas"
        );

        $qry = $this->db->get();

        $row = $qry->result();
        return $row;
    }

    function getDetailCuti($id_cuti)
    {
        $qry = $this->db->get_where("ts_cuti", ["id" => $id_cuti]);
        $row = $qry->result();
        return $row;
    }

    public function countCuti($tgl_dari = "", $tgl_sampai = "")
    {
        $jns_cuti = $this->session->userdata("jns_cuti");

        if ($jns_cuti == 0 || $jns_cuti == "") {
            $andJnsCuti = "";
        } else {
            $andJnsCuti = "AND jns_cuti = " . $jns_cuti;
        }

        $sql = "SELECT id FROM ts_cuti WHERE tgl_dari >= '$tgl_dari' AND tgl_sampai <= '$tgl_sampai' $andJnsCuti";

        $qry = $this->db->query($sql);
        $row = $qry->num_rows();

        return $row;
    }

    function getDataCutiPegawai($tgl_dari, $tgl_sampai, $limit, $offset)
    {
        $jns_cuti = $this->session->userdata("jns_cuti");

        $this->db->select(
            "a.*, b.nama, b.id_validator, c.nama AS jabatan, d.photo"
        );
        $this->db->from("ts_cuti a");
        $this->db->join("mst_pegawai b", "a.id_pegawai = b.id_pegawai", "left");
        $this->db->join("mst_jabatan c", "b.id_jabatan = c.id", "left");
        $this->db->join("detail_pegawai d", "b.nip = d.nip", "left");

        if ($jns_cuti == 2) {
            // khusus cuti melahirkan → cek overlap tanggal
            $this->db->where("a.jns_cuti", 2);
            $this->db->where("a.tgl_dari <=", $tgl_sampai);
            $this->db->where("a.tgl_sampai >=", $tgl_dari);
        } else {
            // cuti selain melahirkan → pakai filter biasa
            if ($jns_cuti != 0 && $jns_cuti != "") {
                $this->db->where("a.jns_cuti", $jns_cuti);
            }
            $this->db->where("a.tgl_dari >=", $tgl_dari);
            $this->db->where("a.tgl_sampai <=", $tgl_sampai);
        }

        $this->db->limit($limit, $offset);
        $query = $this->db->get();

        return $query->result();
    }

    //
    //
    // function getDataCutiPegawai($status)
    // {
    // 	if ($status == '' || $status == 'Semua') {
    // 		$where = '';
    // 	} else if ($status == 'Approve') {
    // 		$where = "WHERE status = 'APPROVE'";
    // 	} else if ($status == 'Tolak') {
    // 		$where = "WHERE status = 'REJECT'";
    // 	} else if ($status == 'Batal') {
    // 		$where = "WHERE status = 'CANCEL'";
    // 	} else if ($status == 'Ditangguhkan') {
    // 		$where = "WHERE status = 'HOLD'";
    // 	} else {
    // 		$where = "WHERE status = 'PEND0' OR status = 'PEND1' OR status = 'PEND2' OR status = 'PEND3'";
    // 	}
    //
    //
    // 	$sql = "SELECT a.*, b.nama, b.id_validator, c.nama AS jabatan, d.photo
    // 	FROM ts_cuti a
    // 	LEFT JOIN mst_pegawai b ON a.id_pegawai = b.id_pegawai
    // 	LEFT JOIN mst_jabatan c ON b.id_jabatan = c.id
    // 	LEFT JOIN detail_pegawai d ON b.nip = d.nip $where ";
    // 	$qry = $this->db->query($sql);
    // 	$row = $qry->result();
    // 	return $row;
    // }

    function getCutiByJnsCuti($jns_cuti)
    {
        if ($jns_cuti == "" || $jns_cuti == 0) {
            $where = "";
        } else {
            $where = "WHERE jns_cuti = $jns_cuti";
        }

        $bulan = $this->input->post("bulan");
        $tahun = $this->input->post("tahun");

        if ($bulan == "" || $bulan == 0) {
            $AND = "";
        } else {
            $AND = "(month(tgl_dari) = '$bulan' OR month(tgl_sampai) = '$bulan') AND year(tgl_dari)= '.$tahun.'";

            if ($where == "") {
                $where = " WHERE  " . $AND;
            } else {
                $where = $where . " AND  $AND";
            }
        }

        $sql = "SELECT a.*, b.nama, b.id_validator, c.nama AS jabatan, d.photo
		FROM ts_cuti a
		LEFT JOIN mst_pegawai b ON a.id_pegawai = b.id_pegawai
		LEFT JOIN mst_jabatan c ON b.id_jabatan = c.id
		LEFT JOIN detail_pegawai d ON b.nip = d.nip $where ";
        $qry = $this->db->query($sql);
        $row = $qry->result();

        return $row;
    }
    function getRekapCutiByJnsCuti($id_pegawai, $periode, $jns_cuti)
    {
        $this->db->select("SUM(jml_hari) AS jumlah");
        $qry = $this->db->get_where("ts_rekap_cuti", [
            "id_pegawai" => $id_pegawai,
            "periode" => $periode,
            "jns_cuti" => $jns_cuti,
        ]);
        $row = $qry->result();

        return $row;
    }

    function getHariCutiPegawai($id_pegawai, $bulan, $tahun)
    {
        $sql = "SELECT SUM(hari_cuti) AS hari_cuti FROM `ts_cuti` WHERE id_pegawai = $id_pegawai AND (MONTH(tgl_dari) = '$bulan' OR MONTH(tgl_sampai) = '$tahun') AND YEAR(tgl_dari) = '$tahun'";
        #echo $sql;
        $qry = $this->db->query($sql);
        $row = $qry->result();

        if (!empty($row)) {
            $num = $row[0]->hari_cuti;
        } else {
            $num = 0;
        }

        return $num;
    }

    function getDataCutiPegawaiKasatpel($id_validator)
    {
        $sql = "SELECT a.*, b.nama, c.nama AS jabatan, d.photo
		FROM ts_cuti a
		LEFT JOIN mst_pegawai b ON a.id_pegawai = b.id_pegawai
		LEFT JOIN mst_jabatan c ON b.id_jabatan = c.id
		LEFT JOIN detail_pegawai d ON b.nip = d.nip WHERE (status = 'PEND0' OR status = 'PEND1') AND b.id_validator = $id_validator";
        $qry = $this->db->query($sql);
        $row = $qry->result();
        return $row;
    }

    function getDataCutiPegawaiKTU()
    {
        $sql = "SELECT a.*, b.nama, c.nama AS jabatan, d.photo
		FROM ts_cuti a
		LEFT JOIN mst_pegawai b ON a.id_pegawai = b.id_pegawai
		LEFT JOIN mst_jabatan c ON b.id_jabatan = c.id
		LEFT JOIN detail_pegawai d ON b.nip = d.nip WHERE status = 'PEND2' ";
        $qry = $this->db->query($sql);
        $row = $qry->result();
        return $row;
    }

    function getDataCutiPegawaiPending($status, $id_validator = 0)
    {
        if ($id_validator == 0) {
            $and = "";
        } else {
            $and = "AND b.id_validator = $id_validator ";
        }

        $sql = "SELECT a.*, b.nama, c.nama AS jabatan, d.photo
		FROM ts_cuti a
		LEFT JOIN mst_pegawai b ON a.id_pegawai = b.id_pegawai
		LEFT JOIN mst_jabatan c ON b.id_jabatan = c.id
		LEFT JOIN detail_pegawai d ON b.nip = d.nip WHERE status = '$status'  $and";

        #echo $sql;
        $qry = $this->db->query($sql);
        $row = $qry->result();
        return $row;
    }

    function updateDataCuti(
        $id_cuti,
        $jns_cuti,
        $jns_hak_cuti,
        $date_from,
        $date_to,
        $jml_hari_cuti
    ) {
        $newData = [
            "jns_cuti" => $jns_cuti,
            "jns_hak_cuti" => $jns_hak_cuti,
            "tgl_dari" => format_db($date_from),
            "tgl_sampai" => format_db($date_to),
            "hari_cuti" => $jml_hari_cuti,
        ];

        $this->db->where("id", $id_cuti);
        $this->db->update("ts_cuti", $newData);
        return true;
    }

    function insertLogCuti(
        $id_pegawai,
        $jns_hak,
        $jns_cuti,
        $id_cuti,
        $jumlah_hari,
        $sisa_akhir,
        $ket
    ) {
        $newData = [
            "id_pegawai" => $id_pegawai,
            "jns_hak_cuti" => $jns_hak,
            "jns_cuti" => $jns_cuti, //karena ini bukan permtongan cuti dari pegawai
            "id_cuti" => $id_cuti,
            "jumlah_hari" => $jumlah_hari,
            "sisa_akhir" => $sisa_akhir,
            "keterangan" => $ket
        ];

        $this->db->insert("log_cuti", $newData);
        return true;
    }

    function getSisaCuti($id_pegawai, $jns_hak_cuti)
    {
        $this->db->order_by("id", "DESC");
        $this->db->select("sisa_akhir");
        $qry = $this->db->get_where("log_cuti", [
            "id_pegawai" => $id_pegawai,
            "jns_hak_cuti" => $jns_hak_cuti
        ]);
        $row = $qry->result();

        if (empty($row)) {
            //klo belum pernah ngajuin cuti sama sekali
            //ambil dari tabel cuti pegawai
            $new_row = $this->Pegawai_model->getHakCutiPegawai(
                $id_pegawai,
                $jns_hak_cuti
            );

            if (!empty($new_row)) {
                $sisa_akhir = $new_row[0]->jumlah;
            } else {
                $sisa_akhir = 0;
            }
        } else {
            $sisa_akhir = $row[0]->sisa_akhir;
        }

        return $sisa_akhir;
    }

    public function getHariCuti($datediff, $start_date)
    {
        $hariCuti = 0;
        $arrayHariCuti = [];
        $newDate = $start_date;
        $loop = $datediff;

        for ($a = 0; $a < $loop; $a++) {
            $cekhariLibur = $this->cekHariLiburNasional($newDate);
            $hari_ke = formatDayOfWeek($newDate);
            if ($hari_ke < 6) {
                if ($cekhariLibur == false) {
                    $hariCuti = $hariCuti + 1;
                    $arrayHariCuti[] = $newDate;
                }
            }

            $newDate = addDaysToDate($newDate, 1);
        }

        #countDatecuti dimulai sehari dari tanggal cuti dari, jadi harus tambah dengan tanggal awal cuti agar tgl awal cuti juga dihitung sebagai hari cuti
        #$jumlah_hari_cuti = $countDateCuti+1;

        return [$hariCuti, $arrayHariCuti];
    }

    function updateDataDetailCuti($id_cuti)
    {
        $id_pegawai_pengganti = $this->input->post("id_pegawai_pengganti");
        $alasan_cuti = $this->input->post("alasan_cuti");
        $alamat_cuti = $this->input->post("alamat");
        $no_tlp = $this->input->post("tlp");

        $newData = [
            "alasan_cuti" => $alasan_cuti,
            "alamat_cuti" => $alamat_cuti,
            "no_tlp" => $no_tlp,
            "id_pengganti" => $id_pegawai_pengganti,
        ];

        $this->db->where("id", $id_cuti);
        $this->db->update("ts_cuti", $newData);

        return true;
    }
    function insertDataCuti($file_image = "")
    {
        $date_from = $this->session->userdata("date_from");
        $date_to = $this->session->userdata("date_to");
        $jns_cuti = $this->session->userdata("jns_cuti");
        $jns_hak_cuti = $this->session->userdata("jns_hak_cuti");
        $jml_hari_cuti = $this->session->userdata("jml_hari_cuti");

        $id_pegawai = $this->session->userdata("id_pegawai");

        $id_pegawai_pengganti = $this->input->post("id_pengganti");
        $alasan_cuti = $this->input->post("alasan_cuti");
        $alamat_cuti = $this->input->post("alamat");
        $no_tlp = $this->input->post("tlp");

        $tugas1 = $this->input->post("tugas1");
        $tugas2 = $this->input->post("tugas2");
        $tugas3 = $this->input->post("tugas3");
        $tugas4 = $this->input->post("tugas4");

        $delegasi_tugas =
            $tugas1 . "+" . $tugas2 . "+" . $tugas3 . "+" . $tugas4;

        $newData = [
            "tgl" => date("Y-m-d"),
            "id_pegawai" => $id_pegawai,
            "jns_cuti" => $jns_cuti,
            "jns_hak_cuti" => $jns_hak_cuti,
            "alasan_cuti" => $alasan_cuti,
            "tgl_dari" => format_db($date_from),
            "tgl_sampai" => format_db($date_to),
            "alamat_cuti" => $alamat_cuti,
            "no_tlp" => $no_tlp,
            "hari_cuti" => $jml_hari_cuti,
            "catatan" => "",
            "status" => "PEND0",
            "id_pengganti" => $id_pegawai_pengganti,
            "delegasi_tugas" => $delegasi_tugas,
            "file_image" => $file_image,
        ];

        $this->db->insert("ts_cuti", $newData);

        $idcuti = $this->getLastIDCuti();
        return $idcuti;
    }


    function getCutiPegawaiPerPeriode($id_pegawai, $start, $end)
    {
        return $this->db
            ->from('ts_pengajuan_cuti')
            ->where('id_pegawai', $id_pegawai)
            ->group_start()
            ->where('tgl_mulai <=', $end)
            ->where('tgl_selesai >=', $start)
            ->group_end()
            ->order_by('id', 'DESC')
            ->get()
            ->result();
    }


    function getCutiPegawai($id_pegawai, $periode)
    {
        $sql = "SELECT * FROM ts_pengajuan_cuti WHERE id_pegawai = $id_pegawai AND (tgl_mulai like '$periode%' OR tgl_selesai like '$periode%') ORDER BY id DESC";
        $qry = $this->db->query($sql);
        $row = $qry->result();
        return $row;
    }

    public function get_items($limit, $offset)
    {
        $query = $this->db->get("items", $limit, $offset);
        return $query->result();
    }

    function getHistoryCutiPegawai($id_pegawai)
    {
        $tahun = 2024;
        $sql = "SELECT * FROM ts_cuti WHERE id_pegawai = $id_pegawai AND tgl_dari like '$tahun%' ORDER BY id DESC";
        $qry = $this->db->query($sql);
        $row = $qry->result();
        return $row;
    }

    public function getHistoryCuti($id_pegawai, $tahun)
    {

        if ($tahun > 2025) {
            $this->db
                ->select('a.*, mc.jenis_cuti')
                ->from("ts_pengajuan_cuti a")
                ->join("mst_cuti mc", "mc.id = a.jenis_cuti")
                ->where("a.id_pegawai", $id_pegawai)
                ->like("a.tgl_mulai", $tahun, 'after');
        } else {
            $this->db
                ->select('a.*, mc.jenis_cuti')
                ->from("ts_cuti a")
                ->join("mst_cuti mc", "mc.id = a.jns_cuti")
                ->where("a.id_pegawai", $id_pegawai)
                ->like("a.tgl_dari", $tahun, 'after');
        }

        return $this->db
            ->order_by("a.id", "DESC")
            ->get()
            ->result();
    }


    function getDetailPengajuanCuti($id_pengajuan)
    {
        return $this->db
            ->select(
                'a.*,
                p.nama,
                mc.jenis_cuti
            '
            )
            ->from("ts_pengajuan_cuti a")
            ->join("mst_pegawai p", "p.id_pegawai = a.id_pegawai")
            ->join("mst_cuti mc", "mc.id = a.jenis_cuti")
            ->where("a.id", $id_pengajuan)
            ->order_by("a.created_at", "ASC")
            ->get()
            ->row();
    }



    // function getMyHistoryCuti2()
    // {
    //     $tahun = 2026;
    //     $id_pegawai = $this->session->userdata("id_pegawai");
    //     $sql = "SELECT * FROM ts_pengajuan_cuti WHERE id_pegawai = $id_pegawai ORDER BY id DESC";
    //     $qry = $this->db->query($sql);
    //     $row = $qry->result();
    //     return $row;
    // }

    function getMyHistoryCuti($tahun)
    {
        $id_pegawai = $this->session->userdata('id_pegawai');

        if ($tahun < 2026) {
            $this->db->from('ts_cuti');
            $this->db->like('tgl_dari', $tahun, 'after');
        } else {
            $this->db->from('ts_pengajuan_cuti');
            $this->db->like('tgl_mulai', $tahun, 'after');
        }

        $this->db->where('id_pegawai', $id_pegawai);
        $this->db->order_by('id', 'DESC');

        return $this->db->get()->result();
    }



    function getListPegawaiPenggantiCuti($id_pegawai, $id_jabatan)
    {
        //khusus utk psikolgi
        if ($id_jabatan == 33) {
            $id_jabatan = 1;
        }
        $sql = "SELECT id_pegawai, nama FROM mst_pegawai
        WHERE tahun_anggaran = '2024' AND id_jabatan =  $id_jabatan   AND status_kerja = 1 AND id_pegawai != $id_pegawai";
        $qry = $this->db->query($sql);

        return $qry->result();
    }

    // function getPermohonanPengganti($id_pegawai)
    // {
    //     $qry = $this->db->get_where("ts_cuti", [
    //         "id_pengganti" => $id_pegawai,
    //         "status" => "PEND0",
    //     ]);
    //     $row = $qry->result();
    //     return $row;
    // }

    function insertDataDetailCuti($id_cuti, $id_pegawai, $tanggal)
    {
        $newData = [
            "id_cuti" => $id_cuti,
            "id_pegawai" => $id_pegawai,
            "tanggal" => $tanggal,
            "status" => 1,
        ];

        $this->db->insert("ts_cuti_detail", $newData);
        return true;
    }
    function cekCutiPegawai($tanggal, $id_pegawai)
    {
        $sql = "SELECT id FROM `ts_cuti` WHERE id_pegawai = $id_pegawai AND '$tanggal' BETWEEN tgl_dari and tgl_sampai AND status != 'CANCEL'";
        $qry = $this->db->query($sql);
        $row = $qry->result();
        return $row;
    }

    function cekIzinSakitPegawai($tanggal, $id_pegawai)
    {
        $qry = $this->db->get_where("pengajuan_izin_sakit", [
            "id_pegawai" => $id_pegawai,
            "tanggal" => $tanggal,
        ]);
        $row = $qry->result();
        return $row;
    }

    function getListHariCuti($id_cuti)
    {
        $qry = $this->db->get_where("ts_cuti_detail", ["id_cuti" => $id_cuti]);
        $row = $qry->result();
        return $row;
    }

    function getLastIDCuti()
    {
        $this->db->select("id");
        $this->db->order_by("id", "DESC");
        $qry = $this->db->get("ts_cuti", 1, 0);
        $row = $qry->result();

        $id = $row[0]->id;
        return $id;
    }
    public function cekHariLiburNasional($tgl)
    {
        $qry = $this->db->get_where("ts_hari_libur", ["tgl" => $tgl]);
        $num = $qry->num_rows();

        if ($num == 0) {
            return false;
        } else {
            return true;
        }
    }
}
