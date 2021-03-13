<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- invoice start-->
        <section>
            <div class="panel panel-primary">
                <!--<div class="panel-heading navyblue"> INVOICE</div>-->
                <div  class="panel-body col-md-5 panel-moree" id="invoice" style="font-size: 10px;">
                    <div class="row invoice-list">

                        <div class="text-center corporate-id">
                            <h1>
                                <?php echo $settings->title ?>
                            </h1>
                            <h4>
                                <?php echo $settings->address ?>
                            </h4>
                            <h4>
                                Tel: <?php echo $settings->phone ?>
                            </h4>
                        </div>

                        
                        <div class="col-lg-4 col-sm-4 details">
                            <h4> <?php echo lang('payment_to'); ?> :</h4>
                            <p>
                                <?php echo $settings->title; ?> <br>
                                <?php echo $settings->address; ?><br>
                                Tel:  <?php echo $settings->phone; ?>
                            </p>
                        </div>
                        
                        
                        <?php if (!empty($payment->patient)) { ?>
                            <div class="col-lg-4 col-sm-4 details">
                                <h4> <?php echo lang('bill_to'); ?> :</h4>
                                <p>
                                    <?php
                                    $patient_info = $this->db->get_where('patient', array('id' => $payment->patient))->row();
                                    echo $patient_info->name . ' <br>';
                                    echo $patient_info->address . '  <br/>';
                                    P: echo $patient_info->phone
                                    ?>
                                </p>
                            </div>
                        <?php } ?>
                        <div class="col-lg-4 col-sm-4 details pull-right">
                            <h4> <?php echo lang('invoice_info'); ?> </h4>
                            <ul class="unstyled">
                                <li> <?php echo lang('invoice_number'); ?> 		: <strong>00<?php echo $payment->id; ?></strong></li>
                                <!--
                                <li> <?php echo lang('status'); ?> 		:
                                <?php
                                if ($payment->gross_total <= $payment->amount_received) {
                                    echo '<strong>' . lang('paid') . '</strong>';
                                } else {
                                    if ($payment->amount_received == 0) {
                                        echo '<strong>' . lang('unpaid') . '</strong>';
                                    } else {
                                        echo '<strong>' . lang('paid_partially') . '</strong>';
                                    }
                                }
                                ?> 
                                </li>
                                -->
                            </ul>
                        </div>

                        <div class="col-lg-4 col-sm-4 details">
                            <h4> <?php echo lang('date'); ?> </h4>
                            <ul class="unstyled"> 
                                <li><?php echo date('m/d/Y', $payment->date); ?></li>    
                            </ul>
                        </div>
                    </div>

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th> <?php echo lang('name'); ?> </th>
                                <th> <?php echo lang('company'); ?> </th>
                                <th> <?php echo lang('unit_price'); ?></th>
                                <th> <?php echo lang('quantity'); ?> </th>
                                <th> <?php echo lang('total_per_item'); ?></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($payment->x_ray)) { ?>
                                <tr>
                                    <td><?php echo $i = 1 ?></td>
                                    <td>X Ray</td>
                                    <td class=""><?php echo $settings->currency; ?> <?php echo $payment->x_ray; ?> </td>
                                </tr>
                            <?php } ?>
                            <?php
                            if (!empty($payment->category_name)) {
                                $category_name = $payment->category_name;
                                $category_name1 = explode(',', $category_name);
                                if (empty($payment->x_ray)) {
                                    $i = 0;
                                }
                                foreach ($category_name1 as $category_name2) {
                                    $category_name3 = explode('*', $category_name2);
                                    if ($category_name3[1] > 0) {
                                        ?>                
                                        <tr>
                                            <td><?php echo $i = $i + 1; ?></td>
                                            <td><?php
                                                $current_medicine = $this->db->get_where('medicine', array('id' => $category_name3[0]))->row();
                                                echo $current_medicine->name;
                                                ?>
                                            </td>
                                            <td class=""> <?php echo $current_medicine->company; ?> </td>
                                            <td class=""><?php echo $settings->currency; ?> <?php echo $category_name3[1]; ?> </td>
                                            <td class=""> <?php echo $category_name3[2]; ?> </td>
                                            <td class=""><?php echo $settings->currency; ?> <?php echo $category_name3[1] * $category_name3[2]; ?> </td>
                                        </tr> 
                                        <?php
                                    }
                                }
                            }
                            ?>

                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-lg-6 invoice-block pull-right">
                            <ul class="unstyled amounts">
                                <li><strong> <?php echo lang('sub_total'); ?>   <?php echo lang('amount'); ?>  : </strong><?php echo $settings->currency; ?> <?php echo $payment->amount; ?></li>
                                <?php if (!empty($payment->discount)) { ?>
                                    <li><strong>Discount</strong> <?php
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
                                    <li><strong> <?php echo lang('vat'); ?>  :</strong>   <?php
                                        if (!empty($payment->vat)) {
                                            echo $payment->vat;
                                        } else {
                                            echo '0';
                                        }
                                        ?> % = <?php echo $settings->currency . ' ' . $payment->flat_vat; ?></li>
                                <?php } ?>
                                <li><strong> <?php echo lang('grand_total'); ?>  : </strong><?php echo $settings->currency; ?> <?php echo $payment->gross_total; ?></li>
                                <!--
                                <li><strong> <?php echo lang('amount_received'); ?>  : </strong><?php echo $settings->currency; ?> <?php echo $payment->amount_received; ?></li>
                                <li><strong> <?php echo lang('amount_to_be_paid'); ?>  : </strong><?php echo $settings->currency; ?> <?php echo $payment->gross_total - $payment->amount_received; ?></li>
                                -->
                            </ul>
                        </div>
                    </div>





                </div>

                <div class="col-md-5 panel-moree" style="font-size: 10px;">

                    <div class="text-center invoice-btn clearfix">
                        <a class="btn btn-info btn-lg editbutton pull-left" onclick="javascript:window.print();"><i class="fa fa-print"></i> <?php echo lang('print'); ?> </a>
                    </div>

                    <div class="text-center invoice-btn clearfix">
                        <a class="btn btn-info btn-sm detailsbutton pull-left download" id="download"><i class="fa fa-download"></i> <?php echo lang('download'); ?> </a>
                    </div>

                    <div class="text-center invoice-btn clearfix">
                        <?php if ($this->ion_auth->in_group(array('admin', 'Accountant'))) { ?>
                            <a href="finance/pharmacy/editPayment?id=<?php echo $payment->id; ?>" class="btn btn-info btn-lg green pull-left"><i class="fa fa-edit"></i> <?php echo lang('edit_invoice'); ?> </a>
                        <?php } ?>
                    </div>
                  <div class="text-center invoice-btn no-print pull-left ">
                        <a href="finance/pharmacy/previousInvoice?id=<?php echo $payment->id ?>"class="btn btn-info btn-lg green previousone1"><i class="glyphicon glyphicon-chevron-left"></i> </a>
                        <a href="finance/pharmacy/nextInvoice?id=<?php echo $payment->id ?>"class="btn btn-info btn-lg green nextone1 "><i class="glyphicon glyphicon-chevron-right"></i> </a>

                    </div>
                    


                </div>


                <!--
                <div class="panel-body col-md-6 add_deposit" style="font-size: 10px; float: right;">

                    <form role="form" action="finance/pharmacy/amountReceived" method="post" enctype="multipart/form-data">
                        <div class="form-group"> 
                            <label for="exampleInputEmail1"></label>
                <?php echo lang('amount_to_be_paid'); ?> : <?php echo $settings->currency; ?>  <?php echo $payment->gross_total - $payment->amount_received; ?> 
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> <?php echo lang('add_deposit'); ?> </label>
                            <input type="text" class="form-control" name="amount_received" id="exampleInputEmail1" value='<?php
                if (!empty($category->description)) {
                    echo $category->description;
                }
                ?>' placeholder="<?php echo $settings->currency; ?> ">
                        </div>
                        <input type="hidden" name="id" value="<?php echo $payment->id; ?>">

                        <button type="submit" name="submit" class="btn btn-info"><?php echo lang('submit'); ?></button>
                    </form>
                </div>
                
                
                -->
            </div>
        </section>
        <!-- invoice end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->











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
                background: transparent !important;
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






            .invoice_head_left h4{
                 font-size: 12px !important;
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
                    margin-bottom: 0px;
                }
                
                .invoice-list h4{
                    font-size: 12px !important;
                }
                


                .wrapper{
                    margin-top: 0px;
                }

                .wrapper{
                    padding: 0px 0px !important;
                    background: #fff !important;

                }
                
                img{
                    width: 100px !important;
                    
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
                    width: auto;
                }

                tr.total td{
                    color: green !important;
                }

                .theadd th{
                    background: #777 !important;
                }

                td{
                    font-size: 10px !important;
                    padding: 5px;
                    font-weight: bold;
                }

                .details{
                    font-weight: bold; 
                    font-size: 8px;
                    width: 33%;
                    float: left;
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
                    margin: -15px;
                }

                .invoice_footer{
                    margin-bottom: 10px;
                }


            }

        </style>

















<script src="common/js/codearistos.min.js"></script>
<script>
                            $(document).ready(function () {
                                $(".flashmessage").delay(3000).fadeOut(100);
                            });
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>

<script>


                            $('#download').click(function () {
                                var pdf = new jsPDF('p', 'pt', 'letter');
                                pdf.addHTML($('#invoice'), function () {
                                    pdf.save('invoice_id_<?php echo $payment->id; ?>.pdf');
                                });
                            });

                            // This code is collected but useful, click below to jsfiddle link.
</script>
