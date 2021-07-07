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
                                    <?php if (!empty($case->id)) { ?>
                                        <option value="<?php echo $case->patient_id; ?>" selected=""><?php echo $case->patient_name . ' (id: ' . $case->patient_id . ' )'; ?></option>
                                    <?php }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1"><?php echo lang('title'); ?></label>
                                <input type="text" class="form-control" name="title" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('title');
                                }
                                if (!empty($case->title)) {
                                    echo $case->title;
                                }
                                ?>' placeholder="">
                            </div>
                            <div class="col-md-6 panel">
                                <label for="exampleInputEmail1">  <?php echo lang('status'); ?></label> 
                                <select class="form-control m-bot15" name="status" value=''> 
                                    <option value="Pending Confirmation" <?php
                                    if (!empty($case->id)) {
                                        if ($case->status == 'Pending Confirmation') {
                                            echo 'selected';
                                        }
                                    }
                                    ?> > <?php echo lang('pending_confirmation'); ?> </option>
                                    <option value="Confirmed"  <?php
                                    if (!empty($case->id)) {
                                        if ($case->status == 'Confirmed') {
                                            echo 'selected';
                                        }
                                    }
                                    ?>> <?php echo lang('confirmed'); ?> </option>

                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1"><?php echo lang('remarks'); ?></label>
                                <input type="text" class="form-control" name="remarks" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('remarks');
                                }
                                if (!empty($case->remarks)) {
                                    echo $case->remarks;
                                }
                                ?>' placeholder="">
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
                                        if (!empty($case->id)) {
                                            $cat_price = explode("##", $case->description);
                                            foreach ($cat_price as $cat_individual) {

                                                $individual = array();
                                                $individual = explode("**", $cat_individual);
                                                if ($individual[0] == 'Package') {
                                                    ?>
                                                    <tr class="proccedure" id="tr-pack-<?php echo $individual[2] ?>">

                                                        <td>
                                                            <input type="hidden" name="type_id[]" id="input_id-pack-<?php echo $individual[2] ?>" value="<?php echo $individual[2] ?>" readonly>
                                                            <input type="text" class="input-category" name="type[]" id="input-pack-<?php echo $individual[1]; ?>" value="<?php echo $individual[1]; ?>"> 
                                                        </td>
                                                        <td>
                                                            <?php echo lang('package'); ?>
                                                            <input type="hidden" name="from[]" class="from_where" value="Package">
                                                        </td>
                                                        <td>
                                                            <input class="price-indivudual" type="text" name="price[]" style="width:100px;" id="price-<?php echo $individual[2]; ?>" value="<?php echo $individual[3]; ?>" >
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control  default-date-picker" name="date_to_done[]" value="<?php
                                                            if (!empty($case->id)) {
                                                                echo $individual[4];
                                                            }
                                                            ?>" readonly>
                                                        </td>
                                                        <td>
                                                            <select class="form-control js-example-basic-single" name="done[]">
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
                                                            <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                                                                <button class="btn btn-info btn-xs btn_width delete_button" id="td-pack-<?php echo $individual[2] ?>"><i class="fa fa-trash"> </i></button>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                if ($individual[0] == 'Medical Analysis') {
                                                    ?>
                                                    <tr class="proccedure" id="tr-med-<?php echo $individual[2] ?>">

                                                        <td>
                                                            <input type="hidden" name="type_id[]" id="input_id-med-<?php echo $individual[2] ?>" value="<?php echo $individual[2] ?>" >
                                                            <input type="text" class="input-category" name="type[]" id="input-med-<?php echo $individual[1]; ?>" value="<?php echo $individual[1]; ?>" readonly> 
                                                        </td>
                                                        <td>
                                                            <?php echo lang('medical_analysis'); ?>
                                                            <input type="hidden" name="from[]" class="from_where" value="Medical Analysis">
                                                        </td>
                                                        <td>
                                                            <input class="price-indivudual" type="text" name="price[]" style="width:100px;" id="price-<?php echo $individual[2]; ?>" value="<?php echo $individual[3]; ?>" <?php if (!empty($case->id)) {
                                                            if ($case->status == 'Confirmed') { 
                                                                echo 'readonly';
                                                            } }?>>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control  default-date-picker" name="date_to_done[]" value="<?php
                                                            if (!empty($case->id)) {
                                                                echo $individual[4];
                                                            }
                                                            ?>" readonly>
                                                        </td>
                                                        <td>
                                                            <select class="form-control js-example-basic-single" name="done[]">
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
                                                            <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                                                                <button class="btn btn-info btn-xs btn_width delete_button" id="td-med-<?php echo $individual[1] ?>"><i class="fa fa-trash"> </i></button>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <input type="hidden" name="id" value='<?php
                            if (!empty($case->id)) {
                                echo $case->id;
                            }
                            ?>'>
                            <input type="hidden" name="redirect" value='case_list'>
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1"><?php echo lang('total_value'); ?></label>
                                <input type="text" class="form-control" name="total_value" id="total_value" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('total_value');
                                }
                                if (!empty($case->total_price)) {
                                    echo $case->total_price;
                                }
                                ?>' placeholder="" readonly="">
                            </div>
                            <?php
                            if (!empty($case->id)) {
                                if ($case->status != 'Confirmed') {
                                    ?>
        <?php if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Nurse', 'Doctor', 'Laboratorist', 'Receptionist')) || $permis == 'ok') { ?>
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
                                    <?php }
                                }
                            } ?>
                            <!--
<?php if ($case->payment_status == 'paid') { ?>
                                                                <div class="form-group col-md-12" style="padding-top: 20px;">
                                                                    <label for="exampleInputEmail1"><?php echo lang('payment'); ?> <?php echo lang('status'); ?></label>
                                                                    <input type="text" class="form-control" name="" id="" value='<?php echo lang('paid'); ?>' placeholder="" readonly="">
                                                                </div> 
                                                                <div class="form-group  payment  right-six col-md-12">
                                                                    <button type="submit" name="submit2" id="submit1" class="btn btn-info row pull-right"> <?php echo lang('add_case'); ?><</button>
                                                                </div>
<?php } else { ?>
                                                                <div class="col-md-12" style="margin-top: 10px;">
                                                                    <input type="checkbox" id="pay_now_case" name="pay_now_case" value="pay_now_case">
                                                                    <label for=""> <?php echo lang('pay_now'); ?></label><br>
                                
                                                                </div>
                                                                <div class="payment_label col-md-12 hidden deposit_type" style="text-align: left !important ;margin: 0% !important ;"> 
                                                                    <label for="exampleInputEmail1"><?php echo lang('deposit_type'); ?></label>
                                
                                                                    <div class=""> 
                                                                        <select class="form-control m-bot15 js-example-basic-single selecttype" id="selecttype" name="deposit_type" value=''> 
                                <?php if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist'))) { ?>
                                                                                    <option value="Cash"> <?php echo lang('cash'); ?> </option>
                                                                                    <option value="Card"> <?php echo lang('card'); ?> </option>
    <?php } ?>
                                
                                                                        </select>
                                                                    </div>
                                
                                                                </div>
                                                                <div class="col-md-12">
    <?php
    $payment_gateway = $settings->payment_gateway;
    ?>
                                
                                
                                
                                                                    <div class = "card">
                                
                                                                        <hr>
    <?php if ($payment_gateway != 'Paymob') { ?>
                                                                                <div class="col-md-12 payment pad_bot">
                                                                                    <label for="exampleInputEmail1"> <?php echo lang('accepted'); ?> <?php echo lang('cards'); ?></label>
                                                                                    <div class="payment pad_bot">
                                                                                        <img src="uploads/card.png" width="100%">
                                                                                    </div> 
                                                                                </div>
                                <?php }
                                ?> 
                                
                                
    <?php
    if ($payment_gateway == 'PayPal') {
        ?>
                                                                                <div class="col-md-12 payment pad_bot">
                                                                                    <label for="exampleInputEmail1"> <?php echo lang('card'); ?> <?php echo lang('type'); ?></label>
                                                                                    <select class="form-control m-bot15" name="card_type" value=''>
                                    
                                                                                        <option value="Mastercard"> <?php echo lang('mastercard'); ?> </option>   
                                                                                        <option value="Visa"> <?php echo lang('visa'); ?> </option>
                                                                                        <option value="American Express" > <?php echo lang('american_express'); ?> </option>
                                                                                    </select>
                                                                                </div>
    <?php } ?>
    <?php if ($payment_gateway == '2Checkout' || $payment_gateway == 'PayPal') {
        ?>
                                                                                <div class="col-md-12 payment pad_bot">
                                                                                    <label for="exampleInputEmail1"> <?php echo lang('cardholder'); ?> <?php echo lang('name'); ?></label>
                                                                                    <input type="text"  id="cardholder" class="form-control pay_in" name="cardholder" value='' placeholder="">
                                                                                </div>
    <?php } ?>
    <?php if ($payment_gateway != 'Pay U Money' && $payment_gateway != 'Paystack' && $payment_gateway != 'SSLCOMMERZ' && $payment_gateway != 'Paytm') { ?>
                                                                                <div class="col-md-12 payment pad_bot">
                                                                                    <label for="exampleInputEmail1"> <?php echo lang('card'); ?> <?php echo lang('number'); ?></label>
                                                                                    <input type="text"  id="card" class="form-control pay_in" name="card_number" value='' placeholder="">
                                                                                </div>
                                    
                                    
                                    
                                                                                <div class="col-md-8 payment pad_bot">
                                                                                    <label for="exampleInputEmail1"> <?php echo lang('expire'); ?> <?php echo lang('date'); ?></label>
                                                                                    <input type="text" class="form-control pay_in" id="expire" data-date="" data-date-format="MM YY" placeholder="Expiry (MM/YY)" name="expire_date" maxlength="7" aria-describedby="basic-addon1" value='' placeholder="">
                                                                                </div>
                                                                                <div class="col-md-4 payment pad_bot">
                                                                                    <label for="exampleInputEmail1"> <?php echo lang('cvv'); ?> </label>
                                                                                    <input type="text" class="form-control pay_in" id="cvv" maxlength="3" name="cvv" value='' placeholder="">
                                                                                </div> 
        <?php
    }
    ?>
                                                                    </div>
                                
                                
                                                                </div>
                                                                <div class="col-md-12 panel">
                                                                    <div class="col-md-3 payment_label"> 
                                                                    </div>
                                                                    <div class="col-md-9"> 
                                <?php $twocheckout = $this->db->get_where('paymentGateway', array('name =' => '2Checkout'))->row(); ?>
                                                                        <div class="form-group cashsubmit payment  right-six col-md-12">
                                                                            <button type="submit" name="submit2" id="submit1" class="btn btn-info row pull-right"> <?php echo lang('add_case'); ?></button>
                                                                        </div>
                                <?php $twocheckout = $this->db->get_where('paymentGateway', array('name =' => '2Checkout'))->row(); ?>
                                                                        <div class="form-group cardsubmit  right-six col-md-12 hidden">
                                                                            <button type="submit" name="pay_now" id="submit-btn" class="btn btn-info row pull-right" <?php if ($settings->payment_gateway == 'Stripe') {
                                    ?>onClick="stripePay(event);"<?php }
                        ?> <?php if ($settings->payment_gateway == '2Checkout' && $twocheckout->status == 'live') {
                            ?>onClick="twoCheckoutPay(event);"<?php }
                        ?>> <?php echo lang('add_case'); ?></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
<?php }
?>
                            
                            -->
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
            $('#tr-' + id_split[1] + '-' + id_split[2]).remove();
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
<script>
    $(document).ready(function () {
        $('.card').hide();
        $(document.body).on('change', '#selecttype', function () {

            var v = $("select.selecttype option:selected").val()
            if (v == 'Card') {
                $('.cardsubmit').removeClass('hidden');
                $('.cashsubmit').addClass('hidden');
                // $("#amount_received").prop('required', true);
                // $('#amount_received').attr("required");;
                $('.card').show();
            } else {
                $('.card').hide();
                $('.cashsubmit').removeClass('hidden');
                $('.cardsubmit').addClass('hidden');
                // $("#amount_received").prop('required', false);
                //$('#amount_received').removeAttr('required');
            }
        });

    });


</script>
<script>
    $(document).ready(function () {
        $('#pay_now_case').change(function () {
            if ($(this).prop("checked") == true) {
                $('.deposit_type').removeClass('hidden');
                $('#editAppointmentForm').find('[name="deposit_type"]').trigger("reset")
                // $('#editAppointmentForm').find('[name="status"]').val("Confirmed").end()
            } else {
                $('#editAppointmentForm').find('[name="deposit_type"]').val("").end()
                $('.deposit_type').addClass('hidden');
                //  $('#editAppointmentForm').find('[name="status"]').val("").end()

                $('.card').hide();
            }

        })
    })
</script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
    function cardValidation() {
        var valid = true;
        var cardNumber = $('#card').val();
        var expire = $('#expire').val();
        var cvc = $('#cvv').val();

        $("#error-message").html("").hide();

        if (cardNumber.trim() == "") {
            valid = false;
        }

        if (expire.trim() == "") {
            valid = false;
        }
        if (cvc.trim() == "") {
            valid = false;
        }

        if (valid == false) {
            $("#error-message").html("All Fields are required").show();
        }

        return valid;
    }
//set your publishable key
    Stripe.setPublishableKey("<?php echo $gateway->publish; ?>");

//callback to handle the response from stripe
    function stripeResponseHandler(status, response) {
        if (response.error) {
            //enable the submit button
            $("#submit-btn").show();
            $("#loader").css("display", "none");
            //display the errors on the form
            $("#error-message").html(response.error.message).show();
        } else {
            //get token id
            var token = response['id'];
            //insert the token into the form
            $('#token').val(token);
            $("#packages_add").append("<input type='hidden' name='token' value='" + token + "' />");
            //submit form to the server
            $("#editAppointmentForm").submit();
        }
    }

    function stripePay(e) {
        e.preventDefault();
        var valid = cardValidation();

        if (valid == true) {
            $("#submit-btn").attr("disabled", true);
            $("#loader").css("display", "inline-block");
            var expire = $('#expire').val()
            var arr = expire.split('/');
            Stripe.createToken({
                number: $('#card').val(),
                cvc: $('#cvv').val(),
                exp_month: arr[0],
                exp_year: arr[1]
            }, stripeResponseHandler);

            //submit from callback
            return false;
        }
    }

</script>

<script src="common/js/moment.min.js"></script>

<script type="text/javascript" src="https://www.2checkout.com/checkout/api/2co.min.js"></script>
<?php if ($settings->payment_gateway == '2Checkout') { ?> 
    <script>

    //   $(document).ready(function () {
    // Called when token created successfully.
        var successCallback = function (data) {
            var myForm = document.getElementById('editAppointmentForm');
            // Set the token as the value for the token input
            // alert(data.response.token.token);
            $("#packages_add").append("<input type='hidden' name='token' value='" + data.response.token.token + "' />");
            //    myForm.token.value = data.response.token.token;
            // IMPORTANT: Here we call `submit()` on the form element directly instead of using jQuery to prevent and infinite token request loop.
            myForm.submit();
        };
    // Called when token creation fails.
        var errorCallback = function (data) {
            if (data.errorCode === 200) {
                tokenRequest();
            } else {
                alert(data.errorMsg);
            }
        };
        var tokenRequest = function () {
    <?php $twocheckout = $this->db->get_where('paymentGateway', array('name =' => '2Checkout'))->row(); ?>
            // Setup token request arguments  
            var expire = $("#expire").val();
            var expiresep = expire.split("/");
            var dateformat = moment(expiresep[1], "YY");
            var year = dateformat.format("YYYY");
            var args = {
                sellerId: "<?php echo $twocheckout->merchantcode; ?>",
                publishableKey: "<?php echo $twocheckout->publishablekey; ?>",
                ccNo: $("#card").val(),
                cvv: $("#cvv").val(),
                expMonth: expiresep[0],
                expYear: year
            };
            console.log($("#card").val() + '-' + $("#cvv").val() + expiresep[0] + year + "<?php echo $twocheckout->merchantcode; ?>");
            // Make the token request

            TCO.requestToken(successCallback, errorCallback, args);
        };
    //   });
        function twoCheckoutPay(e) {
            e.preventDefault();

            // try {
            // Pull in the public encryption key for our environment
            // TCO.loadPubKey('production');
            TCO.loadPubKey('sandbox', function () {  // for sandbox environment
                publishableKey = "<?php echo $twocheckout->publishablekey; ?>"//your public key
                tokenRequest();
            });
            //  $("#editPaymentForm").submit(function (e) {
            // Call our token request function


            // Prevent form from submitting
            return false;
            // });
            // } catch (e) {
            //     alert(e.toSource());
            //  }
        }
    // Pull in the public encryption key for our environment

    //});
    </script>
<?php } ?>