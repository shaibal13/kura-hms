
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
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Appointment') {
                $permis = 'ok';
                //  break;
            }
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Appointment') {
                $permis_2 = 'ok';
                //  break;
            }
        }
        ?>
        <section class="panel">
            <header class="panel-heading">
                <?php echo lang('todays_appointments'); ?>
                <?php if ($this->ion_auth->in_group(array('admin', 'Patient', 'Nurse', 'Doctor', 'Receptionist')) || $permis == 'ok') { ?>
                    <div class="col-md-4 clearfix pull-right">
                        <div class="pull-right"></div>
                        <a data-toggle="modal" href="#myModal">
                            <div class="btn-group pull-right">
                                <button id="" class="btn green btn-xs pull-right">
                                    <i class="fa fa-plus-circle"></i>   <?php echo lang('add_appointment'); ?> 
                                </button>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="space15"></div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample1">
                        <thead>
                            <tr>
                                <th> <?php echo lang('id'); ?></th>
                                <th> <?php echo lang('patient'); ?></th>
                                <th> <?php echo lang('doctor'); ?></th>
                                <th> <?php echo lang('date-time'); ?></th>
                                <th> <?php echo lang('remarks'); ?></th>
                                <th> <?php echo lang('payment'); ?> <?php echo lang('status'); ?></th>
                                <th> <?php echo lang('status'); ?></th>
                                <?php if ($this->ion_auth->in_group(array('admin', 'Patient', 'Nurse', 'Doctor', 'Receptionist')) || $permis == 'ok' || $permis_2 == 'ok') { ?>
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



<!-- Add Appointment Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg"">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('add_appointment'); ?></h4>
            </div>
            <div class="modal-body row">
                <form role="form" id="addAppointmentForm" action="appointment/addNew" method="post" class="clearfix" enctype="multipart/form-data">
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('patient'); ?></label> 
                        <select class="form-control m-bot15 pos_select" id="pos_select" name="patient" value=''> 

                        </select>
                    </div>
                    <input type="hidden" name="redirectlink" value="my_today">
                    <div class="pos_client clearfix col-md-6">
                        <div class="payment pad_bot pull-right">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('name'); ?></label> 
                            <input type="text" class="form-control pay_in" name="p_name" value='' placeholder="">
                        </div>
                        <div class="payment pad_bot pull-right">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('email'); ?></label>
                            <input type="text" class="form-control pay_in" name="p_email" value='' placeholder="">
                        </div>
                        <div class="payment pad_bot pull-right">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('phone'); ?></label>
                            <input type="text" class="form-control pay_in" name="p_phone" value='' placeholder="">
                        </div>
                        <div class="payment pad_bot pull-right">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('age'); ?></label> 
                            <input type="text" class="form-control pay_in" name="p_age" value='' placeholder="">
                        </div> 
                        <div class="payment pad_bot"> 
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('gender'); ?></label>
                            <select class="form-control" name="p_gender" value=''>

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
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1">  <?php echo lang('doctor'); ?></label> 
                        <select class="form-control m-bot15 " id="adoctors" name="doctor" value=''>  

                        </select>
                    </div>
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
                        <input type="text" class="form-control default-date-picker" id="date" readonly="" name="date" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1">Available Slots</label>
                        <select class="form-control m-bot15" name="time_slot" id="aslots" value=''> 

                        </select>
                    </div>
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('appointment'); ?> <?php echo lang('status'); ?></label> 
                        <select class="form-control m-bot15" name="status" value=''>
                            <option value="Pending Confirmation" <?php ?> > <?php echo lang('pending_confirmation'); ?> </option>
                            <option value="Confirmed" <?php
                                ?> > <?php echo lang('confirmed'); ?> </option>
                            <option value="Treated" <?php
                                ?> > <?php echo lang('treated'); ?> </option>
                            <option value="Cancelled" <?php
                                ?> > <?php echo lang('cancelled'); ?> </option>
                        </select>
                    </div>
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('category'); ?> </label> 
                        <select class="form-control m-bot15" name="category_appointment" value=''> 
                            <option value="Bed Allotment" <?php ?> > <?php echo lang('bed_allotment'); ?> </option>
                            <option value="Ambulator" <?php ?> > <?php echo lang('ambulator'); ?> </option>

                        </select>
                    </div>
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('remarks'); ?></label>
                        <input type="text" class="form-control" name="remarks" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="col-md-6 panel">

                        <label class=""><?php echo lang('visit'); ?> <?php echo lang('description'); ?></label>

                        <select class="form-control m-bot15" name="visit_description" id="visit_description" value=''> 

                        </select>

                    </div>
                    <div class="form-group col-md-12" style="padding-top: 20px;">
                        <label for="exampleInputEmail1"><?php echo lang('visit'); ?> <?php echo lang('charges'); ?></label>
                        <input type="number" class="form-control"  name="visit_charges" id="visit_charges" value='' placeholder="" readonly="">
                    </div>
                    <?php if (!$this->ion_auth->in_group(array('Nurse', 'Doctor'))) { ?>    
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
                    <?php } else { ?>
                        <div class="form-group  payment  right-six col-md-12">
                            <button type="submit" name="submit2" id="submit1" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                        </div>
                    <?php } ?>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Appointment Modal-->

<div class="modal fade" tabindex="-1" role="dialog" id="cmodal">
    <div class="modal-dialog modal-lg" role="document" style="width: 80%;">
        <div class="modal-content">
            <!--
            <div class="modal-header">
                <h5 class="modal-title"><?php echo lang('patient') . " " . lang('history'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            -->
            <div id='medical_history'>
                <div class="col-md-12">

                </div> 
            </div>
            <div class="modal-footer">
                <div class="col-md-12">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>





<!-- Edit Event Modal-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg"">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('edit_appointment'); ?></h4>
            </div>
            <div class="modal-body row">
                <form role="form" id="editAppointmentForm" action="appointment/addNew" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('patient'); ?></label> 
                        <select class="form-control m-bot15 pos_select patient" id="pos_select" name="patient" value=''> 

                        </select>
                    </div>
                    <input type="hidden" name="redirectlink" value="my_today">
                    <div class="pos_client clearfix col-md-6">
                        <div class="payment pad_bot pull-right">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('name'); ?></label> 
                            <input type="text" class="form-control pay_in" name="p_name" value='' placeholder="">
                        </div>
                        <div class="payment pad_bot pull-right">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('email'); ?></label>
                            <input type="text" class="form-control pay_in" name="p_email" value='' placeholder="">
                        </div>
                        <div class="payment pad_bot pull-right">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('phone'); ?></label>
                            <input type="text" class="form-control pay_in" name="p_phone" value='' placeholder="">
                        </div>
                        <div class="payment pad_bot pull-right">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('age'); ?></label> 
                            <input type="text" class="form-control pay_in" name="p_age" value='' placeholder="">
                        </div> 
                        <div class="payment pad_bot"> 
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('gender'); ?></label>
                            <select class="form-control" name="p_gender" value=''>

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
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1">  <?php echo lang('doctor'); ?></label> 
                        <select class="form-control m-bot15  doctor" id="adoctors1" name="doctor" value=''>  

                        </select>
                    </div>
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
                        <input type="text" class="form-control default-date-picker" id="date1" readonly="" name="date" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1">Available Slots</label>
                        <select class="form-control m-bot15" name="time_slot" id="aslots1" value=''> 

                        </select>
                    </div>
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('appointment'); ?> <?php echo lang('status'); ?></label> 
                        <select class="form-control m-bot15" name="status" value=''>
                            <option value="Pending Confirmation" <?php ?> > <?php echo lang('pending_confirmation'); ?> </option>
                            <option value="Confirmed" <?php ?> > <?php echo lang('confirmed'); ?> </option>
                            <option value="Treated" <?php ?> > <?php echo lang('treated'); ?> </option>
                            <option value="Cancelled" <?php ?> > <?php echo lang('cancelled'); ?> </option>
                        </select>
                    </div>
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('category'); ?> </label> 
                        <select class="form-control m-bot15" name="category_appointment" value=''> 
                            <option value="Bed Allotment" <?php ?> > <?php echo lang('bed_allotment'); ?> </option>
                            <option value="Ambulator" <?php
                                ?> > <?php echo lang('ambulator'); ?> </option>

                        </select>
                    </div>
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('remarks'); ?></label>
                        <input type="text" class="form-control" name="remarks" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <!--     <div class="col-md-6 panel">
                         <label> <?php echo lang('send_sms'); ?> ? </label> <br>
                         <input type="checkbox" name="sms" class="" value="sms">  <?php echo lang('yes'); ?>
                     </div> -->
                    <input type="hidden" name="id" id="appointment_id" value=''>
                    <div class="form-group col-md-12 hidden consultant_fee_div" style="padding-top: 20px;">
                        <label for="exampleInputEmail1"><?php echo lang('visit'); ?> <?php echo lang('charges'); ?></label>
                        <input type="number" class="form-control" name="visit_charges" id="visit_charges1" value='' placeholder="" readonly="">
                    </div>
                    <?php if (!$this->ion_auth->in_group(array('Nurse', 'Doctor'))) { ?> 
                        <div class="col-md-12 hidden pay_now">
                            <input type="checkbox" id="pay_now_appointment1" name="pay_now_appointment" value="pay_now_appointment">
                            <label for=""> <?php echo lang('pay_now'); ?></label><br>
                            <span style="color:red;"><?php echo lang('if_pay_now_checked_please_select_status_to_confirmed') ?></span>
                        </div>
                        <div class="col-md-12 hidden payment_status form-group">
                            <label for=""> <?php echo lang('payment'); ?> <?php echo lang('status'); ?></label><br>
                            <input type="text"class="form-control" id="pay_now_appointment" name="payment_status_appointment" value="paid" readonly="">


                        </div>
                        <div class="payment_label col-md-12 hidden deposit_type1" style="text-align: left !important ;margin: 0% !important ;"> 
                            <label for="exampleInputEmail1"><?php echo lang('deposit_type'); ?></label>

                            <div class=""> 
                                <select class="form-control m-bot15 js-example-basic-single selecttype1" id="selecttype1" name="deposit_type" value=''> 
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
                                        <input type="text"  id="cardholder1" class="form-control pay_in" name="cardholder" value='' placeholder="">
                                    </div>
                                <?php } ?>
                                <?php if ($payment_gateway != 'Pay U Money' && $payment_gateway != 'Paystack' && $payment_gateway != 'SSLCOMMERZ' && $payment_gateway != 'Paytm') { ?>
                                    <div class="col-md-12 payment pad_bot">
                                        <label for="exampleInputEmail1"> <?php echo lang('card'); ?> <?php echo lang('number'); ?></label>
                                        <input type="text"  id="card1" class="form-control pay_in" name="card_number" value='' placeholder="">
                                    </div>



                                    <div class="col-md-8 payment pad_bot">
                                        <label for="exampleInputEmail1"> <?php echo lang('expire'); ?> <?php echo lang('date'); ?></label>
                                        <input type="text" class="form-control pay_in" id="expire1" data-date="" data-date-format="MM YY" placeholder="Expiry (MM/YY)" name="expire_date" maxlength="7" aria-describedby="basic-addon1" value='' placeholder="">
                                    </div>
                                    <div class="col-md-4 payment pad_bot">
                                        <label for="exampleInputEmail1"> <?php echo lang('cvv'); ?> </label>
                                        <input type="text" class="form-control pay_in" id="cvv1" maxlength="3" name="cvv" value='' placeholder="">
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
                                <div class="form-group cashsubmit1 payment  right-six col-md-12">
                                    <button type="submit" name="submit2" id="submit1" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                                </div>
                                <?php $twocheckout = $this->db->get_where('paymentGateway', array('name =' => '2Checkout'))->row(); ?>
                                <div class="form-group cardsubmit1  right-six col-md-12 hidden">
                                    <button type="submit" name="pay_now" id="submit-btn1" class="btn btn-info row pull-right" <?php if ($settings->payment_gateway == 'Stripe') {
                                    ?>onClick="stripePay1(event);"<?php }
                                ?> <?php if ($settings->payment_gateway == '2Checkout' && $twocheckout->status == 'live') {
                                    ?>onClick="twoCheckoutPay1(event);"<?php }
                                ?>> <?php echo lang('submit'); ?></button>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="form-group  payment  right-six col-md-12">
                            <button type="submit" name="submit2" id="submit1" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                        </div>
                    <?php } ?>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Edit Event Modal-->


<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">
                                        $(document).ready(function () {
                                            $(".table").on("click", ".editbutton", function () {
                                                //   e.preventDefault(e);
                                                // Get the record's ID via attribute  
                                                var iid = $(this).attr('data-id');
                                                var id = $(this).attr('data-id');

                                                $('#editAppointmentForm').trigger("reset");
                                                $('.consultant_fee_div').addClass('hidden');
                                                $('.pay_now').addClass('hidden');
                                                $('.payment_status').addClass('hidden');
                                                $('.deposit_type1').addClass('hidden');
                                                $('#editAppointmentForm').find('[name="doctor"]').html(" ");
                                                $('#editAppointmentForm').find('[name="patient"]').html(" ");
                                                $('#myModal2').modal('show');
                                                $.ajax({
                                                    url: 'appointment/editAppointmentByJason?id=' + iid,
                                                    method: 'GET',
                                                    data: '',
                                                    dataType: 'json',
                                                }).success(function (response) {
                                                    var de = response.appointment.date * 1000;
                                                    var d = new Date(de);
                                                    var da = d.getDate() + '-' + (d.getMonth() + 1) + '-' + d.getFullYear();
                                                    // Populate the form fields with the data returned from server
                                                    $('#editAppointmentForm').find('[name="id"]').val(response.appointment.id).end()
                                                    $('#editAppointmentForm').find('[name="patient"]').val(response.appointment.patient).end()
                                                    $('#editAppointmentForm').find('[name="doctor"]').val(response.appointment.doctor).end()
                                                    $('#editAppointmentForm').find('[name="date"]').val(da).end()
                                                    $('#editAppointmentForm').find('[name="status"]').val(response.appointment.status).end()
                                                    $('#editAppointmentForm').find('[name="remarks"]').val(response.appointment.remarks).end()
                                                    $('#editAppointmentForm').find('[name="category_appointment"]').val(response.appointment.category_appointment).end()
                                                    var option = new Option(response.patient.name + '-' + response.patient.id, response.patient.id, true, true);
                                                    $('#editAppointmentForm').find('[name="patient"]').append(option).trigger('change');
                                                    var option1 = new Option(response.doctor.name + '-' + response.doctor.id, response.doctor.id, true, true);
                                                    $('#editAppointmentForm').find('[name="doctor"]').append(option1).trigger('change');
                                                    $('#visit_description1').html("")
                                                    $.ajax({
                                                        url: 'doctor/getDoctorVisitForEdit?id=' + response.doctor.id + '&description=' + response.appointment.visit_description,
                                                        method: 'GET',
                                                        data: '',
                                                        dataType: 'json',
                                                    }).success(function (response) {


                                                        $('#visit_description1').html(response.response).end();
                                                        // $('#editAppointmentForm').find('[name="visit_description"]').val(response.appointment.visit_description).trigger('change').end();

                                                    });

                                                    if (response.appointment.payment_status == 'unpaid') {
                                                        $('.consultant_fee_div').removeClass('hidden');
                                                        $('.pay_now').removeClass('hidden');
                                                        $('.payment_status').addClass('hidden');
                                                        // $('.deposit_type1').removeClass('hidden');
                                                        $('#editAppointmentForm').find('[name="visit_charges"]').val(response.appointment.visit_charges).end()
                                                    } else {
                                                        $('.payment_status').removeClass('hidden');
                                                        $('.pay_now').addClass('hidden');
                                                        $('.consultant_fee_div').addClass('hidden');
                                                        //  $('.deposit_type1').addClass('hidden');
                                                        $("#editAppointmentForm").find('[id="adoctors1"]').select2([{id: response.doctor.id, text: response.doctor.name + '-' + response.doctor.id, locked: true}]);
                                                        $("#editAppointmentForm").find('[id="pos_select"]').select2([{id: response.patient.id, text: response.patient.name + '-' + response.patient.id, locked: true}]);
                                                    }




                                                    var date = $('#date1').val();
                                                    var doctorr = $('#adoctors1').val();
                                                    var appointment_id = $('#appointment_id').val();
                                                    // $('#default').trigger("reset");
                                                    $.ajax({
                                                        url: 'schedule/getAvailableSlotByDoctorByDateByAppointmentIdByJason?date=' + date + '&doctor=' + doctorr + '&appointment_id=' + appointment_id,
                                                        method: 'GET',
                                                        data: '',
                                                        dataType: 'json',
                                                    }).success(function (response) {
                                                        $('#aslots1').find('option').remove();
                                                        var slots = response.aslots;
                                                        $.each(slots, function (key, value) {
                                                            $('#aslots1').append($('<option>').text(value).val(value)).end();
                                                        });

                                                        $("#aslots1").val(response.current_value)
                                                                .find("option[value=" + response.current_value + "]").attr('selected', true);
                                                        //  $('#aslots1 option[value=' + response.current_value + ']').attr("selected", "selected");
                                                        //   $("#default-step-1 .button-next").trigger("click");
                                                        if ($('#aslots1').has('option').length == 0) {                    //if it is blank. 
                                                            $('#aslots1').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
                                                        }
                                                        // Populate the form fields with the data returned from server
                                                        //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
                                                    });
                                                });
                                            });
                                        });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $(".table").on("click", ".history", function () {

            //e.preventDefault(e);
            // Get the record's ID via attribute   
            var iid = $(this).attr('data-id');
            //var id = $(this).attr('data-id');
            console.log(iid);
            $('#editAppointmentForm').trigger("reset");
            $.ajax({
                url: 'patient/getMedicalHistoryByjason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                $('#medical_history').html("");
                $('#medical_history').append(response.view);

            });
            $('#cmodal').modal('show');
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




<script>


    $(document).ready(function () {
        var table = $('#editable-sample1').DataTable({
            responsive: true,
            //   dom: 'lfrBtip',

            "processing": true,
            "serverSide": true,
            "searchable": true,
            "ajax": {
                url: "appointment/getTodaysAppoinmentList",
                type: 'POST',
            },
            scroller: {
                loadingIndicator: true
            },
            dom: "<'row'<'col-sm-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",

            buttons: [
                {extend: 'copyHtml5', exportOptions: {columns: [0, 1, 2, 3, 4, 5], }},
                {extend: 'excelHtml5', exportOptions: {columns: [0, 1, 2, 3, 4, 5], }},
                {extend: 'csvHtml5', exportOptions: {columns: [0, 1, 2, 3, 4, 5], }},
                {extend: 'pdfHtml5', exportOptions: {columns: [0, 1, 2, 3, 4, 5], }},
                {extend: 'print', exportOptions: {columns: [0, 1, 2, 3, 4, 5], }},
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





<script type="text/javascript">
    $(document).ready(function () {
        $("#adoctors").change(function () {
            // Get the record's ID via attribute  
            var iid = $('#date').val();
            var doctorr = $('#adoctors').val();
            $('#aslots').find('option').remove();
            // $('#default').trigger("reset");
            $.ajax({
                url: 'schedule/getAvailableSlotByDoctorByDateByJason?date=' + iid + '&doctor=' + doctorr,
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
              $('#visit_description').html(" ");
                 $('#visit_charges').val(" ");
            $.ajax({
                url: 'doctor/getDoctorVisit?id=' + doctorr,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {


                $('#visit_description').html(response.response).end();

                //   $("#default-step-1 .button-next").trigger("click");
                //if ($('#visit_description').has('option').length == 0) {                    //if it is blank. 
                //   $('#visit_description').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
                // }
                // Populate the form fields with the data returned from server
                //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
            });
        });

    });

    $(document).ready(function () {
        var iid = $('#date').val();
        var doctorr = $('#adoctors').val();
        $('#aslots').find('option').remove();
        // $('#default').trigger("reset");
        $.ajax({
            url: 'schedule/getAvailableSlotByDoctorByDateByJason?date=' + iid + '&doctor=' + doctorr,
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
        var iid = $('#date').val();
        var doctorr = $('#adoctors').val();
        $('#aslots').find('option').remove();
        // $('#default').trigger("reset");
        $.ajax({
            url: 'schedule/getAvailableSlotByDoctorByDateByJason?date=' + iid + '&doctor=' + doctorr,
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












<script type="text/javascript">
    $(document).ready(function () {
        $("#adoctors1").change(function () {
            // Get the record's ID via attribute 
            var id = $('#appointment_id').val();
            var date = $('#date1').val();
            var doctorr = $('#adoctors1').val();
            $('#aslots1').find('option').remove();
            // $('#default').trigger("reset");
            $.ajax({
                url: 'schedule/getAvailableSlotByDoctorByDateByAppointmentIdByJason?date=' + date + '&doctor=' + doctorr + '&appointment_id=' + id,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                var slots = response.aslots;
                $.each(slots, function (key, value) {
                    $('#aslots1').append($('<option>').text(value).val(value)).end();
                });
                //   $("#default-step-1 .button-next").trigger("click");
                if ($('#aslots1').has('option').length == 0) {                    //if it is blank. 
                    $('#aslots1').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
                }
                // Populate the form fields with the data returned from server
                //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
            });
              $('#visit_description1').html(" ");
                 $('#visit_charges1').val(" ");
            $.ajax({
                url: 'doctor/getDoctorVisit?id=' + doctorr,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {


                $('#visit_description1').html(response.response).end();

                //   $("#default-step-1 .button-next").trigger("click");
                //if ($('#visit_description').has('option').length == 0) {                    //if it is blank. 
                //   $('#visit_description').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
                // }
                // Populate the form fields with the data returned from server
                //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
            });
        });
    });

    $(document).ready(function () {
        var id = $('#appointment_id').val();
        var date = $('#date1').val();
        var doctorr = $('#adoctors1').val();
        $('#aslots1').find('option').remove();
        // $('#default').trigger("reset");
        $.ajax({
            url: 'schedule/getAvailableSlotByDoctorByDateByAppointmentIdByJason?date=' + date + '&doctor=' + doctorr + '&appointment_id=' + id,
            method: 'GET',
            data: '',
            dataType: 'json',
        }).success(function (response) {
            var slots = response.aslots;
            $.each(slots, function (key, value) {
                $('#aslots1').append($('<option>').text(value).val(value)).end();
            });
            //   $("#default-step-1 .button-next").trigger("click");
            if ($('#aslots1').has('option').length == 0) {                    //if it is blank. 
                $('#aslots1').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
            }
            // Populate the form fields with the data returned from server
            //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
        });

    });




    $(document).ready(function () {
        $('#date1').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
        })
                //Listen for the change even on the input
                .change(dateChanged1)
                .on('changeDate', dateChanged1);
    });

    function dateChanged1() {
        // Get the record's ID via attribute  
        var id = $('#appointment_id').val();
        var iid = $('#date1').val();
        var doctorr = $('#adoctors1').val();
        $('#aslots1').find('option').remove();
        // $('#default').trigger("reset");
        $.ajax({
            url: 'schedule/getAvailableSlotByDoctorByDateByAppointmentIdByJason?date=' + iid + '&doctor=' + doctorr + '&appointment_id=' + id,
            method: 'GET',
            data: '',
            dataType: 'json',
        }).success(function (response) {
            var slots = response.aslots;
            $.each(slots, function (key, value) {
                $('#aslots1').append($('<option>').text(value).val(value)).end();
            });
            //   $("#default-step-1 .button-next").trigger("click");
            if ($('#aslots1').has('option').length == 0) {                    //if it is blank. 
                $('#aslots1').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
            }


            // Populate the form fields with the data returned from server
            //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
        });

    }




</script>


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
        $(".patient").select2({
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
        $("#adoctors1").select2({
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
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
<script>
    $(document).ready(function () {
        $("#visit_description").change(function () {
            // Get the record's ID via attribute  
            var id = $(this).val();

            $('#visit_charges').val(" ");
            // $('#default').trigger("reset");

            $.ajax({
                url: 'doctor/getDoctorVisitCharges?id=' + id,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {


                $('#visit_charges').val(response.response.visit_charges).end();


            });
        });

    });
    $(document).ready(function () {
        $("#visit_description1").change(function () {
            // Get the record's ID via attribute  
            var id = $(this).val();

            $('#visit_charges1').val(" ");
            // $('#default').trigger("reset");

            $.ajax({
                url: 'doctor/getDoctorVisitCharges?id=' + id,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {


                $('#visit_charges1').val(response.response.visit_charges).end();


            });
        });

    });
</script>
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
        $('.card1').hide();
        $(document.body).on('change', '#selecttype1', function () {

            var v = $("select.selecttype1 option:selected").val()
            if (v == 'Card') {
                $('.cardsubmit1').removeClass('hidden');
                $('.cashsubmit1').addClass('hidden');
                // $("#amount_received").prop('required', true);
                // $('#amount_received').attr("required");;
                $('.card1').show();
            } else {
                $('.card1').hide();
                $('.cashsubmit1').removeClass('hidden');
                $('.cardsubmit1').addClass('hidden');
                // $("#amount_received").prop('required', false);
                //$('#amount_received').removeAttr('required');
            }
        });
        $('#pay_now_appointment').change(function () {
            if ($(this).prop("checked") == true) {
                $('.deposit_type').removeClass('hidden');
                $('#addAppointmentForm').find('[name="deposit_type"]').trigger("reset")
                // $('#editAppointmentForm').find('[name="status"]').val("Confirmed").end()
            } else {
                $('#addAppointmentForm').find('[name="deposit_type"]').val("").end()
                $('.deposit_type').addClass('hidden');
                //  $('#editAppointmentForm').find('[name="status"]').val("").end()

                $('.card').hide();
            }

        })
        $('#pay_now_appointment1').change(function () {
            if ($(this).prop("checked") == true) {
                $('.deposit_type1').removeClass('hidden');
                $('#editAppointmentForm').find('[name="deposit_type"]').trigger("reset")
                // $('#editAppointmentForm').find('[name="status"]').val("Confirmed").end()
            } else {
                $('#editAppointmentForm').find('[name="deposit_type"]').val("").end()
                $('.deposit_type1').addClass('hidden');
                //  $('#editAppointmentForm').find('[name="status"]').val("").end()

                $('.card1').hide();
            }

        })
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
            $("#addAppointmentForm").append("<input type='hidden' name='token' value='" + token + "' />");
            //submit form to the server
            $("#addAppointmentForm").submit();
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
<script>
    function cardValidation1() {
        var valid = true;
        var cardNumber = $('#card1').val();
        var expire = $('#expire1').val();
        var cvc = $('#cvv1').val();

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
    function stripeResponseHandler1(status, response) {
        if (response.error) {
            //enable the submit button
            $("#submit-btn1").show();
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

    function stripePay1(e) {
        e.preventDefault();
        var valid = cardValidation1();

        if (valid == true) {
            $("#submit-btn1").attr("disabled", true);
            $("#loader").css("display", "inline-block");
            var expire = $('#expire1').val()
            var arr = expire.split('/');
            Stripe.createToken({
                number: $('#card1').val(),
                cvc: $('#cvv1').val(),
                exp_month: arr[0],
                exp_year: arr[1]
            }, stripeResponseHandler1);

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
            var myForm = document.getElementById('addAppointmentForm');
            // Set the token as the value for the token input
            // alert(data.response.token.token);
            $("#addAppointmentForm").append("<input type='hidden' name='token' value='" + data.response.token.token + "' />");
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
<?php if ($settings->payment_gateway == '2Checkout') { ?> 
    <script>

        //   $(document).ready(function () {
        // Called when token created successfully.
        var successCallback1 = function (data) {
            var myForm = document.getElementById('editAppointmentForm');
            // Set the token as the value for the token input
            // alert(data.response.token.token);
            $("#editAppointmentForm").append("<input type='hidden' name='token' value='" + data.response.token.token + "' />");
            //    myForm.token.value = data.response.token.token;
            // IMPORTANT: Here we call `submit()` on the form element directly instead of using jQuery to prevent and infinite token request loop.
            myForm.submit();
        };
        // Called when token creation fails.
        var errorCallback1 = function (data) {
            if (data.errorCode === 200) {
                tokenRequest();
            } else {
                alert(data.errorMsg);
            }
        };
        var tokenRequest1 = function () {
    <?php $twocheckout = $this->db->get_where('paymentGateway', array('name =' => '2Checkout'))->row(); ?>
            // Setup token request arguments  
            var expire = $("#expire1").val();
            var expiresep = expire.split("/");
            var dateformat = moment(expiresep[1], "YY");
            var year = dateformat.format("YYYY");
            var args = {
                sellerId: "<?php echo $twocheckout->merchantcode; ?>",
                publishableKey: "<?php echo $twocheckout->publishablekey; ?>",
                ccNo: $("#card1").val(),
                cvv: $("#cvv1").val(),
                expMonth: expiresep[0],
                expYear: year
            };
            console.log($("#card1").val() + '-' + $("#cvv1").val() + expiresep[0] + year + "<?php echo $twocheckout->merchantcode; ?>");
            // Make the token request

            TCO.requestToken(successCallback1, errorCallback1, args);
        };
        //   });
        function twoCheckoutPay1(e) {
            e.preventDefault();

            // try {
            // Pull in the public encryption key for our environment
            // TCO.loadPubKey('production');
            TCO.loadPubKey('sandbox', function () {  // for sandbox environment
                publishableKey = "<?php echo $twocheckout->publishablekey; ?>"//your public key
                tokenRequest1();
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
