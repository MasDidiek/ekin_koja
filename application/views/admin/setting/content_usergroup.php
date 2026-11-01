<div class="page-header d-print-none">
    <div class="container-fluid">
            <div class="row g-2 align-items-center">
                 
                <div class="page-pretitle">
                    Setting
                </div>
            <h3 class="card-title"> <?php echo $title;?> </h3>

            </div>
    </div>
</div>


                        <table class="table table-bordered table-striped" id="data-table">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Usergroup</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                                                        
                                                    

                        <tbody>

                        
                        
                            <?php

                                        $arrayUsergroup = arrayUsergroup();

                                    for ($i=0; $i < count($arrayUsergroup) ; $i++) { 
                                        
                                        $ug_id = $i;
                                        $usergroup_name = $arrayUsergroup[$i];
                                    

                                        echo ' <tr>
                                                    <td class="text-center">'.($i+1).'</td>
                                                    <td class="text-left">'. $usergroup_name.' </td>
                                                    <td class="text-center">
                                                        <a href="'.base_url().'admin/setting/usergroup_hak_akses/'.$ug_id.'"  class="btn btn-small btn-info" >
                                                        <i class="fa-solid fa-user-lock"></i>&nbsp;  Hak Akses
                                                        </a>
                                                    </td>
                                    
                                                </tr>
                                                ';
                                    }
                            ?>

                        </tbody>

                    </table>
            

