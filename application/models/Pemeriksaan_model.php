<?php


class Pemeriksaan_model extends CI_Model {

    public $title;
    public $content;
    public $date;

    public function getDataPemeriksaan($tgl, $status_ht=0, $status_gds=0, $status_laik=0)
    {      
          
           if($status_ht == 0){
                $and_ht = '';
           }else{
                $and_ht = " AND status_ht = $status_ht";
           }

           
           if($status_gds == 0){
                $and_gds = '';
            }else{
                $and_gds = " AND status_gds = $status_gds";
            }

            
            if($status_laik == 0){
                $and_laik = '';
            }else{
                $and_laik = " AND status_laik = $status_laik";
            }


    //       $sql = "SELECT a.*, b.nama, b.tgl_lahir, b.jns_kel, b.nama_po
    //   FROM ts_pemeriksaan  a
    //   LEFT JOIN mst_driver  b ON a.id_driver =  b. id WHERE date_time like '$tgl%' 
    //       $and_ht  $and_gds $and_laik";
    
    
    
        
          $sql = "SELECT a.*, b.nama, b.tgl_lahir, b.jns_kel, b.nama_po
          FROM ts_pemeriksaan  a
          LEFT JOIN mst_driver  b ON a.id_driver =  b. id ORDER BY id DESC";
    
    
           $qry = $this->db->query($sql);
           $row = $qry->result();
           
  

           return $row;
    }

}