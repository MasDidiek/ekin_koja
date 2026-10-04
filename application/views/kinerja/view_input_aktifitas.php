 

<?php echo	form_open('kinerja/insert_aktifitas_v2', 'class="input_aktifitas" id="input_aktifitas"');?>

  <div class="col-md-6  col-6 mb-3">
      <label for="from" class="fw-semibold">Tanggal <span class="text-danger">*</span></label> : <br>
      <input class="form-control" type="text" name="tanggal" id="tgl_kinerja" readonly value="<?php echo format_view($tgl);?>">
  </div>


  <div class="form-input">
      <label for="from" class="fw-semibold"> Aktifitas <span class="text-danger">*</span></label> : <br>
      <textarea  id="aktifitas" name="aktifitas" class="form-control" required autocomplete="off"  rows="2" cols="10" wrap="soft"></textarea>
      <div id="ajaxlist_aktifitas"></div>
  </div>


  <br>


  <div class="row">

      <div class="col-md-6  col-6 mb-3">
          <label for="from" class="fw-semibold">Jam Mulai <span class="text-danger">*</span></label> : <br>
          <input class="time jam_mulai form-control" type="text" name="jam_mulai" id="jam_mulai" value="00:00">

      </div>
      <div class="col-md-6  col-6 mb-3">
          <label for="from" class="fw-semibold"> Jam Selesai <span class="text-danger">*</span></label> : <br>
          <input type="text" name="jam_selesai" id="jam_selesai" class="time  durationNegativeMinMax form-control" value="00:00">

      </div>
      <div class="col-md-6 col-6">
          <label for="from" class="fw-semibold"> Waktu Efektif <span class="text-danger">*</span></label> : <br>
          <input type="number" name="waktu_efektif" value="0" class="form-control" min="5" id="waktu_efektif">
          <div class="invalid-form waktu_efektif"></div>
      </div>

      <div class="col-md-6  col-6">
      <label for="from" class="fw-semibold"> Volume <span class="text-danger">*</span></label> : <br>
          <input type="number" id="volume" name="vol" value="0" class="form-control" required  autocomplete="off" min="1">
          <div class="invalid-feedback volume"></div>
          <span class="loader" style="display:none"> <div class="spinner-border text-info" role="status"></div></span> <br>

      </div>
  </div>

  <br>
  <div class="form-input">
     <label for="from" class="fw-semibold"> Keterangan <span class="text-danger">*</span></label> : <br>
     <textarea name="keterangan" class="form-control"  id="keterangan"  rows="2" cols="10" wrap="soft"></textarea>
     <div id="list_keterangan"></div>
  </div>

  <div class="form-input mt-4">
      <button type="submit" value="edit" name="action" class="btn btn-success float-end">Simpan</button>
    

      <div class="spinner-border text-info" id="loading-spinner" style="display:none" role="status"></div>
  </div>

<?php   echo form_close(); ?>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-clock-timepicker.js"></script>

<script>

 $('#input_aktifitas').submit(function() {
     $("#loading-spinner").show();

      var tanggal = $("#tgl_kinerja").val();


        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
             // $("#form_edit").html("berhasil");
             if(data=='failed1'){
              $.NotificationApp.send("Gagal","Data aktifitas gagal disimpan, Waktu efektif tidak boleh 0","top-center","rgba(0,0,0,0.2)","danger");
             }else if(data=='failed2'){
              $.NotificationApp.send("Gagal","Data aktifitas gagal disimpan, Volume tidak boleh 0","top-center","rgba(0,0,0,0.2)","danger");
             }else{
              $.NotificationApp.send("Berhasil","Data aktifitas berhasil disimpan","top-right","rgba(0,0,0,0.2)","success");


              $.ajax({

                  type:"POST",
                  dataType:"html",
                  url:"<?php echo base_url();?>kinerja/ajaxGetAktifitasHarian",
                  data:"tanggal="+tanggal,
                  success:function(msg){
                      $(".modal-body").html(msg);
                  }

                  });

             }
           
             $("#loading-spinner").hide();
            }
        })
        return false;
    });


$('.jam_mulai').clockTimePicker({
 precision: 5
});

$('.durationNegativeMinMax').clockTimePicker({
  duration: true,
  precision: 5
});



$("#jam_mulai").change(function() {
    var jam_mulai = $(this).val();

    $("#jam_selesai").val(jam_mulai);
    $('.durationNegativeMinMax').clockTimePicker({
        duration: true,
        minimum: jam_mulai,
        maximum: '23:59',
        precision: 5
    });

  $("#jam_selesai").focus();
});


$("#jam_selesai").change(function() {
    waktu_efektif = $("#waktu_efektif").val();
    var jam_mulai = $("#jam_mulai").val();
    var jam_selesai = $(this).val();
    $(".loader").show();
    $.ajax({
        type: "POST",
        dataType: "html",
        url: "<?php echo base_url();?>kinerja/hitung_volume",
        data: "waktu_efektif=" + waktu_efektif + "&jam_mulai=" + jam_mulai + "&jam_selesai=" + jam_selesai,
        success: function(msg) {
        $("#volume").val(msg);
        $(".loader").fadeOut();
        }
    });
});




//klik di inputan untuk mencari kegiatan yang biasa di input oleh pegawai tersebut
$("#aktifitas").click(function(){

var keyword = $(this).val();
$("#ajaxlist_aktifitas").show();
$.ajax({
    type:"POST",
    dataType:"html",
    url:"<?php echo base_url();?>kinerja/ajaxGetFrequentAktifitas",
    data:"keyword="+keyword,
    success:function(msg){
        $("#ajaxlist_aktifitas").html(msg);
    }
    
});
});

$("#aktifitas").keyup(function(){
    var keyword = $(this).val();
    $("#ajaxlist_aktifitas").show();
        $.ajax({
            type:"POST",
            dataType:"html",
            url:"<?php echo base_url();?>kinerja/ajaxSearchAktifitas",
            data:"keyword="+keyword,
            success:function(msg){
                $("#ajaxlist_aktifitas").html(msg);
            }
            
        });


});


   $("#keterangan").keyup(function(){
    var keyword = $(this).val();
    $("#list_keterangan").show();
        $.ajax({
            type:"POST",
            dataType:"html",
            url:"<?php echo base_url();?>kinerja/ajaxSearchKeterangan",
            data:"keyword="+keyword,
            success:function(msg){
                $("#list_keterangan").html(msg);
            }
            
        });
   });


   $("#keterangan").click(function(){
    var keyword = $(this).val();
    $("#list_keterangan").show();
        $.ajax({
            type:"POST",
            dataType:"html",
            url:"<?php echo base_url();?>kinerja/ajaxGetKeteranganAktifitas",
            data:"keyword="+keyword,
            success:function(msg){
                $("#list_keterangan").html(msg);
            }
            
        });
   });



</script>