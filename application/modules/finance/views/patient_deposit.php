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
        $permis_1 = '';
        foreach ($permission_access_group_explode as $perm) {
            $perm_explode = array();
            $perm_explode = explode(",", $perm);
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Finance') {
                $permis = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Finance') {
                $permis_2 = 'ok';
                //  break;
            }
            if (in_array('1', $perm_explode) && $perm_explode[0] == 'Finance') {
                $permis_1 = 'ok';
                //  break;
            }
             if (in_array('2', $perm_explode) && $perm_explode[0] == 'Patient') {
                $permis_4 = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Patient') {
                $permis_5 = 'ok';
                //  break;
            }
            if (in_array('1', $perm_explode) && $perm_explode[0] == 'Patient') {
                $permis_6 = 'ok';
                //  break;
            }
        }
        ?>
        <section class="no-print col-md-8">
            <header class="panel-heading">
                <?php echo lang('payment_history'); ?>


                <?php if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist')) || $permis_4 == 'ok') { ?>
                    <div class="panel-body no-print pull-right">
                        <a data-toggle="modal" href="#myModal">
                            <div class="btn-group">
                                <button id="" class="btn btn-xs green">
                                    <i class="fa fa-plus-circle"></i> <?php echo lang('deposit'); ?>
                                </button>
                            </div>
                        </a>   
                    </div>
                <?php } ?>
                <div class="panel-body no-print pull-right">
                    <a data-toggle="modal" href="#myModal5">
                        <div class="btn-group">
                            <button id="" class="btn btn-xs green">
                                <i class="fa fa-file"></i> <?php echo lang('invoice'); ?>
                            </button>
                        </div>
                    </a>   
                </div>
                <?php if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist')) || $permis == 'ok') { ?>
                    <div class="panel-body no-print pull-right">
                        <a href="finance/addPaymentByPatientView?id=<?php echo $patient->id; ?>&type=gen">
                            <div class="btn-group">
                                <button id="" class="btn btn-xs green">
                                    <i class="fa fa-plus-circle"></i> <?php echo lang('add_payment'); ?>
                                </button>
                            </div>
                        </a>     
                    </div>
                <?php } ?>
            </header>
            <div class=" panel-body">
                <div class="adv-table editable-table ">


                    <section class="col-md-12 no-print row">
                        <form role="form" class="f_report" action="finance/patientPaymentHistory" method="post" enctype="multipart/form-data">
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
                                            } elseif ($payment->payment_from == 'pre_service') {
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
                                            <?php
                                            if ($this->ion_auth->in_group(array('admin', 'Accountant')) || $permis == 'ok') {
                                                if ($payment->payment_from == 'payment') {
                                                    ?>

                                                    <a class="btn-xs btn-info" title="<?php echo lang('edit'); ?>" style="width: 25%;" href="finance/editPayment?id=<?php echo $payment->id; ?>"><i class="fa fa-edit"> </i></a>
                                                <?php } elseif ($payment->payment_from == 'case') {
                                                    ?>

                                                    <a class="btn-xs btn-info" title="<?php echo lang('edit'); ?>" style="width: 25%;" href="patient/editCaseHistory?id=<?php echo $payment->case_id; ?>"><i class="fa fa-edit"> </i></a>
                                                <?php } elseif ($payment->payment_from == 'appointment') { ?> 
                                                    <a class="btn-xs btn-info" title="<?php echo lang('edit'); ?>" style="width: 25%;" href="appointment/editAppointment?id=<?php echo $payment->appointment_id; ?>"><i class="fa fa-edit"> </i></a>
                                                <?php } elseif ($payment->payment_from == 'surgery') {
                                                    ?>
                                                    <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                                                        <a class="btn-xs btn-info" title="<?php echo lang('edit'); ?>" style="width: 25%;" href="surgery/editSurgery?id=<?php echo $payment->surgery_id; ?>"><i class="fa fa-edit"> </i></a>                                                   
                                                    <?php }
                                                } elseif ($payment->payment_from == 'post_surgery_medical_analysis' || $payment->payment_from == 'pre_surgery_medical_analysis' || $payment->payment_from == 'pre_service' || $payment->payment_from == 'post_service') { ?> 
                                                    <?php if ($this->ion_auth->in_group(array('Accountant')) || $permis == 'ok') { ?>
                                                        <a class="btn-xs btn-info" title="<?php echo lang('edit'); ?>" style="width: 25%;" href="finance/editInvoice?id=<?php echo $payment->id; ?>"><i class="fa fa-edit"> </i></a>
                                                        <?php
                                                    } else {
                                                        if ($payment->payment_from == 'post_surgery_medical_analysis') {
                                                            $surgery_id = $this->db->get_where('post_surgery_medical_analysis', array('payment_id' => $payment->id))->row()->surgery_id;
                                                        } if ($payment->payment_from == 'pre_surgery_medical_analysis') {
                                                            $surgery_id = $this->db->get_where('pre_surgery_medical_analysis', array('payment_id' => $payment->id))->row()->surgery_id;
                                                        }if ($payment->payment_from == 'pre_service') {
                                                            $surgery_id = $this->db->get_where('pre_service', array('date' => $payment->date_string))->row()->surgery_id;
                                                        } if ($payment->payment_from == 'post_service') {
                                                            $surgery_id = $this->db->get_where('post_service', array('date' => $payment->date_string))->row()->surgery_id;
                                                        }
                                                        ?>
                                                        <a class="btn-xs btn-info" title="<?php echo lang('edit'); ?>" style="width: 25%;" href="surgery/surgeryDetails?id=<?php echo $surgery_id; ?>"><i class="fa fa-edit"> </i></a>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                            <?php if ($payment->payment_from == 'payment') { ?>
                                                <a class="btn-xs invoicebutton" title="<?php echo lang('invoice'); ?>" style="color: #fff; width: 25%;" href="finance/invoice?id=<?php echo $payment->id; ?>"><i class="fa fa-file-invoice"></i> </a>
                                            <?php } elseif ($payment->payment_from == 'bed_service') { ?>
                                                <a class="btn-xs invoicebutton" title="<?php echo lang('invoice'); ?>" style="color: #fff; width: 25%;" href="finance/invoice?id=<?php echo $payment->id; ?>"><i class="fa fa-file-invoice"></i> </a>  
                                            <?php } elseif ($payment->payment_from == 'bed') { ?>
                                                <a class="btn-xs invoicebutton" title="<?php echo lang('invoice'); ?>" style="color: #fff; width: 25%;" href="finance/invoice?id=<?php echo $payment->id; ?>"><i class="fa fa-file-invoice"></i> </a>
                                                <?php
                                            } elseif ($payment->payment_from == 'case') {
                                                $caselist = $this->db->get_where('medical_history', array('id' => $payment->case_id))->row();
                                                ?>

                                                <a class="btn-xs invoicebutton" title="<?php echo lang('invoice'); ?>" style="color: #fff; width: 25%;" href="finance/invoice?id=<?php echo $payment->id; ?>"><i class="fa fa-file-invoice"></i> </a>
                                                <?php
                                                // }
                                            } elseif ($payment->payment_from == 'appointment') {
                                                $appointment = $this->db->get_where('appointment', array('payment_id' => $payment->id))->row();
                                                // if ($appointment->status == 'Confirmed') {
                                                ?>  
                                                <a class="btn-xs invoicebutton" title="<?php echo lang('invoice'); ?>" style="color: #fff; width: 25%;" href="finance/invoice?id=<?php echo $payment->id; ?>"><i class="fa fa-file-invoice"></i> </a>
                                                <?php
                                                // }
                                            } else {
                                                ?>
                                                <a class="btn-xs invoicebutton" title="<?php echo lang('invoice'); ?>" style="color: #fff; width: 25%;" href="finance/invoice?id=<?php echo $payment->id; ?>"><i class="fa fa-file-invoice"></i> </a>
                                            <?php }
                                            ?>
                                            <?php if ($this->ion_auth->in_group(array('admin', 'Accountant')) || $permis_2 == 'ok') { ?> 
                                                <?php if ($payment->payment_from == 'payment') { ?>
                                                    <a class="btn-xs btn-info delete_button" title="<?php echo lang('delete'); ?>" style="width: 25%;"  href="finance/delete?id=<?php echo $payment->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>
                                                <?php } ?> 
            <?php } ?>
                                            </button>
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

                                                <?php if ($this->ion_auth->in_group(array('admin', 'Accountant')) || $permis == 'ok') { ?>
                                                    <button type="button" class="btn btn-info btn-xs btn-width editbutton" title="<?php echo lang('edit'); ?>" style="width: 25%;" data-toggle="modal" data-id="<?php echo $deposit->id; ?>"><i class="fa fa-edit"></i> </button> 
                                                <?php } ?>
                                                <?php if ($this->ion_auth->in_group(array('admin', 'Accountant')) || $permis_2 == 'ok') { ?> 
                                                    <a class="btn-xs btn-info delete_button" title="<?php echo lang('delete'); ?>" style="width: 25%;" href="finance/deleteDeposit?id=<?php echo $deposit->id; ?>&patient=<?php echo $patient->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i></a>
                <?php } ?>
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



<script>
    $(document).ready(function () {
        $('#editable-samplee').DataTable();
    });
</script>






<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('add_deposit'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="finance/deposit" id="deposit-form" class="clearfix" method="post" enctype="multipart/form-data">
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
                        <label for="exampleInputEmail1"><?php echo lang('remarks'); ?></label>
                        <input type="text" class="form-control" name="remarks" id="exampleInputEmail1" value='' placeholder="">
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
<?php if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist'))  || $permis_4 == 'ok' ) { ?>
                                    <option value="Cash"> <?php echo lang('cash'); ?> </option>
                                    <option value="Card"> <?php echo lang('card'); ?> </option>
<?php } ?>

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
                                    <input type="text" class="form-control pay_in" id="card" name="card_number" value='' placeholder="">
                                </div>



                                <div class="col-md-8 payment pad_bot">
                                    <label for="exampleInputEmail1"> <?php echo lang('expire'); ?> <?php echo lang('date'); ?></label>
                                    <input type="text" class="form-control pay_in" id="expire" data-date="" data-date-format="MM YY" placeholder="Expiry (MM/YY)" name="expire_date" maxlength="7" aria-describedby="basic-addon1" value='' placeholder="">
                                </div>
                                <div class="col-md-4 payment pad_bot">
                                    <label for="exampleInputEmail1"> <?php echo lang('cvv'); ?> </label>
                                    <input type="text" class="form-control pay_in" id="cvv" maxlength="3" name="cvv" value='' placeholder="">
                                </div> 

                            </div>

                            <?php
                        }
                        ?>

                    </div> 



                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="patient" value='<?php echo $patient->id; ?>'>
                    <div class="form-group cashsubmit payment  right-six col-md-12">
                        <button type="submit" name="submit2" id="submit1" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                    <div class="form-group cardsubmit  right-six col-md-12 hidden">
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
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('edit_deposit'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editDepositform" action="finance/deposit" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class=payment_label"> 
                        <label for="exampleInputEmail1"><?php echo lang('invoice'); ?></label> 
                        <select class="form-control m-bot15 js-example-basic-single" id="" name="payment_id" value=''> 
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
                        <label for="exampleInputEmail1"><?php echo lang('remarks'); ?></label>
                        <input type="text" class="form-control" name="remarks" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="form-group">
                        <div class=""> 
                            <label for="exampleInputEmail1"><?php echo lang('deposit_type'); ?></label>
                        </div>
                        <div class=""> 
                            <select class="form-control m-bot15 js-example-basic-single selecttype1" id="selecttype1" name="deposit_type" value=''> 
<?php if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist'))) { ?>
                                    <option value="Cash"> <?php echo lang('cash'); ?> </option>
                                    <option value="Card"> <?php echo lang('card'); ?> </option>
<?php } ?>

                            </select>
                        </div>

                        <?php
                        $payment_gateway = $settings->payment_gateway;
                        ?>



                        <div class = "card1">

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
                                    <input type="text" class="form-control pay_in" id="card1" name="card_number" value='<?php
                                    if (!empty($payment->p_email)) {
                                        echo $payment->p_email;
                                    }
                                    ?>' placeholder="">
                                </div>



                                <div class="col-md-8 payment pad_bot">
                                    <label for="exampleInputEmail1"> <?php echo lang('expire'); ?> <?php echo lang('date'); ?></label>
                                    <input type="text" class="form-control pay_in" data-date="" id="expire1" data-date-format="MM YY" placeholder="Expiry (MM/YY)" name="expire_date" maxlength="7" aria-describedby="basic-addon1" value='<?php
                                    if (!empty($payment->p_phone)) {
                                        echo $payment->p_phone;
                                    }
                                    ?>' placeholder="">
                                </div>
                                <div class="col-md-4 payment pad_bot">
                                    <label for="exampleInputEmail1"> <?php echo lang('cvv'); ?> </label>
                                    <input type="text" class="form-control pay_in" id="cvv1" maxlength="3" name="cvv_number" value='<?php
                                    if (!empty($payment->p_age)) {
                                        echo $payment->p_age;
                                    }
                                    ?>' placeholder="">
                                </div> 

                            </div>

                            <?php
                        }
                        ?>

                    </div> 



                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="patient" value='<?php echo $patient->id; ?>'>
                    <div class="form-group cashsubmit1 payment  right-six col-md-12">
                        <button type="submit" name="submit2" id="submit1" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                    <div class="form-group cardsubmit1  right-six col-md-12 hidden">
                        <button type="submit" name="pay_now" id="submit-btn1" class="btn btn-info row pull-right" <?php if ($settings->payment_gateway == 'Stripe') {
                            ?>onClick="stripePay1(event);"<?php }
                        ?>> <?php echo lang('submit'); ?></button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
</div>
<!-- Add Patient Modal-->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i> <?php echo lang('choose_payment_type'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="clearfix">
                    <div class="col-lg-12 clearfix">
                        <a href="finance/addPaymentByPatientView?id=<?php echo $patient->id; ?>&type=gen">
                            <div class="col-lg-6">
                                <div class="flat-carousal" style="background: #39B27C;">
                                    <div id="owl-demo" class="owl-carousel owl-theme" style="opacity: 1; display: block;">
<?php echo lang('add_general_payment'); ?> <i style="float: right; font-size: 18px;"class="fa fa-arrow-circle-o-right"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="finance/addPaymentByPatientView?id=<?php echo $patient->id; ?>&type=ot">
                            <div class="col-lg-6">
                                <div class="flat-carousal" style="background: #39B27C;">
                                    <div id="owl-demo" class="owl-carousel owl-theme" style="opacity: 1; display: block;">
<?php echo lang('add_ot_payment'); ?> <i style="float: right; font-size: 18px;"class="fa fa-arrow-circle-o-right"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="col-lg-3"></div>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
</div>










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
                    <div class="panel"  id="invoice" style="font-size: 10px;">
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
                    </div>


                    <div class="panel col-md-12 no-print">
                        <a class="btn btn-info invoice_button" onclick="javascript:window.print();"><i class="fa fa-print"></i> <?php echo lang('print'); ?> </a>
                    </div>

                    <div class="text-center invoice-btn clearfix">
                        <a class="btn btn-info btn-sm detailsbutton pull-left download" id="download"><i class="fa fa-download"></i> <?php echo lang('download'); ?> </a>
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
                                            $('#editDepositform').find('[name="payment_id"]').val(response.deposit.payment_id).trigger('change');
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
        $(document.body).on('change', '#selecttype', function () {

            var v = $("#selecttype option:selected").val()
            if (v == 'payu') {
                $("#deposit-form").attr("action", 'payu/check');
            } else {
                $("#deposit-form").attr("action", 'finance/deposit');
            }
        });

    });


    $(document).ready(function () {
        var v = $("#selecttype1 option:selected").val()
        if (v == 'payu') {
            $("#editDepositform").attr("action", 'payu/check');
        } else {
            $("#editDepositform").attr("action", 'finance/deposit');
        }
    });


</script>


<script>
    $(document).ready(function () {
        $('.card').hide();
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
    $(document).ready(function () {
        $('.card1').hide();
        $(document.body).on('change', '#selecttype1', function () {

            var v = $("select.selecttype option:selected").val()
            if (v == 'Card') {
                $('.card1').show();
                $('.cardsubmit1').removeClass('hidden');
                $('.cashsubmit1').addClass('hidden');
            } else {
                $('.card').hide();
                $('.cashsubmit1').removeClass('hidden');
                $('.cardsubmit1').addClass('hidden');
            }
        });

    });


</script>


<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>
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
            $("#editDepositform").append("<input type='hidden' name='token' value='" + token + "' />");
            console.log(token);
            //submit form to the server
            $("#editDepositform").submit();
        }
    }

    function stripePay1(e) {
        e.preventDefault();
        var valid = cardValidation1();

        if (valid == true) {
            $("#submit-btn").attr("disabled", true);
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
<script>


    $('#download').click(function () {
        var pdf = new jsPDF('p', 'pt', 'letter');
        pdf.addHTML($('#invoice'), function () {
            pdf.save('invoice.pdf');
        });
    });

    // This code is collected but useful, click below to jsfiddle link.
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
