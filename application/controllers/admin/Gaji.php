<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Gaji  extends CI_Controller
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

        //     $thn_aggrn = date('Y');
        $thn_aggrn =  2024;

        $data['pegawai'] = $this->Pegawai_model->getListPegawai('non_pns', $thn_aggrn);

        //print_array($data['pegawai']);

        $this->load->view('admin/gaji/main', $data);
    }

    function all_data()
    {
        $thn_aggrn = date('Y');

        $data['pegawai'] = $this->Pegawai_model->getListPegawai('non_pns', $thn_aggrn);

        $this->load->view('admin/gaji/all_data', $data);
    }
    function filter_tmt()
    {

        $bulan_tmt = $this->input->post('bulan_tmt');
        $ganjil_genap = $this->input->post('ganjil_genap');

        if ($ganjil_genap == 1) {
            $gg = 1;
        } else {
            $gg = 0;
        }

        $this->session->set_userdata('bulan_tmt', $bulan_tmt);
        $this->session->set_userdata('ganjil_genap', $gg);
        redirect('admin/gaji/index');
    }

    function update_data_gaji()
    {
        $thn_aggrn = date('Y');
        $pegawai = $this->Pegawai_model->getListPegawai('non_pns', $thn_aggrn);

        $periode_bulan = $this->session->userdata('bulan_tmt');
        $periode_tahun = 2024;

        // $periode_bulan = $this->session->userdata('periode_bulan'); 
        // $periode_tahun = $this->session->userdata('periode_tahun'); 

        if ($periode_bulan == '') {
            $bulan = date('m') - 1;
            if ($bulan == 0) {
                $periode_bulan = 1;
            } else {
                $periode_bulan = $bulan;
            }

            $periode_tahun =  date('Y');
        }
        $periode = $periode_tahun . '-' . $periode_bulan;
        $periode = date('Y-m', strtotime($periode));

        $date1 = $periode . '-01';
        // echo $date1;
        // exit;

        $no = 1;
        foreach ($pegawai as $peg) {

            $id_pegawai = $peg->id_pegawai;
            $nip = $peg->nip;
            $id_jabatan = $peg->id_jabatan;
            $tmt = $peg->tgl_masuk;
            $id_pendidikan = $peg->id_pendidikan;
            $pengkalian = $peg->pengkalian;
            $gaji_pokok = $peg->gaji_pokok;



            $masa_kerja = hitungMasaKerja($date1, $tmt);
            $masa_tahun = $masa_kerja['years'];
            $masa_bulan = $masa_kerja['months'];


            $bulan_tmt = date('m', strtotime($tmt));
            $tahun_tmt = date('Y', strtotime($tmt));

            $id_masa_kerja = $this->Master_model->getIdMasaKerja($masa_tahun);
            $gaji_pokok_mst = $this->Master_model->getGajiPokok($id_masa_kerja, $id_pendidikan);

            if ($gaji_pokok != $gaji_pokok_mst) {
                $tkd_pokok = $gaji_pokok * $pengkalian;

                $this->db->where('id_pegawai', $id_pegawai);
                $this->db->set('gaji_pokok', $gaji_pokok_mst);
                $this->db->update('gaji_pegawai');
            }
        }

        $this->session->set_flashdata('message', ' Data gaji berhasil diupdate');
        redirect('admin/gaji/index');
    }



    function data_gaji()
    {
        $thn_anggrn  = 2024;

        $data['pegawai'] = $this->Pegawai_model->getListPegawai('non_pns', $thn_anggrn);
        $this->load->view('admin/gaji/update_gaji', $data);
    }

    function update_gaji_all()
    {
        /// print_array($this->input->post());

        $id_pegawai = $this->input->post('id_pegawai');
        $gaji_pokok = $this->input->post('gaji_pokok');
        $pengkalian = $this->input->post('pengkalian');
        $bpjs = $this->input->post('bpjs');
        $bpjs_tk = $this->input->post('bpjs_tk');
        $pph21 = $this->input->post('pph21');


        // $numRow = count($id_pegawai);

        // echo $numRow;
        for ($i = 0; $i < count($id_pegawai); $i++) {


            $data = array(
                'gaji_pokok' => $gaji_pokok[$i],
                'pengkalian' =>  $pengkalian[$i],

            );


            /// print_array($data);
            $this->db->where('id_pegawai', $id_pegawai[$i]);
            $this->db->update('gaji_pegawai', $data);
        }

        /// exit;
        $pesan =  createMessageInfo('Data gaji berhasil diupdate');
        $this->session->set_flashdata('message', $pesan);
        redirect('admin/gaji/data_gaji');
    }


    function recount()
    {
        $tanggal    = $this->input->post('tanggal');
        $thn_aggrn  = date('Y');
        $this->session->set_userdata('tgl_recount', $tanggal);
        $data['pegawai'] = $this->Pegawai_model->getListPegawai('non_pns', $thn_aggrn);
        $this->load->view('admin/gaji/recount_gaji', $data);
    }


    function fixedDataDokter()
    {
        $pegawai = $this->Pegawai_model->getListPegawai('non_pns', '2024');

        for ($i = 0; $i < count($pegawai); $i++) {
            $nama = $pegawai[$i]->nama;
            $id_pegawai = $pegawai[$i]->id_pegawai;


            // Test if string contains the word A.Md.Kep
            if (strpos($nama, 'A.Md.') !== false) {
                echo  $nama . "<br>";


                // $this->db->where('id_pegawai', $id_pegawai);
                // $this->db->set('id_pendidikan', 6);
                // $this->db->update('mst_pegawai');

                $this->db->where('id_pegawai', $id_pegawai);
                $this->db->set('pengkalian', 0.8);
                $this->db->update('gaji_pegawai');
            }
        }

        //print_array($pegawai);
    }

    function recount_process()
    {
        $tgl_recount = $this->session->userdata('tgl_recount');
        $date1 = format_db($tgl_recount);

        $thn_aggrn  = date('Y');
        $pegawai    = $this->Pegawai_model->getListPegawai('non_pns', $thn_aggrn);


        $no = 1;
        foreach ($pegawai as $peg) {
            $id_pegawai = $peg->id_pegawai;
            $id_jabatan = $peg->id_jabatan;
            $tmt = $peg->tgl_masuk;
            $id_pendidikan = $peg->id_pendidikan;
            $pengkalian = $peg->pengkalian;
            $gaji_pokok = $peg->gaji_pokok;

            $masa_kerja = hitungMasaKerja($date1, $tmt);
            #print_r($masa_kerja);
            $masa_tahun = $masa_kerja['years'];
            $masa_bulan = $masa_kerja['months'];
            $masa_hari  = $masa_kerja['days'];


            $id_masa_kerja  = $this->Master_model->getIdMasaKerja($masa_tahun);
            $gaji_pokok_mst = $this->Master_model->getGajiPokok($id_masa_kerja, $id_pendidikan);


            #echo $tmt.'--'.$id_masa_kerja.'<br>';
            $this->db->where('id_pegawai', $id_pegawai);
            $this->db->set('gaji_pokok', $gaji_pokok_mst);
            $this->db->set('last_date_recount', $date1);
            $this->db->update('gaji_pegawai');


            $updatePegawai  = array(
                'kategori_masa_kerja' => $id_masa_kerja,
                'masa_kerja' => $masa_tahun . '-' . $masa_bulan . '-' . $masa_hari
            );

            $this->db->where('id_pegawai', $id_pegawai);
            $this->db->update('mst_pegawai', $updatePegawai);

            $nama = $peg->nama;


            // echo '<tr>
            //             <td>'.$nama.'</td>
            //             <td>'.$tmt.'</td>
            //             <td>'.$masa_tahun.'-'.$masa_bulan.'-'.$masa_hari.'</td>
            //             <td>'.$gaji_pokok_mst.'</td>
            //       </tr>';


            $no += 1;
        }




        $pesan =  createMessageInfo('Data gaji berhasil direcount');
        $this->session->set_flashdata('message', $pesan);
        redirect('admin/gaji/all_data');
    }

    function data_bpjs_pajak()
    {
        $thn_anggrn  = 2024;

        $data['pegawai'] = $this->Pegawai_model->getListPegawai('non_pns', $thn_anggrn);
        $this->load->view('admin/gaji/update_bpjs', $data);
    }


    function update_bpjs_pajak()
    {
        //print_array($this->input->post());

        $id_pegawai = $this->input->post('id_pegawai');
        $bpjs_kes = $this->input->post('bpjs_kes');
        $bpjs_tk = $this->input->post('bpjs_tk');
        $pph21 = $this->input->post('pph21');


        // $numRow = count($id_pegawai);

        // echo $numRow;
        for ($i = 0; $i < count($id_pegawai); $i++) {


            $data = array(
                'bpjs_kes' =>  $bpjs_kes[$i],
                'bpjs_tk' =>  $bpjs_tk[$i],
                'pph21' =>  $pph21[$i],

            );

            $this->db->where('id_pegawai', $id_pegawai[$i]);
            $this->db->update('gaji_pegawai', $data);


            //print_array($data);
        }


        //exit;
        $pesan =  createMessageInfo('Data BPJS dan Pajak berhasil diupdate');
        $this->session->set_flashdata('message', $pesan);
        redirect('admin/gaji/update_bpjs_pajak');
    }


    function proses_update_pajak_bpjs()
    {
        // print_array($this->input->post());
        $id_pegawai = $this->input->post('id_pegawai');
        $bpjs = $this->input->post('bpjs');
        $bpjs_tk = $this->input->post('bpjs_tk');
        $pajak = $this->input->post('pajak');

        for ($i = 0; $i < count($id_pegawai); $i++) {

            $newUpdateData = array(
                'bpjs_kes' => $bpjs[$i],
                'bpjs_tk' => $bpjs_tk[$i],
                'pph21' => $pajak[$i]
            );


            $this->db->where('id_pegawai', $id_pegawai[$i]);
            $this->db->update('gaji_pegawai', $newUpdateData);
            // print_array($newUpdateData);
        }


        $this->session->set_flashdata('message', 'Data berhasil diupdate');
        redirect('admin/gaji/data_bpjs_pajak');
    }

    function import_bpjs_tk()
    {
        $data = array(); // Buat variabel $data sebagai array

        $date_now  = date('Ymd_Hi');
        $file_name = $date_now;
        $path = 'pajak';

        $ta = 2024;
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


            echo '<table border="1" width="50%">
                    <tr>
                     
                      <th rowspan="2">Nama</th>
                      <th rowspan="2">Status Update</th>
                      <th rowspan="2">Keterangan</th>
                      <th colspan="2">Jumlah Potongan BPJS TK</th>
                    </tr>
                    <tr>
                      <th>Lama</th>
                      <th>Baru</th>
                    </tr>
            ';
            foreach ($sheet as $row) {


                if ($numrow > 1) {
                    // Kita push (add) array data ke variabel data


                    #print_array($row);
                    $no_ktp      = $row['A'];
                    $jumlah      = $row['C'];
                    $nama      = $row['B'];

                    $nip = $this->Pegawai_model->cekNoKTP($no_ktp);

                    if ($nip == 0) {
                        echo '<tr>
                                            <td>' . $nama . ' </td>
                                            <td>Gagal</td>
                                            
                                            <td></td>
                                            <td></td>
                                            <td>NIP tidak ditemukan</td>
                                      </tr>';
                    } else {
                        $bpjs_tk =  str_replace(",", "", $jumlah);

                        $id_pegawai = $this->Pegawai_model->getIDpegawaiByNIP($nip, $ta);

                        $dataGaji   = $this->Pegawai_model->getDataGajiPegawai($id_pegawai);

                        if ($bpjs_tk == $dataGaji[0]->bpjs_tk) {
                            $status_jumlah = 'Jumlah sama';
                        } else {
                            $status_jumlah = 'Jumlah Tidak  sama';
                        }
                        echo '<tr>
                                            <td>' . $nama . ' </td>
                                            <td>Berhasil</td>      
                                            <td>' . rupiah($dataGaji[0]->bpjs_tk) . '</td>
                                            <td>' . rupiah($bpjs_tk) . '</td>
                                            <td>' . $status_jumlah . '</td>
                                    </tr>';


                        $this->db->where('id_pegawai', $id_pegawai);
                        $this->db->set('bpjs_tk', $bpjs_tk);
                        $this->db->update('gaji_pegawai');
                        //echo $bpjs_tk;
                    }



                    $numrow++; // Tambah 1 setiap kali looping

                }

                $numrow++; // Tambah 1 setiap kali looping
            }

            echo '</table>';


            echo '<h3>Data BPJS TK berhasil diupdate</h3>';
        } else { // Jika proses upload gagal

            echo  $upload['error'];
            #$this->session->set_userdata('error_msg', $upload['error']); // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
            #redirect('admin/swab/error_import');
        }

        exit;
    }


    function import_pajak()
    {
        $data = array(); // Buat variabel $data sebagai array

        $date_now  = date('Ymd_Hi');
        $file_name = $date_now;
        $path = 'pajak';

        $ta = 2024;
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


            echo '<table border="1" width="50%">
                    <tr>
                     
                      <th rowspan="2">Nama</th>
                      <th rowspan="2">Status Update</th>
                      <th rowspan="2">Keterangan</th>
                      <th colspan="2">Jumlah Potongan BPJS TK</th>
                    </tr>
                    <tr>
                      <th>Lama</th>
                      <th>Baru</th>
                    </tr>';

            foreach ($sheet as $row) {

                if ($numrow > 1) {
                    // Kita push (add) array data ke variabel data


                    #print_array($row);

                    $nama      = $row['A'];
                    $jumlah      = $row['B'];

                    $id_pegawai  = $this->Pegawai_model->getIDpegawaiByName($nama);
                    if ($id_pegawai == 0) {
                        echo '<tr>
                                            <td>' . $nama . ' </td>
                                            <td>Gagal</td> 
                                            <td></td>
                                            <td></td>
                                            <td>NIP tidak ditemukan</td>
                                      </tr>';
                    } else {
                        $pph21 =  str_replace(",", "", $jumlah);

                        $dataGaji   = $this->Pegawai_model->getDataGajiPegawai($id_pegawai);
                        $pph21_db   = trim($dataGaji[0]->pph21);

                        if ($pph21 == $pph21_db) {
                            $status_jumlah2 = 'Jumlah sama';
                        } else {
                            $status_jumlah2 = 'Jumlah Tidak  sama';
                        }
                        echo '<tr>
                                            <td>' . $nama . ' </td>
                                            <td>Berhasil</td>      
                                            <td>' . $pph21_db . '</td>
                                            <td>' . $pph21 . '</td>
                                            <td>' . $status_jumlah2 . '</td>
                                    </tr>';


                        $this->db->where('id_pegawai', $id_pegawai);
                        $this->db->set('pph21', $pph21);
                        $this->db->update('gaji_pegawai');
                        //echo $bpjs_tk;
                    }



                    $numrow++; // Tambah 1 setiap kali looping

                }

                $numrow++; // Tambah 1 setiap kali looping
            }

            echo '</table>';


            echo '<h3>Data BPJS TK berhasil diupdate</h3>';
        } else { // Jika proses upload gagal

            echo  $upload['error'];
            #$this->session->set_userdata('error_msg', $upload['error']); // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
            #redirect('admin/swab/error_import');
        }

        exit;
    }
}
