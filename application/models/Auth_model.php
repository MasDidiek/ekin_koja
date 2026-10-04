<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Auth_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

    
	function cekUserAuth($nip, $pass)
	{
	
        $nip_leght = strlen($nip);
        if($nip_leght < 10){
            //menggunakan NRK
            $qry = $this->db->get_where('mst_pegawai', array('nrk'=> $nip, 'password'=> $pass));
        }else{
            //pake NIP 
            
            $thn_angg = '2024';
            #echo 'pake nip';
            $this->db->limit(3,0);
            #$this->db->order_by('tahun_anggaran','DESC');
            $qry = $this->db->get_where('mst_pegawai', array('nip'=> $nip, 'password'=> $pass, 'tahun_anggaran'=> $thn_angg));
        }
		
		$row = $qry->result();

    
		return $row;
	}

    function cekAuthMenu($usergroup_id, $menu_id){
        $qry = $this->db->get_where('tbl_hak_akses', array('usergroup_id'=> $usergroup_id, 'id_menu'=> $menu_id));
        $row = $qry->num_rows();

        if($row==0){
            return false;
        }else{
            return true;
        }

    }


    function  cekAuthLogin(){
        //cek apakah sudah habis sessionya
        $id_pegawai = $this->session->userdata('id_pegawai');

        if($id_pegawai==''){
            $getUri = $this->uri->uri_string();

            $this->session->set_userdata('uri_login', $getUri);
            redirect('login/index');
            
        }
    }

    function updatePassword($new_pass){
        $id_pegawai = $this->session->userdata('id_pegawai');
        $this->db->where('id_pegawai', $id_pegawai);
        $this->db->set('password', $new_pass);
        $this->db->update('mst_pegawai');
        return true;

    }

}