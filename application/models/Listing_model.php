<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Listing_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}



    function getCapaianTerkecil($periode)
    {
        $sql = "SELECT id, nama, capaian FROM ts_rekap_tkd WHERE periode = '$periode' AND capaian != 50 ORDER BY capaian ASC LIMIT 10 OFFSET 0";
        $qry = $this->db->query($sql);
        return $qry->result();
    }

    function insertListingTKD() {

     
        
    }

}


