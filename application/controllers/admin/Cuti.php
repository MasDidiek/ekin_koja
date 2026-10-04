<?php
defined("BASEPATH") or exit("No direct script access allowed");
class Cuti extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Profile_model");
        $this->load->model('Admin_cuti_model', 'ACM');
        $this->load->model('api/Api_cuti_model');
        $this->load->model('api/Api_absensi_model');
        $this->load->model('api/Master_api_model');
        $this->Auth_model->cekAuthLogin();
    }

    function index()
    {
        $data["history"] = $this->Cuti_model->getMyHistoryCuti();

        $id_pegawai = $this->session->userdata("id_pegawai");
        $nip = $this->session->userdata("nip");
        $data["data_detail"] = $this->Pegawai_model->getDataDetailPegawai($nip);
        $data["pegawai"] = $this->Pegawai_model->getDataEditPegawai(
            $id_pegawai
        );

        $data["master_cuti"] = $this->Master_model->getlistCuti();
        $this->load->view("cuti/my_cuti", $data);
    }

    function filter_cuti()
    {
        $filter = [
            'periode'    => $this->input->get('periode'),
            'date_from'  => $this->input->get('date_from'),
            'date_to'    => $this->input->get('date_to'),
            'status'     => $this->input->get('status'),
            'jenis_cuti' => $this->input->get('jenis_cuti'),
        ];


        // $data['cuti'] = $this->ACM->getListPengajuan($filter);
        $data['cuti'] = $this->ACM->getDataCuti($filter);

        // print_array($data['cuti']);
        // exit;
        $data["listJenisCuti"] = $this->Master_model->getlistCuti();
        $this->load->view('admin/cuti/pengajuan_cuti', $data);
    }




    public function pengajuan_cuti_pegawai($status = '')
    {
        //sebagai validator
        $id_pegawai = $this->session->userdata("id_pegawai"); //id_validator
        $usergroup = $this->session->userdata("usergroup");
        // print_array($this->session->userdata);

        if ($usergroup == 1) {
            $role = "kapus";
        } elseif ($usergroup == 2) {
            $role = "ktu";
        } else {
            $role = "kapustu";
        }


        $data['cuti'] = $this->ACM->getPengajuanCutiPegawai($id_pegawai, $role, $status);
        $data["listJenisCuti"] = $this->Master_model->getlistCuti();
        $this->load->view('admin/cuti/pengajuan_cuti', $data);
        //print_array($cuti);
    }


    public function get_pegawai()
    {
        $term = $this->input->post('term', TRUE);

        $this->db->select('id_pegawai, nama');
        $this->db->from('mst_pegawai');
        $this->db->like('nama', $term);
        $this->db->where('jns_pegawai', 'non_pns');
        $this->db->where('status_kerja >', 0);
        $this->db->limit(10);

        $query = $this->db->get();
        $result = $query->result();

        $data = array();

        foreach ($result as $row) {
            $data[] = array(
                'label' => $row->nama, // yang tampil di dropdown
                'value' => $row->id_pegawai    // yang masuk ke hidden input
            );
        }

        echo json_encode($data);
    }

    function sisa_cuti()
    {
        $tahun = $this->input->get('tahun', true) ?: date('Y');

        //$tahunList = [2025, 2026];

        $this->db->select('
                p.id_pegawai,
                p.nama,
                j.nama as nama_jabatan,
                hc.tahun,
                hc.hak_total,
                hc.hak_terpakai,
                hc.hak_reserved
            ');
        $this->db->where("jns_pegawai", "non_pns");
        $this->db->where("status_kerja >", 0);
        $this->db->from("mst_pegawai p");
        $this->db->join("mst_jabatan j", "j.id = p.id_jabatan", "left");
        $this->db->join(
            "ts_hak_cuti_pegawai hc",
            "hc.id_pegawai = p.id_pegawai AND hc.tahun = " . $tahun,
            "left"
        );
        $this->db->order_by("p.nama", "ASC");

        $query = $this->db->get()->result();

        $data["list"] = $query;
        $data["tahun"] = $tahun;
        $this->load->view("admin/cuti/sisa_cuti", $data);
    }


    function simpanHakCutiBersama()
    {
        $id_pegawai = $this->input->post("id_pegawai");
        $jumlah = $this->input->post("jumlah");
        $tahun = date('Y');

        $data = [
            "id_pegawai" => $id_pegawai,
            "tahun" => $tahun,
            "hak_total" => $jumlah,
            "hak_terpakai" => 0,
            "hak_reserved" => 0
        ];

        $this->db->insert("ts_hak_cuti_bersama", $data);

        redirect("admin/cuti/cuti_bersama?tahun=" . $tahun);
    }


    public function updateHakCutiBersama()
    {
        $id_pegawai      = $this->input->post("id_pegawai");
        $jumlah          = $this->input->post("jumlah");
        $jumlah_terpakai = $this->input->post("jumlah_terpakai");

        $tahun = date('Y');

        $data = [
            "hak_total"     => $jumlah,
            "hak_terpakai"  => $jumlah_terpakai,
            "hak_reserved"  => 0
        ];

        $this->db->where('id_pegawai', $id_pegawai);
        $this->db->where('tahun', $tahun);

        $cek = $this->db->get('ts_hak_cuti_bersama')->row();

        if ($cek) {
            $this->db->where('id_pegawai', $id_pegawai);
            $this->db->where('tahun', $tahun);
            $this->db->update('ts_hak_cuti_bersama', $data);
        } else {
            $data['id_pegawai'] = $id_pegawai;
            $data['tahun'] = $tahun;

            $this->db->insert('ts_hak_cuti_bersama', $data);
        }

        redirect("admin/cuti/cuti_bersama?tahun=" . $tahun);
    }

    function info_detail($id_pegawai)
    {

        $detail_pegawai = $this->Pegawai_model->getDetailPegawai($id_pegawai);
        $data_hak_cuti = $this->Api_cuti_model->getHakCutiPegawai($id_pegawai);
        $data_riwayat  = $this->Api_cuti_model->getRiwayatCutiPegawai($id_pegawai);

        $this->load->view('admin/cuti/info_detail', [
            'detail_pegawai' => $detail_pegawai,
            'hak_cuti' => $data_hak_cuti,
            'riwayat_cuti' => $data_riwayat,
        ]);
    }


    function cuti_bersama()
    {
        $tahun = $this->input->get('tahun', true) ?: date('Y');


        $this->db->select('
                p.id_pegawai,
                p.nama,
                j.nama as nama_jabatan,
                hc.tahun,
                hc.hak_total,
                hc.hak_terpakai,
                hc.hak_reserved
            ');
        $this->db->where("jns_pegawai", "non_pns");
        $this->db->where("status_kerja >", 0);
        $this->db->from("mst_pegawai p");
        $this->db->join("mst_jabatan j", "j.id = p.id_jabatan", "left");
        $this->db->join(
            "ts_hak_cuti_bersama hc",
            "hc.id_pegawai = p.id_pegawai AND hc.tahun = " . $tahun,
            "left"
        );
        $this->db->order_by("p.nama", "ASC");

        $query = $this->db->get()->result();

        $data["list"] = $query;


        $this->load->view("admin/cuti/sisa_cuti_bersama", $data);
    }

    function detail_pengajuan_cuti($id_cuti)
    {
        // $usergroup = $this->session->userdata("usergroup");
        // if ($usergroup == 1) {
        //     $role = "kapus";
        // } elseif ($usergroup == 2) {
        //     $role = "ktu";
        // } else {
        //     $role = "kapustu";
        // }

        // $data["role"] = $role;
        // $data["cuti"] = $this->ACM->getDetailPengajuanCuti(
        //     $id_cuti,
        //     $role
        // );


        $data['cuti'] = $this->Cuti_model->get_detail_pengajuan($id_cuti);
        $this->load->view("admin/cuti/detail_pengajuan_cuti", $data);
    }

    function sisa_cuti_fixed()
    {
        $tahunList = [2025, 2026];

        $this->db->select('
            p.id_pegawai,
            p.nama,
            j.nama as nama_jabatan,
            hc.tahun,
            hc.hak_total,
            hc.hak_terpakai,
            hc.hak_reserved
        ');
        $this->db->where("jns_pegawai", "non_pns");
        $this->db->where("status_kerja >", 0);
        $this->db->from("mst_pegawai p");
        $this->db->join("mst_jabatan j", "j.id = p.id_jabatan", "left");
        $this->db->join(
            "ts_hak_cuti_pegawai hc",
            "hc.id_pegawai = p.id_pegawai AND hc.tahun IN (" .
                implode(",", $tahunList) .
                ")",
            "left"
        );
        $this->db->order_by("p.nama", "ASC");

        $query = $this->db->get()->result();

        $dataPegawai = [];

        foreach ($query as $row) {
            $id = $row->id_pegawai;

            if (!isset($dataPegawai[$id])) {
                $dataPegawai[$id] = [
                    "id_pegawai" => $row->id_pegawai,
                    "nama" => $row->nama,
                    "jabatan" => $row->nama_jabatan,
                    "cuti" => [],
                ];
            }

            if ($row->tahun) {
                $sisa =
                    $row->hak_total - $row->hak_terpakai - $row->hak_reserved;

                $dataPegawai[$id]["cuti"][$row->tahun] = [
                    "hak" => (int) $row->hak_total,
                    "terpakai" => (int) $row->hak_terpakai,
                    "sisa" => max(0, $sisa),
                ];
            }
        }

        $data["list"] = $dataPegawai;
        $data["tahun"] = $tahunList;

        $this->load->view("admin/cuti/sisa_cuti_fixed", $data);
    }

    // function insert_hak_cuti($tahun)
    // {
    //     ///  print_array($this->input->post());
    //     $id_pegawai = $this->input->post("id_pegawai");
    //     $jumlah = $this->input->post("hari");

    //     $newData = [
    //         "id_pegawai" => $id_pegawai,
    //         "hak_cuti_tahun" => $tahun,
    //         "jns_cuti" => "TAHUNAN",
    //         "jns_transaksi" => "OPENING",
    //         "keterangan" => "input sisa cuti tahun " . $tahun,
    //         "sisa_awal" => 0,
    //         "jumlah" => $jumlah,
    //         "sisa_akhir" => $jumlah,
    //         "created_at" => date("Y-m-d H:i:s"),
    //     ];

    //     $this->db->insert("ts_log_cuti", $newData);
    //     redirect("admin/cuti/sisa_cuti");
    // }


    function adjustmentCuti2025()
    {
        $pegawai  = $this->Pegawai_model->getListPegawai('non_pns', 2024);

        $no = 1;
        foreach ($pegawai as $peg) {

            $id_pegawai = $peg->id_pegawai;
            $nip = $peg->nip;
            $nama = $peg->nama;



            $sisaTahunIni = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, 4, 'DESC');
            echo  $peg->nip . ' - ' . $nama . ': ' . $sisaTahunIni . '<br>';

            if ($sisaTahunIni > 5) {
                $sisaTahunIni = 6;

                //$this->Cuti_model->simpanSisaCuti2025($id_pegawai, $sisaTahunIni);
            } else {
                //echo  $peg->nip . ' - ' . $nama . ': ' . $sisaTahunIni . '<br>';
                //  $this->Cuti_model->simpanSisaCuti2025($id_pegawai, $sisaTahunIni);
            }

            $no++;
        }


        echo $no . 'Rows Updated';
    }

    public function simpanSisaCuti2025()
    {
        $idPegawai = $this->input->post("id_pegawai");
        $sisa = (int) $this->input->post("sisa_cuti");

        // cek sudah ada atau belum
        $exist = $this->db
            ->get_where("ts_hak_cuti_pegawai", [
                "id_pegawai" => $idPegawai,
                "tahun" => 2025,
            ])
            ->row();

        if ($exist) {
            // update
            $this->db->where("id", $exist->id)->update("ts_hak_cuti_pegawai", [
                "hak_total" => $sisa,
                "hak_terpakai" => 0,
                "hak_reserved" => 0,
                "updated_at" => date("Y-m-d H:i:s"),
            ]);
        } else {
            // insert
            $this->db->insert("ts_hak_cuti_pegawai", [
                "id_pegawai" => $idPegawai,
                "tahun" => 2025,
                "hak_total" => $sisa,
                "hak_terpakai" => 0,
                "hak_reserved" => 0,
            ]);
        }

        // LOG (WAJIB)
        $this->db->insert("ts_log_mutasi_cuti", [
            "id_pegawai" => $idPegawai,
            "tahun" => 2025,
            "tipe" => "manual",
            "jumlah" => $sisa,
            "saldo_sebelum" => 0,
            "saldo_sesudah" => $sisa,
            "keterangan" => "Adjustment awal sisa cuti 2025",
            "created_by" => $this->session->userdata("id_user"),
        ]);

        $this->session->set_flashdata(
            "success",
            "Sisa cuti 2025 berhasil disimpan"
        );
        redirect("admin/cuti/sisa_cuti");
    }

    public function generateCuti2026()
    {
        $pegawai = $this->db->get("mst_pegawai")->result();

        foreach ($pegawai as $p) {
            $cek = $this->db
                ->get_where("ts_hak_cuti_pegawai", [
                    "id_pegawai" => $p->id_pegawai,
                    "tahun" => 2026,
                ])
                ->row();

            if (!$cek) {
                $this->db->insert("ts_hak_cuti_pegawai", [
                    "id_pegawai" => $p->id_pegawai,
                    "tahun" => 2026,
                    "hak_total" => 12,
                    "hak_terpakai" => 0,
                    "hak_reserved" => 0,
                ]);

                $this->db->insert("ts_log_mutasi_cuti", [
                    "id_pegawai" => $p->id_pegawai,
                    "tahun" => 2026,
                    "tipe" => "manual",
                    "jumlah" => 12,
                    "saldo_sebelum" => 0,
                    "saldo_sesudah" => 12,
                    "keterangan" => "Generate hak cuti awal tahun 2026",
                    "created_by" => $this->session->userdata("id_user"),
                ]);
            }
        }

        $this->session->set_flashdata(
            "success",
            "Hak cuti 2026 berhasil digenerate"
        );
        redirect("admin/cuti/adjustment");
    }

    function pengajuan_cuti($status = "")
    {
        $id_validator_session = $this->session->userdata("id_pegawai");

        $id_pegawai = $this->session->userdata("id_pegawai"); //id_validator
        $usergroup = $this->session->userdata("usergroup");
        // print_array($this->session->userdata);

        if ($usergroup == 1) {
            $role = "kapus";
        } elseif ($usergroup == 2) {
            $role = "ktu";
        } else {
            $role = "kapustu";
        }


        $data['cuti'] = $this->ACM->getPengajuanCutiPegawai($id_pegawai, $role, $status);


        // $data["cuti_pegawai"] = $this->Cuti_model->getPengajuanCutiPegawai(
        //     $id_validator_session,
        //     "kapustu"
        // ); // pengajuan cuti menunggu acc kapustu
        // $data["cuti_pegawai_ktu"] = $this->Cuti_model->getPengajuanCutiPegawai(
        //     $id_validator_session,
        //     "ktu"
        // ); // pengajuan cuti menunggu acc ktu

        $this->load->view("admin/cuti/pengajuan_cuti", $data);
    }


    public function proses_approval()
    {
        $id_pengajuan = $this->input->post('id_pengajuan_cuti');
        $id_approval  = $this->input->post('id_approval');
        $status       = $this->input->post('status'); // approved / rejected / ditangguhkan

        $ttd_digital = $this->input->post('ttd_digital'); // String Base64 dari modal
        $file_name   = NULL;

        // Jika user membubuhkan TTD
        if (!empty($ttd_digital)) {
            // 1. Dekode string Base64
            $image_parts  = explode(";base64,", $ttd_digital);
            $image_base64 = base64_decode($image_parts[1]);

            // 2. Tentukan folder simpan & nama file unik
            $folder_path = FCPATH . 'uploads/ttd_digital/';

            // Buat folder jika belum ada
            if (!is_dir($folder_path)) {
                mkdir($folder_path, 0777, true);
            }

            $file_name = 'ttd_app_' . $id_approval . '_' . time() . '.png';
            $file_path = $folder_path . $file_name;

            // 3. Simpan gambar ke folder uploads/ttd_digital/
            file_put_contents($file_path, $image_base64);
        }

        // 4. Simpan nama file ke database


        // 2. Ambil data pengajuan cuti saat ini
        //$cuti = $this->db->get_where('ts_pengajuan_cuti', ['id' => $id_pengajuan])->row_array();

        if ($status == 'approved') {
            // Cek apakah masih ada level approval berikutnya
            //   $next_step  = $cuti['current_step'] + 1;
            $data_approval = $this->db->get_where('ts_pengajuan_cuti_approval', [
                'id_pengajuan_cuti' => $id_pengajuan,
                'status'    => 'pending'
            ])->row();

            // print_array($data_approval);


            $new_status = 'proses'; //status awal

            $level_approval = $data_approval->level_approval;
            $role_approval   = $data_approval->role_approval;

            $next_step =  $level_approval + 1;

            // exit;

            // =========================================================================
            // FITUR BYPASS LEVEL 4 (KAPUS INDUK)
            // Jika ada step ke-4, otomatis di-approve oleh sistem tanpa perlu menunggu.
            // Jika kelak mau mengaktifkan persetujuan Kapus Induk lagi, HAPUS/COMMENT blok IF ini.
            // =========================================================================
            if ($data_approval && $next_step == 4) {
                // 1. Auto-approve rekord level 4 di database
                $this->db->where('id_pengajuan_cuti', $id_pengajuan);
                $this->db->where('level_approval', 4);
                $this->db->update('ts_pengajuan_cuti_approval', [
                    'status'      => 'approved',
                    'catatan'     => 'Auto-approved (Bypass sistem)',
                    'approved_at' => date('Y-m-d H:i:s')
                ]);

                // 2. Set $check_next menjadi null agar dianggap sudah selesai (step terakhir)
                $check_next = null;
            }
            // =========================================================================

            if ($next_step < 4) {
                // Jika masih ada step selanjutnya (misal baru level 1 mau ke level 2 / 3)
                $this->db->where('id_pengajuan_cuti', $id_pengajuan);
                $this->db->where('level_approval', $next_step);
                $this->db->update('ts_pengajuan_cuti_approval', ['status' => 'pending']);


                $this->db->where('id', $id_pengajuan);
                $this->db->update('ts_pengajuan_cuti', ['current_step' => $next_step]);
            } else {
                // Jika sudah di step terakhir (KTU / Level 3 setelah bypass)

                // 1. Ubah status_akhir pengajuan utama menjadi 'disetujui'
                $this->db->where('id', $id_pengajuan);
                $this->db->update('ts_pengajuan_cuti', [
                    'status_akhir' => 'disetujui'
                ]);

                // 2. Potong hak cuti (Reserved -> Terpakai) HANYA saat pengajuan FINAL DISETUJUI
                $this->Cuti_model->komit_potong_hak_cuti($id_pengajuan);




                $new_status = 'disetujui';
                $this->db->where('id', $id_pengajuan);
                $this->db->set('status_akhir', $new_status);
                $this->db->update('ts_pengajuan_cuti');
            }

            $data_approval = [
                'status'      => $this->input->post('status'),
                'catatan'     => $this->input->post('catatan'),
                'ttd_digital' => $file_name, // Hanya simpan nama file, misal: ttd_app_5_1723123456.png
                'approved_at' => date('Y-m-d H:i:s')
            ];

            $this->db->where('id', $id_approval);
            $this->db->update('ts_pengajuan_cuti_approval', $data_approval);
        } else if ($status == 'rejected') {
            // Jika ditolak, langsung set status_akhir menjadi 'ditolak'
            $this->db->where('id', $id_pengajuan);
            $this->db->update('ts_pengajuan_cuti', [
                'status_akhir' => 'ditolak'
            ]);

            $this->Cuti_model->batal_reserved_hak_cuti($id_pengajuan);
            $new_status = 'ditolak';
        } else if ($status == 'ditangguhkan') {
            // Jika ditangguhkan
            $this->db->where('id', $id_pengajuan);
            $this->db->update('ts_pengajuan_cuti', [
                'status_akhir' => 'ditangguhkan'
            ]);
            $new_status = 'ditangguhkan';
        }



        $this->session->set_flashdata('success', 'Status approval berhasil diperbarui.');
        redirect('admin/pegawai/detail_cuti/' . $id_pengajuan);
    }


    public function setujui_ajax()
    {
        // if (!$this->input->is_ajax_request()) {
        //     show_404();
        // }

        $input = json_decode(file_get_contents("php://input"), true);

        $id_pengajuan = isset($input['id_pengajuan']) ? $input['id_pengajuan'] : null;
        $role_approval = isset($input['role_approval']) ? $input['role_approval'] : 'kapustu';

        $id_pegawai = $this->session->userdata("id_pegawai");

        if (!$id_pengajuan) {
            echo json_encode([
                'status' => false,
                'message' => 'ID pengajuan tidak valid'
            ]);
            return;
        }

        $approval = $this->db
            ->where("id_pengajuan_cuti", $id_pengajuan)
            ->where("role_approval", $role_approval)
            ->where("id_pegawai_approval", $id_pegawai)
            ->where("status", "pending")
            ->get("ts_pengajuan_cuti_approval")
            ->row();


        //print_array($approval);
        if (!$approval) {
            echo json_encode([
                'status' => false,
                'message' => 'Anda tidak berhak atau approval sudah diproses'
            ]);
            return;
        }

        $this->db->trans_start();

        // Approve
        $this->db->where("id", $approval->id)->update(
            "ts_pengajuan_cuti_approval",
            [
                "status" => "approved",
                "approved_at" => date("Y-m-d H:i:s"),
            ]
        );

        // Next step
        if ($role_approval == "kapustu") {
            $this->ACM->updateNextRoleApproval($id_pengajuan, "ktu");
        } elseif ($role_approval == "ktu") {
            $this->ACM->updateNextRoleApproval($id_pengajuan, "kapus");
        } else {
            $this->approveKapusInduk($id_pengajuan, $approval->id);
        }

        $this->db->trans_complete();

        echo json_encode([
            'status' => true,
            'message' => 'Permohonan cuti berhasil disetujui'
        ]);
    }



    public function tolak_ajax()
    {
        // if (!$this->input->is_ajax_request()) {
        //     show_404();
        // }

        $input = json_decode(file_get_contents("php://input"), true);

        $id_pengajuan = isset($input['id_pengajuan']) ? $input['id_pengajuan'] : null;
        $role_approval = isset($input['role_approval']) ? $input['role_approval'] : 'kapustu';


        $alasan        = isset($input['alasan']) ? $input['alasan'] : '';
        $id_pegawai_approval    = $this->session->userdata("id_pegawai");

        if (!$id_pengajuan || !$role_approval || !$alasan) {
            echo json_encode([
                'status' => false,
                'message' => 'Data tidak lengkap'
            ]);
            return;
        }

        $approval = $this->db
            ->where("id_pengajuan_cuti", $id_pengajuan)
            ->where("role_approval", $role_approval)
            ->where("id_pegawai_approval", $id_pegawai_approval)
            ->where("status", "pending")
            ->get("ts_pengajuan_cuti_approval")
            ->row();

        if (!$approval) {
            echo json_encode([
                'status' => false,
                'message' => 'Anda tidak berhak atau data sudah diproses'
            ]);
            return;
        }

        $this->db->trans_start();


        $this->db->where("id", $approval->id)->update(
            "ts_pengajuan_cuti_approval",
            [
                "status"       => "rejected",
                "catatan"       => $alasan,
                "approved_at"  => date("Y-m-d H:i:s"),
            ]
        );

        // Optional: update status utama cuti
        $this->db->where("id", $id_pengajuan)->update(
            "ts_pengajuan_cuti",
            [
                "status_akhir" => "ditolak"
            ]
        );

        //release hak cuti
        $this->ACM->releaseHakCuti($id_pengajuan, $alasan);

        $this->db->trans_complete();

        echo json_encode([
            'status' => true,
            'message' => 'Permohonan cuti berhasil ditolak'
        ]);
    }


    public function approveKapusInduk($id_pengajuan, $id_approval)
    {
        $id_kapus = $this->session->userdata("id_pegawai");



        // // Ambil approval Kapus Induk yang masih pending
        // $approval = $this->db
        //     ->where("id_pengajuan_cuti", $id_pengajuan)
        //     ->where("role_approval", "kapus")
        //     ->where("id_pegawai_approval", $id_kapus)
        //     ->where("status", "pending")
        //     ->get("ts_pengajuan_cuti_approval")
        //     ->row();

        // if (!$approval) {
        //     show_error("Anda tidak berhak atau approval sudah diproses");
        // }



        // Ambil data cuti
        $cuti = $this->db
            ->where("id", $id_pengajuan)
            ->get("ts_pengajuan_cuti")
            ->row();


        $id_pegawai_cuti = $cuti->id_pegawai;
        $jenis_hak_cuti = $cuti->jenis_hak_cuti;
        $hak_tahun = $cuti->tahun_hak_cuti;
        $lama_cuti = $cuti->lama_cuti;

        $this->db->trans_start();

        // 1. Approve Kapus Induk
        $this->db
            ->where("id", $id_approval)
            ->update("ts_pengajuan_cuti_approval", [
                "status" => "approved",
                "approved_at" => date("Y-m-d H:i:s"),
            ]);

        // 2. Update status pengajuan
        $this->db->where("id", $id_pengajuan)->update("ts_pengajuan_cuti", [
            "status_akhir" => "disetujui",
            "updated_at" => date("Y-m-d H:i:s")
        ]);

        // 3. Ambil saldo sebelum
        //
        if ($jenis_hak_cuti == 'tahunan') {
            $rowHak = $this->db
                ->where("id_pegawai", $id_pegawai_cuti)
                ->where("tahun", $hak_tahun)
                ->get("ts_hak_cuti_pegawai")
                ->row();

            $saldo_sebelum =
                $rowHak->hak_total -
                ($rowHak->hak_terpakai + $rowHak->hak_reserved);

            // 4. Pindahkan reserve → terpakai
            //
            //
            $this->db->set("hak_reserved", "hak_reserved - " . $lama_cuti, false);
            $this->db->set("hak_terpakai", "hak_terpakai + " . $lama_cuti, false);
            $this->db->where("id_pegawai", $id_pegawai_cuti);
            $this->db->where("tahun", $hak_tahun);
            $this->db->update("ts_hak_cuti_pegawai");
        } else if ($jenis_hak_cuti == 'bersama') {

            $rowHak = $this->db
                ->where("id_pegawai", $id_pegawai_cuti)
                ->where("tahun", $hak_tahun)
                ->get("ts_hak_cuti_bersama")
                ->row();

            $saldo_sebelum =
                $rowHak->hak_total -
                ($rowHak->hak_terpakai + $rowHak->hak_reserved);

            // 4. Pindahkan reserve → terpakai
            $this->db->set("hak_reserved", "hak_reserved - " . $lama_cuti, false);
            $this->db->set("hak_terpakai", "hak_terpakai + " . $lama_cuti, false);
            $this->db->where("id_pegawai", $id_pegawai_cuti);
            $this->db->where("tahun", $hak_tahun);
            $this->db->update("ts_hak_cuti_bersama");
        }

        // 5. Hitung saldo sesudah
        $saldo_sesudah = $saldo_sebelum - $lama_cuti;


        // 6. Insert log FINAL (JANGAN UPDATE LOG LAMA)
        $this->db->insert("ts_log_mutasi_cuti", [
            "id_pegawai" => $id_pegawai_cuti,
            "tahun" => $hak_tahun,
            "id_pengajuan_cuti" => $id_pengajuan,
            "tipe" => "final",
            "jumlah" => -$lama_cuti,
            "saldo_sebelum" => $saldo_sebelum,
            "saldo_sesudah" => $saldo_sesudah,
            "keterangan" => "Final approval Kapus Induk",
            "created_by" => $id_kapus,
        ]);

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            show_error("Gagal memproses persetujuan cuti");
        }


        return true;
        // $this->session->set_flashdata(
        //     "success",
        //     "Permohonan cuti berhasil disetujui."
        // );
        // redirect("admin/cuti/detail_pengajuan_cuti/" . $id_pengajuan);
    }

    function approve()
    {
        $id_cuti = $this->input->post("id");
        $id_validator_session = $this->session->userdata("id_pegawai");

        $row = $this->db
            ->get_where("tbl_detail_cuti", ["id_cuti" => $id_cuti])
            ->row();
        if (!$row) {
            echo json_encode([
                "status" => false,
                "message" => "Data cuti tidak ditemukan.",
            ]);
            return;
        }

        $alasan_cuti = $row->alasan_cuti;
        $nip = $row->nip;
        $lama_cuti = $row->lama_cuti;
        $list_tgl_cuti = $row->list_tgl_cuti;
        $pin = substr($nip, -4);

        if ($lama_cuti == 1) {
            $tgl_cuti = $list_tgl_cuti;
            $this->Presensi_model->insertAbsensiCuti(
                $tgl_cuti,
                $pin,
                $alasan_cuti
            );
        } else {
            $explode = explode(",", $list_tgl_cuti);
            foreach ($explode as $tgl_cuti) {
                // proses insert absensi cuti
                $this->Presensi_model->insertAbsensiCuti(
                    $tgl_cuti,
                    $pin,
                    $alasan_cuti
                );
            }
        }

        $this->db->select("id_validator");
        $pegawai = $this->db->get_where("mst_pegawai", ["nip" => $nip])->row();
        $id_validator = $pegawai->id_validator;

        //1058 = id pegawai bu muklah
        if ($id_validator == 1058) {
            $data = [
                "check_ktu" => 1,
                "tgl_check_ktu" => date("Y-m-d"),
                "check_kapuskec" => 1,
                "tgl_check2" => date("Y-m-d"),
                "status" => "APPROVE",
            ];

            //langsung approve tanpa harus di approve ktu
        } else {
            $data = [
                "check_kapuskec" => 1,
                "tgl_check2" => date("Y-m-d"),
                "status" => "APPROVE",
            ];
        }

        $this->db->where("id", $id_cuti);
        $update = $this->db->update("ts_cuti", $data);

        if ($update) {
            echo json_encode(["status" => true]);
        } else {
            echo json_encode([
                "status" => false,
                "message" => "Gagal menyetujui pengajuan.",
            ]);
        }
    }

    function cancel_cuti()
    {
        $id_cuti = $this->input->post("id");
        $id_validator_session = $this->session->userdata("id_pegawai");

        $row = $this->db
            ->get_where("ts_log_cuti", ["id_cuti" => $id_cuti])
            ->row();
        if (!$row) {
            echo json_encode([
                "status" => false,
                "message" => "Data cuti tidak ditemukan.",
            ]);
            return;
        }

        $id_pegawai = $row->id_pegawai;
        $jumlah = $row->jumlah;

        $sql = "SELECT sisa_akhir FROM ts_log_cuti WHERE id_pegawai = $id_pegawai ORDER BY id DESC LIMIT 1";
        $query = $this->db->query($sql);
        $row = $query->row();
        $sisa_cuti = $row ? $row->sisa_akhir : 0;

        $sisa_akhir = $sisa_cuti + $jumlah;

        $newData = [
            "id_pegawai" => $id_pegawai,
            "hak_cuti_tahun" => "2025",
            "jns_cuti" => "-",
            "jns_transaksi" => "PEMBATALAN", //karena ini bukan permtongan cuti dari pegawai
            "id_cuti" => $id_cuti,
            "sisa_awal" => $sisa_cuti,
            "jumlah" => $jumlah,
            "sisa_akhir" => $sisa_akhir,
        ];

        // //print_array($newData);

        $this->db->insert("ts_log_cuti", $newData);

        $this->db->where("id", $id_cuti);
        $this->db->set("status", "CANCEL");
        $update = $this->db->update("ts_cuti");

        $this->db->where("id_cuti", $id_cuti);
        $this->db->set("status", "Batal");
        $update = $this->db->update("tbl_detail_cuti");

        if ($update) {
            echo json_encode(["status" => true]);
        } else {
            echo json_encode([
                "status" => false,
                "message" => "Gagal menyetujui pengajuan.",
            ]);
        }
    }

    function ajaxDetailCuti()
    {
        $id_cuti = $this->input->post("id_cuti");
        $data["detail_cuti"] = $this->Cuti_model->getDetailCuti($id_cuti);

        $this->load->view("admin/cuti/view_detail_cuti", $data);
    }

    function ajaxEditCuti()
    {
        $id_cuti = $this->input->post("id_cuti");
        $data["detail_cuti"] = $this->Cuti_model->getDetailCuti($id_cuti);
        $data["master_cuti"] = $this->Master_model->getlistCuti();

        $this->load->view("admin/cuti/form_edit_cuti", $data);
    }

    function update_cuti()
    {
        $id_pegawai = $this->input->post("id_pegawai");
        $id_cuti = $this->input->post("id_cuti");
        $jns_cuti = $this->input->post("jns_cuti");
        $tgl_mulai = $this->input->post("tgl_mulai");
        $tgl_akhir = $this->input->post("tgl_akhir");
        $id_pengganti = $this->input->post("id_pengganti");
        $id_pengganti = $this->input->post("id_pengganti");
        $alasan_cuti = $this->input->post("alasan_cuti");
        $detail_pegawai_pengganti = $this->Pegawai_model->getDetailPegawai(
            $id_pengganti
        );

        $detail_pegawai = $this->Pegawai_model->getDataEditPegawai($id_pegawai);
        $jns_jam_kerja = $detail_pegawai[0]->jns_jam_kerja;
        if ($jns_jam_kerja == "non_shift") {
            $jenis_jam_kerja = "N";
        } else {
            $jenis_jam_kerja = "S";
        }

        if ($jns_cuti == 1) {
            $jumlah = $this->Cuti_model->hitungHariKerja(
                $tgl_mulai,
                $tgl_akhir,
                $jenis_jam_kerja
            );

            $arrayTglCuti = $this->session->userdata("list_tgl_cuti");
            $listTglCuti = implode(",", $arrayTglCuti);
        } else {
            $hitungHari = $this->Cuti_model->hitungHariInklusif(
                $tgl_mulai,
                $tgl_akhir
            );
            $jumlah = $hitungHari[0];
            $listTglCuti = implode($hitungHari[1]);
        }

        $newUpdate = [
            "jns_cuti" => $jns_cuti,
            "alasan_cuti" => $alasan_cuti,
            "tgl_dari" => format_db($tgl_mulai),
            "tgl_sampai" => format_db($tgl_akhir),
            "hari_cuti" => $jumlah,
            "id_pengganti" => $id_pengganti,
        ];

        $this->db->where("id", $id_cuti);
        $this->db->update("ts_cuti", $newUpdate);

        $updateTblCuti = [
            "jns_cuti" => $jns_cuti,
            "alasan_cuti" => $alasan_cuti,
            "tgl_cuti" => format_db($tgl_mulai) . "/" . format_db($tgl_akhir),
            "lama_cuti" => $jumlah,
            "nama_pengganti" => $detail_pegawai_pengganti[0]->nama,
            "alasan_cuti" => $alasan_cuti,
            "list_tgl_cuti" => $listTglCuti,
        ];

        $this->db->where("id_cuti", $id_cuti);
        $this->db->update("tbl_detail_cuti", $updateTblCuti);

        redirect("admin/cuti/pengajuan_cuti");
    }

    function sinkron($id_cuti, $id_pegawai)
    {
        $tahun = 2025;

        $sisa_cuti = $this->Cuti_model->getSisaCutiTahun($id_pegawai, $tahun);

        $qry = $this->db->get_where(
            "tbl_detail_cuti",
            ["id_cuti" => $id_cuti],
            1,
            0
        );
        $log_cuti = $qry->row();

        $qry = $this->db->get_where("ts_cuti", [
            "id_pegawai" => $id_pegawai,
            "tgl_dari LIKE" => "$tahun%",
            "status !=" => "CANCEL",
        ]);
        $cuti = $qry->result();

        foreach ($cuti as $row) {
            $id_cuti = $row->id;
            $jns_cuti = $row->jns_cuti;
            $jns_hak_cuti = $row->jns_hak_cuti;
            $hari_cuti = $row->hari_cuti;
            $alasan_cuti = $row->alasan_cuti;

            $cekLogCuti = $this->Cuti_model->cekLogCuti($id_cuti);

            $sisa_awal = 0;

            if ($jns_hak_cuti == 2) {
                $cuti_tahun = 2024;
            } else {
                $cuti_tahun = 2025;
            }

            $sisa_awal = $this->Cuti_model->getSisaCutiTahun(
                $id_pegawai,
                $cuti_tahun
            );
            $sisa_akhir = $sisa_awal - $hari_cuti;

            if ($jns_cuti == 1) {
                $jenis_cuti = "TAHUNAN";
            } elseif ($jns_cuti == 2) {
                $jenis_cuti = "CB";
                $sisa_awal = 0;
                $sisa_akhir = 0;
            } elseif ($jns_cuti == 3) {
                $jenis_cuti = "CAP";
                $sisa_awal = 0;
                $sisa_akhir = 0;
            } else {
                $jenis_cuti = "SAKIT";
                $sisa_awal = 0;
                $sisa_akhir = 0;
            }

            if ($cekLogCuti) {
                continue;
            }

            $newData = [
                "id_pegawai" => $id_pegawai,
                "hak_cuti_tahun" => $cuti_tahun,
                "jns_cuti" => $jenis_cuti,
                "jns_transaksi" => "PEMAKAIAN",
                "id_cuti" => $id_cuti,
                "keterangan" => $alasan_cuti,
                "sisa_awal" => $sisa_awal,
                "jumlah" => $hari_cuti,
                "sisa_akhir" => $sisa_akhir,
                "created_at" => date("Y-m-d H:i:s"),
            ];

            //$this->db->insert('ts_log_cuti', $newData);

            print_array($newData);
        }

        exit();
        redirect("admin/cuti/pengajuan_cuti");
    }

    function create_session_pengajuan_cuti()
    {
        $this->session->set_userdata([
            "tgl_mulai" => $this->input->post("tgl_mulai"),
            "tgl_akhir" => $this->input->post("tgl_akhir"),
            "jns_cuti" => $this->input->post("jns_cuti"),
        ]);

        $this->load->view("pengajuan_cuti/form_delegasi_tugas");
        redirect("cuti/form_detail_pengajuan_cuti");
    }



    // function edit_cuti($id_pegawai)
    // {
    //     $data["history"] = $this->Cuti_model->getMyHistoryCuti();

    //     $id_pegawai = $this->session->userdata("id_pegawai");
    //     $nip = $this->session->userdata("nip");
    //     $data["data_detail"] = $this->Pegawai_model->getDataDetailPegawai($nip);
    //     $data["pegawai"] = $this->Pegawai_model->getDataEditPegawai( $id_pegawai);

    //     $data["master_cuti"] = $this->Master_model->getlistCuti();
    //     $this->load->view("cuti/my_cuti", $data);
    // }
}
