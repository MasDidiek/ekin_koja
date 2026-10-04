<?php
class Template_shift_model extends CI_Model {

    public function get_all()
    {
        return $this->db->get('tbl_shift_template')->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('tbl_shift_template', ['id' => $id])->row();
    }

    public function insert_template($data)
    {
        $this->db->insert('tbl_shift_template', $data);
        return $this->db->insert_id();
    }

    public function get_detail($template_id)
    {
        $this->db->order_by('tanggal','ASC');
        $this->db->select('d.*, s.nama_shift');
        $this->db->from('tbl_shift_template_detail d');
        $this->db->join('mst_shift_kerja s', 's.id = d.shift_id');
        $this->db->where('d.template_id', $template_id);

        return $this->db->get()->result();
    }

    public function insert_detail($data)
    {
        $this->db->insert('tbl_shift_template_detail', $data);
    }

    public function get_shift()
    {
        return $this->db->get('mst_shift_kerja')->result();
    }

}