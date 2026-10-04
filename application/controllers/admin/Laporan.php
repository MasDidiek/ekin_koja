<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Laporan  extends CI_Controller
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

        $periode_bulan = $this->session->userdata('periode_bulan');
        $periode_tahun = $this->session->userdata('periode_tahun');
        $periode = $periode_tahun . '-' . $periode_bulan;
        $periode = date('Y-m', strtotime($periode));

        $data['listing_tkd'] = $this->Laporan_model->getListingTKD($periode);

        $this->load->view('admin/laporan/main', $data);
    }


    public function str_sip($jns_dokumen = 'SIP')
    {


        $data['data_sip_str'] = $this->Laporan_model->getDataSTRSIP($jns_dokumen);

        $this->load->view('admin/laporan/str_sip', $data);
    }


    function listing_tkd()
    {
        $periode_bulan = $this->session->userdata('periode_bulan');
        $periode_tahun = $this->session->userdata('periode_tahun');
        $periode = $periode_tahun . '-' . $periode_bulan;
        $periode = date('Y-m', strtotime($periode));

        $data['listing_tkd'] = $this->Laporan_model->getListingTKD($periode);

        $this->load->view('admin/laporan/listing_tkd', $data);
    }

    public function create_listing_tkd()
    {

        $periode_bulan = $this->session->userdata('periode_bulan');
        $periode_tahun = $this->session->userdata('periode_tahun');
        $periode = $periode_tahun . '-' . $periode_bulan;
        $periode = date('Y-m', strtotime($periode));

        $data['listing_tkd'] = $this->Laporan_model->getListingTKD($periode);

        $this->load->view('admin/listing_tkd/create_listing_tkd', $data);
    }


    function update_rekap_tkd($periode)
    {
        $explod = explode('-', $periode);
        $tahun = $explod[0];
        $bulan = $explod[1];
        $thn_anggrn    = 2024;
        $jumlahHariKerja = $this->Master_model->getMenitEfektifBulan($bulan, $tahun);
        $waktu_efektif = $jumlahHariKerja * 300;

        $this->db->where('periode', $periode);
        $this->db->delete('ts_rekap_tkd');
        $pegawai = $this->Pegawai_model->getPegawaiforListingTKD($thn_anggrn);



        $dateNow = $periode . '-30';
        # print_array($pegawai);
        # exit;

        $no = 1;
        foreach ($pegawai as $peg) {

            $id_pegawai = $peg->id_pegawai;
            $nip = $peg->nip;
            $nama = $peg->nama;
            $jabatan = $peg->jabatan;
            $tmt = $peg->tgl_masuk;

            $npwp = $peg->npwp;
            $no_rekening = $peg->no_rekening;
            $gaji_pokok = $peg->gaji_pokok;
            $pengkalian = $peg->pengkalian;
            $pph21 = $peg->pph21;
            $bpjs_kes = $peg->bpjs_kes;
            $bpjs_tk = $peg->bpjs_tk;
            $bpjs_kes = $peg->bpjs_kes;
            $status_kerja = $peg->status_kerja;



            $hitungMasaKerja = hitungMasaKerja($dateNow, $tmt);
            $masa_tahun = $hitungMasaKerja['years'];
            $masa_bulan = $hitungMasaKerja['months'];

            $masa_kerja = $masa_tahun . ' tahun &nbsp; ' . $masa_bulan . ' bulan';
            //

            $totalCapaian = $this->Laporan_model->getCapaianKinerjaPegawai($nip, $periode);

            $tkd_pokok = ceil($gaji_pokok * $pengkalian);
            $bruto = round(($tkd_pokok * $totalCapaian) / 100);
            $pengurang = $pph21 + $bpjs_kes + $bpjs_tk;

            $thp = $bruto - $pengurang;

            if ($status_kerja > 0 && $nip != '') {
                $newRekap[] = array(
                    'periode' => $periode,
                    'nip' => $nip,
                    'nama' => strtoupper($nama),
                    'jabatan' => $jabatan,
                    'npwp' => $npwp,
                    'tkd_pokok' => $tkd_pokok,
                    'capaian' => $totalCapaian,
                    'bruto' => $bruto,
                    'pph21' => $pph21,
                    'bpjs' => $bpjs_kes,
                    'bpjs_tk' => $bpjs_tk,
                    'thp' => $thp,
                    'no_rekening' => $peg->no_rekening,
                    'masa_kerja' => $masa_kerja,
                    'urutan' => $no,
                    'update_on' => date('Y-m-d H:i:s')
                );
            }



            $no += 1;
        }

        // print_array($newRekap);

        // exit;


        $this->db->insert_batch('ts_rekap_tkd', $newRekap);
        $this->session->set_flashdata('message', ' Data berhasil direkap');

        redirect('admin/laporan/listing_tkd');
        //print_array($pegawai);
    }


    function fixes_id()
    {
        $qry =  $this->db->get('ts_rekap_capaian');
        $row = $qry->result();

        $id = 0;
        for ($i = 0; $i < count($row); $i++) {
            $nip = $row[$i]->nip;
            $periode = $row[$i]->periode;

            $id = $id + 1;

            $this->db->where('nip', $nip);
            $this->db->where('periode', $periode);
            $this->db->set('id', $id);
            $this->db->update('ts_rekap_capaian');
        }


        echo 'selesai';
    }


    function capaian_kinerja()
    {
        $periode_bulan = $this->session->userdata('periode_bulan');
        $periode_tahun = $this->session->userdata('periode_tahun');
        $periode = $periode_tahun . '-' . $periode_bulan;
        $periode = date('Y-m', strtotime($periode));

        $this->db->order_by('total_capaian', 'ASC');
        $this->db->where('periode', $periode);
        $qry =  $this->db->get('ts_rekap_capaian');
        $row = $qry->result();
        $data['capaian_kinerja'] = $row;

        $this->load->view('admin/laporan/capaian_kinerja', $data);
    }
}
