<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('admin/master/meta');?>
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


<body>
	<div class="wrapper">
	
    <?php $this->load->view('admin/master/navbar');?>
			<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3"><strong>Dashboard</strong> </h1>

          <div class="row">
              

              <div class="col-sm-4">
                  <div class="card">
                    <div class="card-body">
                         <div class="row">
                              <div class="col mt-0">
                                <h5 class="card-title">Pemeriksaan Darah</h5>
                              </div>

                          </div>
                           
                          <table class="table  table-borderless">
                            <tr>
                              <td> 
                                <div class=" text-warning">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                </div>
                              </td>
                              <td>Tekanan Darah Tinggi</td>
                              <th><?php echo count($driverHtTinggi);?></th>
                            </tr>
                            <tr>
                              <td>
                                <div class="text-danger">
                                  <i class="fa-solid fa-circle-exclamation"></i>
                                </div>
                              </td>
                              <td>GDS Tinggi</td>
                              <th>5</th>
                            </tr>
                            
                          </table>
                              
                    </div>
                  </div>
              </div>

              <div class="col-sm-4">
                  <div class="card">
                    <div class="card-body">
                         <div class="row">
                              <div class="col mt-0">
                                <h5 class="card-title">Pemeriksaan Alkohol dan Psikotropika</h5>
                              </div>

                          </div>
                          
                          <table class="table  table-borderless">
                            <tr>
                              <td> 
                                <div class="text-info">
                                <i class="fa-solid fa-wine-bottle"></i> 

                                </div>
                              </td>
                              <td>Positive Alkohol</td>
                              <th>5</th>
                            </tr>
                            <tr>
                              <td>
                                <div class="text-warning">
                                <i class="fa-solid fa-capsules"></i> <!-- beberapa kapsul -->
                                </div>
                              </td>
                              <td>Positive Ampetamine </td>
                              <th>5</th>
                            </tr>
                            
                          </table>
                              
                      </div>
                  </div>
              </div>
              <div class="col-sm-4">
                  <div class="card">
                    <div class="card-body">
                       <h5 class="card-title">Jumlah Pengemudi</h5>
                       <table class="table table-borderless">
                            <tr>
                              <td> 
                              <div class=" text-danger">
                                  <i class="fa-solid fa-circle-exclamation"></i>
                                </div>
                              </td>
                              <td>Belum diperiksa</td>
                              <th class="text-end"  > <a href="<?php echo base_url();?>admin/admin_driver/index" class="fs-5"><?php echo $numDriverBlmDiperiksa;?></a></th>
                            </tr>
                            <tr>
                              <td>
                                <div class="text-primary">
                                <i class="fa-solid fa-users"></i> <!-- beberapa kapsul -->
                                </div>
                              </td>
                              <td>Total    Pengemudi </td>
                              <th  class="text-end"  >
                                 <a href="<?php echo base_url();?>admin/admin_driver/index" class="fs-5"><?php echo $numDriver;?></a> </th>
                            </tr>
                            
                          </table>

                    </div>
                  </div>
              </div>







              <div class="col-sm-4">
                  <div class="card">
                    <div class="card-body">
                         <div class="row">
                              <div class="col mt-0">
                                <h5 class="card-title">Kelaikan Mengemudi</h5>
                              </div>

                          </div>

                          <div class="table-responsive">

                         
                              <table class="table  table-borderless">
                                <tr>
                                  <td> 
                                    <div class="text-success">
                                      <i class="fa-solid fa-thumbs-up"></i>

                                    </div>
                                  </td>
                                  <td>Laik Mengemudi</td>
                                  <th><?php echo $DriverLaik;?></th>
                                </tr>
                                <tr>
                                  <td>
                                    <div class=" text-danger">
                                      <i class="fa-solid fa-circle-xmark"></i>

                                    
                                    </div>
                                  </td>
                                  <td>Tidak Laik Mengemudi</td>
                                  <th><?php echo $DriverTdkLaik;?></th>
                                </tr>
                                <tr>
                                  <td>
                                    <div class="text-warning">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    </div>
                                  </td>
                                  <td>Laik Mengemudi dgn Catatan</td>
                                  <th><?php echo $DriverLaikCttn;?></th>
                                </tr>
                              </table>
                          </div>
                           
                              
                    </div>
                  </div>
              </div>
              <div class="col-sm-8">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Driver Belum Diperiksa</h5>

                      <table class="table table-striped">
                              <thead>
                                  <tr>
                                      <th>No</th>
                                      <th>Nama</th>
                                      <th>No KTP</th>
                                      <th>PO</th>
                                      <th>Status Supir</th>
                                      <th>Tgl Daftar</th>
                                      <th>Action</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php $no=1; foreach($DriverBlmDiperiksa as $d): ?>
                                  <tr>
                                      <td><?= $no++; ?></td>
                                      <td><?= $d->nama; ?></td>
                                      <td><?= $d->no_ktp; ?></td>

                                      <td><?= $d->nama_po; ?></td>
                                      <td><?= $d->status_supir; ?></td>
                                      <td><?= $d->tgl_daftar; ?></td>
                                      <td>
                                        <a href="<?php echo base_url();?>admin/admin_driver/periksa/<?= $d->id; ?>" class="btn btn-sm btn-primary"> <i class="fa-solid fa-pencil"></i> Periksa</a>
                                       </td>
                                  </tr>
                                  <?php endforeach; ?>
                              </tbody>
                          </table>


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