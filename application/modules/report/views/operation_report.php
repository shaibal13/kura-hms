
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
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Report') {
                $permis = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Report') {
                $permis_2 = 'ok';
                //  break;
            }
        }
        ?>

        <section class="panel">
            <header class="panel-heading">
                <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Laboratorist', 'Doctor')) || $permis == 'ok') { ?>
                    <?php echo lang('operation_report'); ?>
                    <div class="col-md-4 no-print pull-right"> 
                        <a data-toggle="modal" href="#myModal">
                            <div class="btn-group pull-right">
                                <button id="" class="btn green btn-xs">
                                    <i class="fa fa-plus-circle"></i> <?php echo lang('add_new_report'); ?>
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
                                <th><?php echo lang('patient'); ?></th>
                                <th><?php echo lang('description'); ?></th>
                                <th><?php echo lang('doctor'); ?></th>
                                <th><?php echo lang('date'); ?></th>
                                <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Laboratorist', 'Doctor')) || $permis == 'ok' || $permis_2 == 'ok') { ?>
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

                        <?php foreach ($reports as $report) { ?>
                            <tr class="">
                                <td><?php echo explode('*', $report->patient)[0]; ?></td>
                                <td> <?php echo $report->description; ?></td>
                                <td><?php echo $report->doctor; ?></td>
                                <td class="center"><?php echo $report->date; ?></td>
                                <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Laboratorist', 'Doctor')) || $permis == 'ok' || $permis_2 == 'ok') { ?>
                                    <td class="no-print">
                                        <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Laboratorist', 'Doctor')) || $permis == 'ok') { ?>
                                            <button type="button" class="btn btn-info btn-xs btn_width editbutton" title="<?php echo lang('edit'); ?>" data-toggle="modal" data-id="<?php echo $report->id; ?>"><i class="fa fa-edit"></i> </button>   
                                        <?php } ?>
                                        <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Laboratorist', 'Doctor')) || $permis_2 == 'ok') { ?>
                                            <a class="btn btn-info btn-xs btn_width delete_button" href="report/delete?id=<?php echo $report->id; ?>" title="<?php echo lang('delete'); ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>
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








