<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Absensi extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();

        $this->load->model('Old_model');

        $this->Auth_model->cekAuthLogin();
    }


    function index()
    {
        $id_pegawai  =  $this->session->userdata('id_pegawai');
        $data['detail_pegawai'] = $this->Pegawai_model->getDataEditPegawai($id_pegawai);
        $this->load->view('my_absensi/index', $data);
    }


    function lihat_absensi($bulan, $tahun)
    {
        $id_pegawai  =  $this->session->userdata('id_pegawai');
        $data['detail_pegawai'] = $this->Pegawai_model->getDataEditPegawai($id_pegawai);
        $this->load->view('my_absensi/lihat_absensi', $data);
    }



    function update_absensi($bulan, $tahun, $pin, $id_puskesmas)
    {
        $id_pegawai = $this->session->userdata('id_pegawai');
        $this->db->where('id_puskesmas', $id_puskesmas);
        $qry = $this->db->get('tbl_mesin_absensi');
        $row = $qry->result();

        $ip_address = $row[0]->ip_address;

        $dataPresensi = $this->Sinkron_model->getDataAbsenMesin($ip_address, $pin);

        #echo $ip_address;

        $periode = $tahun . '-' . $bulan;
        $periode = date('Y-m', strtotime($periode));


        for ($i = 0; $i < count($dataPresensi); $i++) {

            $DateTime = $dataPresensi[$i]['DateTime'];
            $pinMesin      = $dataPresensi[$i]['pin'];
            $Status   = $dataPresensi[$i]['Status'];

            $periode_db = date('Y-m', strtotime($DateTime));

            $thn = date('Y', strtotime($DateTime));

            $cekAbsen  = $this->Presensi_model->cekExistAbsensi($pinMesin, $DateTime);

            if ($cekAbsen == 0 && ($thn == $tahun)) {
                $this->Presensi_model->insertAbsensi($DateTime, $pinMesin, $Status);
            }
        }

        $dataAbsensi  = $this->Presensi_model->getAbsenBulanan($pin, $periode);
        //  print_array($dataAbsensi);

        //  exit;

        for ($a = 0; $a < count($dataAbsensi); $a++) {


            $datetime       = $dataAbsensi[$a]->tanggal;
            $status_absen  = $dataAbsensi[$a]->status;
            $id_absen  = $dataAbsensi[$a]->id;

            $explode = explode(" ", $datetime);
            $tanggal = $explode[0];
            $jam     = $explode[1];


            if ($status_absen == 0) {

                $newArray = array(
                    'tanggal' => $tanggal,
                    'pin' => $pin,
                    'masuk' => $jam,
                    'telat' => 0,
                    'keterangan' => ''
                );
            } else {
                $newArray = array(
                    'tanggal' => $tanggal,
                    'pin' => $pin,
                    'pulang' => $jam,
                    'p_awal' => 0,
                    'keterangan' => ''
                );
            }



            $cekAbsenExist = $this->Presensi_model->cekAbsenExist($tanggal, $pin);
            if ($cekAbsenExist == false) {

                $this->db->insert('tbl_absensi', $newArray);
            } else {


                $this->db->where('pin', $pin);
                $this->db->where('tanggal', $tanggal);
                $this->db->update('tbl_absensi', $newArray);
            }
        }


        $pesan =  createMessageInfo('Absensi berhasil diupdate', 'success');
        $this->session->set_flashdata('message', $pesan);
        redirect('absensi/lihat_absensi/' . $bulan . '/' . $tahun);


        #print_array($dataPresensi);
    }

    function dinas_luar()
    {
        $id_pegawai  =  $this->session->userdata('id_pegawai');
        $data['pengajuan_dinas_luar'] = $this->Absensi_model->getListPengajuanDL($id_pegawai);
        $this->load->view('my_absensi/dinas_luar', $data);
    }

    function delete_pengajuan_dl($id)
    {

        $path_surtug = 'uploads/surat_tugas/';
        $path_photo  = 'uploads/photo_dinas_luar/thumb/';

        $pengajuan_dinas_luar = $this->Absensi_model->getDetailPengajuanDL($id);
        $surtug = $pengajuan_dinas_luar[0]->surtug;
        $photo  = $pengajuan_dinas_luar[0]->photo;


        $fileImage     = $path_photo . $photo;
        if (file_exists($fileImage)) {
            unlink($fileImage);
        }

        $fileImageSurtug     = $path_surtug . $surtug;
        if (file_exists($fileImageSurtug)) {
            unlink($fileImageSurtug);
        }

        $this->db->where('id', $id);
        $this->db->delete('pengajuan_dinas_luar');


        $pesan =  createMessageInfo('Pengajuan dinas luar berhasil dihapus', 'success');
        $this->session->set_flashdata('message', $pesan);
        redirect('absensi/dinas_luar');
    }

    function detail_pengajuan_dl($id)
    {


        $data['pengajuan_dinas_luar'] = $this->Absensi_model->getDetailPengajuanDL($id);
        $this->load->view('my_absensi/detail_dinas_luar', $data);
    }

    function insertPengajuanDinasLuar()
    {

        $randomNumber = $this->generateRandomNumber();

        if (isset($_FILES['cameraInput'])) {
            $image_path = $_FILES['cameraInput']['tmp_name'];

            //print_array($_FILES);


            // Periksa apakah file yang diunggah adalah gambar
            if ($image_info = getimagesize($image_path)) {
                // Mendapatkan dimensi gambar
                $width = $image_info[0];
                $height = $image_info[1];
                // Mendapatkan tipe gambar dan string ukuran
                $image_type = $image_info[2];
                $image_size_str = $image_info[3];

                // Menampilkan informasi gambar
                // echo "Lebar gambar: " . $width . " pixels<br>";
                // echo "Tinggi gambar: " . $height . " pixels<br>";
                // echo "Tipe gambar: " . image_type_to_mime_type($image_type) . "<br>";
                // echo "String ukuran gambar: " . $image_size_str . "<br>";

                // Mendapatkan ukuran file dalam bytes
                $file_size = filesize($image_path);
                echo "Ukuran file: " . $file_size . " bytes<br>";
            } else {
                echo "File yang diunggah bukan gambar.";
            }
        } else {
            echo "Tidak ada file yang diunggah.";
        }

        $nama_user   =  $this->session->userdata('nama');
        $id_pegawai  =  $this->session->userdata('id_pegawai');
        $tanggal     =  $this->input->post('tanggal');


        $namaPeg = strtolower($nama_user);
        $namaPeg = url_title($namaPeg);
        $namaPeg = str_replace("-", "_", $namaPeg);


        $tanggal_dl  = date('Ymd', strtotime($tanggal));

        $target_dir = "./uploads/photo_dinas_luar/";
        $target_file = $target_dir . basename($_FILES["cameraInput"]["name"]);

        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Periksa apakah file adalah gambar sebenarnya atau bukan
        $check = getimagesize($_FILES["cameraInput"]["tmp_name"]);
        if ($check !== false) {
            //  echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            // echo "File is not an image.";
            $uploadOk = 0;
        }



        $fileType = getFileType('cameraInput');

        // Simpan data geolokasi dan timestamp

        //$file_name = $_FILES['cameraInput']['name'];

        $file_name = $randomNumber . '_temp';
        //  $fileNameSave = str_replace(" ", "_", $file_name);


        $config['file_name']      = $file_name;
        $config['upload_path']    = $target_dir;
        $config['allowed_types']  = 'gif|jpg|png|jpeg|';
        $config['max_size']       = '5000';
        $config['max_width']      = '5000';
        $config['max_height']     = '5000';
        $this->upload->initialize($config);

        $latitude = isset($_POST['latitude']) ? $_POST['latitude'] : 'Unknown';
        $longitude = isset($_POST['longitude']) ? $_POST['longitude'] : 'Unknown';
        $timestamp = date('Y-m-d H:i:s');

        if ($latitude == '' || $longitude == '') {
            $pesan =  createMessageInfo('Upload file gagal. Lokasi tidak dapat diakses, periksa pengaturan lokasi atau GPS pada perangkat anda', 'danger');
            $this->session->set_flashdata('message', $pesan);
            $this->session->set_userdata($this->input->post());

            redirect('absensi/dinas_luar');
        }


        if (!$this->upload->do_upload('cameraInput')) {
            $data = array('error' => $this->upload->display_errors('', ''));
            $error = $data['error'];
            $pesan =  createMessageInfo('Upload file gagal.' . $error, 'danger');
            $this->session->set_flashdata('message', $pesan);
            $this->session->set_userdata($this->input->post());

            echo $pesan;
        } else {

            // Ubah ukuran gambar
            $date = date('YmdHi');

            // echo basename($_FILES["cameraInput"]["name"]);
            // exit;
            $nameSmallImage = $namaPeg . '_' .  $date . '.' . $fileType;
            $resized_file = $target_dir . 'thumb/' . $nameSmallImage;
            $fileUploaded = $target_dir . $file_name . '.' . $fileType;
            resizeImage($fileUploaded, 800, 600, $resized_file);

            #delete image exis
            $fileImageName     = $target_dir . $file_name . '.' . $fileType;

            if (file_exists($fileImageName)) {
                unlink($fileImageName);
            }

            $namaFileDB = $nameSmallImage;
            $this->Absensi_model->insertPengajuanDL($id_pegawai, $namaFileDB, $latitude, $longitude);
            $pesan =  createMessageInfo('Pengajuan dinas luar berhasil dikirim', 'success');
            $this->session->set_flashdata('message', $pesan);

            $this->session->unset_userdata('tanggal');
            $this->session->unset_userdata('keterangan');
            $this->session->unset_userdata('jns_dl');

            redirect('absensi/dinas_luar');
        }
    }

    function upload_surat_tugas($id, $tgl_dl)
    {
        $nama_user   =  $this->session->userdata('nama');
        $id_pegawai  =  $this->session->userdata('id_pegawai');
        //$tanggal     =  $this->input->post('tanggal');

        $xplod       = explode(' ', $nama_user);
        $first_name  = $xplod[0];
        $tanggal_dl  = date('Ymd', strtotime($tgl_dl));


        $file_title  = 'surtug_' . $first_name . '_' . $tanggal_dl;
        $nama_file   =  $file_title;
        $nama_file  .= $_FILES['filedocs']['name'];

        $file_name       = $file_title . '_' . $jns_dl;
        $file_name       = url_title($file_name);

        $namaFileDB      =  $file_name . '.pdf';
        $numchar         = strlen($namaFileDB);

        $path = 'surat_tugas';
        $uploadFile = $this->Master_model->uploadFilePDF($path, $file_name, '5000');


        if ($uploadFile) {

            $pesan =  createMessageInfo('Surat Tugas berhasil diupload', 'success');
            $this->session->set_flashdata('message', $pesan);
            $this->db->where('id', $id);
            $this->db->set('surtug', $namaFileDB);
            $this->db->update('pengajuan_dinas_luar');
        }

        redirect('absensi/detail_pengajuan_dl/' . $id);
    }


    function generateRandomNumber()
    {
        $min = pow(10, 9); // Minimum 10-digit number (1000000000)
        $max = pow(10, 10) - 1; // Maximum 10-digit number (9999999999)

        return strval(mt_rand($min, $max)); // Generate random number and convert to string
    }


    function izin_sakit()
    {
        $id_pegawai  =  $this->session->userdata('id_pegawai');
        $data['pengajuan_izin_sakit'] = $this->Absensi_model->getListPengajuanIzinSakit($id_pegawai);
        $this->load->view('my_absensi/izin_sakit', $data);
    }



    function insertPengajuanIzinSakit()
    {
        $nama_user   =  $this->session->userdata('nama');
        $id_pegawai  =  $this->session->userdata('id_pegawai');
        $tanggal     =  $this->input->post('tanggal');

        $xplod       = explode(' ', $nama_user);
        $first_name  = $xplod[0];
        $tanggal_dl  = date('Ymd', strtotime($tanggal));

        $file_title  = $first_name . '_' . $tanggal_dl;
        $file_name = url_title($file_title);
        $file_name       = strtolower($file_name);



        $ImageName = $file_name . '.' . substr($_FILES['ImageUpload']['name'], strrpos($_FILES['ImageUpload']['name'], '.') + 1);
        $ImageName_temp = $file_name . '_temp.' . substr($_FILES['ImageUpload']['name'], strrpos($_FILES['ImageUpload']['name'], '.') + 1);

        $config['file_name']      = $file_name . '_temp';
        $config['upload_path']    = './uploads/surat_izin/';
        $config['allowed_types']  = 'gif|jpg|png|jpeg|';
        $config['max_size']          = '2000';
        $config['max_width']      = '2000';
        $config['max_height']     = '2000';
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('ImageUpload')) {
            $data = array('error' => $this->upload->display_errors('', ''));
            $error = $data['error'];
            $pesan =  createMessageInfo('Upload file gagal.' . $error, 'danger');
            $this->session->set_flashdata('message', $pesan);
            $this->session->set_userdata($this->input->post());
            redirect('absensi/izin_sakit');
        } else {

            #delete temp image
            $fileImageName_temp     = './uploads/surat_izin/' . $ImageName_temp;
            if (file_exists($fileImageName_temp)) {
                unlink($fileImageName_temp);
            }

            #delete image exis
            $fileImageName     = './uploads/surat_izin/' . $ImageName;
            if (file_exists($fileImageName) && $ImageName != '') {
                unlink($fileImageName);
            }

            #second upload with no error, not necessary to make a condition error upload image
            $config['file_name']      = $file_name; // initialization new config file_name
            $this->upload->initialize($config);

            $this->upload->do_upload('ImageUpload');

            $this->Absensi_model->insertPengajuanIzinSakit($id_pegawai, $ImageName);

            $this->session->unset_userdata('tanggal');
            $this->session->unset_userdata('keterangan');
            $this->session->unset_userdata('jns_absen');


            $pesan =  createMessageInfo('Pengajuan izin / sakit berhasil dikirim.', 'success');
            $this->session->set_flashdata('message', $pesan);
            $this->session->set_userdata($this->input->post());
            redirect('absensi/izin_sakit');
        }    // kondisi upload
        #close upload image =========================================================================


    }



    function delete_pengajuan_izin_sakit($id, $file_name)
    {

        $path = 'uploads/surat_izin/';


        if (file_exists($path . $file_name)) {
            unlink($path . $file_name);
        }

        $this->db->where('id', $id);
        $this->db->delete('pengajuan_izin_sakit');


        $pesan =  createMessageInfo('Pengajuan izin/sakit dihapus', 'success');
        $this->session->set_flashdata('message', $pesan);
        redirect('absensi/izin_sakit');
    }
}
