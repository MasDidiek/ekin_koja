<form action="<?php echo base_url(); ?>admin/setting/update_sort" method="post">

    <a href="#" class="btn btn-primary mb-4 float-end " data-bs-toggle="modal" data-bs-target="#modal-report"><i class="fa-solid fa-plus"></i>&nbsp; Add Menu </a>
    <button type="submit" class="btn btn-success float-end mb-4 me-2"> <i class="fa-solid fa-floppy-disk"></i> &nbsp; Update </button>
    <div class="clearfix"></div>


    <div class="table-responsive">
        <table class="table table-bordered table-sm">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Menu Name</th>
                    <th>Controller</th>
                    <th>Link</th>
                    <th>Icon</th>
                    <th>Sort</th>
                    <th>Action</th>
                </tr>
            </thead>



            <tbody>



                <?php
                for ($i = 0; $i < count($menu); $i++) {
                    $id_menu = $menu[$i]->id_menu;
                    $menu_name = $menu[$i]->menu_name;

                    $icon = $menu[$i]->icon;

                    $childMenu = $this->Master_model->getListMenu($menu_type = 'C', 0);


                    echo ' <tr>
                            <td class="text-center">' . ($i + 1) . '</td>
                            <td class="text-start">
                            <a href="' . base_url() . 'admin/setting/menu_level_2/' . $id_menu . '">' . $menu_name . '</a></td>
                            <td class="text-start">' . $menu[$i]->controller . '</td>
                            <td class="text-start">' . $menu[$i]->link . '</td>
                            <td class="text-center">' . $icon . '</td>
                            <td class="text-center">
                                <input type="hidden" name="id_menu[]" value="' . $id_menu . '">
                                <input type="text" name="sort[]" style="width:80px" class="form-control" value="' . $menu[$i]->sort . '">
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm text-info" value="' . $id_menu . '" data-bs-toggle="modal" data-bs-target="#modal-report">
                                <i class="fa-solid fa-pen-to-square"></i>&nbsp;  Edit </button>
                            </td>
            
                        </tr>
                        ';
                }
                ?>

            </tbody>

        </table>
    </div><!--table-responsive-->

</form>



<div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="<?php echo base_url(); ?>admin/setting/insert_menu" method="post">

                <div class="modal-header">
                    <h5 class="modal-title">Add New Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Menu Name</label>
                                <input type="text" class="form-control" name="menu_name" required placeholder="Nama Menu">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Menu Link</label>
                                <input type="text" class="form-control" name="url" required>
                            </div>
                        </div>
                    </div>


                    <div class="row">

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Controller</label>
                                <input type="text" class="form-control" name="controller" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Menu Icon</label>
                                <div class="input-group input-group-flat">

                                    <input type="text" class="form-control" name="icon" autocomplete="off" required>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>




                <div class="modal-footer">
                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary ms-auto">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Save
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>