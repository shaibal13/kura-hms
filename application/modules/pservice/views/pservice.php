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
        foreach ($permission_access_group_explode as $perm) {
            $perm_explode = array();
            $perm_explode = explode(",", $perm);
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Bed') {
                $permis = 'ok';
                //  break;
            }
             if (in_array('3', $perm_explode) && $perm_explode[0] == 'Bed') {
                $permis_2 = 'ok';
                //  break;
            }
             
        }
        ?>
        <section class="panel">
            <header class="panel-heading">
                <?php echo lang('pservice'); ?>
                <?php if ($this->ion_auth->in_group(array('admin')) || $permis=='ok') { ?>
                    <div class="col-md-4 no-print pull-right"> 
                        <a data-toggle="modal" href="#myModal">
                            <div class="btn-group pull-right">
                                <button id="" class="btn green btn-xs">
                                    <i class="fa fa-plus-circle"></i> <?php echo lang('add_pservice'); ?>
                                </button>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </header>

            <style>
                .form-control {
                    height: auto !important;
                }
            </style>


            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="space15"></div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample1">
                        <thead>
                            <tr>
                                <th> <?php echo lang('no'); ?></th>
                                <th> <?php echo lang('service'); ?>  <?php echo lang('code'); ?></th>
                                <th> <?php echo lang('alpha_code'); ?>  </th>
                                <th> <?php echo lang('service'); ?>  <?php echo lang('name'); ?></th>
                                <th> <?php echo lang('price'); ?></th>
                                <th> <?php echo lang('referential_price'); ?></th>
                                <th> <?php echo lang('special_price'); ?></th>
                                <th> <?php echo lang('active'); ?></th>
                                <?php if ($this->ion_auth->in_group(array('admin'))|| $permis=='ok'|| $permis_2=='ok') { ?>
                                    <th> <?php echo lang('options'); ?></th>
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




<!-- Add Pservice Modal-->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">   <?php echo lang('add_pservice'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="pservice/addNew" class="clearfix row" method="post" enctype="multipart/form-data">

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('service'); ?> <?php echo lang('name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='<?php
                        if (!empty($pservice->name)) {
                            echo $pservice->name;
                        }
                        ?>' placeholder="" required="">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('service'); ?> <?php echo lang('code'); ?></label>
                        <input type="text" class="form-control" name="code" id="exampleInputEmail1" value='<?php
                        if (!empty($pservice->code)) {
                            echo $pservice->code;
                        }
                        ?>' placeholder="" required="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('alpha_code'); ?></label>
                        <input type="text" class="form-control" name="alpha_code" id="exampleInputEmail1" value='<?php
                        if (!empty($pservice->alpha_code)) {
                            echo $pservice->alpha_code;
                        }
                        ?>' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('price'); ?></label>
                        <input type="text" class="form-control" min="0" name="price" id="exampleInputEmail1" value='<?php
                        if (!empty($pservice->price)) {
                            echo $pservice->price;
                        }
                        ?>' placeholder="" required="">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('referential_price'); ?></label>
                        <input type="number" min="0" class="form-control" name="referential_price" id="exampleInputEmail1" value='<?php
                        if (!empty($pservice->referential_price)) {
                            echo $pservice->referential_price;
                        }
                        ?>' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('special_price'); ?></label>
                        <input type="number" min="0" class="form-control" name="special_price" id="exampleInputEmail1" value='<?php
                        if (!empty($pservice->special_price)) {
                            echo $pservice->special_price;
                        }
                        ?>' placeholder="">
                    </div>
                    <div class="form-group col-md-6">

                        <input type="checkbox" class="" name="active" id="exampleInputEmail1" value='1' <?php
                         if (!empty($pservice->id)) {
                        if ($pservice->active == "1") {
                            echo "checked";
                        }
                         }
                        ?>>
                        <label for="exampleInputEmail1"> <?php echo lang('active'); ?></label>
                    </div>

                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Pservice Modal-->







<!-- Edit Pservice Modal-->
<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">   <?php echo lang('edit_pservice'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editPserviceForm" class="clearfix row" action="pservice/addNew" method="post" enctype="multipart/form-data">

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('service'); ?> <?php echo lang('name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='<?php
                        if (!empty($pservice->name)) {
                            echo $pservice->name;
                        }
                        ?>' placeholder="" required="">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('service'); ?> <?php echo lang('code'); ?></label>
                        <input type="text" class="form-control" name="code" id="exampleInputEmail1" value='<?php
                        if (!empty($pservice->code)) {
                            echo $pservice->code;
                        }
                        ?>' placeholder="" required="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('alpha_code'); ?></label>
                        <input type="text" class="form-control" name="alpha_code" id="exampleInputEmail1" value='<?php
                        if (!empty($pservice->alpha_code)) {
                            echo $pservice->alpha_code;
                        }
                        ?>' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('price'); ?></label>
                        <input type="text" class="form-control" min="0" name="price" id="exampleInputEmail1" value='<?php
                        if (!empty($pservice->price)) {
                            echo $pservice->price;
                        }
                        ?>' placeholder="" required="">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('referential_price'); ?></label>
                        <input type="number" min="0" class="form-control" name="referential_price" id="exampleInputEmail1" value='<?php
                        if (!empty($pservice->referential_price)) {
                            echo $pservice->referential_price;
                        }
                        ?>' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('special_price'); ?></label>
                        <input type="number" min="0" class="form-control" name="special_price" id="exampleInputEmail1" value='<?php
                        if (!empty($pservice->special_price)) {
                            echo $pservice->special_price;
                        }
                        ?>' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        
                        <input type="checkbox" class="" name="active" id="exampleInputEmail1" value='' <?php
                         if (!empty($pservice->id)) {
                        if ($pservice->active=="1") {
                            echo "checked";
                        }
                         }
                        ?>>
                        <label for="exampleInputEmail1"> <?php echo lang('active'); ?></label>
                    </div>



                    <input type="hidden" name="id" value='<?php
                    if (!empty($pservice->id)) {
                        echo $pservice->id;
                    }
                    ?>'>
                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Edit Event Modal-->

<script src="common/js/codearistos.min.js"></script>


<script type="text/javascript">
    $(document).ready(function () {
        $(".table").on("click", ".editbutton", function () {
            // e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#editPserviceForm').trigger("reset");
            $('#myModal2').modal('show');
            $.ajax({
                url: 'pservice/editPserviceByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                // Populate the form fields with the data returned from server
                $('#editPserviceForm').find('[name="price"]').val(response.pservice.price).end()
                $('#editPserviceForm').find('[name="referential_price"]').val(response.pservice.referential_price).end()
                $('#editPserviceForm').find('[name="special_price"]').val(response.pservice.special_price).end()
                if (response.pservice.active == "1") {
                    $('#editPserviceForm').find('[name="active"]').prop("checked", true).end()
                } else {
                    $('#editPserviceForm').find('[name="active"]').prop("checked", false).end()
                }
                $('#editPserviceForm').find('[name="name"]').val(response.pservice.name).end()
                $('#editPserviceForm').find('[name="id"]').val(response.pservice.id).end()
                $('#editPserviceForm').find('[name="code"]').val(response.pservice.code).end()
                $('#editPserviceForm').find('[name="alpha_code"]').val(response.pservice.alpha_code).end()

            });
        });
    });</script>
<script>


    $(document).ready(function () {
        var table = $('#editable-sample1').DataTable({
            responsive: true,
            //   dom: 'lfrBtip',

            "processing": true,
            "serverSide": true,
            "searchable": true,
            "ajax": {
                url: "pservice/getPserviceList",
                type: 'POST',
            },
            scroller: {
                loadingIndicator: true
            },
            dom: "<'row'<'col-sm-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
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
                searchPlaceholder: "Search...",
                "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json"
            },
        });
        table.buttons().container().appendTo('.custom_buttons');
    });
</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
