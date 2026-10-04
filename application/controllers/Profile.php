<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Profile extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();

        $this->load->model('Profile_model');
        $this->Auth_model->cekAuthLogin();
    }



    function my_profile()
    {

     $tahun  = date('Y');
        $id_pegawai = $this->session->userdata('id_pegawai');
        $nip = $this->session->userdata('nip');
        $data['data_detail'] = $this->Pegawai_model->getDetailPegawai($id_pegawai);
        $data['pegawai'] = $this->Pegawai_model->getDataEditPegawai($id_pegawai);
        $data['data_gaji'] = $this->Pegawai_model->getDataGajiPegawai($id_pegawai);
        $data['data_sip'] = $this->Profile_model->getDataSIPSTR($nip, 'sip');
        $data['data_str'] = $this->Profile_model->getDataSIPSTR($nip, 'str');
        $data['data_diklat'] = $this->Profile_model->getDataDiklat($nip);
        $data['history'] = $this->Cuti_model->getHistoryCuti($id_pegawai, $tahun);

        $data['master_cuti'] = $this->Master_model->getlistCuti();
        $data['data_detail_pegawai'] = $this->Pegawai_model->getDataDetailPegawai($nip);



        $this->load->view('profile/my_profile', $data);
    }

    function edit_profile($id_pegawai){
        $data_pegawai   = $this->Pegawai_model->getDetailPegawai($id_pegawai);
		$nip = $data_pegawai[0]->nip;
		$data['data_gaji'] = $this->Pegawai_model->getDataGajiPegawai($id_pegawai);

		$data['list_jabatan'] 	   = $this->Master_model->getlistJabatan();
		$data['list_pendidikan']   = $this->Master_model->getlistPendidikan();
		$data['list_poli'] 		   = $this->Master_model->getlistPoli();
		$data['list_puskesmas']    = $this->Master_model->getlistPuskesmas();
		$data['list_Status']       = $this->Master_model->getlistStatus();
		$data['list_validator']    = $this->Pegawai_model->getValidator();
		$data['cutiPegawai']       = $this->Cuti_model->getHistoryCutiPegawai($id_pegawai);
		$data['pegawai'] 		   = $data_pegawai;
		$data['data_detail_pegawai'] = $this->Pegawai_model->getDataDetailPegawai($nip);
		
		$this->load->view('profile/edit_profile', $data);
    }

    function change_password()
    {
        $id_pegawai = $this->session->userdata('id_pegawai');
        #print_array($this->input->post());
        $data['pegawai'] = $this->Pegawai_model->getDataEditPegawai($id_pegawai);
        $this->load->view('profile/change_password', $data);
    }

    function change_password_process()
    {

        #print_array($this->input->post());
        $curr_password = $this->input->post('curr_password');
        $new_password = $this->input->post('new_password');
        $confirm_password = $this->input->post('confirm_password');


        $nip        = $this->session->userdata('nip');
        $password   = md5($curr_password);
        $cekAuth    = $this->Auth_model->cekUserAuth($nip, $password);


        if (empty($cekAuth)) {

            $this->session->set_flashdata('message_status', 250);
            $this->session->set_flashdata('message', 'Gagal merubah password. Password lama salah');
            $this->session->set_flashdata('error_msg', 'failed1');
            redirect('profile/change_password');
        } else {

            if ($new_password !== $confirm_password) {
                $this->session->set_flashdata('message_status', 250);

                $this->session->set_flashdata('message', 'Gagal merubah password. Password  tidak cocok');
                $this->session->set_flashdata('error_msg', 'failed2');
                redirect('profile/change_password');
            } else {

                $new_pass = md5($new_password);
                $this->Auth_model->updatePassword($new_pass);

                $this->session->set_flashdata('message_status', 200);
                $this->session->set_flashdata('message', 'Password berhasil diubah');

                redirect('profile/change_password');
            }
        }
    }

    function edit_sipstr()
    {
        $id = $this->input->post('id');


        $qry = $this->db->get_where('tbl_sip_str', array('id' => $id));
        $row = $qry->result();


        $tgl_terbit = $row[0]->tgl_terbit;
        $tgl_kadaluarsa = $row[0]->tgl_kadaluarsa;
        $no_sip_str = $row[0]->no_sip_str;
        $seumur_hidup = $row[0]->seumur_hidup;

        if ($seumur_hidup == 1) {
            $checked = 'checked';
            $display = 'style="display:none"';
        } else {
            $checked = '';
            $display = '';
        }

        echo '
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="recipient-name" class="control-label">Tanggal Terbit:</label>
                            <input type="text" required name="tanggal_terbit" value="' . format_view($tgl_terbit) . '" autocomplete="off" class="form-control" id="dpd3" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        
                        <div class="mb-3">

                                <label for="recipient-name" class="control-label">Tanggal Expired:</label> <br>

                                <input type="checkbox" name="str_seumur_hidup" value="1" ' . $checked . ' id="masa_berlaku">  Seumur Hidup<br>
                                 <span class="text-info"> (Checklist jika STR berlaku seumur hidup) </span> <br>

                                <input type="text" name="tanggal_expired" autocomplete="off"  value="' . format_view($tgl_kadaluarsa) . '"  class="form-control tgl_exp"  ' . $display . ' id="dpd4" >
                            </div>
                        </div>
                </div>

                <input type="hidden" name="id" id="id" value="' . $id . '">
            

                <div class="mb-3">
                    <label for="message-text" class="control-label">No <span id="title_no">SIP</span>:</label>
                    <input type="text" name="no_sip_str" required autocomplete="off" class="form-control" value="' . $no_sip_str . '" >
                </div>


          
            
            <script>
            
                var nowTemp = new Date();
                var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

                var checkin = $("#dpd3").datepicker({
                        onRender: function(date) {
                            //  return date.valueOf() < now.valueOf() ? "disabled" : "";
                            }
                }).on("changeDate", function(ev) {
                if (ev.date.valueOf() > checkout.date.valueOf()) {
                    var newDate = new Date(ev.date)
                    newDate.setDate(newDate.getDate() + 1);
                    checkout.setValue(newDate);
                }
                    checkin.hide();
                $("#dpd4")[0].focus();
                }).data("datepicker");
                    var checkout = $("#dpd4").datepicker({
                    onRender: function(date) {
                    return date.valueOf() <= checkin.date.valueOf() ? "disabled" : "";
                }
                }).on("changeDate", function(ev) {
                checkout.hide();
                }).data("datepicker");

                var tgl_exp = document.getElementById("dpd4");
                const masa_berlaku = document.getElementById("masa_berlaku");
                    masa_berlaku.addEventListener("change", e => {
                        if (e.target.checked === true) {
                            tgl_exp.style.display = "none";
                        } else {
                            tgl_exp.style.display = "block";
                        }
                    });

            </script>
            ';
    }


    function edit_pelatihan()
    {
        $id = $this->input->post('id');
        $arayJenis = getListJnsDiklat();

        $qry = $this->db->get_where('tbl_diklat', array('id' => $id));
        $row = $qry->result();


        $tgl_terbit = $row[0]->tgl_mulai;
        $tgl_kadaluarsa = $row[0]->tgl_selesai;
        $judul_pelatihan = $row[0]->judul_pelatihan;
        $lokasi_diklat = $row[0]->lokasi_diklat;


        echo '
                <div class="row">
                
                        <div class="mb-3">
                                <label for="message-text" class="control-label">Judul / Nama Pelatihan:</label>
                                <input type="text" name="judul" required autocomplete="off" class="form-control" value="' . $judul_pelatihan . '" >
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="recipient-name" class="control-label">Tanggal Mulai:</label>
                                    <input type="text" required name="tanggal_mulai" value="' . format_view($tgl_terbit) . '" autocomplete="off" class="form-control" id="dpd3" >
                                </div>
                            </div>
                            <div class="col-md-6">
                            <div class="mb-3">
                                    <label for="recipient-name" class="control-label">Tanggal Selesai:</label>
                                    <input type="text" name="tanggal_selesai" autocomplete="off"  value="' . format_view($tgl_kadaluarsa) . '"  class="form-control" id="dpd4" >
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="id" id="id" value="' . $id . '">
                    

                        <div class="mb-3">
                        <label for="recipient-name" class="control-label">Jenis Diklat:</label>
                        <select name="jns_diklat" id="jns_diklat"  class="form-control">';

        for ($d = 0; $d < count($arayJenis); $d++) {
            $jns_diklat = trim($arayJenis[$d]);

            if ($judul_pelatihan == $jns_diklat) {
                echo '<option value="' . $jns_diklat . '" selected>' . $jns_diklat . '</option>';
            } else {
                echo '<option value="' . $jns_diklat . '">' . $jns_diklat . '</option>';
            }
        }
        echo '
                        </select>
                    </div>


                        <div class="mb-3">
                            <label for="message-text" class="control-label">Lokasi/Tempat Pelatihan:</label>
                            <input type="text" name="lokasi" required autocomplete="off" class="form-control" value="' . $lokasi_diklat . '" >
                        </div>

                        <h6>Ubah file Sertifikat/Surat Tugas ?</h6>
                        <input type="radio" name="change_file" class="ganti_file" value="0" checked> Tidak &nbsp;&nbsp;&nbsp;
                        <input type="radio" name="change_file" class="ganti_file" value="1"> Iya
                        

                

                        
                        <div class="mb-3 edit-image d-none">
                                <div class="card w-100 bg-info-subtle overflow-hidden p-2 shadow-none">
                                    <h6>Dokumen Sertifikat/Surat Tugas:</h6>
                                    <p class="text-danger">
                                        Jenis file yang diizinkan : <strong>PDF </strong> <br>
                                        Ukuran Maksimum File      : <strong>1 MB </strong> 
                                    </p>

                                    
                                    <br>
                                    <br>
                                        <input type="file" name="filedocs" id="file-dokumen" class="d-none" multiple />
                                             <label for="file-input">
                                                <div class="btn btn-primary">  
                                                    <i class="fa fa-folder-open"></i>
                                                    &nbsp; Choose Files To Upload
                                                </div> 
                                            </label>

                                        <div id="num-of-files">No Files Choosen</div>
                                        <ul id="files-list"></ul>
                                        <div id="inforequired"></div>
                                    </div>
                        </div>



                
            
            <script>


            $(".ganti_file").click(function(){
                var ganti = $(this).val();
        
                if(ganti==1){
                    $(".edit-image").removeClass("d-none");
                    $("#file-dokumen").prop("required",true);
                 
                }else{
                    $(".edit-image").addClass("d-none");
                    $("#file-dokumen").prop("required",false);
                    
                }
                      
                    
            });
            
            
                var nowTemp = new Date();
                var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

                var checkin = $("#dpd3").datepicker({
                        onRender: function(date) {
                            //  return date.valueOf() < now.valueOf() ? "disabled" : "";
                            }
                }).on("changeDate", function(ev) {
                if (ev.date.valueOf() > checkout.date.valueOf()) {
                    var newDate = new Date(ev.date)
                    newDate.setDate(newDate.getDate() + 1);
                    checkout.setValue(newDate);
                }
                    checkin.hide();
                $("#dpd4")[0].focus();
                }).data("datepicker");
                    var checkout = $("#dpd4").datepicker({
                    onRender: function(date) {
                    return date.valueOf() <= checkin.date.valueOf() ? "disabled" : "";
                }
                }).on("changeDate", function(ev) {
                checkout.hide();
                }).data("datepicker");

            </script>
            ';
    }






    function update_sip_str()
    {
        $tanggal_terbit      =  $this->input->post('tanggal_terbit');
        $tanggal_expired     =  $this->input->post('tanggal_expired');
        $str_seumur_hidup     =  $this->input->post('str_seumur_hidup');

        $tgl_terbit         = format_db($tanggal_terbit);
        $id     =  $this->input->post('id');

        if ($str_seumur_hidup == 1) {

            $seumur_hidup       = 1;
        } else {

            $seumur_hidup       = 0;
        }

        $tgl_kadaluarsa     = format_db($tanggal_expired);

        $newarray = array(
            'tgl_terbit' => $tgl_terbit,
            'tgl_kadaluarsa' => $tgl_kadaluarsa,
            'seumur_hidup' => $seumur_hidup,
            'no_sip_str' => $this->input->post('no_sip_str')
        );

        #print_array($newarray);
        $this->db->where('id', $id);
        $this->db->update('tbl_sip_str', $newarray);

        $this->session->set_flashdata('message_status', 200);
        $pesan =  createMessageInfo('Data SIP / STR berhasil diupdate', 'success');
        $this->session->set_flashdata('message_update', $pesan);

        redirect('profile/my_profile');
    }





    function update_profile()
    {
        #print_array($this->input->post());

        $this->Profile_model->updateProfile();
        $update = $this->Profile_model->updateProfileDetail();

        // Respon JSON untuk AJAX
        if ($update) {
            $response = array(
                'status'  => 'success',
                'message' => 'Data pegawai berhasil diperbarui.'
            );
        } else {
            $response = array(
                'status'  => 'error',
                'message' => 'Gagal memperbarui data pegawai ke database.'
            );
        }

        // Output dalam bentuk JSON
        echo json_encode($response);
        return;
    }


    function upload_image()
    {
        $nip    = $this->session->userdata('nip');
        $nama   = $this->session->userdata('nama');


        $first_name = strtok($nama, " "); // Test
        $img_name   = $nip . '_' . $first_name;

        $ImageName_temp = createTempImageName($img_name, 'imageupload');
        $ImageName_db   = createImageName($img_name, 'imageupload');

        $upload           = $this->Profile_model->do_upload($ImageName_temp);


        if ($upload == '') {
            #delete image exist
            $fileImageName     = './uploads/photo_profile/' . $ImageName_db;
            if (file_exists($fileImageName) && $nip != '') {
                unlink($fileImageName);
            }
            #delete image temp
            $fileImageName     = './uploads/photo_profile/' . $ImageName_temp;
            unlink($fileImageName);
            #upload new image
            $this->Profile_model->do_upload($img_name);


            $this->db->where('nip', $nip);
            $this->db->set('photo', $ImageName_db);
            $this->db->update('detail_pegawai');

            $this->session->set_flashdata('message_status', 200);
            $this->session->set_flashdata('message', 'Profile picture berhasil diubah');

            redirect('profile/my_profile');
        } else {
            // echo '<script language="javascript">alert("' . $upload . '!");window.history.go(-1);</script>';
            // exit();
            $pesan = $upload;

            $this->session->set_flashdata('message_status', 250);
            $this->session->set_flashdata('message', $pesan);
            redirect('profile/my_profile');
        }
    }


    function upload_sip_str()
    {
        $nama_user   =  $this->session->userdata('nama');
        $id_pegawai  =  $this->session->userdata('id_pegawai');
        $nip         =  $this->session->userdata('nip');
        $tanggal_terbit = $this->input->post('tanggal_terbit');
        $tgl_terbit   = date('dmY', strtotime($tanggal_terbit));

        $xplod       = explode(' ', $nama_user);
        $first_name  = $xplod[0];
        // $tanggal_dl  = date('Ymd', strtotime($tanggal));

        $jns_dokumen = $this->input->post('jns_dokumen');

        // $file_title  = $jns_dokumen . '_' . $first_name . '_' . $tanggal_dl;
        // $nama_file   =  $file_title;
        // $nama_file  .= $_FILES['filedocs']['name'];

        $nama_file  = $jns_dokumen . '_' . $first_name . '_' . $tgl_terbit;
        $file_name       = strtolower($nama_file);
        $file_name  = url_title($file_name);

        #nama file untuk disimpan di folder upload
        $fileNameSave = $file_name;

        //nama file disimpan untuk di database dgn extention .pdf
        $namaFileDB      =  $file_name . '.pdf';



        // if ($numchar > 99) {
        //     $pesan =  createMessageInfo('Upload SIP/STR Gagal, nama file terlalu panjang. Ubah nama file kurang dari 80 karakter', 'danger');
        //     $this->session->set_flashdata('message', $pesan);
        //     $this->session->set_userdata($this->input->post());
        //     redirect('profile/my_profile');
        // }


        $path = 'sip_str';
        $uploadFile = $this->Master_model->uploadFilePDF($path, $fileNameSave, '1000');


        if ($uploadFile) {

            $this->Profile_model->insertSIPSTR($nip, $namaFileDB);
            $pesan =  createMessageInfo(' SIP/STR berhasil disimpan', 'success');
            $this->session->set_flashdata('message', $pesan);

            $this->session->unset_userdata('tanggal');
            $this->session->unset_userdata('keterangan');
            $this->session->unset_userdata('jns_dl');

            redirect('profile/my_profile');
        } else {

            redirect('profile/my_profile');
        }
    }

    function delete_sip_str($id, $file_name)
    {
        $path = 'uploads/sip_str/';


        if (file_exists($path . $file_name)) {
            unlink($path . $file_name);
        }

        $this->db->where('id', $id);
        $this->db->delete('tbl_sip_str');


        $pesan =  createMessageInfo('Data SIP/STR telah dihapus', 'success');
        $this->session->set_flashdata('message', $pesan);
        redirect('profile/my_profile');
    }

    function input_diklat()
    {

        $nama_user   =  $this->session->userdata('nama');
        $nip         =  $this->session->userdata('nip');
        $tanggal     =  $this->input->post('tanggal');

        $xplod       = explode(' ', $nama_user);
        $first_name  = $xplod[0];

        $jns_dokumen = 'diklat';

        $file_title  = $jns_dokumen . '_' . $first_name;
        $nama_file   =  $file_title;
        $nama_file  .= $_FILES['filedocs']['name'];

        $namaFileCaption = substr($nama_file, 0, -4);
        $namaFileCaption = url_title($namaFileCaption);
        $file_name       = strtolower($namaFileCaption);

        $namaFileDB      =  $file_name . '.pdf';


        $numchar         = strlen($namaFileDB);


        // if ($numchar > 99) {
        //     $pesan =  createMessageInfo('Input pelatihan gagal,  nama file terlalu panjang. Ubah nama file kurang dari 80 karakter', 'danger');
        //     $this->session->set_flashdata('message', $pesan);
        //     $this->session->set_userdata($this->input->post());
        //     #redirect('profile/my_profile' );
        // }


        $path = 'diklat';
        $uploadFile = $this->Master_model->uploadFilePDF($path, $file_name, '1000');


        if ($uploadFile) {

            $this->Profile_model->insertDiklat($nip, $namaFileDB);
            $pesan = createMessageInfo(' Input pelatihan berhasil disimpan', 'success');
            $this->session->set_flashdata('message', $pesan);

            $this->session->unset_userdata('tanggal');
            $this->session->unset_userdata('keterangan');
            $this->session->unset_userdata('jns_dl');

            redirect('profile/my_profile');
        } else {

            redirect('profile/my_profile');
        }
    }


    function update_pelatihan()
    {
        $nama_user   =  $this->session->userdata('nama');
        $nip         =  $this->session->userdata('nip');
        $change_file     =  $this->input->post('change_file');
        $id     =  $this->input->post('id');


        $this->Profile_model->updateDataDiklat($nip, $id);

        if ($change_file == 1) {


            $xplod       = explode(' ', $nama_user);
            $first_name  = $xplod[0];

            $jns_dokumen = 'diklat';

            $file_title  = $jns_dokumen . '_' . $first_name;
            $nama_file   =  $file_title;
            $nama_file  .= $_FILES['filedocs']['name'];

            $namaFileCaption = substr($nama_file, 0, -4);
            $namaFileCaption = url_title($namaFileCaption);
            $file_name       = strtolower($namaFileCaption);

            $namaFileDB      =  $file_name . '.pdf';
            $numchar         = strlen($namaFileDB);



            if ($numchar > 99) {
                $pesan =  createMessageInfo('Input pelatihan gagal,  nama file terlalu panjang. Ubah nama file kurang dari 80 karakter', 'danger');
                $this->session->set_flashdata('message', $pesan);
                $this->session->set_userdata($this->input->post());
                #redirect('profile/my_profile' );
            }


            $path = 'diklat';
            $uploadFile = $this->Master_model->uploadFilePDF($path, $file_name, '1000');


            if ($uploadFile) {

                $this->Profile_model->updateFileDiklat($id, $namaFileDB);
                $pesan = createMessageInfo(' Input pelatihan berhasil disimpan', 'success');
                $this->session->set_flashdata('message', $pesan);

                $this->session->unset_userdata('tanggal');
                $this->session->unset_userdata('keterangan');
                $this->session->unset_userdata('jns_dl');

                redirect('profile/my_profile');
            } else {

                redirect('profile/my_profile');
            }
        }
    }

    function delete_pelatihan($id, $file_name)
    {
        $path = 'uploads/diklat/';


        if (file_exists($path . $file_name)) {
            unlink($path . $file_name);
        }

        $this->db->where('id', $id);
        $this->db->delete('tbl_diklat');


        $pesan =  createMessageInfo('Data Pelatihan telah dihapus', 'success');
        $this->session->set_flashdata('message', $pesan);
        redirect('profile/my_profile');
    }
}
