<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Admin_cuti_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }


    function getCutiPegawai($id_pegawai, $bulan, $tahun)
    {
        $this->db->select('c.*, p.nama, mc.jenis_cuti');
        $this->db->from('ts_pengajuan_cuti c');
        $this->db->join('mst_pegawai p', 'p.id_pegawai = c.id_pegawai');
        $this->db->join('mst_cuti mc', 'mc.id = c.jenis_cuti');

        $this->db->where('c.id_pegawai', $id_pegawai);

        // Buat tanggal awal & akhir bulan
        $start_bulan = date('Y-m-d', strtotime($tahun . '-' . $bulan . '-01'));
        $end_bulan   = date('Y-m-t', strtotime($start_bulan));

        // Logika overlap
        $this->db->where('c.tgl_mulai <=', $end_bulan);
        $this->db->where('c.tgl_selesai >=', $start_bulan);

        return $this->db->order_by('c.tgl_mulai', 'ASC')->get()->result();
    }


    function getDataCuti($filter = [])
    {
        $this->db->select('c.*, p.nama, mc.jenis_cuti');
        $this->db->from('ts_pengajuan_cuti c');
        $this->db->join('mst_pegawai p', 'p.id_pegawai = c.id_pegawai');
        $this->db->join('mst_cuti mc', 'mc.id = c.jenis_cuti');
        // $this->db->join('ts_pengajuan_cuti_approval a', 'a.id_pengajuan_cuti = c.id');
        if (!empty($filter['date_from'])) {
            $this->db->where('c.tgl_selesai >=', $filter['date_from']);
        }

        if (!empty($filter['date_to'])) {
            $this->db->where('c.tgl_mulai <=', $filter['date_to']);
        }

        // Status
        if (!empty($filter['status'])) {
            $this->db->where('c.status_akhir', $filter['status']);
        }

        // Jenis cuti
        if (!empty($filter['jenis_cuti'])) {
            $this->db->where('c.jenis_cuti', $filter['jenis_cuti']);
        }

        return $this->db->order_by('c.tgl_pengajuan', 'DESC')->get()->result();
    }

    public function getListPengajuan($filter = [])
    {
        $this->db->select('c.*, p.nama, mc.jenis_cuti, a.status');
        $this->db->from('ts_pengajuan_cuti c');
        $this->db->join('mst_pegawai p', 'p.id_pegawai = c.id_pegawai');
        $this->db->join('mst_cuti mc', 'mc.id = c.jenis_cuti');
        $this->db->join('ts_pengajuan_cuti_approval a', 'a.id_pengajuan_cuti = c.id');

        // Periode bulan
        if (!empty($filter['periode'])) {
            $this->db->where("DATE_FORMAT(c.tgl_pengajuan, '%Y-%m')", $filter['periode']);
        }

        // Date from - to
        if (!empty($filter['date_from'])) {
            $this->db->where('c.tgl_pengajuan >=', $filter['date_from']);
        }

        if (!empty($filter['date_to'])) {
            $this->db->where('c.tgl_pengajuan <=', $filter['date_to']);
        }

        // Status
        if (!empty($filter['status'])) {
            $this->db->where('c.status_akhir', $filter['status']);
        }

        // Jenis cuti
        if (!empty($filter['jenis_cuti'])) {
            $this->db->where('c.jenis_cuti', $filter['jenis_cuti']);
        }

        return $this->db->order_by('c.tgl_pengajuan', 'DESC')->get()->result();
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

    public function getPengajuanCutiPegawai($id_pegawai, $role_approval = "kapustu", $status = '')
    {
        $this->db
            ->select(
                'c.*,
                    p.nama,
                    mc.jenis_cuti,
                    a.status as status_approval'
            )
            ->from("ts_pengajuan_cuti_approval a")
            ->join("ts_pengajuan_cuti c", "c.id = a.id_pengajuan_cuti")
            ->join("mst_pegawai p", "p.id_pegawai = c.id_pegawai")
            ->join("mst_cuti mc", "mc.id = c.jenis_cuti")
            ->where("a.id_pegawai_approval", $id_pegawai)
            ->where("a.role_approval", $role_approval);

        // 🔑 where status hanya jika diisi
        if ($status !== '') {
            $this->db->where("a.status", $status);
        }

        return $this->db
            ->order_by("c.created_at", "ASC")
            ->get()
            ->result();

        //   echo $this->db->last_query();
    }


    function getDetailPengajuanCuti($id_pengajuan, $role_approval = "pengganti")
    {
        return $this->db
            ->select(
                'c.*,
                p.nama,
                mc.jenis_cuti,
                a.status as status_approval,
                a.id_pegawai_approval,
                a.role_approval'
            )
            ->from("ts_pengajuan_cuti_approval a")
            ->join("ts_pengajuan_cuti c", "c.id = a.id_pengajuan_cuti")
            ->join("mst_pegawai p", "p.id_pegawai = c.id_pegawai")
            ->join("mst_cuti mc", "mc.id = c.jenis_cuti")
            ->where("a.id_pengajuan_cuti", $id_pengajuan)
            ->where("a.role_approval", $role_approval)
            ->order_by("c.created_at", "ASC")
            ->get()
            ->row();
    }


    function getInfoPenggantiCuti($id_pengganti)
    {
        $this->db->where("mst_pegawai.id_pegawai", $id_pengganti);
        $this->db->select(
            "mst_pegawai.nama, mst_pegawai.nip, mst_jabatan.nama AS jabatan,
            mst_puskesmas.nama AS puskesmas"
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

        $row = $qry->row();
        return $row;
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

    function insertHakCuti($table=null, $id_pegawai=null, $tahun=2026, $hak_total=0, $used=0, $process=0){
	//insert
        $newData = array(
            'id_pegawai' => $id_pegawai,
            'tahun' => $tahun,
            'hak_total' => $hak_total, //karena ini bukan permtongan cuti dari pegawai
            'hak_terpakai' => $used,
            'hak_reserved' => $process,
        );

        $insert = $this->db->insert($table, $newData);
        return $insert;

    }

    function updateHakCuti($table=null, $id=1, $hak_total=0, $used=0, $process=0){
        
				$newData = array(
            'hak_total' => $hak_total, //karena ini bukan permtongan cuti dari pegawai
            'hak_terpakai' => $used,
            'hak_reserved' => $process,
        );

        $this->db->where('id', $id);
        $update = $this->db->update($table, $newData);
        return $update;

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


    function getHakCutiBersama($id_pegawai, $tahun)
    {
        $this->db->where("tahun", $tahun);
        $this->db->where("id_pegawai", $id_pegawai);
        $this->db->select("*");
        $this->db->from("ts_hak_cuti_bersama");

        return $this->db->get()->row();
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



    public function tolakPengajuanCuti($id_pengajuan, $role, $id_validator, $alasan)
    {
        $approval = $this->db
            ->where("id_pengajuan_cuti", $id_pengajuan)
            ->where("role_approval", $role)
            ->where("id_pegawai_approval", $id_validator)
            ->where("status", "pending")
            ->get("ts_pengajuan_cuti_approval")
            ->row();

        if (!$approval) {
            return [
                'status' => false,
                'message' => 'Anda tidak berhak atau data sudah diproses'
            ];
        }

        $this->db->trans_start();

        // 1️⃣ Update approval
        $this->db->where("id", $approval->id)->update(
            "ts_pengajuan_cuti_approval",
            [
                "status"      => "rejected",
                "catatan"     => $alasan,
                "approved_at" => date("Y-m-d H:i:s"),
            ]
        );

        // 2️⃣ Update status cuti
        $this->db->where("id", $id_pengajuan)->update(
            "ts_pengajuan_cuti",
            [
                "status_akhir" => "ditolak"
            ]
        );

        // 3️⃣ Release hak cuti (LOG + saldo)
        $this->releaseHakCuti($id_pengajuan, $approval->id_pegawai, $alasan);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return [
                'status' => false,
                'message' => 'Gagal memproses penolakan cuti'
            ];
        }

        return [
            'status' => true,
            'message' => 'Permohonan cuti berhasil ditolak'
        ];
    }


    public function releaseHakCuti($id_pengajuan, $alasan = '')
    {

        // Anti double release
        $exists = $this->db
            ->where("id_pengajuan_cuti", $id_pengajuan)
            ->where("tipe", "release")
            ->get("ts_log_mutasi_cuti")
            ->row();

        if ($exists) {
            return;
        }

        $this->db->trans_start();

        $logs = $this->db
            ->where("id_pengajuan_cuti", $id_pengajuan)
            ->where("tipe", "reserve")
            ->get("ts_log_mutasi_cuti")
            ->result();

        foreach ($logs as $log) {

            $row = $this->db
                ->where("id_pegawai", $log->id_pegawai)
                ->where("tahun", $log->tahun)
                ->get("ts_hak_cuti_pegawai")
                ->row();


            log_message('error', json_encode([
                'id' => $row->id,
                'hak_reserved_sebelum' => $row->hak_reserved,
                'jumlah_release' => $log->jumlah
            ]));
            // print_array($row);

            $sebelum = $row->hak_total - ($row->hak_terpakai + $row->hak_reserved);
            $sesudah = $sebelum + $log->jumlah;

            // Log release
            $this->db->insert("ts_log_mutasi_cuti", [
                "id_pegawai" => $log->id_pegawai,
                "tahun" => $log->tahun,
                "id_pengajuan_cuti" => $id_pengajuan,
                "tipe" => "release",
                "jumlah" => $log->jumlah,
                "saldo_sebelum" => $sebelum,
                "saldo_sesudah" => $sesudah,
                "keterangan" => 'Cuti ditolak : ' . $alasan,
                "created_at" => date('Y-m-d H:i:s')
            ]);

            // Update reserved
            // $this->db->where("id", $row->id)->update("ts_hak_cuti_pegawai", [
            //     "hak_reserved" => $row->hak_reserved - $log->jumlah,
            // ]);

            $this->db->where("id_pegawai", $log->id_pegawai)
                ->where("tahun", $log->tahun)
                ->update("ts_hak_cuti_pegawai", [
                    "hak_reserved" => $row->hak_reserved - $log->jumlah,
                ]);
        }




        $this->db->trans_complete();
    }
}
