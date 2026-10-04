   <?php
                                     $no = 0;
                                   
                                         foreach ($pengajuanCuti as $cuti) {
                                                $status = $cuti->status;
                                                $hari_cuti = $cuti->hari_cuti;
                                                $jns_cuti = $cuti->jns_cuti;

                                                $id = $cuti->id;
                                                
                                                if ($status=='PEND0') {
                                                    $flag_status = '<span class="badge badge-warning-lighten">ACC Pengganti</span>';
                                                }else if($status=='PEND1'){
                                                    $flag_status = '<span class="badge badge-info-lighten">ACC Kapustu</span>';
                                                }else if($status=='PEND2'){
                                                    $flag_status = '<span class="badge badge-success-lighten">ACC KTU</span>';
                                                }else{
                                                    $flag_status = '-';
                                                }



                                                if($hari_cuti==1){
                                                    $waktu_cuti =  '<strong> '. format_hari($cuti->tgl_dari).', '.format_view($cuti->tgl_dari).'</strong>';
                                                }else{
                                                    $waktu_cuti = '<strong> '. format_hari($cuti->tgl_dari).', '.format_view($cuti->tgl_dari).'</strong> s/d <strong> '.format_hari($cuti->tgl_sampai).', '.format_view($cuti->tgl_sampai).'</strong>';
                                                }


                                                 
                                                if ($jns_cuti==1) {
                                                    $flag_cuti = '<span class="badge bg-info float-end">Cuti Tahunan</span>';
                                                }else if($jns_cuti==2){
                                                    $flag_cuti = '<span class="badge bg-primary float-end">Cuti Bersalin</span>';
                                                }else if($jns_cuti==3){
                                                    $flag_cuti = '<span class="badge bg-warning float-end">Cuti Alasan Penting</span>';
                                                }else{
                                                    $flag_cuti = '<span class="badge bg-danger float-end">Cuti Sakit</span>';
                                                }

                                            ?>

                                        <div class="col-lg-3 d-flex align-items-stretch card-wrapper" id="card-<?= $id; ?>">
                                            <div class="card w-100">
                                                <div class="card-body p-2">
                                                 
                                                       
                                                        <h5> <?php echo $flag_status;?> </h5>
                                                         <?php echo $flag_cuti;?> 
                                                        <h5> <?php echo $cuti->nama;?></h5>

                                                         <p><?php echo $waktu_cuti;?> <br>   <strong> <?php echo $hari_cuti;?> </strong> hari </p>
                                                       
                                                            <p><?= $cuti->alasan_cuti;?> </p>

                                                     
                                                         <div class=" border-top mt-2 pt-2">
                                                             
                                                             <button type="button" value="<?= $id;?>"  class="btn btn-sm text-dark border-none bg-white btn-detail"  data-bs-toggle="modal"  data-bs-target="#detailDL">
                                                                <i class="uil uil-expand-arrows-alt"></i> Detail
                                                             </button>

                                                               <span class="text-light">|</span> 

                                                              <a href="javascript:void(0);" 
                                                                    class="btn btn-sm text-success btn-acc-cuti" 
                                                                    data-id="<?= $id; ?>"  data-status="<?= $status; ?>">
                                                                    <i class="uil uil-file-check-alt"></i> ACC
                                                                </a>

                                                              <span class="text-light">|</span>     

                                                                <button type="button" value="<?= $id;?>"  class="btn btn-sm text-info border-none bg-white btn-edit-cuti"  data-bs-toggle="modal"  data-bs-target="#editDL">
                                                                    <i class="uil  uil-edit"></i> Edit
                                                                </button>

                                                               <span class="text-light">|</span> 

                                                                 <a href="javascript:void(0);" 
                                                                    class="btn btn-sm text-danger btn-delete-dl" 
                                                                    data-id="<?= $id; ?>">
                                                                    <i class="uil  uil-sync-exclamation"></i> Cancel
                                                                </a>

                                                        </div>
                                                  
                                                   
                                                </div>
                                                        

                                            </div>
                                        </div>


                                <?php  } ?>
                      

                                

                                 <div class="modal fade" id="detailDL" tabindex="-1" role="dialog" aria-labelledby="scrollableModalTitle" aria-hidden="true">
                              <div class="modal-dialog modal-lg" role="document">

                                    <div class="modal-content">
                                          
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="scrollableModalTitle">Pengajuan Cuti</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                </div>
                                                <div class="modal-body" id="detailpengajuanCuti">
                                                
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                </div>
                                           
                                    </div><!-- /.modal-content -->


                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->


                        
                                <div class="modal fade" id="editDL" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form id="formEditShift" method="post" action="<?= base_url('dashboard/update_data_pengajuan_cuti'); ?>">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myLargeModalLabel">Edit Dinas Luar </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                </div>
                                                      <div class="modal-body">
                                                             <input type="hidden" name="id_cuti" id="id_cuti">
                                                             <input type="hidden" name="id_pegawai" id="id_pegawai">
                                                             <input type="hidden" name="id_pengganti" id="id_pengganti">


                                                              <input type="text" name="nama_pegawai" class="form-control" readonly id="nama_pegawai">

                                                                <div class="row mt-3">
                                                                <div class="col-md-8 mb-2">
                                                                    <div class="form-group">  <label class="form-label">Jenis Cuti</label>
                                                                        <select name="jns_cuti" id="jenis_cuti" required  class="form-control">

                                                                            <option value="">Pilih Jenis Cuti</option>
                                                                                <?php
                                                                                for ( $c = 0; $c < count($master_cuti);$c++ ) {
                                                                                    $id = $master_cuti[$c]->id;
                                                                                    $jenis_cuti = $master_cuti[$c]->jenis_cuti;

                                                                                    echo ' <option value="' . $id . '">' .$jenis_cuti . "</option>";
                                                                                } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mt-2 col-6">
                                                                    <div class="form-group">
                                                                        <label for="tgl_mulai">Tanggal Mulai</label>
                                                                        <input type="text" name="tgl_dari"  class="form-control bg-white" autocomplete="off" required id="tgl_mulai_cuti"   data-date-format="d-m-Y" placeholder="Select Date">
                                                                    </div>

                                                                </div>
                                                                <div class="col-md-6 mt-2 col-6">
                                                                    <div class="form-group">
                                                                        <label for="tgl_mulai">Tanggal Akhir</label>
                                                                        <input type="text" name="tgl_sampai"  class="form-control bg-white" autocomplete="off"   required  id="tgl_akhir_cuti"  data-date-format="d-m-Y" placeholder="Select Date">
                                                                    </div>

                                                                </div>

                                                          </div>
                                                           
                                                      </div><!--modal body-->
                                                 

                                                      <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-hidden="true">Batal</button>
                                                    </div>

                                                </form>

                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->




            <!-- Todo js -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


                <script>

                

                 $('.btn-detail').on('click', function(e) {
                        e.preventDefault();
                        let id = $(this).val();

                         $.ajax({

                                type:"POST",
                                dataType:"html",
                                url:"<?php echo base_url();?>dashboard/ajaxDetailCuti",
                                data:"id_cuti="+id,
                                success:function(msg){
                        
                                   $("#detailpengajuanCuti").html(msg);
                                //console.log(msg);
                                }

                            });
                   });

                     $('.btn-edit-cuti').on('click', function() {
                            var id = $(this).val();

                            $.ajax({
                            url: '<?= base_url("dashboard/ajaxEditDataCuti"); ?>',
                            type: 'POST',
                            data: { id_cuti: id },
                            dataType: 'json',
                            success: function(return_data) {

                               let  data = return_data[0];
                                // Isi modal dengan data yang didapat
                                
                                $('#nama_pegawai').val(data.nama);
                                $('#id_pegawai').val(data.id_pegawai);
                                $('#id_pengganti').val(data.id_pengganti);
                                $('#id_cuti').val(data.id);
                                $('#jenis_cuti').val(data.jns_cuti);
                                $('#tgl_mulai_cuti').val(data.tgl_dari);
                                $('#tgl_akhir_cuti').val(data.tgl_sampai);
                               
                            },
                            error: function(xhr, status, error) {
                                console.error('Gagal ambil data:', error);
                            }
                            });
                        });



                        
                   $('.btn-acc-cuti').on('click', function(e) {
                        e.preventDefault();
                        var id = $(this).data('id');
                        var status = $(this).data('status');

                        Swal.fire({
                        title: 'Setujui Pengajuan cuti ini?',
                        text: "Pastikan data sudah benar.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Setujui'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                            url: '<?= base_url("dashboard/acc_pengajuan_cuti"); ?>', // Ganti sesuai controller kamu
                            type: 'POST',
                            data: { id: id, status:status },
                            success: function(response) {
                                var res = JSON.parse(response);
                                if (res.status === 'success') {
                                toastr.success('Pengajuan Cuti berhasil disetujui.');

                                // Hapus kartu dari tampilan (atau ubah status di dalam kartu)
                                $('#card-' + id).fadeOut(600, function() {
                                    $(this).remove();
                                });
                                } else {
                                  toastr.error('Gagal menyetujui pengajuan.');
                                }
                            },
                            error: function() {
                                toastr.error('Terjadi kesalahan saat menyetujui.');
                            }
                            });
                        }
                        });
                    });


                </script>