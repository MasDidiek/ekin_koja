    <script src="<?php echo base_url();?>assets/lib/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url();?>assets/lib/feathericons/feather.min.js"></script>
    <script src="<?php echo base_url();?>assets/lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?php echo JS_PATH; ?>dataTables/jquery.dataTables.js"></script>
    <script src="<?php echo JS_PATH; ?>dataTables/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url();?>assets/js/script.js"></script>
 




   <script>
            $(document).ready(function() {
                $("#list_pegawai").hide();

                    $(".view_detail").dblclick(function(){
                        var id = $(this).attr("id");
                                location.href = "<?php echo base_url();?>cuti/detail_pengajuan_cuti/"+id;
                        
                    });

                    $("#myInput").keydown(function() {
                        var keyword = $(this).val();
                        $("#list_pegawai").show();
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url(); ?>cuti/search_pegawai',
                            data: 'keyword=' + keyword,
                            success: function(return_data) {
                                $("#list_pegawai").html(return_data);
                            }
                        });
                    });
                    
                    
                $(".nav-link").click(function(){
                    var href = $(this).attr("id");
                    location.href = href;
                    
                });
                    

                $('#dataTables-example').dataTable();

                    
            });

           

               

                
</script>