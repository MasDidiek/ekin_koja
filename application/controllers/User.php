<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User extends CI_Controller
{

    public function index()
    {
        
         $data['list_user'] = $this->Master_model->getDataListMaster('usermst');
         $this->load->view('admin/user', $data);
    }


    public function add_user()
    {
        
        
         $this->load->view('admin/add_user');
    }
    
    
    
     public function insert_user()
    {
        
        $nama       = $this->input->post('nama');
        $username   = $this->input->post('username');
        $puskesmas  = $this->input->post('puskesmas');
        $userlevel  = $this->input->post('userlevel');
        $password   = $this->input->post('password');
        
        $new_data = array(
                'name'=> $nama,
                'username'=> $username,
                'userpass'=> md5($password),
                'puskesmas'=> $puskesmas,
                'usertype'=> $userlevel,

                
            );

        $this->db->insert('usermst', $new_data);
        $this->session->set_flashdata('message', '<div class="alert alert-success"> Berhasil!! Data berhasil disimpan</div>');
        redirect('user/index' );
    }
    
    
    
     public function delete_user($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('usermst');

        $this->session->set_flashdata('message', '<div class="alert alert-success"> Berhasil!! Data user berhasil dihapus</div>');

       redirect('user/index' );
    }
    
  
}

?>