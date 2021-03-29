
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel col-md-10 row">
            <header class="panel-heading">
                <?php
                if (!empty($appointment->id))
                    echo lang('edit_appointment');
                else
                    echo lang('add_appointment');
                ?>
            </header>


            <style>
                .panel{
                    background: transparent;
                }

                .payment_label {
                    margin-left: -2%;
                }
                form{
                    background: #f1f1f1 !important;
                }
            </style>


            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <?php echo validation_errors(); ?>
                    <?php echo $this->session->flashdata('feedback'); ?>
                </div>
                <form role="form" action="appointment/addNew" id="editAppointmentForm"class="clearfix row" method="post" enctype="multipart/form-data">
                    <div class="col-md-7">
                        <div class="col-md-12 panel">
                            <div class="col-md-3 payment_label"> 
                                <label for="exampleInputEmail1"> <?php echo lang('patient'); ?></label>
                            </div>
                            <div class="col-md-9"> 
                                <select class="form-control m-bot15  pos_select" id="pos_select" name="patient" value=''> 
                                    <?php if (!empty($patients)) { ?>
                                        <option value="<?php echo $patients->id; ?>" selected="selected"><?php echo $patients->name; ?> - <?php echo $patients->id; ?></option>  
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="pos_client clearfix">
                            <div class="col-md-8 payment pad_bot pull-right">
                                <div class="col-md-3 payment_label"> 
                                    <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('name'); ?></label>
                                </div>
                                <div class="col-md-9"> 
                                    <input type="text" class="form-control pay_in" name="p_name" value='<?php
                                    if (!empty($payment->p_name)) {
                                        echo $payment->p_name;
                                    }
                                    ?>' placeholder="">
                                </div>
                            </div>
                            <div class="col-md-8 payment pad_bot pull-right">
                                <div class="col-md-3 payment_label"> 
                                    <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('email'); ?></label>
                                </div>
                                <div class="col-md-9"> 
                                    <input type="text" class="form-control pay_in" name="p_email" value='<?php
                                    if (!empty($payment->p_email)) {
                                        echo $payment->p_email;
                                    }
                                    ?>' placeholder="">
                                </div>
                            </div>
                            <div class="col-md-8 payment pad_bot pull-right">
                                <div class="col-md-3 payment_label"> 
                                    <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('phone'); ?></label>
                                </div>
                                <div class="col-md-9"> 
                                    <input type="text" class="form-control pay_in" name="p_phone" value='<?php
                                    if (!empty($payment->p_phone)) {
                                        echo $payment->p_phone;
                                    }
                                    ?>' placeholder="">
                                </div>
                            </div>
                            <div class="col-md-8 payment pad_bot pull-right">
                                <div class="col-md-3 payment_label"> 
                                    <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('age'); ?></label>
                                </div>
                                <div class="col-md-9"> 
                                    <input type="text" class="form-control pay_in" name="p_age" value='<?php
                                    if (!empty($payment->p_age)) {
                                        echo $payment->p_age;
                                    }
                                    ?>' placeholder="">
                                </div>
                            </div> 
                            <div class="col-md-8 payment pad_bot pull-right">
                                <div class="col-md-3 payment_label"> 
                                    <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('gender'); ?></label>
                                </div>
                                <div class="col-md-9"> 
                                    <select class="form-control m-bot15" name="p_gender" value=''>

                                        <option value="Male" <?php
                                        if (!empty($patient->sex)) {
                                            if ($patient->sex == 'Male') {
                                                echo 'selected';
                                            }
                                        }
                                        ?> > Male </option>   
                                        <option value="Female" <?php
                                        if (!empty($patient->sex)) {
                                            if ($patient->sex == 'Female') {
                                                echo 'selected';
                                            }
                                        }
                                        ?> > Female </option>
                                        <option value="Others" <?php
                                        if (!empty($patient->sex)) {
                                            if ($patient->sex == 'Others') {
                                                echo 'selected';
                                            }
                                        }
                                        ?> > Others </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 panel">
                            <div class="col-md-3 payment_label"> 
                                <label for="exampleInputEmail1">  <?php echo lang('doctor'); ?></label>
                            </div>
                            <div class="col-md-9"> 
                                <select class="form-control m-bot15" id="adoctors" name="doctor" value=''>  
                                    <?php if (!empty($doctors)) { ?>
                                        <option value="<?php echo $doctors->id; ?>" selected="selected"><?php echo $doctors->name; ?> - <?php echo $doctors->id; ?></option>  
                                    <?php } ?>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-12 panel">
                            <div class="col-md-3 payment_label"> 
                                <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
                            </div>
                            <div class="col-md-9"> 
                                <input type="text" class="form-control" id="date" readonly="" name="date" id="exampleInputEmail1" value='<?php
                                if (!empty($appointment->date)) {
                                    echo date('d-m-Y', $appointment->date);
                                }
                                ?>' placeholder="">
                            </div>
                        </div>

                        <div class="col-md-12 panel">
                            <div class="col-md-3 payment_label"> 
                                <label class=""><?php echo lang('available_slots'); ?></label>
                            </div>
                            <div class="col-md-9"> 
                                <select class="form-control m-bot15" name="time_slot" id="aslots" value=''> 

                                </select>
                            </div>
                        </div>


                        <div class="col-md-12 panel">
                            <div class="col-md-3 payment_label"> 
                                <label for="exampleInputEmail1"> <?php echo lang('remarks'); ?></label>
                            </div>
                            <div class="col-md-9"> 
                                <input type="text" class="form-control" name="remarks" id="exampleInputEmail1" value='<?php
                                if (!empty($appointment->remarks)) {
                                    echo $appointment->remarks;
                                }
                                ?>' placeholder="">
                            </div>
                        </div>


                        <div class="col-md-12 panel">
                            <div class="col-md-3 payment_label"> 
                                <label for="exampleInputEmail1"> <?php echo lang('appointment'); ?> <?php echo lang('status'); ?></label>
                            </div>
                            <div class="col-md-9"> 
                                <select class="form-control m-bot15" name="status" value='' id="appointment_status">
                                    <option value="Pending Confirmation" <?php
                                    if (!empty($appointment->status)) {
                                        if ($appointment->status == 'Pending Confirmation') {
                                            echo 'selected';
                                        }
                                    }
                                    ?> > <?php echo lang('pending_confirmation'); ?> </option> 
                                    <option value="Confirmed" <?php
                                    if (!empty($appointment->status)) {
                                        if ($appointment->status == 'Confirmed') {
                                            echo 'selected';
                                        }
                                    }
                                    ?> > <?php echo lang('confirmed'); ?> </option>
                                    <option value="Treated" <?php
                                    if (!empty($appointment->status)) {
                                        if ($appointment->status == 'Treated') {
                                            echo 'selected';
                                        }
                                    }
                                    ?> > <?php echo lang('treated'); ?> </option>
                                    <option value="cancelled" <?php
                                    if (!empty($appointment->status)) {
                                        if ($appointment->status == 'Treated') {
                                            echo 'selected';
                                        }
                                    }
                                    ?> > <?php echo lang('cancelled'); ?> </option>
                                </select>
                            </div>
                        </div>

                        <!--     <div class="col-md-12 panel">
                             <div class="col-md-3 payment_label"> 
                             </div>
                             <div class="col-md-9"> 
                                 <input type="checkbox" name="sms" value="sms"> <?php echo lang('send_sms') ?><br>
                             </div>
                         </div>
                        -->





                        <input type="hidden" name="id" id="appointment_id" value='<?php
                        if (!empty($appointment->id)) {
                            echo $appointment->id;
                        }
                        ?>'>


                    </div>
                     <input type="hidden" name="redirectlink" value="10">
                    <div class="col-md-5 clearfix" style="background:#fff !important;">
                        
                        <div class="form-group col-md-12" style="padding-top: 20px;">
                            <label for="exampleInputEmail1"><?php echo lang('consultant_fee'); ?></label>
                            <input type="number" class="form-control" name="consultant_fee" id="consultant_fee" value='<?php if(!empty($appointment)){
                                echo $doctors->consultant_fee;
                            }?>' placeholder="" readonly="">
                        </div>
                        
                        <?php if (!$this->ion_auth->in_group(array('Nurse', 'Doctor'))) { ?> 
                        <?php if($appointment->payment_status=='paid') { ?>
                            <div class="form-group col-md-12" style="padding-top: 20px;">
                            <label for="exampleInputEmail1"><?php echo lang('payment'); ?> <?php echo lang('status'); ?></label>
                            <input type="text" class="form-control" name="" id="" value='<?php echo lang('paid'); ?>' placeholder="" readonly="">
                        </div> 
                         <div class="form-group  payment  right-six col-md-12">
                                <button type="submit" name="submit2" id="submit1" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                            </div>
                        <?php } else { ?>
                            <div class="col-md-12">
                                <input type="checkbox" id="pay_now_appointment" name="pay_now_appointment" value="pay_now_appointment">
                                <label for=""> <?php echo lang('pay_now'); ?></label><br>
                                <?php if (!$this->ion_auth->in_group(array('Patient'))) { ?> 
                            <span style="color:red;"><?php echo lang('if_pay_now_checked_please_select_status_to_confirmed') ?></span>
                       <?php } ?>
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
                                    <?php
                                }
                                if ($payment_gateway == 'Paymob') {
                                    $gateway_datails = $this->db->get_where('paymentGateway', array('name' => 'Paymob'))->row();
                                    ?>
  <div class="col-md-12 payment pad_bot">
                                                                <label for="exampleInputEmail1"> <?php echo lang('accepted'); ?> <?php echo lang('medium'); ?></label> <br>
                                                                <input type="radio" id="payment_option" name="payment_option" value="card_payment">
                                                                <label for="male"><?php echo lang('card');?></label><br>
                                                                <?php if(!empty($gateway_datails->wallet_instance_id)){ ?>
                                                                <input type="radio" id="payment_option" name="payment_option" value="wallet">
                                                                <label for="male"><?php echo lang('wallet');?></label><br>
                                                                <?php } ?>
                                                                <?php if(!empty($gateway_datails->at_kiosk_instance_id)){ ?>
                                                                <input type="radio" id="payment_option" name="payment_option" value="at_kiosk">
                                                                <label for="male"><?php echo lang('at_kiosk');?></label><br>
                                                                <?php } ?>
                                                                <div class="form-group hidden" id="wallet_mobile">
                                                                <label for="exampleInputEmail1">Wallet Mobile No:</label> <br>
                                                                <input type="text" name="wallet_mobile" class="form-control">
                                                                </div>
                                                            </div>
                                <?php } ?>

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
                                    <?php if ($payment_gateway != 'Paymob' && $payment_gateway != 'Pay U Money' && $payment_gateway != 'Paystack' && $payment_gateway != 'SSLCOMMERZ' && $payment_gateway != 'Paytm') { ?>
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
                                        <button type="submit" name="submit2" id="submit1" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                                    </div>
                                    <?php $twocheckout = $this->db->get_where('paymentGateway', array('name =' => '2Checkout'))->row(); ?>
                                    <div class="form-group cardsubmit  right-six col-md-12 hidden">
                                        <button type="submit" name="pay_now" id="submit-btn" class="btn btn-info row pull-right" <?php if ($settings->payment_gateway == 'Stripe') {
                                        ?>onClick="stripePay(event);"<?php }
                                    ?> <?php if ($settings->payment_gateway == '2Checkout' && $twocheckout->status == 'live') {
                                        ?>onClick="twoCheckoutPay(event);"<?php }
                                    ?>> <?php echo lang('submit'); ?></button>
                                    </div>
                                </div>
                            </div>
                        <?php } 
                        
                                    }else { ?>
                            <div class="form-group  payment  right-six col-md-12">
                                <button type="submit" name="submit2" id="submit1" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                            </div>
                        <?php } ?>
                    </div>
                </form>
            </div>

        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->


