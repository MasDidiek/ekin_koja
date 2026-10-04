

    <?php



             $list_bulan = array_bulan();


              $periode_bulan = $this->session->userdata('periode_bulan');
              $periode_tahun = $this->session->userdata('periode_tahun');
              $id_pkm_sess   = $this->session->userdata('id_pkm');
              $id_pj_sess = $this->session->userdata('id_pj');
              $id_user_validator   = $this->session->userdata('id_pegawai');

              if($periode_bulan=='') {
              $bulan = date('m');
              $tahun = date('Y');

              }else{
                  $bulan = $periode_bulan;
                  $tahun = $periode_tahun;
              }

              $periode = $tahun.'-'.$bulan;
              $periode = date('Y-m', strtotime($periode));

              $nm_bulan = getBulan($bulan);



            //print_array($pegawai);

            $id_pegawai = $pegawai[0]->id_pegawai;
            $tgl_masuk = $pegawai[0]->tgl_masuk;
            $nip = $pegawai[0]->nip;
            $nama_pegawai = $pegawai[0]->nama;
            $jabatan = $pegawai[0]->jabatan;
            $puskesmas = $pegawai[0]->puskesmas;

            $photo = $this->Pegawai_model->getPhotoPegawai($nip);

            if($photo==''){
              $photo = 'avatar.png';
            }


            $cutiTahunan = $this->Cuti_model->getDataCutiByStatus($id_pegawai, 1, $periode);

            $hari_cuti_tahunan = 0;
            foreach ($cutiTahunan as $ct) {
                $hariCuti = $ct->hari_cuti;
                $hari_cuti_tahunan =  $hari_cuti_tahunan +$hariCuti ;

            }


            $hari_cuti_bersalin = 0;

            $last_date = date('t', strtotime($periode));
            for ($i=0; $i < $last_date ; $i++) {
               $date = $periode.'-'.$i;
               $addDate = add_date($date, 1);

               $cutiBersalin = $this->Cuti_model->cekCutiBersalin($id_pegawai,$addDate);
               if($cutiBersalin==1){
                 $hari_cuti_bersalin = $hari_cuti_bersalin +1;
               }


            }





            $periode = $dataTKD[0]->periode;
            $nip = $dataTKD[0]->nip;
            $nama = $dataTKD[0]->nama;
            $jabatan = $dataTKD[0]->jabatan;
            $tkd_pokok = $dataTKD[0]->tkd_pokok;
            $capaian = $dataTKD[0]->capaian;
            $bruto = $dataTKD[0]->bruto;
            $pph21 = $dataTKD[0]->pph21;

            $bpjs = $dataTKD[0]->bpjs;
            $bpjs_tk = $dataTKD[0]->bpjs_tk;
            $thp = $dataTKD[0]->thp;
            $masa_kerja = $dataTKD[0]->masa_kerja;
            $status = $dataTKD[0]->status;

            $totalPotongan = $pph21+$bpjs+$bpjs_tk;

            $telat = $dataRekap[0]->telat;
            $pulang_awal = $dataRekap[0]->pulang_awal;
            $izin = $dataRekap[0]->izin;
            $sakit = $dataRekap[0]->sakit;
            $sakit_dgn_sk = $dataRekap[0]->sakit_dgn_sk;
            $alpha = $dataRekap[0]->alpha;
            $cuti = $dataRekap[0]->cuti;

            if($status==1){
                $flag_status = '<span class="badge bg-success">Sudah Sesuai</span>';
            }else{
              $flag_status = '<span class="badge bg-warning">Belum Sesuai</span>';
            }



            $menit_izin = $izin*300;
            $menit_sakit = $sakit*300;
            $menitSakitDenganSK = $sakit_dgn_sk*150;


            $menit_cuti = $cuti*300;

            $totalMenitPengurang = $telat+$pulang_awal+$menit_izin+$menit_sakit+$menitSakitDenganSK;

            $periode_name = formatTanggalIndonesia($periode);


            $gaji_pokok = $pegawai[0]->gaji_pokok;
            $pengkalian = $pegawai[0]->pengkalian;
            $status_kerja= $pegawai[0]->status_kerja;


             $checkAktif = '';
             $checkCuti = '';
             $checkNonAktif = '';

            if($status_kerja==1){
                $checkAktif = 'checked';
            }

            if($status_kerja==2){
                $checkCuti = 'checked';
            }

            if($status_kerja==3){
                $checkNonAktif = 'checked';
            }


            $tkd_pokok  = $gaji_pokok*$pengkalian;


            $tmt = $pegawai[0]->tmt;
            $today = date('Y-m-d');

            $masa_kerja = hitungMasaKerja($tmt, $today);

            $detailPegawai = $this->Pegawai_model->getDataDetailPegawai($nip);


            $x2 = 100-$capaian;

            if($capaian > 98){
              $bg = '#47C984';
            }else if($capaian < 98 && $capaian > 91){
                $bg = '#A0C518';
            }else if($capaian < 91 && $capaian > 80){
                $bg = '#FE9900';
            }else{
                $bg = '#D71A1A';
            }



           $bobot_aktifitas = $dataCapaian[0]->bobot_aktifitas;
           $perilaku = $dataCapaian[0]->perilaku;
           $serapan = $dataCapaian[0]->serapan;

            //print_array($dataCapaian);
        ?>


   <style>
   .svg-item {
       width: 40%;
       font-size: 16px;
       margin: 0 auto;
       animation: donutfade 1s;
     }

     .donut-ring {
         stroke: #EBEBEB;
     }

     .donut-segment {
         transform-origin: center;
         stroke: #47C984;
     }

     .donut-segment-2 {
           stroke: <?php echo $bg;?>;
           animation: donut1 3s;
       }


       .segment-1{fill:#ccc;}
       .segment-2{fill:666;}
       .segment-3{fill:#666;}
       .segment-4{fill:#666;}

       .donut-text {
              font-family: Arial, Helvetica, sans-serif;
              fill: #FF6200;
          }
          .donut-text-1 {
              fill: #777;
          }
          .donut-text-2 {
              fill: #d9e021;
          }
          .donut-text-3 {
              fill: #ed1e79;
          }

          .donut-label {
              font-size: 0.28em;
              font-weight: 700;
              line-height: 1;
              fill: #000;
              transform: translateY(0.25em);
          }

          .donut-percent {
              font-size: 0.3em !important;
              line-height: 1;
              transform: translateY(0.5em);
              font-weight: bold;

          }

          .donut-data {
              font-size: 0.1em !important;
              line-height: 1;
              transform: translateY(0.5em);
              font-weight: bold;

          }


       @keyframes donutfade {
         /* this applies to the whole svg item wrapper */
           0% {
               opacity: .2;
           }
           100% {
               opacity: 1;
           }
       }
       @keyframes donutfadelong {
           0% {
               opacity: 0;
           }
           100% {
               opacity: 1;
           }
       }

       @keyframes donut1 {
           0% {
               stroke-dasharray: 0, 100;
           }
           100% {
               stroke-dasharray: <?php echo $capaian;?>, <?php echo $x2;?>;
           }
       }

   </style>
</head>

<body>


        <div class="row">
            <div class="col-6">

                Periode : <?php echo $periode_name;?>

               <h4>
               <a href="<?php echo base_url().'admin/pegawai/detail_pegawai/'.$id_pegawai;?>">
                 <?php echo $nama_pegawai;?>
                </a> 
               </h4>
                <?php echo $nip;?>
                <br>

                <?php echo $jabatan.' @'.$puskesmas;?>


                <p>&nbsp;</p>
                Status &nbsp;&nbsp; :  &nbsp;&nbsp; <?php echo $flag_status;?>

                <?php
                        if($status==0){
                            echo '<a href="'.base_url().'admin/listing_tkd/cekSesuai/'.$dataTKD[0]->id.'" class="btn btn-success">Cek Sesuai</a>';

                        }

                      
                ?>



            </div>

            <div class="col-6">



                  <div class="svg-item">
                    <svg width="100%" height="100%" viewBox="0 0 40 40" class="donut">
                      <circle class="donut-hole" cx="20" cy="20" r="15.91549430918954" fill="#fff"></circle>
                      <circle class="donut-ring" cx="20" cy="20" r="15.91549430918954" fill="transparent" stroke-width="3.5"></circle>
                      <circle class="donut-segment donut-segment-2" cx="20" cy="20" r="15.91549430918954" fill="transparent" stroke-width="3.5" stroke-dasharray="<?php echo $capaian ;?> <?php echo $x2 ;?>" stroke-dashoffset="25"></circle>
                      <g class="donut-text donut-text-1">

                        <text y="50%" transform="translate(0, 2)">
                          <tspan x="50%" text-anchor="middle"  class="donut-percent"><?php echo $capaian ;?> %</tspan>
                        </text>

                        <text y="60%" transform="translate(0, 2)">
                          <tspan x="50%" text-anchor="middle" class="donut-data">Capaian Kinerja</tspan>
                        </text>

                      </g>
                    </svg>
                  </div>

                  <div class="row text-center">
                    <div class="col-md-4 border-end">
                      <h4><?php echo $bobot_aktifitas;?>%</h4>
                       Aktifitas
                    </div>
                    <div class="col-md-4 border-end">
                      <h4><?php echo $perilaku;?>%</h4>
                      Perilaku
                    </div>
                    <div class="col-md-4 ">
                      <h4><?php echo $serapan;?>%</h4>
                      Serapan
                    </div>

                  </div>



            </div>
            <div class="col-12 p-2">

                  <a href="<?php echo base_url().'admin/listing_tkd/update_tkd_pegawai/'.$nip.'/'.$dataTKD[0]->id.'/'.$periode;?>" class="btn btn-info">Update Data</a>

                   <table class="table table-sm table-centered mb-0 font-14 mt-1">
                     <thead class="table-warning">
                           <tr>
                               <th colspan="3">Menit Pengurang</th>

                           </tr>
                       </thead>
                       <tbody>
                           <tr>
                               <td>Terlambat</td>
                               <td><strong>-</td>
                               <td><strong><?php echo $telat;?> </strong> Menit</td>

                           </tr>
                           <tr>
                               <td>Pulang Awal</td>
                               <td><strong>-</td>
                               <td><strong><?php echo $pulang_awal;?> </strong> Menit</td>

                           </tr>
                           <tr>
                               <td>Sakit</td>
                               <td><strong><?php echo $sakit;?></strong>  Hari</td>
                               <td><strong><?php echo $menit_sakit;?> </strong> Menit</td>

                           </tr>
                           <tr>
                               <td>Sakit dng Keterangan</td>
                               <td><strong><?php echo $sakit_dgn_sk;?></strong>  Hari</td>
                               <td><strong><?php echo $menitSakitDenganSK;?> </strong> Menit</td>

                           </tr>
                           <tr>
                               <td>Izin</td>
                               <td> <strong><?php echo $izin;?></strong>  Hari</td>
                               <td><strong><?php echo $menit_izin;?> </strong> Menit</td>

                           </tr>
                           <tr>
                               <td>Alpha</td>
                               <td><strong><?php echo $alpha;?> </strong> Hari</td>
                               <td><strong>0</strong> Menit</td>

                           </tr>

                           <tr class="table-light">
                               <td colspan="2">Total Menit Pengurang</td>
                               <td><strong><?php echo $totalMenitPengurang;?> </strong> Menit</td>

                           </tr>
                       </tbody>
                   </table>

                   <table class="table table-sm table-centered mb-0 font-14 mt-4">
                     <thead class="table-success">
                           <tr>
                               <th colspan="3">Menit Penambah</th>

                           </tr>
                       </thead>
                       <tbody>
                           <tr>
                               <td>Cuti Tahunan</td>
                               <td><strong><?php echo   $hari_cuti_tahunan;?> </strong> Hari</td>


                           </tr>
                           <tr>
                               <td>Cuti Alasan Penting</td>
                              <td><strong><?php echo $alpha;?> </strong> Hari</td>

                           </tr>
                           <tr>
                               <td>Cuti Sakit</td>
                              <td><strong><?php echo $alpha;?> </strong> Hari</td>

                           </tr>
                           <tr>
                               <td>Cuti Bersalin</td>
                            <td><strong><?php echo  $hari_cuti_bersalin ;?> </strong> Hari</td>

                           </tr>
                       </tbody>
                   </table>



            </div>

        </div>
