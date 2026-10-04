
<!DOCTYPE html>
<html>
<head>
    <title>Datalist TKD</title>

<link rel="shortcut icon" href="images/favicon.png" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">


<link rel="stylesheet" href="https://cdn.datatables.net/2.1.0/css/dataTables.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.0/css/buttons.dataTables.css">


</head>
<body>
    

        




    <div class="wrap">
      
            <div class="form-header">
                <h3>DATA LIST</h3>
               
            </div>

          
          
       
			<table id="example" class="display nowrap" style="width:100%">
					<thead>
						<tr>
							<th style="text-align:center" width="20">#</th>
							<th style="text-align:center">Nama</th>
							<th style="text-align:center">Jabatan</th>
							<th style="text-align:center">NPWP</th>
							<th style="text-align:center">TKD Pokok</th>
							<th style="text-align:center" width="50">Capaian</th>
							<th style="text-align:center">TKD Brutto</th>
							<th style="text-align:center">PPH 21</th>
							<th style="text-align:center">BPJS Kesehatan 2%</th>
							<th style="text-align:center">Jamsostek 3%</th>
                            <th style="text-align:center">Jumlah Diterima</th>
							<th style="text-align:center">No Rekening</th>
                            <th style="text-align:center">Note</th>



						</tr>
					</thead>

					<tbody>
              
                            <?php

                            #print_array($data_tkd);
                            $totalBruto = 0;
                            $totalpph = 0;
                            $totalthp = 0;
                            $note = '';
                            $grandTotal = 0;
                           
                            $totalKes = 0;
                            $totalTK = 0;
                            for ($a = 0; $a < count($data_tkd); $a++) {
                                $nama = $data_tkd[$a]->nama;
                                $tkd_pokok = $data_tkd[$a]->tkd_pokok;
                                $totalCapaian = $data_tkd[$a]->capaian;
                                $tkd_bruto  = $data_tkd[$a]->bruto;
                                $pph21      = $data_tkd[$a]->pph21;
                                $bpjs       = $data_tkd[$a]->bpjs;
                                $bpjs_tk    = $data_tkd[$a]->bpjs_tk;
                                $thp        = $data_tkd[$a]->thp;
                                $masa_kerja = $data_tkd[$a]->masa_kerja;
                                //$lebih_bayar = $data_tkd[$a]->lebih_bayar;
                                $lebih_bayar =  0;

                                $explodMasaKerja = explode(" ",$masa_kerja);
                                $masa_tahun = $explodMasaKerja[0];
                                $masa_bulan = $explodMasaKerja[3];

                               
                                // if($masa_tahun == 0 && $masa_bulan < 4){
                                //   $tkd_bruto = ($tkd_bruto*75/100);
                                // }
                               

                        
                                $color = "color: green";
                                if ($totalCapaian < 95) {
                                    $color = "color: orange";
                                }

                                if ($totalCapaian < 90) {
                                    $color = "color: red";
                                }

                                $totalKes = $totalKes +$bpjs;
                                $totalTK = $totalTK +$bpjs_tk;


                                $totalpph = $totalpph + $pph21;

                                $grandTotal = $grandTotal+$thp;
                                $totalCapaian = str_replace(".", ",", $totalCapaian);

                                $totalBruto = $totalBruto + $tkd_bruto  ;

                                

                            ?>
                                <tr>
                                    <td class="sort-no" style="text-align:center"><?php echo ($a + 1); ?></td>
                                    <td class="sort-name" style="text-align:left !important">
                                      
                                            <?php echo ucwords(strtolower($nama)); ?>
                                    </td>
                                    <td class="sort-city" style="text-align:right !important"><?php echo $data_tkd[$a]->jabatan; ?></td>
                                    <td class="sort-city" style="text-align:right !important"><?php echo $data_tkd[$a]->npwp; ?></td>
                                    <td class="sort-city" style="text-align:right !important"><?php echo $tkd_pokok; ?></td>
                                    <td class="sort-type" style="text-align:center;  <?php echo  $color; ?>"><?php echo  $totalCapaian; ?> </td>
                                    <td class="sort-score" style="text-align:right !important"><?php echo noCommas($tkd_bruto); ?></td>
                                    <td class="sort-date" style="text-align:right !important"><?php echo noCommas($pph21); ?></td>
                                    <td class="sort-quantity" style="text-align:right !important"><?php echo noCommas($bpjs); ?></td>
                                    <td class="sort-progress" style="text-align:right !important"> <?php echo noCommas($bpjs_tk); ?> </td>
                                    <td class="sort-thp strong" style="text-align:right !important; font-weight:bold"> <?php echo noCommas($thp); ?> </td>
               
                                    <td class="sort-city" style="text-align:right !important"><?php echo $data_tkd[$a]->no_rekening; ?></td>
                                    <td><?php echo $note ; ?></td>
                                </tr>

                            <?php } ?>

                      

                        </tbody>

                        
                        <tr>
                                <th colspan="6"> Total</th>

                                <th style="text-align:right !important"> <?php echo rupiah($totalBruto); ?></th>
                                <th style="text-align:right !important"><?php echo rupiah($totalpph); ?></th>
                                <th><?php echo rupiah($totalKes); ?> </th>
                                <th><?php echo rupiah($totalTK); ?> </th>
                                <th style="text-align:right !important"> <?php echo rupiah($grandTotal); ?></th>
                                <th></th>
                            </tr>
                            

              
          </table>
         
          
                
    </div><!--/.wrap-->
</body>

        <script src="<?php echo LIBS_JS_PATH;?>jquery/dist/jquery.min.js"></script>
        <script src="<?php echo NEW_JS_PATH;?>app.min.js"></script>

        <script src="https://cdn.datatables.net/buttons/3.1.0/js/dataTables.buttons.js"></script>

        <script src="https://cdn.datatables.net/buttons/3.1.0/js/buttons.dataTables.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.1.0/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.1.0/js/buttons.print.min.js"></script>
<script>
new DataTable('#example', {
    layout: {
        topStart: {
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        }
    }
});

</script>
</html>