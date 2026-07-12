<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pemeriksaan Driver</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <link href="https://googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
     <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">

    <style>
        td a {
            text-decoration: none !important;
        }
    </style>

</head>
<body>
<div class="container-fluid p-0">
    <div class="dashboard-layout">
        <?php $this->load->view('admin/layouts/sidebar'); ?>
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar(false)"></div>
        <div class="main-content">
            <main class="p-4">
                <?php $this->load->view('admin/layouts/navbar'); ?>
                 <div class="d-none d-md-block mb-3">
                    <h4 class="fw-bold mb-1"> Pengemudi</h4>
                   
                    <div class="breadcrums">
                       <a href="<?php echo base_url('admin/dashboard'); ?>">Home</a> / Pengemudi
                    </div>
                </div>



            <div class="card p-4 stat-card">
                  <div class="bg-white mb-3">     
                        <a href="<?php echo base_url();?>admin/admin_driver/add_driver" class="btn btn-primary float-end">
                        <i class="fa fa-plus"></i>  Input Pengemudi</a>
                    </div>


                <div class="table-responsive border-0">
                    <table class="table table-hover" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th align="center">Tanggal Daftar</th>
                                        <th align="center">No KTP</th>
                                        <th align="left">Nama</th>
                                        <th align="center">Tgl Lahir</th>
                                        <th align="center">L/P</th>       
                                        <th align="center">Nama PO</th>
                                        <th align="center">Status</th>
                                        <th align="center">Petugas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php
                                        $no = 0;
                                        for ($i=0; $i < count($driver) ; $i++) { 
                                            
                                                $status_pemeriksaan = $driver[$i]->status_pemeriksaan;
            
                                                if($status_pemeriksaan==0){
                                                    $status_periksa = '<span class="badge bg-warning-light">Belum diperiksa</span>';
                                                }else{
                                                    $status_periksa = '<span class="badge bg-success-light">Sudah diperiksa</span>'; 
                                                }
                                                
                                                
                                            $no = $i+1;
                                            echo ' <tr>
                                                    <td align="center">'.$no .'</td>
                                                    <td align="center">'.format_view($driver[$i]->tgl_daftar).'</td>
                                                    <td align="center">'.$driver[$i]->no_ktp.'</td>
                                                    
                                                    <td>
                                                        <a href="'.base_url().'admin/admin_driver/detail/'.$driver[$i]->id.'" class="text-link">'.$driver[$i]->nama.'</a></td>
                                                    <td align="center">'.format_view($driver[$i]->tgl_lahir).'</td>
                                                    <td  align="center">'.$driver[$i]->jns_kel.'</td>
                                                    <td  align="left">'.$driver[$i]->nama_po.'</td>
                                                    <td  align="center">
                                                        '.$status_periksa.'
                                                    </td>
                                                    <td>'.$driver[$i]->petugas.'</td>
                                                    
                                                </tr>';
                                        }
                                    ?>
                                    

                                
                            </tbody>
                        </table>
								
                </div>
            </div>
            </main>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/main.min.js?v=1628755089081"></script>
<script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>


   
$(document).ready(function(){
  
        
  $('#dataTable').DataTable({
    "pageLength": 25,
    "lengthMenu": [ [25, 50, 100, -1], [25, 50, 100, "All"] ]
  });


  $( function() {
        $( "#datepicker" ).datepicker({
            dateFormat : "dd-mm-yy",
          changeMonth: true
        });
    } );

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

    // Toggle sidebar behavior (matches dashboard main)
    function toggleSidebar(force) {
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        if (!sidebar || !overlay) return;
        const isSmall = window.innerWidth < 1200;

        if (isSmall) {
            const isOpen = sidebar.classList.contains('open');
            if (typeof force === 'boolean') {
                if (force) {
                    sidebar.classList.add('open');
                    overlay.classList.add('active');
                } else {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('active');
                }
            } else {
                if (isOpen) {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('active');
                } else {
                    sidebar.classList.add('open');
                    overlay.classList.add('active');
                }
            }
        } else {
            const isClosed = sidebar.classList.contains('closed');
            if (typeof force === 'boolean') {
                if (force) sidebar.classList.remove('closed');
                else sidebar.classList.add('closed');
            } else {
                if (isClosed) sidebar.classList.remove('closed');
                else sidebar.classList.add('closed');
            }
            overlay.classList.remove('active');
            sidebar.classList.remove('open');
        }
    }
</script>
</body>
</html>
