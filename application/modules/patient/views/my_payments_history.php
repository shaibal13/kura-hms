
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="no-print col-md-8">
            <header class="panel-heading">
                <?php echo lang('payment_history'); ?>



                <div class="panel-body no-print pull-right">
                    <a data-toggle="modal" href="#myModal">
                        <div class="btn-group">
                            <button id="" class="btn btn-xs green">
                                <i class="fa fa-plus-circle"></i> <?php echo lang('deposit'); ?>
                            </button>
                        </div>
                    </a>   
                </div>

                <div class="panel-body no-print pull-right">
                    <a data-toggle="modal" href="#myModal5">
                        <div class="btn-group">
                            <button id="" class="btn btn-xs green">
                                <i class="fa fa-file"></i> <?php echo lang('invoice'); ?>
                            </button>
                        </div>
                    </a>   
                </div>



            </header>
            <div class=" panel-body">
                <div class="adv-table editable-table ">


                    <section class="col-md-12 no-print row">
                        <form role="form" class="f_report" action="patient/myPaymentHistory" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <!--     <label class="control-label col-md-3">Date Range</label> -->
                                <div class="col-md-6">
                                    <div class="input-group input-large" data-date="13/07/2013" data-date-format="mm/dd/yyyy">
                                        <input type="text" class="form-control dpd1" name="date_from" value="<?php
                                        if (!empty($date_from)) {
                                            echo date('m/d/Y', $date_from);
                                        }
                                        ?>" placeholder="<?php echo lang('date_from'); ?>" readonly="">
                                        <span class="input-group-addon"><?php echo lang('to'); ?></span>
                                        <input type="text" class="form-control dpd2" name="date_to" value="<?php
                                        if (!empty($date_to)) {
                                            echo date('m/d/Y', $date_to);
                                        }
                                        ?>" placeholder="<?php echo lang('date_to'); ?>" readonly="">
                                        <input type="hidden" class="form-control dpd2" name="patient" value="<?php echo $patient->id; ?>">
                                    </div>
                                    <div class="row"></div>
                                    <span class="help-block"></span> 
                                </div>
                                <div class="col-md-6 no-print">
                                    <button type="submit" name="submit" class="btn btn-info range_submit"><?php echo lang('submit'); ?></button>
                                </div>
                            </div>
                        </form>
                    </section>

                    <header class="panel-heading col-md-12 row">
                        <?php echo lang('all_bills'); ?> & <?php echo lang('deposits'); ?>
                    </header>
                    <div class="space15"></div>
                    <table class="table table-striped table-hover table-bordered" id="editable-samples">
                        <thead>
                            <tr>
                                <th class=""><?php echo lang('date'); ?></th>
                                <th class=""><?php echo lang('invoice'); ?> #</th>
                                <th class=""><?php echo lang('bill_amount'); ?></th>
                                <th class=""><?php echo lang('deposit'); ?></th>
                                <th class=""><?php echo lang('deposit_type'); ?></th>
                                <th class=""><?php echo lang('from'); ?></th>
                                <th class="no-print"><?php echo lang('options'); ?></th>
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
                            .option_th{
                                width:33%;
                            }

                        </style>

                        <?php
                        $dates = array();
                        $datess = array();
                        foreach ($payments as $payment) {
                            $dates[] = $payment->date;
                        }
                        foreach ($deposits as $deposit) {
                            $datess[] = $deposit->date;
                        }
                        $dat = array_merge($dates, $datess);
                        $dattt = array_unique($dat);
                        asort($dattt);

                        $total_pur = array();

                        $total_p = array();
                        ?>

                        <?php
                        foreach ($dattt as $key => $value) {
                            foreach ($payments as $payment) {
                                if ($payment->date == $value) {
                                    ?>
                                    <tr class="">
                                        <td><?php echo date('d-m-y', $payment->date); ?></td>
                                        <td> <?php echo $payment->id; ?></td>
                                        <td><?php echo $settings->currency; ?> <?php echo $payment->gross_total; ?></td>
                                        <td><?php
                                            if (!empty($payment->amount_received)) {
                                                echo $settings->currency;
                                            }
                                            ?> <?php echo $payment->amount_received; ?>
                                        </td>

                                        <td> <?php echo $payment->deposit_type; ?></td>
                                        <td> 
                                            <?php
                                            if ($payment->payment_from == 'appointment') {
                                                echo lang('appointment');
                                            } elseif ($payment->payment_from == 'bed') {
                                                echo lang('allotment_medicine');
                                            } elseif ($payment->payment_from == 'case') {
                                                echo lang('case');
                                            } elseif ($payment->payment_from == 'bed_service') {
                                                echo lang('allotment_service');
                                            } elseif ($payment->payment_from == 'payment') {
                                                echo lang('payment');
                                            }elseif ($payment->payment_from == 'pre_service') {
                                                echo lang('pre_surgery') . ' ' . lang('service');
                                            } elseif ($payment->payment_from == 'post_service') {
                                                echo lang('post_surgery') . ' ' . lang('service');
                                            } elseif ($payment->payment_from == 'surgery') {
                                                echo lang('surgery');
                                            } elseif ($payment->payment_from == 'pre_surgery_medical_analysis') {
                                                echo lang('pre_surgery') . ' ' . lang('medical_analysis');
                                            } elseif ($payment->payment_from == 'post_surgery_medical_analysis') {
                                                echo lang('post_surgery') . ' ' . lang('medical_analysis');
                                            } elseif ($payment->payment_from == 'pre_surgery_medicine') {
                                                echo lang('pre_surgery') . ' ' . lang('medicine');
                                            } elseif ($payment->payment_from == 'post_surgery_medicine') {
                                                echo lang('post_surgery') . ' ' . lang('medicine');
                                            }
                                            ?></td>


                                        <td  class="no-print">
                                            <?php if ($payment->payment_from == 'payment') { ?>
                                                <a class="btn-xs invoicebutton" title="<?php echo lang('invoice'); ?>" style="color: #fff; width: 23px;" href="patient/myInvoice?id=<?php echo $payment->id; ?>"><i class="fas fa-file-invoice"></i> </a>
                                            <?php } elseif ($payment->payment_from == 'bed_service') { ?>
                                                <a class="btn-xs invoicebutton" title="<?php echo lang('invoice'); ?>" style="color: #fff; width: 25%;" href="patient/myInvoice?id=<?php echo $payment->id; ?>"><i class="fa fa-file-invoice"></i> </a>  
                                            <?php } elseif ($payment->payment_from == 'bed') { ?>
                                                <a class="btn-xs invoicebutton" title="<?php echo lang('invoice'); ?>" style="color: #fff; width: 25%;" href="patient/myInvoice?id=<?php echo $payment->id; ?>"><i class="fa fa-file-invoice"></i> </a>    
                                                <?php
                                            } elseif ($payment->payment_from == 'case') {
                                                $caselist = $this->db->get_where('medical_history', array('id' => $payment->case_id))->row();
                                               // if ($payment->case_status == 'Confirmed') {
                                                    ?>

                                                    <a class="btn-xs invoicebutton" title="<?php echo lang('invoice'); ?>" style="color: #fff; width: 25%;" href="patient/myInvoice?id=<?php echo $payment->id; ?>"><i class="fa fa-file-invoice"></i> </a>
                                                    <?php
                                               // }
                                            }  elseif ($payment->payment_from == 'appointment') {
                                                $appointment = $this->db->get_where('appointment', array('payment_id' => $payment->id))->row();
                                              //  if ($appointment->status == 'Confirmed') {
                                                    ?> 
                                                    <a class="btn-xs invoicebutton" title="<?php echo lang('invoice'); ?>" style="color: #fff; width: 23px;" href="patient/myInvoice?id=<?php echo $payment->id; ?>"><i class="fas fa-file-invoice"></i> </a>
                                                <?php //} ?>


                                            <?php } else{ ?>
                                                <a class="btn-xs invoicebutton" title="<?php echo lang('invoice'); ?>" style="color: #fff; width: 25%;" href="patient/myInvoice?id=<?php echo $payment->id; ?>"><i class="fa fa-file-invoice"></i> </a>
                                            <?php } 
                                            ?>
                                        </td>
                                    </tr>

                                    <?php
                                }
                            }
                            ?>


                            <?php
                            foreach ($deposits as $deposit) {
                                if ($deposit->date == $value) {
                                    if (!empty($deposit->deposited_amount) && empty($deposit->amount_received_id)) {
                                        ?>

                                        <tr class="">
                                            <td><?php echo date('d-m-y', $deposit->date); ?></td>
                                            <td><?php echo $deposit->payment_id; ?></td>
                                            <td></td>
                                            <td><?php echo $settings->currency; ?> <?php echo $deposit->deposited_amount; ?></td>
                                            <td> <?php echo $deposit->deposit_type; ?></td>  
                                            <td></td>
                                            <td  class="no-print"> 
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        <?php } ?>



                        </tbody>

                    </table>
                </div>
            </div>

        </section>


        <section class="no-print col-md-4">
            <header class="panel-heading">
                <?php echo lang(''); ?>
            </header>

            <div class="">
                <section class="m_t">
                    <div class="panel-body profile">
                        <div class="task-thumb-details">
                            <?php echo lang('patient'); ?> <?php echo lang('name'); ?>: <h1><a href="#"><?php echo $patient->name; ?></a></h1> <br>
                            <?php echo lang('address'); ?>: <p> <?php echo $patient->address; ?></p>
                        </div>
                    </div>
                    <table class="table table-hover personal-task">
                        <tbody>
                            <tr>
                                <td>
                                    <i class=" fa fa-envelope"></i>
                                </td>
                                <td><?php echo $patient->email; ?></td>

                            </tr>
                            <tr>
                                <td>
                                    <i class="fa fa-phone"></i>
                                </td>
                                <td><?php echo $patient->phone; ?></td>

                            </tr>

                        </tbody>
                    </table>
                </section>

                <?php
                $total_bill = array();
                foreach ($payments as $payment) {
                    $total_bill[] = $payment->gross_total;
                }
                if (!empty($total_bill)) {
                    $total_bill = array_sum($total_bill);
                } else {
                    $total_bill = 0;
                }
                ?>






                <section class="panel">
                    <div class="weather-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-money"></i>
                                    <?php echo lang('total_bill_amount'); ?>
                                </div>
                                <div class="col-xs-8">
                                    <div class="degree">
                                        <?php echo $settings->currency; ?>
                                        <?php echo $total_payable_bill = $total_bill; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="panel">
                    <div class="weather-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-money"></i>
                                    <?php echo lang('total_deposit_amount'); ?>
                                </div>
                                <div class="col-xs-8">
                                    <div class="degree">
                                        <?php echo $settings->currency; ?>
                                        <?php
                                        $total_deposit = array();
                                        foreach ($deposits as $deposit) {
                                            $total_deposit[] = $deposit->deposited_amount;
                                        }
                                        echo array_sum($total_deposit);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="panel red"  style="border: 2px solid red; color: red;">
                    <div class="weather-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-money"></i>
                                    <?php echo lang('due_amount'); ?>
                                </div>
                                <div class="col-xs-8">
                                    <div class="degree">
                                        <?php echo $settings->currency; ?>
                                        <?php
                                        echo $total_payable_bill - array_sum($total_deposit);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->









<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('add_deposit'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="patient/deposit" id="deposit-form" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group"> 
                        <label for="exampleInputEmail1"><?php echo lang('invoice'); ?></label> 
                        <select class="form-control m-bot15 js-example-basic-single" id="" name="payment_id" value='' required=""> 
                            <option value="">Select .....</option>
                            <?php foreach ($payments as $payment) { ?>
                                <option value="<?php echo $payment->id; ?>" <?php
                                if (!empty($deposit->payment_id)) {
                                    if ($deposit->payment_id == $payment->id) {
                                        echo 'selected';
                                    }
                                }
                                ?> ><?php echo $payment->id; ?> </option>
                                    <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('deposit_amount'); ?></label>
                        <input type="text" class="form-control" name="deposited_amount" id="exampleInputEmail1" value='' placeholder="">
                    </div>



                    <div class="form-group">
                        <div class=""> 
                            <label for="exampleInputEmail1"><?php echo lang('deposit_type'); ?></label>
                        </div>
                        <div class=""> 
                            <select class="form-control m-bot15 js-example-basic-single selecttype" id="selecttype" name="deposit_type" value=''> 

                                <option value="Card"> <?php echo lang('card'); ?> </option>  
                            </select>
                        </div>

                        <?php
                        $payment_gateway = $settings->payment_gateway;
                        ?>



                        <div class = "card">

                            <hr>
                            <div class="col-md-12 payment pad_bot">
                                <label for="exampleInputEmail1"> <?php echo lang('accepted'); ?> <?php echo lang('cards'); ?></label>
                                <div class="payment pad_bot">
                                    <img src="uploads/card.png" width="100%">
                                </div> 
                            </div>

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
                                    <input type="text" class="form-control pay_in" id="card"  name="card_number" value='' placeholder="">
                                </div>



                                <div class="col-md-8 payment pad_bot">
                                    <label for="exampleInputEmail1"> <?php echo lang('expire'); ?> <?php echo lang('date'); ?></label>
                                    <input type="text" class="form-control pay_in" data-date="" id="expire" data-date-format="MM YY" placeholder="Expiry (MM/YY)" name="expire_date" maxlength="7" aria-describedby="basic-addon1" value='' placeholder="">
                                </div>
                                <div class="col-md-4 payment pad_bot">
                                    <label for="exampleInputEmail1"> <?php echo lang('cvv'); ?> </label>
                                    <input type="text" class="form-control pay_in" id="cvv" maxlength="3" name="cvv_number" value='' placeholder="">
                                </div> 

                            </div>

                            <?php
                        }
                        ?>

                    </div> 



                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="patient" value='<?php echo $patient->id; ?>'>

                    <div class="form-group cardsubmit  right-six col-md-12"> 
                        <?php $twocheckout = $this->db->get_where('paymentGateway', array('name =' => '2Checkout'))->row(); ?>
                        <button type="submit" name="pay_now" id="submit-btn" class="btn btn-info row pull-right" <?php if ($settings->payment_gateway == 'Stripe') {
                            ?>onClick="stripePay(event);"<?php }
                        ?><?php if ($settings->payment_gateway == '2Checkout' && $twocheckout->status == 'live') {
                            ?>onClick="twoCheckoutPay(event);"<?php }
                        ?>> <?php echo lang('submit'); ?></button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
</div>
<!-- Add Patient Modal-->









<div class="modal fade" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header no-print">
                <button type="button" class="close no-print" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('invoice'); ?></h4>
            </div>
            <div class="modal-body clearfix">
                <div class="panel panel-primary">
                    <!--<div class="panel-heading navyblue"> INVOICE</div>-->
                    <div class="panel-body col-md-12" style="font-size: 10px;">
                        <div class="row invoice-list">

                            <div class="text-center corporate-id top_title">

                                <img alt="" src="<?php echo $this->settings_model->getSettings()->logo; ?>" width="200" height="100">
                                <h3>
                                    <?php echo $settings->title ?>
                                </h3>
                                <h4>
                                    <?php echo $settings->address ?>
                                </h4>
                                <h4>
                                    Tel: <?php echo $settings->phone ?>
                                </h4>
                            </div>

                            <div class="col-lg-4 col-sm-4" style="float: left;">
                                <h4><?php echo lang('payment_to'); ?>:</h4>
                                <p>
                                    <?php echo $settings->title; ?> <br>
                                    <?php echo $settings->address; ?><br>
                                    Tel:  <?php echo $settings->phone; ?>
                                </p>
                            </div>

                            <?php if (!empty($payment->patient)) { ?>


                                <div class="col-lg-4 col-sm-4" style="float: left;">
                                    <h4><?php echo lang('bill_to'); ?>:</h4>
                                    <p>
                                        <?php
                                        if (!empty($patient->name)) {
                                            echo $patient->name . ' <br>';
                                        }
                                        if (!empty($patient->address)) {
                                            echo $patient->address . ' <br>';
                                        }
                                        if (!empty($patient->phone)) {
                                            echo $patient->phone . ' <br>';
                                        }
                                        ?>
                                    </p>
                                </div>


                            <?php } ?>

                            <div class="col-lg-4 col-sm-4" style="float: left;">
                                <h4><?php echo lang('invoice_info'); ?></h4>
                                <ul class="unstyled">
                                    <li>Date		: <?php echo date('m/d/Y'); ?></li>
                                </ul>

                            </div>
                            <br>

                        </div>






                        <table class="table table-striped table-hover table-bordered" id="editable-samples">
                            <thead>
                                <tr>
                                    <th class=""><?php echo lang('date'); ?></th>
                                    <th class=""><?php echo lang('invoice'); ?> #</th>
                                    <th class=""><?php echo lang('bill_amount'); ?></th>
                                    <th class=""><?php echo lang('deposit'); ?></th>
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
                                .option_th{
                                    width:33%;
                                }

                            </style>

                            <?php
                            $dates = array();
                            $datess = array();
                            foreach ($payments as $payment) {
                                $dates[] = $payment->date;
                            }
                            foreach ($deposits as $deposit) {
                                $datess[] = $deposit->date;
                            }
                            $dat = array_merge($dates, $datess);
                            $dattt = array_unique($dat);
                            asort($dattt);

                            $total_pur = array();

                            $total_p = array();
                            ?>

                            <?php
                            foreach ($dattt as $key => $value) {
                                foreach ($payments as $payment) {
                                    if ($payment->date == $value) {
                                        ?>
                                        <tr class="">
                                            <td><?php echo date('d/m/y', $payment->date); ?></td>
                                            <td> <?php echo $payment->id; ?></td>
                                            <td><?php echo $settings->currency; ?> <?php echo $payment->gross_total; ?></td>
                                            <td><?php
                                                if (!empty($payment->amount_received)) {
                                                    echo $settings->currency;
                                                }
                                                ?> <?php echo $payment->amount_received; ?>
                                            </td>


                                        </tr>

                                        <?php
                                    }
                                }
                                ?>


                                <?php
                                foreach ($deposits as $deposit) {
                                    if ($deposit->date == $value) {
                                        if (!empty($deposit->deposited_amount) && empty($deposit->amount_received_id)) {
                                            ?>

                                            <tr class="">
                                                <td><?php echo date('d-m-y', $deposit->date); ?></td>
                                                <td><?php echo $deposit->payment_id; ?></td>
                                                <td></td>
                                                <td><?php echo $settings->currency; ?> <?php echo $deposit->deposited_amount; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            <?php } ?>



                            </tbody>

                        </table>





                        <div class="row">
                            <div class="col-lg-8 invoice-block pull-right total_section">
                                <ul class="unstyled amounts"> 
                                    <li><strong><?php echo lang('grand_total'); ?> : </strong><?php echo $settings->currency; ?> <?php echo $total_payable_bill = $total_bill; ?></li>
                                    <li><strong><?php echo lang('amount_received'); ?> : </strong><?php echo $settings->currency; ?> <?php echo array_sum($total_deposit); ?></li>
                                    <li><strong><?php echo lang('amount_to_be_paid'); ?> : </strong><?php echo $settings->currency; ?> <?php echo $total_payable_bill - array_sum($total_deposit); ?></li>
                                </ul>
                            </div>
                        </div>


                        <div class="text-center invoice-btn">

                            <a class="btn btn-info btn-lg invoice_button" onclick="javascript:window.print();"><i class="fa fa-print"></i> Print </a>
                        </div>


                    </div>



                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
</div>



<style>

    @media print {

        .modal-content{
            width: 100%;
        }


        .modal{
            overflow: hidden;
        }
    }



</style>



<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="vendor/jquery/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="common/js/ajaxrequest-codearistos.min.js"></script>
<script type="text/javascript">
                                $(document).ready(function () {
                                    $(".editbutton").click(function (e) {
                                        e.preventDefault(e);
                                        // Get the record's ID via attribute  
                                        var iid = $(this).attr('data-id');
                                        $('#editDepositform').trigger("reset");
                                        $.ajax({
                                            url: 'finance/editDepositbyJason?id=' + iid,
                                            method: 'GET',
                                            data: '',
                                            dataType: 'json',
                                        }).success(function (response) {
                                            // Populate the form fields with the data returned from server
                                            if (response.deposit.deposit_type != 'Card') {
                                                $('#editDepositform').find('[name="id"]').val(response.deposit.id).end()
                                                $('#editDepositform').find('[name="patient"]').val(response.deposit.patient).end()
                                                $('#editDepositform').find('[name="payment_id"]').val(response.deposit.payment_id).end()
                                                $('#editDepositform').find('[name="date"]').val(response.deposit.date).end()
                                                $('#editDepositform').find('[name="deposited_amount"]').val(response.deposit.deposited_amount).end()

                                                $('#myModal2').modal('show');

                                            } else {
                                                alert('Payement Processed By Card can not be edited. Thanks.')
                                            }
                                        });
                                    });
                                });
</script>



<script>
    $(document).ready(function () {
        //   $('.card').hide();
        $(document.body).on('change', '#selecttype', function () {

            var v = $("select.selecttype option:selected").val()
            if (v == 'Card') {
                $('.card').show();
                $('.cardsubmit').removeClass('hidden');
                $('.cashsubmit').addClass('hidden');
            } else {
                $('.card').hide();
                $('.cashsubmit').removeClass('hidden');
                $('.cardsubmit').addClass('hidden');
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
            $("#deposit-form").append("<input type='hidden' name='token' value='" + token + "' />");
            console.log(token);
            //submit form to the server
            $("#deposit-form").submit();
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
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
<script src="common/js/moment.min.js"></script>

<script type="text/javascript" src="https://www.2checkout.com/checkout/api/2co.min.js"></script>
<?php if ($settings->payment_gateway == '2Checkout') { ?> 
    <script>

    //   $(document).ready(function () {
    // Called when token created successfully.
    var successCallback = function (data) {
        var myForm = document.getElementById('editPaymentForm');
        // Set the token as the value for the token input
        // alert(data.response.token.token);
        $("#editPaymentForm").append("<input type='hidden' name='token' value='" + data.response.token.token + "' />");
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
