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
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Finance') {
                $permis = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Finance') {
                $permis_2 = 'ok';
                //  break;
            }
            if (in_array('1', $perm_explode) && $perm_explode[0] == 'Finance') {
                $permis_1 = 'ok';
                //  break;
            }
        }
        ?>
        <section class="panel">
            <header class="panel-heading">
                <?php echo lang('expense_categories'); ?>
                <?php if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Nurse', 'Laboratorist', 'Doctor')) || $permis == 'ok') { ?>
                    <div class="col-md-4 no-print pull-right"> 
                        <a href="finance/addExpenseCategoryView">
                            <div class="btn-group pull-right">
                                <button id="" class="btn green btn-xs">
                                    <i class="fa fa-plus-circle"></i> <?php echo lang('add_expense_category'); ?>
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
                                <th><?php echo lang('category'); ?></th>
                                <th><?php echo lang('description'); ?></th>
                                <?php if ($this->ion_auth->in_group('admin') || $permis == 'ok' || $permis_2 == 'ok') { ?>
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

                        <?php foreach ($categories as $category) { ?>
                            <tr class="">
                                <td><?php echo $category->category; ?></td>
                                <td> <?php echo $category->description; ?></td>
                                <?php if ($this->ion_auth->in_group('admin') || $permis == 'ok' || $permis_2 == 'ok') { ?>
                                    <td class="no-print">
                                        <?php if ($this->ion_auth->in_group('admin') || $permis == 'ok') { ?>
                                            <a class="btn btn-info btn-xs editbutton" title="<?php echo lang('edit'); ?>" href="finance/editExpenseCategory?id=<?php echo $category->id; ?>"><i class="fa fa-edit"></i> </a>
                                        <?php } ?>
                                        <?php if ($this->ion_auth->in_group('admin') || $permis_2 == 'ok') { ?>
                                            <a class="btn btn-info btn-xs delete_button" title="<?php echo lang('delete'); ?>" href="finance/deleteExpenseCategory?id=<?php echo $category->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>
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


<script src="common/js/codearistos.min.js"></script>
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