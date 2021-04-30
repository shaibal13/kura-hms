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
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Lab') {
                $permis = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Lab') {
                $permis_2 = 'ok';
                //  break;
            }
        }
        ?>
        <section class="col-md-12"> 
            <header class="panel-heading">
                <?php echo lang('lab_report'); ?>

            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="space15"></div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo lang('patient'); ?></th>

                                <th style="width: 15%"><?php echo lang('case'); ?> <?php echo lang('title'); ?></th>
                                <th style="width: 15%"><?php echo lang('description'); ?> </th>
                                <th style="width: 15%"><?php echo lang('status'); ?> </th>
                                <th><?php echo lang('case_nr'); ?></th>

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
                            .option_th{
                                width:18%;
                            }

                        </style>
                        <?php
                        $i = 0;
                        foreach ($cases_manager as $case) {
                            $i = $i + 1;
                            ?>
                            <tr>
                                <td><?php echo $i; ?> </td>
                                <td><?php echo $this->db->get_where('patient', array('id' => $case->patient_id))->row()->name; ?> </td>

                                <td><?php echo $case->title; ?></td>
                                <td><?php
                                    $descriptions = explode('##', $case->description);
                                    foreach ($descriptions as $description) {
                                        $description_single = array();
                                        $description_single = explode('**', $description);
                                        if ($description_single[0] == 'Package') {
                                            ?>
                                            <ul><li> <?php echo lang('package'); ?> - <?php echo $description_single[1]; ?></li></ul>
                                        <?php } else { ?>
                                            <ul><li> <?php echo $description_single[1]; ?></li></ul>
                                            <?php
                                        }
                                    }
                                    ?></td>
                                <td>  <?php
                                    if ($case->status == 'Pending Confirmation') {
                                        echo lang('pending_confirmation');
                                    } if ($case->status == 'Confirmed') {
                                        echo lang('confirmed');
                                    }
                                    ?> </td>

                                <td> <button type="button" class="btn btn-info btn-xs btn_width editbutton_show" data-toggle="modal" data-id="case-<?php echo $case->id; ?>"><i class="fa fa-plus-circle"></i></button></td>

                            </tr>
                        <?php } ?>
                                <?php
                       
                        foreach ($pre_medical_surgery as $case) {
                            $i = $i + 1;
                            ?>
                            <tr>
                                <td><?php echo $i; ?> </td>
                                <td><?php echo $this->db->get_where('patient', array('id' => $case->patient_id))->row()->name; ?> </td>

                                <td><?php echo $case->title; ?></td>
                                <td><?php
                                    $descriptions = explode('##', $case->description);
                                    foreach ($descriptions as $description) {
                                        $description_single = array();
                                        $description_single = explode('**', $description);
                                        if ($description_single[0] == 'Package') {
                                            ?>
                                            <ul><li> <?php echo lang('package'); ?> - <?php echo $description_single[1]; ?></li></ul>
                                        <?php } else { ?>
                                            <ul><li> <?php echo $description_single[1]; ?></li></ul>
                                            <?php
                                        }
                                    }
                                    ?></td>
                                <td>  <?php
                                    if ($case->status == 'Pending Confirmation') {
                                        echo lang('pending_confirmation');
                                    } if ($case->status == 'Confirmed') {
                                        echo lang('confirmed');
                                    }
                                    ?> </td>

                                <td> <button type="button" class="btn btn-info btn-xs btn_width editbutton_show" data-toggle="modal" data-id="precase-<?php echo $case->id; ?>"><i class="fa fa-plus-circle"></i></button></td>

                            </tr>
                        <?php } ?>
                             <?php
                       
                        foreach ($on_medical_surgery as $case) {
                            $i = $i + 1;
                            ?>
                            <tr>
                                <td><?php echo $i; ?> </td>
                                <td><?php echo $this->db->get_where('patient', array('id' => $case->patient_id))->row()->name; ?> </td>

                                <td><?php echo $case->title; ?></td>
                                <td><?php
                                    $descriptions = explode('##', $case->description);
                                    foreach ($descriptions as $description) {
                                        $description_single = array();
                                        $description_single = explode('**', $description);
                                        if ($description_single[0] == 'Package') {
                                            ?>
                                            <ul><li> <?php echo lang('package'); ?> - <?php echo $description_single[1]; ?></li></ul>
                                        <?php } else { ?>
                                            <ul><li> <?php echo $description_single[1]; ?></li></ul>
                                            <?php
                                        }
                                    }
                                    ?></td>
                                <td>  <?php
                                    if ($case->status == 'Pending Confirmation') {
                                        echo lang('pending_confirmation');
                                    } if ($case->status == 'Confirmed') {
                                        echo lang('confirmed');
                                    }
                                    ?> </td>

                                <td> <button type="button" class="btn btn-info btn-xs btn_width editbutton_show" data-toggle="modal" data-id="oncase-<?php echo $case->id; ?>"><i class="fa fa-plus-circle"></i></button></td>

                            </tr>
                        <?php } ?>
                             <?php
                       
                        foreach ($post_medical_surgery as $case) {
                            $i = $i + 1;
                            ?>
                            <tr>
                                <td><?php echo $i; ?> </td>
                                <td><?php echo $this->db->get_where('patient', array('id' => $case->patient_id))->row()->name; ?> </td>

                                <td><?php echo $case->title; ?></td>
                                <td><?php
                                    $descriptions = explode('##', $case->description);
                                    foreach ($descriptions as $description) {
                                        $description_single = array();
                                        $description_single = explode('**', $description);
                                        if ($description_single[0] == 'Package') {
                                            ?>
                                            <ul><li> <?php echo lang('package'); ?> - <?php echo $description_single[1]; ?></li></ul>
                                        <?php } else { ?>
                                            <ul><li> <?php echo $description_single[1]; ?></li></ul>
                                            <?php
                                        }
                                    }
                                    ?></td>
                                <td>  <?php
                                    if ($case->status == 'Pending Confirmation') {
                                        echo lang('pending_confirmation');
                                    } if ($case->status == 'Confirmed') {
                                        echo lang('confirmed');
                                    }
                                    ?> </td>

                                <td> <button type="button" class="btn btn-info btn-xs btn_width editbutton_show" data-toggle="modal" data-id="postcase-<?php echo $case->id; ?>"><i class="fa fa-plus-circle"></i></button></td>

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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('lab'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="adv-table editable-table ">
                    <div class="space15"></div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample3">
                        <thead>
                            <tr>
                               
                                <th><?php echo lang('patient'); ?></th>

                                <th style="width: 15%"><?php echo lang('department'); ?></th>
                                <th style="width: 15%"><?php echo lang('type'); ?> </th>
                                <th style="width: 15%"><?php echo lang('name'); ?> </th>
                                <th style="width: 15%"><?php echo lang('date'); ?> </th>
                                <th><?php echo lang('laboratorist'); ?></th>
                                <th><?php echo lang('status'); ?></th>
                                <th><?php echo lang('options'); ?></th>

                            </tr>
                        </thead>
                        <tbody id="lab-reports-payment">

                        </tbody>
                       
                    </table>
                    
                </div>



            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Accountant Modal-->

<script src="common/js/codearistos.min.js"></script>

<script>
    $(document).ready(function () {
        $(".table").on("click", ".editbutton_show", function () {
            var id = $(this).attr('data-id');
            $('#lab-reports-payment').html("");
         //  $('#lab-reports-package').html("");
            $('#myModal').modal('show');
            $.ajax({
                url: 'lab/getLabTestFromCases?id=' + id,
                method: 'GET',
                data: '',
                dataType: 'json'
            }).success(function (response) {
              //  alert('sdad');
              //+ '<br><h3 style="text-align: center;"><?php echo lang('packages'); ?></h3>' 
              //var data = jQuery.parseJSON(response);
             $('#lab-reports-payment').html(response.option +  response.option1);
               // $('#op').html("hjhj")
                //$('#lab-reports-package').append(response.option1);
               
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        var table = $('#editable-sample').DataTable({
            responsive: true,

            "processing": true,
            "serverSide": false,
            "searchable": true,

            scroller: {
                loadingIndicator: true
            },

            dom: "<'row'<'col-sm-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",

            buttons: [
                {extend: 'copyHtml5', exportOptions: {columns: [0, 1, 2,3,4], }},
                {extend: 'excelHtml5', exportOptions: {columns: [0, 1, 2,3,4], }},
                {extend: 'csvHtml5', exportOptions: {columns: [0, 1, 2,3,4], }},
                {extend: 'pdfHtml5', exportOptions: {columns: [0, 1, 2,3,4], }},
                {extend: 'print', exportOptions: {columns: [0, 1, 2,3,4], }},
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
                searchPlaceholder: "Search..."
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

