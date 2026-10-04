<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Absensi_pjlp extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->load->model('Old_model');
        $this->Auth_model->cekAuthLogin();
    }

    function index($id_pjlp = 0)
    {


        // $data['data_pjlp'] = $this->Pegawai_model->detailPegawaiPJLP($id_pjlp);
        //$data['data_pjlp'] = $this->Pegawai_model->getDataDetailPegawai($id_pjlp);
        $data['data_pjlp'] = $this->Pegawai_model->getDataEditPegawaiPJLP($id_pjlp);

        $this->load->view('admin/absensi_pjlp/view_absensi', $data);
    }


    function view_absensi($id_pjlp)
    {
        $data['data_pjlp'] = $this->Pegawai_model->getDataEditPegawaiPJLP($id_pjlp);

        $this->load->view('admin/absensi_pjlp/view_absensi', $data);
    }

    function cetak_absensi($id_pjlp)
    {
        $data['data_pjlp'] = $this->Pegawai_model->getDataEditPegawaiPJLP($id_pjlp);

        $this->load->view('admin/absensi_pjlp/print_absensi', $data);
    }

    function main()
    {


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



        $periode = $tahun . '-' . $bulan;
        $periode = date('Y-m', strtotime($periode));
        // echo $periode;

        $data_rekap = $this->Presensi_model->getDataRekapAbsensi($periode, 'id', 'ts_rekap_absensi_pjlp');
        if (empty($data_rekap)) {
            $pegawai_pjlp = $this->Pegawai_model->getPegawaiPJLP($filters = []);

            foreach ($pegawai_pjlp as $peg) {
                $id_pjlp = $peg->id_pjlp;
                $this->Presensi_model->insertRekapAbsensiPJLP($id_pjlp, $periode);
            }

            //  print_array($pegawai_pjlp);
        }
        $data['datalist'] = $this->Presensi_model->getDataRekapAbsensi($periode, 'id', 'ts_rekap_absensi_pjlp');

        //print_array($data['datalist']);
        $this->load->view('admin/absensi_pjlp/main', $data);
    }




    function insert_absen_tidakhadir()
    {
        $arrayAbsens = [
            0 => 'IZIN SEHARI',
            1 => 'IZIN SETENGAH HARI AWAL',
            2 => 'IZIN SETENGAH HARI AKHIR',
            3 => 'SAKIT TNP SURAT KETERANGAN',
            4 => 'SAKIT DGN SURAT KETERANGAN',
            5 => 'CUTI',
            6 => 'ALPHA'
        ];

        $dataPjlp      = $this->input->post('id_pjlp');
        $jenis_absensi = (int) $this->input->post('jenis_absensi'); // Cast ke integer
        $tanggal       = $this->input->post('tanggal');
        $keterangan    = $this->input->post('keterangan');

        $explod  = explode("-", $dataPjlp);
        $id_pjlp = trim($explod[0]);

        $periode    = date('Y-m', strtotime($tanggal));
        $tanggal_db = format_db($tanggal);

        // Dapatkan label teks absensi (default ke string kosong jika index tidak ditemukan)
        $label_absensi = isset($arrayAbsens[$jenis_absensi]) ? $arrayAbsens[$jenis_absensi] : '';

        // Cek apakah data absensi hari ini sudah ada (mengembalikan ID atau 0)
        $cekID = $this->Presensi_model->cekAbsenExist($tanggal_db, $id_pjlp, 'tbl_absensi_pjlp');

        if ($cekID == 0) {
            // --- JIKA BELUM ADA DATA (INSERT) ---
            $dataInsert = array(
                'tanggal'    => $tanggal_db,
                'pin'        => $id_pjlp,
                'shift'      => 'OFF2',
                'jam_masuk'  => '00:00:00',
                'jam_pulang' => '00:00:00',
                'masuk'      => ($jenis_absensi == 2) ? '' : $label_absensi,
                'pulang'     => ($jenis_absensi == 1) ? '' : $label_absensi,
                'telat'      => 0,
                'p_awal'     => 0,
                'keterangan' => $keterangan
            );
            $this->db->insert('tbl_absensi_pjlp', $dataInsert);
        } else {
            // --- JIKA SUDAH ADA DATA (UPDATE) ---
            if ($jenis_absensi == 1) {
                $dataUpdate = array(
                    'masuk'      => $label_absensi,
                    'telat'      => 0,
                    'keterangan' => $keterangan
                );
            } elseif ($jenis_absensi == 2) {
                $dataUpdate = array(
                    'pulang'     => $label_absensi,
                    'p_awal'     => 0,
                    'keterangan' => $keterangan
                );
            } else {
                $dataUpdate = array(
                    'masuk'      => $label_absensi,
                    'pulang'     => $label_absensi,
                    'telat'      => 0,
                    'p_awal'     => 0,
                    'keterangan' => $keterangan
                );
            }

            $this->db->where('id', $cekID);
            $this->db->update('tbl_absensi_pjlp', $dataUpdate);
        }


        // --- REKAP ABSENSI PJLP ---
        $dataRekap = $this->Presensi_model->getDataRekapAbsensiPJLP($id_pjlp, $periode);

        if (!empty($dataRekap)) {
            $id_rekap = $dataRekap[0]->id;
        } else {
            $this->Presensi_model->insertRekapAbsensiPJLP($id_pjlp, $periode);
            $dataRekap = $this->Presensi_model->getDataRekapAbsensiPJLP($id_pjlp, $periode);
            $id_rekap = $dataRekap[0]->id;
        }

        // Tentukan kolom rekap berdasarkan jenis absensi
        $column = null;
        switch ($jenis_absensi) {
            case 0:
                $column = 'izin';
                break;
            case 1:
            case 2:
                $column = 'izin_half';
                break;
            case 3:
                $column = 'sakit';
                break;
            case 4:
                $column = 'sakit_dng_sk';
                break;
            case 5:
                $column = 'cuti';
                break;
            case 6:
                $column = 'alpha';
                break;
        }

        // Eksekusi update rekap
        if ($column !== null) {
            $this->db->set($column, "$column + 1", FALSE);
            $this->db->where('id', $id_rekap);
            $this->db->update('ts_rekap_absensi_pjlp');
        }

        $this->session->set_flashdata('success', 'Absensi ketidakhadiran berhasil disimpan');
        redirect('admin/absensi_pjlp/main');
    }

    function change_periode($id_pjlp)
    {
        $this->session->set_userdata($this->input->post());

        if ($id_pjlp == 0) {
            redirect('admin/absensi_pjlp/main');
        } else {
            redirect('admin/absensi_pjlp/index/' . $id_pjlp);
        }
    }



    public function delete_data_rekap_pegawai($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('ts_rekap_absensi_pjlp');

        $pesan =  createMessageInfo('Data absensi  berhasil dihapus');
        $this->session->set_flashdata('message', $pesan);

        redirect('admin/absensi_pjlp/main');
    }

    function sinkron_data_shift($id_pegawai, $id_pjlp)
    {

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



        $periode = $tahun . '-' . $bulan;
        $periode = date('Y-m', strtotime($periode));

        $qry = $this->db->get_where('tbl_pegawai_pjlp', ['id_pjlp' => $id_pjlp]);
        $row1 = $qry->row();
        if (!empty($row1)) {
            $pin =  $row1->id_mesin;
        } else {
            $this->session->set_flashdata('error', 'PIN tidak ditemukan');
            redirect('admin/absensi_pjlp/index/' . $id_pjlp);
        }



        $sql = "SELECT a.*, b.jam_masuk, b.jam_pulang
                FROM ts_shift_kerja a
                LEFT JOIN mst_shift_kerja b ON a.shift = b.kode_shift
                WHERE pin = '$pin' AND tanggal like '$periode%'";



        $qry = $this->db->query($sql);
        $row = $qry->result();

        if (empty($row)) {

            $this->session->set_flashdata('error', 'Data shift  tidak ditemukan');
            redirect('admin/absensi_pjlp/index/' . $id_pjlp);
        }

        // print_array($row);
        // exit;

        for ($i = 0; $i < count($row); $i++) {

            $tanggal = $row[$i]->tanggal;
            $shift = $row[$i]->shift;
            $jam_masuk = $row[$i]->jam_masuk;
            $jam_pulang = $row[$i]->jam_pulang;


            $cekID = $this->Presensi_model->cekAbsenExist($tanggal, $id_pjlp, 'tbl_absensi_pjlp');

            if ($cekID == 0) {
                $newArray = array(
                    'tanggal' => $tanggal,
                    'pin' => $id_pjlp,
                    'shift' => $shift,
                    'jam_masuk' => $jam_masuk,
                    'jam_pulang' => $jam_pulang,
                    'masuk' => '',
                    'pulang' => '',
                    'telat' => 0,
                    'p_awal' => 0,
                    'keterangan' => ''
                );

                $this->db->insert('tbl_absensi_pjlp', $newArray);
            } else {
                $newArray = array(
                    'tanggal' => $tanggal,
                    'pin' => $id_pjlp,
                    'shift' => $shift,
                    'jam_masuk' => $jam_masuk,
                    'jam_pulang' => $jam_pulang,
                    'telat' => 0,
                    'p_awal' => 0,
                    'keterangan' => ''
                );

                $this->db->where('id', $cekID);
                $this->db->update('tbl_absensi_pjlp', $newArray);
            }
        }
        $this->session->set_flashdata('success', 'Data shift pegawai berhasil diupdate');

        redirect('admin/absensi_pjlp/index/' . $id_pjlp);
    }

    // function update_rekap()
    // {

    //     $bulan = $this->session->userdata('periode_bulan');
    //     $tahun = $this->session->userdata('periode_tahun');

    //     $periode = $tahun . '-' . $bulan;
    //     $periode = date('Y-m', strtotime($periode));

    //     $pegawai = $this->Pegawai_model->getPegawaiPJLP();

    //     // print_array($pegawai);
    //     // exit;
    //     //cekDataRekapAbsensi($id_pegawai, $periode,  $table='ts_rekap_absensi')

    //     for ($i = 0; $i < count($pegawai); $i++) {
    //         $id_pjlp = $pegawai[$i]->id_pjlp;

    //         $cekID = $this->Presensi_model->cekDataRekapAbsensi($id_pjlp, $periode,  'ts_rekap_absensi_pjlp');

    //         //  echo   $i.'--'.$id_pjlp.' --'.$cekID.'<br>';


    //         if ($cekID == 0) {
    //             $this->Presensi_model->insertRekapAbsensiPJLP($id_pjlp, $periode);
    //         } else {
    //         }
    //     }


    //     redirect('admin/absensi_pjlp/main');
    // }

    public function input_absensi_manual($id_pjlp = '')
    {
        $tgl_absensi = $this->input->post('tgl_absensi');
        $absensi_masuk = $this->input->post('absensi_masuk');
        $absensi_keluar = $this->input->post('absensi_keluar');

        if ($absensi_masuk != '') {

            $this->Presensi_model->insertJamAbsen($tgl_absensi, $absensi_masuk, $id_pjlp, 0);
        }

        if ($absensi_keluar != '') {
            $this->Presensi_model->insertJamAbsen($tgl_absensi, $absensi_keluar, $id_pjlp, 1);
        }

        redirect('admin/absensi_pjlp/index/' . $id_pjlp);
    }
    public function delete_absen($tanggal, $id_pjlp, $status)
    {
        $this->db->where('pin', $id_pjlp);
        $this->db->where('tanggal', $tanggal);
        if ($status == 'masuk') {
            $this->db->set('masuk', '');
        } else {
            $this->db->set('pulang', '');
        }
        $this->db->update('tbl_absensi_pjlp');

        $pesan =  createMessageInfo('Data absensi  berhasil dihapus');
        $this->session->set_flashdata('message', $pesan);

        redirect('admin/absensi_pjlp/index/' . $id_pjlp);
    }

    function sinkron_data_absensi($id_pegawai, $id_pjlp)
    {
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


        $periode = $tahun . '-' . $bulan;
        $periode = date('Y-m', strtotime($periode));


        $this->db->where('pin', $id_pjlp);
        $this->db->like('tanggal', $periode, 'after');
        $qry = $this->db->get('import_absen');
        $row = $qry->result();

        // print_array($row);
        // exit;
        for ($i = 0; $i < count($row); $i++) {


            $status = $row[$i]->status;
            $tanggal = $row[$i]->tanggal;
            $tgl = format_db($tanggal);
            $jam = date('H:i:s', strtotime($tanggal));

            $cekID = $this->Presensi_model->cekAbsenExist($tgl, $id_pjlp, 'tbl_absensi_pjlp');


            if ($cekID == 0) {

                if ($status == 0) {
                    $absenMasuk  = $jam;
                    $absenPulang = '-';
                } else {
                    $absenMasuk  = '-';
                    $absenPulang = $jam;
                }

                $newArray = array(
                    'tanggal' => $tanggal,
                    'pin' => $id_pjlp,
                    'shift' => 'OFF',
                    'jam_masuk' => '00:00:00',
                    'jam_pulang' => '00:00:00',
                    'masuk' => $absenMasuk,
                    'pulang' => $absenPulang,
                    'telat' => 0,
                    'p_awal' => 0,
                    'keterangan' => ''
                );

                $this->db->insert('tbl_absensi_pjlp', $newArray);
            } else {

                if ($status == 0) {
                    $newArray = array(
                        'tanggal' => $tanggal,
                        'pin' => $id_pjlp,
                        'masuk' => $jam,
                        'telat' => 0,
                        'p_awal' => 0,
                        'keterangan' => ''
                    );
                } else {
                    $newArray = array(
                        'tanggal' => $tanggal,
                        'pin' => $id_pjlp,
                        'pulang' => $jam,
                        'telat' => 0,
                        'p_awal' => 0,
                        'keterangan' => ''
                    );
                }


                $this->db->where('id', $cekID);
                $this->db->update('tbl_absensi_pjlp', $newArray);
            }
        }

        $this->session->set_flashdata('success', 'Data absensi berhasil disinkronkan!');
        redirect('admin/absensi_pjlp/index/' . $id_pjlp);
    }

    public function update_rekap($id_pegawai, $pin, $periode)
    {
        // 1. Ambil seluruh data absensi pegawai di bulan/periode tersebut
        // Format $periode disesuaikan dengan isi database Anda (misal: '2026-09')
        $dataAbsensi = $this->Presensi_model->getAbsensiBulan($pin, $periode);

        // 2. Inisialisasi variabel hitung
        $totalTelat  = 0; // Menit
        $totalPAwal  = 0; // Menit

        // Counter untuk kategori presensi
        $counts = [
            'izin'        => 0, // IZIN SEHARI
            'izin_half'   => 0, // IZIN SETENGAH HARI AWAL / AKHIR
            'sakit'       => 0, // SAKIT TNP SURAT KETERANGAN
            'sakit_dgn_sk' => 0, // SAKIT DGN SURAT KETERANGAN
            'cuti'        => 0, // CUTI
            'alpha'       => 0, // ALPHA
            'isoman'      => 0, // ISOMAN (opsional jika ada)
        ];

        // 3. Looping data absensi harian
        if (!empty($dataAbsensi)) {
            foreach ($dataAbsensi as $row) {
                // Akumulasi keterlambatan & pulang awal
                $totalTelat += (int) $row->telat;
                $totalPAwal += (int) $row->p_awal;

                // Ambil string status (cek kolom masuk atau keterangan)
                $status = strtoupper(trim($row->masuk != '' ? $row->masuk : $row->keterangan));

                // Mapping berdasarkan kriteria $arrayAbsens Anda
                switch ($status) {
                    case 'IZIN SEHARI':
                        $counts['izin']++;
                        break;

                    case 'IZIN SETENGAH HARI AWAL':
                    case 'IZIN SETENGAH HARI AKHIR':
                        $counts['izin_half']++;
                        break;

                    case 'SAKIT TNP SURAT KETERANGAN':
                        $counts['sakit']++;
                        break;

                    case 'SAKIT DGN SURAT KETERANGAN':
                        $counts['sakit_dgn_sk']++;
                        break;

                    case 'CUTI':
                        $counts['cuti']++;
                        break;

                    case 'ALPHA':
                        $counts['alpha']++;
                        break;

                    case 'ISOMAN':
                        $counts['isoman']++;
                        break;
                }
            }
        }

        // 4. Mapping data sesuai struktur tabel `ts_rekap_absensi_pjlp`
        $dataSave = [
            'id_pegawai'   => $pin,
            'periode'      => $periode,
            'telat'        => $totalTelat,
            'pulang_awal'  => $totalPAwal,
            'izin'         => $counts['izin'],
            'izin_half'    => $counts['izin_half'],
            'sakit'        => $counts['sakit'],
            'sakit_dgn_sk' => $counts['sakit_dgn_sk'],
            'cuti'         => $counts['cuti'],
            'alpha'        => $counts['alpha'],
            'isoman'       => $counts['isoman'],
            'date_update'  => date('Y-m-d H:i:s')
        ];

        // print_array($dataSave);
        // exit;

        // 5. Jalankan query Insert / Update
        $simpan = $this->Presensi_model->saveRekapBulanan($dataSave);

        if ($simpan) {
            $this->session->set_flashdata('success', 'Data rekap berhasil diperbarui!');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data rekap.');
        }

        redirect('admin/absensi_pjlp/index/' . $pin);
    }


    function update_perhitungan_absensi($id_pegawai, $id_pjlp)
    {

        $bulan = $this->session->userdata('periode_bulan');
        $tahun = $this->session->userdata('periode_tahun');

        $periode = $tahun . '-' . $bulan;
        $periode = date('Y-m', strtotime($periode));


        $absensi = $this->Presensi_model->getAbsensiPegawai($id_pjlp, $periode, 'tbl_absensi_pjlp');

        $totalTelat = 0;

        // print_array($absensi);
        foreach ($absensi as $list) {
            $id          = $list->id;
            $tanggal     = $list->tanggal;
            $shift       = $list->shift;
            $jam_masuk   = $list->jam_masuk;
            $jam_pulang  = $list->jam_pulang;
            $masuk       = $list->masuk;
            $pulang      = $list->pulang;


            $jamMskKerja = substr($jam_masuk, 0, 2);
            $jamMsk      = substr($masuk, 0, 2);


            $menit1 =  substr($jam_masuk, 3, 2);
            $menit2 =  substr($masuk, 3, 2);

            if ($shift != 'OFF2') {

                if (!strpos($masuk, ':') === false) {


                    if ($jamMsk >= $jamMskKerja && $menit2 > $menit1) {



                        $difference = $this->getTimeDifference($jam_masuk, $masuk);
                        //  print_array($difference);

                        $jam_telat   = $difference['hours'];
                        $menit_telat = $difference['minutes'];

                        $totalTelatPerhari = ($jam_telat * 60) + $menit_telat;

                        $newArray = array(
                            'telat' => $totalTelatPerhari,
                            'p_awal' => 0,
                        );

                        //  echo $totalTelatPerhari;
                        //print_array($newArray);

                        $this->db->where('id', $id);
                        $this->db->update('tbl_absensi_pjlp', $newArray);

                        $totalTelat =   $totalTelat +  $totalTelatPerhari;
                        //echo $tanggal . " -- Differencfe: {$difference['hours']} hours, {$difference['minutes']} minutes, {$difference['seconds']} seconds. <br>";

                    } else {
                        $newArray = array(
                            'telat' => 0,
                            'p_awal' => 0,
                        );

                        //  echo $totalTelatPerhari;
                        //print_array($newArray);

                        $this->db->where('id', $id);
                        $this->db->update('tbl_absensi_pjlp', $newArray);
                    }
                }
            }
        }


        $cekID = $this->Presensi_model->cekDataRekapAbsensi($id_pjlp, $periode,  'ts_rekap_absensi_pjlp');

        if ($cekID == 0) {
            $this->Presensi_model->insertRekapAbsensiPJLP($id_pjlp, $periode);
        } else {
            $this->db->where('id', $cekID);
            $this->db->set('telat', $totalTelat);
            $this->db->update('ts_rekap_absensi_pjlp');
        }

        exit;

        redirect('admin/absensi_pjlp/index/' . $pin);
    }

    function ajax_lihat_absensi_ketidakhadiran()
    {

        $dataPjlp = $this->input->post('dataPjlp');

        $explod  = explode("-", $dataPjlp);
        $id_pjlp = trim($explod[0]);

        $bulan = $this->session->userdata('periode_bulan');
        $tahun = $this->session->userdata('periode_tahun');

        // Memastikan format YYYY-MM tepat dua digit bulan (misal: 2026-05)
        $periode = sprintf('%04d-%02d', $tahun, $bulan);

        $this->db->select('*');
        $this->db->from('tbl_absensi_pjlp');
        $this->db->where('pin', $id_pjlp);

        // Filter berdasarkan periode bulan & tahun pada kolom tanggal
        $this->db->where("DATE_FORMAT(tanggal, '%Y-%m') =", $periode);

        // Filter khusus jenis absensi (bebas pilih metode A atau B di bawah)
        // METODE A: Mengambil SEMUA ketidakhadiran (selain absensi normal/kosong)
        $this->db->group_start()
            ->where_in('masuk', [
                'IZIN SEHARI',
                'IZIN SETENGAH HARI AWAL',
                'IZIN SETENGAH HARI AKHIR',
                'SAKIT TNP SURAT KETERANGAN',
                'SAKIT DGN SURAT KETERANGAN',
                'CUTI',
                'ALPHA'
            ])
            ->or_where_in('pulang', [
                'IZIN SEHARI',
                'IZIN SETENGAH HARI AWAL',
                'IZIN SETENGAH HARI AKHIR',
                'SAKIT TNP SURAT KETERANGAN',
                'SAKIT DGN SURAT KETERANGAN',
                'CUTI',
                'ALPHA'
            ]);
        $this->db->group_end();

        $row = $this->db->get()->result();


        echo '<div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="exampleModalLabel1">
                    Data Ketidakhadiran Pegawai
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                     <table class="table">
                      <tr>
                        <th>Tanggal</th>
                        <th>Jenis Absensi</th>
                        <th>Keterangan</th>
                        <th>Hapus</th>
                      </tr>
                     ';

        for ($i = 0; $i < count($row); $i++) {
            $masuk = $row[$i]->masuk;
            $pulang = $row[$i]->pulang;

            if ($pulang != '') {
                $info_absen = $pulang;
            } else {
                $info_absen = $masuk;
            }



            echo '
                            <tr>
                            <td class="text-center ">' . format_semi($row[$i]->tanggal) . '</td>
                            <td class="text-center ">' . $info_absen . '</td>
                            <td>' . $row[$i]->keterangan . '</td>
                            <td class="text-center ">
                                <a href="' . base_url() . 'admin/absensi_pjlp/delete_absen_ketidakhadiran?id=' . $row[$i]->id . '&tanggal=' . $row[$i]->tanggal . '&id_pjlp=' . $id_pjlp . '&periode=' . $periode . '" class="text-danger" onClick="return confirm(\'Apakah anda yakin ingin menghapus data absensi ini?\')">
                                <i class="ti ti-trash fs-6"></i>
                                </a>
                            </td>
                            </tr>
                        ';
        }

        echo '
                    </table>
                    </div>

                </div>
                 <div class="modal-footer">
                    <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">
                    Close
                    </button>
                    <button type="submit" class="btn btn-success">
                    Submit
                    </button>
                </div>';
    }


    function delete_absen_ketidakhadiran()
    {
        $id = $this->input->get('id');
        $tanggal = $this->input->get('tanggal');
        $id_pjlp = $this->input->get('id_pjlp');
        $periode = $this->input->get('periode');



        $jenis_absensi = null;
        $newArray = [];

        $qry = $this->db->get_where('tbl_absensi_pjlp', ['id' => $id, 'tanggal' => $tanggal]);
        $row = $qry->row();
        // print_array($row);
        // exit;
        if (!empty($row)) {
            $masuk = $row->masuk;
            $pulang = $row->pulang;
            if ($pulang == 'IZIN SETENGAH HARI AKHIR') {

                $newArray = array(
                    'pulang' => '',
                    'keterangan' => ''
                );

                $jenis_absensi = 2;
            }

            if ($masuk == 'IZIN SETENGAH HARI AWAL') {
                $newArray = array(
                    'masuk' => '',
                    'keterangan' => ''
                );

                $jenis_absensi = 1;
            } else if ($masuk == 'IZIN SEHARI') {
                $newArray = array(
                    'masuk' => '',
                    'pulang' => '',
                    'keterangan' => ''
                );
                $jenis_absensi = 0;
            } else if ($masuk == 'SAKIT TNP SURAT KETERANGAN') {
                $newArray = array(
                    'masuk' => '',
                    'pulang' => '',
                    'keterangan' => ''
                );
                $jenis_absensi = 3;
            } else if ($masuk == 'SAKIT DGN SURAT KETERANGAN') {
                $newArray = array(
                    'masuk' => '',
                    'pulang' => '',
                    'keterangan' => ''
                );
                $jenis_absensi = 4;
            } else if ($masuk == 'CUTI') {
                $newArray = array(
                    'masuk' => '',
                    'pulang' => '',
                    'keterangan' => ''
                );
                $jenis_absensi = 5;
            }

            $this->db->where('id', $id);
            $this->db->update('tbl_absensi_pjlp', $newArray);

            //prses update
        }


        // --- REKAP ABSENSI PJLP ---
        $dataRekap = $this->Presensi_model->getDataRekapAbsensiPJLP($id_pjlp, $periode);

        if (!empty($dataRekap)) {
            $id_rekap = $dataRekap[0]->id;
        } else {
            $this->Presensi_model->insertRekapAbsensiPJLP($id_pjlp, $periode);
            $dataRekap = $this->Presensi_model->getDataRekapAbsensiPJLP($id_pjlp, $periode);
            $id_rekap = $dataRekap[0]->id;
        }

        // Tentukan kolom rekap berdasarkan jenis absensi
        $column = null;
        switch ($jenis_absensi) {
            case 0:
                $column = 'izin';
                break;
            case 1:
            case 2:
                $column = 'izin_half';
                break;
            case 3:
                $column = 'sakit';
                break;
            case 4:
                $column = 'sakit_dng_sk';
                break;
            case 5:
                $column = 'cuti';
                break;
            case 6:
                $column = 'alpha';
                break;
        }

        // Eksekusi update rekap
        if ($column !== null) {
            $this->db->set($column, "$column - 1", FALSE);
            $this->db->where('id', $id_rekap);
            $this->db->update('ts_rekap_absensi_pjlp');
        }




        $this->session->set_flashdata('message', 'Absensi ketidakhadiran berhasil dihapus');
        redirect('admin/absensi_pjlp/main');
    }

    function getTimeDifference($start, $end)
    {
        // Convert the time strings to DateTime objects
        $startTime = new DateTime($start);
        $endTime = new DateTime($end);

        // Calculate the difference
        $interval = $startTime->diff($endTime);

        // Format the result as needed (e.g., hours, minutes, seconds)
        $hours = $interval->h;
        $minutes = $interval->i;
        $seconds = $interval->s;

        // Handle cases where the difference spans across days
        $hours += ($interval->days * 24);

        return [
            'hours' => $hours,
            'minutes' => $minutes,
            'seconds' => $seconds
        ];
    }




    function print_data($id_pjlp)
    {
        //$data['data_pjlp'] = $this->Pegawai_model->detailPegawaiPJLP($id_pjlp);
        $qry = $this->db->get_where('mst_pegawai', array('nip' => $id_pjlp));
        $data['data_pjlp'] = $qry->result();

        $this->load->view('admin/absensi/print_absen', $data);
    }
}
