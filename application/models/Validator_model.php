<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Validator_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		
	}


    protected $table = 'mst_validator';


    function getDataValidatorByNip($nip)
    {
        $this->db->where('nip', $nip);
        return $this->db->get($this->table)->row();
        
    }

}