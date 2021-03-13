<!--main content start-->
<?php if ($redirect == 'download') { ?>
    <!DOCTYPE html>
    <html lang="en" <?php if ($this->db->get('settings')->row()->language == 'arabic') { ?> dir="rtl" <?php } ?>>
        <link href="common/css/bootstrap.min.css" rel="stylesheet">
        <link href="common/css/bootstrap-reset.css" rel="stylesheet">
        <!--external css-->
        <link href="common/assets/fontawesome5pro/css/all.min.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="common/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
        <style>
            @import url('https://fonts.googleapis.com/css?family=Ubuntu&display=swap');
        </style>
        <link rel="stylesheet" type="text/css" href="common/assets/DataTables/DataTables-1.10.16/custom/css/datatable-responsive-cdn-version-1-0-7.css" />

        <style>
            hr {
                margin-top: 20px;
                margin-bottom: 20px;
                height: 100px;
            }
            .title{
                border-top: 1px solid #eee;
                border-bottom: 1px solid #eee;
                padding: 20px;
                margin: 10px;
            }
            .logotitle{
                margin-bottom: 20px !important;
            }
            .invoice-box {
                max-width: 800px;
                margin: auto;
                padding: 10px;

                font-size: 16px;
                line-height: 24px;
                font-family: 'Open Sans', sans-serif;
                color: #555;
            }

            .invoice-box table {
                width: 100%;
                line-height: inherit;
                text-align: left;
            }
            .invoice-box table th{
                background: white !important;
            }
            .invoice-box table td {
                padding: 5px;
                vertical-align: top;
            }

            .invoice-box table tr td:nth-child(2) {
                text-align: right;
            }

            .invoice-box table tr.top table td {
                padding-bottom: 20px;
            }

            .invoice-box table tr.top table td.title {
                font-size: 45px;
                line-height: 45px;
                color: #333;
            }

            .invoice-box table tr.information table td {
                padding-bottom: 40px;
            }

            .invoice-box table tr.heading td {
                background: #eee;
                border-bottom: 1px solid #ddd;
                font-weight: bold;
            }

            .invoice-box table tr.details td {
                padding-bottom: 20px;
            }

            .invoice-box table tr.item td{
                border-bottom: 1px solid #eee;
            }

            .invoice-box table tr.item.last td {
                border-bottom: none;
            }

            .invoice-box table tr.total td:nth-child(2) {
                border-top: 2px solid #eee;
                font-weight: bold;
            }

            @media only screen and (max-width: 600px) {
                .invoice-box table tr.top table td {
                    width: 100%;
                    display: block;
                    text-align: left;
                }

                .invoice-box table tr.information table td {
                    width: 100%;
                    display: block;
                    text-align: left;
                }
            }

            /** RTL **/
            .rtl {
                direction: rtl;
                font-family: 'Open Sans', sans-serif;
            }

            .rtl table {
                text-align: right;
            }

            .rtl table tr td:nth-child(2) {
                text-align: left;
            }
            .printinfo{
                margin-bottom: 1000px !important;
            }

            #customers {
                font-family: 'Open Sans', sans-serif;
                border-collapse: collapse;
                width: 100%;
                margin-top: 20px;
                margin-bottom: 20px;
                border-bottom: 2px solid #eee;

            }

            #customers td, #customers th {

                padding: 8px;
                text-align: center;
            }

            #customers tr:nth-child(even){background-color: #f2f2f2;}

            #customers tr:hover {background-color: #ddd;}

            #customers th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: center;
                background-color: #eee;
                color: black;
                font-weight: bold;
            }
            #customers tbody{
                border-bottom: 2px solid black !important;
            }
            .paragraphprint{
                margin-bottom: 10px !important;
            }

        </style>
    <?php } ?>
    <?php if ($redirect != 'download') { ?>
        <section id="main-content">
            <section class="wrapper site-min-height">
            <?php } ?>
            <!-- invoice start-->
            <?php if ($redirect != 'download') { ?>
                <section class="col-md-6">
                <?php } else { ?>
                    <section class="col-md-12">
                    <?php } ?>
                    <div class="panel panel-primary" id="invoice">
                        <!--<div class="panel-heading navyblue"> INVOICE</div>-->
                        <div class="panel-body" style="font-size: 10px;">
                            <div class="row invoice-list">

                                <div class="col-md-12 invoice_head clearfix logotitle">

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
                                <?php if ($redirect != 'download') { ?>
                                    <div class="col-md-12 hr_border">
                                        <hr>
                                    </div>
                                    <div class="col-md-12 title" >
                                        <h4 class="text-center" style="font-weight: bold; margin-top: 20px; text-transform: uppercase;">
                                            <?php echo lang('payment') ?> <?php echo lang('invoice') ?>
                                        </h4>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-md-12 title" >
                                        <h4 class="text-center" style="font-weight: bold; margin-top: 15px; text-transform: uppercase;">
                                            <?php echo lang('payment') ?> <?php echo lang('invoice') ?>
                                        </h4>
                                    </div>
                                <?php } ?>

                                <?php if ($redirect != 'download') { ?>                  

                                    <div class="col-md-12 hr_border">
                                        <hr>
                                    </div>
                                <?php } ?>
                                <?php if ($redirect == 'download') { ?>  
                                    <div class="col-md-12 invoice-box">
                                        <table cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td colspan="2">
                                                    <table>
                                                        <tr>
                                                            <td> 
                                                                <div class="paragraphprint">
                                                                    <?php $patient_info = $this->db->get_where('patient', array('id' => $payment->patient))->row(); ?>
                                                                    <label class="control-label"><?php echo lang('patient'); ?> <?php echo lang('name'); ?> </label>
                                                                    <span style="text-transform: uppercase;"> : 
                                                                        <?php
                                                                        if (!empty($patient_info)) {
                                                                            echo $patient_info->name . ' <br>';
                                                                        }
                                                                        ?>
                                                                    </span>  
                                                                </div>
                                                                <div class="paragraphprint">
                                                                    <label class="control-label"><?php echo lang('patient_id'); ?>  </label>
                                                                    <span style="text-transform: uppercase;"> : 
                                                                        <?php
                                                                        if (!empty($patient_info)) {
                                                                            echo $patient_info->id . ' <br>';
                                                                        }
                                                                        ?>
                                                                    </span></div>
                                                                <div class="paragraphprint"><label class="control-label"> <?php echo lang('address'); ?> </label>
                                                                    <span style="text-transform: uppercase;"> : 
                                                                        <?php
                                                                        if (!empty($patient_info)) {
                                                                            echo $patient_info->address . ' <br>';
                                                                        }
                                                                        ?>
                                                                    </span></div>
                                                                <div class="paragraphprint">
                                                                    <label class="control-label"><?php echo lang('phone'); ?>  </label>
                                                                    <span style="text-transform: uppercase;"> : 
                                                                        <?php
                                                                        if (!empty($patient_info)) {
                                                                            echo $patient_info->phone . ' <br>';
                                                                        }
                                                                        ?>
                                                                    </span>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <div class="paragraphprint">

                                                                    <label class="control-label"><?php echo lang('invoice'); ?>  </label>
                                                                    <span style="text-transform: uppercase;"> : 
                                                                        <?php
                                                                        if (!empty($payment->id)) {
                                                                            echo $payment->id;
                                                                        }
                                                                        ?>
                                                                    </span>

                                                                </div>
                                                                <div class="paragraphprint">

                                                                    <label class="control-label"><?php echo lang('date'); ?>  </label>
                                                                    <span style="text-transform: uppercase;"> : 
                                                                        <?php
                                                                        if (!empty($payment->date)) {
                                                                            echo date('d-m-Y', $payment->date) . ' <br>';
                                                                        }
                                                                        ?>
                                                                    </span>

                                                                </div>
                                                                <div class="paragraphprint">

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
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                <?php } else { ?>
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



                                        </div>

                                    </div>






                                </div> 
                            <?php } if ($redirect != 'download') { ?>

                                <div class="col-md-12 hr_border">
                                    <hr>
                                </div>

                            <?php } ?>
                            <?php if ($redirect != 'download') { ?>
                                <table class="table table-striped table-hover detailssale">
                                <?php } else { ?>
                                    <table class="table table-striped table-hover detailssale" id="customers"> 
                                    <?php } ?>          
                                    <thead class="theadd">

                                        <tr style="border-bottom: 2px solid;">
                                            <th>#</th>
                                            <th><?php echo lang('description'); ?></th>
                                            <th><?php echo lang('unit_price'); ?></th>
                                            <th><?php echo lang('qty'); ?></th>
                                            <th><?php echo lang('amount'); ?></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        if (!empty($payment->category_name)) {
                                            $category_name = $payment->category_name;
                                            $category_name1 = explode(',', $category_name);
                                            $i = 0;
                                            // $length = count($category_name1);

                                            foreach ($category_name1 as $category_name2) {
                                                $i = $i + 1;
                                                $category_name3 = explode('*', $category_name2);
                                                //$count=count+1;
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
                                        ?>

                                    </tbody>




                                </table>
                                <?php if ($redirect == 'download') { ?>
                                    <table>
                                        <tr class="lasttr">
                                            <td style="width: 30%;"></td>
                                            <td  style="width: 20%;"></td>
                                            <td  style="width: 23%;"></td>
                                            <td style="font-size: 14px;"><li><strong><?php echo lang('sub_total'); ?> : </li></td>
                                        <td style="font-size: 14px;text-align: right;"></strong><?php echo $settings->currency; ?> <?php echo $payment->amount; ?></td> 
                                        </tr>
                                        <?php if (!empty($payment->discount)) { ?>
                                            <?php
                                            $type = "";
                                            $dis = "";
                                            if ($discount_type == 'percentage') {
                                                $type = '(%) : ';
                                            } else {
                                                $type = ': ';
                                            }
                                            ?> <?php
                                            $discount = explode('*', $payment->discount);
                                            if (!empty($discount[1])) {
                                                $dis = $discount[0] . ' %  =  ' . $settings->currency . ' ' . $discount[1];
                                            } else {
                                                $dis = $discount[0];
                                            }
                                            ?></li>
                                            <tr class="lasttr">
                                                <td style="width: 30%;"></td>
                                                <td  style="width: 20%;"></td>
                                                <td  style="width: 23%;"></td>
                                                <td style="font-size: 14px;"><li><strong><?php echo lang('discount'); ?> <?php echo $type; ?></strong></li></td>
                                            <td style="font-size: 14px;text-align: right;"></strong><?php echo $settings->currency . " " . $dis; ?></td> 
                                            </tr>
                                        <?php } ?>
                                        <?php if (!empty($payment->vat)) { ?>
                                            <?php
                                            if (!empty($payment->vat)) {
                                                $vat = $payment->vat;
                                            } else {
                                                $vat = '0';
                                            }
                                            ?> 
                                            <tr class="lasttr">
                                                <td style="width: 30%;"></td>
                                                <td  style="width: 20%;"></td>
                                                <td  style="width: 23%;"></td>
                                                <td style="font-size: 14px;"><li><strong>VAT :</strong></strong></li></td>
                                            <td style="font-size: 14px;text-align: right;"></strong><?php echo $vat; ?> % = <?php echo $settings->currency . ' ' . $payment->flat_vat; ?> </td> 
                                        <?php } ?>
                                        <tr class="lasttr">
                                            <td style="width: 30%;"></td>
                                            <td  style="width: 20%;"></td>
                                            <td  style="width: 23%;"></td>
                                            <td style="font-size: 14px;"><li><strong><?php echo lang('grand_total'); ?> : </strong></li></td>
                                        <td style="font-size: 14px;text-align: right;"></strong><?php echo $settings->currency; ?> <?php echo $g = $payment->gross_total; ?></td> 
                                        </tr>
                                        <tr class="lasttr">
                                            <td style="width: 20%;"></td>
                                            <td  style="width: 20%;"></td>
                                            <td  style="width: 20%;"></td>
                                            <td style="width: 30%; font-size: 14px;"><li><strong><?php echo lang('amount_received'); ?> : </strong></li></td>
                                        <td style="width: 10%; font-size: 14px;text-align: right;"></strong><?php echo $settings->currency; ?> <?php echo $r = $this->finance_model->getDepositAmountByPaymentId($payment->id); ?></td> 
                                        </tr>
                                        <tr class="lasttr">
                                            <td style="width: 20%;"></td>
                                            <td  style="width: 20%;"></td>
                                            <td  style="width: 20%;"></td>
                                            <td style="width: 30%; font-size: 14px;"><li><strong><?php echo lang('amount_to_be_paid'); ?> : </strong></li></td>
                                        <td style="width: 10%; font-size: 14px;text-align: right;"></strong><?php echo $settings->currency; ?> <?php echo $g - $r; ?></td> 
                                        </tr>
                                    </table>
                                <?php } ?>
                                <?php if ($redirect != 'download') { ?>
                                    <div class="col-md-12 hr_border">
                                        <hr>
                                    </div>

                                    <div class="">
                                        <div class="col-lg-4 invoice-block pull-left">
                                            <h4></h4>
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
                                <?php } ?>
                        </div>
                </section>

                <?php if ($redirect != 'download') { ?>
                    <section class="col-md-6">
                        <div class="col-md-5 no-print" style="margin-top: 20px;">
                            <a href="finance/payment" class="btn btn-info btn-sm info pull-left"><i class="fa fa-arrow-circle-left"></i>  <?php echo lang('back_to_payment_modules'); ?> </a>
                            <div class="text-center col-md-12 row">
                                <a class="btn btn-info btn-sm invoice_button pull-left" onclick="javascript:window.print();"><i class="fa fa-print"></i> <?php echo lang('print'); ?> </a>
                                <?php if ($this->ion_auth->in_group(array('admin', 'Accountant'))) { ?>
                                    <a href="finance/editPayment?id=<?php echo $payment->id; ?>" class="btn btn-info btn-sm editbutton pull-left"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?> <?php echo lang('invoice'); ?> </a>
                                    <a href="finance/download?id=<?php echo $payment->id; ?>" class="btn btn-info btn-sm detailsbutton pull-left download"><i class="fa fa-download"></i> <?php echo lang('download'); ?>  </a>
                                <?php } ?>


                            </div>

                            <div class="no-print">
                                <a href="finance/addPaymentView" class="pull-left">
                                    <div class="btn-group">
                                        <button id="" class="btn btn-info green btn-sm">
                                            <i class="fa fa-plus-circle"></i> <?php echo lang('add_another_payment'); ?>
                                        </button>
                                    </div>
                                </a>
                                <?php if ($this->ion_auth->in_group(array('admin', 'Accountant'))) { ?>
                                    <a href="finance/sendInvoice?id=<?php echo $payment->id; ?>" class="btn  btn-sm pull-left send"> <i class="fa fa-paper-plane"></i> <?php echo lang('send_invoice'); ?>  </a>
                                <?php } ?>
                            </div>

                            <div class="panel_button">

                                <div class="text-center invoice-btn no-print pull-left ">
                                    <a href="finance/previousInvoice?id=<?php echo $payment->id ?>"class="btn btn-info btn-lg green previousone1"><i class="glyphicon glyphicon-chevron-left"></i> </a>
                                    <a href="finance/nextInvoice?id=<?php echo $payment->id ?>"class="btn btn-info btn-lg green nextone1 "><i class="glyphicon glyphicon-chevron-right"></i> </a>

                                </div>

                            </div>

                        </div>

                    </section>
                <?php } ?>


                <style>

                    .send{
                        background-color: #339FCC !important;
                        color:#FFFFFF;
                    }
                    .detailssale td,.detailssale th{
                        text-align: center !important ;
                    }

                    .detailssale tr.total{
                        color: green !important;
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

                        }

                        .site-min-height {
                            min-height: 950px;
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



                <script src="common/js/codearistos.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>

      <!--  <script>


                        $('#download').click(function () {
                            var pdf = new jsPDF('p', 'pt', 'letter');
                            pdf.addHTML($('#invoice'), function () {
                                pdf.save('invoice_id_<?php echo $payment->id; ?>.pdf');
                            });
                        });

                        // This code is collected but useful, click below to jsfiddle link.
        </script>

                -->

            </section>
            <?php if ($redirect == 'download') { ?>
                </html>
            <?php } ?>
            <!-- invoice end-->
            <?php if ($redirect != 'download') { ?>
            </section>
        </section>

        <script src="common/js/codearistos.min.js"></script>
        <script src="common/js/bootstrap.min.js"></script>
        <?php
        $language = $this->db->get('settings')->row()->language;

        if ($language == 'english') {
            $lang = 'en';
        } elseif ($language == 'spanish') {
            $lang = 'es';
        } elseif ($language == 'french') {
            $lang = 'fr';
        } elseif ($language == 'portuguese') {
            $lang = 'pt';
        } elseif ($language == 'arabic') {
            $lang = 'ar';
        } elseif ($language == 'italian') {
            $lang = 'it';
        } elseif ($language == 'chinese') {
            $lang = 'zh-cn';
        } elseif ($language == 'japanese') {
            $lang = 'ja';
        } elseif ($language == 'russian') {
            $lang = 'ru';
        } elseif ($language == 'turkish') {
            $lang = 'tr';
        } elseif ($language == 'indonesian') {
            $lang = 'id';
        }
        ?>

        <script src='common/assets/fullcalendar/locale/<?php echo $lang; ?>.js'></script>



        <script src="common/assets/DataTables/DataTables-1.10.16/custom/js/datatable-responsive-cdn-version-2-2-5.js"></script>

    <?php } ?>
    <!--main content end-->
    <!--footer start-->


    <script>
                                $(document).ready(function () {
                                    $(".flashmessage").delay(3000).fadeOut(100);
                                });
    </script>
    <?php if ($redirectlink == 'print') { ?>
        <script type="text/javascript">
            <!--
        window.print();
            //-->
        </script>
    <?php } ?>