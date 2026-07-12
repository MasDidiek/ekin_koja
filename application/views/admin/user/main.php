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

					<h1 class="h3 mb-3"><strong>User</strong> </h1>

          <div class="row">
              
              <div class="col-sm-12">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">List User Admin</h5>

                
                            <button type="button" class="btn btn-primary float-end"  data-bs-toggle="modal" data-bs-target="#modalPetugas">
                                    Tambah Petugas
                            </button>

                        
                         <table class="table table-striped">
                              <thead>
                                    <tr>
                                        <th>No</th>
                                        <th align="left">Nama</th>
                                        <th align="left">Username</th>
                                        <th align="left">Puskesmas</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                        $no = 0;
                                        for ($i=0; $i < count($user) ; $i++) { 
                                            $no = $i+1;
                                            echo ' <tr>
                                                    <td align="center">'.$no .'</td>
                                                    <td>'.$user[$i]->nama.'</td>
                                                    <td>'.$user[$i]->username.'</td>
                                                    <td>'.$user[$i]->puskesmas.'</td>
                                                    <td align="center">
                                                        <button type="button" value="'.$user[$i]->id.'" class="btn btn-sm btn-success  btn_ubah">Ubah</button>
                                                        <a href="#" class="btn btn-danger btn-sm">Hapus</a>
                                                    </td>
                                                </tr>';
                                        }
                                    ?>
                                
                                </tbody>
                          </table>


                    </div>
                  </div>
              </div>



              
                    <!-- Modal -->
                    <div class="modal fade" id="modalPetugas" tabindex="-1" aria-labelledby="modalPetugasLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                            <form action="<?= site_url('petugas/simpan'); ?>" method="post">
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

                        

           </div><!-- close row-->

				</div>
			</main>
            




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


</body>

</html>