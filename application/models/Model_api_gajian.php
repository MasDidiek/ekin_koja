<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Model_api_gajian extends CI_Model
{
	function __construct()
	{
        parent::__construct();
    }
	
	
	function getDataPegawai($NIP){
		$NIP = trim($NIP);
		
		$sql = "SELECT id_pegawai, nama, nip FROM mst_pegawai WHERE nip like '$NIP%'";
		$qry = $this->db->query($sql);
		$row = $qry->result();
		
		return $row;
	}
	
	
	function getDataGajiPokok($NIP){
		$NIP = trim($NIP);
		$this->db->select('gaji_pokok, id_pegawai');
		$this->db->from('mst_pegawai');
		$this->db->where('nip',$NIP);
		$query = $this->db->get();
		$row = $query->result();
		
		return $row;
	 }
	 
	 function updateDataGajiPokok($NIP, $gaji_pokok){
		 
		 $this->db->where('nip', $NIP);
		 $this->db->set('gaji_pokok', $gaji_pokok);
		 $this->db->update('mst_pegawai');
		 return true;
	 }	
	 
	  function updateDataPerhitunganGaji($id_pegawai, $gaji_pokok, $pengali, $tkd_pokok){
		 
		 $dataArray = array(
		 		'gaji_pokok' =>$gaji_pokok,
				'pengali' =>$pengali,
				'total' =>$tkd_pokok,
		 );
		 $this->db->where('id_pegawai', $id_pegawai);
		 $this->db->update('perhitungan_tkd', $dataArray);
		 return true;
	 }	
}


?>