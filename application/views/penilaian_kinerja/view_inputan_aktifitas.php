<?php
if ($approved_all == false) {

    echo '<button type="button" value="' . $id_pegawai . '/' . $tanggal . '" class="btn btn-success w-100 mt-2 approve-all">
                <i class="fa-solid fa-check-double"></i>
                   Setujui Semua
                </button>
                ';
}
?>


<?php


for ($i = 0; $i < count($dataAktifitas); $i++) {
    $id = $dataAktifitas[$i]->id;
    $tgl = $dataAktifitas[$i]->tgl;
    $jns_kegiatan = $dataAktifitas[$i]->jns_kegiatan;
    $nama_kegiatan = $dataAktifitas[$i]->nama_kegiatan;
    $jam_mulai = $dataAktifitas[$i]->jam_mulai;
    $jam_selesai = $dataAktifitas[$i]->jam_selesai;
    $volume = $dataAktifitas[$i]->volume;
    $waktu_efektif = $dataAktifitas[$i]->waktu_efektif;
    $total = $dataAktifitas[$i]->total;
    $ket = $dataAktifitas[$i]->ket;
    $status = $dataAktifitas[$i]->status;
    $indikator = $dataAktifitas[$i]->indikator;

    if ($jns_kegiatan == 1) {
        $kategori_aktifitas = '<h6 class="text-success"> <i class="fa-regular fa-star"></i> &nbsp; Aktifitas Utama</h6>';
    } else {
        $kategori_aktifitas = '<h6 class=" text-warning"> <i class="fa-regular fa-note-sticky"></i> &nbsp; Aktifitas Tambahan</h6>';
    }


    if ($status == 0) {
        $flag_status = '<span class="badge bg-warning fs-2"> <i class="fa-regular fa-circle-question"></i>   &nbsp;Belum divalidasi</span>';
        $d_none = '';
        $d_none_cancel = 'd-none';
    } else if ($status == 1) {
        $flag_status = '<span class="badge bg-success fs-2"> <i class="fa-regular fa-circle-check"></i>  &nbsp; Disetujui</span>';
        $d_none = 'd-none';
        $d_none_cancel = '';
    } else {
        $flag_status = '<span class="badge bg-danger fs-2"> <i class="fa-solid fa-triangle-exclamation"></i>  &nbsp; Ditolak</span>';
        $d_none = 'd-none';
        $d_none_cancel = '';
    }
?>


    <!-- 
<i class="fa-regular fa-star"></i> -->
    <div class="border-bottom" id="aktifitasPegawai<?php echo $id; ?>">
        <div class="card-body px-0 py-4">


            <div class="row mb-4">
                <div class="col-md-6 border-end ">
                    <?php echo $kategori_aktifitas; ?>
                    <span class="text-muted  fs-2">Jenis Aktifitas</span>
                </div>
                <div class="col-md-3 border-end ">
                    <span class="text-dark fw-semibold fs-3"><i class="ti ti-clock fs-4"></i> &nbsp; <?php echo format_jam($jam_mulai); ?> </span><br>
                    <span class="text-muted fs-2">Jam Mulai</span>
                </div>
                <div class="col-md-3">
                    <span class="text-dark fw-semibold fs-3"> <i class="ti ti-clock fs-4"></i> &nbsp; <?php echo format_jam($jam_selesai); ?> </span><Br>
                    <span class="text-muted  fs-2">Jam Selesai</span>

                </div>
            </div>


            <span class="text-danger fs-3">Indikator : </span>
            <div class="mb-2 fs-3"><?php echo $indikator; ?></div>


            <span class="text-danger fs-3">Aktifitas : </span>
            <div class="mb-2 fs-3"><?php echo $nama_kegiatan; ?></div>

            <span class="text-danger fs-3">Keterangan : </span>
            <div class="mb-3 fs-3"><?php echo $ket; ?></div>



            <span class="badge text-info  fs-2">Waktu Efektif : &nbsp; <strong><?php echo $waktu_efektif; ?> Menit</strong></span> &nbsp; &nbsp;
            <span class="badge text-info fs-2">Volume : &nbsp; <strong><?php echo $volume; ?></strong></span> &nbsp; &nbsp; &nbsp;
            <span class="badge text-success bg-success-subtle  fs-2">Total : &nbsp; <strong> <?php echo $total; ?> Menit</strong></span>

            <br>

            <div class="row mt-4" id="row-id<?php echo $id; ?>">
                <div class="col-md-4">
                    <?php echo $flag_status; ?>
                </div>
                <div class="col-md-8" id="btn-group<?php echo $id; ?>">

                    <button type="button" value="<?php echo $id; ?>" class="btn btn-light text-danger  float-end ms-1 tolak_aktifitas <?php echo  $d_none; ?>">
                        <i class="fa-solid fa-circle-exclamation"></i> Tolak</button>
                    <button type="button" value="<?php echo $id; ?>" class="btn btn-success float-end setujui-aktifitas <?php echo  $d_none; ?>">
                        <i class="fa-solid fa-check"></i> Setujui</button>

                    <button type="button" value="<?php echo $id; ?>" class="btn bg-warning-subtle  text-warning float-end cancel-acc-aktifitas <?php echo  $d_none_cancel; ?>">
                        <i class="fa-solid fa-times"></i> Cancel</button>

                </div>

                <div class="col-md-12 bg-danger-subtle text-danger p-2 mt-2" style="display: none;" id="confirm<?php echo $id; ?>">
                    Apakah anda ingin menghapus data aktifitas ini ? &nbsp; &nbsp; &nbsp; &nbsp;

                    <button value="<?php echo $id; ?>" class="btn btn-xs btn-danger btn-confirm-delete">Iya</button> &nbsp;
                    <button value="<?php echo $id; ?>" class="btn btn-xs btn-cancel-delete ">Tidak</button>
                </div>

            </div>


        </div>
    </div>

<?php }


