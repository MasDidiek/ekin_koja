<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('admin/master/meta');?>
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>
    .modal-dialog {
    max-width: 400px; /* atur sesuai kebutuhan */
}
</style>

<body>
	<div class="wrapper">
	
    <?php $this->load->view('admin/master/navbar');?>
			<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3"><strong>Petugas</strong> </h1>

                            <div class="row">
                                
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                        <h5 class="card-title">List Petugas</h5>

                                        <?php if($this->session->flashdata('success')): ?>
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i class="fa-solid fa-circle-check"></i> 
                                                <?= $this->session->flashdata('success'); ?>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        <?php endif; ?>


                                        
                                        <?php if($this->session->flashdata('error')): ?>
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <i class="fa-solid fa-triangle-exclamation"></i> 
                                                <?= $this->session->flashdata('error'); ?>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        <?php endif; ?>



                                        <button type="button" class="btn btn-primary float-end"  data-bs-toggle="modal" data-bs-target="#modalPetugas">
                                                    Tambah Petugas
                                            </button>


                                        <table class="table table-striped">
                                                <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th align="left">Nama</th>
                                                            <th align="left">Jabatan</th>
                                                            <th align="center">Puskesmas</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php
                                                            $no = 0;
                                                            for ($i=0; $i < count($petugas) ; $i++) { 
                                                                $no = $i+1;
                                                                echo ' <tr>
                                                                        <td align="center">'.$no .'</td>
                                                                        <td>'.$petugas[$i]->nama.'</td>
                                                                        <td>'.$petugas[$i]->jabatan.'</td>
                                                                        <td>'.$petugas[$i]->puskesmas.'</td>
                                                                        <td align="center">
                                                                            <button type="button" value="'.$petugas[$i]->id.'"   class="btn btn-sm btn-success  btn_ubah"  data-bs-toggle="modal" data-bs-target="#editPetugas">Ubah</button>
                                                                            <a href="'.base_url().'admin/admin_petugas/delete/'.$petugas[$i]->id.'" class="btn btn-danger btn-sm">Hapus</a>
                                                                        </td>
                                                                    </tr>';
                                                            }
                                                        ?>
                                                    
                                                    </tbody>
                                            </table>


                                        </div>
                                    </div>
                                </div>




                  </div><!-- close row-->
                      

				</div>
			</main>

            <!-- Modal -->
         <div class="modal fade" id="modalPetugas" tabindex="-1" aria-labelledby="modalPetugasLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form action="<?= site_url('admin/admin_petugas/simpan'); ?>" method="post">
                        <div class="modal-header">
                        <h5 class="modal-title" id="modalPetugasLabel">Input Data Petugas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                        <!-- Nama -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Petugas</label>
                            <input type="text" class="form-control" name="nama" id="nama" required>
                        </div>

                        <!-- Jabatan -->
                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <select class="form-select" name="jabatan" id="jabatan" required>
                            <option value="">-- Pilih Jabatan --</option>
                            <option value="Dokter">Dokter</option>
                            <option value="Perawat">Perawat</option>
                            </select>
                        </div>

                        <!-- Puskesmas -->
                        <div class="mb-3">
                            <label for="puskesmas" class="form-label">Puskesmas</label>
                            <input type="text" class="form-control" name="puskesmas" id="puskesmas" required>
                        </div>
                        </div>

                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                    </div>
            </div>
        </div>

        <div class="modal fade" id="editPetugas" tabindex="-1" aria-labelledby="editPetugasLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <form action="<?= site_url('admin/admin_petugas/update'); ?>" method="post">
                    <div class="modal-header">
                    <h5 class="modal-title" id="editPetugasLabel">Edit Data Petugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">

                    <div class="mb-3">
                        <label for="edit_nama" class="form-label">Nama Petugas</label>
                        <input type="text" class="form-control" name="nama" id="edit_nama" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_jabatan" class="form-label">Jabatan</label>
                        <select class="form-select" name="jabatan" id="edit_jabatan" required>
                        <option value="Dokter">Dokter</option>
                        <option value="Perawat">Perawat</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_puskesmas" class="form-label">Puskesmas</label>
                        <input type="text" class="form-control" name="puskesmas" id="edit_puskesmas" required>
                    </div>
                    </div>

                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    </div>
                </form>
                </div>
            </div>
            </div>


			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-start">
							<p class="mb-0">
								<a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>AdminKit</strong></a> - <a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>Bootstrap Admin Template</strong></a>								&copy;
							</p>
						</div>
						<div class="col-6 text-end">
							<ul class="list-inline">
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Support</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Help Center</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Privacy</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Terms</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>

	<script src="<?php echo base_url();?>assets/js/app.js"></script>
<!-- jQuery (wajib untuk AJAX & event handler) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Popper + Bootstrap JS (wajib untuk modal, dropdown, dll) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>


    <script>
        $(document).ready(function(){
                $('.btn_ubah').on('click', function(){
                    var id = $(this).val();

                    $.ajax({
                        url: "<?= site_url('admin/admin_petugas/get_by_id'); ?>",
                        type: "POST",
                        data: {id:id},
                        dataType: "JSON",
                        success: function(data){
                            $('#edit_id').val(data.id);
                            $('#edit_nama').val(data.nama);
                            $('#edit_jabatan').val(data.jabatan);
                            $('#edit_puskesmas').val(data.puskesmas);
                        }
                    });
                });
            });
    </script>


</body>

</html>