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
                <?php echo lang('alloted_beds'); ?>
                 <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Doctor', 'Accountant')) || $permis == 'ok') { ?>
                <div class="col-md-4 no-print pull-right"> 
                    <a data-toggle="modal" href="#myModal">
                        <div class="btn-group pull-right">
                            <button id="" class="btn green btn-xs">
                                <i class="fa fa-plus-circle"></i> <?php echo lang('add_new_allotment'); ?>
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
                                <th><?php echo lang('bed_id'); ?></th>
                                <th><?php echo lang('patient'); ?></th>
                                <th><?php echo lang('alloted_time'); ?></th>
                                <th><?php echo lang('discharge_time'); ?></th>
                                 <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Doctor', 'Accountant')) || $permis == 'ok'|| $permis_2 == 'ok') { ?>
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







<!-- Add Accountant Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('add_new_allotment'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="bed/addAllotment" class="clearfix row" method="post" enctype="multipart/form-data">

                    <div class="form-group col-md-12">

                        <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('covid_19'); ?>:</label>

                        <span></span>
                        <input type="radio" name="covid_19" value="po">
                        <label style="margin-right: 56px;"><?php echo lang('po'); ?></label>
                        <input type="radio" name="covid_19" value="jo">
                        <label><?php echo lang('jo'); ?></label>

                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('alloted_time'); ?></label>
                        <div data-date="" class="input-group date form_datetime-meridian">
                            <div class="input-group-btn"> 
                                <button type="button" class="btn btn-info date-set"><i class="fa fa-calendar"></i></button>
                                <button type="button" class="btn btn-danger date-reset"><i class="fa fa-times"></i></button>
                            </div>
                            <input type="text" class="form-control" readonly="" name="a_time" id="alloted_time" value='<?php
                            if (!empty($allotment->a_time)) {
                                echo $allotment->a_time;
                            }
                            ?>' placeholder="">
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('room_no'); ?></label>
                        <select class="form-control m-bot15" id="room_no" name="category" value=''>
                            <option><?php echo lang('select'); ?></option>
                            <?php foreach ($room_no as $room) { ?>
                                <option value="<?php echo $room->category; ?>" <?php
                                if (!empty($allotment->category)) {
                                    if ($allotment->category == $room->category) {
                                        echo 'selected';
                                    }
                                }
                                ?> > <?php echo $room->category; ?> </option>
                                    <?php } ?> 
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('bed_id'); ?></label>
                        <select class="form-control m-bot15" id="bed_id" name="bed_id" value=''> 
                            <option value="select"><?php echo lang('select'); ?></option>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('patient'); ?></label>
                        <select class="form-control m-bot15" id="patientchoose" name="patient" value=''> 

                        </select>
                    </div>


                    <div class="form-group col-md-12">

                        <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('category'); ?>:</label>

                        <span></span>
                        <input type="checkbox" name="category_status[]" value="urgent">
                        <label style="margin-right: 56px;"><?php echo lang('urgent'); ?></label>
                        <input type="checkbox" name="category_status[]" value="planned">
                        <label><?php echo lang('planned'); ?></label>

                    </div>
                    <div class="form-group col-md-12">

                        <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('reaksione'); ?>:</label>
                        <textarea name="reaksione" class='form-control'> </textarea>

                    </div>
                    <div class="form-group col-md-12">

                        <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('transferred_from'); ?>:</label>
                        <textarea name="transferred_from" class='form-control'> </textarea>

                    </div>
                    <div class="form-group col-md-12">

                        <label for="exampleInputEmail1"><?php echo lang('diagnoza_a_shtrimit'); ?>:</label>
                        <textarea name="diagnoza_a_shtrimit" class='form-control'> </textarea>

                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('doctor'); ?></label>
                        <select class="form-control m-bot15" id="doctors" name="doctor" value=''> 

                        </select>
                    </div>
                    <div class="form-group col-md-12">

                        <label for="exampleInputEmail1"><?php echo lang('diagnosis'); ?>:</label>
                        <textarea name="diagnosis" class='form-control'> </textarea>

                    </div>
                    <div class="form-group col-md-12">

                        <label for="exampleInputEmail1"><?php echo lang('other_illnesses'); ?>:</label>
                        <textarea name="other_illnesses" class='form-control'> </textarea>

                    </div>
                    <div class="form-group col-md-12">

                        <label for="exampleInputEmail1"><?php echo lang('anamneza'); ?>:</label>
                        <textarea name="anamneza" class='form-control'> </textarea>

                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('blood_group'); ?></label>
                        <select class="form-control m-bot15" id="blood_group" name="blood_group" value=''> 
                            <?php foreach ($blood_group as $blood_group) {
                                ?>

                                <option value="<?php echo $blood_group->id; ?>"><?php echo $blood_group->group; ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('accepting_doctor'); ?></label>
                        <select class="form-control m-bot15" id="accepting_doctors" name="accepting_doctor" value=''> 

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
<!-- Add Accountant Modal-->







<!-- Edit Event Modal-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('edit_allotment'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editAllotmentForm" action="bed/addAllotment" class="clearfix row" method="post" enctype="multipart/form-data">

                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1">Bed Id</label>
                        <select class="form-control m-bot15" name="bed_id" value=''>
                            <?php foreach ($beds as $bed) { ?>
                                <option value="<?php echo $bed->bed_id; ?>" <?php
                                if (!empty($allotment->bed_id)) {
                                    if ($allotment->bed_id == $bed->bed_id) {
                                        echo 'selected';
                                    }
                                }
                                ?> > <?php echo $bed->bed_id; ?> </option>
                                    <?php } ?> 
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1">Patient</label>
                        <select class="form-control m-bot15" id="patientchoose1" name="patient" value=''> 

                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('alloted_time'); ?></label>
                        <div data-date="" class="input-group date form_datetime-meridian">
                            <div class="input-group-btn"> 
                                <button type="button" class="btn btn-info date-set"><i class="fa fa-calendar"></i></button>
                                <button type="button" class="btn btn-danger date-reset"><i class="fa fa-times"></i></button>
                            </div>
                            <input type="text" class="form-control" readonly="" name="a_time" id="exampleInputEmail1" value='' placeholder="">
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('discharge_time'); ?></label>
                        <div data-date="" class="input-group date form_datetime-meridian">
                            <div class="input-group-btn"> 
                                <button type="button" class="btn btn-info date-set"><i class="fa fa-calendar"></i></button>
                                <button type="button" class="btn btn-danger date-reset"><i class="fa fa-times"></i></button>
                            </div>
                            <input type="text" class="form-control" name="d_time" id="exampleInputEmail1" value='' placeholder="">
                        </div>
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
<script type="text/javascript">
    $(document).ready(function () {
        $(".table").on("click", ".editbutton1", function () {
            //   e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#editAllotmentForm').trigger("reset");
            $('#myModal2').modal('show');
            $.ajax({
                url: 'bed/editallotmentByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                // Populate the form fields with the data returned from server
                $('#editAllotmentForm').find('[name="id"]').val(response.allotment.id).end()
                $('#editAllotmentForm').find('[name="bed_id"]').val(response.allotment.bed_id).end()
                //  $('#editAllotmentForm').find('[name="patient"]').val(response.allotment.patient).end()
                var option = new Option(response.patient.name + '-' + response.patient.id, response.patient.id, true, true);
                $('#editAllotmentForm').find('[name="patient"]').append(option).trigger('change');
                $('#editAllotmentForm').find('[name="a_time"]').val(response.allotment.a_time).end()
                $('#editAllotmentForm').find('[name="d_time"]').val(response.allotment.d_time).end()
            });
        });
    });
</script>


<script>


    $(document).ready(function () {
        var table = $('#editable-sample').DataTable({
            responsive: true,
            //   dom: 'lfrBtip',

            "processing": true,
            "serverSide": true,
            "searchable": true,
            "ajax": {
                url: "bed/getBedAllotmentList",
                type: 'POST',
            },
            scroller: {
                loadingIndicator: true
            },
            dom: "<'row'<'col-md-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
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
        $("#patientchoose").select2({
            placeholder: '<?php echo lang('select_patient'); ?>',
            allowClear: true,
            ajax: {
                url: 'patient/getPatientinfo',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }

        });
        $("#doctors").select2({
            placeholder: '<?php echo lang('select_doctor'); ?>',
            allowClear: true,
            ajax: {
                url: 'doctor/getDoctorInfo',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }

        });
        $("#accepting_doctors").select2({
            placeholder: '<?php echo lang('select_doctor'); ?>',
            allowClear: true,
            ajax: {
                url: 'doctor/getDoctorInfo',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }

        });
        $("#patientchoose1").select2({
            placeholder: '<?php echo lang('select_patient'); ?>',
            allowClear: true,
            ajax: {
                url: 'patient/getPatientinfo',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }

        });


    });
</script>
<script>
    $(document).ready(function () {
        $('#room_no').change(function () {
            var id = $(this).val();
            $('#bed_id').html(" ");
            var alloted_time = $('#alloted_time').val();
            //alert(alloted_time);
            $.ajax({
                url: 'bed/getBedByRoomNo?id=' + id + '&alloted_time=' + alloted_time,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                $('#bed_id').html(response.response);
            });

        })
    })
</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
