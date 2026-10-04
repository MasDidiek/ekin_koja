<!--  Shopping Cart -->

<?php
$id_pegawai =  $this->session->userdata('id_pegawai');
$permohonanPengganti = $this->Cuti_model->getPermohonanPengganti($id_pegawai);
$numPermohonan = count($permohonanPengganti);



?>
<div class="offcanvas offcanvas-end shopping-cart" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header py-4">
    <h5 class="offcanvas-title fs-5 fw-semibold" id="offcanvasRightLabel">
      Permohonan Pengganti Cuti
    </h5>
    <span class="badge bg-primary rounded-4 px-3 py-1 lh-sm"><?php echo  $numPermohonan; ?> new</span>
  </div>
  <div class="offcanvas-body h-100 px-4 pt-0" data-simplebar>
    <ul class="mb-0">
      <?php

      ///print_array($permohonanPengganti);;


      foreach ($permohonanPengganti as $key) {
        $id_cuti = $key->id;
        $id_pegawai = $key->id_pegawai;
        $alasan_cuti = $key->alasan_cuti;
        $tgl_dari = $key->tgl_mulai;
        $tgl_sampai = $key->tgl_selesai;

        $hari_cuti = $key->lama_cuti;

        $pengganti = $this->Pegawai_model->getDataEditPegawai($id_pegawai);
        $nama_pengganti = $pengganti[0]->nama;


        if ($hari_cuti == 1) {
          $tgl_cuti = format_view($tgl_dari);
        } else {
          $tgl_cuti = format_view($tgl_dari) . ' s/d ' . format_view($tgl_sampai);
        }


        echo '
                                                <li class="pb-7">
                                                    <div class="d-flex align-items-center">


                                                        <div>
                                                            <h6 class="mb-1">' . $nama_pengganti . '</h6>
                                                            <p class="mb-0 text-muted fs-2">
                                                                    Tanggal Cuti : <span class="text-danger">' . $tgl_cuti . '</span>  <br>
                                                                  Alasan Cuti : ' . $alasan_cuti . '
                                                                </p>
                                                            <div class="mt-2">
                                                                <button type="button" value="' . $id_cuti . '" class="btn btn-sm btn-success approve"   data-bs-toggle="modal" data-bs-target="#al-success-alert" >Setujui</button>

                                                                <a href="' . base_url() . 'cuti/detail_cuti/' . $id_cuti . '" class="btn btn-sm btn-info me-4">Lihat Detail</a>
                                                                <button type="button" class="btn btn-sm bg-danger-subtle text-danger reject" value="' . $id_cuti . '"  data-bs-toggle="modal" data-bs-target="#al-info-alert">Tolak</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>';
      }

      ?>


    </ul>

  </div>
</div>


<div class="modal fade" id="al-success-alert" tabindex="-1" aria-labelledby="vertical-center-modal" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content modal-filled bg-light-success text-success">
      <div class="modal-body p-4">
        <div class="text-center text-success">
          <i class="ti ti-circle-check fs-7"></i>
          <h4 class="mt-2">Approve Cuti</h4>
          <p class="mt-3 text-success-50">
            Apakah anda ingin menyetujui sebagai pengganti cuti?
          </p>


          <form method="post" action="<?php echo base_url(); ?>cuti/setujui_cuti">


            <input type="hidden" name="id_cuti" id="id_cuti_approve" value="">


            <button type="submit" class="btn btn-success my-2"> Iya, setujui </button>
            <button type="button" class="btn btn-light my-2" data-bs-dismiss="modal">
              Batal
            </button>

          </form>


        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
</div>


<!-- Vertically centered modal -->
<div class="modal fade" id="al-info-alert" tabindex="-1" aria-labelledby="vertical-center-modal" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content modal-filled">
      <div class="modal-body p-4">
        <div class="text-center text-warning">
          <i class="ti ti-info-circle fs-7"></i>
          <h4 class="mt-2">Tolak Sebagai Pengganti</h4>
          <p class="mt-3">
            Apakah anda ingin menolak sebagai pengganti cuti?
          </p>

          <button type="button" class="btn btn-success my-2">
            Iya, Tolak
          </button>

          <button type="button" class="btn btn-light my-2" data-bs-dismiss="modal">
            Batal
          </button>
        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
</div>