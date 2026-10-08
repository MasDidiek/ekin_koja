<?php ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');
class Shift_model extends CI_Model
{
	function __construct()
	{
        parent::__construct();
		
    }
	
	function getDataMasterShift()
	{
		
		$this->db->select('*');
		$this->db->from('mst_shift_kerja');
		$this->db->where('flag', 1);
		$this->db->order_by('shift', 'ASC');		
		$query = $this->db->get();
		$row = $query->result();
		
		return $row;
		
	}
	function getDataShiftPegawai($bulan_tahun)
	{
		$this->db->select('*');
		$this->db->from('ts_shift_kerja');
		$this->db->where('bulan_tahun', $bulan_tahun);
		$this->db->group_by('id_pegawai');		
		$query = $this->db->get();
		$row = $query->result();
		
		return $row;
		
	}
	
	function getDetailShift($id_shift)
	{
		$sql = "SELECT a.id, tanggal, a.bulan_tahun, b.name AS shift 
		FROM ts_shift_kerja a LEFT JOIN mst_shift_kerja b ON a.shift=b.shift
		WHERE a.id = $id_shift";
		$qry =$this->db->query($sql);
		$row = $qry->result();
		
		return $row;
	}
	
	function getDataShiftPerPegawai($id_pegawai, $bulan_tahun)
	{
		
		$sql = "SELECT a.id, tanggal, b.name AS shift, b.jam_masuk, jam_pulang, keterangan
		FROM ts_shift_kerja a LEFT JOIN mst_shift_kerja b ON a.shift=b.shift
		WHERE id_pegawai = $id_pegawai AND bulan_tahun = '$bulan_tahun' GROUP BY tanggal ORDER BY tanggal ASC";
		$qry =$this->db->query($sql);
		$row = $qry->result();
		
		return $row;
		
	}
	
	function getShiftPerhari($id_pegawai, $tgl, $bulan_tahun){
		
		$sql = "SELECT a.id, tanggal, b.name AS shift 
		FROM ts_shift_kerja a 
		LEFT JOIN mst_shift_kerja b ON a.shift=b.shift
		WHERE id_pegawai = $id_pegawai AND bulan_tahun = '$bulan_tahun' AND tanggal = $tgl";
			
		$qry =$this->db->query($sql);
		$row = $qry->result();
		
		if(!empty($row)){
			$shift = $row[0]->shift;
		}else{
			$shift = '-';
		}
		
		return $shift;
		
	}
	
	
	function insertDataShift()
	{
		
		$data = array(
			'shift' => $this->input->post('shift_id'),
			'name' => $this->input->post('shift_name'),
			'jam_masuk' => $this->input->post('jam_masuk'),
			'jam_pulang' => $this->input->post('jam_pulang'),
			'keterangan' => $this->input->post('keterangan')
		);
		
		$this->db->insert('mst_shift_kerja', $data);
		
		return true;
		
	}


	function getShiftTemplate(){
		$this->db->order_by('id', 'ASC');
		$this->db->from('tbl_shift_template');
		$query = $this->db->get();
		$row = $query->result();
		
		return $row;
	}

	function getShiftTemplateByID($id){
		$this->db->where('id', $id);
		$this->db->from('tbl_shift_template');
		$query = $this->db->get();
		$row = $query->row();
		return $row;
	}

	function getDetailShiftTemplate($id_template){
		$this->db->order_by('tanggal', 'ASC');
		$this->db->select('tbl_shift_template_detail.*, mst_shift_kerja.kode_shift');
		$this->db->where('template_id', $id_template);
		$this->db->from('tbl_shift_template_detail');
		$this->db->join('mst_shift_kerja', 'mst_shift_kerja.id = tbl_shift_template_detail.shift_id', 'left');
		$query = $this->db->get();
		$row = $query->result();
		return $row;
	}

	


	 
	  function deleteData($tgl, $id_pegawai)
	 {
			$sql = "DELETE FROM jadwal_shift WHERE tgl ='$tgl' AND id_pegawai = $id_pegawai";			
			$qry = $this->db->query($sql);
			
			return true;
	 }
	 
	 
	 function insertData($tgl, $id_pegawai, $jns, $shift, $shift_name)
	 {
			
			$array = array(
					'id_pegawai'=>$id_pegawai,
					'jns' =>$jns,
					'tgl' => $tgl,
					'shift' =>$shift,
					'shift_name' =>$shift_name
					
			);
			
			$this->db->insert('jadwal_shift', $array);
			
			return true;
	 }
	 
	 function getDataShift($tgl, $jns)
	 {
		 
		 $sql  = "SELECT * FROM jadwal_shift WHERE tgl like '$tgl%' AND jns = $jns GROUP BY id_pegawai";
		 $qry = $this->db->query($sql);
		 $row = $qry->result();
		 
		 return $row;
		 
		 
	 }
	 
	 
	 
	 
}
?>
