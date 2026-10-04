<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Penilaian_kinerja extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();

        $this->load->model('Profile_model');

        $this->Auth_model->cekAuthLogin();
    }

    function index()
    {

        $id_validator = $this->session->userdata('id_pegawai');
        $id_pj_sess = $this->session->userdata('id_pj');
        $thn_anggaran = date('Y');

        if ($id_pj_sess != '') {
            $id_validator = $id_pj_sess;
        }


        $this->load->library('pagination');

        $config['base_url'] = base_url() . 'admin/penilaian_kinerja/index/';
        $config['total_rows'] = $this->Pegawai_model->countgetPegawaiPenilaianKinerja($id_validator, $thn_anggaran);
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['cur_tag_open'] = '<span class="page-item page-link active"><a href="#" class=" text-white">';
        $config['cur_tag_close'] = '</a></span>';


        $this->pagination->initialize($config);

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        // $data['results'] = $this->db->get('your_table', $config['per_page'], $page)->result();


        # echo $id_validator;
        $limit = $config['per_page'];
        $offset = $page;
        $data['data_pegawai'] =  $this->Pegawai_model->getPegawaiPenilaianKinerja($id_validator, $thn_anggaran, $limit, $offset);
        $data['pagination'] = $this->pagination->create_links();
        $data['validator'] = $this->Pegawai_model->getValidator();
        $this->load->view('penilaian_kinerja/index', $data);
    }


    function aktivitas($id_pegawai, $bulan, $tahun)
    {
        $data['pegawai'] = $this->Pegawai_model->getDetailPegawai($id_pegawai);
        $data['dataAktifitasPegawai'] = $this->Kinerja_model->getAktifitasPegawai($id_pegawai);
        $this->load->view('penilaian_kinerja/penilaian_aktivitas', $data);
    }


    function perilaku($id_pegawai, $bulan, $tahun)
    {
        $cekPenilaian = $this->Kinerja_model->cekPenilaianPegawai($id_pegawai, $bulan, $tahun);

        if ($cekPenilaian == false) {
            //klo belum pernah dinliai sama sekali
            $this->Kinerja_model->insertInitialPerilaku($id_pegawai, $bulan, $tahun);
        }


        $data['totalPoin']  = $this->Kinerja_model->getPoinPerilaku($id_pegawai, $bulan, $tahun);
        $data['pegawai'] = $this->Pegawai_model->getDetailPegawai($id_pegawai);
        $data['datalist'] = $this->Kinerja_model->getListKategoriPenilaianPerilaku();
        $this->load->view('penilaian_kinerja/penilaian_perilaku', $data);
    }


    function getInputanAktifitasPegawai()
    {
        $id_pegawai = $this->input->post('id_pegawai');
        $tgl        = $this->input->post('tanggal');

        $tanggal = format_db($tgl);
        $data['dataAktifitas'] = $this->Kinerja_model->getDataInputAktifitas($id_pegawai, $tanggal);
        $data['tanggal'] = $tanggal;
        $data['id_pegawai'] = $id_pegawai;

        $cekData = $this->Kinerja_model->cekDataAktifitasPending($id_pegawai, $tanggal);
        if (count($cekData) == 0) {
            //udah ga ada yang pending
            $data['approved_all'] = true;
        } else {
            $data['approved_all'] = false;
        }


        $this->load->view('penilaian_kinerja/view_inputan_aktifitas', $data);
    }

    function approve_aktifitas()
    {
        $id_validator = $this->session->userdata('id_pegawai');
        $id           = $this->input->post('id');
        $status       = $this->input->post('status');
        $tgl_validasi = date('Y-m-d H:i:s');


        $this->db->where('id', $id);
        $this->db->set('status', $status);
        $this->db->set('tgl_validasi', $tgl_validasi);
        $this->db->set('id_validator', $id_validator);
        $this->db->update('ts_kinerja');


        if ($status == 1) {
            echo 'Aktifitas  telah disetujui';
        } else {
            echo 'Aktifitas  telah ditolak';
        }


        $this->db->select('total, tgl, id_pegawai');
        $this->db->where('id', $id);
        $qry = $this->db->get('ts_kinerja');
        $row = $qry->result();

        $total = $row[0]->total;
        $tanggal = $row[0]->tgl;
        $id_pegawai = $row[0]->id_pegawai;

        $periode = date('Y-m', strtotime($tanggal));
        $this->db->where('id_pegawai', $id_pegawai);
        $this->db->where('periode', $periode);
        $this->db->set('disetujui', "disetujui+ $total", FALSE);
        $this->db->update('rekap_input_kinerja');
    }

    function approve_all_aktifitas()
    {
        $id_validator = $this->session->userdata('id_pegawai');
        $data_value = $this->input->post('data_value');
        $xpl = explode("/", $data_value);
        $id_pegawai = $xpl[0];
        $tanggal    = $xpl[1];

        $tgl_validasi = date('Y-m-d H:i:s');

        $periode = date('Y-m', strtotime($tanggal));

        $this->db->where('id_pegawai', $id_pegawai);
        $this->db->where('tgl', $tanggal);
        $this->db->set('status', 1);
        $this->db->set('tgl_validasi', $tgl_validasi);
        $this->db->set('id_validator', $id_validator);
        $this->db->update('ts_kinerja');

        $disetujui = $this->Kinerja_model->getAktifitasByStatus($id_pegawai, $periode, 1);

        $this->db->where('id_pegawai', $id_pegawai);
        $this->db->where('periode', $periode);
        $this->db->set('disetujui', $disetujui);
        $this->db->update('rekap_input_kinerja');

        echo 'Aktifitas tanggal ' . format_semi($tanggal) . ' telah disetujui';
    }

    function ajaxGetPoinPerilaku()
    {
        $data_value = $this->input->post('value');
        $id_pegawai = $this->input->post('id_pegawai');
        $bulan = $this->session->userdata('periode_bulan');
        $tahun = $this->session->userdata('periode_tahun');

        $xpl             = explode("_", $data_value);
        $jawaban         = $xpl[0];
        $id_jawaban   = $xpl[1];
        $jns_item   = $xpl[2];


        if ($jns_item == 2) {
            //jenis penilaian semakin kecil semakin baik
            $poin = getPoinPerilaku($jawaban);
        } else {
            //jenis penilaian semakin besar semakin baik
            $poin = $jawaban;
        }


        $this->db->where('id', $id_jawaban);
        $this->db->set('jawaban', $jawaban);
        $this->db->set('poin', $poin);
        $this->db->update('tbl_penilaian_perilaku');


        $totalPoin          = $this->Kinerja_model->getPoinPerilaku($id_pegawai, $bulan, $tahun);


        echo $totalPoin;
    }

    function set_session_validator()
    {
        $id_pj = $this->input->post('id_pj');

        $this->session->set_userdata('id_pj', $id_pj);
        return true;
    }

    function cancel_acc_aktifitas()
    {
        $id_validator = $this->session->userdata('id_pegawai');
        $id           = $this->input->post('id');
        $status       = $this->input->post('status');
        $tgl_validasi = date('Y-m-d H:i:s');


        $this->db->where('id', $id);
        $this->db->set('status', 0);
        $this->db->update('ts_kinerja');

        $this->db->select('total, tgl, id_pegawai');
        $this->db->where('id', $id);
        $qry = $this->db->get('ts_kinerja');
        $row = $qry->result();

        $total     = $row[0]->total;
        $tanggal   = $row[0]->tgl;
        $id_pegawai = $row[0]->id_pegawai;

        $periode = date('Y-m', strtotime($tanggal));
        $this->db->where('id_pegawai', $id_pegawai);
        $this->db->where('periode', $periode);
        $this->db->set('disetujui', "disetujui- $total", FALSE);
        $this->db->update('rekap_input_kinerja');

        echo 'Aktifitas batal disetujui';
    }

    function tarik_data($nip, $id_pegawai_baru)
    {
        $data_ekin = $this->Kinerja_model->getIDPegawaiekin($nip);
        $id_pegawai_ekin = $data_ekin[0]->id_pegawai;
        $nama = $data_ekin[0]->nama;


        // print_array($data_ekin );
        // exit;

        if (!empty($data_ekin)) {
            redirect('admin/penilaian_kinerja/proses_tarik_data/' . $id_pegawai_ekin . '/' . $id_pegawai_baru);
        } else {
            $pesan =  createMessageInfo('data pegawai tidak ditemukan');
            $this->session->set_flashdata('message', $pesan);
            redirect('admin/penilaian_kinerja/index');
        }
    }


    function updateRekapInput()
    {
        $periode_tahun     = $this->session->userdata('periode_tahun');
        $periode_bulan     = $this->session->userdata('periode_bulan');
        if ($periode_bulan == '') {
            $bulan = date('m');
            $tahun = date('Y');
        } else {
            $bulan = $periode_bulan;
            $tahun = $periode_tahun;
        }

        $day        = date('d');
        $month = $bulan;
        $year = $tahun;

        $nm_bulan = getBulan($bulan);

        $bulanNow = date('m');
        $now = date('Y-m-d');


        $periode = $tahun . '-' . $bulan;
        $periode = date('Y-m', strtotime($periode));
        $id_validator = $this->session->userdata('id_pegawai');
        $id_pj_sess = $this->session->userdata('id_pj');

        if ($id_pj_sess != '') {
            $id_validator = $id_pj_sess;
        }

        $thn_anggaran = date('Y');
        $data_pegawai =  $this->Pegawai_model->getPegawaiPenilaianKinerja($id_validator, $thn_anggaran, 500, 0);

        for ($i = 0; $i < count($data_pegawai); $i++) {
            # code...
            $id_pegawai =    $data_pegawai[$i]->id_pegawai;
            $nama =    $data_pegawai[$i]->nama;
            $nip                = $data_pegawai[$i]->nip;
            $newName             = upperCase($nama);



            $jmlhInput = $this->Kinerja_model->getJumlahInputPerBulan($id_pegawai, $periode);
            $disetujui = $this->Kinerja_model->getAktifitasByStatus($id_pegawai, $periode, 1);
            $ditolak = $this->Kinerja_model->getAktifitasByStatus($id_pegawai, $periode, 2);
            $ditolak = 0;


            if ($jmlhInput > 0) {
                $totalAcc = $disetujui + $ditolak;
                $persenAcc =  ceil(($totalAcc / $jmlhInput) * 100);
            } else {
                $persenAcc =  0;
                $jmlhInput  = 0;
                $disetujui = 0;
                $ditolak = 0;
            }



            $this->db->where('id_pegawai', $id_pegawai);
            $this->db->where('periode', $periode);
            $this->db->delete('rekap_input_kinerja');

            $new_data = array(
                'id_pegawai' => $id_pegawai,
                'periode' => $periode,
                'total_input' => $jmlhInput,
                'disetujui' => $disetujui,
                'ditolak' => $ditolak
            );


            $cekRekapInput = $this->Kinerja_model->rekap_input_kinerja($id_pegawai, $periode);
            if ($cekRekapInput == 0) {
                $this->db->insert('rekap_input_kinerja', $new_data);
            } else {
                $id = $cekRekapInput;
                $this->db->where('id', $id);
                $this->db->update('rekap_input_kinerja', $new_data);
            }

            // echo $i . '. ' . $nip . ' - ' . $nama . ' -> ' . $jmlhInput . ' - ' . $disetujui . '<br>';
        }

        $pesan =  createMessageInfo('Data kinerja berhasil diupdate');
        $this->session->set_flashdata('message', $pesan);
        redirect('admin/penilaian_kinerja/index');
    }



    // function proses_tarik_data($id_pegawai, $id_ekin_v2)
    // {


    //     $getInputan = $this->Kinerja_model->getInputan($id_pegawai);

    //     $cekData = $this->Kinerja_model->delete_inputan($id_ekin_v2);

    //     $dataPerilaku = $this->Kinerja_model->getDataPerilkuEkin1($id_pegawai);

    //     foreach ($getInputan as $akt) {

    //         $tgl = $akt->tgl;
    //         $jns_kegiatan = $akt->jns_kegiatan;
    //         $id_kegiatan = $akt->id_kegiatan;
    //         $jam_mulai = $akt->jam_mulai;
    //         $jam_selesai = $akt->jam_selesai;
    //         $volume = $akt->volume;
    //         $ket  = $akt->ket;
    //         $status  = $akt->status;
    //         $nama_kegiatan  = $akt->nama_kegiatan;
    //         $waktu  = $akt->waktu;

    //         $total = $waktu * $volume;


    //         // if(!empty($cekData)){
    //         //     $id =$cekData[0]->id;
    //         //      $this->db->where('id', $id);
    //         //      $this->db->delete('ts_kinerja');
    //         // }


    //         $new_data = array(
    //             'id_pegawai' => $id_ekin_v2,
    //             'tgl' => $tgl,
    //             'jns_kegiatan' => $jns_kegiatan,
    //             'id_indikator' => 0,
    //             'nama_kegiatan' => $nama_kegiatan,
    //             'jam_mulai' => $jam_mulai,
    //             'jam_selesai' => $jam_selesai,
    //             'volume' => $volume,
    //             'waktu_efektif' => $waktu,
    //             'total' =>  $total,
    //             'status' =>  $status,
    //             'ket' =>  $ket
    //         );

    //         $this->db->insert('ts_kinerja', $new_data);
    //     }


    //     $sql = "DELETE FROM tbl_penilaian_perilaku WHERE id_pegawai = $id_ekin_v2 AND periode_bulan = '01' AND periode_tahun = '2024'";
    //     $this->db->query($sql);


    //     for ($i = 0; $i < count($dataPerilaku); $i++) {


    //         $tgl_input = $dataPerilaku[$i]->tgl_input;
    //         $poin = $dataPerilaku[$i]->poin;
    //         $jawaban = $dataPerilaku[$i]->jawaban;
    //         $jns_item = $dataPerilaku[$i]->jns_item;
    //         $id_item = $dataPerilaku[$i]->id_pertanyaan;


    //         $this->Kinerja_model->insertPenilaianPerilaku($id_ekin_v2, 1, '2024', $tgl_input, $id_item, $jns_item, $jawaban, $poin);
    //     }

    //     $pesan =  createMessageInfo('data kinerja berhasil ditransfer');
    //     $this->session->set_flashdata('message', $pesan);
    //     redirect('admin/penilaian_kinerja/index');


    //     #print_array($new_data);
    // }
}
