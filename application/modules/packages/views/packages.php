<!--sidebar end-->
<!--main content start-->

<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <?php
        $group_permission = $this->ion_auth->get_users_groups()->row();

        if ($group_permission->name == 'admin' || $group_permission->name == 'Patient' || $group_permission->name == 'Doctor' || $group_permission->name == 'Nurse' || $group_permission->name == 'Pharmacist' || $group_permission->name == 'Laboratorist' || $group_permission->name == 'Accountant' || $group_permission->name == 'Receptionist' || $group_permission->name == 'members') {

            $pers = array();
            $permission_access_group_explode = array();
        } else {
            $pers = explode(',', $group_permission->description);

            $this->db->where('group_id', $group_permission->id);
            $query = $this->db->get('permission_access_group')->row();
            $permission_access_group = $query->permission_access;
            $permission_access_group_explode = explode('***', $permission_access_group);
        }
        $permis = '';
        $permis_2 = '';
        $permis_1 = '';
        foreach ($permission_access_group_explode as $perm) {
            $perm_explode = array();
            $perm_explode = explode(",", $perm);
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Medical-Data') {
                $permis = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Medical-Data') {
                $permis_2 = 'ok';
                //  break;
            }
            if (in_array('1', $perm_explode) && $perm_explode[0] == 'Medical-Data') {
                $permis_1 = 'ok';
                //  break;
            }
        }
        ?>
        <section class="panel">
            <header class="panel-heading">
                <?php echo lang('packages'); ?>  
                <?php if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok') { ?>
                    <div class="col-md-4 no-print pull-right"> 
                        <a href="packages/addPackagesView">
                            <div class="btn-group pull-right">
                                <button id="" class="btn green btn-xs">
                                    <i class="fa fa-plus-circle"></i> <?php echo lang('create_packages'); ?>
                                </button>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="space15"></div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo lang('code'); ?></th>
                                <th><?php echo lang('name'); ?></th>
                                <th><?php echo lang('total_value'); ?></th>
                                <th><?php echo lang('packages'); ?> <?php echo lang('price'); ?></th>
                                  <th><?php echo lang('status'); ?></th>
                                <?php if ($this->ion_auth->in_group(array('admin')) || $permis_1 == 'ok' || $permis_2 == 'ok') { ?>
                                    <th class="no-print"><?php echo lang('options'); ?></th>
                                <?php } ?>
                                </tr>
                            </thead>
                            <tbody>

                            <style>

                                .img_url{
                                    height:20px;
                                    width:20px;
                                    background-size: contain; 
                                    max-height:20px;
                                    border-radius: 100px;
                                }

                            </style>


                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            <!-- page end-->
        </section>
    </section>
    <!--main content end-->
    <!--footer start-->







    <!-- Add Bed Modal-->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title"> <?php echo lang('add_new_category'); ?> </h4>
                </div>
                <div class="modal-body">
                    <form role="form" action="category/addCategory" class="clearfix row" method="post" enctype="multipart/form-data">
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1"><?php echo lang('code'); ?></label>
                            <input type="text" class="form-control" name="code" id="exampleInputEmail1" value='' placeholder="" required="">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1"><?php echo lang('name'); ?></label>
                            <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="" required="">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1"><?php echo lang('description'); ?></label>
                            <input type="text" class="form-control" name="description" id="exampleInputEmail1" value='' placeholder="">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1"><?php echo lang('status'); ?></label>
                            <select class="js-example-basic-single" name="status">
                                <option value="active"><?php echo lang('active'); ?></option>
                                <option value="disable"><?php echo lang('in_active'); ?></option>
                            </select>

                        </div>
                        <div class="form-group col-md-12">
                            <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
                        </div>

                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- Add Accountant Modal-->







    <!-- Edit Event Modal-->
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title"> <?php echo lang('edit_category'); ?> </h4>
                </div>
                <div class="modal-body">
                    <form role="form" id="editCategoryForm" class="clearfix row" action="category/addCategory" method="post" enctype="multipart/form-data">
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1"><?php echo lang('code'); ?></label>
                            <input type="text" class="form-control" name="code" id="exampleInputEmail1" value='' placeholder="" required="">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1"><?php echo lang('name'); ?></label>
                            <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="" required="">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1"><?php echo lang('description'); ?></label>
                            <input type="text" class="form-control" name="description" id="exampleInputEmail1" value='' placeholder="">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1"><?php echo lang('status'); ?></label>
                            <select class="js-example-basic-single" name="status">
                                <option value="active"><?php echo lang('active'); ?></option>
                                <option value="disable"><?php echo lang('in_active'); ?></option>
                            </select>

                        </div>
                        <input type="hidden" name="id" value=''>

                        <div class="form-group col-md-12">
                            <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
                        </div>

                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- Edit Event Modal-->

    <script src="common/js/codearistos.min.js"></script>




    <script>


        $(document).ready(function () {
            var table = $('#editable-sample').DataTable({
                responsive: true,
                //   dom: 'lfrBtip',

                "processing": true,
                "serverSide": true,
                "searchable": true,
                "ajax": {
                    url: "packages/getPackagesList",
                    type: 'POST',
                },
                scroller: {
                    loadingIndicator: true
                },
                dom: "<'row'<'col-md-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                buttons: [
                    {extend: 'copyHtml5', exportOptions: {columns: [0, 1, 2, 3, 4], }},
                    {extend: 'excelHtml5', exportOptions: {columns: [0, 1, 2, 3, 4], }},
                    {extend: 'csvHtml5', exportOptions: {columns: [0, 1, 2, 3, 4], }},
                    {extend: 'pdfHtml5', exportOptions: {columns: [0, 1, 2, 3, 4], }},
                    {extend: 'print', exportOptions: {columns: [0, 1, 2, 3, 4], }},
                ],
                aLengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                iDisplayLength: 100,
                "order": [[0, "desc"]],
                "language": {
                    "lengthMenu": "_MENU_",
                    search: "_INPUT_",
                    "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json"
            }
        });
        table.buttons().container().appendTo('.custom_buttons');
    });
</script>


<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>

