<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listing Tunjangan Kinerja</title>
</head>
<body>

<?php
 $bulan = $this->session->userdata('periode_bulan');
 $tahun = $this->session->userdata('periode_tahun');
 $periode = $tahun.'-'.$bulan;
 $periode = date('Y-m', strtotime($periode));

 $nm_bulan = getBulan($bulan);


?>


<div class="col-xxl-12col-lg-12">
                                <div class="card widget-flat">
                                    <div class="card-body text-left">
                                        <h4>Data Pegawai Non PNS</h4>
                                        <br>



                                        <table id="datatable-buttons" class="table table-sm dt-responsive nowrap w-100">
                                                <thead class="bg-light">
                                                      <tr>

                                                         <th data-sort="no">No</th>


                                                          <th  data-sort="nama_pegawai">Nama Pegawai</th>

                                                          <th  data-sort="jabatan">Jabatan</th>
                                                          <th>NPWP</th>
                                                          <th  data-sort="tkd_pokok">TKD Pokok</th>
                                                          <th  data-sort="capaian">Capaian</th>
                                                          <th  data-sort="bruto">Bruto</th>
                                                          <th  data-sort="pph21">Pajak</th>
                                                          <th  data-sort="bpjs">BPJS</th>
                                                          <th  data-sort="bpjs_tk">BPJS TK</th>
                                                          <th  data-sort="thp">THP</th>
                                                          <th  data-sort="norek">No Rekening</th>
                                                        
                                                      </tr>
                                                  </thead>
                                                  <tbody class="list form-check-all">
                                                  <?php

                                                         $total_bruto = 0;
                                                         $total_pajak = 0;
                                                         $total_bpjs = 0;
                                                         $total_bpjs_tk = 0;
                                                         $total_thp = 0;

                                                          $no = 1;
                                                          foreach ($listing_tkd as $peg){

                                                          $nama = $peg->nama;
                                                          $nip = $peg->nip;
                                                          $jabatan = $peg->jabatan;

                                                          $id_pegawai = $this->Pegawai_model->cekData($nip);


                                                          $capaian = $peg->capaian;
                                                          if($capaian < 50){
                                                              $class_text = 'text-danger ';
                                                          }else if($capaian > 50 && $capaian < 90){
                                                              $class_text = 'text-warning ';
                                                          }else if($capaian > 90 && $capaian < 98){
                                                              $class_text = 'text-info ';
                                                          }else{
                                                              $class_text = 'text-success ';
                                                          }

                                                          $status = $peg->status;

                                                          if($status==0){
                                                             $flag_status = '<span class="badge badge-warning-lighten">Belum sesuai</span>';
                                                             $btn_check = '<a href="'.base_url().'admin/listing_tkd/cekSesuai/'.$peg->id.'" class="text-info float-end"> <i class="mdi mdi-account-edit me-1"></i></a>';

                                                          }else{
                                                              $flag_status = '<span class="badge badge-success-lighten">Sesuai</span>';
                                                               $btn_check = '';
                                                          }

                                                             $total_bruto = $total_bruto+$peg->bruto;
                                                             $total_pajak = $total_pajak+$peg->pph21;
                                                             $total_bpjs = $total_bpjs+$peg->bpjs;
                                                             $total_bpjs_tk = $total_bpjs_tk+$peg->bpjs_tk;
                                                             $total_thp = $total_thp+$peg->thp;

                                                              echo' <tr>
                                                                      <td class="text-center ">'.$no.'</td>
                                                                      <td class="text-left  nama_pegawai"> '.$peg->nama.' </td>

                                                                      <td class=" jabatan">'.$jabatan.'</td>
                                                                      <td class="text-center">'.$peg->npwp.'</td>
                                                                      <td class="text-center  tkd_pokok">'.$peg->tkd_pokok.'</td>
                                                                      <td class="text-center  '.$class_text.' capaian">
                                                                       <strong>'.$peg->capaian.'</strong>  </td>
                                                                      <td class="text-center">'.$peg->bruto.'</td>
                                                                      <td class="text-center">'.$peg->pph21.'</td>
                                                                      <td class="text-center">'.$peg->bpjs.'</td>
                                                                      <td class="text-center">'.$peg->bpjs_tk.'</td>
                                                                      <td class="text-center"> <strong>'.$peg->thp.'</strong></td>
                                                                      <td class="text-center">'.$peg->no_rekening.'</td>
                                                                     

                                                                      </tr>';

                                                                  $no += 1;

                                                          }

                                                       ?>

                                              
                                                       
                                                  </tbody>

                                                    <tr>
                                                        <th>Total</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th><?php echo rupiah($total_bruto);?></th>
                                                        <th><?php echo rupiah($total_pajak);?></th>
                                                        <th><?php echo rupiah($total_bpjs);?></th>
                                                        <th><?php echo rupiah($total_bpjs_tk);?></th>
                                                        <th><?php echo rupiah($total_thp);?></th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                    
                                              </table>





                                    </div>
                                </div>
                            </div> <!-- end col-->
    
</body>
</html>