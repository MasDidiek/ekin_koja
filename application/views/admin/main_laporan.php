<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('admin/master/meta');?>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <style>
                .form-input{
                    width: 100%;
                    padding: 5px 10px;
                    border: 1px solid #DDD;
                    border-radius: 5px;
                    box-sizing: border-box;
                    display: inline-block;
                    color: #666;
                }
                .form-select{
                    width: 100%;
                    padding: 5px 10px;
                    border: 1px solid #DDD;
                    border-radius: 5px;
                    box-sizing: border-box;
                    display: inline-block;
                    color: #666;
                }
        </style>

<body>
	<div class="wrapper">

    <?php $this->load->view('admin/master/navbar');?>
			<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3">Pemeriksaan Pengemudi</h1>


 <?php

                $nama_terminal        = $this->session->userdata('nama_terminal');
                $tgl_daftar = $this->session->userdata('tgl_daftar');

                if($tgl_daftar==''){
                    $tgl = date('d-m-Y');

                }else{
                    $tgl = format_view($tgl_daftar);
                }


            ?>


					<div class="row">
						<div class="col-12 col-lg-12 col-xxl-12">
							<div class="card">
								<div class="card-header">

                                    <form action="<?php echo base_url();?>admin/admin_laporan/filter_data" method="post">

                                        <label for="datepicker">Filter Data: </label><br>
                                        <input type="text" name="filter_date" class="form-input" value="<?php echo $tgl ;?>" style="width:120px" id="datepicker">

                                        <select name="nama_terminal" id="status_laik"   class="form-select"  style="width:220px">
                                            <option value="0">Semua</option>
                                            <option value="Pulogebang">Pulogebang</option>
                                            <option value="Kp.Rambutan">Kp.Rambutan</option>


                                        </select>

                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>



                                    <table class="filter-table">
                                        <tr>
                                            <td width="200">Tanggal</td>
                                            <td width="20">:</td>
                                            <td><?php echo  $tgl ;?></td>
                                        </tr>
                                        <tr>
                                            <td >Nama Terminal</td>
                                            <td>:</td>
                                            <td><?php echo  $nama_terminal  ;?></td>
                                        </tr>
                                    </table>


								</div>
								<?php
							//	print_array($laporan);

								?>
								<div class="card-body" style="max-width:100%; overflow:auto">
							    <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">No</th>
                                            <th rowspan="2">Nama</th>
                                            <th rowspan="2">Umur</th>
                                            <th rowspan="2">L/P</th>

                                            <th colspan="4">Tekanan Darah</th>
                                            <th colspan="3">GDS</th>
                                            <th colspan="3">Amphetamin Urine</th>
                                            <th colspan="4">Rekomendasi Pengemudi</th>
                                        </tr>
                                        <tr>
                                            <th>Normal</th>
                                            <th>HT Ringan</th>
                                            <th>HT Sedang</th>
                                            <th>HT Berat</th>

                                            <th>80–200</th>
                                            <th>>200 Tanpa Gejala</th>
                                            <th>>200 Dengan Gejala</th>

                                            <th>(-)</th>
                                            <th>Tdk Diperiksa</th>
                                            <th>(+)</th>

                                            <th>Laik</th>
                                            <th>Laik dgn Catatan</th>
                                            <th>Tidak Laik</th>
                                            <th>Dirujuk</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $no = 1; foreach ($laporan as $row): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $row->nama ?></td>
                                            <td></td>
                                            <td><?= $row->jns_kel ?></td>

                                            <!-- Tekanan Darah -->
                                            <td><?= $row->ht_normal ? '✔' : '' ?></td>
                                            <td><?= $row->ht_ringan ? '✔' : '' ?></td>
                                            <td><?= $row->ht_sedang ? '✔' : '' ?></td>
                                            <td><?= $row->ht_berat ? '✔' : '' ?></td>

                                            <!-- GDS -->
                                            <td><?= $row->gds_normal ? '✔' : '' ?></td>
                                            <td><?= $row->gds_tanpa_gejala ? '✔' : '' ?></td>
                                            <td><?= $row->gds_dengan_gejala ? '✔' : '' ?></td>

                                            <!-- Amphetamin -->
                                            <td><?= $row->amph_negatif ? '✔' : '' ?></td>
                                            <td><?= $row->amph_tdk_diperiksa ? '✔' : '' ?></td>
                                            <td><?= $row->amph_positif ? '✔' : '' ?></td>

                                            <!-- Rekomendasi -->
                                            <td><?= $row->laik ? '✔' : '' ?></td>
                                            <td><?= $row->laik_catatan ? '✔' : '' ?></td>
                                            <td><?= $row->tidak_laik ? '✔' : '' ?></td>
                                            <td><?= $row->dirujuk ? '✔' : '' ?></td>
                                        </tr>
                                        <?php endforeach ?>

									</tbody>
								</table>

									</div>
							</div>
						</div>

					</div>

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


<!-- Scripts below are for demo only -->
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/main.min.js?v=1628755089081"></script>
<script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

</body>


<script>



$(document).ready(function(){


  $('#dataTable').DataTable({
    "pageLength": 10
  });


  $( function() {
        $( "#datepicker" ).datepicker({
            dateFormat : "dd-mm-yy",
          changeMonth: true
        });
    } );

  $("#filter_bydatae").click(function(){
        $(this).html('loading');

        var tgl = $("#datepicker").val();


        $.ajax({
            type: "POST",
            dataType: "html",
            url: "<?php echo  base_url() . 'admin/admin_driver/create_session_date'; ?>",
            data: "tgl=" + tgl,
            success: function(msg) {
                window.location.reload();
            }
        });

    });

});

</script>
</html>