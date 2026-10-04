<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Old_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
        #$this->db = $this->load->database('db_penggajian', true); //database e-absensi
	}



    
    function detail_pegawai($nip){
        $qry = $this->db->get_where('mst_pegawai_detail', array('nip'=> $nip));
        $row = $qry->result();

        return $row;

    }

     
    function mst_pegawai($nip){
        $qry = $this->db->get_where('mst_pegawai', array('nip'=> $nip, 'tahun_anggaran'=> 2023));
        $row = $qry->result();

        return $row;

    }





}