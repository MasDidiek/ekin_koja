<?php


class Petugas_model extends CI_Model {
    private $table = 'mst_petugas';

   

    public function get_data_edit($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }


 

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function get_all() {
        return $this->db->get($this->table)->result();
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }



}


?>