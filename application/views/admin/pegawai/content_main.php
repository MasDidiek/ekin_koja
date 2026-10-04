<div class="page-header d-print-none">
    <div class="container-fluid">
            <div class="row g-2 align-items-center">
                 
                <div class="page-pretitle">
                    Setting
                </div>
            <h3 class="card-title"> Menu</h3>

            </div>
    </div>
</div>

    <!-- Page body -->
<div class="page-body">
    <div class="container-fluid">
         <div class="row row-deck row-cards">
             <div class="col-12">
                <div class="card">
                    <div class="card-header">Datalist Pegawai </div>
                       <div class="card-body">


                     
                        <a href="#" class="btn btn-primary mb-4 float-end " data-bs-toggle="modal" data-bs-target="#modal-report"><i class="fa-solid fa-plus"></i>&nbsp;   Add New </a>
                          
                            <div class="clearfix"></div>


                                <div class="table-responsive">
                                        <table class="table table-bordered table-striped"  id="data-table">
                                            <thead>
                                                <tr>
                                                
                                                <th class="w-1">No.</th>
                                                <th>Photo</th>
                                                <th>TMT</th>
                                                <th>NIP</th>
                                                <th>Nama</th>
                                                <th>Jabatan</th>
                                                <th>Puskesmas</th>
                                                <th>Status </th>
                                            
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 

                                                    $no = 1;
                                                    foreach ($pegawai as $peg){
                                                        $nip = $peg->nip;
                                                        $id_pegawai = $peg->id_pegawai;
                                                        $id_jabatan = $peg->id_jabatan;
                                                        $tmt = $peg->tgl_masuk;
                                                        $id_puskesmas = $peg->id_puskesmas;
                                                        
                            
                                                        echo' <tr>
                                                                    <td>'.$no.' </td>
                                                                    <td>'.$peg->status_kerja.'</td>
                                                                    <td class="text-center">'.format_semi($tmt).'</td>
                                                                    <td class="text-center"> '.$peg->nip.'</td>
                                                                    <td><a href="'.PEGAWAI.'detail_pegawai/'.$id_pegawai.'/'.$nip.'">'.$peg->nama.'</a></td>
                                                                    <td>'.$peg->jabatan.' </td>
                                                                    <td>'.$peg->puskesmas.' </td>
                                                    
                                                                    <td class="text-center"> </td>
                                                                
                                                                    
                                                                </tr>';

                                                                $no += 1;

                                                    }


                                            ?>
                                            

                                            

                                            
                                            
                                            </tbody>
                                    </table>
                            </div><!--table-responsive-->

                    

                     </div>
                </div><!--card body-->
            </div>
          </div>  
    </div>
</div>
