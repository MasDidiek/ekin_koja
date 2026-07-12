<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_user extends CI_Controller {

	public function index()
	{
		$data['user'] = $this->User_model->get_list_user();
		$this->load->view('admin/user/main', $data);
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

	public function ajax_get_dataedit()
	{
		$id = $this->input->post('id');

		$data_edit =  $this->User_model->get_data_edit($id);

		echo '
		<script>
			const checkbox = document.getElementById("ubah_password");

			const box = document.getElementById("edit_password");
			
			checkbox.addEventListener("click", function handleClick() {
			if (checkbox.checked) {
				box.style.display = "block";
			} else {
				box.style.display = "none";
			}
			});
		</script>
		';

		
		echo  '<form action="'.base_url().'admin/admin_user/update/'.$id.'" method="post">
					<label for="nama">Nama</label>
					<input type="text" name="nama" id="nama" value="'.$data_edit[0]->nama.'" class="form-input" required>

					<label for="puskesmas">Puskesmas</label>
					<input type="text" name="puskesmas"  value="'.$data_edit[0]->puskesmas.'" class="form-input" required>

					<label for="no hp">No HP</label>
					<input type="text" name="no_hp"  value="'.$data_edit[0]->no_hp.'"class="form-input" required>

					<label for="username">Username</label>
					<input type="text" name="username"  value="'.$data_edit[0]->username.'" class="form-input" required>
					<br><br>
					<input type="checkbox" name="check_ubah_password" id="ubah_password" value="1">
					<label for="ubah_password">Ubah Password</label>
					
					<div id="edit_password" style="display:none; margin-top:10px" >
						<label for="password">Password Baru</label>
						<input type="text" name="new_password" placeholder="ketikan password baru" class="form-input" required>
					</div>
				


					<br> <br>
					<button type="submit" class="btn btn-success float-right">Simpan Perubahan</button>
					<div class="clearfix"></div><br>
			</form>';
	}

	public function update($id)
	{
		$is_checked = $this->input->post('check_ubah_password');

		if($is_checked==1){
			$data = array(
				'nama' => $this->input->post('nama'),
				'puskesmas' => $this->input->post('puskesmas'),
				'no_hp' => $this->input->post('no_hp'),
				'username' => $this->input->post('username'),
				'password' => md5($this->input->post('new_password'))
	
			);
		}else{
			$data = array(
				'nama' => $this->input->post('nama'),
				'puskesmas' => $this->input->post('puskesmas'),
				'no_hp' => $this->input->post('no_hp'),
				'username' => $this->input->post('username')
	
			);
		}
		
		$this->db->where('id', $id);
		$this->db->update('mst_user', $data);
		$this->session->set_flashdata('success', 'Data user berhasil diubah');
		redirect('admin/admin_user/index');
	}

}

