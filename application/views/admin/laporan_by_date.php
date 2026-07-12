<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPUSPA | PKC Cakung</title>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
     <link rel="stylesheet" href="<?php echo base_url();?>assets/css/admin.css">
     <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
     <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
    $( function() {
        $( "#datepicker" ).datepicker({
            dateFormat : "dd-mm-yy",
          changeMonth: true
        });
    } );
    </script>

    <style>


        td a{
            color: #1a6bb8;
        }
        td a:hover{
            color: #0b4b6d;
            text-decoration: underline !important;
        }

        .main-content{
            overflow:scroll;
        }
       
        .table-report{
            overflow:scroll;
            width:auto;
        }
        
        .table-report th{
            border: 1px solid #CCC;
             background: #EEE;
             color:#333

        }

        .mytable td{
            border: 1px solid #EEE;
        }

        .badge{
            background-color: #EEE;
            padding: 3px 10px;
            font-size: 10px;
            border-radius: 8px;
        }

        .badge-success{
            background-color: #43e17c;
            color: #FFF;
        }

        .btn-disabled{
            background:#EEE;
            color:#999;
        }
        
        .btn-disabled:hover{
            background:orange;
            color:#FFF;
        }
    </style>

     
</head>
<body>

    <div class="wrapper">
        <!--Top menu -->

        <div class="sidebar">
           <!--profile image & text-->
           <?php $this->load->view('admin/master/sidebar_profile');?>
            


            <!--menu item-->
            <?php $this->load->view('admin/master/menu');?>


        </div><!--close sidebar-->

        <div id="main" class="main-content">
            <h2 class="title-page">Laporan Pengemudi</h2>
            <br>

            <a href="<?php echo base_url();?>admin/admin_laporan/index" class="btn btn-disabled">Laporan By Name</a>
            <a href="<?php echo base_url();?>admin/admin_laporan/by_date" class="btn btn-info">Laporan By Date</a>
            <br> <br>

            <table class="table-report">
                <thead>
                    <tr>
                        <th  rowspan="2">No</th>
                        <th align="left" rowspan="2">Tanggal</th>
                        <th align="center"  rowspan="2">Terminal</th>
                        <th align="center" colspan="4">Tekanan Darah</th>
                        <th align="center" colspan="3">GDS</th>
                        <th align="center" colspan="3">Test Keseimbangan</th>
                        <th align="center" colspan="3">Amphetamin Urine</th>
                        <th align="center" colspan="3">Rekomendasi Pengemudi</th>
                        <th align="center" rowspan="2">Dirujuk</th>
                       
                    </tr>
                    <tr>
                        <th>Normal</th>
                        <th>HT Ringan</th>
                        <th>HT Sedang</th>
                        <th>HT Berat</th>
                        <th>80 mg/dl - 200 mg/dl</th>
                        <th>>200 mg/dl tanpa gejala penyerta</th>
                        <th>>200 mg/dl dengan gejala penyerta</th>
                        <th>Normal</th>
                        <th>Tidak Normal 1</th>
                        <th>Tidak Normal 2</th>
                        <th>Amphetamin (-)</th>
                        <th>Amphetamin Tdk Diperika</th>
                        <th>Amphetamin (+)</th>
                        <th>Laik Mengemudi</th>
                        <th>Laik Dgn Catatan</th>
                        <th>Tidak Laik</th>
                    </tr>
                </thead>

                <tbody>
                  
                   
                </tbody>
            </table>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>


  <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>



  <script>


   
        $(document).ready(function(){
          
                
          $('#dataTable').DataTable({
            "pageLength": 50
          });


          $("#filter_bydatae").click(function(){
                $(this).html('loading');
               
                var tgl = $("#datepicker").val();


                $.ajax({
                    type: "POST",
                    dataType: "html",
                    url: "<?php echo  base_url() . 'admin/admin_driver/create_session_date'; ?>",
                    data: "tgl=" + tgl,
                    success: function(msg) {
                        window.location.reload();
                    }
                });

            });

        });

  </script>
</body>
</html>
