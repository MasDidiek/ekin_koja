<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_petugas extends CI_Controller {

	public function index()
	{
		$data['petugas'] = $this->Petugas_model->get_all();
		$this->load->view('admin/petugas/main', $data);
	}

	public function insert()
	{
		$data = array(
			'nama' => $this->input->post('nama'),
			'puskesmas' => $this->input->post('puskesmas'),
			'no_hp' => $this->input->post('no_hp'),
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('password')),
			'userlevel' => 2

		);

		$this->db->insert('mst_user', $data);
		$this->session->set_flashdata('success', 'Data user berhasil ditambahkan');
		redirect('admin/admin_user/index');
     }

    public function simpan() {
        $data = [
            'nama'      => $this->input->post('nama', TRUE),
            'jabatan'   => $this->input->post('jabatan', TRUE),
            'puskesmas' => $this->input->post('puskesmas', TRUE),
        ];
        $this->Petugas_model->insert($data);
        redirect('admin/admin_petugas/index'); // arahkan ke halaman daftar petugas
    }

    public function get_by_id() {
        $id = $this->input->post('id');
        $data = $this->Petugas_model->get_data_edit($id);
        echo json_encode($data);
    }
    
    public function update() {
        $id = $this->input->post('id');
        $data = [
            'nama'      => $this->input->post('nama'),
            'jabatan'   => $this->input->post('jabatan'),
            'puskesmas' => $this->input->post('puskesmas'),
        ];

        if ($this->Petugas_model->update($id, $data)) {
            $this->session->set_flashdata('success', 'Data petugas berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error', 'Data petugas gagal diperbarui.');
        }

        

        redirect('admin/admin_petugas/index'); 
    }

    public function delete($id) {
      
            
        $this->db->where('id', $id);
        $this->db->delete('mst_petugas');
        $this->session->set_flashdata('success', 'Data petugas berhasil dihapus.');
       

        

        redirect('admin/admin_petugas/index'); 
    }
            

}