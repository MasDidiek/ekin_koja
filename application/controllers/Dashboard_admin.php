<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api/Api_cuti_model');
        $this->load->model('api/Api_absensi_model');
        $this->load->model('api/Master_api_model');
        $this->load->config('api');



        //$this->_auth();
    }

    public function cuti()
    {
        $data = $this->Api_cuti_model->get_all();
        $data['cuti'] = $data;
        $this->load->view('dashboard_admin/cuti/index', $data);

        // print_array($data);
        // return $this->_response($data);
    }


    public function getDataCuti()
    {
        $param = [
            'jenis_cuti' => $this->input->get('jenis_cuti'),
            'status_akhir' => $this->input->get('status_akhir'),
            'bulan' => $this->input->get('bulan'),
            'tahun' => $this->input->get('tahun')
        ];

        $data = $this->Api_cuti_model->get_all($param);

        return $this->_response($data);
    }


    function cuti_detail($id = null)
    {


        if (empty($id)) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Parameter id tidak boleh kosong'
                ]));
        }



        $data_cuti = $this->Api_cuti_model->get_by_id($id);


        if (!$data_cuti) {
            return $this->output
                ->set_status_header(404)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Data cuti tidak ditemukan'
                ]));
        }

        $id_pegawai = $data_cuti->id_pegawai;

        $data_approval = $this->Api_cuti_model->get_data_approval($id);
        $data_hak_cuti = $this->Api_cuti_model->getHakCutiPegawai($id_pegawai);
        $data_riwayat  = $this->Api_cuti_model->getRiwayatCutiPegawai($id_pegawai);
        $list_hari_cuti = $this->Api_cuti_model->getListHariCuti($id);


        $this->load->view('dashboard_admin/cuti/detail', [
            'cuti' => $data_cuti,
            'approval' => $data_approval,
            'hak_cuti' => $data_hak_cuti,
            'history' => $data_riwayat,
            'list_hari' => $list_hari_cuti
        ]);
    }


    function acc_cuti()
    {
        $id_cuti       = $this->input->get('id_pengajuan');
        $id_approval   = $this->input->get('id_approval');
        $role_approval = $this->input->get('role');

        if (empty($id_cuti)) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Parameter id tidak boleh kosong'
                ]));
        }

        //mapping next approval
        $next_role = [
            'kapustu' => 'ktu',
            'ktu'     => 'kapus'
        ];


        $cuti =  $this->Api_cuti_model->get_by_id($id_cuti);

        $pin = $cuti->pin;
        $hari_cuti   = $cuti->lama_cuti;
        $id_pegawai = $cuti->id_pegawai;
        $tahun_hak_cuti = $cuti->tahun_hak_cuti;
        $tgL_mulai   = $cuti->tgl_mulai;
        $tgl_selesai = $cuti->tgl_selesai;


        //ubah status di table pengajuan cuti approval menjadi approved

        $this->db->where('id', $id_approval);
        $updateApproval =  $this->db->update('ts_pengajuan_cuti_approval', [
            'status' => 'approved',
            'approved_at' => date('Y-m-d H:i:s')
        ]);


        if (isset($next_role[$role_approval])) {
            $this->db->where('id_pengajuan_cuti', $id_cuti);
            $this->db->where('role_approval', $next_role[$role_approval]);
            $this->db->update('ts_pengajuan_cuti_approval', [
                'status' => 'pending'
            ]);
        } else {

            //jika role nya adalah kapus kecamatan
            if ($tahun_hak_cuti != 0) {
                //cuti tahunan

                $this->db->where('id_pegawai', $id_pegawai);
                $this->db->where('tahun', $tahun_hak_cuti);
                $hak_cuti_pegawai = $this->db->get('ts_hak_cuti_pegawai')->row();

                $hak_total = $hak_cuti_pegawai->hak_total;
                $hak_reserved = $hak_cuti_pegawai->hak_reserved;
                $hak_terpakai = $hak_cuti_pegawai->hak_terpakai;

                //ambil nilai hak reserved saat ini, lalu kurangi dengan lama cuti yang diambil
                $sisa_hak_reserved = $hak_reserved - $hari_cuti;
                $sisa_akhir = $hak_total - ($sisa_hak_reserved + $hak_terpakai);

                $this->Api_cuti_model->updateHakCuti($id_pegawai, $tahun_hak_cuti, $hak_terpakai,  $hari_cuti, $sisa_hak_reserved);
                $this->Api_cuti_model->updateLogMutasiCuti($id_pegawai, $id_cuti, $tahun_hak_cuti, $hari_cuti, $sisa_hak_reserved, $sisa_akhir);
            }

            //update status cuti dan approval
            $this->db->where('id', $id_cuti);
            $this->db->update('ts_pengajuan_cuti', [
                'status_akhir' => 'disetujui'
            ]);

            $this->db->where('id_pengajuan_cuti', $id_cuti);
            $this->db->update('ts_pengajuan_cuti_approval', [
                'status' => 'approved'
            ]);
        } //close if role approval = kapus

        $update = $this->Api_absensi_model->updateAbsensiKehadiranCuti($id_cuti, $pin);


        return $this->_response([
            'status' => $update
        ]);
    }

    function deleteCuti()
    {
        $id_cuti = $this->input->get('id');

        $this->db->where('id_pengajuan_cuti', $id_cuti);
        $this->db->delete('ts_log_mutasi_cuti');

        $this->db->where('id_pengajuan_cuti', $id_cuti);
        $this->db->delete('ts_pengajuan_cuti_approval');

        $this->db->where('id_pengajuan_cuti', $id_cuti);
        $this->db->delete('ts_pengajuan_cuti_detail');



        $this->db->where('id', $id_cuti);
        $delete = $this->db->delete('ts_pengajuan_cuti');

        return $this->_response([
            'status' => $delete
        ]);
    }

    function re_sync_absen_cuti()
    {
        $id_cuti = $this->input->get('id');
        $pin     = $this->input->get('pin');

        if (empty($id_cuti)) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Parameter id tidak boleh kosong'
                ]));
        }

        $update = $this->Api_absensi_model->updateAbsensiKehadiranCuti($id_cuti, $pin);


        return $this->_response([
            'status' => $update
        ]);
    }


    function updateCuti()
    {
        $id_cuti     = $this->input->post('id_cuti');
        $jns_cuti    = $this->input->post('jenis_cuti');
        $tahun_hak_cuti = $this->input->post('tahun_hak_cuti');
        $tgl_mulai = $this->input->post('tgl_mulai');
        $tgl_selesai = $this->input->post('tgl_selesai');
        $alasan_cuti = $this->input->post('alasan_cuti');
        $alamat_cuti = $this->input->post('alamat_cuti');

        // validasi sederhana
        if (
            empty($id_cuti) ||
            empty($tgl_mulai) ||
            empty($tgl_selesai) ||
            empty($jns_cuti)
        ) {

            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Parameter tidak lengkap'
                ]));
        }

        $start_date = new DateTime($tgl_mulai);
        $end_date = new DateTime($tgl_selesai);


        //pertama cari tau dulu, pegawai ini jenis jam kerjanya shift atau reguler
        $cuti = $this->db->get_where('ts_pengajuan_cuti', ['id' => $id_cuti])->row();
        if (empty($cuti)) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Data cuti tidak ditemukan'
                ]));
        }

        $id_pegawai   = $cuti->id_pegawai;
        $lama_cuti_db = $cuti->lama_cuti;

        $this->db->select('jns_jam_kerja');
        $pegawai       = $this->db->get_where('mst_pegawai', ['id_pegawai' => $id_pegawai])->row();
        if (empty($pegawai)) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Data pegawai tidak ditemukan'
                ]));
        }

        $jns_jam_kerja = $pegawai->jns_jam_kerja;

        if ($jns_jam_kerja == 'non_shift') {
            //update data di table pengajuan_cuti detail
            //pertama hapus data lama di table ts_pengajuan_cuti_detail, lalu insert data baru sesuai dengan tanggal yang baru
            $this->db->where('id_pengajuan_cuti', $id_cuti);
            $this->db->delete('ts_pengajuan_cuti_detail');

            //hitung hari kerja
            //jika start date dan end date sama, maka lama cuti 1 hari
            if ($start_date->format('Y-m-d') == $end_date->format('Y-m-d')) {
                $lama_cuti = 1;

                $this->db->insert('ts_pengajuan_cuti_detail', [
                    'id_pengajuan_cuti' => $id_cuti,
                    'tgl_cuti' => $end_date->format('Y-m-d')
                ]);
            } else {
                $lama_cuti = 0;
                $current_date = clone $start_date;

                while ($current_date <= $end_date) {

                    $tanggal = $current_date->format('Y-m-d');

                    // ambil shift di tanggal tersebut
                    $shift_detail = $this->db
                        ->where('tanggal', $tanggal)
                        ->get('tbl_shift_template_detail')
                        ->row();

                    // jika shift_id bukan 1 maka dihitung cuti
                    if ($shift_detail && $shift_detail->shift_id != 1) {

                        $lama_cuti++;

                        // insert hanya hari kerja
                        $this->db->insert('ts_pengajuan_cuti_detail', [
                            'id_pengajuan_cuti' => $id_cuti,
                            'tgl_cuti' => $tanggal
                        ]);
                    }


                    $current_date->modify('+1 day');
                }
            }
        } else {
            //klo pegawai yg jam kerjanya shift2an, maka semua tgl dihitung cuti
            //hitung hari kalender
            $interval = $start_date->diff($end_date);
            $lama_cuti = $interval->days + 1;


            //update data di table pengajuan_cuti detail
            //pertama hapus data lama di table ts_pengajuan_cuti_detail, lalu insert data baru sesuai dengan tanggal yang baru
            $this->db->where('id_pengajuan_cuti', $id_cuti);
            $this->db->delete('ts_pengajuan_cuti_detail');

            //input baru
            $current_date = $start_date;
            while ($current_date <= $end_date) {
                $this->db->insert('ts_pengajuan_cuti_detail', [
                    'id_pengajuan_cuti' => $id_cuti,
                    'tgl_cuti' => $current_date->format('Y-m-d')
                ]);

                $current_date->modify('+1 day');
            }
        }


        // kalo lama cuti berubah, update juga di hak cuti pegawai, dengan cara ambil dulu hak reserved yang lama, lalu kurangi dengan lama cuti yang lama, lalu tambahkan dengan lama cuti yang baru
        if ($lama_cuti != $lama_cuti_db) {
            $hak_cuti = $this->db->get_where('ts_hak_cuti_pegawai', ['id_pegawai' => $id_pegawai, 'tahun' => $tahun_hak_cuti])->row();
            $hak_reserved_lama = $hak_cuti->hak_reserved;
            $hak_reserved_baru = $hak_reserved_lama - $lama_cuti_db + $lama_cuti;

            $this->db->where('id_pegawai', $id_pegawai);
            $this->db->where('tahun', $tahun_hak_cuti);
            $this->db->update('ts_hak_cuti_pegawai', ['hak_reserved' => $hak_reserved_baru]);

            //update log mutasi cuti
            $this->db->insert('ts_log_mutasi_cuti', [
                'id_pengajuan_cuti' => $id_cuti,
                'id_pegawai' => $id_pegawai,
                'tahun' => $tahun_hak_cuti,
                'tipe' => 'update',
                'jumlah' => $lama_cuti - $lama_cuti_db,
                'saldo_sebelum' => $hak_reserved_lama,
                'saldo_sesudah' => $hak_reserved_baru,
                'keterangan' => 'Update pengajuan cuti, perubahan lama cuti dari ' . $lama_cuti_db . ' hari menjadi ' . $lama_cuti . ' hari'
            ]);
        }



        //update di table ts_pengajuan_cuti
        $this->db->where('id', $id_cuti);
        $update = $this->db->update('ts_pengajuan_cuti', [
            'lama_cuti' => $lama_cuti,
            'tgl_mulai' => $start_date->format('Y-m-d'),
            'tgl_selesai' => $end_date->format('Y-m-d'),
            'alasan_cuti' => $alasan_cuti,
            'alamat_cuti' => $alamat_cuti,
            'tahun_hak_cuti' => $tahun_hak_cuti
        ]);
        if ($update) {

            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => true,
                    'message' => 'Data cuti berhasil diupdate'
                ]));
        }
    }



    // public function updateCuti()
    // {
    //     $this->_auth();

    //     $id_cuti     = $this->input->post('id_cuti');
    //     $tgl_mulai   = $this->input->post('tgl_mulai');
    //     $tgl_selesai = $this->input->post('tgl_selesai');
    //     $alasan      = $this->input->post('alasan');
    //     $jenis_cuti  = $this->input->post('jenis_cuti');

    //     // validasi sederhana
    //     if (
    //         empty($id_cuti) ||
    //         empty($tgl_mulai) ||
    //         empty($tgl_selesai) ||
    //         empty($alasan) ||
    //         empty($jenis_cuti)
    //     ) {

    //         return $this->output
    //             ->set_status_header(400)
    //             ->set_content_type('application/json')
    //             ->set_output(json_encode([
    //                 'status' => false,
    //                 'message' => 'Parameter tidak lengkap'
    //             ]));
    //     }

    //     $data = [
    //         'tgl_mulai'   => $tgl_mulai,
    //         'tgl_selesai' => $tgl_selesai,
    //         'alasan'      => $alasan,
    //         'jenis_cuti'  => $jenis_cuti
    //     ];

    //     $update = $this->Api_cuti_model->update_cuti($id_cuti, $data);

    //     if ($update) {

    //         return $this->output
    //             ->set_content_type('application/json')
    //             ->set_output(json_encode([
    //                 'status' => true,
    //                 'message' => 'Data cuti berhasil diupdate'
    //             ]));
    //     }

    //     return $this->output
    //         ->set_status_header(500)
    //         ->set_content_type('application/json')
    //         ->set_output(json_encode([
    //             'status' => false,
    //             'message' => 'Gagal update data'
    //         ]));
    // }




    /*----------------absensi pegawai------------------*/


    function getDataRekapAbsensi()
    {
        $jns_pegawai = $this->input->get('jns_pegawai');
        $periode = $this->input->get('periode');

        if (empty($jns_pegawai) || empty($periode)) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Parameter jns_pegawai dan periode tidak boleh kosong'
                ]));
        }

        $data = $this->Api_absensi_model->getRekapAbsensiPerbulan($jns_pegawai, $periode);


        return $this->_response($data);
    }

    function getDataAbsensi()
    {
        $pin     = $this->input->get('pin');
        $periode = $this->input->get('periode');


        if (empty($pin) || empty($periode)) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Parameter pin dan periode tidak boleh kosong'
                ]));
        }

        $absensi       = $this->Presensi_model->getAbsensiPegawaiPerbulan($pin, $periode);
        $jns_pegawai   = 'non_pns';
        $pegawai       = $this->Api_absensi_model->getInfoPegawaiByPin($pin, $jns_pegawai);
        $id_pegawai    = $pegawai->id_pegawai;
        $rekap_absensi = $this->Api_absensi_model->getRekapAbsensiPerpegawai($id_pegawai, $periode);
        $data = [
            'absensi' => $absensi,
            'pegawai' => $pegawai,
            'rekap_absensi' => $rekap_absensi
        ];
        return $this->_response($data);
    }


    function insertPengajuanDL()
    {

        $this->_auth();

        $id_pegawai     = $this->input->post('id_pegawai');
        $tanggal   = $this->input->post('tanggal');
        $jns_dl = $this->input->post('jns_dl');
        $keterangan      = $this->input->post('keterangan');


        $newarray = array(
            'id_pegawai' => $id_pegawai,
            'tanggal ' => format_db($tanggal),
            'jns_dl' => $jns_dl,
            'photo' => '',
            'surtug' => '',
            'lat' => 0,
            'lon' => 0,
            'create_at' => date('Y-m-d H:i:s'),
            'keterangan' => $keterangan
        );

        $insert =     $this->db->insert('pengajuan_dinas_luar', $newarray);
        return $this->_response($insert);
    }

    // function updateRekapAbsensi()
    // {
    //     $pin     = $this->input->get('pin');
    //     $periode = $this->input->get('periode');


    //     if (empty($pin) || empty($periode)) {
    //         return $this->output                
    //             ->set_status_header(400)
    //             ->set_content_type('application/json')
    //             ->set_output(json_encode([
    //                 'status' => false,
    //                 'message' => 'Parameter pin dan periode tidak boleh kosong'
    //           ]));
    //     }

    //     $absensi       = $this->Presensi_model->getAbsensiPegawaiPerbulan($pin, $periode);
    //     $jns_pegawai   = 'non_pns';
    //     $pegawai       = $this->Api_absensi_model->getInfoPegawaiByPin($pin, $jns_pegawai);
    //     $id_pegawai    = $pegawai->id_pegawai;

    //     foreach ($absensi as $abs) {
    //         $id = $abs->id;
    //         $status = $abs->status;
    //         $status_detail = $abs->status_detail;

    //         if($status=='CUTI' || $status=='SAKIT'){

    //             $this->Api_absen_model->updateDataKehadiran($id, 'SAKIT', $jam_pulang=null, $telat=0, $p_awal=0);

    //         }else{
    //               if($status_detail==''){

    //               }
    //         }



    //     }


    //     print_array($absensi);
    // }



    function getCapaianKinerja()
    {

        $periode = $this->input->get('periode');

        if (empty($periode)) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Parameter id tidak boleh kosong'
                ]));
        }

        $data = $this->Master_api_model->getCapaianPegawai($periode);
        return $this->_response($data);
    }



    function getDetailCapaian()
    {
        $nip     = $this->input->get('nip');
        $periode = $this->input->get('periode');

        if (empty($nip) || empty($periode)) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Parameter nip dan periode tidak boleh kosong'
                ]));
        }

        $explodPeriode = explode("-", $periode);


        $qry = $this->db->get_where('mst_pegawai', ['nip' => $nip]);
        $row = $qry->row();

        if (empty($row)) {

            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => true,
                    'message' => 'Data tidak ditemukan'
                ]));

            die;
        }


        $id_pegawai    = $row->id_pegawai;
        $data          = $this->Api_absensi_model->getRekapAbsensiPerpegawai($id_pegawai, $periode);
        $input_kinerja = $this->Master_api_model->getTotalInputanKinerja($id_pegawai, $periode);
        $waktu_efektif = $this->Master_api_model->getWaktuEfektif($periode);
        $poinPerilaku  = $this->Kinerja_model->getPoinPerilaku($id_pegawai, $explodPeriode[1], $explodPeriode[0]);


        return $this->_response([
            'data_rekap' => $data,
            'inputan' => $input_kinerja,
            'waktu_efektif' => $waktu_efektif,
            'poin_perilaku' => $poinPerilaku,
            'serapan' => SERAPAN
        ]);
    }


    function updateCapaianKinerja()
    {


        $nip = $this->input->post('nip');
        $periode = $this->input->post('periode');
        $bobot_aktifitas = $this->input->post('bobot_aktifitas');
        $perilaku = $this->input->post('perilaku');
        $total_capaian = $this->input->post('total_capaian');

        $data = [
            'bobot_aktifitas' => $bobot_aktifitas,
            'perilaku' => $perilaku,
            'total_capaian' => $total_capaian
        ];

        $this->db->where('nip', $nip);
        $this->db->where('periode', $periode);

        $update = $this->db->update('tbl_capaian', $data);
        return $this->_response($update);
    }



    function updateStatusCekKinerja()
    {
        $nip     = $this->input->get('nip');
        $periode = $this->input->get('periode');
        $status = $this->input->get('status');
        if ($status == '') {
            $status = 1;
        }

        if (empty($nip) || empty($periode)) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Parameter nip dan periode tidak boleh kosong'
                ]));
        }

        $this->db->where('nip', $nip);
        $this->db->where('periode', $periode);
        $this->db->set('checked', $status);
        $update = $this->db->update('tbl_capaian');

        return $this->_response($update);
    }





    function getListingTKD()
    {

        $periode = $this->input->get('periode');

        if (empty($periode)) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Parameter id tidak boleh kosong'
                ]));
        }

        $data = $this->Master_api_model->getDataListingTKD($periode);
        return $this->_response($data);
    }



    function createListingTKD()
    {

        $periode = $this->input->get('periode');

        if (empty($periode)) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Parameter nip dan periode tidak boleh kosong'
                ]));
        }

        $data_gaji = $this->Master_api_model->getDataGajiPegawai();

        //print_array($data_gaji);
        foreach ($data_gaji as $list) {
            $nip = $list->nip;
            $nama = $list->nama;
            $tkd_pokok = $list->total_gaji;

            $lastRekapTKD = $this->Master_api_model->getLastRekapTKD($nip);
            if (empty($lastRekapTKD)) {
                $jabatan = '';
                $npwp    = '';
                $no_rekening    = '';
                $masa_kerja    = '0 tahun 0 bulan';
                $no_urut = 0;
            } else {
                $jabatan = $lastRekapTKD->jabatan;
                $npwp    = $lastRekapTKD->npwp;
                $no_rekening    = $lastRekapTKD->no_rekening;
                $masa_kerja    = $lastRekapTKD->masa_kerja;
                $no_urut =  $lastRekapTKD->urutan;
            }
            $insert =  $this->Master_api_model->insertListingTKD($periode, $nama, $jabatan, $nip, $npwp, $no_rekening, $masa_kerja,  $no_urut, $tkd_pokok);
        }
        return $this->_response($insert);
    }


    function getDataDinasLuar()
    {
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');

        $this->db->select('pengajuan_dinas_luar.*, mst_pegawai.nama');
        $this->db->from('pengajuan_dinas_luar');
        $this->db->join(
            'mst_pegawai',
            'mst_pegawai.id_pegawai = pengajuan_dinas_luar.id_pegawai',
            'left'
        );

        // filter tanggal minimal
        $this->db->where('pengajuan_dinas_luar.tanggal >', '2025-03-30');

        // jika bulan dan tahun ada
        if (!empty($bulan) && !empty($tahun)) {
            $this->db->where('MONTH(pengajuan_dinas_luar.tanggal)', $bulan);
            $this->db->where('YEAR(pengajuan_dinas_luar.tanggal)', $tahun);
        }

        $this->db->order_by('pengajuan_dinas_luar.tanggal', 'DESC');

        $qry = $this->db->get('', 500, 0);
        $data = $qry->result();

        return $this->_response($data);
    }


    function updateHakCuti()
    {
        $id_pegawai = $this->input->post('id_pegawai');
        $tahun = $this->input->post('hak_cuti_tahun');
        $field = $this->input->post('field'); //kolom
        $jumlah = $this->input->post('value'); //jumlah yg diinput

        $this->db->where('id_pegawai', $id_pegawai);
        $this->db->where('tahun', $tahun);
        $this->db->set($field, $jumlah);
        $update = $this->db->update('ts_hak_cuti_pegawai');
        redirect('admin/cuti/info_detail/' . $id_pegawai);
    }




    private function _auth()
    {
        $key = $this->input->get_request_header('X-API-KEY');

        if ($key !== $this->config->item('api_key')) {

            $this->output
                ->set_status_header(401)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Unauthorized'
                ]))
                ->_display();

            exit;
        }
    }

    private function _response($data)
    {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => true,
                'message' => 'success',
                'data' => $data
            ]));
    }
}