<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
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
        $('.pos_client').hide();
        $(document.body).on('change', '#pos_select', function () {

            var v = $("select.pos_select option:selected").val()
            if (v == 'add_new') {
                $('.pos_client').show();
            } else {
                $('.pos_client').hide();
            }
        });

    });


</script>


<?php if (!empty($appointment->id)) { ?>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#adoctors").change(function () {
                // Get the record's ID via attribute  
                var id = $('#appointment_id').val();
                var date = $('#date').val();
                var doctorr = $('#adoctors').val();

                $('#aslots').find('option').remove();
                // $('#default').trigger("reset");
                $.ajax({
                    url: 'schedule/getAvailableSlotByDoctorByDateByAppointmentIdByJason?date=' + date + '&doctor=' + doctorr + '&appointment_id=' + id,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                }).success(function (response) {
                    var slots = response.aslots;
                    $.each(slots, function (key, value) {
                        $('#aslots').append($('<option>').text(value).val(value)).end();
                    });
                    //   $("#default-step-1 .button-next").trigger("click");
                    if ($('#aslots').has('option').length == 0) {                    //if it is blank. 
                        $('#aslots').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
                    }

                    // Populate the form fields with the data returned from server
                    //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
                });
            });

        });

        $(document).ready(function () {
            var id = $('#appointment_id').val();
            var date = $('#date').val();
            var doctorr = $('#adoctors').val();
            //  var consultant_fee=$('#consultant_fee').val();
            $('#aslots').find('option').remove();
            // $('#default').trigger("reset");
            $.ajax({
                url: 'schedule/getAvailableSlotByDoctorByDateByAppointmentIdByJason?date=' + date + '&doctor=' + doctorr + '&appointment_id=' + id,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                var slots = response.aslots;
                $.each(slots, function (key, value) {
                    $('#aslots').append($('<option>').text(value).val(value)).end();
                });

                $("#aslots").val(response.current_value)
                        .find("option[value=" + response.current_value + "]").attr('selected', true);

                //   $("#default-step-1 .button-next").trigger("click");
                if ($('#aslots').has('option').length == 0) {                    //if it is blank. 
                    $('#aslots').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
                }
                // Populate the form fields with the data returned from server
                //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
            });

        });




        $(document).ready(function () {
            $('#date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
            })
                    //Listen for the change even on the input
                    .change(dateChanged)
                    .on('changeDate', dateChanged);
        });

        function dateChanged() {
            // Get the record's ID via attribute  
            var id = $('#appointment_id').val();
            var date = $('#date').val();
            var doctorr = $('#adoctors').val();
            $('#aslots').find('option').remove();
            // $('#default').trigger("reset");
            $.ajax({
                url: 'schedule/getAvailableSlotByDoctorByDateByAppointmentIdByJason?date=' + date + '&doctor=' + doctorr + '&appointment_id=' + id,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                var slots = response.aslots;
                $.each(slots, function (key, value) {
                    $('#aslots').append($('<option>').text(value).val(value)).end();
                });
                //   $("#default-step-1 .button-next").trigger("click");
                if ($('#aslots').has('option').length == 0) {                    //if it is blank. 
                    $('#aslots').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
                }


                // Populate the form fields with the data returned from server
                //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
            });

        }




    </script>

