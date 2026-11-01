<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model');
     //   header("Content-Security-Policy: default-src 'self'; script-src 'self'; object-src 'none'; base-uri 'self';");
	}


	function index()
	{


		
        // optional: batasi hanya IP internal
        if (strpos($_SERVER['REMOTE_ADDR'], '10.') !== 0) {
            exit('Access denied');
        }

        $raw = file_get_contents("php://input");

        if (empty($raw)) {
            echo "OK";
            exit;
        }

        $rows = explode("\n", trim($raw));

        foreach ($rows as $row) {

            $col = explode("\t", trim($row));

            if (count($col) >= 2) {

                $data = [
                    'pin' => $col[0],
                    'datetime_log' => $col[1],
                    'status' => isset($col[2]) ? $col[2] : 0,
                    'verify' => isset($col[3]) ? $col[3] : NULL,
                    'workcode' => isset($col[4]) ? $col[4] : NULL
                ];

                $this->db->insert('tbl_log_mesin', $data);
            }
        }

        echo "OK";
	}

	function login()
	{

    

		//$this->load->view('login_page');
		$this->load->view('auth/login_page');
	}

	function login_process() {

		$nip = $this->input->post('idpegawai');
		$password = trim($this->input->post('password'));

        $this->load->library('form_validation');
        $this->form_validation->set_rules('idpegawai', 'NIP/NRK', 'required|numeric');

		$user = $this->Pegawai_model->get_by_nip($nip);
		if ($user && password_verify($password, $user->password)) {

			//Simpan data user ke session
			$this->session->set_userdata([
				'id_pegawai' => $user->id_pegawai,
				'nip' => $user->nip,
				'nama' => $user->nama,
				'nrk' => $user->nrk,
				'id_puskesmas' => $user->id_puskesmas,
                'jns_pegawai' => $user->jns_pegawai,
				'usergroup' => $user->usergroup,
                'klaster' => $user->klaster,
				'logged_in' => true

			]);


			redirect('dashboard'); // Ganti dengan controller tujuan
		} else {
			$this->session->set_flashdata('nip', $nip);
			$this->session->set_flashdata('error', 'NIP atau Password salah');
			redirect('auth/login');
		}

	}


	function reset_password()
	{


		//$this->load->view('login_page');
		$this->load->view('auth/reset_password');
	}
	function reset_password_process(){

        #print_array($this->input->post());
      //  $id_pegawai    = $this->session->userdata('id_pegawai');
	    $nip = $this->input->post('nip');
	//	$default_password = 'PKC2025@Cilincing';
	//	$md5 = md5($default_password);


		$old_password  = $this->input->post('old_password');
		$md5 = md5($old_password);
		$raw_pass = 'bd1e8429efd1b289f7634ea118469a7a';

		if($md5 === $raw_pass){
                $new_password  = $this->input->post('new_password');
                $confirm_password = $this->input->post('confirm_password');

                $this->load->library('form_validation');
                $config = array(
                    array(
                        'field'   => 'nip',
                        'label'   => 'NIP',
                        'rules'   => 'trim|required|callback_userexist_check'
                    ),
                    array(
                        'field'   => 'new_password',
                        'label'   => 'Password',
                        'rules'   => 'trim|required|min_length[8]|max_length[25]|callback_password_check'
                    ),
                    array(
                        'field'   => 'conf_password',
                        'label'   => 'Confirm Password',
                        'rules'   => 'trim|required|matches[new_password]'
                    ));


                    $this->form_validation->set_rules($config );
                    if ($this->form_validation->run() == FALSE)
                    {

                        #print_array($this->input->post());
                        // $data['pegawai']   =  $this->Pegawai_model->getDetailPegawai($id_pegawai);
                        $this->load->view('auth/reset_password');

                    } else {

                        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                        $this->db->where('nip', $nip);
                        $this->db->set('password', $hashed_password);
                        $this->db->update('mst_pegawai');

                        $this->session->set_flashdata('message_status', 200);

                        redirect('auth/success_reset_password');

                    }
		}else{
		   $this->session->set_flashdata('message_status', 202);
		   $this->session->set_flashdata('message_error', 'Gagal reset password!! Password lama tidak sesuai');
		   redirect('auth/reset_password');
		}




    }


	public function password_check($str)
    {

        if (preg_match('~[0-9]+~', $str)) {
            if(preg_match('/[A-Z]/', $str)){


                    if(preg_match('/[^a-zA-Z0-9]/', $str) > 0)
                    {
                        return true;
                    }else{
                        $this->form_validation->set_message('password_check', ' {field} harus berisi minimal 1 special karakter [@...&]');
                        return FALSE;
                    }


            }else{
                $this->form_validation->set_message('password_check', ' {field} harus berisi minimal 1 huruf besar [A-Z]');
                return FALSE;
            }

        }else{
            $this->form_validation->set_message('password_check', ' {field} harus berisi minimal 1 angka [0-9]');
            return FALSE;
        }


    }

	function userexist_check($nip) {



        if($nip ==''){
            $this->form_validation->set_message('userexist_check', ' {field} harus diisi ');
            return FALSE;
        }else{

            $cekAuth    = $this->Auth_model->cekDataPegawai($nip);

            if(empty($cekAuth)){
                $this->form_validation->set_message('userexist_check', ' {field} tidak terdaftar ');
                return FALSE;
            }else{
                return TRUE;
            }
        }



    }

	function success_reset_password() {
		$this->load->view('auth/success_reset_password');
	}


}

?>
