<?php
defined("BASEPATH") or exit("No direct script access allowed");
class Import_data extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Laporan_model");
        $this->load->helper("text");
        $this->load->model('Admin_cuti_model', 'acm');
        $this->Auth_model->cekAuthLogin();
    }

    function import_gaji()
    {
        $date_now = date("Ymd_Hi");
        $file_name = $date_now;

        $jns_file = $this->input->post("jenis_file");
        $periode = $this->input->post("periode");
        $path = "pajak";

        $upload = $this->Master_model->upload_file($file_name, $path);

        //---delete data gaji periode tersebut sebelum import ulang----

        $this->db->where("periode", $periode);
        $this->db->delete("ts_listing_gaji");

        if ($upload["result"] == "success") {
            // Jika proses upload sukses
            // Load plugin PHPExcel nya
            include APPPATH . "third_party/PHPExcel/PHPExcel.php";

            $excelreader = new PHPExcel_Reader_Excel2007();
            $loadexcel = $excelreader->load( "uploads/" . $path . "/" . $file_name . ".xlsx" ); // Load file yang tadi diupload ke folder excel
            $sheet = $loadexcel
                ->getActiveSheet()
                ->toArray(null, true, true, true);

            // Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
            $data = [];
            $numrow = 1;
            $num = 0;
            $newData = [];
            foreach ($sheet as $row) {
                if ($numrow > 0) {
                    $nama = $row["B"];
                    $jabatan = $row["C"];
                    $tmt_tgl = $row["D"];
                    $tmt_bln = $row["E"];
                    $tmt_thn = $row["F"];
                    $status_kawin = $row["G"];
                    $nik = $row["H"];
                    $gp = $row["I"]; //gaji pokok
                    $tunj_suami = $row["J"];
                    $tunj_anak1 = $row["K"];
                    $tunj_anak2 = $row["L"];
                    $jumlah_gaji = $row["M"]; //bruto
                    $ptkp = $row["N"];
                    $tarif_ter = $row["O"];
                    $pajak = $row["P"];
                    $netto = $row["Q"];
                    $no_rekening = $row["R"];

                    $no_bulan = getNomorBulan($tmt_bln);

                    $tmt = $tmt_tgl . "-" . $no_bulan . "-" . $tmt_thn;
                    $tmt_format = format_db($tmt);

                    $pajak = str_replace("Rp ", "", $pajak);

                    if ($tmt_format != "1970-01-01") {
                        $newData[] = [
                            "periode" => $periode,
                            "nama" => $nama,
                            "jabatan" => $jabatan,
                            "tmt" => $tmt_format,
                            "status_kawin" => $status_kawin,
                            "nik" => clear_tags($nik),
                            "gaji_pokok" => clear_tags($gp),
                            "tunj_suami" => clear_tags($tunj_suami),
                            "tunj_anak1" => clear_tags($tunj_anak1),
                            "tunj_anak2" => clear_tags($tunj_anak2),
                            "bruto" => clear_tags($jumlah_gaji),
                            "ptkp" => clear_tags($ptkp),
                            "tarif_ter" => $tarif_ter,
                            "pajak" => clear_tags($pajak),
                            "netto" => clear_tags($netto),
                            "no_rekening" => $no_rekening,
                            "ttd_spj" => "",
                        ];
                    }
                }
            } //close loop


      
            $this->db->insert_batch("ts_listing_gaji", $newData);
        }

        $this->session->set_flashdata(
            "message",
            '<div class="alert alert-success" role="alert">Data berhasil diimport!</div>'
        );



        redirect("admin/listing_tkd/listing_gaji");
    }


    public function import_tkd_p3k()
    {
        $date_now = date("Ymd_Hi");
        $file_name = $date_now;
        $periode = $this->input->post("periode");
        $path = "pajak";

        $upload = $this->Master_model->upload_file($file_name, $path);

        //---delete data gaji periode tersebut sebelum import ulang----

        $this->db->where("periode", $periode);
        $this->db->delete("ts_rekap_tkd_pppk");

        if ($upload["result"] == "success") {
            // Jika proses upload sukses
            // Load plugin PHPExcel nya
            include APPPATH . "third_party/PHPExcel/PHPExcel.php";

            $excelreader = new PHPExcel_Reader_Excel2007();
            $loadexcel = $excelreader->load( "uploads/" . $path . "/" . $file_name . ".xlsx" ); // Load file yang tadi diupload ke folder excel
            $sheet = $loadexcel
                ->getActiveSheet()
                ->toArray(null, true, true, true);

            // Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
            $data = [];
            $numrow = 1;
            $nip = 0;

            $newData = [];
            foreach ($sheet as $row) {
                if ($numrow > 0) {
                    $nama = $row["B"];
                    $jabatan = $row["C"];
                    $tkd_pokok = $row["D"];
                    $pot_absen = $row["E"];
                    $bruto = $row["F"];
                    $bpjs = $row["G"];
                    $pph = $row["H"];
                    $tht = $row["I"]; //gaji pokok
                    $thp = $row["J"];
                  
                    $nip = $this->getNipPegawaiP3k($nama);
                
                    if($nip != 0){
                        $newData[] = [
                            "periode" => $periode,
                            "nama" => $nama,
                            "nip" => $nip,
                            "jabatan" => $jabatan,
                            "tkd_pokok" => $tkd_pokok,
                            "pot_absensi" => $pot_absen,
                            "bruto" => clear_tags($bruto),  // tkd_pokok setelah dipotong absen tidak hadri (izin, sakit, dll)
                            "pph21" => clear_tags($pph),  //potongan pajak
                            "bpjs" => clear_tags($bpjs),  //potongan bpjs
                            "tht" => clear_tags($tht),  //potongan tunjangan hari tua
                            "thp" => clear_tags($thp),
                            "ttd_spj" => "",
                        ];
                    }
                    
                    
                }
            } //close loop
         $this->db->insert_batch("ts_rekap_tkd_pppk", $newData);
        }


       // print_array($newData);

        $this->session->set_flashdata(
            "message",
            '<div class="alert alert-success" role="alert">Data berhasil diimport!</div>'
        );



        redirect("admin/listing_tkd/p3k_pw");
    }


    function getNipPegawaiP3k($nama)
    {
        $this->db->select('nip');
        $qry = $this->db->get_where('mst_pegawai', ['nama'=> $nama]);
        $row = $qry->row();

        if($row){
            $nip = $row->nip;
        }else{
            $nip = 0;
        }

        return $nip;
    }


    public function preview()
    {

        $periode = '2025-11';

        if (!empty($_FILES["file"]["name"])) {
            $file = $_FILES["file"]["tmp_name"];
            $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            $jns_file = $this->input->post("jns_file");

            $found = [];
            $not_found = [];

            $listData = [];




                 foreach ($lines as $line) {
                    $parts = explode("\t", $line);
                    $nik = trim($parts[0]);
                    $nama = trim($parts[1]);

                    $part2 = isset($parts[2]) ? $parts[2] : '0';
                    $jumlah = trim($part2);
                    //$jumlah_clean = floatval(str_replace(['.', ','], ['', '.'], $jumlah));
                    $jumlah_clean = str_replace(",", "", $jumlah);

                    $query = $this->db
                        ->select("nip")
                        ->from("detail_pegawai")
                        ->where("no_ktp", $nik)
                        ->get();

                    if ($query->num_rows() > 0) {
                        $found[] = [
                            "nik" => $nik,
                            "nama" => $nama,
                            "jumlah" => $jumlah,
                            "jumlah_clean" => $jumlah_clean,
                            "nip" => $query->row()->nip,
                        ];
                    } else {
                        $not_found[] = [
                            "nik" => $nik,
                            "nama" => $nama,
                            "jumlah" => $jumlah,
                        ];
                    }
                 }

                //bpjs
                $this->session->set_userdata("jns_file", $jns_file);
                $this->session->set_userdata("import_found", $found);
                $data["found"] = $found;
                $data["not_found"] = $not_found;

                $this->load->view("admin/listing_tkd/preview_import", $data);


        } else {
            echo "Tidak ada file yang diunggah.";
        }
    }


    function process_import_pajak(){
    $pajak = $this->session->userdata("pajak");
    $bulan = $this->session->userdata("periode_bulan") ?: date("m");
    $tahun = $this->session->userdata("periode_tahun") ?: date("Y");

    $periode = date("Y-m", strtotime("$tahun-$bulan"));

    foreach ($pajak as $row) {

            $nip    = $row['nip'];
            $jumlah = $row["jumlah"];
            $pph21  = str_replace(".", "", $jumlah);
            $pph21  = str_replace(",", "", $pph21);

            // Query data
            $qry = $this->db->get_where('ts_rekap_tkd', [
                'nip'     => $nip,
                'periode' => $periode
            ]);

            // Cek apakah datanya ada
            if ($qry->num_rows() == 0) {
                // Jika tidak ada, lanjut ke baris berikutnya
                continue;
            }

            $data = $qry->row(); // lebih rapi dari result()[0]

            $thp = $data->bruto - $pph21 - $data->bpjs - $data->bpjs_tk;

            $update = [
                'pph21' => $pph21,
                'thp'   => $thp
            ];

            $this->db->where('id', $data->id);
            $this->db->update('ts_rekap_tkd', $update);
        }

        $this->session->set_flashdata("success", 'Data Pajak Berhasil disimpan');
        redirect('admin/listing_tkd/index');
    }


    public function import()
    {
        $bulan = $this->session->userdata("periode_bulan") ?: date("m");
        $tahun = $this->session->userdata("periode_tahun") ?: date("Y");

        $periode = date("Y-m", strtotime("$tahun-$bulan"));


        $found = $this->session->userdata("import_found");
        $jns_file = $this->session->userdata("jns_file");

        if (empty($found)) {
            echo "Tidak ada data untuk diupdate.";
            return;
        }

        $updated = 0;

        if ($jns_file == "bpjs") {
            $colomn = "bpjs";
        } elseif ($jns_file == "bpjs_tk") {
            $colomn = "bpjs_tk";
        } else {
            $colomn = "pph21";
        }
        foreach ($found as $row) {
            $jumlah = $row["jumlah_clean"];
            $jumlah = str_replace(".", "", $jumlah);

            $this->db
                ->where("nip", $row["nip"])
                ->where("periode", $periode)
                ->update("ts_rekap_tkd", [$colomn => $jumlah]);

            $updated += $this->db->affected_rows();
        }

        // Hapus data dari session
        $this->session->unset_userdata("import_found");

        echo "$updated data berhasil diupdate. <br>
            <a href='" .
            base_url("admin/listing_tkd/index") .
            "'>Kembali</a>
        ";
    }





    public function import_absensi()
    {
        $date_now = date("Ymd_Hi");
        $file_name = $date_now;

        $path = "pajak";

        $this->load->library("upload"); // Load librari upload

        $config["upload_path"] = "./uploads/" . $path . "/";
        $config["allowed_types"] = "txt";
        $config["max_size"] = "2048";
        $config["overwrite"] = true;
        $config["file_name"] = $file_name;

        $this->upload->initialize($config); // Load konfigurasi uploadnya
        if ($this->upload->do_upload("absensi_file")) {
            // Lakukan upload dan Cek jika proses upload berhasil
            $upload = true;
        } else {
            $upload = false;
        }

        if (!$upload) {
            echo $this->upload->display_errors();
        } else {
            $upload_data = $this->upload->data();
            $file_path = $upload_data["full_path"];
            $insert_data = [];
            $handle = fopen($file_path, "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    $data = explode("\t", trim($line));

                    $user_id = $data[0];
                    $datetime = $data[1];
                    $verifikasi = $data[2];
                    $status = $data[3];
                    $validasi = $data[4];

                    $tanggal = date("Y-m-d", strtotime($datetime));
                    $jam = date("H:i:s", strtotime($datetime));

                    $insert_data[] = [
                        "pin" => $user_id,
                        "tanggal" => $datetime,
                        "status" => $status,
                    ];

                    // $this->db->insert('ts_import_absensi', $insert_data);
                }
                fclose($handle);


                print_array($insert_data);
               // $this->db->insert_batch("ts_import_absensi", $insert_data);
                //print_array($insert_data);
                echo "Import berhasil.";
            } else {
                echo "Gagal membaca file.";
            }
        }
    }

    function getDataImportAbsensi()
    {
        $data["import_absensi"] = $this->db->get("ts_import_absensi")->result();
        $this->load->view("admin/import_data_view", $data);
    }


    function form_import_gaji_p3k_pw(){
         $this->load->view("admin/form_import_gaji_p3k_pw");
    }

     function import_gaji_p3k_pw()
        {
            $date_now  = date("Ymd_Hi");
            $file_name = $date_now;
            $path      = "pajak";

            $bulan = $this->input->post("bulan"); // 1-12
            $tahun = $this->input->post("tahun"); // 2026
            $periode = strtoupper(getNamaBulan($bulan)) . " " . $tahun;

            $upload = $this->Master_model->upload_file($file_name, $path);

            // 🔥 hapus data periode yg sama (import ulang)
            $this->db->where("bulan", $bulan);
            $this->db->where("tahun", $tahun);
            $this->db->delete("tbl_gaji_p3k_pw");

            if ($upload["result"] == "success") {

                include APPPATH . "third_party/PHPExcel/PHPExcel.php";

                $excelreader = new PHPExcel_Reader_Excel2007();
                $loadexcel   = $excelreader->load("uploads/".$path."/".$file_name.".xlsx");
                $sheet       = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

                $newData = [];
                $numrow  = 1;

                foreach ($sheet as $row) {

                    // skip header
                    if ($numrow > 1) {

                        // ==== mapping kolom Excel ====
                        $nipppk_pw  = trim($row['B']);
                        $nama       = trim($row['C']);
                        $jabatan    = trim($row['D']);
                        $jumlah_gaji = clear_tags($row['E']);
                        $gaji_hasil  = clear_tags($row['F']);
                        $pot_absen  = clear_tags($row['G']);
                        $pot_bpjs_1 = clear_tags($row['H']);
                        $pot_pph    = clear_tags($row['I']);
                        $pot_tht    = clear_tags($row['J']);
                        $gaji_setelah_pot = clear_tags($row['K']);
                        $jumlah_diterima = clear_tags($row['L']);
                        $tunj_bpjs  = clear_tags($row['M']);
                        $bruto      = clear_tags($row['N']);
                        $no_rekening = trim($row['O']);

                        //cari id_pegawai berdasarkan NIPPPK-PW
                        $pegawai = $this->db
                            ->where("nip", $nipppk_pw)
                            ->get("mst_pegawai")
                            ->row();

                        // ❗ kalau pegawai tidak ditemukan, skip
                        if (!$pegawai) {
                            $numrow++;
                            continue;
                        }

                       $id_pegawai = $pegawai->id_pegawai;

                       // $id_pegawai = 0;

                        $newData[] = [
                            "id_pegawai" => $id_pegawai,
                            "nama"       => $nama,
                            "nipppk_pw"  => $nipppk_pw,
                            "jabatan"    => $jabatan,
                            "bulan"      => $bulan,
                            "tahun"      => $tahun,
                            "periode"    => $periode,
                            "jumlah_gaji" => $jumlah_gaji,
                            "gaji_hasil_kerja" => $gaji_hasil,
                            "pot_absen"  => $pot_absen,
                            "pot_bpjs_1" => $pot_bpjs_1,
                            "pot_pph"    => $pot_pph,
                            "pot_tht_325"=> $pot_tht,
                            "gaji_setelah_pot_absen" => $gaji_setelah_pot,
                            "jumlah_diterima" => $jumlah_diterima,
                            "tunjangan_bpjs_4" => $tunj_bpjs,
                            "bruto"      => $bruto,
                            "no_rekening"=> $no_rekening,
                            "ttd_pegawai"=> 0
                        ];
                    }

                    $numrow++;
                }

               // print_array($newData);

                if (!empty($newData)) {
                    $this->db->insert_batch("tbl_gaji_p3k_pw", $newData);
                }
            }

            $this->session->set_flashdata(
                "message",
                '<div class="alert alert-success">Data gaji P3K Paruh Waktu berhasil diimport</div>'
            );

            redirect("admin/import_data/list_import_gaji_p3k_pw");
        }

       function list_import_gaji_p3k_pw()
        {
            $bulan = $this->input->get('bulan');
            $tahun = $this->input->get('tahun');

            $this->db->from('tbl_gaji_p3k_pw');

            if ($bulan) {
                $this->db->where('bulan', $bulan);
            }

            if ($tahun) {
                $this->db->where('tahun', $tahun);
            }

            $this->db->order_by('tahun', 'DESC');
            $this->db->order_by('bulan', 'DESC');
            $this->db->order_by('nama', 'ASC');

            $data['list'] = $this->db->get()->result();

            // kirim ke view
            $this->load->view('admin/gaji_p3k_pw/list_import', $data);
        }


}