<?php } else { ?> 

    <script type="text/javascript">
        $(document).ready(function () {
            /* $('#appointment_status').change(function(){
             var value=$(this).val();
             if(value=='Confirmed'){
             $('#pay_now_appointment').prop("checked",true);
             $('.deposit_type').removeClass('hidden');
             }else{
             $('#pay_now_appointment').prop("checked",false);
             $('.deposit_type').addClass('hidden');
             $('.card').hide();
             }
             })*/
            $('#pay_now_appointment').change(function () {
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
            $("#adoctors").change(function () {
                // Get the record's ID via attribute  
                var id = $('#appointment_id').val();
                var date = $('#date').val();
                var doctorr = $('#adoctors').val();
                $('#consultant_fee').val(" ");

                $('#aslots').find('option').remove();
                // $('#default').trigger("reset");
                $.ajax({
                    url: 'schedule/getAvailableSlotByDoctorByDateByJason?date=' + date + '&doctor=' + doctorr,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                }).success(function (response) {
                    var slots = response.aslots;
                    $.each(slots, function (key, value) {
                        $('#aslots').append($('<option>').text(value).val(value)).end();
                    });
                    //   $("#default-step-1 .button-next").trigger("click");
                    if ($('#aslots').has('option').length == 0) {                    //if it is blank. 
                        $('#aslots').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
                    }
                    $('#consultant_fee').val(response.doctor.consultant_fee).end();
                    // Populate the form fields with the data returned from server
                    //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
                });
            });

        });

        $(document).ready(function () {
            var id = $('#appointment_id').val();
            var date = $('#date').val();
            var doctorr = $('#adoctors').val();
            $('#aslots').find('option').remove();
            // $('#default').trigger("reset");
            $.ajax({
                url: 'schedule/getAvailableSlotByDoctorByDateByJason?date=' + date + '&doctor=' + doctorr,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                var slots = response.aslots;
                $.each(slots, function (key, value) {
                    $('#aslots').append($('<option>').text(value).val(value)).end();
                });

                $("#aslots").val(response.current_value)
                        .find("option[value=" + response.current_value + "]").attr('selected', true);

                //   $("#default-step-1 .button-next").trigger("click");
                if ($('#aslots').has('option').length == 0) {                    //if it is blank. 
                    $('#aslots').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
                }
                // Populate the form fields with the data returned from server
                //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
            });

        });




        $(document).ready(function () {
            $('#date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
            })
                    //Listen for the change even on the input
                    .change(dateChanged)
                    .on('changeDate', dateChanged);
        });

        function dateChanged() {
            // Get the record's ID via attribute  
            var id = $('#appointment_id').val();
            var date = $('#date').val();
            var doctorr = $('#adoctors').val();
            $('#aslots').find('option').remove();
            // $('#default').trigger("reset");
            $.ajax({
                url: 'schedule/getAvailableSlotByDoctorByDateByJason?date=' + date + '&doctor=' + doctorr,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                var slots = response.aslots;
                $.each(slots, function (key, value) {
                    $('#aslots').append($('<option>').text(value).val(value)).end();
                });
                //   $("#default-step-1 .button-next").trigger("click");
                if ($('#aslots').has('option').length == 0) {                    //if it is blank. 
                    $('#aslots').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
                }


                // Populate the form fields with the data returned from server
                //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
            });

        }

    </script>

<?php } ?>

<script>
    $(document).ready(function () {
        $("#pos_select").select2({
            placeholder: '<?php echo lang('select_patient'); ?>',
            allowClear: true,
            ajax: {
                url: 'patient/getPatientinfoWithAddNewOption',
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

        $("#adoctors").select2({
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

    });
</script>
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
            $("#editAppointmentForm").append("<input type='hidden' name='token' value='" + token + "' />");
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
        $("#editAppointmentForm").append("<input type='hidden' name='token' value='" + data.response.token.token + "' />");
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


    <script>
         //    $('#wallet_mobile').hide();
        $(document).ready(function(){
       $('input[type=radio][id=payment_option]').on('change', function() {
           // $("#payment_option").change(function(){ // bind a function to the change event

       // check if the radio is checked
            var val = $(this).val(); // retrieve the value
          
            if(val=='wallet'){
                $('#wallet_mobile').removeClass('hidden');
              //  $("input[value=card_payment]").removeAttr("Checked");
            }else{
                $('#wallet_mobile').addClass('hidden');
                
                // $("input[value=card_payment]").removeAttr("Checked");
            }
        
    });
        })
        </script>

