<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Cuti extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();

        $this->load->model('Profile_model');
        $this->load->model('Admin_cuti_model', 'ACM');
        $this->Auth_model->cekAuthLogin();
    }

    function index()
    {
        $tahun = $this->uri->segment(3) ?: date('Y');
        $id_pegawai = $this->session->userdata('id_pegawai');
        $nip = $this->session->userdata('nip');
        //echo $thn_cuti;
        $data['history'] = $this->Cuti_model->getHistoryCuti($id_pegawai, $tahun);

        $data['data_detail'] = $this->Pegawai_model->getDataDetailPegawai($nip);
        $data['pegawai'] = $this->Pegawai_model->getDataEditPegawai($id_pegawai);

        $data["tahun"] = [2025, 2026];
        $data["rekap_hak_cuti"] = $this->Cuti_model->get_rekap_cuti_pegawai_by_id($id_pegawai, $data["tahun"]);
        $data['sisa_cuti_bersama'] =  $this->ACM->getHakCutiBersama($id_pegawai, $tahun);

        $data['master_cuti'] = $this->Master_model->getlistCuti();
        $this->load->view('cuti/index',  $data);
    }

    function change_year($tahun = 2025)
    {
        $this->session->set_userdata('tahun_cuti', $tahun);
        redirect('cuti/index');
    }


    // $data['data_gaji'] = $this->Pegawai_model->getDataGajiPegawai($id_pegawai);
    // $data['list_jabatan'] = $this->Master_model->getlistJabatan();
    // $data['list_pendidikan'] = $this->Master_model->getlistPendidikan();
    // $data['list_poli'] = $this->Master_model->getlistPoli();
    // $data['list_puskesmas'] = $this->Master_model->getlistPuskesmas();
    // $data['list_Status'] = $this->Master_model->getlistStatus();
    // $data['list_validator'] = $this->Pegawai_model->getValidator();
    // $data['data_sip'] = $this->Profile_model->getDataSIPSTR($nip, 'sip');
    // $data['data_str'] = $this->Profile_model->getDataSIPSTR($nip, 'str');
    // $data['data_diklat'] = $this->Profile_model->getDataDiklat($nip);

    function buat_pengajuan_cuti($jns_hak_cuti = 1)
    {
        $tahun = date('Y');
        $id_pegawai = $this->session->userdata("id_pegawai");
        $data["master_cuti"] = $this->Master_model->getlistCuti();
        $data["tahun"] = [2025, 2026];
        $data["rekap_hak_cuti"] = $this->Cuti_model->get_rekap_cuti_pegawai_by_id($id_pegawai, $data["tahun"]);
        $data['detail_pegawai'] = $this->Pegawai_model->getDetailPegawai($id_pegawai);
        $data['sisa_cuti_bersama'] =  $this->ACM->getHakCutiBersama($id_pegawai, $tahun);
        $this->load->view('cuti/form_pengajuan_cuti', $data);
    }


    public function hitung()
    {
        $tgl_mulai = $this->input->post("tgl_mulai");
        $tgl_akhir = $this->input->post("tgl_akhir");
        $jenis_jam_kerja = $this->input->post("jenis_jam_kerja");

        // Validasi input kosong
        if (empty($tgl_mulai) || empty($tgl_akhir)) {
            echo json_encode([
                "error" => "Tanggal mulai dan akhir harus diisi",
            ]);
            return;
        }

        // Convert ke DateTime
        try {
            $start = new DateTime($tgl_mulai);
            $end = new DateTime($tgl_akhir);
        } catch (Exception $e) {
            echo json_encode(["error" => "Format tanggal tidak valid"]);
            return;
        }

        // Cek logika tanggal: akhir >= mulai
        if ($end < $start) {
            echo json_encode([
                "error" => "Tanggal akhir tidak boleh sebelum tanggal mulai",
            ]);
            return;
        }

        // Optional: validasi rentang tanggal (misal max 90 hari dari hari ini)
        $today = new DateTime();
        //$maxDate = (clone $today)->modify("+120 days");

        $maxDate = clone $today;
        $maxDate->modify("+120 day");


        if ($start < $today->modify("-14 day") || $end > $maxDate) {
            echo json_encode([
                "error" =>
                "Tanggal cuti harus antara kemarin sampai 120 hari ke depan",
            ]);
            return;
        }


        $id_pegawai = $this->session->userdata("id_pegawai");
        $detail_pegawai    = $this->Pegawai_model->getDataEditPegawai($id_pegawai);
        $jns_jam_kerja     = $detail_pegawai[0]->jns_jam_kerja;
        if ($jns_jam_kerja == 'non_shift') {
            $jenis_jam_kerja = 'N';
        } else {
            $jenis_jam_kerja = 'S';
        }

        $jumlah = $this->Cuti_model->hitungHariKerja($start,  $end,  $jenis_jam_kerja);

        echo json_encode(["jumlah_hari" => $jumlah]);
    }



    function simpan_pengajuan_cuti()
    {
        $id_pegawai   = $this->session->userdata("id_pegawai");

        $jns_cuti        = $this->input->post("jns_cuti");
        $HakCutiDipakai         = $this->input->post("hak_cuti"); //hak cuti mana yg ingin digunakan, bisa tahun ini, tahun lalu atau sisa cuti bersama
        $tgl_cuti_dari   = $this->input->post("tgl_mulai");
        $tgl_cuti_sampai = $this->input->post("tgl_akhir");
        $id_pengganti    = $this->input->post("id_pengganti");
        $no_tlp          = $this->input->post("no_tlp");
        $alasan_cuti     = $this->input->post("alasan_cuti");
        $alamat          = $this->input->post("alamat");
        $delegasi_tugas          = $this->input->post("delegasi_tugas");


        //print_array($this->input->post());
        $this->session->set_userdata($this->input->post());


        $tgl_cuti_dari = format_db($tgl_cuti_dari);
        $tgl_cuti_sampai = format_db($tgl_cuti_sampai);

        $jamKerja = $this->Pegawai_model->checkJenisJamKerja($id_pegawai);

        $skipHariLibur = false;

        if ($jns_cuti == 2) {
            // Cuti Bersalin → semua hari dihitung
            $skipHariLibur = false;
        } else {
            // Tahunan, sakit, alasan penting
            if ($jamKerja == 'non_shift') {
                $skipHariLibur = true;   // lewati sabtu, minggu, libur
            } else {
                $skipHariLibur = false;  // shift → semua hari dihitung
            }
        }

        $hariLibur = $this->Cuti_model->getHariLibur($skipHariLibur, $tgl_cuti_dari, $tgl_cuti_sampai);

        $lamaCuti = hitungHariCuti(
            $tgl_cuti_dari,
            $tgl_cuti_sampai,
            $skipHariLibur,
            $hariLibur
        );

        $this->session->set_userdata('lama_cuti', $lamaCuti);
        // echo $lamaCuti;
        if ($lamaCuti <= 0) {
            $this->session->set_flashdata('error', 'Tanggal yang dipilih tidak menghasilkan hari cuti');
            redirect('cuti/buat_pengajuan_cuti');
        }


        // Default
        $sisaCuti = 0;
        $tipeCutiTahunan = null;
        // Tentukan tipe hak cuti
        if ($HakCutiDipakai === 'cuti_bersama') {
            $jenis_hak_cuti = 'bersama';
            $HakCutiDipakai = date('Y');
        } elseif ($HakCutiDipakai !== 'lainnya') {
            $jenis_hak_cuti = 'tahunan';
        }else{
            $jenis_hak_cuti = 'lainnya';
        }



        // Jika HakCutiTahun == 'lainnya'
        // Tidak perlu cek sisa, tapi tetap lanjut proses berikutnya
        if ($HakCutiDipakai != 'lainnya') {

            $sisaCuti = $this->Cuti_model->getSisaCutiTahunan($id_pegawai, $HakCutiDipakai, $jenis_hak_cuti);

            if ($jns_cuti == 1 && $lamaCuti > $sisaCuti) {
                $this->session->set_flashdata(
                    'error',
                    "Sisa cuti $jenis_hak_cuti tahun $HakCutiDipakai tidak mencukupi. Sisa: $sisaCuti hari"
                );
                redirect('cuti/buat_pengajuan_cuti');
                return;
            }
        }

        $this->db->trans_begin();

        /*
            |--------------------------------------------------------------------------
            | 1. INSERT PENGAJUAN CUTI
            |--------------------------------------------------------------------------
            */

        $dataPengajuan = [
            'id_pegawai'      => $id_pegawai,
            'jenis_cuti'      => $jns_cuti,
            'jenis_hak_cuti'  => $jenis_hak_cuti,
            'tahun_hak_cuti'  => $HakCutiDipakai,
            'lama_cuti'       => $lamaCuti,
            'tgl_pengajuan'   => date('Y-m-d'),
            'tgl_mulai'       => $tgl_cuti_dari,
            'tgl_selesai'     => $tgl_cuti_sampai,
            'id_pengganti'    => $id_pengganti,
            'alamat_cuti'     => $alamat,
            'no_telp'         => $no_tlp,
            'alasan_cuti'     => $alasan_cuti,
            'delegasi_tugas'  => $delegasi_tugas,
            'status_akhir'    => 'draft'
        ];

        $this->db->insert('ts_pengajuan_cuti', $dataPengajuan);
        $id_pengajuan = $this->db->insert_id();


        /*
            |--------------------------------------------------------------------------
            | 2. INSERT DETAIL CUTI
            |--------------------------------------------------------------------------
            */

        $hariLibur   = $this->Cuti_model->getHariLibur($skipHariLibur, $tgl_cuti_dari, $tgl_cuti_sampai);
        $listTanggal = $this->Cuti_model->getListTanggalCuti($tgl_cuti_dari, $tgl_cuti_sampai, $jns_cuti, $jamKerja, $hariLibur);

        if ($jns_cuti != 2) {
            foreach ($listTanggal as $tgl) {

                $this->db->insert('ts_pengajuan_cuti_detail', [
                    'id_pengajuan_cuti' => $id_pengajuan,
                    'tgl_cuti'          => $tgl,
                    'tahun_hak_cuti'    => $HakCutiDipakai
                ]);
            }
        }


        /*
            |--------------------------------------------------------------------------
            | 3. INSERT WORKFLOW APPROVAL
            |--------------------------------------------------------------------------
            */

        $approver = $this->Cuti_model->getApproverCuti($id_pegawai, $id_pengganti);

        $workflow = [
            ['level' => 1, 'role' => 'pengganti', 'id' => $approver['pengganti']],
            ['level' => 2, 'role' => 'kapustu', 'id' => $approver['kapustu']],
            ['level' => 3, 'role' => 'ktu', 'id' => $approver['ktu']],
            ['level' => 4, 'role' => 'kapus', 'id' => $approver['kapus']],
        ];

        foreach ($workflow as $w) {

            $this->db->insert('ts_pengajuan_cuti_approval', [
                'id_pengajuan_cuti'     => $id_pengajuan,
                'level_approval'        => $w['level'],
                'role_approval'         => $w['role'],
                'id_pegawai_approval'   => $w['id'],
                'status'                => ($w['level'] == 1 ? 'pending' : 'waiting')
            ]);
        }


        /*
            |--------------------------------------------------------------------------
            | 4. LOG MUTASI CUTI (HANYA UNTUK CUTI YANG PUNYA SALDO)
            |--------------------------------------------------------------------------
            */

        if ($HakCutiDipakai != 'lainnya') {

            $saldo_sebelum = $sisaCuti;
            $saldo_sesudah = $saldo_sebelum - $lamaCuti;

            if ($saldo_sesudah < 0) {

                $this->db->trans_rollback();

                $this->session->set_flashdata(
                    'error',
                    "Sisa cuti tidak mencukupi"
                );

                redirect('cuti/buat_pengajuan_cuti');
                return;
            }

            $this->db->insert('ts_log_mutasi_cuti', [
                'id_pegawai'         => $id_pegawai,
                'tahun'              => $HakCutiDipakai,
                'id_pengajuan_cuti'  => $id_pengajuan,
                'tipe'               => 'reserve',
                'jumlah'             => $lamaCuti,
                'saldo_sebelum'      => $saldo_sebelum,
                'saldo_sesudah'      => $saldo_sesudah,
                'keterangan'         => 'Reserve pengajuan cuti'
            ]);
        }


        /*
            |--------------------------------------------------------------------------
            | 5. UPDATE SALDO CUTI
            |--------------------------------------------------------------------------
            */

        if ($jenis_hak_cuti == 'tahunan') {

            $this->db->set('hak_reserved', 'hak_reserved+' . $lamaCuti, false);
            $this->db->where('id_pegawai', $id_pegawai);
            $this->db->where('tahun', $HakCutiDipakai);
            $this->db->update('ts_hak_cuti_pegawai');
        } else if ($jenis_hak_cuti == 'bersama') {

            $this->db->set('hak_reserved', 'hak_reserved+' . $lamaCuti, false);
            $this->db->where('id_pegawai', $id_pegawai);
            $this->db->where('tahun', $HakCutiDipakai);
            $this->db->update('ts_hak_cuti_bersama');
        }


        /*
            |--------------------------------------------------------------------------
            | 6. COMMIT / ROLLBACK
            |--------------------------------------------------------------------------
            */

        if ($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();

            $this->session->set_flashdata('error', 'Pengajuan cuti gagal disimpan');
        } else {

            $this->db->trans_commit();

            $this->session->set_flashdata('success', 'Pengajuan cuti berhasil dibuat');
        }



        redirect('cuti/summary_pengajuan_cuti/' . $id_pengajuan);
    }



    function summary_pengajuan_cuti($id_cuti = 0)
    {

        $data['cuti'] = $this->Cuti_model->get_detail_pengajuan($id_cuti);
		

        $this->load->view('cuti/summary_pengajuan_cuti', $data);
    }

    function delete_cuti($id_cuti) {
        //ts pengajuan cuti approval
        //ts pengajuan cuti detail

         $this->db->where('id_pengajuan_cuti', $id_cuti);
        $this->db->delete('ts_log_mutasi_cuti');

        $this->db->where('id_pengajuan_cuti', $id_cuti);
        $this->db->delete('ts_pengajuan_cuti_approval');

        $this->db->where('id_pengajuan_cuti', $id_cuti);
        $this->db->delete('ts_pengajuan_cuti_detail');

        $this->db->where('id', $id_cuti);
        $this->db->delete('ts_pengajuan_cuti');

        $this->session->set_flashdata('success', 'Pengajuan cuti berhasil dihapus');
        redirect('cuti/index');
    }



    function detail_cuti($id_cuti)
    {

        $data['cuti'] = $this->ACM->getDetailPengajuanCuti($id_cuti);
        $this->load->view('cuti/detail_pengajuan_cuti', $data);
    }


    function edit_cuti($id_cuti)
    {
        $id_pegawai = $this->session->userdata('id_pegawai');
        $nip = $this->session->userdata('nip');
        //echo $thn_cuti;
        $data["master_cuti"] = $this->Master_model->getlistCuti();
        $data["tahun"] = [2025, 2026];
        $data["rekap_hak_cuti"] = $this->Cuti_model->get_rekap_cuti_pegawai_by_id($id_pegawai, $data["tahun"]);

        $data['detail_pegawai'] = $this->Pegawai_model->getDetailPegawai($id_pegawai);
        $data['detail_cuti'] = $this->Cuti_model->getDetailPengajuanCuti($id_cuti);
        $this->load->view('cuti/form_edit_cuti', $data);
    }



    function update_pengajuan_cuti($id_pengajuan)
    {

        $id_pegawai   = $this->session->userdata("id_pegawai");

        $jns_cuti        = $this->input->post("jns_cuti");
        $HakCutiTahun        = $this->input->post("hak_cuti");
        $tgl_cuti_dari   = $this->input->post("tgl_mulai");
        $tgl_cuti_sampai = $this->input->post("tgl_akhir");
        $id_pengganti    = $this->input->post("id_pengganti");
        $no_tlp          = $this->input->post("no_tlp");
        $alasan_cuti     = $this->input->post("alasan_cuti");
        $alamat          = $this->input->post("alamat");
        $delegasi_tugas          = $this->input->post("delegasi_tugas");

        $this->session->set_userdata($this->input->post());


        $tgl_cuti_dari = format_db($tgl_cuti_dari);
        $tgl_cuti_sampai = format_db($tgl_cuti_sampai);

        $jamKerja = $this->Pegawai_model->checkJenisJamKerja($id_pegawai);

        $skipHariLibur = false;

        if ($jns_cuti == 2) {
            // Cuti Bersalin → semua hari dihitung
            $skipHariLibur = false;
        } else {
            // Tahunan, sakit, alasan penting
            if ($jamKerja == 'non_shift') {
                $skipHariLibur = true;   // lewati sabtu, minggu, libur
            } else {
                $skipHariLibur = false;  // shift → semua hari dihitung
            }
        }

        $hariLibur = $this->Cuti_model->getHariLibur($skipHariLibur, $tgl_cuti_dari, $tgl_cuti_sampai);

        $lamaCuti = hitungHariCuti(
            $tgl_cuti_dari,
            $tgl_cuti_sampai,
            $skipHariLibur,
            $hariLibur
        );

        $this->session->set_userdata('lama_cuti', $lamaCuti);
        // echo $lamaCuti;
        if ($lamaCuti <= 0) {
            $this->session->set_flashdata('error', 'Tanggal yang dipilih tidak menghasilkan hari cuti');
            redirect('cuti/buat_pengajuan_cuti/' . $id_pengajuan);
        }

        $sisaCuti = $this->Cuti_model->getSisaCutiTahunan($id_pegawai, $HakCutiTahun);

        if ($jns_cuti == 1 && $lamaCuti > $sisaCuti) {
            $this->session->set_flashdata(
                'error',
                "Sisa cuti tahun $HakCutiTahun tidak mencukupi. Sisa: $sisaCuti hari"
            );
            redirect('cuti/buat_pengajuan_cuti');
        }


        //1. insert ke table ts_pengajuan_cuti
        $dataPengajuan = [
            'jenis_cuti'      => $jns_cuti,
            'tahun_hak_cuti'  => $HakCutiTahun,
            'lama_cuti'       => $lamaCuti,
            'tgl_mulai'       => $tgl_cuti_dari,
            'tgl_selesai'     => $tgl_cuti_sampai,
            'id_pengganti'    => $id_pengganti,
            'alamat_cuti'     => $alamat,
            'no_telp'         => $no_tlp,
            'alasan_cuti'     => $alasan_cuti,
            'delegasi_tugas'  => $delegasi_tugas
        ];

        $this->db->where('id', $id_pengajuan);
        $this->db->update('ts_pengajuan_cuti', $dataPengajuan);

        //2. insert ke table ts_pengajuan_cuti_detail

        $hariLibur   = $this->Cuti_model->getHariLibur($skipHariLibur, $tgl_cuti_dari, $tgl_cuti_sampai);
        $listTanggal = $this->Cuti_model->getListTanggalCuti($tgl_cuti_dari, $tgl_cuti_sampai, $jns_cuti, $jamKerja, $hariLibur);


        $this->db->where('id_pengajuan_cuti', $id_pengajuan);
        $this->db->delete('ts_pengajuan_cuti_detail');

        if ($jns_cuti != 2) {
            foreach ($listTanggal as $tgl) {
                $this->db->insert('ts_pengajuan_cuti_detail', [
                    'id_pengajuan_cuti' => $id_pengajuan,
                    'tgl_cuti' => $tgl,
                    'tahun_hak_cuti' => $HakCutiTahun
                ]);
            }
        }
        //3. insert ts_pengajuan_cuti_detail




        $this->db->where('id_pengajuan_cuti', $id_pengajuan);
        $this->db->delete('ts_log_mutasi_cuti');

        $this->db->insert('ts_log_mutasi_cuti', [
            'id_pegawai'         => $id_pegawai,
            'tahun'             => $HakCutiTahun,
            'id_pengajuan_cuti' => $id_pengajuan,
            'tipe'              => 'reserve',
            'jumlah'            => $lamaCuti,
            'saldo_sebelum'     => $sisaCuti,
            'saldo_sesudah'     => $sisaCuti - $lamaCuti,
            'keterangan'        => 'Reserve pengajuan cuti'
        ]);
        //5. insert ke table ts_hak_cuti_pegawai

        $this->db->set('hak_reserved', 'hak_reserved+' . $lamaCuti, false);
        $this->db->where('id_pegawai', $id_pegawai);
        $this->db->where('tahun', $HakCutiTahun);
        $this->db->update('ts_hak_cuti_pegawai');

        $this->session->set_flashdata('success', 'Pengajuan cuti berhasil disimpan');


        redirect('cuti/summary_pengajuan_cuti/' . $id_pengajuan);
    }

    function approve_penggantian_cuti($id_pengajuan){

        $id_pegawai    = $this->session->userdata('id_pegawai');
        $data_approval = $this->db->get_where('ts_pengajuan_cuti_approval', [
            'id_pengajuan_cuti' => $id_pengajuan,
            'status'    => 'pending'
        ])->row();

        $new_status = 'proses'; //status awal

        $level_approval = $data_approval->level_approval;
        $next_step =  $level_approval+1;

        $this->db->where('id_pengajuan_cuti', $id_pengajuan);
        $this->db->where('id_pegawai_approval', $id_pegawai );
        $this->db->update('ts_pengajuan_cuti_approval', [
            'status'      => 'approved',
            'approved_at' => date('Y-m-d H:i:s')
        ]);
        

        $this->db->where('id_pengajuan_cuti', $id_pengajuan);
        $this->db->where('level_approval', $next_step);
        $this->db->update('ts_pengajuan_cuti_approval', ['status' => 'pending']);


        $this->db->where('id', $id_pengajuan);
        $this->db->update('ts_pengajuan_cuti', ['current_step' => $next_step, 'status_akhir'=> $new_status]);

        $this->session->set_flashdata('success', 'Permohonan penggantian pegawai cuti berhasil disetujui');
        redirect('dashboard/index');
    }

    function check_date()
    {
        $id_pegawai = $this->session->userdata('id_pegawai');
        $now        = date('Y-m-d');
        $date_from  =  $this->input->post('date_from');
        $date_to    =  $this->input->post('date_to');

        $start_date = format_db($date_from);
        $end_date   = format_db($date_to);

        $this->session->set_userdata($this->input->post());


        $selisihhari =  datediff('d', $start_date, $end_date);
        //selesih hari jika cuti yang  hari dianggap 0 hari, maka dari itu harus ditambah 1 hari
        $selisihhari = $selisihhari + 1;

        if ($selisihhari < 1) {

            //salah memasukkan tanggal (tanggal akhir lebih kecil dari pada tanggal dari)
            $pesan =  createMessageInfo('Tanggal tidak valid, Periksa kembali tanggal cuti ', 'danger');
            $this->session->set_flashdata('message', $pesan);

            redirect('cuti/buat_pengajuan_cuti');
        }



        $jns_cuti     =  $this->input->post('jns_cuti');
        $jns_hak_cuti =  $this->input->post('jns_hak_cuti');

        $jamKerja     = $this->Pegawai_model->checkJenisJamKerja($id_pegawai);


        if ($jns_cuti == 1) {
            //klo cuti tahunan
            /* proses cek hari cuti yang diajukan..   */

            if ($start_date < $now) {
                $diff_date = dateDifference($start_date, $now);


                //klo tanggal cuti lebih kecil dari tanggal hari ini//cek apakah sudah melebihi 14 hari
                if ($diff_date > 40) {
                    //klo mengajukan cuti tanggal sudah terlewat, maksimal 14 hari dari hari ini
                    $pesan =  createMessageInfo('Pengajuan cuti untuk tanggal yang sudah lewat, <strong>maksimal 14 hari</strong> dari hari ini!', 'danger');
                    $this->session->set_flashdata('message', $pesan);

                    redirect('cuti/buat_pengajuan_cuti');
                }
            }


            $cekSisaCuti = $this->Cuti_model->getSisaCuti($id_pegawai, $jns_hak_cuti);
            if ($cekSisaCuti == 0) {
                $pesan =  createMessageInfo('Sisa cuti tidak mencukupi', 'danger');
                $this->session->set_flashdata('message', $pesan);

                redirect('cuti/buat_pengajuan_cuti');
            }


            if ($jamKerja == 'non_shift') {


                if ($selisihhari > 1) {
                    //klo cuti lebih dari 1 hari
                    $dataCuti = $this->Cuti_model->getHariCuti($selisihhari, $start_date);
                    $hariCuti = $dataCuti[0];
                    $listhariCuti = $dataCuti[1];
                } else {
                    $hariCuti = 1;
                    $listhariCuti = array($start_date);
                }


                if ($cekSisaCuti < $hariCuti) {
                    $pesan =  createMessageInfo('Sisa cuti tidak mencukupi', 'danger');
                    $this->session->set_flashdata('message', $pesan);

                    redirect('cuti/buat_pengajuan_cuti');
                } else {

                    $this->session->set_userdata('jml_hari_cuti', $hariCuti);
                    $this->session->set_userdata('list_hari_cuti', $listhariCuti);

                    redirect('cuti/pengajuan_cuti_step2');
                }
            } else {

                $arrayHariCuti = array();
                $datetime1 = date_create($start_date);
                $datetime2 = date_create($end_date);
                // Calculates the difference between DateTime objects
                $interval = date_diff($datetime1, $datetime2);
                $hariCuti =  $interval->format('%a') + 1;
                $newDate      = $start_date;
                for ($a = 0; $a < $hariCuti; $a++) {


                    $arrayHariCuti[] = $newDate;
                    $newDate = addDaysToDate($newDate, 1);
                }


                $this->session->set_userdata('jml_hari_cuti', $hariCuti);
                $this->session->set_userdata('list_hari_cuti', $arrayHariCuti);
                //klo pegawai jam kerja shift
                redirect('cuti/pengajuan_cuti_step2');
            }
        } else {

            if ($jns_cuti == 3 || $jns_cuti == 4) {
                //utk cuti alasan penting atau cuti sakit
                if ($jamKerja == 'non_shift') {


                    if ($selisihhari > 1) {
                        //klo cuti lebih dari 1 hari
                        $dataCuti = $this->Cuti_model->getHariCuti($selisihhari, $start_date);
                        $hariCuti = $dataCuti[0];
                        $listhariCuti = $dataCuti[1];
                    } else {
                        $hariCuti = 1;
                        $listhariCuti = array($start_date);
                    }


                    $this->session->set_userdata('jml_hari_cuti', $hariCuti);
                    $this->session->set_userdata('list_hari_cuti', $listhariCuti);

                    redirect('cuti/pengajuan_cuti_step2');
                } else {

                    $arrayHariCuti = array();
                    $datetime1 = date_create($start_date);
                    $datetime2 = date_create($end_date);
                    // Calculates the difference between DateTime objects
                    $interval = date_diff($datetime1, $datetime2);
                    $hariCuti =  $interval->format('%a') + 1;
                    $newDate      = $start_date;
                    for ($a = 0; $a < $hariCuti; $a++) {


                        $arrayHariCuti[] = $newDate;
                        $newDate = addDaysToDate($newDate, 1);
                    }


                    $this->session->set_userdata('jml_hari_cuti', $hariCuti);
                    $this->session->set_userdata('list_hari_cuti', $arrayHariCuti);
                    //klo pegawai jam kerja shift
                    redirect('cuti/pengajuan_cuti_step2');
                }
            } else {
                //jenis cuti yang lain, cuti bersalin, cuti alasan penting tidak perlu cek sisa cuti
                $datetime1 = date_create($start_date);
                $datetime2 = date_create($end_date);
                // Calculates the difference between DateTime objects
                $interval = date_diff($datetime1, $datetime2);
                $hariCuti =  $interval->format('%a') + 1;




                $this->session->set_userdata('jml_hari_cuti', $hariCuti);
            }


            redirect('cuti/pengajuan_cuti_step2');
        }
    }

    public function cancel()
    {
        $id_pegawai = $this->session->userdata('id_pegawai');
        $input = json_decode(file_get_contents("php://input"), true);

        $id_pengajuan  = $input['id_pengajuan'] ?: null;
        // Ambil pengajuan
        $cuti = $this->db
            ->where('id', $id_pengajuan)
            ->where('id_pegawai', $id_pegawai)
            ->get('ts_pengajuan_cuti')
            ->row();

        if (!$cuti) {
            show_error("Data cuti tidak ditemukan");
        }


        if ($cuti->status_akhir == 'disetujui') {
            show_error("Cuti sudah final, tidak bisa dibatalkan");
        }

        $lama_cuti = $cuti->lama_cuti;
        $hak_tahun = $cuti->tahun_hak_cuti;
        $jns_hak_cuti = $cuti->jenis_hak_cuti;;


        $this->db->trans_start();

        // 1. Update status pengajuan
        $this->db->where('id', $id_pengajuan)
            ->update('ts_pengajuan_cuti', [
                'status_akhir' => 'dibatalkan',
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        // 2. Matikan semua approval
        $this->db->where('id_pengajuan_cuti', $id_pengajuan)
            ->where('status', 'pending')
            ->update('ts_pengajuan_cuti_approval', [
                'status' => 'cancelled'
            ]);

        // 3. Ambil saldo sebelum


        if($jns_hak_cuti !='lainnya'){
            $hak_tahun = $cuti->tahun_hak_cuti;

                if($jns_hak_cuti=='tahunan'){
                    $rowHak = $this->db
                        ->where('id_pegawai', $id_pegawai)
                        ->where('tahun', $hak_tahun)
                        ->get('ts_hak_cuti_pegawai')
                        ->row();
                }else{
                    $rowHak = $this->db
                        ->where('id_pegawai', $id_pegawai)
                        ->where('tahun', $hak_tahun)
                        ->get('ts_hak_cuti_bersama')
                        ->row();
                }


                $saldo_sebelum = $rowHak->hak_total - ($rowHak->hak_terpakai + $rowHak->hak_reserved);

                // 4. Lepaskan reserve
                $this->db->set('hak_reserved', 'hak_reserved - ' . $lama_cuti, false);
                $this->db->where('id_pegawai', $id_pegawai);
                $this->db->where('tahun', $hak_tahun);
                $this->db->update('ts_hak_cuti_pegawai');

                $saldo_sesudah = $saldo_sebelum + $lama_cuti;

                // 5. Log RELEASE
                $this->db->insert('ts_log_mutasi_cuti', [
                    'id_pegawai' => $id_pegawai,
                    'tahun' => $hak_tahun,
                    'id_pengajuan_cuti' => $id_pengajuan,
                    'tipe' => 'release',
                    'jumlah' => $lama_cuti,
                    'saldo_sebelum' => $saldo_sebelum,
                    'saldo_sesudah' => $saldo_sesudah,
                    'keterangan' => 'Pengajuan dibatalkan oleh pegawai',
                    'created_by' => $id_pegawai
                ]);
        }



        $this->db->trans_complete();


        echo json_encode([
            'status' => true,
            'message' => 'Pengajuan cuti berhasil dibatalkan'
        ]);
    }




    function edit_tanggal_cuti($id_cuti)
    {
        $id_pegawai = $this->session->userdata('id_pegawai');
        $now        = date('Y-m-d');
        $date_from  =  $this->input->post('date_from');
        $date_to    =  $this->input->post('date_to');

        $start_date = format_db($date_from);
        $end_date   = format_db($date_to);

        $this->session->set_userdata($this->input->post());


        $selisihhari =  datediff('d', $start_date, $end_date);
        //selesih hari jika cuti yang  hari dianggap 0 hari, maka dari itu harus ditambah 1 hari
        $selisihhari = $selisihhari + 1;

        if ($selisihhari < 1) {

            //salah memasukkan tanggal (tanggal akhir lebih kecil dari pada tanggal dari)
            $pesan =  createMessageInfo('Tanggal tidak valid, Periksa kembali tanggal cuti ', 'danger');
            $this->session->set_flashdata('message', $pesan);

            redirect('cuti/edit_cuti/' . $id_cuti);
        }



        $jns_cuti     =  $this->input->post('jns_cuti');
        $jns_hak_cuti =  $this->input->post('jns_hak_cuti');

        $jamKerja     = $this->Pegawai_model->checkJenisJamKerja($id_pegawai);


        if ($jns_cuti == 1 || $jns_cuti == 3 || $jns_cuti == 4) {
            //klo cuti tahunan
            /* proses cek hari cuti yang diajukan..   */

            if ($start_date < $now) {
                $diff_date = dateDifference($start_date, $now);
                //klo tanggal cuti lebih kecil dari tanggal hari ini//cek apakah sudah melebihi 14 hari
                if ($diff_date > 30) {
                    //klo mengajukan cuti tanggal sudah terlewat, maksimal 14 hari dari hari ini
                    $pesan =  createMessageInfo('Pengajuan cuti untuk tanggal yang sudah lewat, <strong>maksimal 14 hari</strong> dari hari ini!', 'danger');
                    $this->session->set_flashdata('message', $pesan);

                    redirect('cuti/edit_cuti/' . $id_cuti);
                }
            }

            $cekSisaCuti = $this->Cuti_model->getSisaCuti($id_pegawai, $jns_hak_cuti);
            if ($cekSisaCuti == 0) {
                $pesan =  createMessageInfo('Sisa cuti tidak mencukupi', 'danger');
                $this->session->set_flashdata('message', $pesan);

                redirect('cuti/edit_cuti/' . $id_cuti);
            }


            if ($jamKerja == 'non_shift') {


                if ($selisihhari > 1) {
                    //klo cuti lebih dari 1 hari
                    $dataCuti = $this->Cuti_model->getHariCuti($selisihhari, $start_date);
                    $hariCuti = $dataCuti[0];
                    $listhariCuti = $dataCuti[1];
                } else {
                    $hariCuti = 1;
                    $listhariCuti = array($start_date);
                }


                if ($cekSisaCuti < $hariCuti) {
                    $pesan =  createMessageInfo('Sisa cuti tidak mencukupi', 'danger');
                    $this->session->set_flashdata('message', $pesan);

                    redirect('cuti/edit_cuti/' . $id_cuti);
                } else {

                    $pesan =  createMessageInfo('Cuti berhasil diupdate', 'success');
                    $this->session->set_flashdata('message', $pesan);

                    $this->Cuti_model->updateDataCuti($id_cuti, $jns_cuti, $jns_hak_cuti, $start_date, $end_date, $hariCuti);

                    $this->db->where('id_cuti', $id_cuti);
                    $this->db->delete('ts_cuti_detail');


                    for ($i = 0; $i < count($listhariCuti); $i++) {
                        $tanggal = $listhariCuti[$i];
                        $this->Cuti_model->insertDataDetailCuti($id_cuti, $id_pegawai, $tanggal);
                    }

                    redirect('cuti/edit_cuti/' . $id_cuti);
                }
            } else {
                #$hariCuti =  datediff('d', $start_date, $end_date);

                $arrayHariCuti = array();
                $datetime1 = date_create($start_date);
                $datetime2 = date_create($end_date);
                // Calculates the difference between DateTime objects
                $interval = date_diff($datetime1, $datetime2);
                $hariCuti =  $interval->format('%a') + 1;
                $newDate      = $start_date;
                for ($a = 0; $a < $hariCuti; $a++) {


                    $arrayHariCuti[] = $newDate;
                    $newDate = addDaysToDate($newDate, 1);
                }

                $pesan =  createMessageInfo('Cuti berhasil diupdate', 'success');
                $this->session->set_flashdata('message', $pesan);
                $this->Cuti_model->updateDataCuti($id_cuti, $jns_cuti, $jns_hak_cuti, $start_date, $end_date, $hariCuti);


                $this->db->where('id_cuti', $id_cuti);
                $this->db->delete('ts_cuti_detail');

                for ($i = 0; $i < count($arrayHariCuti); $i++) {
                    $tanggal = $arrayHariCuti[$i];
                    $this->Cuti_model->insertDataDetailCuti($id_cuti, $id_pegawai, $tanggal);
                }


                redirect('cuti/edit_cuti/' . $id_cuti);
            }
        } else {
            //jenis cuti yang lain, cuti bersalin, cuti alasan penting tidak perlu cek sisa cuti



            $hariCuti =  datediff('d', $start_date, $end_date);
            $pesan =  createMessageInfo('Cuti berhasil diupdate', 'success');
            $this->session->set_flashdata('message', $pesan);

            $this->Cuti_model->updateDataCuti($id_cuti, $jns_cuti, $jns_hak_cuti, $start_date, $end_date, $hariCuti);
            redirect('cuti/edit_cuti/' . $id_cuti);
        }
    }





    function approve_pengganti_cuti($status, $id_cuti)
    {

        $data = array(
            'cek_pengganti' => 1,
            'tgl_cek' => date('Y-m-d'),
            'status' => $status
        );


        $this->db->where('id', $id_cuti);
        $this->db->update('ts_cuti', $data);
        $this->session->set_flashdata('message', 'Anda telah menyetujui sebagai pengganti cuti');

        redirect('cuti/detail_cuti/' . $id_cuti);
    }

    function approve_cuti_kapus($status, $id_cuti)
    {

        $data = array(
            'check_kapuskel' => 1,
            'tgl_check' => date('Y-m-d'),
            'status' => $status
        );


        $this->db->where('id', $id_cuti);
        $this->db->update('ts_cuti', $data);
        $this->session->set_flashdata('message', 'Pengajuan cuti telah disetuju');

        redirect('cuti/detail_cuti/' . $id_cuti);
    }

    function approve_cuti_kasubbag_tu($status, $id_cuti)
    {

        $data = array(
            'check_ktu' => 1,
            'tgl_check_ktu' => date('Y-m-d'),
            'status' => $status
        );

        $this->db->where('id', $id_cuti);
        $this->db->update('ts_cuti', $data);
        $this->session->set_flashdata('message', 'Pengajuan cuti telah disetuju');

        redirect('cuti/detail_cuti/' . $id_cuti);
    }


    function approve_cuti_kapuskec($status, $id_cuti)
    {
        $detail_cuti  = $this->Cuti_model->getDetailCuti($id_cuti);
        $id_pegawai   = $detail_cuti[0]->id_pegawai;
        $jns_cuti     = $detail_cuti[0]->jns_cuti;
        $tgl_dari     = $detail_cuti[0]->tgl_dari;
        $jns_hak_cuti = $detail_cuti[0]->jns_hak_cuti;
        $hari_cuti    = $detail_cuti[0]->hari_cuti;
        $alasan_cuti     = $detail_cuti[0]->alasan_cuti;
        $nip          = $this->Pegawai_model->getNipPegawaiByID($id_pegawai);
        $pin          = substr($nip, -4);

        if ($jns_cuti == 1) {
            //cuti tahunan
            $sisa_cuti  = $this->Cuti_model->getSisaCuti($id_pegawai, $jns_hak_cuti);
            $sisa_akhir = $sisa_cuti - $hari_cuti;
            $ket = 'Penggunaan cuti';
            $this->Cuti_model->insertLogCuti($id_pegawai, $jns_hak_cuti, $jns_cuti, $id_cuti, $hari_cuti, $sisa_akhir, $ket);

            if ($hari_cuti == 1) {
                $this->Presensi_model->insertAbsensiCuti($tgl_dari, $pin);
            } else {
                $list_hari = $this->Cuti_model->getListHariCuti($id_cuti);
                for ($c = 0; $c < count($list_hari); $c++) {
                    $tgl_cuti = $list_hari[$c]->tanggal;
                    $this->Presensi_model->insertAbsensiCuti($tgl_cuti, $pin, $alasan_cuti);
                }
            }
            // kondisi sudah divalidasi oleh kasubbag TU
            $data = array(
                'check_kapuskec' => 1,
                'tgl_check2' => date('Y-m-d'),
                'status' => 'APPROVE'
            );
        } else {
            $detail_cuti  = $this->Cuti_model->getDetailCuti($id_cuti);
            $id_pegawai   = $detail_cuti[0]->id_pegawai;
            $jns_cuti     = $detail_cuti[0]->jns_cuti;
            $tgl_dari     = $detail_cuti[0]->tgl_dari;
            $end_date     = $detail_cuti[0]->tgl_sampai;
            $alasan_cuti  = $detail_cuti[0]->alasan_cuti;

            $selisihhari =  datediff('d', $tgl_dari, $end_date);
            $hari_cuti   = $selisihhari + 1;
            $tgl_cuti    = $tgl_dari;

            for ($c = 0; $c < $hari_cuti; $c++) {

                $this->Presensi_model->insertAbsensiCuti($tgl_cuti, $pin, $alasan_cuti);
                $tgl_cuti = add_date($tgl_cuti, 1);
            }



            $data = array(
                'check_kapuskec' => 1,
                'tgl_check2' => date('Y-m-d'),
                'status' => 'APPROVE'
            );
        }




        $this->db->where('id', $id_cuti);
        $this->db->update('ts_cuti', $data);
        $this->session->set_flashdata('message', 'Pengajuan cuti telah disetuju');

        redirect('cuti/detail_cuti/' . $id_cuti);
    }

    function cancel_cuti($newStatus, $id_cuti)
    {

        $detail_cuti   = $this->Cuti_model->getDetailCuti($id_cuti);
        $id_pegawai    = $detail_cuti[0]->id_pegawai;
        $jns_hak_cuti  = $detail_cuti[0]->jns_hak_cuti;
        $hari_cuti     = $detail_cuti[0]->hari_cuti;
        $status        = $detail_cuti[0]->status;
        $jns_cuti      = $detail_cuti[0]->jns_cuti;

        if ($status == 'APPROVE') {
            //klo sudah di acc sama kapus kecamatan, harus kembalikan cutinya
            $sisa_cuti  = $this->Cuti_model->getSisaCuti($id_pegawai, $jns_hak_cuti);
            $sisa_akhir = $sisa_cuti + $hari_cuti;
            $ket = 'Sisa  cuti dikembalikan, pembatalan cuti';
            $this->Cuti_model->insertLogCuti($id_pegawai, $jns_hak_cuti, $jns_cuti, $id_cuti, $hari_cuti, $sisa_akhir, $ket);

            $this->Presensi_model->updateAbsensiCancelCuti($id_cuti, $pin);
        }

        $this->db->where('id', $id_cuti);
        $this->db->set('status', 'CANCEL');
        $this->db->update('ts_cuti', $data);

        $this->session->set_flashdata('message', 'Cuti telah dibatalkan');
        redirect('cuti/detail_cuti/' . $id_cuti);
    }



    //setujui cuti diakses oleh pengganti cuti
    public function ajax_setujui()
    {

        $input = json_decode(file_get_contents("php://input"), true);

        $id_pengajuan = $input['id_pengajuan'] ?: null;
        $role_approval = $input['role_approval'] ?: 'pengganti';
        $id_pegawai = $this->session->userdata("id_pegawai");

        if (!$id_pengajuan) {
            echo json_encode([
                'status' => false,
                'message' => 'ID pengajuan tidak valid'
            ]);
            return;
        }

        // Ambil row approval pengganti
        $approval = $this->db
            ->where('id_pengajuan_cuti', $id_pengajuan)
            ->where('role_approval', 'pengganti')
            ->where('id_pegawai_approval', $id_pegawai)
            ->where('status', 'pending')
            ->get('ts_pengajuan_cuti_approval')
            ->row();

        if (!$approval) {
            show_error("Anda tidak berhak atau approval sudah diproses");
        }

        $this->db->trans_start();

        // 1. Approve pengganti
        $this->db->where('id', $approval->id)
            ->update('ts_pengajuan_cuti_approval', [
                'status' => 'approved',
                'approved_at' => date('Y-m-d H:i:s')
            ]);

        // 2. Aktifkan Kapustu
        $this->db->where('id_pengajuan_cuti', $id_pengajuan)
            ->where('role_approval', 'kapustu')
            ->update('ts_pengajuan_cuti_approval', [
                'status' => 'pending'
            ]);

        // 3. Update status di pengajuan
        $this->db->where('id', $id_pengajuan)
            ->update('ts_pengajuan_cuti', [
                'status_akhir' => 'proses'
            ]);

        $this->db->trans_complete();

        echo json_encode([
            'status' => true,
            'message' => 'Permohonan pengganti cuti berhasil disetujui'
        ]);
    }



    function update_detail_cuti($id_cuti)
    {


        $this->Cuti_model->updateDataDetailCuti($id_cuti);

        $pesan =  createMessageInfo('Cuti berhasil diupdate', 'success');
        $this->session->set_flashdata('message', $pesan);
        redirect('cuti/edit_cuti/' . $id_cuti);
    }


    function pengajuan_cuti_step2()
    {
        $this->load->view('pengajuan_cuti/form_pengajuan_cuti_step2');
    }

    // function save_pengajuan_cuti()  {
    //     $id_pegawai = $this->session->userdata('id_pegawai');




    //     $id_cuti          =  $this->Cuti_model->insertDataCuti();
    //     $jml_hari_cuti    =  $this->session->userdata('jml_hari_cuti');
    //     $date_from        =  $this->session->userdata('date_from');
    //     $list_hari_cuti   =  $this->session->userdata('list_hari_cuti');

    //     #print_array($list_hari_cuti);

    //     if($jml_hari_cuti==1){
    //         $tanggal = format_db($date_from);
    //         $this->Cuti_model->insertDataDetailCuti($id_cuti, $id_pegawai, $tanggal);
    //     }else{

    //         for ($i=0; $i < count($list_hari_cuti) ; $i++) {
    //                 $tanggal = $list_hari_cuti[$i];
    //                 $this->Cuti_model->insertDataDetailCuti($id_cuti, $id_pegawai, $tanggal);
    //         }
    //     }


    //     $pesan =  createMessageInfo('Pengajuan cuti berhasil dikirim', 'success');
    //     $this->session->set_flashdata('message', $pesan);

    //     redirect('cuti/index');

    // }


    function generateRandomNumber()
    {
        $min = pow(10, 9); // Minimum 10-digit number (1000000000)
        $max = pow(10, 10) - 1; // Maximum 10-digit number (9999999999)

        return strval(mt_rand($min, $max)); // Generate random number and convert to string
    }


    function insertPengajuanCuti()
    {
        $id_pegawai = $this->session->userdata('id_pegawai');
        $countFile =  count($_FILES['files']['name']);
        $data = array();
        $errorUploadType = $statusMsg = '';
        $fileNmDb = ''; //nama file yang akan disimpan didatabase
        // If file upload form submitted


        $nama_pegawai = $this->input->post('nama_pengganti');
        $row = $this->Pegawai_model->getPegawaiByNama($nama_pegawai);


        if (count($row) == 0) {
            $pesan =  createMessageInfo('Nama pengganti cuti tidak ditemukan di database, periksa kembali nama pengganti cuti', 'danger');
            $this->session->set_flashdata('message', $pesan);

            redirect('cuti/pengajuan_cuti_step2');
            exit;
        }

        $jns_cuti         =  $this->session->userdata('jns_cuti');
        $this->session->set_userdata($this->input->post());
        if ($jns_cuti  == 1) {
            $id_cuti          =  $this->Cuti_model->insertDataCuti($fileNmDb);
            $jml_hari_cuti    =  $this->session->userdata('jml_hari_cuti');
            $date_from        =  $this->session->userdata('date_from');
            $list_hari_cuti   =  $this->session->userdata('list_hari_cuti');

            #print_array($list_hari_cuti);

            if ($jml_hari_cuti == 1) {
                $tanggal = format_db($date_from);
                $this->Cuti_model->insertDataDetailCuti($id_cuti, $id_pegawai, $tanggal);
            } else {

                for ($i = 0; $i < count($list_hari_cuti); $i++) {
                    $tanggal = $list_hari_cuti[$i];
                    $this->Cuti_model->insertDataDetailCuti($id_cuti, $id_pegawai, $tanggal);
                }
            }


            $pesan =  createMessageInfo('Pengajuan cuti berhasil dikirim', 'success');
            $this->session->set_flashdata('message', $pesan);

            redirect('cuti/detail_cuti/' . $id_cuti);
        } else {

            //selain cuti tahunan
            $now = date('YmdHis');
            // If files are selected to upload
            if (!empty($_FILES['files']['name']) && count(array_filter($_FILES['files']['name'])) > 0) {
                $filesCount = count($_FILES['files']['name']);
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file']['name']     = $_FILES['files']['name'][$i];
                    $_FILES['file']['type']     = $_FILES['files']['type'][$i];

                    $name_upload_file =  $_FILES['files']['name'][$i];

                    $extFile = getFileType2($name_upload_file); //file extensi

                    $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                    $_FILES['file']['error']     = $_FILES['files']['error'][$i];
                    $_FILES['file']['size']     = $_FILES['files']['size'][$i];


                    $fileName =  'cuti_' . $now;
                    // File upload configuration
                    $uploadPath = 'uploads/cuti/';
                    $config['upload_path'] = $uploadPath;
                    $config['allowed_types'] = 'jpg|jpeg|png|gif';
                    $config['file_name'] = $fileName;
                    $config['max_size']    = '5000';
                    $config['max_width'] = '5000';
                    $config['max_height'] = '5000';

                    //Load and initialize upload library
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    // Upload file to server
                    if ($this->upload->do_upload('file')) {
                        // Uploaded file data
                        $fileData = $this->upload->data();
                        $uploadData[$i]['file_name'] = $fileData['file_name'];
                        $uploadData[$i]['uploaded_on'] = date("Y-m-d H:i:s");
                    } else {
                        $errorUploadType .= $_FILES['file']['name'] . ' | ';
                    }

                    $fileNmDb .= $fileName . '.' . $extFile . ',';
                }

                $fileNmDb = rtrim($fileNmDb, " ,");


                $errorUploadType = !empty($errorUploadType) ? '<br/>File Type Error: ' . trim($errorUploadType, ' | ') : '';

                if (!empty($uploadData)) {
                    // Insert files data into the database

                    $id_cuti          =  $this->Cuti_model->insertDataCuti($fileNmDb);
                    $jml_hari_cuti    =  $this->session->userdata('jml_hari_cuti');
                    $date_from        =  $this->session->userdata('date_from');
                    $list_hari_cuti   =  $this->session->userdata('list_hari_cuti');

                    #print_array($list_hari_cuti);

                    if ($jml_hari_cuti == 1) {
                        $tanggal = format_db($date_from);
                        $this->Cuti_model->insertDataDetailCuti($id_cuti, $id_pegawai, $tanggal);
                    } else {

                        for ($i = 0; $i < count($list_hari_cuti); $i++) {
                            $tanggal = $list_hari_cuti[$i];
                            $this->Cuti_model->insertDataDetailCuti($id_cuti, $id_pegawai, $tanggal);
                        }
                    }


                    $pesan =  createMessageInfo('Pengajuan cuti berhasil dikirim', 'success');
                    $this->session->set_flashdata('message', $pesan);

                    redirect('cuti/detail_cuti/' . $id_cuti);
                } else {
                    $statusMsg = "Sorry, there was an error uploading your file." . $errorUploadType;
                    $pesan =  createMessageInfo($statusMsg, 'danger');
                    $this->session->set_flashdata('message', $pesan);


                    redirect('cuti/pengajuan_cuti_step2');
                }
            } else {
                $statusMsg = 'Please select image files to upload.';
                $pesan =  createMessageInfo($statusMsg, 'danger');
                $this->session->set_flashdata('message', $pesan);


                redirect('cuti/pengajuan_cuti_step2');
            }
        }
    }



    // function detail_pengajuan_cuti()
    // {
    //     $this->load->view('pengajuan_cuti/detail_pengajuan_cuti');
    // }

    public function search_pegawai()
    {

        $id_pegawai = $this->session->userdata('id_pegawai');
        $pegawai = $this->Pegawai_model->getDataEditPegawai($id_pegawai);
        $id_jabatan = $pegawai[0]->id_jabatan;


        $keyword = $this->input->post('keyword');

        echo '<script>


                $(".choose_pegawai").click(function() {
                    var data = $(this).attr("id");
                    var pecah = data.split("/");
                    var id_pegawai = pecah[0];
                    var nama_pegawai = pecah[1];

                    $("#search_pegawai").val(nama_pegawai);
                    $("#id_pegawai_choose").val(id_pegawai);
                    $("#list_pegawai").hide();
                    $(".btn-success").removeClass("d-none");
                });
                </script>';


        $sql = "SELECT id_pegawai, nama FROM mst_pegawai
        WHERE nama like '%$keyword%'
        AND tahun_anggaran = '2024'
        AND status_kerja = 1 AND id_pegawai != $id_pegawai";
        $qry = $this->db->query($sql);
        $row = $qry->result();


        //	$row = $this->Pegawai_model->search_pegawai($keyword);

        for ($i = 0; $i < count($row); $i++) {
            $id_pegawai = $row[$i]->id_pegawai;
            $nama = $row[$i]->nama;

            echo '<div class="choose_pegawai" id="' . $id_pegawai . '/' . $nama . '">' . $nama . '</div>';
        }
    }


    function setujui_cuti()
    {
        $id_cuti = $this->input->post('id_cuti');
        if ($id_cuti == '') {
            echo '<div class="alert alert-danger">Gagal acc pengganti cuti</div>';
        } else {


            $data = array(
                'cek_pengganti' => 1,
                'tgl_cek' => date('Y-m-d'),
                'status' => 'PEND1'
            );

            $this->db->where('id', $id_cuti);
            $this->db->update('ts_cuti', $data);

            echo '<div class="alert alert-success">Cuti berhasil disetujui</div> <br>refresh halaman untuk melihat perubahan';
        }




        // $pesan =  createMessageInfo('Anda telah menyetujui sebagai pengganti cuti', 'success');
        // $this->session->set_flashdata('message', $pesan);

        // redirect('dashboard/index');

    }


    function setujui_cuti_kapuskel()
    {
        $id_cuti = $this->input->post('id_cuti');

        $data = array(
            'check_kapuskel' => 1,
            'tgl_check' => date('Y-m-d'),
            'status' => 'PEND2'
        );

        $this->db->where('id', $id_cuti);
        $this->db->update('ts_cuti', $data);


        $pesan =  createMessageInfo('Pengajuan cuti telah disetujui', 'success');
        $this->session->set_flashdata('message', $pesan);

        redirect('admin/pengajuan_cuti/detail/' . $id_cuti);
    }




    // function cancel_cuti(){
    //     $id_cuti = $this->input->post('id_cuti');

    //     $data = array(
    //         'status' => 'CANCEL'
    //     );

    //     $this->db->where('id', $id_cuti);
    //     $this->db->update('ts_cuti', $data);


    //     $pesan =  createMessageInfo('Cuti telah dibatalkan', 'success');
    //     $this->session->set_flashdata('message', $pesan);

    //     redirect('cuti/index');

    // }






}
