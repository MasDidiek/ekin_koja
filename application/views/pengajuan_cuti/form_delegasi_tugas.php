<form action="<?php echo base_url(); ?>cuti/finish_pengajuan_cuti" method="post" enctype="multipart/form-data" id="pengajuan_cuti2">
        <div class="modal-header">
            <h5 class="modal-title" id="scrollableModalTitle">Form Delegasi Tugas</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                   <div class="form-group">
                        <label>Tugas 1 <span class="text-danger">*</span>:</label><br>
                        <input type="text"  name="tugas1" value="" placeholder="input delegasi tugas" class="form-control" required autocomplete="off">
                    </div>
                    <div class="form-group  mt-2">
                        <label>Tugas 2 <span class="text-danger">*</span>:</label><br>
                        <input type="text"  name="tugas2" value="" placeholder="input delegasi tugas" class="form-control" required autocomplete="off">
                    </div>
                     <div class="form-group  mt-2">
                        <label>Tugas 3 <span class="text-danger">*</span>:</label><br>
                        <input type="text"  name="tugas3" value="" placeholder="input delegasi tugas" class="form-control" required autocomplete="off">
                    </div>
                     <div class="form-group mt-2">
                        <label>Tugas 4 :</label><br>
                        <input type="text"  name="tugas4" value="" placeholder="input delegasi tugas" class="form-control" autocomplete="off">
                    </div>

                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success kirim" id="submit_btn">Kirim Pengajuan Cuti</button>
        </div>
    </form>
