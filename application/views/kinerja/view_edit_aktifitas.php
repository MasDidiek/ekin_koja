   
   
   <div class="border p-2 mb-2 bg-info-subtle text-info">
     <strong>Edit Aktifitas</strong>
   </div>
 

    <?php

        $id = $dataAktifitas[0]->id;
        $tgl = $dataAktifitas[0]->tgl;
        $jns_kegiatan = $dataAktifitas[0]->jns_kegiatan;
        $nama_kegiatan = $dataAktifitas[0]->nama_kegiatan;
        $jam_mulai = $dataAktifitas[0]->jam_mulai;
        $jam_selesai = $dataAktifitas[0]->jam_selesai;
        $volume = $dataAktifitas[0]->volume;
        $waktu_efektif = $dataAktifitas[0]->waktu_efektif;
        $total = $dataAktifitas[0]->total;
        $ket = $dataAktifitas[0]->ket;
        $status = $dataAktifitas[0]->status;
        $indikator = $dataAktifitas[0]->indikator;


        $jam_mulai = format_jam($jam_mulai);
        $jam_selesai = format_jam($jam_selesai);
    ?>
   <strong>Jenis Kegiatan</strong>
        <div class="jns_kegiatan">
            <div class="jenis_aktifitas aktifitas-utama">
                <input type="radio" name="jns_kegiatan" id="kegiatan_utama" value="1" checked> 
                <label for="kegiatan_utama" class="label-kegiatan utama kegiatan_active" > Utama</label>
            </div>

            <div class="jenis_aktifitas aktifitas-tambahan">
                <input type="radio" name="jns_kegiatan" id="kegiatan_tambahan" value="2"> 
                <label for="kegiatan_tambahan"  class="label-kegiatan tambahan"> Tambahan</label>
            </div>
      </div>

    <div class="col-md-6  col-6 mb-3">
        <label for="from" class="fw-semibold">Tanggal <span class="text-danger">*</span></label> : <br>
        <input class="form-input-kinerja" type="text" name="tanggal" id="tgl_kinerja" readonly value="<?php echo format_view($tgl) ;?>">
    </div>

<!-- 
    <div class="form-input">
        <label for="from" class="fw-semibold"> Indikator Kegiatan <span class="text-danger">*</span></label> : <br>
        <textarea id="indikator" name="indikator" class="form-input-kinerja"  required autocomplete="off"  rows="2" cols="10" wrap="soft"><?php echo $indikator;?></textarea>
        <div id="ajaxlist_indikator"></div>
    </div>
    <br> -->

    <div class="form-input">
        <label for="from" class="fw-semibold"> Aktifitas <span class="text-danger">*</span></label> : <br>
        <textarea  id="aktifitas" name="aktifitas" class="form-input-kinerja" required autocomplete="off"  rows="2" cols="10" wrap="soft"><?php echo $nama_kegiatan;?></textarea>
        <div id="ajaxlist_aktifitas"></div>
    </div>


    <br>


    <div class="row">

        <div class="col-md-6  col-6 mb-3">
            <label for="from" class="fw-semibold">Jam Mulai <span class="text-danger">*</span></label> : <br>
            <input class="time precisionTime5 form-input-kinerja" type="text" name="jam_mulai" id="jam_mulai" value="<?php echo $jam_mulai;?>">

        </div>
        <div class="col-md-6  col-6 mb-3">
            <label for="from" class="fw-semibold"> Jam Selesai <span class="text-danger">*</span></label> : <br>
            <input type="text" name="jam_selesai" id="jam_selesai" class="time durationNegativeMinMax  form-input-kinerja" value="<?php echo $jam_selesai;?>">

        </div>
        <div class="col-md-6 col-6">
            <label for="from" class="fw-semibold"> Waktu Efektif <span class="text-danger">*</span></label> : <br>
            <input type="number" name="waktu_efektif" value="<?php echo $waktu_efektif;?>" class="form-input-kinerja" id="waktu_efektif">
        </div>

        <div class="col-md-6  col-6">
        <label for="from" class="fw-semibold"> Volume <span class="text-danger">*</span></label> : <br>
            <input type="number" id="volume" name="vol" value="<?php echo $volume;?>" class="form-input-kinerja" required  autocomplete="off">
            <span class="loader" style="display:none"> <img src="<?php echo PATH_IMAGE; ?>loading.gif"></span> <br>

        </div>
    </div>

    <br>
    <div class="form-input">
    <label for="from" class="fw-semibold"> Keterangan <span class="text-danger">*</span></label> : <br>
    <textarea name="keterangan" class="form-input-kinerja"  id="keterangan"  rows="2" cols="10" wrap="soft"><?php echo $ket;?></textarea>
    </div>

    <div class="form-input mt-4">
        <input type="hidden" name="id_aktifitas" value="<?php echo $id;?>">
        <button type="submit" value="edit" name="action" class="btn btn-success float-end">Simpan</button>
        <button type="button" class="btn btn-light float-end me-2 cancel-edit">Batal</button>
    </div>

    <script>



        $(".cancel-edit").click(function(){
            $(".btn-lihat-aktifitas").trigger("click");
        });  
            
            
          $('.precisionTime5').clockTimePicker({
            precision: 5
          });
    
      
          $('.durationNegative').clockTimePicker({
            duration: true,
            durationNegative: true
          });
         
          $('.durationNegativeMinMax').clockTimePicker({
            duration: true,
            precision: 5
          });
          
          
        $("#indikator").keyup(function(){
            var keyword = $(this).val();
            $("#ajaxlist_indikator").show();
                    $.ajax({
                        
                        type:"POST",
                        dataType:"html",
                        url:"<?php echo base_url();?>kinerja/ajaxSearchIndikator",
                        data:"keyword="+keyword,
                        success:function(msg){
                            $("#ajaxlist_indikator").html(msg);
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

      $("#jam_mulai").change(function() {
            var jam_mulai = $(this).val();
            // alert(jam_mulai);
            // var pecah = jam_mulai.split(":");
            // var jam_awal = pecah[0];
            // var menit_awal = pecah[1];
            // var resctr_jam =
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
    

          


        
    </script>