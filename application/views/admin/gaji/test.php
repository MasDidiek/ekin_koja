<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    
<div class="container">

        

   <a href="<?php echo base_url();?>admin/gaji/update_all_bpjstk" class="btn btn-primary">Update All</a>

        <table class="table">
                <tr>
                    <th>No</th>
                    <th>ID Pegawai</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Jumlah</th>
                    <th>BPJS TK</th>
                    <th>Action</th>
                </tr>


                <?php

                  
                     $no = 1;
                        foreach ($import as $data) {

                            $nik = $data->nik;
                            $nama = $data->nama;
                            $jumlah = $data->jumlah;

                            $id_pegawai = $this->Pegawai_model->getIDpegawaiByName($nama);
                            $data_gaji = $this->Pegawai_model->getDataGajiPegawai($id_pegawai);
                            

                            $bpjs_tk = $data_gaji[0]->bpjs_tk;

                            if($bpjs_tk == $jumlah){
                                $class = 'text-success';
                            }else{
                                $class = 'text-warning';
                            }

                            echo ' <tr>
                                        <td>'.$no.'</td>
                                        <td>'.$id_pegawai.'</td>
                                        <td>'.$nik.'</td>
                                        <td>'.$nama.'</td>
                                        <td>'.rupiah($jumlah).'</td>
                                        <td class="'.$class.'">'.rupiah($bpjs_tk).'</td>
                                        <td><a href="'.base_url().'admin/gaji/update_bpjstk_perpegawai/'.$id_pegawai.'/'.$jumlah.'" class="btn btn-sm btn-success">
                                        Update
                                        </a></td>
                                    </tr>';

                                    $no+=1;
                        }
                ?>
        
        </table>

</div>
</body>
</html>