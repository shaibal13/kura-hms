<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- invoice start-->
        <section class="col-md-7">


            <div class="panel panel-primary">
                <!--<div class="panel-heading navyblue"> INVOICE</div>-->
                <div class="panel-body" style="font-size: 10px;">
                    <div class="row invoice-list">

                        <div class="col-md-12 invoice_head clearfix">

                            <div class="col-md-6 text-left invoice_head_left">
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
                            <div class="col-md-6 text-right invoice_head_right">
                                <img alt="" src="<?php echo $this->settings_model->getSettings()->logo; ?>" width="200" height="100">
                            </div>



                        </div>

                        <div class="col-md-12 hr_border">
                            <hr>
                        </div>


                        <div class="col-md-12">
                            <h4 class="text-center" style="font-weight: bold; margin-top: 20px; text-transform: uppercase;">
                                <?php
                                if ($payment->payment_from == 'appointment') {
                                    echo lang('appointment')
                                    ?> <?php
                                    echo lang('invoice');
                                } else {
                                    echo lang('payment')
                                    ?> <?php
                                    echo lang('invoice');
                                }
                                ?>
                            </h4>
                        </div>

                        <div class="col-md-12 hr_border">
                            <hr>
                        </div>


                        <div class="col-md-12">
                            <div class="col-md-6 pull-left row" style="text-align: left;">
                                <div class="col-md-12 row details" style="">
                                    <p>
                                        <?php $patient_info = $this->db->get_where('patient', array('id' => $payment->patient))->row(); ?>
                                        <label class="control-label"><?php echo lang('patient'); ?> <?php echo lang('name'); ?> </label>
                                        <span style="text-transform: uppercase;"> : 
                                            <?php
                                            if (!empty($patient_info)) {
                                                echo $patient_info->name . ' <br>';
                                            }
                                            ?>
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-12 row details" style="">
                                    <p>
                                        <label class="control-label"><?php echo lang('patient_id'); ?>  </label>
                                        <span style="text-transform: uppercase;"> : 
                                            <?php
                                            if (!empty($patient_info)) {
                                                echo $patient_info->id . ' <br>';
                                            }
                                            ?>
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-12 row details" style="">
                                    <p>
                                        <label class="control-label"> <?php echo lang('address'); ?> </label>
                                        <span style="text-transform: uppercase;"> : 
                                            <?php
                                            if (!empty($patient_info)) {
                                                echo $patient_info->address . ' <br>';
                                            }
                                            ?>
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-12 row details" style="">
                                    <p>
                                        <label class="control-label"><?php echo lang('phone'); ?>  </label>
                                        <span style="text-transform: uppercase;"> : 
                                            <?php
                                            if (!empty($patient_info)) {
                                                echo $patient_info->phone . ' <br>';
                                            }
                                            ?>
                                        </span>
                                    </p>
                                </div>


                            </div>

                            <div class="col-md-6 pull-right" style="text-align: left;">

                                <div class="col-md-12 row details" style="">
                                    <p>
                                        <label class="control-label"><?php echo lang('invoice'); ?>  </label>
                                        <span style="text-transform: uppercase;"> : 
                                            <?php
                                            if (!empty($payment->id)) {
                                                echo $payment->id;
                                            }
                                            ?>
                                        </span>
                                    </p>
                                </div>


                                <div class="col-md-12 row details">
                                    <p>
                                        <label class="control-label"><?php echo lang('date'); ?>  </label>
                                        <span style="text-transform: uppercase;"> : 
                                            <?php
                                            if (!empty($payment->date)) {
                                                echo date('d-m-Y', $payment->date) . ' <br>';
                                            }
                                            ?>
                                        </span>
                                    </p>
                                </div>
                                <?php if ($payment->payment_from != 'case' && $payment->payment_from != 'surgery' && $payment->payment_from != 'pre_surgery_medical_analysis' && $payment->payment_from != 'post_surgery_medical_analysis' && $payment->payment_from != 'pre_service' && $payment->payment_from != 'post_service') { ?>
                                    <div class="col-md-12 row details">
                                        <p>
                                            <label class="control-label"><?php echo lang('doctor'); ?>  </label>
                                            <span style="text-transform: uppercase;"> : 
                                                <?php
                                                if (!empty($payment->doctor)) {
                                                    $doc_details = $this->doctor_model->getDoctorById($payment->doctor);
                                                    if (!empty($doc_details)) {
                                                        echo $doc_details->name . ' <br>';
                                                    } else {
                                                        echo $payment->doctor_name . ' <br>';
                                                    }
                                                }
                                                ?>
                                            </span>
                                        </p>
                                    </div>

                                <?php } ?>

                            </div>

                        </div>






                    </div> 

                    <div class="col-md-12 hr_border">
                        <hr>
                    </div>




                    <table class="table table-striped table-hover">

                        <thead class="theadd">
                            <tr>
                                <?php if ($payment->payment_from == 'appointment') { ?>
                                    <th>#</th>
                                    <th><?php echo lang('description'); ?></th>
                                    <th><?php echo lang('date_time'); ?></th>
                                    <th><?php echo lang('doctor'); ?></th>
                                    <th><?php echo lang('amount'); ?></th>
                                <?php } elseif ($payment->payment_from == 'case' || $payment->payment_from == 'surgery' || $payment->payment_from == 'pre_surgery_medical_analysis' || $payment->payment_from == 'post_surgery_medical_analysis') { ?>
                                    <th>#</th>
                                    <th><?php echo lang('items'); ?></th>
                                    <th><?php echo lang('type'); ?></th>
                                    <th><?php echo lang('date_to_be_done'); ?></th>
                                    <th><?php echo lang('amount'); ?></th>
                                    <?php if ($payment->payment_from == 'case' ||$payment->payment_from == 'pre_surgery_medical_analysis' || $payment->payment_from == 'post_surgery_medical_analysis') { ?>
                                        <th><?php echo lang('discount'); ?></th>
                                        <th><?php echo lang('grand_total'); ?></th>
                                    <?php } ?>
                                <?php } elseif ($payment->payment_from == 'bed') { ?>
                                    <th>#</th>
                                    <th><?php echo lang('medicine'); ?> <?php echo lang('name'); ?></th>
                                    <th><?php echo lang('unit'); ?> <?php echo lang('price') ?></th>
                                    <th><?php echo lang('quantity'); ?></th>
                                    <th><?php echo lang('amount'); ?></th>
                                <?php } elseif ($payment->payment_from == 'bed_service') { ?>
                                    <th>#</th>
                                    <th><?php echo lang('service'); ?> <?php echo lang('name'); ?></th>
                                    <th><?php echo lang('unit'); ?> <?php echo lang('price') ?></th>
                                    <th><?php echo lang('quantity'); ?></th>
                                    <th><?php echo lang('amount'); ?></th>
                                <?php } elseif ($payment->payment_from == 'pre_service' || $payment->payment_from == 'post_service') { ?>
                                    <th>#</th>
                                    <th><?php echo lang('service'); ?> <?php echo lang('name'); ?></th>
                                    <th><?php echo lang('unit'); ?> <?php echo lang('price') ?></th>
                                    <th><?php echo lang('quantity'); ?></th>
                                    <th><?php echo lang('amount'); ?></th>
                                    <th><?php echo lang('discount'); ?></th>
                                    <th><?php echo lang('grand_total'); ?></th>
                                <?php } else { ?>
                                    <th>#</th>
                                    <th><?php echo lang('description'); ?></th>
                                    <th><?php echo lang('unit_price'); ?></th>
                                    <th><?php echo lang('qty'); ?></th>
                                    <th><?php echo lang('amount'); ?></th> 
                                <?php } ?>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if ($payment->payment_from == 'appointment') {
                                if (!empty($payment->category_name)) {
                                    $appointment_details = $this->db->get_where('appointment', array('id' => $payment->appointment_id))->row();
                                    ?>
                                    <tr>
                                        <td><?php echo '1'; ?> </td>
                                        <td><?php echo $payment->category_name; ?> </td>
                                        <td class=""><?php echo date('d-m-Y', $appointment_details->date); ?> <br ><?php echo $appointment_details->time_slot; ?> </td>
                                        <td class=""> <?php echo $appointment_details->doctorname; ?> </td>
                                        <td class=""><?php echo $settings->currency; ?> <?php echo $payment->gross_total; ?> </td>
                                    </tr> 
                                    <?php
                                }
                            } elseif ($payment->payment_from == 'case' || $payment->payment_from == 'surgery' || $payment->payment_from == 'pre_surgery_medical_analysis' || $payment->payment_from == 'post_surgery_medical_analysis') {
                                if (!empty($payment->category_name)) {
                                    if ($payment->payment_from == 'case') {
                                        $case_setails = $this->db->get_where('medical_history', array('id' => $payment->case_id))->row();
                                    } elseif ($payment->payment_from == 'pre_surgery_medical_analysis') {
                                        $case_setails = $this->db->get_where('pre_surgery_medical_analysis', array('id' => $payment->pre_medical_surgery_id))->row();
                                    } elseif ($payment->payment_from == 'post_surgery_medical_analysis') {
                                        $case_setails = $this->db->get_where('post_surgery_medical_analysis', array('id' => $payment->post_medical_surgery_id))->row();
                                    } else {
                                        $case_setails = $this->db->get_where('surgery', array('id' => $payment->surgery_id))->row();
                                    }
                                    $category = explode('##', $payment->category_name);
                                    $i = 0;
                                    foreach ($category as $cat) {
                                        $i = $i + 1;
                                        $cat_new = array();
                                        $cat_new = explode("**", $cat);
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?> </td>
                                            <td><?php echo $cat_new[1]; ?> </td>
                                            <?php if ($cat_new[0] == 'MedicalAnalysis_pre_surgery' || $cat_new[0] == 'MedicalAnalysis_post_surgery') { ?>
                                                <td><?php echo lang('medical_analysis'); ?></td>
                                            <?php } elseif ($cat_new[0] == 'Package_pre_surgery_medical' || $cat_new[0] == 'Package_post_surgery_medical') { ?>
                                                <td><?php echo lang('package'); ?></td>
                                            <?php } else { ?>
                                                <td class=""><?php echo $cat_new[0]; ?> </td>
                                            <?php } ?>
                                            <td class=""> <?php echo $cat_new[4]; ?> </td>
                                            <td class=""><?php echo $settings->currency; ?> <?php echo $cat_new[3]; ?> </td>
                                            <?php if ($payment->payment_from == 'case' ||$payment->payment_from == 'pre_surgery_medical_analysis' || $payment->payment_from == 'post_surgery_medical_analysis') { ?>
                                                <td class=""><?php echo $settings->currency; ?> <?php echo $cat_new[6]; ?> </td>
                                                <td class=""><?php echo $settings->currency; ?> <?php echo $cat_new[3] - $cat_new[6]; ?> </td>
                                            <?php }
                                            ?>
                                        </tr> 
                                        <?php
                                    }
                                }
                            } elseif ($payment->payment_from == 'bed') {
                                if (!empty($payment->category_name)) {

                                    $category = explode('#', $payment->category_name);

                                    $i = 0;
                                    foreach ($category as $cat) {
                                        $i = $i + 1;
                                        $cat_new = array();
                                        $cat_new = explode('*', $cat);
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?> </td>
                                            <td><?php echo $cat_new[1]; ?> </td>
                                            <td class=""><?php echo $settings->currency; ?> <?php echo $cat_new[2]; ?> </td>
                                            <td class=""> <?php echo $cat_new[3]; ?> </td>
                                            <td class=""><?php echo $settings->currency; ?> <?php echo $cat_new[4]; ?> </td>
                                        </tr> 
                                        <?php
                                    }
                                }
                            } elseif ($payment->payment_from == 'bed_service') {
                                if (!empty($payment->category_name)) {
                                    // $case_setails = $this->db->get_where('medical_history', array('id' => $payment->case_id))->row();
                                    $category = explode('#', $payment->category_name);
                                    //  print_r($category);
                                    //die();
                                    $i = 0;
                                    foreach ($category as $cat) {
                                        $i = $i + 1;
                                        $cat_new = array();
                                        $cat_new = explode('*', $cat);
                                        $service = $this->db->get_where('pservice', array('id' => $cat_new[0]))->row();
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?> </td>
                                            <td>  <?php echo $service->name; ?> </td>
                                            <td class=""><?php echo $settings->currency; ?> <?php echo $cat_new[1]; ?> </td>
                                            <td class=""> <?php echo '1'; ?> </td>
                                            <td class=""><?php echo $settings->currency; ?> <?php echo $cat_new[1]; ?> </td>
                                        </tr> 
                                        <?php
                                    }
                                }
                            } elseif ($payment->payment_from == 'pre_service' || $payment->payment_from == 'post_service') {
                                if (!empty($payment->category_name)) {
                                    // $case_setails = $this->db->get_where('medical_history', array('id' => $payment->case_id))->row();
                                    $category = explode('#', $payment->category_name);
                                    //  print_r($category);
                                    //die();
                                    $i = 0;
                                    foreach ($category as $cat) {
                                        $i = $i + 1;
                                        $cat_new = array();
                                        $cat_new = explode('*', $cat);
                                        $service = $this->db->get_where('pservice', array('id' => $cat_new[0]))->row();
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?> </td>
                                            <td>  <?php echo $service->name; ?> </td>
                                            <td class=""><?php echo $settings->currency; ?> <?php echo $cat_new[1]; ?> </td>
                                            <td class=""> <?php echo '1'; ?> </td>
                                            <td class=""><?php echo $settings->currency; ?> <?php echo $cat_new[1]; ?> </td>
                                            <td class=""><?php echo $settings->currency; ?> <?php echo $cat_new[2]; ?> </td>
                                            <td class=""><?php echo $settings->currency; ?> <?php echo $cat_new[1] - $cat_new[2]; ?> </td>
                                        </tr> 
                                        <?php
                                    }
                                }
                            } else {
                                if (!empty($payment->category_name)) {
                                    $category_name = $payment->category_name;
                                    $category_name1 = explode(',', $category_name);
                                    $i = 0;
                                    foreach ($category_name1 as $category_name2) {
                                        $i = $i + 1;
                                        $category_name3 = explode('*', $category_name2);
                                        if ($category_name3[3] > 0) {
                                            ?>  

                                            <tr>
                                                <td><?php echo $i; ?> </td>
                                                <td><?php echo $this->finance_model->getPaymentcategoryById($category_name3[0])->category; ?> </td>
                                                <td class=""><?php echo $settings->currency; ?> <?php echo $category_name3[1]; ?> </td>
                                                <td class=""> <?php echo $category_name3[3]; ?> </td>
                                                <td class=""><?php echo $settings->currency; ?> <?php echo $category_name3[1] * $category_name3[3]; ?> </td>
                                            </tr> 
                                            <?php
                                        }
                                    }
                                }
                            }
                            ?>

                        </tbody>
                    </table>

                    <div class="col-md-12 hr_border">
                        <hr>
                    </div>

                    <div class="">
                        <div class="col-lg-4 invoice-block pull-left">
                            <?php
                            if (!empty($payment->payment_from)) {
                                if ($payment->payment_from == 'appointment') {
                                    ?> 
                                    <h6><?php echo lang('remarks'); ?>: <?php echo $appointment_details->remarks; ?></h6>
                                <?php } elseif ($payment->payment_from == 'case') { ?>
                                    <h6><?php echo lang('remarks'); ?>: <?php echo $case_setails->remarks; ?></h6>
                                <?php } elseif ($payment->payment_from == 'bed') { ?>
                                    <h6><?php echo lang('remarks'); ?>: <?php echo $payment->remarks; ?></h6>
                                <?php } elseif ($payment->payment_from == 'bed_service') { ?>
                                    <h6><?php echo lang('remarks'); ?>: <?php echo $payment->remarks; ?></h6>
                                <?php } else { ?>
                                    <h6><?php echo lang('notes'); ?>: <?php echo $payment->notes; ?></h6>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <div class="">
                        <div class="col-lg-4 invoice-block pull-right">
                            <ul class="unstyled amounts">
                                <li><strong><?php echo lang('sub_total'); ?> : </strong><?php echo $settings->currency; ?> <?php echo $payment->amount; ?></li>
                                <?php if (!empty($payment->discount)) { ?>
                                    <li><strong><?php echo lang('discount'); ?></strong> <?php
                                        if ($discount_type == 'percentage') {
                                            echo '(%) : ';
                                        } else {
                                            echo ': ' . $settings->currency;
                                        }
                                        ?> <?php
                                        $discount = explode('*', $payment->discount);
                                        if (!empty($discount[1])) {
                                            echo $discount[0] . ' %  =  ' . $settings->currency . ' ' . $discount[1];
                                        } else {
                                            echo $discount[0];
                                        }
                                        ?></li>
                                    <?php } ?>
                                    <?php if (!empty($payment->vat)) { ?>
                                    <li><strong>VAT :</strong>   <?php
                                        if (!empty($payment->vat)) {
                                            echo $payment->vat;
                                        } else {
                                            echo '0';
                                        }
                                        ?> % = <?php echo $settings->currency . ' ' . $payment->flat_vat; ?></li>
                                <?php } ?>
                                <li><strong><?php echo lang('grand_total'); ?> : </strong><?php echo $settings->currency; ?> <?php echo $g = $payment->gross_total; ?></li>
                                <li><strong><?php echo lang('amount_received'); ?> : </strong><?php echo $settings->currency; ?> <?php echo $r = $this->finance_model->getDepositAmountByPaymentId($payment->id); ?></li>
                                <li><strong><?php echo lang('amount_to_be_paid'); ?> : </strong><?php echo $settings->currency; ?> <?php echo $g - $r; ?></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-12 hr_border">
                        <hr>
                    </div>



                    <div class="col-md-12 invoice_footer">
                        <div class="col-md-4 row pull-left" style="">

                            <?php echo lang('user'); ?> : <?php echo $this->ion_auth->user($payment->user)->row()->username; ?>

                            <div class="col-md-4 row pull-right" style="">



                            </div>
                        </div>

                    </div>


                </div>




        </section>


        <section class="col-md-5">




            <div class="col-md-5 no-print" style="margin-top: 20px;">

                <div class="text-center invoice-btn col-md-12 row">
                    <a class="btn btn-info btn-lg invoice_button pull-left" onclick="javascript:window.print();"><i class="fa fa-print"></i> Print </a>
                    <?php
                    if ($this->ion_auth->in_group(array('admin', 'Accountant'))) {
                        if ($payment->payment_from == 'appointment') {
                            ?>
                            <a href="appointment/editAppointment?id=<?php echo $payment->appointment_id; ?>" class="btn btn-info btn-sm editbutton pull-left"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?> <?php echo lang('appointment'); ?> </a>       

                        <?php } else { ?>
                            <a href="finance/editPayment?id=<?php echo $payment->id; ?>" class="btn btn-info btn-sm editbutton pull-left"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?> <?php echo lang('invoice'); ?> </a>
                            <?php
                        }
                    }
                    ?>

                </div>

                <!--
                <form role="form" action="finance/amountReceived" method="post" enctype="multipart/form-data">
                    <div class="form-group"> 
                        <label for="exampleInputEmail1"></label>
                        Due Amount: <?php echo $settings->currency; ?>  <?php echo $payment->gross_total - $payment->amount_received; ?> 
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Add Deposit</label>
                        <input type="text" class="form-control" name="amount_received" id="exampleInputEmail1" value='<?php
                if (!empty($category->description)) {
                    echo $category->description;
                }
                ?>' placeholder="<?php echo $settings->currency; ?> ">
                    </div>
                    <input type="hidden" name="id" value="<?php echo $payment->id; ?>">

                    <button type="submit" name="submit" class="btn btn-info">Submit</button>
                </form>
                -->


            </div>

        </section>


        <style>

            th{
                text-align: center;
            }

            td{
                text-align: center;
            }

            tr.total{
                color: green;
            }



            .control-label{
                width: 100px;
            }



            h1{
                margin-top: 5px;
            }


            .print_width{
                width: 50%;
                float: left;
            } 

            ul.amounts li {
                padding: 0px !important;
            }

            .invoice-list {
                margin-bottom: 10px;
            }




            .panel{
                border: 0px solid #5c5c47;
                background: #fff !important;
                height: 100%;
                margin: 20px 5px 5px 5px;
                border-radius: 0px !important;
                min-height: 700px;

            }



            .table.main{
                margin-top: -50px;
            }



            .control-label{
                margin-bottom: 0px;
            }

            tr.total td{
                color: green !important;
            }

            .theadd th{
                background: #edfafa !important;
                background: #fff!important;
            }

            td{
                font-size: 12px;
                padding: 5px;
                font-weight: bold;
            }

            .details{
                font-weight: bold;
            }

            hr{
                border-bottom: 0px solid #f1f1f1 !important;
            }

            .corporate-id {
                margin-bottom: 5px;
            }

            .adv-table table tr td {
                padding: 5px 10px;
            }



            .btn{
                margin: 10px 10px 10px 0px;
            }

            .invoice_head_left h3{
                color: #2f80bf !important;
                font-family: cursive;
            }


            .invoice_head_right{
                margin-top: 10px;
            }

            .invoice_footer{
                margin-bottom: 10px;
            }










            @media print {

                h1{
                    margin-top: 5px;
                }

                #main-content{
                    padding-top: 0px;
                }

                .print_width{
                    width: 50%;
                    float: left;
                } 

                ul.amounts li {
                    padding: 0px !important;
                }

                .invoice-list {
                    margin-bottom: 10px;
                }

                .wrapper{
                    margin-top: 0px;
                }

                .wrapper{
                    padding: 0px 0px !important;
                    background: #fff !important;

                }



                .wrapper{
                    border: 2px solid #777;
                }

                .panel{
                    border: 0px solid #5c5c47;
                    background: #fff !important;
                    padding: 0px 0px;
                    height: 100%;
                    margin: 5px 5px 5px 5px;
                    border-radius: 0px !important;
                    min-height: 900px;

                }

                .site-min-height {
                    min-height: 1010px;
                }



                .table.main{
                    margin-top: -50px;
                }



                .control-label{
                    margin-bottom: 0px;
                }

                tr.total td{
                    color: green !important;
                }

                .theadd th{
                    background: #777 !important;
                }

                td{
                    font-size: 12px;
                    padding: 5px;
                    font-weight: bold;
                }

                .details{
                    font-weight: bold; 
                }

                hr{
                    border-bottom: 0px solid #f1f1f1 !important;
                }

                .corporate-id {
                    margin-bottom: 5px;
                }

                .adv-table table tr td {
                    padding: 5px 10px;
                }

                .invoice_head{
                    width: 100%;
                }

                .invoice_head_left{
                    float: left;
                    width: 40%;
                    color: #2f80bf;
                    font-family: cursive;
                }

                .invoice_head_right{
                    float: right;
                    width: 40%;
                    margin-top: 10px;
                }

                .hr_border{
                    width: 100%;
                }

                .invoice_footer{
                    margin-bottom: 10px;
                }


            }

        </style>







    </section>
    <!-- invoice end-->
</section>
</section>
<!--main content end-->
<!--footer start-->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
                        $(document).ready(function () {
                            $(".flashmessage").delay(3000).fadeOut(100);
                        });
</script>
