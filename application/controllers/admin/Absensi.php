<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Absensi  extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('text');
        $this->Auth_model->cekAuthLogin();
        $this->load->model('Admin_cuti_model', 'acm');
        $this->load->model('Shift_model');
        $this->load->model('Template_shift_model');
    }

    function pengajuan_izin_sakit_pegawai()
    {
        $this->db->select('pengajuan_izin_sakit.*, mst_pegawai.nama'); // Sesuaikan 'nama' dengan nama kolom di tabel mst_pegawai
        $this->db->from('pengajuan_izin_sakit');
        $this->db->join('mst_pegawai', 'mst_pegawai.id_pegawai = pengajuan_izin_sakit.id_pegawai');
        $this->db->where('pengajuan_izin_sakit.status >', 0);
        $this->db->order_by('pengajuan_izin_sakit.tanggal', 'DESC');
        $this->db->limit(20);

        $qry = $this->db->get();
        $row = $qry->result();

        print_array($row);
    }

    function rekap_absensi()
    {


        $periode_bulan = $this->session->userdata('periode_bulan');
        $periode_tahun = $this->session->userdata('periode_tahun');
        $jns_pegawai = $this->session->userdata('status_pegawai');

        $id_pj = $this->session->userdata('id_pj');
        if ($id_pj == '') {
            $this->session->set_userdata('id_pj', $this->session->userdata('id_pegawai'));
        }


        $periode       = $periode_tahun . '-' . $periode_bulan;
        $periode       = date('Y-m', strtotime($periode));

        $qry = $this->db->get_where('mst_pegawai', ['id_pegawai' => $id_pj]);
        $detValidator =  $qry->row();
        $id_puskesmas = $detValidator->id_puskesmas;
        $id_klaster = $detValidator->klaster;


        $data['bulan'] = $periode_bulan;
        $data['tahun'] = $periode_tahun;
        $data['validator'] = $this->Pegawai_model->getValidator();



        $data['data_rekap']     = $this->Presensi_model->getDataRekapAbsensi($periode, 'mst_pegawai.nama', $jns_pegawai, $id_puskesmas, $id_klaster);
        $this->load->view('admin/absensi/rekap_absensi', $data);
    }

    function view_absensi_pegawai($pin, $bulan, $tahun)
    {

        $jns_pegawai = $this->session->userdata('status_pegawai');
        if ($jns_pegawai = '') {
            $jns_pegawai = 'non_pns';
        }

        $pegawai = $this->Presensi_model->getDetailPegawaiByPin($pin, $jns_pegawai);
        $id_pegawai = $pegawai->id_pegawai;


        $periode = $tahun . '-' . $bulan;
        $periode = date('Y-m', strtotime($periode));

        $data['cuti_pegawai'] = $this->acm->get_cuti_bulanan_absensi($id_pegawai, $bulan, $tahun);

        $data['absensi']      = $this->Presensi_model->get_absensi_pegawai($pin, $bulan, $tahun);
        $data['dataRekap']    = $this->Presensi_model->getRekapAbsensiPegawai($id_pegawai, $periode);
        $data['DinasLuar']    =  $this->Presensi_model->getDataPengajuanDLPerbulan($id_pegawai, $periode);

        $data['IzinSakit']    = $this->Presensi_model->getDataIzinSakit($id_pegawai, 'ALL', $periode);
        $data['template']     = $this->Template_shift_model->get_all();

        $data['detailPegawai'] =  $pegawai;
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $this->load->view('admin/absensi/view_absensi_pegawai', $data);
    }

    function update_absensi_cuti($pin, $id_cuti, $bulan, $tahun)
    {
        $list_hari = $this->acm->getlistHariCuti($id_cuti);

        //print_array($list_hari);

        $qry = $this->db->get_where('ts_pengajuan_cuti', ['id' => $id_cuti]);
        $cuti =  $qry->row();

        $jenis_cuti = $cuti->jenis_cuti;

        if ($jenis_cuti == 2) {
            //cuti bersalin

            $tgl_mulai   = new DateTime($cuti->tgl_mulai);
            $tgl_selesai = new DateTime($cuti->tgl_selesai);

            // Supaya tanggal akhir ikut terproses
            $tgl_selesai->modify('+1 day');

            $interval = new DateInterval('P1D');
            $periode  = new DatePeriod($tgl_mulai, $interval, $tgl_selesai);

            foreach ($periode as $tgl) {

                $hari = $tgl->format('N');
                // 6 = Sabtu, 7 = Minggu

                if ($hari != 6 && $hari != 7) {

                    $tanggal_loop = $tgl->format('Y-m-d');

                    $this->Presensi_model->update_absensi_cuti(
                        $pin,
                        $tanggal_loop,
                        $cuti->alasan_cuti
                    );
                }
            }
        } else {
            //cuti tahunan, sakit, alasan penting
            foreach ($list_hari as $ls) {
                $this->Presensi_model->update_absensi_cuti($pin, $ls->tgl_cuti, $cuti->alasan_cuti);
            }
        }


        // print_array($cuti);
        // exit;


        redirect('admin/absensi/view_absensi_pegawai/' . $pin . '/' . $bulan . '/' . $tahun);
    }

    function create_session_periode()
    {
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');

        $id_validator = $this->input->post('id_validator');
        $status_pegawai = $this->input->post('status_pegawai');

        //$tahun = 2025;
        $this->session->set_userdata('periode_tahun', $tahun);
        $this->session->set_userdata('periode_bulan', $bulan);

        $this->session->set_userdata('id_pj', $id_validator);
        $this->session->set_userdata('status_pegawai', $status_pegawai);


        redirect('admin/absensi/rekap_absensi');
    }

    function view_raw_absensi($pin, $ip_address, $bulan, $tahun, $jns_pegawai)
    {
        $data['absensi_raw']    = $this->Sinkron_model->getDataAbsenMesin($ip_address, $pin);
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['detailPegawai'] = $this->Presensi_model->getDetailPegawaiByPin($pin, $jns_pegawai);
        $this->load->view('admin/absensi/view_raw_absensi', $data);
    }

    function insertAbsenPengajuanDL($id, $pin, $bulan, $tahun)
    {
        $qry = $this->db->get_where('pengajuan_dinas_luar', array('id' => $id));
        $dinasLuar = $qry->result();

        $jns_dl = $dinasLuar[0]->jns_dl;
        $keterangan = $dinasLuar[0]->keterangan;
        $tanggal = $dinasLuar[0]->tanggal;


        $this->Presensi_model->saveAbsensiDL($pin, $tanggal, $jns_dl, $keterangan);

        $this->db->where('id', $id);
        $this->db->set('status', 1);

        $this->db->update('pengajuan_dinas_luar');

        $this->session->set_flashdata('message', ' Data shift berhasil disimpan');
        redirect('admin/absensi/view_absensi_pegawai/' . $pin . '/' . $bulan . '/' . $tahun);
    }
    function insertAbsenPengajuanIzinSakit($id, $pin, $bulan, $tahun)
    {
        $qry = $this->db->get_where('pengajuan_izin_sakit', array('id' => $id));
        $is = $qry->row();

        $tanggal = $is->tanggal;
        $jenis_absen = $is->jenis_absen;
        $jns_izin = $is->jns_izin;
        $jns_sakit = $is->jns_sakit;
        $ket  = $is->keterangan;

        if ($jenis_absen == 'IZIN') {
            if ($jns_izin == 1) {
                $status_detail = 'IZIN PENUH';
            } else if ($jns_izin == 2) {
                $status_detail = 'IZIN AWAL';
            } else {
                $status_detail = 'IZIN AKHIR';
            }
        } else {

            if ($jns_sakit == 1) {
                $status_detail = 'SAKIT TANPA SK';
            } else {
                $status_detail = 'SAKIT DGN SK';
            }
        }

        $this->Presensi_model->saveAbsensiIzinSakit($pin, $tanggal, $jenis_absen, $status_detail, $ket);

        $this->db->where('id', $id);
        $this->db->set('status', 1);

        $this->db->update('pengajuan_izin_sakit');

        $this->session->set_flashdata('message', ' Data  berhasil disimpan');
        redirect('admin/absensi/view_absensi_pegawai/' . $pin . '/' . $bulan . '/' . $tahun);
    }



    function updateHariLibur()
    {
        $this->Presensi_model->update_absensi_khusus('ts_hari_libur');
    }

    public function update_shift_pegawai($pin, $bulan, $tahun)
    {
        $this->db->where('pin', $pin);
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $data = $this->db->get('tbl_kehadiran_harian')->result();

        foreach ($data as $row) {

            $tanggal = $row->tanggal;
            $hari = date('N', strtotime($tanggal));
            // 6 = Sabtu, 7 = Minggu

            $shift_baru = $row->shift;

            // =========================
            // 1. Jika Libur Nasional
            // =========================
            if ($row->status_detail == 'LIBUR NASIONAL') {
                $shift_baru = 'OFF';
            }

            // =========================
            // 2. Jika Sabtu/Minggu
            // =========================
            elseif ($hari == 6 || $hari == 7) {
                $shift_baru = 'OFF';
            }

            $this->db->where('id', $row->id);
            $this->db->update('tbl_kehadiran_harian', [
                'shift' => $shift_baru
            ]);
        }

        return true;
    }




    function sinkron_absensi($id_pegawai, $pin, $bulan, $tahun, $ip_address)
    {

        $absensi_raw   = $this->Sinkron_model->getDataAbsenMesin($ip_address, $pin);

        //print_array($absensi_raw);

        $now = '2026-02-01 00:01:00';
        $dateNow = strtotime($now);

        foreach ($absensi_raw as $raw) {
            $DateTime = $raw['DateTime'];
            $Status = $raw['Status'];

            $dateAbsen = strtotime($DateTime);

            //echo 'DateNow = '.$dateNow.' data absen :'.$dateAbsen.'<br>';

            if ($dateAbsen > $dateNow) {

                $tanggal = format_db($DateTime);
                $jam     = date('H:i:s', strtotime($DateTime));


                $this->db->where('pin', $pin);
                $this->db->where('tanggal', $tanggal);
                if ($Status == 1) {
                    //absen pulang
                    $this->db->set('jam_pulang', $jam);
                } else {
                    //absen masuk
                    $this->db->set('jam_masuk', $jam);
                }

                $this->db->update('tbl_kehadiran_harian');
            }
        }
        redirect('admin/absensi/view_absensi_pegawai/' . $pin . '/' . $bulan . '/' . $tahun);
    }

    public function update_rekap_absensi($id_pegawai, $pin, $bulan, $tahun)
    {


        $this->db->where('pin', $pin);
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $data = $this->db->get('tbl_kehadiran_harian')->result();


        foreach ($data as $row) {

            $status         = $row->status;
            $jam_masuk      = $row->jam_masuk;
            $jam_pulang     = $row->jam_pulang;
            $telat_menit    = $row->telat_menit;
            $p_awal_menit   = $row->p_awal_menit;
            $shift          = $row->shift;

            $detailShift = $this->Presensi_model->detailShiftByKode($shift);
            $jam_masuk_shift = $detailShift->jam_masuk;
            $jam_pulang_shift = $detailShift->jam_pulang;

            if ($status == 'ALPHA' || $status == 'OFF') {
                $telat_menit = 0;
                $p_awal_menit = 0;

                if ($status != 'OFF' && ($jam_masuk != null && $jam_masuk_shift != null)) {
                    $status = 'HADIR';
                }
            } else {
                //hitung telat & p_awal
                if ($jam_masuk && $jam_masuk_shift) {
                    $telat_menit = max(0, (strtotime($jam_masuk) - strtotime($jam_masuk_shift)) / 60);
                }

                if ($jam_pulang && $jam_pulang_shift) {
                    $p_awal_menit = max(0, (strtotime($jam_pulang_shift) - strtotime($jam_pulang)) / 60);
                }
            }

            //update kehadiran harian
            $this->db->where('id', $row->id);
            $this->db->update('tbl_kehadiran_harian', [
                'telat_menit' => $telat_menit,
                'p_awal_menit' => $p_awal_menit,
                'status' => $status
            ]);
        }



        // print_array($data);
        // exit;


        $this->Presensi_model->generate_rekap_bulanan($pin, $id_pegawai, $bulan, $tahun);

        //print_array($absensi_raw);
        //exit;
        redirect('admin/absensi/view_absensi_pegawai/' . $pin . '/' . $bulan . '/' . $tahun);
    }


    public function update_absensi_pegawai($id_pegawai, $pin, $bulan, $tahun)
    {

        $this->Presensi_model->generate_rekap_bulanan($pin, $id_pegawai, $bulan, $tahun);

        //print_array($absensi_raw);
        //exit;
        redirect('admin/absensi/view_absensi_pegawai/' . $pin . '/' . $bulan . '/' . $tahun);
    }


    function refresh_data()
    {



        $bulan = $this->session->userdata('periode_bulan');
        $tahun = $this->session->userdata('periode_tahun');
        $periode = date('Y-m', strtotime("$tahun-$bulan"));
        $id_pj = $this->session->userdata('id_pj');

        if ($id_pj == '') {
            $id_pj = $this->session->userdata('id_pegawai');
            $this->session->set_userdata('id_pj', $id_pj);
        }




        $qry = $this->db->get_where('mst_pegawai', ['id_pegawai' => $id_pj]);
        $detValidator =  $qry->row();
        $id_puskesmas = $detValidator->id_puskesmas;
        $id_klaster = $detValidator->klaster;

        $jns_pegawai = $this->session->userdata('status_pegawai');

        $select = 'id_pegawai,pin, nama';
        if ($id_puskesmas != 1) {
            //selaian puskesmas induk
            $pegawai = $this->Pegawai_model->getPegawaiByIDPuskesmas($id_puskesmas, $jns_pegawai, $select);
        } else {

            $pegawai = $this->Pegawai_model->getPegawaiByKlaster($id_puskesmas, $id_klaster, $jns_pegawai, $select);
        }

        //print_array($pegawai);exit;

        foreach ($pegawai as $peg) {
            $id_pegawai = $peg->id_pegawai;
            $pin = $peg->pin;
            $this->Presensi_model->generate_rekap_bulanan($pin, $id_pegawai, $bulan, $tahun);
        }

        redirect('admin/absensi/rekap_absensi');

        //print_array($pegawai);
    }


    function deleteAbsenPengajuanDL($id_dl, $pin, $bulan, $tahun)
    {

        $this->db->where('id', $id_dl);
        $this->db->delete('pengajuan_dinas_luar');

        redirect('admin/absensi/view_absensi_pegawai/' . $pin . '/' . $bulan . '/' . $tahun);
    }

    public function update_jam_manual()
    {
        $id    = $this->input->post('id');
        $field = $this->input->post('field');
        $value = $this->input->post('value');

        // validasi field
        if (!in_array($field, ['jam_masuk', 'jam_pulang'])) {
            echo json_encode(['status' => false]);
            return;
        }

        $this->db->where('id', $id);
        $this->db->update('tbl_kehadiran_harian', [
            $field => $value
        ]);

        echo json_encode(['status' => true]);
    }


    function update_shift($id_template, $pin, $bulan, $tahun, $jns_shift = 'non_shift')
    {

        $periode = $tahun . '-' . $bulan;
        $periode = date('Y-m', strtotime($periode));


        if ($jns_shift == 'non_shift') {
            $detail   = $this->Template_shift_model->get_detail($id_template);

            $this->updateShiftReguler($pin, $detail);
        } else {
            //jam kerja khusus pegawai yg  shift2an

            //jika jam kerja shift, maka id_template adalah id_pegawai untuk mengambil data shift perbulan dari tabel shift_kerja
            $id_pegawai = $id_template;
            $dataShift = $this->Shift_model->getShiftPerbulanById($id_pegawai, $periode);

            //print_array($dataShift);

            foreach ($dataShift as $shift_kerja) {
                $shift   = $shift_kerja->shift;
                $tanggal = $shift_kerja->tanggal;

                $cekAbsen = $this->Presensi_model->cekAbsenExist($tanggal, $pin, 'id');

                if ($cekAbsen == 0) {
                    //insert shift
                    $this->db->insert('tbl_kehadiran_harian', [
                        'pin' => $pin,
                        'tanggal' => $tanggal,
                        'shift' => $shift,
                        'status' => ($shift == 'OFF') ? 'OFF' : 'HADIR',
                        'status_detail' => null,
                        'keterangan' => null,
                        'jam_masuk' => null,
                        'jam_pulang' => null,
                        'telat_menit' => 0,
                        'p_awal_menit' => 0
                    ]);
                } else {
                    //update shift
                    $this->db->where('id', $cekAbsen->id);
                    $this->db->set('shift', $shift);
                    $this->db->update('tbl_kehadiran_harian');
                }
            }
        }


        // exit;

        redirect('admin/absensi/view_absensi_pegawai/' . $pin . '/' . $bulan . '/' . $tahun);
    }



    function insert_absen_ketidakhadiran()
    {
        $pin   = $this->input->post('pin');

        $tanggal    = $this->input->post('tanggal'); // YYYY-MM-DD
        $jamMasuk   = $this->input->post('jam_masuk');
        $jamPulang  = $this->input->post('jam_pulang');
        $status     = $this->input->post('status');
        $keterangan = $this->input->post('keterangan');


        // print_array($this->input->post());
        //  exit;
        // Ambil data awal (optional, kalau ingin log/cek dulu)
        $absen = $this->db->get_where('tbl_kehadiran_harian', [
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
                $dataUpdate['jam_masuk'] = $jamMasuk . ':00';
            }

            if (!empty($jamPulang)) {
                $dataUpdate['jam_pulang'] = $jamPulang . ':00';
            }

            // Optional: bisa set telat / p_awal kalau mau
        }
        /* ==============================
			PRIORITAS 2 : STATUS / TIDAK HADIR
			============================== */ elseif (!empty($status)) {

            switch ($status) {

                case 'DL-AWAL': // Dinas Luar Awal
                    $dataUpdate['status'] = 'DINAS';
                    $dataUpdate['status_detail'] = 'DLA';
                    // optional: update telat = 0
                    break;

                case 'DL-AKHIR': // Dinas Luar Akhir
                    $dataUpdate['status'] = 'DINAS';
                    $dataUpdate['status_detail'] = 'DLAK';
                    // optional: update p_awal = 0
                    break;

                case 'DL-PENUH': // Dinas Luar Penuh
                    $dataUpdate['status'] = 'DINAS';
                    $dataUpdate['status_detail']  = 'DLP';

                    // optional: telat = 0, p_awal = 0
                    break;

                default: // Izin / Sakit / Alpha
                    $dataUpdate['status'] = $status;
                    $dataUpdate['status_detail']  = $status;

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
            $this->db->update('tbl_kehadiran_harian', $dataUpdate);
        }

        // Redirect kembali ke halaman sebelumnya
        redirect($_SERVER['HTTP_REFERER']);
    }


    function updateShiftReguler($pin, $data_shift)
    {


        //print_array($data_shift);
        for ($i = 0; $i < count($data_shift); $i++) {

            $tanggal = $data_shift[$i]->tanggal;

            //echo $tanggal;

            $libur = $this->db
                ->where('tgl', $tanggal)
                ->get('ts_hari_libur')
                ->row();

            $status_detail = null;
            $keterangan = null;


            //print_array($libur);
            if ($libur) {
                $shift = 'OFF';
                $status_detail = 'LIBUR NASIONAL';
                $keterangan = $libur->keterangan;
            } else {


                $shiftDetail = $this->db->where('id', $data_shift[$i]->shift_id)->get('mst_shift_kerja')->row();
                //print_array($shiftDetail);
                $shift = $shiftDetail->kode_shift;
            }

            // ============================
            // Cek apakah data sudah ada
            // ============================
            $cek = $this->db
                ->where('pin', $pin)
                ->where('tanggal', $tanggal)
                ->get('tbl_kehadiran_harian')
                ->row();

            if (!$cek) {

                // INSERT jika belum ada
                $this->db->insert('tbl_kehadiran_harian', [
                    'pin' => $pin,
                    'tanggal' => $tanggal,
                    'shift' => $shift,
                    'status' => ($shift == 'OFF') ? 'OFF' : 'ALPHA',
                    'status_detail' => $status_detail,
                    'keterangan' => $keterangan,
                    'jam_masuk' => null,
                    'jam_pulang' => null,
                    'telat_menit' => 0,
                    'p_awal_menit' => 0
                ]);
            } else {

                // UPDATE shift & detail saja
                $this->db->where('id', $cek->id);
                $this->db->update('tbl_kehadiran_harian', [
                    'shift' => $shift,
                    'status_detail' => $status_detail,
                    'keterangan' => $keterangan
                ]);
            }
        }


        return true;
    }

    public function repair_periode_reguler($pin, $bulan, $tahun)
    {
        $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        for ($i = 1; $i <= $jumlah_hari; $i++) {

            $tanggal = date('Y-m-d', strtotime("$tahun-$bulan-$i"));
            $hari_ke = date('N', strtotime($tanggal)); // 1=Senin ... 7=Minggu

            // ============================
            // Cek Hari Libur Nasional
            // ============================
            $libur = $this->db
                ->where('tgl', $tanggal)
                ->get('ts_hari_libur')
                ->row();

            $status_detail = null;
            $keterangan = null;

            if ($libur) {
                $shift = 'OFF';
                $status_detail = 'LIBUR NASIONAL';
                $keterangan = $libur->keterangan;
            } else {

                // ============================
                // Tentukan Shift Reguler
                // ============================
                if ($hari_ke == 6 || $hari_ke == 7) {
                    $shift = 'OFF';
                } elseif ($hari_ke == 5) {
                    $shift = 'REG-JUM';
                } else {
                    $shift = 'REG';
                }
            }

            // ============================
            // Cek apakah data sudah ada
            // ============================
            $cek = $this->db
                ->where('pin', $pin)
                ->where('tanggal', $tanggal)
                ->get('tbl_kehadiran_harian')
                ->row();

            if (!$cek) {

                // INSERT jika belum ada
                $this->db->insert('tbl_kehadiran_harian', [
                    'pin' => $pin,
                    'tanggal' => $tanggal,
                    'shift' => $shift,
                    'status' => ($shift == 'OFF') ? 'OFF' : 'ALPHA',
                    'status_detail' => $status_detail,
                    'keterangan' => $keterangan,
                    'jam_masuk' => null,
                    'jam_pulang' => null,
                    'telat_menit' => 0,
                    'p_awal_menit' => 0
                ]);
            } else {

                // UPDATE shift & detail saja
                $this->db->where('id', $cek->id);
                $this->db->update('tbl_kehadiran_harian', [
                    'shift' => $shift,
                    'status_detail' => $status_detail,
                    'keterangan' => $keterangan
                ]);
            }
        }

        redirect('admin/absensi/view_absensi_pegawai/' . $pin . '/' . $bulan . '/' . $tahun);
    }
}
