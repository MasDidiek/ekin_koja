<?php


$tanggal        = $tanggal; // tanggal yang diklik
$today          = date('Y-m-d');

$bulanSekarang  = date('Y-m');
$bulanDipilih   = date('Y-m', strtotime($tanggal));
$hariSekarang   = date('d');

if ($hariSekarang < 6) {
    // Tanggal 1–5 → boleh bulan sekarang & bulan sebelumnya
    $bulanMin = date('Y-m', strtotime('-1 month'));

    if ($bulanDipilih < $bulanMin) {
        $showBtn = false;
    } else {
        $showBtn = true;
    }
} else {
    // Tanggal 6 ke atas → hanya boleh bulan berjalan
    if ($bulanDipilih < $bulanSekarang) {
        $showBtn = false;
    } else {
        $showBtn = true;
    }
}

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
        $isDisabled = '';
    } else if ($status == 1) {
        $flag_status = '<span class="badge bg-success fs-2"> <i class="fa-regular fa-circle-check"></i>  &nbsp; Disetujui</span>';
        $isDisabled = 'disabled';
    } else {
        $flag_status = '<span class="badge bg-danger fs-2"> <i class="fa-solid fa-triangle-exclamation"></i>  &nbsp; Ditolak</span>';
        $isDisabled = 'disabled';
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

            <div class="row mt-4">
                <div class="col-md-4">
                    <?php echo $flag_status; ?>
                </div>
                <div class="col-md-8">

                    <button type="button" <?php echo  $isDisabled; ?> value="<?php echo $id; ?>" class="btn btn-light text-danger btn-sm float-end ms-1 delete_aktifitas">Hapus</button>
                    <button type="button" <?php echo  $isDisabled; ?> value="<?php echo $id; ?>" class="btn btn-info btn-sm float-end btn-edit-aktifitas">Ubah</button>

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



    if (!empty($absensiHarian)) {
        $absenMasuk         = $absensiHarian[0]->masuk;
        $absenPulang        = $absensiHarian[0]->pulang;
    } else {
        $absenMasuk         = '';
        $absenPulang        = '';
    }

    if ($absenMasuk == 'CUTI' || $absenMasuk == 'IZIN' || $absenMasuk == 'SAKIT') {
        echo '<div class="alert alert-danger text-danger mt-2">Warning!! anda tidak diperkenankan untuk melakukan input aktifitas</div>';
    } else {

        echo '<div class="bg-warning-subtle text-warning p-2 my-2 fs-4"><i class="fa-solid fa-triangle-exclamation"></i>
            &nbsp;  Belum ada inputan aktifitas!</div>
           <br>';
    }



    if ($showBtn == true) {
        echo '  <button type="button" value="1" class="btn btn-light float-end me-2 input-aktifitas">
            <i class="fa-solid fa-pencil"></i> &nbsp;  Mulai Input Aktifitas</button> ';
    } else {
        echo '  <button type="button" value="0" class="btn btn-light float-end me-2 input-aktifitas">
        <i class="fa-solid fa-pencil"></i> &nbsp;  Mulai Input Aktifitas</button> ';
    }



    $bulanNow = date('m');
    $bulanAktifitas = date('m', strtotime($tanggal));

    // if($bulanAktifitas < $bulanNow){
    //     echo '<div class="alert alert-danger text-danger mt-2"><strong> <i class="fa-solid fa-triangle-exclamation"></i> Batas input aktifitas telah berakhir!!</strong> 
    //     anda tidak diperkenankan untuk melakukan input aktifitas</div>';
    // }

    //  echo $bulanAktifitas;


}

?>



<script>
    $(".input-aktifitas").click(function() {
        let allow = $(this).val();
        if (allow == 1) {
            $(".btn-input-aktifitas").trigger("click");
        } else {
            alert('Warning!! input aktifitas bulan lalu sudah tidak dizinkan');
            return false;
        }
        //  $(".btn-input-aktifitas").trigger("click");

    });



    $(".delete_aktifitas").click(function() {
        var id = $(this).val();
        $("#confirm" + id).show();

    });



    $(".btn-cancel-delete").click(function() {
        var id = $(this).val();
        $("#confirm" + id).fadeOut(500);

    });



    $(".btn-confirm-delete").click(function() {
        var id = $(this).val();
        $("#confirm" + id).html("Deleting...");


        $.ajax({
            type: "POST",
            dataType: "html",
            url: "<?php echo base_url(); ?>kinerja/ajaxDeleteAktifitas",
            data: "id=" + id,
            success: function(msg) {
                $("#aktifitasPegawai" + id).fadeOut(1000);
                toastr.success(msg, "Berhasil");
            }

        });



    });



    $(".btn-edit-aktifitas").click(function() {

        $(".view_aktifitas").addClass("d-none");
        $(".input_kegiatan").removeClass("d-none");
        $(".btn-lihat-aktifitas").removeClass("fw-semibold text-dark");
        $(".btn-lihat-aktifitas").addClass("text-muted");

        $(".btn-input-aktifitas").addClass("fw-semibold text-dark");
        $(".btn-input-aktifitas").removeClass("text-muted");

        var id = $(this).val();

        $.ajax({
            type: "POST",
            dataType: "html",
            url: "<?php echo base_url(); ?>kinerja/getDataEditAktifitas",
            data: "id=" + id,
            success: function(msg) {
                $("#input_kegiatan").html(msg);
            }

        });


    });
</script>