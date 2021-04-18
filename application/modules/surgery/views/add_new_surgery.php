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
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Surgery') {
                $permis = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Surgery') {
                $permis_2 = 'ok';
                //  break;
            }
        }
        ?>
        <section class="col-md-8 row">
            <header class="panel-heading">
                <?php
                if (!empty($surgeries->id))
                    echo lang('edit_surgery');
                else
                    echo lang('add_surgery');
                ?>

            </header>
            <style>
                .separator {
                    display: flex;
                    align-items: center;
                    text-align: center;
                }

                .separator::before,
                .separator::after {
                    content: '';
                    flex: 1;
                    border-bottom: 1px solid #000;
                }

                .separator:not(:empty)::before {
                    margin-right: .25em;
                }

                .separator:not(:empty)::after {
                    margin-left: .25em;
                }
                .input-category{
                    border: none !important;
                }
                .price-indivudual{
                    border: none !important;
                }
                .from_where{
                    border: none !important;
                }
            </style>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <?php echo validation_errors(); ?>
                        <form role="form" id="packages_add" action="surgery/addSurgery" class="clearfix" method="post" enctype="multipart/form-data">

                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1"><?php echo lang('patient'); ?></label>
                                <select class="form-control m-bot15" id="patientchoose" name="patient_id" value=''>
                                    <?php if (!empty($surgeries->id)) { ?>
                                        <option value="<?php echo $surgeries->patient_id; ?>" selected=""><?php echo $surgeries->patient_name . ' (id: ' . $surgeries->patient_id . ' )'; ?></option>
                                    <?php }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">  <?php echo lang('time_to_be_done'); ?></label> 
                                <input type="text" class="form-control form-control-inline input-medium  form_datetime " name="time_to_be_done" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('time_to_be_done');
                                }
                                if (!empty($surgeries->time_to_be_done)) {
                                    echo $surgeries->time_to_be_done;
                                }
                                ?>' placeholder="" readonly="" required="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1"><?php echo lang('title'); ?></label>
                                <input type="text" class="form-control" name="title" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('title');
                                }
                                if (!empty($surgeries->title)) {
                                    echo $surgeries->title;
                                }
                                ?>' placeholder="">
                            </div>
                            <div class="col-md-6 panel">
                                <label for="exampleInputEmail1">  <?php echo lang('status'); ?></label> 
                                <select class="form-control m-bot15" name="status" value=''> 
                                    <option value="Pending Confirmation" <?php
                                    if (!empty($surgeries->id)) {
                                        if ($surgeries->status == 'Pending Confirmation') {
                                            echo 'selected';
                                        }
                                    }
                                    ?> > <?php echo lang('pending_confirmation'); ?> </option>
                                    <option value="Confirmed"  <?php
                                    if (!empty($surgeries->id)) {
                                        if ($surgeries->status == 'Confirmed') {
                                            echo 'selected';
                                        }
                                    }
                                    ?>> <?php echo lang('confirmed'); ?> </option>

                                </select>
                            </div>

                            <div class="adv-table editable-table ">
                                <table style="width: 100% !important;" class="table table-striped table-hover table-bordered" id="editable-tablesurgery">
                                    <thead>
                                        <tr>
                                            <th style=""><?php echo lang('items'); ?></th>
                                            <th style=""><?php echo lang('type'); ?></th>
                                            <th style=""><?php echo lang('price'); ?></th>
                                            <th style=""><?php echo lang('date_to_be_done'); ?></th>
                                            <th style=""><?php echo lang('status'); ?></th>
                                            <th style="" class="no-print"><?php echo lang('options'); ?></th>

                                        </tr>
                                    </thead>
                                    <tbody id="surgery_proccedure">
                                        <?php
                                        if (!empty($surgeries->id)) {
                                            $cat_price = explode("##", $surgeries->description);
                                            foreach ($cat_price as $cat_individual) {

                                                $individual = array();
                                                $individual = explode("**", $cat_individual);
                                                ?>
                                                <tr class="proccedure" id="tr-med-surgery-<?php echo $individual[2] ?>">

                                                    <td>
                                                        <input type="hidden" name="type_id_surgery[]" id="input_id-med-surgery-<?php echo $individual[2] ?>" value="<?php echo $individual[2] ?>" readonly>
                                                        <input type="text" class="input-category" name="type_surgery[]" id="input-med-surgery-<?php echo $individual[1]; ?>" value="<?php echo $individual[1]; ?>"> 
                                                    </td>
                                                    <td>
                                                        <?php echo lang('surgery'); ?>
                                                        <input type="hidden" name="from_surgery[]" class="from_where" value="Surgery">
                                                    </td>
                                                    <td>
                                                        <input class="price-indivudual" type="text" name="price_surgery[]" style="width:100px;" id="price-surgery-<?php echo $individual[2]; ?>" value="<?php echo $individual[3]; ?>" >
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control  default-date-picker" name="date_to_done_surgery[]" value="<?php
                                                        if (!empty($surgeries->id)) {
                                                            echo $individual[4];
                                                        }
                                                        ?>" readonly>
                                                    </td>
                                                    <td>
                                                        <select class="form-control js-example-basic-single" name="done_surgery[]">
                                                            <option value="done" <?php
                                                            if ($individual[5] == 'done') {
                                                                echo 'selected';
                                                            }
                                                            ?>>Done</option>
                                                            <option value="undone" <?php
                                                            if ($individual[5] == 'undone') {
                                                                echo 'selected';
                                                            }
                                                            ?>>Undone</option>
                                                        </select>
                                                    </td>
                                                    <td>

                                                        <button class="btn btn-info btn-xs btn_width delete_button" id="td-med-surgery-<?php echo $individual[2] ?>"><i class="fa fa-trash"> </i></button>

                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <input type="hidden" name="id" value='<?php
                            if (!empty($surgeries->id)) {
                                echo $surgeries->id;
                            }
                            ?>'>
                            <input type="hidden" name="redirect" value='<?php
                            if (empty($surgeries->id)) {
                                echo 'surgery_add';
                            } else {
                                echo 'surgery';
                            }
                            ?>'>
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1"><?php echo lang('total_value'); ?></label>
                                <input type="text" class="form-control" name="total_value_surgery" id="total_value_surgery" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('total_value_surgery');
                                }
                                if (!empty($surgeries->total_price)) {
                                    echo $surgeries->total_price;
                                }
                                ?>' placeholder="" readonly="">
                            </div>

                            <div class="separator col-md-12"><?php echo lang('select'); ?></div>
                            <br>  <br>
                            <div class="col-md-12" style="margin-top:20px;">

                                <div class="col-md-5">

                                    <select style=" display: block;"class="form-control m-bot15 js-example-basic-single" id="surgery_type" name="medical_analysis" value='' required=""> 
                                        <option><?php echo lang('select'); ?></option>
                                        <?php foreach ($surgery_category as $surgery) { ?>
                                            <option value="<?php echo $surgery->id;
                                            ?>"><?php echo $surgery->category; ?></option>
                                                <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-info" id="add_surgery"><i class="fa fa-save"></i></button>     
                                </div>



                            </div>


                            <div class="form-group col-md-12" style="margin-top:20px;">
                                <button type="submit" id="submit" name="submit" class="btn btn-info pull-right"><?php
                                    if (empty($surgeries->id)) {
                                        echo lang('add_surgery');
                                    } else {
                                        echo lang('edit_surgery');
                                    }
                                    ?></button>
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
<script src="common/toastr/js/toastr.js"></script>
<link rel="stylesheet" type="text/css" href="common/toastr/css/toastr.css">

<script>
    $(document).ready(function () {
        $('#add_surgery').click(function (e) {
            var medical_analysis = $('#surgery_type').val();
            // var package = $('#package').val();

            if ($('table#editable-tablesurgery').find('#tr-med-surgery-' + medical_analysis).length > 0) {
                alert('Already in the List');
            } else if (medical_analysis === 'Select') {
                alert('Please Select a  Medical Analysis');
            } else if ($('table#editable-table2').find('#tr-med-surgery-' + medical_analysis).length <= 0) {
                $.ajax({
                    url: 'surgery/getTableTrValue?medical_analysis=' + medical_analysis,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                }).success(function (response) {
                    $('#surgery_proccedure').after(response.option);
                    var values = $("input[name^='price_surgery[]']").map(function (idx, ele) {
                        return $(ele).val();
                    }).get();
                    var sum = 0;
                    $.each(values, function (index, value) {
                        // alert(index + ": " + value);
                        var number = parseInt(value, 10);
                        sum += number;
                    });
                    $('#total_value_surgery').val(sum);
                })
            } else {

                var url = 'surgery/getTableTrValue?medical_analysis=' + medical_analysis;

                $.ajax({
                    url: url,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                }).success(function (response) {
                    $('#package_proccedure').after(response.option);
                    var values = $("input[name^='price_surgery[]']").map(function (idx, ele) {
                        return $(ele).val();
                    }).get();
                    var sum = 0;
                    $.each(values, function (index, value) {
                        // alert(index + ": " + value);
                        var number = parseInt(value, 10);
                        sum += number;
                    });
                    $('#total_value_surgery').val(sum);
                })
            }
            e.preventDefault();
        })

    })
</script>
<script>
    $(document).ready(function () {
        $('#editable-tablesurgery').on('click', '.delete_button', function () {
            //  $('.delete_button').click(function () {
            // alert('sadas');
            var id = $(this).attr('id');
            var id_split = id.split("-");
            // if(id_split[1]=='med'){
            $('#tr-' + id_split[1] + '-' + id_split[2] + '-' + id_split[3]).remove();
            //}

            var values = $("input[name^='price_surgery[]']").map(function (idx, ele) {
                return $(ele).val();
            }).get();
            //  alert(values);
            var sum = 0;
            $.each(values, function (index, value) {
                // alert(index + ": " + value);
                var number = parseInt(value, 10);
                sum += number;
            });
            $('#total_value_surgery').val(sum);
        });

    })
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
        $('body').on('focus', ".default-date-picker", function () {
            $(this).datepicker();
        });
    });
</script>