<!-- Add Accountant Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('add_new_report'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="report/addReport" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('select_type'); ?></label>
                        <select class="form-control m-bot15" name="type" value=''>
                            <option value="birth" <?php
                            if (!empty($report->report_type)) {
                                if ($report->report_type == 'birth') {
                                    echo 'selected';
                                }
                            }
                            ?>><?php echo lang('birth'); ?></option>
                            <option value="operation" <?php
                            if (!empty($report->report_type)) {
                                if ($report->report_type == 'operation') {
                                    echo 'selected';
                                }
                            }
                            ?>><?php echo lang('operation'); ?></option>
                            <option value="expire" <?php
                            if (!empty($report->report_type)) {
                                if ($report->report_type == 'expire') {
                                    echo 'selected';
                                }
                            }
                            ?>><?php echo lang('expire'); ?></option>
                        </select>
                    </div>
                    <div class="form-group">


                        <label for="exampleInputEmail1"><?php echo lang('description'); ?></label>
                        <input type="text" class="form-control" name="description" id="exampleInputEmail1" value='' placeholder="">

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('patient'); ?></label>
                        <select class="form-control m-bot15" name="patient" value=''> 
                            <?php foreach ($patients as $patient) { ?>
                                <option value="<?php echo $patient->name . '*' . $patient->ion_user_id; ?>" <?php
                                if (!empty($report->patient)) {
                                    if (explode('*', $report->patient)[1] == $patient->ion_user_id) {
                                        echo 'selected';
                                    }
                                }
                                ?> ><?php echo $patient->name; ?> </option>
                                    <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('doctor'); ?></label>
                        <select class="form-control m-bot15" name="doctor" value=''> 
                            <?php foreach ($doctors as $doctor) { ?>
                                <option value="<?php echo $doctor->name; ?>" <?php
                                if (!empty($report->doctor)) {
                                    if ($report->doctor == $doctor->name) {
                                        echo 'selected';
                                    }
                                }
                                ?> ><?php echo $doctor->name; ?> </option>
                                    <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('date'); ?></label>
                        <input class="form-control form-control-inline input-medium default-date-picker" name="date"  size="16" type="text" readonly="" value="" />

                    </div>
                    <input type="hidden" name="id" value=''>
                    <div class="">
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
                <h4 class="modal-title"><i class="fa fa-edit"></i> <?php echo lang('edit_operation_report'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editReportForm" action="report/addReport" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('select_type'); ?></label>
                        <select class="form-control m-bot15" name="type" value=''>
                            <option value="birth" <?php
                            if (!empty($report->report_type)) {
                                if ($report->report_type == 'birth') {
                                    echo 'selected';
                                }
                            }
                            ?>><?php echo lang('birth'); ?></option>
                            <option value="operation" <?php
                            if (!empty($report->report_type)) {
                                if ($report->report_type == 'operation') {
                                    echo 'selected';
                                }
                            }
                            ?>><?php echo lang('operation'); ?></option>
                            <option value="expire" <?php
                            if (!empty($report->report_type)) {
                                if ($report->report_type == 'expire') {
                                    echo 'selected';
                                }
                            }
                            ?>><?php echo lang('expire'); ?></option>
                        </select>
                    </div>
                    <div class="form-group">


                        <label for="exampleInputEmail1"><?php echo lang('description'); ?></label>
                        <input type="text" class="form-control" name="description" id="exampleInputEmail1" value='' placeholder="">

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('patient'); ?></label>
                        <select class="form-control m-bot15" name="patient" value=''> 
                            <?php foreach ($patients as $patient) { ?>
                                <option value="<?php echo $patient->name . '*' . $patient->ion_user_id; ?>" <?php
                                if (!empty($report->patient)) {
                                    if (explode('*', $report->patient)[1] == $patient->ion_user_id) {
                                        echo 'selected';
                                    }
                                }
                                ?> ><?php echo $patient->name; ?> </option>
                                    <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('doctor'); ?></label>
                        <select class="form-control m-bot15" name="doctor" value=''> 
                            <?php foreach ($doctors as $doctor) { ?>
                                <option value="<?php echo $doctor->name; ?>" <?php
                                if (!empty($report->doctor)) {
                                    if ($report->doctor == $doctor->name) {
                                        echo 'selected';
                                    }
                                }
                                ?> ><?php echo $doctor->name; ?> </option>
                                    <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('date'); ?></label>
                        <input class="form-control form-control-inline input-medium default-date-picker" name="date" readonly="" size="16" type="text" value="" />

                    </div>
                    <input type="hidden" name="id" value=''>
                    <div class="">
                        <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
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
                                        $(".editbutton").click(function (e) {
                                            e.preventDefault(e);
                                            // Get the record's ID via attribute  
                                            var iid = $(this).attr('data-id');
                                            $('#editReportForm').trigger("reset");

                                            $.ajax({
                                                url: 'report/editReportByJason?id=' + iid,
                                                method: 'GET',
                                                data: '',
                                                dataType: 'json',
                                            }).success(function (response) {
                                                // Populate the form fields with the data returned from server
                                                $('#editReportForm').find('[name="id"]').val(response.report.id).end()
                                                $('#editReportForm').find('[name="type"]').val(response.report.type).end()
                                                $('#editReportForm').find('[name="description"]').val(response.report.description).end()
                                                $('#editReportForm').find('[name="patient"]').val(response.report.patient).end()
                                                $('#editReportForm').find('[name="doctor"]').val(response.report.doctor).end()
                                                $('#editReportForm').find('[name="date"]').val(response.report.date).end()
                                                $('#myModal2').modal('show');
                                            });

                                        });
                                    });
</script>
<script>
    $(document).ready(function () {
        var table = $('#editable-sample').DataTable({
            responsive: true,

            dom: "<'row'<'col-sm-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",

            buttons: [
                {extend: 'copyHtml5', exportOptions: {columns: [0, 1, 2, 3], }},
                {extend: 'excelHtml5', exportOptions: {columns: [0, 1, 2, 3], }},
                {extend: 'csvHtml5', exportOptions: {columns: [0, 1, 2, 3], }},
                {extend: 'pdfHtml5', exportOptions: {columns: [0, 1, 2, 3], }},
                {extend: 'print', exportOptions: {columns: [0, 1, 2, 3], }},
            ],
            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            iDisplayLength: -1,
            "order": [[0, "desc"]],

            "language": {
                "lengthMenu": "_MENU_",
                search: "_INPUT_",
                "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json"
            },

        });

        table.buttons().container()
                .appendTo('.custom_buttons');
    });
</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
