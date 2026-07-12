<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$this->load->view('admin/login');
	}


    function do_login(){
        $username = $this->input->post('username');
        $userpass = $this->input->post('password');

        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/login');
        } else {
			
                
                $mdPass= md5($userpass);
                
                $qry = $this->db->get_where('mst_user', array('username'=> $username, 'password'=> $mdPass));
                $cekDataLogin = $qry->result();
                
                if(!empty($cekDataLogin)){
                    $new_session = array(
                            'id_user' => $cekDataLogin[0]->id,
                            'nama'=> $cekDataLogin[0]->nama,
                            'no_hp'=> $cekDataLogin[0]->no_hp,
                            'puskesmas'=> $cekDataLogin[0]->puskesmas
                        );
                        
                    $this->session->set_userdata($new_session);
                    redirect('admin/home/index');
                        
                }else{
                    
                    $this->session->set_flashdata('error_login', '<div class="alert alert-danger" role="alert">
                <a href="#!" class="alert-link">Error </a>. NIP atau Password salah.
            </div>');
                    redirect('admin/login/index');
                }
            }
        
    }

    public function logout()
    {
        $this->session->sess_destroy();
        
        redirect('admin/login/index');
    }
    
    function test(){
        echo 'tes login';
    }
}

