<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Public_info extends CI_Controller
{
	public function __construct()
	{

		parent::__construct();
		$this->load->model('Laporan_model');
		$this->load->helper('text');
	}


    function view_daftar_ttd($case='tkd') {
        $periode_bulan = $this->session->userdata('periode_bulan');
        $periode_tahun = $this->session->userdata('periode_tahun');


        $periode = $periode_tahun.'-'.$periode_bulan;
        $periode = date('Y-m', strtotime($periode));
       // $periode = '2025-02';
        if($case=='tkd'){
            $table = 'ts_rekap_tkd';
        }else{
             $table = 'ts_listing_thr';
        }
        $data['data_tkd'] = $this->Laporan_model->getDataListing($periode, $table);

        $this->load->view('view_daftar_ttd', $data);
    }

}