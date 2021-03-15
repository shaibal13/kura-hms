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
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Notice') {
                $permis = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Notice') {
                $permis_2 = 'ok';
                //  break;
            }
        }
        ?>
        <section class="panel">
            <header class="panel-heading">
                <?php echo lang('notice'); ?>
                <?php if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok') { ?>
                    <div class="col-md-4 no-print pull-right"> 
                        <a data-toggle="modal" href="#myModal">
                            <div class="btn-group pull-right">
                                <button id="" class="btn green btn-xs">
                                    <i class="fa fa-plus-circle"></i> <?php echo lang('add_notice'); ?>
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
                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                        <thead>
                            <tr>
                                <th> <?php echo lang('title'); ?></th>
                                <th> <?php echo lang('description'); ?></th>
                                <th> <?php echo lang('notice'); ?> <?php echo lang('for'); ?> </th>
                                <th> <?php echo lang('date'); ?></th>
                                <?php if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok' || $permis_2 == 'ok') { ?>
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
                        <?php foreach ($notices as $notice) { ?>
                            <tr class="">
                                <td> <?php echo $notice->title; ?></td>
                                <td> <?php echo $notice->description; ?></td>
                                <td class="center"><?php echo $notice->type; ?></td>
                                <td> <?php
                                    if (!empty($notice->date)) {
                                        echo date('d-m-Y', $notice->date);
                                    }
                                    ?>
                                </td>
                                <?php if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok' || $permis_2 == 'ok') { ?>
                                    <td>
                                        <?php if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok' || $permis_2 == 'ok') { ?>
                                            <button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="<?php echo $notice->id; ?>"><i class="fa fa-edit"> <?php echo lang('edit'); ?></i></button>   
                                        <?php } ?>                                        
                                        <?php if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok' || $permis_2 == 'ok') { ?>
                                            <a class="btn btn-info btn-xs btn_width delete_button" href="notice/delete?id=<?php echo $notice->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash-o"> <?php echo lang('delete'); ?></i></a>
                                        <?php } ?>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
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




<!-- Add Notice Modal-->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">   <?php echo lang('add_notice'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="notice/addNew" class="clearfix row" method="post" enctype="multipart/form-data">

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('title'); ?></label>
                        <input type="text" class="form-control" name="title" id="exampleInputEmail1" value='<?php
                        if (!empty($notice->name)) {
                            echo $notice->name;
                        }
                        ?>' placeholder="">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('notice_for'); ?></label>
                        <select class="form-control m-bot15" name="type" value=''>
                            <option value="patient" <?php
                            if (!empty($notice->type)) {
                                if ($notice->type == 'patient') {
                                    echo 'selected';
                                }
                            }
                            ?>><?php echo lang('patient'); ?></option>
                            <option value="staff" <?php
                            if (!empty($notice->type)) {
                                if ($notice->type == 'staff') {
                                    echo 'selected';
                                }
                            }
                            ?>><?php echo lang('staff'); ?></option>

                        </select>
                    </div>

                    <div class="form-group col-md-12 des">
                        <label class=""><?php echo lang('description'); ?></label>
                        <div class="">
                            <textarea class="ckeditor form-control editor" id="editor" name="description" value="" rows="10"></textarea>
                        </div>
                    </div>


                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
                        <input type="text" class="form-control default-date-picker" name="date" id="exampleInputEmail1" value='' placeholder="" readonly="">
                    </div>




                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Notice Modal-->







<!-- Edit Notice Modal-->
<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">   <?php echo lang('edit_notice'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editNoticeForm" class="clearfix row" action="notice/addNew" method="post" enctype="multipart/form-data">

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('title'); ?></label>
                        <input type="text" class="form-control" name="title" id="exampleInputEmail1" value='<?php
                        if (!empty($notice->name)) {
                            echo $notice->name;
                        }
                        ?>' placeholder="">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('notice_for'); ?></label>
                        <select class="form-control m-bot15" name="type" value=''>
                            <option value="patient" <?php
                            if (!empty($notice->type)) {
                                if ($notice->type == 'patient') {
                                    echo 'selected';
                                }
                            }
                            ?>><?php echo lang('patient'); ?></option>
                            <option value="staff" <?php
                            if (!empty($notice->type)) {
                                if ($notice->type == 'staff') {
                                    echo 'selected';
                                }
                            }
                            ?>><?php echo lang('staff'); ?></option>

                        </select>
                    </div>  
                    <div class="form-group col-md-12 des">
                        <label class=""><?php echo lang('description'); ?></label>
                        <div class="">
                            <textarea class="ckeditor form-control editor" id="editor" name="description" value="" rows="10"></textarea>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
                        <input type="text" class="form-control default-date-picker" name="date" id="exampleInputEmail1" value='' placeholder="" readonly="">
                    </div>




                    <input type="hidden" name="id" value='<?php
                    if (!empty($notice->id)) {
                        echo $notice->id;
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
<script>
                                    $(document).ready(function () {
                                        var table = $('#editable-sample').DataTable({
                                            responsive: true,
                                            dom: "<'row'<'col-sm-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
                                                    "<'row'<'col-sm-12'tr>>" +
                                                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",

                                            buttons: [
                                                {extend: 'copyHtml5', exportOptions: {columns: [1, 2, 3], }},
                                                {extend: 'excelHtml5', exportOptions: {columns: [1, 2, 3], }},
                                                {extend: 'csvHtml5', exportOptions: {columns: [1, 2, 3], }},
                                                {extend: 'pdfHtml5', exportOptions: {columns: [1, 2, 3], }},
                                                {extend: 'print', exportOptions: {columns: [1, 2, 3], }},
                                            ],
                                            aLengthMenu: [
                                                [10, 25, 50, 100, -1],
                                                [10, 25, 50, 100, "All"]
                                            ],
                                            iDisplayLength: -1,
                                            "order": [[3, "desc"]],
                                            "language": {
                                                "lengthMenu": "_MENU_",
                                                search: "_INPUT_",
                                                "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json"
                                            },

                                        });

                                        table.buttons().container()
                                                .appendTo('.custom_buttons');
                                    });</script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".editbutton").click(function (e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#editNoticeForm').trigger("reset");
            $('#myModal2').modal('show');
            $.ajax({
                url: 'notice/editNoticeByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                // Populate the form fields with the data returned from server

                var de = response.notice.date * 1000;
                var d = new Date(de);
                var date = (d.getDate() + 1) + '-' + (d.getMonth() + 1) + '-' + d.getFullYear();

                $('#editNoticeForm').find('[name="id"]').val(response.notice.id).end()
                $('#editNoticeForm').find('[name="title"]').val(response.notice.title).end()
                $('#editNoticeForm').find('[name="date"]').val(date).end()
                CKEDITOR.instances['editor'].setData(response.notice.description)
            });
        });
    });</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
