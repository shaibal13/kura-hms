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
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Medicine') {
                $permis = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Medicine') {
                $permis_2 = 'ok';
                //  break;
            }
        }
        ?>
        <section class="">
            <header class="panel-heading">
                <?php echo lang('medicine'); ?> 
                <?php if ($this->ion_auth->in_group(array('admin', 'Pharmacist')) || $permis == 'ok') { ?>
                    <div class="col-md-4 no-print pull-right"> 
                        <a data-toggle="modal" href="#myModal">
                            <div class="btn-group pull-right">
                                <button id="" class="btn green btn-xs">
                                    <i class="fa fa-plus-circle"></i> <?php echo lang('add_medicine'); ?>
                                </button>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </header>
            <style>

                .wrapper {
                    padding: 0px 10px 0px 15px !important;
                }

            </style>

            <div class="panel-body"> 
                <div class="adv-table editable-table">
                    <div class="space15">
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample1">
                        <thead>
                            <tr>
                                <th> <?php echo lang('id'); ?></th>
                                <th> <?php echo lang('name'); ?></th>
                                <th> <?php echo lang('category'); ?></th>
                                <th> <?php echo lang('store_box'); ?></th>
                                <th> <?php echo lang('p_price'); ?></th>
                                <th> <?php echo lang('s_price'); ?></th>
                                <th> <?php echo lang('quantity'); ?></th>
                                <th> <?php echo lang('generic_name'); ?></th>
                                <th> <?php echo lang('company'); ?></th>
                                <th> <?php echo lang('effects'); ?></th>
                                <th> <?php echo lang('expiry_date'); ?></th>
                                <?php if ($this->ion_auth->in_group(array('admin', 'Pharmacist')) || in_array('Medicine', $pers)) { ?>
                                    <th> <?php echo lang('department'); ?></th>
                                <?php } ?>
                                <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                                    <th> <?php echo lang('pharmacist'); ?></th>
                                <?php } ?>
                                <?php if ($this->ion_auth->in_group(array('admin', 'Pharmacist')) || $permis == 'ok' || $permis_2 == 'ok') { ?>
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

                            .load{
                                float: right !important;
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






<!-- Add Accountant Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('add_medicine'); ?></h4>
            </div>
            <div class="modal-body row">
                <form role="form" action="medicine/addNewMedicine" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group col-md-5">
                        <label for="exampleInputEmail1"> <?php echo lang('name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-5">
                        <label for="exampleInputEmail1"> <?php echo lang('category'); ?></label>
                        <select class="form-control m-bot15" name="category" value=''>
                            <?php foreach ($categories as $category) { ?>
                                <option value="<?php echo $category->category; ?>" <?php
                                if (!empty($medicine->category)) {
                                    if ($category->category == $medicine->category) {
                                        echo 'selected';
                                    }
                                }
                                ?> > <?php echo $category->category; ?> </option>
                                    <?php } ?> 
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="exampleInputEmail1"> <?php echo lang('p_price'); ?></label>
                        <input type="text" class="form-control" name="price" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="exampleInputEmail1"> <?php echo lang('s_price'); ?></label>
                        <input type="text" class="form-control" name="s_price" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <!-- <div class="form-group col-md-3">
                         <label for="exampleInputEmail1"> <?php echo lang('quantity'); ?></label>
                         <input type="text" class="form-control" name="quantity" id="exampleInputEmail1" value='' placeholder="">
                     </div>-->
                    <div class="form-group col-md-5">
                        <label for="exampleInputEmail1"> <?php echo lang('generic_name'); ?></label>
                        <input type="text" class="form-control" name="generic" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-5">
                        <label for="exampleInputEmail1"> <?php echo lang('company'); ?></label>
                        <input type="text" class="form-control" name="company" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-5">
                        <label for="exampleInputEmail1"> <?php echo lang('effects'); ?></label>
                        <input type="text" class="form-control" name="effects" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-4"> 
                        <label for="exampleInputEmail1"> <?php echo lang('store_box'); ?></label>
                        <input type="text" class="form-control" name="box" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-5"> 
                        <label for="exampleInputEmail1"> <?php echo lang('alpha_code'); ?></label>
                        <input type="text" class="form-control" name="alpha_code" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="exampleInputEmail1"> <?php echo lang('expiry_date'); ?></label>
                        <input type="text" class="form-control default-date-picker" name="e_date" id="exampleInputEmail1" value='' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('department'); ?></label>
                        <select class="form-control m-bot15 js-example-basic-single" name="department" value=''>
                            <?php foreach ($departments as $department) { ?>
                                <option value="<?php echo $department->id; ?>" <?php
                                if (!empty($medicine->department)) {
                                    if ($department->id == $medicine->department) {
                                        echo 'selected';
                                    }
                                }
                                ?> > <?php echo $department->name; ?> </option>
                                    <?php } ?> 
                        </select>
                    </div>
                    <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"> <?php echo lang('pharmacist'); ?></label>
                            <select class="form-control m-bot15 js-example-basic-single" name="pharmacist" value=''>
                                <?php foreach ($pharmacists as $pharmacist) { ?>
                                    <option value="<?php echo $pharmacist->id; ?>" <?php
                                    if (!empty($medicine->pharmacist)) {
                                        if ($pharmacist->id == $medicine->pharmacist) {
                                            echo 'selected';
                                        }
                                    }
                                    ?> > <?php echo $pharmacist->name; ?> </option>
                                        <?php } ?> 
                            </select>
                        </div>
                    <?php } ?>
                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
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
                <h4 class="modal-title">  <?php echo lang('edit_medicine'); ?></h4>
            </div>
            <div class="modal-body row">
                <form role="form" id="editMedicineForm" class="clearfix" action="medicine/addNewMedicine" method="post" enctype="multipart/form-data">
                    <div class="form-group col-md-5">
                        <label for="exampleInputEmail1"> <?php echo lang('name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-5">
                        <label for="exampleInputEmail1"> <?php echo lang('category'); ?></label>
                        <select class="form-control m-bot15" name="category" value=''>
                            <?php foreach ($categories as $category) { ?>
                                <option value="<?php echo $category->category; ?>" <?php
                                if (!empty($medicine->category)) {
                                    if ($category->category == $medicine->category) {
                                        echo 'selected';
                                    }
                                }
                                ?> > <?php echo $category->category; ?> </option>
                                    <?php } ?> 
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="exampleInputEmail1"> <?php echo lang('p_price'); ?></label>
                        <input type="text" class="form-control" name="price" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="exampleInputEmail1"> <?php echo lang('s_price'); ?></label>
                        <input type="text" class="form-control" name="s_price" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <!--   <div class="form-group col-md-3">
                           <label for="exampleInputEmail1"> <?php echo lang('quantity'); ?></label>
                           <input type="text" class="form-control" name="quantity" id="exampleInputEmail1" value='' placeholder="">
                       </div>-->
                    <div class="form-group col-md-5">
                        <label for="exampleInputEmail1"> <?php echo lang('generic_name'); ?></label>
                        <input type="text" class="form-control" name="generic" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-5">
                        <label for="exampleInputEmail1"> <?php echo lang('company'); ?></label>
                        <input type="text" class="form-control" name="company" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-5">
                        <label for="exampleInputEmail1"> <?php echo lang('effects'); ?></label>
                        <input type="text" class="form-control" name="effects" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-4"> 
                        <label for="exampleInputEmail1"> <?php echo lang('store_box'); ?></label>
                        <input type="text" class="form-control" name="box" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-5"> 
                        <label for="exampleInputEmail1"> <?php echo lang('alpha_code'); ?></label>
                        <input type="text" class="form-control" name="alpha_code" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="exampleInputEmail1"> <?php echo lang('expiry_date'); ?></label>
                        <input type="text" class="form-control default-date-picker" name="e_date" id="exampleInputEmail1" value='' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('department'); ?></label>
                        <select class="form-control m-bot15 js-example-basic-single" name="department" value=''>
                            <?php foreach ($departments as $department) { ?>
                                <option value="<?php echo $department->id; ?>" <?php
                                if (!empty($medicine->department)) {
                                    if ($department->id == $medicine->department) {
                                        echo 'selected';
                                    }
                                }
                                ?> > <?php echo $department->name; ?> </option>
                                    <?php } ?> 
                        </select>
                    </div>
                    <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"> <?php echo lang('pharmacist'); ?></label>
                            <select class="form-control m-bot15 js-example-basic-single" name="pharmacist" value=''>
                                <?php foreach ($pharmacists as $pharmacist) { ?>
                                    <option value="<?php echo $pharmacist->id; ?>" <?php
                                    if (!empty($medicine->pharmacist)) {
                                        if ($pharmacist->id == $medicine->pharmacist) {
                                            echo 'selected';
                                        }
                                    }
                                    ?> > <?php echo $pharmacist->name; ?> </option>
                                        <?php } ?> 
                            </select>
                        </div>
                    <?php } ?>
                    <input type="hidden" name="id" value=''>
                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>



                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Edit Event Modal-->









<!-- Load Medicine -->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('load_medicine'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editMedicineForm" class="clearfix" action="medicine/load" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('add_quantity'); ?></label>
                        <input type="text" class="form-control" name="qty" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <input type="hidden" name="id" value=''>

                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Load Medicine -->












<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".table").on("click", ".editbutton", function () {

            var iid = $(this).attr('data-id');
            $('#editMedicineForm').trigger("reset");
            $('#myModal2').modal('show');
            $.ajax({
                url: 'medicine/editMedicineByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                // Populate the form fields with the data returned from server
                $('#editMedicineForm').find('[name="id"]').val(response.medicine.id).end()
                $('#editMedicineForm').find('[name="name"]').val(response.medicine.name).end()
                $('#editMedicineForm').find('[name="box"]').val(response.medicine.box).end()
                $('#editMedicineForm').find('[name="price"]').val(response.medicine.price).end()
                $('#editMedicineForm').find('[name="s_price"]').val(response.medicine.s_price).end()
                // $('#editMedicineForm').find('[name="quantity"]').val(response.medicine.quantity).end()
                $('#editMedicineForm').find('[name="generic"]').val(response.medicine.generic).end()
                $('#editMedicineForm').find('[name="company"]').val(response.medicine.company).end()
                $('#editMedicineForm').find('[name="effects"]').val(response.medicine.effects).end()
                $('#editMedicineForm').find('[name="e_date"]').val(response.medicine.e_date).end()
                $('#editMedicineForm').find('[name="alpha_code"]').val(response.medicine.alpha_code).end()
                $('#editMedicineForm').find('[name="department"]').val(response.medicine.department).trigger("change")
<?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                    $('#editMedicineForm').find('[name="pharmacist"]').val(response.medicine.pharmacist).trigger("change")
<?php } ?>
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".table").on("click", ".load", function () {

            // e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#editMedicineForm').trigger("reset");
            $('#myModal3').modal('show');

            //  var id = $(this).data('id');

            // Populate the form fields with the data returned from server
            $('#editMedicineForm').find('[name="id"]').val(iid).end()
        });
    });
</script>

<script>


    $(document).ready(function () {
        var table = $('#editable-sample1').DataTable({
            responsive: true,
            //   dom: 'lfrBtip',

            "processing": true,
            "serverSide": true,
            "searchable": true,
            "ajax": {
                url: "medicine/getMedicineList",
                type: 'POST',
            },
            scroller: {
                loadingIndicator: true
            },
            dom: "<'row'<'col-sm-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",

            buttons: [
                {extend: 'copyHtml5', exportOptions: {columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], }},
                {extend: 'excelHtml5', exportOptions: {columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], }},
                {extend: 'csvHtml5', exportOptions: {columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], }},
                {extend: 'pdfHtml5', exportOptions: {columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], }},
                {extend: 'print', exportOptions: {columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], }},
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

