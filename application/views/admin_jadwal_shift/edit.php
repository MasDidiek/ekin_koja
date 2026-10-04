
<form action="<?php echo base_url();?>admin_jadwal_shift/update/<?php echo $data_edit[0]->id_bagian;?>" method="post">
            <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">  Ubah Depertamen /  Bagian </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <label for="bagian">Nama Bagian  <span class="text-danger">*</span>:</label></label>
                <input type="text" name="nama_bagian" id="nama_bagian" value="<?php echo $data_edit[0]->nama_bagian;?>" class="form-control"> <br>

                <label>Penanggung Jawab  <span class="text-danger">*</span>:</label><br>
                <div class="form-input">
                <input type="text" id="search_pegawai_edit" name="nama_pj" value="<?php echo $data_edit[0]->nama_pj_bagian;?>" class="form-control" required autocomplete="off">
                <div id="list_pegawai_edit"></div>
                </div>

                <input type="hidden" name="id_pj" id="id_pj_choose_edit"   value="<?php echo $data_edit[0]->id_pj;?>">
            </div>


            <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            </div>

</form>

<script>


$(document).ready(function(){
    $("#search_pegawai_edit").keydown(function() {
            var keyword = $(this).val();
            $("#list_pegawai_edit").show();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>admin_jadwal_shift/search_pegawai_edit",
                data: "keyword=" + keyword,
                success: function(return_data) {
                    $("#list_pegawai_edit").html(return_data);
                }
            });
        });

});
                
       
</script>