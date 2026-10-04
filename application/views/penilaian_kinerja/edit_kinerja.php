<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <h1>Update Aktifitas</h1>

<?php
 $id_pegawai = $this->uri->segment(4);

?>
    <form method="post" action="<?php echo base_url();?>admin/penilaian_kinerja/update_aktifitas/<?php echo $id_pegawai;?>">

     <button type="submit" class="btn btn-info">Update</button>

    <table class="table">
    <thead class="bg-slate-100 dark:bg-zink-600">
                                                        <tr>
                                                            
                                                            <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500" scope="col" style="width: 50px;">
                                                               
                                                            </th>
                                                            <th>No</th>

                                                            <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="jam">Jam</th>
                                                            <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="kegiatan"> Kegiatan</th>
                                                            <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="waktu">waktu</th>
                                                            <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="volume">Volume</th>
                                                            <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="Total">Total</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody class="list form-check-all">
                                                        

                                                        <?php

                                                                $no = 1;
                                                            
                                                                $tgl_first = '';

                                                                $totalVolume =  0;
                                                                foreach ($dataAktifitasPegawai as $list ) {

                                                                        $id = $list->id;
                                                                        $tgl = $list->tgl;
                                                                        $nama = $list->nama_kegiatan;
                                                                        $jns_kegiatan = $list->jns_kegiatan;
                                                                        $jam_mulai = $list->jam_mulai;
                                                                
                                                                        $jam_selesai = $list->jam_selesai;
                                                                        $total = $list->total;
                                                                        $status= $list->status;
                                                                        $keterangan= $list->ket;
                                                                       // $volume = $list->volume;
                                                                        $waktu_efektif = $list->waktu_efektif;

                                                                        $totalVolume = $totalVolume+$total;


                                                                        if($jns_kegiatan==1){
                                                                            $jns = 'Utama';
                                                                        }else{
                                                                            $jns = 'Tambahan';
                                                                        }

                                                                        if($status==0){
                                                                            $flag = '<span class="px-2.5 py-0.5 text-xs inline-block font-medium rounded border bg-orange-100 border-orange-200 text-orange-500 dark:bg-orange-500/20 dark:border-orange-500/20">Pending</span>';
                                                                        }else if($status==1){
                                                                            $flag = '<span class="px-2.5 py-0.5 text-xs inline-block font-medium rounded border bg-green-100 border-green-200 text-green-500 dark:bg-green-500/20 dark:border-green-500/20">Disetujui</span>';
                                                                        }else{
                                                                            $flag = '<span class="px-2.5 py-0.5 text-xs inline-block font-medium rounded border bg-red-100 border-red-200 text-red-500 dark:bg-red-500/20 dark:border-red-500/20">Ditolak</span>';
                                                                        }


                                                                        $to_time   = strtotime($jam_mulai);
                                                                        $from_time = strtotime($jam_selesai);
                                                                        $diff      = round(abs($to_time - $from_time) / 60, 2);


                                                                        $wktu = number_format($diff / $waktu_efektif, 2);

                                                                        $expl = explode(".", $wktu);
                                                                        $ex1  = $expl[0];
                                                                        $ex2  = @$expl[1];

                                                                        if ($ex2 < 60) {
                                                                            $volume = $ex1;
                                                                        } else {

                                                                            $volume = $ex1 + 1;
                                                                        }


                                                                        
                                                                        $date = date('d', strtotime($tgl));
                                                                        
                                                                        $jam = date('H:i', strtotime($jam_mulai)).' - '.date('H:i', strtotime($jam_selesai));
                                                                        
                                                                            if($tgl_first !=$tgl){
                                                                                echo '
                                                                                <tr class="bg-slate-100 dark:bg-zink-600">
                                                                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500" scope="col" style="width: 50px;">
                                                                                        <input class="check-semua border rounded-sm appearance-none cursor-pointer size-4 bg-slate-100 border-slate-200 dark:bg-zink-600 dark:border-zink-500 checked:bg-custom-500 checked:border-custom-500 dark:checked:bg-custom-500 dark:checked:border-custom-500 checked:disabled:bg-custom-400 checked:disabled:border-custom-400" type="checkbox" id="checkAll_'.$date.'" value="'.$date.'">
                                                                                    </th>
                                                                                    <th  colspan="2" class="text-left px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500" scope="row">
                                                                                    '.getNamahari($tgl).', '.formatTanggalIndo($tgl).'</th>
                                                                                    <th class="text-left" colspan="5"></th>
                                                                                   
                                                                                </tr>';
                                                                              
                                                             
                                                                            }
                                                                           
                                                                            
                                                                            
                                                                               echo '<tr> 
                                                                                        <th class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500" scope="row">
                                                                                         <input type="hidden" name="id[]" value="'.$id.'">

                                                                                          <input type="hidden" name="waktu_efektif[]" value="'.$waktu_efektif.'">
                                                                                            <input class="border rounded-sm appearance-none cursor-pointer size-4 bg-slate-100 border-slate-200 dark:bg-zink-600 dark:border-zink-500 checked:bg-custom-500 checked:border-custom-500 dark:checked:bg-custom-500 dark:checked:border-custom-500 checked:disabled:bg-custom-400 checked:disabled:border-custom-400 form-check-all'.$date.'" type="checkbox" name="chk_child">
                                                                                        </th>
                                                                                        <th class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 id" style="display:none;"><a href="javascript:void(0);" class="fw-medium link-primary id">'.$id.'</a></th>	
                                                                                        <th class="text-center px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">'.$no.'</th>
                                                                                        <td class="text-center px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 tgl">'.$jam.' <br> 
                                                                                         (<strong class="text-dark-500"> '.$total.' </strong> <span class="text-slate-500">  menit </span>)</td>
                                                                                    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 kegiatan">
                                                                                        <span class="text-bold"> '.$nama.' </span>
                                                                                        <br> <span class="text-muted">'.$keterangan.'</span> <br> <span class="status'.$id.'">'.$flag.'</span>
                                                                                        </td>
                                                                                        <td class="text-right px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 waktu">'.$waktu_efektif.'</td>
                                                                                        <td class="text-right  px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 volume">
                                                                                        <input type="number" name="volume[]" value="'.$volume.'"></td>
                                                                                        <td class="text-right  px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 volume">'.$total.'</td>
                                                                                       
                                                                                        
                                                                                   
                                                                                   </tr>';



                                                                                $tgl_first =$tgl;
                                                                                

                                                                $no+=1;
                                                               
                                                             
                                                            }

                                                            $totalVolume = 0;
                                                            
                                                          

                                                        ?>

                                                    </tbody>

                                                        </form>
    </table>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>