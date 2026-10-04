<!DOCTYPE html>
<html lang="en">
    
<head>
    <title>Detail Hubdis</title>
</head>

    <body>

    <?php


        $id_hubdis= $hd[0]->id;
        $tgl_hubdis = $hd[0]->tgl_hubdis;
        $nip = $hd[0]->nip;
        $jns_hukuman= $hd[0]->jns_hukuman;
        $kategori= $hd[0]->kategori;
        $no_sk = $hd[0]->no_sk;
        $pejabat_ttd = $hd[0]->pejabat_ttd;
        $tgl_mulai = $hd[0]->tgl_mulai;
        $tgl_akhir = $hd[0]->tgl_akhir;
        $catatan = $hd[0]->catatan;
        $file_hubdis = $hd[0]->file_hubdis;

        if($kategori=='Ringan'){
            $flag_kategori = '<span class="badge bg-info">'.$kategori.'</span>';
        }else if($kategori=='Sedang'){
            $flag_kategori = '<span class="badge bg-warning">'.$kategori.'</span>';
        }else{
            $flag_kategori = '<span class="badge bg-danger">'.$kategori.'</span>';
        }


        $tgl_potong_tkd = format_full($tgl_mulai).' - '.format_full($tgl_akhir);


    ?>
       
            <div class="row">
                <div class="col-12">
                        <h4>Informasi Hukuman Disiplin</h4> 
                        <table class="table">
                            <tr>
                                <td>Tanggal Hubdis</td>
                                <td>:</td>
                                <td><?php echo format_full( $tgl_hubdis);?></td>
                            </tr>
                            <tr>
                                <td>Jenis Hubdis</td>
                                <td>:</td>
                                <td><?php echo  $jns_hukuman;?></td>
                            </tr>
                            <tr>
                                <td>Kategori Hubdis</td>
                                <td>:</td>
                                <td><?php echo $flag_kategori;?></td>
                            </tr>
                            <tr>
                                <td>No SK</td>
                                <td>:</td>
                                <td><?php echo $no_sk;?></td>
                            </tr>
                            <tr>
                                <td>Pejabat Penanda Tangan</td>
                                <td>:</td>
                                <td><?php echo $pejabat_ttd;?></td>
                            </tr>
                            <tr>
                                <td>Tgl Potong TKD</td>
                                <td>:</td>
                                <td><?php echo $tgl_potong_tkd;?></td>
                            </tr>
                            <tr>
                                <td>Catatan</td>
                                <td>:</td>
                                <td><?php echo $catatan;?></td>
                            </tr>
                        </table>
                    
                </div>
            </div>
            
            <?php
                if( $file_hubdis !=''){
                    echo '
                     <h5>SK HUBDIS</h5>

                     <a href="'.base_url().'uploads/hubdis/'.$file_hubdis.'" target="_blank" class="border border-info p-1 mt-2 text-info">'.$file_hubdis.'</a>';
                }else{
                    echo ' <div class="file-upload-izin alert border p-3">
                        <h4>Upload Dokumen HUBDIS :</h4>
                                <p class="text-danger">
                                    Jenis file yang diizinkan : <strong>PDF </strong> <br>
                                    Ukuran Maksimum File      : <strong>2 MB </strong> 
                                </p>

                                
                                <br>
                                <br>
                                <form action="'.base_url().'admin/pegawai/upload_file_hubdis/'. $nip.'/'.$id_hubdis.'" method="post" enctype="multipart/form-data" id="upload_file_pdf">
                                    

                                    <input type="file" name="filedocs" required id="file-input"  />
                                        <label for="file-input">


                                            <div class="btn bg-custom-500 text-white">  
                                            <i data-lucide="folder-open"></i>
                                                Choose Files To Upload
                                            </div> 
                                    </label>

                                    <button type="submit" class="btn btn-success">Upload</button>

                                </form>

                            
                        </div>';
                }
            ?>
           

    </body>
</html>
