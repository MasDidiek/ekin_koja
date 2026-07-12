<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Master_model extends CI_Model
{



    public function getDataListMaster($table)
    {
        $qry = $this->db->get($table);
        $row = $qry->result();
        return $row;
    }


    function getNamaProvinsi($id_provinsi){
        $qry = $this->db->get_where('provinsi', array('id' => $id_provinsi));
        $row = $qry->result();
        $nama = $row[0]->nama;
        
        return $nama;
    }
    
    public function getPertanyaan($id_pertanyaan)
    {
        $qry = $this->db->get_where('mst_self_reporting', array('id' => $id_pertanyaan));
        $row = $qry->result();
        $pertanyaan = $row[0]->pertanyaan;
        
        return $pertanyaan;
    }
    
    
    function getNamaKota($id_kota){
        $qry = $this->db->get_where('kota', array('id_kota' => $id_kota));
        $row = $qry->result();
        $nama = $row[0]->nama_kota;
        
        return $nama;
    }
    
      
    function getNamaKecamatan($id_kecamatan){
        $qry = $this->db->get_where('kecamatan', array('id_kecamatan' => $id_kecamatan));
        $row = $qry->result();
        $nama = $row[0]->nama_kecamatan;
        
        return $nama;
    }
    
    
     function getNamaKelurahan($id_kelurahan){
        $qry = $this->db->get_where('mst_kelurahan', array('id_kelurahan' => $id_kelurahan));
        $row = $qry->result();
        $nama = $row[0]->nama_kelurahan;
        
        return $nama;
    }
    
    

    public function filterTanggal($tanggal)
    {
        $date = date('Y-m-d', strtotime($tanggal));
        $qry = $this->db->get_where('driver', array('tanggal' => $date));
        $row = $qry->result();
        return $row;
    }

    public function cekLoginUser( $username, $userpass)
    {
        $qry = $this->db->get_where('usermst', array('username'=> $username, 'userpass'=> $userpass));
        $row = $qry->result();
        return $row;
    }

    public function getDataEditMaster($table, $id_name, $id)
    {
        $qry = $this->db->get_where($table, array('' . $id_name . '' => $id));
        $row = $qry->result();
        return $row;
    }
}
