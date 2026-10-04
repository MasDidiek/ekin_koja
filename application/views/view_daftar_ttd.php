<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <h1>Hello, world!</h1>



                      <?php



                                $message = $this->session->flashdata('message');
                                $periode_bulan = $this->session->userdata('periode_bulan'); 
                                $periode_tahun = $this->session->userdata('periode_tahun'); 
                                $id_pkm_sess   = $this->session->userdata('id_pkm');


                                $periode = $periode_tahun.'-'.$periode_bulan;
                                $periode = date('F Y', strtotime($periode));







                        ?>



                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                ...
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                            </div>
                        </div>
                        </div>




                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                    
                                        <h4 class="header-title">Data Tanda tangan SPJ Pegawai</h4>
                                        <strong>Periode : <?php echo  $periode ;?> </strong>
                                            <?php
                                                $totalRow = count($data_tkd);

                                                if($totalRow==0){   
                                                    $totalRow = 1;
                                                }

                                           
                                                $numTTD = 0;
                                                for ($i=0; $i < count($data_tkd); $i++) { 

                                                      $ttd_spj = $data_tkd[$i]->ttd_spj;
                                                      if($ttd_spj !=''){
                                                        $numTTD =  $numTTD +1;


                                                      }


                                                }

                                                $persentage = ($numTTD/$totalRow)*100;
                                                $persentage = ceil($persentage);
                                            ?>
                                        <div id="views-min" class="apex-charts mt-2" data-colors="#0acf97"></div>

                                                                                    <!-- Success -->
                                            <div class="progress">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $persentage ;?>%" aria-valuenow="<?php echo $persentage ;?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>

                                              <h5>
                                            <?php
                                                echo  '<span class="text-warning">'.$numTTD.' </span>/ '.$totalRow .' rows &nbsp; ( '. $persentage.'%)'; 
                                            ?>

                                            </h5>




                                        <div class="table-responsive mt-3">
                                            <table class="table table-sm mb-0 table-bordered">
                                                <thead>
                                                    <tr>
                                                        
                                                            <th class="text-center">No.</th>
                                                            <th>Nama</th>
                                                            <th>Jabatan</th>
                                                            <th>NPWP</th>
                                                            <th class="text-center">Total</th>
                                                            <th class="text-center">No Handphone</th>
                                                          
                                                            <th class="text-center">TTD</th>
                                                            <th  class="text-center">Action</th>
                                                        
                                                        </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                <?php 
                                                    $case = $this->uri->segment(4);
                                                $grandTotal = 0;
                                                    $no = 1;
                                                    foreach ($data_tkd as $peg){

                                                    $nama = $peg->nama;
                                                    $nip = $peg->nip;
                                                    $jabatan = $peg->jabatan;
                                                    $npwp = $peg->npwp;


                                                    if($case=='thr'){
                                                        $total =   $peg->total;
                                                        $capaian = rupiah($total);

                                                        $grandTotal = $grandTotal +$total;
                                                    }else{
                                                        $capaian = $peg->capaian;
                                                        if($capaian < 50){
                                                            $class_text = 'text-danger ';
                                                        }else if($capaian > 50 && $capaian < 90){
                                                            $class_text = 'text-warning ';
                                                        }else if($capaian > 90 && $capaian < 98){
                                                            $class_text = 'text-info';
                                                        }else{
                                                            $class_text = 'text-success ';
                                                        }
                                                    }
                                                    

                                                    $ttd_spj = $peg->ttd_spj;
                                                  


                                                    if($ttd_spj==''){
                                                        $btn_ttd = '<span class="badge bg-danger">Belum</span>';
                                                        $no_hp = '';
                                                        $btn_reset = '';
                                                    }else{
                                                        $btn_ttd = '<img src="'.base_url().'uploads/ttd_spj/'.$ttd_spj.'" width="100">';
                                                        $no_hp = $peg->no_hp;
                                                        $btn_reset = '<a href="'.base_url().'admin/listing_tkd/reset_tdd/'.$peg->id.'" class="btn btn-sm btn-warning" onClick="return confirm(\'apakah anda ingin mereset tandatangan ini?\')">
                                                          Reset
                                                        </a>';
                                                    }
                                                        
                                                    

                                                        echo' <tr>
                                                                    <td class="text-center">'.$no.'</td>
                                                                    <td class="text-left"> '.$nama.'</td>
                                                                
                                                                    <td class="text-left">'.$jabatan.'</td>
                                                                    <td class="text-center">'.$npwp.'</td>
                                                                    <td class="text-end">'.$capaian.'</td>
                                                                
                                                                    <td class="text-center">'.$no_hp.'</td>
                                                                    <td class="text-center">'.$btn_ttd.'</td>
                                                                    <td class="text-center">'.$btn_reset.'</td>

                                                                </tr>';

                                                            $no += 1;

                                                    }

                                                    ?>

                                                    <tr>
                                                        <td>Total</td>
                                                        <td colspan="4" class="text-end fw-bold"><?php echo rupiah($grandTotal);?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            </div>



                    </div> <!-- container -->

                </div> <!-- content -->


                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Launch demo modal
                        </button>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function(){
           // alert('test');

           

        });
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>
    