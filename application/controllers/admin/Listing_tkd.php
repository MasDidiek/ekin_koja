<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Listing_tkd  extends CI_Controller
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

        $this->load->view('admin/listing_tkd/main', $data);
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

        redirect('admin/listing_tkd/index');
    }


    function detail_capaian($id_pegawai)
    {
        $periode_bulan = $this->session->userdata('periode_bulan');
        $periode_tahun = $this->session->userdata('periode_tahun');
        $periode = $periode_tahun . '-' . $periode_bulan;
        $periode = date('Y-m', strtotime($periode));

        $data['detail_pegawai']   = $this->Pegawai_model->getDataEditPegawai($id_pegawai);
        $data['dataRekap'] = $this->Presensi_model->getRekapAbsensiPegawai($id_pegawai, $periode);
        $data['master_cuti'] = $this->Master_model->getlistCuti();
        $this->load->view('admin/capaian_kinerja/detail_capaian', $data);
    }

    function import_pajak()
    {
        $data = array(); // Buat variabel $data sebagai array

        $date_now  = date('Ymd_Hi');
        $file_name = $date_now;
        $path = 'pajak';

        $upload = $this->Master_model->upload_file($file_name, $path);

        if ($upload['result'] == "success") { // Jika proses upload sukses
            // Load plugin PHPExcel nya
            include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

            $excelreader = new PHPExcel_Reader_Excel2007();
            $loadexcel = $excelreader->load('uploads/' . $path . '/' . $file_name . '.xlsx'); // Load file yang tadi diupload ke folder excel
            $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

            // Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
            $data = array();
            $numrow = 1;
            $num = 0;
            foreach ($sheet as $row) {


                if ($numrow > 2) {
                    // Kita push (add) array data ke variabel data


                    #print_array($row);
                    $nama      = $row['A'];
                    $bpjs_kes      = $row['B'];
                    $bpjs_tk      = $row['C'];
                    $pajak      = $row['D'];

                    $id_pegawai = $this->Pegawai_model->getIDpegawaiByName($nama);


                    $updatePajak = array(
                        'id_pegawai' => $id_pegawai,
                        'pph21' => $pajak,
                        'bpjs_kes' => $bpjs_kes,
                        'bpjs_tk' => $bpjs_tk,
                    );


                    # print_array($updatePajak);

                    $this->db->where('id_pegawai', $id_pegawai);
                    $this->db->update('gaji_pegawai', $updatePajak);


                    $numrow++; // Tambah 1 setiap kali looping



                }

                $numrow++; // Tambah 1 setiap kali looping
            }

            echo 'berhasil';
        } else { // Jika proses upload gagal

            echo  $upload['error'];
            #$this->session->set_userdata('error_msg', $upload['error']); // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
            #redirect('admin/swab/error_import');
        }

        exit;
    }
}
