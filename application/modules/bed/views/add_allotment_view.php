<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-7 row">
            <header class="panel-heading">
                <?php
                if (!empty($allotment->id))
                    echo lang('edit_bed_allotment');
                else
                    echo lang('add_bed_allotment');
                ?>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <?php echo validation_errors(); ?>
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
                            <!--   <div class="form-group col-md-12">
                                   <label for="exampleInputEmail1"><?php echo lang('discharge_time'); ?></label>
                                   <div data-date="" class="input-group date form_datetime-meridian">
                                       <div class="input-group-btn"> 
                                           <button type="button" class="btn btn-info date-set"><i class="fa fa-calendar"></i></button>
                                           <button type="button" class="btn btn-danger date-reset"><i class="fa fa-times"></i></button>
                                       </div>
                                       <input type="text" class="form-control" name="d_time" id="exampleInputEmail1" value='<?php
                                    if (!empty($allotment->d_time)) {
                                        echo $allotment->d_time;
                                    }
                                    ?>' placeholder="">
                                   </div>
                               </div>-->

                            <input type="hidden" name="id" value='<?php
                            if (!empty($allotment->id)) {
                                echo $allotment->id;
                            }
                                    ?>'>

                            <div class="form-group col-md-12">
                                <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
                            </div>

                        </form>
                    </div>
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



    });
</script>
<script>
    $(document).ready(function () {
        $('#room_no').change(function () {
            var id = $(this).val();
            $('#bed_id').html(" ");
            var alloted_time = $('#alloted_time').val();
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