<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Auth extends CI_Controller
{
	public function __construct()
	{

		parent::__construct();
	   $this->load->model('Admin_cuti_model', 'acm');
	}


    function menu(){
        $data['list_menu'] = $this->Auth_model->get_menu();
        $this->load->view('auth/menu', $data);
    }

    function insert_menu(){
        $menu_level = $this->input->post('menu_level');
        $menu_name  = $this->input->post('menu_name');
        $menu_link  = $this->input->post('menu_link');

        if($menu_level==1){
            $parent_id = 0;
        }else{
            $parent_id = $this->input->post('id_parent');
        }

        $newData =[
            'menu_level' => $menu_level,
            'menu_name' => $menu_name,
            'parent_id' => $parent_id,
            'link'=> $menu_link,
            'sort_order' => $this->Auth_model->getLastSort(),
            'icon'=> ''

        ];

     
        $this->db->insert('mst_menu', $newData);
        $this->session->set_flashdata('success', 'Data berhasil disimpan');

        redirect('admin/auth/menu');

    }

    function change_sort($id, $sort='up'){
                // 1. Ambil menu sekarang
            $current = $this->db->get_where('mst_menu', ['id_menu' => $id])->row();

            if (!$current) return;

            $current_sort = $current->sort_order;




            if ($sort == 'up') {
                // 2. Cari menu yang berada tepat di atasnya
                $target = $this->db
                    ->where('sort_order <', $current_sort)
                    ->order_by('sort_order', 'DESC')
                    ->limit(1)
                    ->get('mst_menu')
                    ->row();
            } else {
                // 2. Cari menu yang berada tepat di bawahnya
                $target = $this->db
                    ->where('sort_order >', $current_sort)
                    ->order_by('sort_order', 'ASC')
                    ->limit(1)
                    ->get('mst_menu')
                    ->row();
            }

            // Jika tidak ada target (berarti sudah paling atas/bawah)
            if (!$target) return;

            // 3. Swap urutan
            $this->db->update('mst_menu', 
                ['sort_order' => $target->sort_order], 
                ['id_menu' => $id]
            );

            $this->db->update('mst_menu', 
                ['sort_order' => $current_sort], 
                ['id_menu' => $target->id_menu]
            );

        redirect('admin/auth/menu');
    }


    function usergroup(){
          $data['list_menu'] = $this->Auth_model->get_menu();
          $data['usergroup'] = $this->Auth_model->get_usergroup();

          $this->load->view('auth/usergroup', $data);

    }

    function insert_usergroup(){
           $newData =[
            'usergroup_name' => $this->input->post('usergroup_name'),
            'usergroup_menu' => '1',
        ];

     
        $this->db->insert('usergroup', $newData);
        $this->session->set_flashdata('success', 'Data usergroup berhasil disimpan');

        redirect('admin/auth/usergroup');
    }


    function insert_usergroup_menu(){
       // print_array($this->input->post());
        $id_usergroup = $this->input->post('id_usergroup');
        $id_menu = $this->input->post('id_menu');

        $menu = implode(",", $id_menu);

        $this->db->where('id', $id_usergroup);
        $this->db->set('usergroup_menu', $menu);
        $this->db->update('usergroup');

          $this->session->set_flashdata('success', 'Data usergroup berhasil disimpan');

        redirect('admin/auth/usergroup');
    }

    function usergroup_user($id_usergroup){
         $data['list_user'] = $this->Auth_model->getUserinGroup($id_usergroup);

          $this->load->view('auth/usergroup_user', $data);
    }

    function search_pegawai(){
        $keyword = $this->input->post('keyword');

        $sql = "SELECT id_pegawai, nama FROM  mst_pegawai WHERE nama like '%$keyword%' ORDER by nama ASC";
        $qry = $this->db->query($sql);
        $row = $qry->result();

        foreach ($row as $list) {
            $nama = $list->nama;
            $id_pegawai = $list->id_pegawai;

            echo '<option value="'.$id_pegawai.'">'.$nama.'</option>';
        }
    }

    function insert_user_usergroup(){

         $id_pegawai = $this->input->post('id_pegawai');  
         $usergroup_id = $this->input->post('usergroup_id');

         $this->db->where('id_pegawai', $id_pegawai);
         $this->db->set('usergroup', $usergroup_id);
         $this->db->update('mst_pegawai');

          redirect('admin/auth/usergroup_user/'.$usergroup_id);



    }
}