<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Gaji_pjlp  extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Laporan_model');
        $this->load->helper('text');
        $this->Auth_model->cekAuthLogin();
    }


    public function index()
    {


      	$data['pegawai'] = $this->Pegawai_model->getPegawaiPJLP();

        $this->load->view('admin/gaji/gaji_pjlp', $data);
    }

    public function edit_data_gaji()
    {

      $data['pegawai'] = $this->Pegawai_model->getPegawaiPJLP();

      $this->load->view('admin/gaji/edit_data_gaji', $data);
    }

    public function update_data_gaji()
    {

        //print_array($this->input->post());

        $id_gaji  = $this->input->post('id');
        $pph21    = $this->input->post('pph21');
        $bpjs     = $this->input->post('bpjs');
        $bpjs_tk  = $this->input->post('bpjs_tk');

        $bruto    = $this->input->post('bruto');

        for ($i=0; $i < count($id_gaji) ; $i++) {
            $id = $id_gaji[$i];
            if($id > 0){
                $pajak = $pph21[$i];
                $B_kes = $bpjs[$i];
                $B_tk  = $bpjs_tk[$i];


                $totalPengurang = $pajak+$B_kes+$B_tk;
                $new_thp = $bruto[$i]-$totalPengurang;

                $updateData = array(
                  'pph21' => $pajak,
                  'bpjs' => $B_kes,
                  'bpjs_tk' => $B_tk,
                  'thp' => $new_thp,
                );

                $this->db->where('id', $id);
                $this->db->update('ts_rekap_gaji_pjlp', $updateData);
            }//close if
        } //close for

          redirect('admin/gaji_pjlp/index');

    }


    public function update_data_gaji_pegawai($id_pjlp='')
    {
      $periode_bulan = $this->session->userdata('periode_bulan');
      $periode_tahun = $this->session->userdata('periode_tahun');
      $periode       = $periode_tahun . '-' . $periode_bulan;
      $periode       = date('Y-m', strtotime($periode));

      $cekData = $this->Laporan_model->cekDataRekapGajiPjlp($id_pjlp, $periode);

      $detail_pegawai = $this->Pegawai_model->getDataEditPegawaiPJLP($id_pjlp);
      $gaji_pokok  = $detail_pegawai[0]->gaji_pokok;
      $no_rekening = $detail_pegawai[0]->no_rekening;
      $npwp        = $detail_pegawai[0]->npwp;

      if($gaji_pokok==''){
        $gaji_pokok = 0;
      }
      if($npwp==''){
        $npwp = 0;
      }

      if($no_rekening==''){
        $no_rekening = 0;
      }



      $dataAbsensi = $this->Presensi_model->getDataRekapAbsensiPJLP($id_pjlp, $periode);
      if (!empty($dataAbsensi)) {
          $telat = $dataAbsensi[0]->telat;
          $pulang_awal = $dataAbsensi[0]->pulang_awal;
          $izin = $dataAbsensi[0]->izin;
          $sakit = $dataAbsensi[0]->sakit;
          $sakit_dgn_sk = $dataAbsensi[0]->sakit_dgn_sk;
          $alpha = $dataAbsensi[0]->alpha;
          $cuti = $dataAbsensi[0]->cuti;

          $menitIzin = $izin*300;
          $menitSakit = $sakit*300;
          $menitIzin = $izin*300;
          $menitDgnSurat = $sakit_dgn_sk*150;
          $menitAlpha= $alpha*450;

          $totalPengurang = $telat+$pulang_awal+$menitIzin+$menitSakit+$menitDgnSurat+$menitAlpha;

      }else{
        //belum ada rekap
        $telat = 0;
        $pulang_awal =  0;
        $izin = 0;
        $sakit =  0;
        $sakit_dgn_sk =  0;
        $alpha = 0;
        $cuti =  0;

        $totalPengurang = 0;
      }

      $waktuEfektif = 6000;
      $waktuCapaian = $waktuEfektif-$totalPengurang;
      $capaian      = ($waktuCapaian/$waktuEfektif)*100;
      $totalCapaian = round($capaian, 2);
      $bruto        = ($gaji_pokok*$totalCapaian)/100;
      $Bruto        = ceil($bruto);
      $pph21        = 0;
      $bpjs_kes     = 0;
      $bpjs_tk      = 0;

      $thp = $Bruto-$pph21-$bpjs_kes-$bpjs_tk;

      if(empty($cekData)){
          $dataInsert = array(
            'periode' => $periode,
            'id_pjlp' => $id_pjlp,
            'npwp' => $npwp,
            'gaji_pokok' => $gaji_pokok,
            'capaian' => $totalCapaian,
            'bruto' => $Bruto,
            'pph21' => $pph21,
            'bpjs' => $bpjs_kes,
            'bpjs_tk' => $bpjs_tk,
            'thp' => $thp,
            'no_rekening' => $no_rekening,
          );

//print_array($dataInsert);
          $this->db->insert('ts_rekap_gaji_pjlp', $dataInsert);
      }else{

      }

        redirect('admin/gaji_pjlp/index');
    }


public function detail_gaji_pjlp($id_rekap_gaji, $id_pjlp)
{
   $data['dataRekap'] = $this->Laporan_model->detailRekapGajiPjlp($id_rekap_gaji);
   $data['pegawai'] = $this->Pegawai_model->getDataEditPegawaiPJLP($id_pjlp);
   $this->load->view('admin/gaji/detail_gaji_pjlp', $data);
}



}
