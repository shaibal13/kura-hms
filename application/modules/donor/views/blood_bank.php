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
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Donor') {
                $permis = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Donor') {
                $permis_2 = 'ok';
                //  break;
            }
        }
        ?>
        <section class="panel">
            <header class="panel-heading">
                <?php echo lang('blood_bank'); ?>
                <div class="col-md-4 pull-right">

                    <div class="pull-right"></div>

                </div>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                    </div>
                    <button class="export" onclick="javascript:window.print();"><?php echo lang('print'); ?></button>  
                    <div class="space15"></div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                        <thead>
                            <tr>
                                <th>Blood Group</th>
                                <th>Status</th>
                                <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Laboratorist', 'Doctor')) || $permis == 'ok') { ?>
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
                        <?php foreach ($groups as $group) { ?>
                            <tr class="">
                                <td><?php echo $group->group; ?></td>
                                <td> <?php echo $group->status; ?></td>
                                <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Laboratorist', 'Doctor')) || $permis == 'ok') { ?>
                                <td>
                                    <button type="button" class="btn btn-info btn-xs btn_width editbutton" title="<?php echo lang('edit'); ?>" data-toggle="modal" data-id="<?php echo $group->id; ?>"><i class="fa fa-edit"></i> </button>   
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








<!-- Edit Event Modal-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('update_blood_bank'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editBloodBank" action="donor/updateBloodBank" method="post" enctype="multipart/form-data">
                    <div class="form-group"> 
                        <label for="exampleInputEmail1"><?php echo lang('group'); ?></label>
                        <input type="text" class="form-control" name="group" id="exampleInputEmail1" value='' placeholder="" disabled>    
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('status'); ?></label>
                        <input type="text" class="form-control" name="status" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <input type="hidden" name="id" value=''>
                    <button type="submit" name="submit" class="btn btn-info"><?php echo lang('submit'); ?></button>
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
                                $('#editBloodBank').trigger("reset");
                                $('#myModal2').modal('show');
                                $.ajax({
                                    url: 'donor/updateBloodBankByJason?id=' + iid,
                                    method: 'GET',
                                    data: '',
                                    dataType: 'json',
                                }).success(function (response) {
                                    // Populate the form fields with the data returned from server
                                    $('#editBloodBank').find('[name="id"]').val(response.bloodbank.id).end()
                                    $('#editBloodBank').find('[name="group"]').val(response.bloodbank.group).end()
                                    $('#editBloodBank').find('[name="status"]').val(response.bloodbank.status).end()

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
                {extend: 'copyHtml5', exportOptions: {columns: [0, 1], }},
                {extend: 'excelHtml5', exportOptions: {columns: [0, 1], }},
                {extend: 'csvHtml5', exportOptions: {columns: [0, 1], }},
                {extend: 'pdfHtml5', exportOptions: {columns: [0, 1], }},
                {extend: 'print', exportOptions: {columns: [0, 1], }},
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

