<?php


class User_model extends CI_Model {

    public $title;
    public $content;
    public $date;

    public function get_list_user()
    {
            $query = $this->db->get('mst_user', 100);
            return $query->result();
    }

    public function get_data_edit($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('mst_user');
        return $query->result();
    }


    public function insert_entry()
    {
            $this->title    = $_POST['title']; // please read the below note
            $this->content  = $_POST['content'];
            $this->date     = time();

            $this->db->insert('entries', $this);
    }

    public function update_entry()
    {
            $this->title    = $_POST['title'];
            $this->content  = $_POST['content'];
            $this->date     = time();

            $this->db->update('entries', $this, array('id' => $_POST['id']));
    }


}


?>