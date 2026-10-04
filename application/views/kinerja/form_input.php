<?php echo form_open('kinerja/insert_aktifitas', 'id="input_aktifitas"'); ?>

<div class="p-4 input_kegiatan">

    <h5 class="mb-3">
        Input Aktivitas – <?= date('d F Y', strtotime($tgl)) ?>
    </h5>

    <input type="hidden" name="tanggal" value="<?= $tgl ?>">

    <!-- ISI FORM SAJA -->

    <div class="jns_kegiatan">
        <div class="jenis_aktifitas aktifitas-utama">
            <input type="radio" name="jns_kegiatan" id="kegiatan_utama" value="1" checked>
            <label for="kegiatan_utama" class="label-kegiatan utama kegiatan_active"> Utama</label>
        </div>

        <div class="jenis_aktifitas aktifitas-tambahan">
            <input type="radio" name="jns_kegiatan" id="kegiatan_tambahan" value="2">
            <label for="kegiatan_tambahan" class="label-kegiatan tambahan"> Tambahan</label>
        </div>
    </div>


    <div class="form-input">
        <label for="from" class="fw-semibold"> Indikator Kegiatan <span class="text-danger">*</span></label> : <br>
        <textarea id="indikator" name="indikator" class="form-input-kinerja" required autocomplete="off" rows="2" cols="10" wrap="soft"></textarea>
        <div id="ajaxlist_indikator"></div>
    </div>
    <br>

    <div class="form-input">
        <label for="from" class="fw-semibold"> Aktifitas <span class="text-danger">*</span></label> : <br>
        <textarea id="aktifitas" name="aktifitas" class="form-input-kinerja" required autocomplete="off" rows="2" cols="10" wrap="soft"></textarea>
        <div id="ajaxlist_aktifitas"></div>
    </div>


    <br>


    <div class="row">

        <div class="col-md-6  col-6 mb-3">
            <label for="from" class="fw-semibold">Jam Mulai <span class="text-danger">*</span></label> : <br>
            <input class="time start_time form-input-kinerja" type="text" name="jam_mulai" id="jam_mulai" value="06:00">

        </div>
        <div class="col-md-6  col-6 mb-3">
            <label for="from" class="fw-semibold"> Jam Selesai <span class="text-danger">*</span></label> : <br>
            <input type="text" name="jam_selesai" id="jam_selesai" class="time end_time  form-input-kinerja" value="07:00">

        </div>
        <div class="col-md-6 col-6">
            <label for="from" class="fw-semibold"> Waktu Efektif <span class="text-danger">*</span></label> : <br>
            <input type="number" name="waktu_efektif" value="0" class="form-input-kinerja" id="waktu_efektif">
        </div>

        <div class="col-md-6  col-6">
            <label for="from" class="fw-semibold"> Volume <span class="text-danger">*</span></label> : <br>
            <input type="number" id="volume" name="vol" class="form-input-kinerja" required autocomplete="off">
            <span class="loader" style="display:none"> <img src="<?php echo PATH_IMAGE; ?>loading.gif"></span> <br>

        </div>
    </div>

    <br>
    <div class="form-input">
        <label for="from" class="fw-semibold"> Keterangan <span class="text-danger">*</span></label> : <br>
        <textarea name="keterangan" id="keterangan" class="form-input-kinerja" rows="2" cols="10" wrap="soft"></textarea>
        <div id="list_keterangan"></div>
    </div>

    <div class="mt-4 text-end">
        <button type="submit" class="btn btn-success">Simpan</button>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
            Batal
        </button>
    </div>

</div>

<?php echo form_close(); ?>