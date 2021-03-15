
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
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Website') {
                $permis = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Website') {
                $permis_2 = 'ok';
                //  break;
            }
        }
        ?>
        <section class="panel">
            <header class="panel-heading">
                <?php echo lang('review'); ?>
                <?php if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok') { ?>
                    <div class="col-md-4 no-print pull-right"> 
                        <a data-toggle="modal" href="#myModal">
                            <div class="btn-group pull-right">
                                <button id="" class="btn green btn-xs">
                                    <i class="fa fa-plus-circle"></i> <?php echo lang('add_review'); ?>
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
                                <th><?php echo lang('image'); ?></th>
                                <th><?php echo lang('name'); ?></th>
                                <th><?php echo lang('designation'); ?></th>
                                <th><?php echo lang('review'); ?></th>
                                <th><?php echo lang('status'); ?></th>
                                <?php if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok' || $permis_2 == 'ok') { ?>
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

                        <?php foreach ($reviews as $review) { ?>
                            <tr class="">
                                <td style="width:10%;"><img style="width:95%;" src="<?php echo $review->img; ?>"></td>
                                <td> <?php echo $review->name; ?></td>
                                <td><?php echo $review->designation; ?></td>
                                <td><?php echo $review->review; ?></td>
                                <td>
                                    <?php
                                    if ($review->status == 'Active') {
                                        echo lang('active');
                                    } else {
                                        echo lang('in_active');
                                    }
                                    ?>
                                </td>
                                <?php if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok' || $permis_2 == 'ok') { ?>
                                    <td class="no-print">
                                        <?php if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok') { ?>
                                            <button type="button" class="btn btn-info btn-xs btn_width editbutton" title="<?php echo lang('edit'); ?>" data-toggle="modal" data-id="<?php echo $review->id; ?>"><i class="fa fa-edit"> </i></button>   
                                        <?php } ?>
                                        <?php if ($this->ion_auth->in_group(array('admin')) || $permis_2 == 'ok') { ?>
                                            <a class="btn btn-info btn-xs btn_width delete_button" title="<?php echo lang('delete'); ?>" href="review/delete?id=<?php echo $review->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"> </i></a>
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

<style>
    textarea.form-control {
        height: auto !important;
    }
</style>


<!-- Add Slide Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('add_review'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="review/addNew" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value=''>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('designation'); ?></label>
                        <input type="text" class="form-control" name="designation" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('review'); ?></label>
                        <textarea class="form-control" name="review" id="exampleInputEmail1" value='' placeholder="" cols="20"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('status'); ?></label>
                        <select class="form-control m-bot15" name="status" value=''>
                            <option value="Active" <?php
                            if (!empty($setval)) {
                                if ($review->status == set_value('status')) {
                                    echo 'selected';
                                }
                            }
                            if (!empty($review->status)) {
                                if ($review->status == 'Active') {
                                    echo 'selected';
                                }
                            }
                            ?> > <?php echo lang('active'); ?> 
                            </option>
                            <option value="Inactive" <?php
                            if (!empty($setval)) {
                                if ($review->status == set_value('status')) {
                                    echo 'selected';
                                }
                            }
                            if (!empty($review->status)) {
                                if ($review->status == 'Inactive') {
                                    echo 'selected';
                                }
                            }
                            ?> > <?php echo lang('in_active'); ?> 
                            </option>
                        </select>
                    </div>
                    <div class="form-group last">
                        <label class="control-label">Image Upload</label>
                        <div class="">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="//www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                        <input type="file" class="default" name="img_url"/>
                                    </span>
                                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                                </div>
                            </div>

                        </div>
                    </div>

                    <input type="hidden" name="id" value=''>


                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Slide Modal-->







<!-- Edit Event Modal-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('edit_review'); ?></h4>
            </div>

            <div class="modal-body">
                <form role="form" id="editSlideForm" class="clearfix" action="review/addNew" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value=''>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('designation'); ?></label>
                        <input type="text" class="form-control" name="designation" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('review'); ?></label>
                        <textarea type="text" cols="20" class="form-control" name="review" id="exampleInputEmail1" value='' placeholder=""></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('status'); ?></label>
                        <select class="form-control m-bot15" name="status" value=''>
                            <option value="Active" <?php
                            if (!empty($setval)) {
                                if ($review->status == set_value('status')) {
                                    echo 'selected';
                                }
                            }
                            if (!empty($review->status)) {
                                if ($review->status == 'Active') {
                                    echo 'selected';
                                }
                            }
                            ?> > <?php echo lang('active'); ?> 
                            </option>
                            <option value="Inactive" <?php
                            if (!empty($setval)) {
                                if ($review->status == set_value('status')) {
                                    echo 'selected';
                                }
                            }
                            if (!empty($review->status)) {
                                if ($review->status == 'Inactive') {
                                    echo 'selected';
                                }
                            }
                            ?> > <?php echo lang('in_active'); ?> 
                            </option>
                        </select>
                    </div>
                    <div class="form-group last">
                        <label class="control-label">Image Upload</label>
                        <div class="">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="//www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" id="img" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                        <input type="file" class="default" name="img_url"/>
                                    </span>
                                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                                </div>
                            </div>

                        </div>
                    </div>

                    <input type="hidden" name="id" value=''>

                    <div class="form-group">
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
                                    $('#editSlideForm').trigger("reset");
                                    $("#img").attr("src", "uploads/cardiology-patient-icon-vector-6244713.jpg");
                                    $.ajax({
                                    url: 'review/editReviewByJason?id=' + iid,
                                            method: 'GET',
                                            data: '',
                                            dataType: 'json',
                                    }).success(function (response) {
                                    // Populate the form fields with the data returned from server
                                    $('#editSlideForm').find('[name="id"]').val(response.review.id).end()
                                            $('#editSlideForm').find('[name="name"]').val(response.review.name).end()
                                            $('#editSlideForm').find('[name="designation"]').val(response.review.designation).end()
                                            $('#editSlideForm').find('[name="review"]').val(response.review.review).end()
                                            $('#editSlideForm').find('[name="status"]').val(response.review.status).end()

                                            if (typeof response.review.img !== 'undefined' && response.review.img != '') {
                                    $("#img").attr("src", response.review.img);
                                    }

                                    $('#myModal2').modal('show');
                                    });
                                    });
                                    });</script>




<script>
    $(document).ready(function () {
    var = $('#editable-sample').DataTable({
    responsive: true,
            dom: "<'row'<'col-sm-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
            {extend: 'copyHtml5', exportOptions: {columns: [1, 2, 3, 4], }},
            {extend: 'excelHtml5', exportOptions: {columns: [1, 2, 3, 4], }},
            {extend: 'csvHtml5', exportOptions: {columns: [1, 2, 3, 4], }},
            {extend: 'pdfHtml5', exportOptions: {columns: [1, 2, 3, 4], }},
            {extend: 'print', exportOptions: {columns: [1, 2, 3, 4], }},
            ],
            aLengthMenu: [
            [10, 25, 50, 100, - 1],
            [10, 25, 50, 100, "All"]
            ],
            iDisplayLength: - 1,
            "order": [[0, "desc"]],
            "language": {
            "lengthMenu": "_MENU_",
                    search: "_INPUT_",
                    "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json"
            },
    });
    table.buttons().container()
            .appendTo('.custom_buttons');
    });</script>






<script>
    $(document).ready(function () {
    $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
