<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Admin extends CI_Controller
{

    public function index()
    {

    
        $this->load->view('admin/login');
    }

    public function login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $userpass = md5($password);
        $user = $this->Master_model->cekLoginUser($username, $userpass);

        if (!empty($user)) {
            $new_array = array(
                'id_user' => $user[0]->id,
                'nama_user' => $user[0]->name,
                'puskesmas' => $user[0]->puskesmas,
                'userlevel' => $user[0]->usertype
            );

            $this->session->set_userdata($new_array);
            redirect('admin/dashboard');
        } else {
            $this->session->set_flashdata('error_login', '<div class="alert alert-danger"> <strong>Login Gagal!!</strong> Username atau password salah</div>');
            redirect('admin/index');
        }
        //redirect('home/skrining_pasien');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('admin/index');
    }

    function dashboard()
    {
        $id_user = $this->session->userdata('id_user');
        if($id_user==''){
            redirect('admin/index'); 
        }
        $data['list_catin'] = $this->Master_model->getDataListMaster('mst_calon_pengantin');
        $this->load->view('admin/dashboard', $data);
    }

   
}