if (count($dataAktifitas) == 0) {
    echo '<div class="bg-warning-subtle text-warning p-2 my-2 fs-4"><i class="fa-solid fa-triangle-exclamation"></i>
    &nbsp;  Tidak ada inputan aktifitas!</div> ';
}

?>



<script>
    $(".input-aktifitas").click(function() {
        $(".btn-input-aktifitas").trigger("click");
    });




    $(".setujui-aktifitas").click(function() {

        var id = $(this).val();

        $(this).html("loading..");
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "<?php echo base_url(); ?>admin/penilaian_kinerja/approve_aktifitas",
            data: "id=" + id + "&status=1",
            success: function(msg) {
                toastr.success(msg, "Berhasil");
                $("#btn-group" + id).hide();
                $("#aktifitas" + id).css("background-color", "#41c46e");
            }

        });


    });


    $(".tolak_aktifitas").click(function() {

        var id = $(this).val();
        $(this).html("loading..");
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "<?php echo base_url(); ?>admin/penilaian_kinerja/approve_aktifitas",
            data: "id=" + id + "&status=0",
            success: function(msg) {
                toastr.success(msg, "Berhasil");
                $("#btn-group" + id).hide();
                $("#aktifitas" + id).css("background-color", "#f66363");
            }

        });
    });

    $(".cancel-acc-aktifitas").click(function() {

        var id = $(this).val();
        $(this).html("loading..");
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "<?php echo base_url(); ?>admin/penilaian_kinerja/cancel_acc_aktifitas",
            data: "id=" + id + "&status=0",
            success: function(msg) {
                toastr.success(msg, "Berhasil");
                $("#btn-group" + id).hide();
                $("#aktifitas" + id).css("background-color", "#f66363");
            }

        });
    });



    $(".approve-all").click(function() {

        var data_value = $(this).val();
        $(this).html("loading..");

        $.ajax({
            type: "POST",
            dataType: "html",
            url: "<?php echo base_url(); ?>admin/penilaian_kinerja/approve_all_aktifitas",
            data: "data_value=" + data_value,
            success: function(msg) {
                toastr.success(msg, "Berhasil");
                $(".approve-all").fadeOut(1500);

                setTimeout(function() {
                    window.location.reload(1);
                }, 3000);
                //$("#aktifitasPegawai"+id).fadeOut(1000);

            }

        });

    });
</script>