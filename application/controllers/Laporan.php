<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Laporan extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->load->model('Laporan_model');
        $this->Auth_model->cekAuthLogin();
    }


    function index()
    {
        $id_pegawai  =  $this->session->userdata('id_pegawai');
        $data['pegawai'] = $this->Laporan_model->getListPegawai();

        $this->load->view('admin/laporan/index', $data);
        // $this->load->view('admin/laporan/dashboard_laporan', $data);
    }

    function create_session_absensi($id_pegawai, $pin, $periode)
    {

        $xplod = explode('-', $periode);
        $tahun = $xplod[0];
        $bulan = $xplod[1];

        $this->session->set_userdata('periode_tahun', $tahun);
        $this->session->set_userdata('periode_bulan', $bulan);

        redirect('admin/presensi/lihat_absensi_pegawai/' . $id_pegawai . '/' . $pin);
    }

    function filter_data()
    {

        $bulan_start = $this->input->post('bulan_start');
        $bulan_end = $this->input->post('bulan_end');
        $tahun = $this->input->post('tahun');
        $jenis = $this->input->post('jenis');

        $new_session = array(
            'bulan_start' => $bulan_start,
            'bulan_end' => $bulan_end,
            'tahun' => $tahun,
            'jns_absensi' => $jenis
        );

        #print_array($new_session);
        $this->session->set_userdata($new_session);
    }
}
