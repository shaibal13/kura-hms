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
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Patient') {
                $permis = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Patient') {
                $permis_2 = 'ok';
                //  break;
            }
        }
        ?>
        <section class="col-md-8 row">
            <header class="panel-heading">
                <?php
                if (!empty($case->id))
                    echo lang('edit') . ' ' . lang('case');
                else
                    echo lang('add') . ' ' . lang('case');
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
                        <form role="form" id="packages_add" action="patient/addMedicalHistory" class="clearfix" method="post" enctype="multipart/form-data">

                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1"><?php echo lang('patient'); ?></label>
                                <select class="form-control m-bot15" id="patientchoose" name="patient_id" value=''>

                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1"><?php echo lang('title'); ?></label>
                                <input type="text" class="form-control" name="title" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('title');
                                }
                                if (!empty($package->code)) {
                                    echo $package->code;
                                }
                                ?>' placeholder="">
                            </div>
                            <div class="col-md-6 panel">
                                <label for="exampleInputEmail1">  <?php echo lang('status'); ?></label> 
                                <select class="form-control m-bot15" name="status" value=''> 
                                    <option value="Pending Confirmation" <?php ?> > <?php echo lang('pending_confirmation'); ?> </option>
                                    <option value="Confirmed" <?php
                                ?> > <?php echo lang('confirmed'); ?> </option>

                                </select>
                            </div>

                            <div class="adv-table editable-table ">
                                <table style="width: 100% !important;" class="table table-striped table-hover table-bordered" id="editable-table2">
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
                                    <tbody id="package_proccedure">
                                        <?php
                                        if (!empty($package->id)) {
                                            $cat_price = explode("##", $package->price_cat);
                                            foreach ($cat_price as $cat_individual) {

                                                $individual = array();
                                                $individual = explode("**", $cat_individual);
                                                ?>
                                                <tr class="proccedure" id="tr-<?php echo $individual[1] ?>">
                                                    <td> <?php echo $individual[3]; ?></td>
                                                    <td>
                                                        <input type="hidden" name="type_id[]" id="input_id-<?php echo $individual[1] ?>" value="<?php echo $individual[1] ?>" readonly>
                                                        <input type="text" class="input-category" name="type[]" id="input-<?php echo $individual[1]; ?>" value="<?php echo $individual[0]; ?>"> 
                                                    </td>
                                                    <td>
                                                        <input class="price-indivudual" type="text" name="price[]" style="width:100px;" id="price-<?php echo $individual[1]; ?>" value="<?php echo $individual[2]; ?>" >
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-info btn-xs btn_width delete_button" id="td-<?php echo $individual[1] ?>"><i class="fa fa-trash"> </i></button>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1"><?php echo lang('total_value'); ?></label>
                                <input type="text" class="form-control" name="total_value" id="total_value" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('total_value');
                                }
                                if (!empty($package->total_price)) {
                                    echo $package->total_price;
                                }
                                ?>' placeholder="" readonly="">
                            </div>
                            <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                                <div class="separator col-md-12"><?php echo lang('select'); ?></div>
                                <br>  <br>
                                <div class="col-md-12" style="margin-top:20px;">
                                    <div class="col-md-5">

                                        <select style=" display: block;"class="form-control m-bot15 js-example-basic-single" id="package" name="package" value='' required=""> 
                                            <option><?php echo lang('select'); ?> <?php echo lang('packages'); ?></option>
                                            <?php foreach ($packages as $package) { ?>
                                                <option value="<?php echo $package->id;
                                                ?>"><?php echo $package->name; ?></option>
                                                    <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-5">

                                        <select style=" display: block;"class="form-control m-bot15 js-example-basic-single" id="medical_analysis" name="medical_analysis" value='' required=""> 
                                            <option><?php echo lang('select'); ?> <?php echo lang('medical_analysis'); ?></option>
                                            <?php foreach ($payment_category as $category) { ?>
                                                <option value="<?php echo $category->id;
                                                ?>"><?php echo $category->category; ?></option>
                                                    <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-info" id="add_type"><i class="fa fa-save"></i></button>     
                                    </div>



                                </div>
                            <?php } ?>
                            <input type="hidden" name="id" value='<?php
                            if (!empty($case->id)) {
                                echo $case->id;
                            }
                            ?>'>

                            <div class="form-group col-md-12" style="margin-top:20px;">
                                <button type="submit" id="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('add_case'); ?></button>
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
        $('#add_type').click(function (e) {
            var medical_analysis = $('#medical_analysis').val();
            var package = $('#package').val();

            if ($('table#editable-table2').find('#tr-med-' + medical_analysis).length > 0 && $('table#editable-table2').find('#tr-pack-' + package).length > 0) {
                alert('Already in the List');
            } else if (package === 'Select Packages' && medical_analysis === 'Select Medical Analysis') {
                alert('Please Select a package or Medical Analysis');
            } else if ($('table#editable-table2').find('#tr-med-' + medical_analysis).length > 0 && $('table#editable-table2').find('#tr-pack-' + package).length <= 0) {
                $.ajax({
                    url: 'patient/getTableTrValue?package=' + package,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                }).success(function (response) {
                    $('#package_proccedure').after(response.option);
                    var values = $("input[name^='price[]']").map(function (idx, ele) {
                        return $(ele).val();
                    }).get();
                    var sum = 0;
                    $.each(values, function (index, value) {
                        // alert(index + ": " + value);
                        var number = parseInt(value, 10);
                        sum += number;
                    });
                    $('#total_value').val(sum);
                })
            } else if ($('table#editable-table2').find('#tr-med-' + medical_analysis).length <= 0 && $('table#editable-table2').find('#tr-pack-' + package).length > 0) {
                $.ajax({
                    url: 'patient/getTableTrValue?medical_analysis=' + medical_analysis,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                }).success(function (response) {
                    $('#package_proccedure').after(response.option);
                    var values = $("input[name^='price[]']").map(function (idx, ele) {
                        return $(ele).val();
                    }).get();
                    var sum = 0;
                    $.each(values, function (index, value) {
                        // alert(index + ": " + value);
                        var number = parseInt(value, 10);
                        sum += number;
                    });
                    $('#total_value').val(sum);
                })
            } else {
                if (package === 'Select Packages') {
                    var url = 'patient/getTableTrValue?medical_analysis=' + medical_analysis;
                } else if (medical_analysis === 'Select Medical Analysis') {
                    var url = 'patient/getTableTrValue?package=' + package;
                } else {
                    var url = 'patient/getTableTrValue?medical_analysis=' + medical_analysis + '&package=' + package;
                }
                $.ajax({
                    url: url,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                }).success(function (response) {
                    $('#package_proccedure').after(response.option);
                    var values = $("input[name^='price[]']").map(function (idx, ele) {
                        return $(ele).val();
                    }).get();
                    var sum = 0;
                    $.each(values, function (index, value) {
                        // alert(index + ": " + value);
                        var number = parseInt(value, 10);
                        sum += number;
                    });
                    $('#total_value').val(sum);
                })
            }
            e.preventDefault();
        })

    })
</script>

<script>
    $(document).ready(function () {
        $('#editable-table2').on('click', '.delete_button', function () {
            //  $('.delete_button').click(function () {
            // alert('sadas');
            var id = $(this).attr('id');
            var id_split = id.split("-");
           // if(id_split[1]=='med'){
                 $('#tr-' + id_split[1]+'-'+id_split[2]).remove();
            //}
           
            var values = $("input[name^='price[]']").map(function (idx, ele) {
                return $(ele).val();
            }).get();
            //  alert(values);
            var sum = 0;
            $.each(values, function (index, value) {
                // alert(index + ": " + value);
                var number = parseInt(value, 10);
                sum += number;
            });
            $('#total_value').val(sum);
        });
        /* $("#packages_add").submit(function (e) {
         var id = $(this).attr('id');
         alert(id);
         if (id === 'submit') {
         
         var dataString = $(this).serialize();
         // alert(dataString); return false;
         
         $.ajax({
         type: "POST",
         url: "packages/addPackage",
         data: dataString,
         success: function (response) {
         var data = jQuery.parseJSON(response);
         toastr.success(data.message.message);
         }
         });
         
         }else{
         e.preventDefault();
         }
         });*/

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
