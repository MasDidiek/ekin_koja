<?php


class Driver_model extends CI_Model {

    public $title;
    public $content;
    public $date;




    function countDriver(){
        $this->db->select('id');
        $query = $this->db->get('mst_driver');
        $num   = $query->num_rows();
        return $num;

    }

    function countDriverBlmDiperiksa(){
        $this->db->select('COUNT(m.id) as jml_belum');
        $this->db->from('mst_driver m');
        $this->db->join('ts_pemeriksaan p', 'p.id_driver = m.id', 'left');
        $this->db->where('p.id_driver IS NULL');
        $query = $this->db->get();

        $result = $query->row();
        return  $result->jml_belum;
    }


    function countDriverByStatusLaik($status_laik){
        $this->db->select('id');
        $this->db->where('status_laik', $status_laik);
        $query = $this->db->get('ts_pemeriksaan');
        $num   = $query->num_rows();
        return $num;

    }

    function getDriverBlmDiperiksa(){
        $this->db->select('m.id, m.nama, m.no_ktp, m.no_hp, m.nama_po, m.status_supir, m.tgl_daftar');
        $this->db->from('mst_driver m');
        $this->db->join('ts_pemeriksaan p', 'p.id_driver = m.id', 'left');
        $this->db->where('p.id_driver IS NULL');
        $query = $this->db->get();

        $drivers = $query->result();

        return $drivers;

    }

 

    public function cek_ktp($no_ktp) {
        return $this->db->get_where('mst_driver', ['no_ktp' => $no_ktp])->row();
    }

    public function getAllDriver()
    {      
            $this->db->order_by('id', 'DESC');
            $this->db->select('mst_driver.*, mst_user.nama AS petugas');
            $this->db->from('mst_driver');
            $this->db->join('mst_user', 'mst_driver.id_petugas = mst_user.id', 'left');
            $query = $this->db->get();

            return $query->result();
    }
    
    public function get_list_driver($tgl_daftar)
    {      
            $this->db->select('mst_driver.*, mst_user.nama AS petugas');
            $this->db->where('tgl_daftar', $tgl_daftar);
            $this->db->from('mst_driver');
            $this->db->join('mst_user', 'mst_driver.id_petugas = mst_user.id', 'left');
            $query = $this->db->get();

            return $query->result();
    }

    public function get_data_edit($id)
    {
        // $this->db->where('id', $id);
        // $query = $this->db->get('mst_driver');

        $this->db->select('mst_driver.*, mst_user.nama AS petugas');
        $this->db->where('mst_driver.id', $id);
        $this->db->from('mst_driver');
        $this->db->join('mst_user', 'mst_driver.id_petugas = mst_user.id', 'left');
        $query = $this->db->get();


        return $query->result();
    }

    public function getHistoryPemeriksaanPengemudi($id_driver)
    {
        
        $this->db->select('ts_pemeriksaan.*, mst_user.nama AS petugas');
        $this->db->where('ts_pemeriksaan.id_driver', $id_driver);
        $this->db->from('ts_pemeriksaan');
        $this->db->join('mst_user', 'mst_user.id = ts_pemeriksaan.id_petugas', 'left');
        $query = $this->db->get();


        return $query->result();
    }

    
    public function get_detail_pemeriksaan($id)
    {
         
        $this->db->select('ts_pemeriksaan.*, mst_user.nama AS petugas');
        $this->db->where('ts_pemeriksaan.id', $id);
        $this->db->from('ts_pemeriksaan');
        $this->db->join('mst_user', 'mst_user.id = ts_pemeriksaan.id_petugas', 'left');
        $query = $this->db->get();

        return $query->result();
    }

    function getDataEditPemeriksaan($id_pemeriksaan){
        $this->db->where('id', $id_pemeriksaan);
        $query = $this->db->get('ts_pemeriksaan');
        return $query->result();
    }

    function getDataPemeriksaan($id_pemeriksaan, $table){
         $this->db->where('id_pemeriksaan', $id_pemeriksaan);
         $query = $this->db->get($table);
         return $query->result();
    }

    public function getlastIDPemeriksaan()
    {
        $this->db->order_by('id', 'DESC');
         $query = $this->db->get('ts_pemeriksaan', 1,0);
         $row   = $query->result();
         $id    = $row[0]->id;
         return $id;
    }

    function insertRujukan($id_pemeriksaan){
        
		$data_rujukan = array(
            'id_pemeriksaan' => $id_pemeriksaan,
			'id_driver' => $this->session->userdata('id_driver_rujuk'),
			'umur' => $this->session->userdata('umur'),
            'tujuan_rujuk' => $this->session->userdata('yth'),
			'catatan' => $this->session->userdata('catatan'),
			'id_petugas' =>  $this->session->userdata('id_user'),
			'date_create' => date('Y-m-d H:i:s')
		);

		$this->db->insert('tbl_rujukan', $data_rujukan);

        return true;
    }

    function getDataRujukan($id_pemeriksaan){
        $this->db->where('id_pemeriksaan', $id_pemeriksaan);
        $query = $this->db->get('tbl_rujukan');
        return $query->result();

    }
    
    



}


?>