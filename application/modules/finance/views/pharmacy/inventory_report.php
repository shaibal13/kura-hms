<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">

        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php echo lang('payments'); ?>

            </header>
            <div class="col-md-12">
                <div class="col-md-12 row">
                    <section>
                        <form role="form" class="f_report" action="finance/faturime" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <!--     <label class="control-label col-md-3">Date Range</label> -->
                                <div class="col-md-3">
                                    <div class="input-group input-large" data-date="13/07/2013" data-date-format="mm/dd/yyyy">
                                        <input type="text" class="form-control dpd1" name="date_from" value="<?php
                                        if (!empty($from)) {
                                            echo $from;
                                        }
                                        ?>" placeholder="<?php echo lang('date_from'); ?>" readonly="">
                                        <span class="input-group-addon"><?php echo lang('to'); ?></span>
                                        <input type="text" class="form-control dpd2" name="date_to" value="<?php
                                        if (!empty($to)) {
                                            echo $to;
                                        }
                                        ?>" placeholder="<?php echo lang('date_to'); ?>" readonly="">
                                    </div>
                                    <div class="row"></div>
                                    <span class="help-block"></span> 
                                </div>
                                <div class="col-md-3 no-print">

                                    <select class="form-control m-bot15" name="filter_by" value='' id="filter_by">
                                        <option value="select" <?php
                                        if ($filter_by == 'select') {
                                            echo 'selected';
                                        }
                                        ?> > <?php echo lang('filter_by'); ?> </option>
                                        <option value="department" <?php
                                        if ($filter_by == 'department') {
                                            echo 'selected';
                                        }
                                        ?> > <?php echo lang('department'); ?> </option>
                                        <option value="payment_proccedure" <?php
                                        if ($filter_by == 'payment_proccedure') {
                                            echo 'selected';
                                        }
                                        ?> > <?php echo lang('payment_proccedure'); ?> <?php echo lang('type'); ?> </option>
                                        <option value="laboratorist" <?php
                                        if ($filter_by == 'laboratorist') {
                                            echo 'selected';
                                        }
                                        ?> > <?php echo lang('laboratorist'); ?> </option>
                                    </select>


                                </div>
                              
                                        <div class="col-md-2 no-print form-group" id="department_choose">
                                      

                                        <select class="form-control m-bot15 js-example-basic-single" name="department_choose" value=''>  
                                            <option value="select_department"><?php echo lang('select') . ' ' . lang('department'); ?></option>                 
                                            <?php foreach ($departments as $department) { ?>
                                                <option value="<?php echo $department->id; ?>" <?php
                                                if ($department->id == $department_choose) {
                                                    echo 'selected';
                                                }
                                                ?> ><?php echo $department->name; ?></option>

                                            <?php } ?>
                                        </select>
                                    </div>


                                    <?php if ($filter_by != 'payment_proccedure') { ?> 
                                        <div class="col-md-2 no-print hidden form-group" id="type_choose">
                                        <?php } else { ?>
                                            <div class="col-md-2 no-print  form-group" id="type_choose">
                                            <?php } ?>

                                            <select class="form-control m-bot15" name="type" value=''>  
                                                <option value="select_type"><?php echo lang('select') . ' ' . lang('type'); ?></option>          
                                                <?php foreach ($types as $type) { ?>
                                                    <option value="<?php echo $type->id; ?>" <?php
                                                    if ($type->id == $type_choose) {
                                                        echo 'selected';
                                                    }
                                                    ?> ><?php echo $type->name; ?></option>
                                                        <?php } ?>

                                            </select>
                                        </div>

                                        <?php if ($filter_by != 'laboratorist') { ?> 
                                            <div class="col-md-2 no-print hidden form-group" id="laboratorist_choose">
                                            <?php } else { ?>
                                                <div class="col-md-2 no-print form-group" id="laboratorist_choose">
                                                <?php } ?>
                                                <select class="form-control m-bot15 js-example-basic-single" name="laboratorist_choose" value=''>  
                                                    <option value="select_laboratorist"><?php echo lang('select') . ' ' . lang('laboratorist'); ?></option>                 
                                                    <?php foreach ($laboratorists as $laboratorist) { ?>
                                                        <option value="<?php echo $laboratorist->id; ?>" <?php
                                                        if ($laboratorist->id == $laboratorist_choose) {
                                                            echo 'selected';
                                                        }
                                                        ?> ><?php echo $laboratorist->name; ?></option>

                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2 no-print">

                                                <select class="form-control m-bot15" name="status" value=''>
                                                    <option value="select" <?php
                                                    if ($status == 'select') {
                                                        echo 'selected';
                                                    }
                                                    ?> > <?php echo lang('select'); ?> </option>
                                                    <option value="paid" <?php
                                                    if ($status == 'paid') {
                                                        echo 'selected';
                                                    }
                                                    ?> > <?php echo lang('paid'); ?> </option>
                                                    <option value="unpaid" <?php
                                                    if ($status == 'unpaid') {
                                                        echo 'selected';
                                                    }
                                                    ?> > <?php echo lang('not_fully_paid'); ?> </option>
                                                </select>


                                            </div>
                                            <div class="col-md-2 no-print">
                                                <button type="submit" name="submit" class="btn btn-info range_submit"><?php echo lang('submit'); ?></button>
                                            </div>
                                        </div>
                                        </form>
                                        </section>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="adv-table editable-table ">

                                        <div class="space15"></div>
                                        <table class="table table-striped table-hover table-bordered" id="">
                                            <thead>
                                                <tr>
                                                    <th><?php echo lang('invoice_id'); ?></th>
                                                    <th><?php echo lang('patient'); ?></th>

                                                    <th><?php echo lang('date'); ?></th>
                                                    <th><?php echo lang('from'); ?></th>
                                                    <th><?php echo lang('sub_total'); ?></t>
                                                    <th><?php echo lang('discount'); ?></th>
                                                    <th><?php echo lang('grand_total'); ?></th>
                                                    <th><?php echo lang('paid'); ?> <?php echo lang('amount'); ?></th>
                                                    <th><?php echo lang('due'); ?></th>


                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($payments as $payment) {
                                                    if ($filter_by == 'department') {
                                                        if ($payment->payment_from == 'case' || $payment->payment_from == 'surgery' || $payment->payment_from == 'pre_surgery_medical_analysis' || $payment->payment_from == 'post_surgery_medical_analysis') {
                                                            $payment_cat = explode("##", $payment->category_name);
                                                            $pay_final = array();
                                                            foreach ($payment_cat as $value) {
                                                                $pay = array();
                                                                $pay = explode("**", $value);
                                                                if ($pay[0] == 'Medical Analysis' || $pay[0] == 'Surgery' || $pay[0] == 'MedicalAnalysis_pre_surgery' || $pay[0] == 'MedicalAnalysis_post_surgery') {

                                                                    $department_id = $this->db->get_where('payment_category', array('id' => $pay[2]))->row();

                                                                    if ($department_id->department == $department_choose) {

                                                                        $pay_final[] = '1';
                                                                    }
                                                                } else {
                                                                    $package_id = $this->db->get_where('packages', array('id' => $pay[2]))->row();
                                                                    $package_separate = explode("##", $package_id->price_cat);
                                                                    foreach ($package_separate as $value2) {
                                                                        $pay_single = array();
                                                                        $pay_single = explode("**", $value2);
                                                                        $department_id = $this->db->get_where('payment_category', array('id' => $pay_single[1]))->row();
                                                                        if ($department_id->department == $department_choose) {
                                                                            $pay_final[] = '1';
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                            if (in_array("1", $pay_final)) {
                                                                if ($status == 'paid') {
                                                                    if ($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id) == 0) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><a class="" title="<?php echo lang('invoice'); ?> " href="finance/invoice?id=<?php echo $payment->id; ?>"target="_blank"> <?php echo $payment->id ;?></a></td>
                                                                            <td><?php
                                                                                $patient_info = $this->db->get_where('patient', array('id' => $payment->patient))->row();
                                                                                if (!empty($patient_info)) {
                                                                                    $patient_details = $patient_info->name . '</br>' . $patient_info->address . '</br>' . $patient_info->phone . '</br>';
                                                                                } else {
                                                                                    $patient_details = ' ';
                                                                                }
                                                                                echo $patient_details;
                                                                                ?></td>
                                                                            <td><?php echo date('d-m-y', $payment->date); ?></td>
                                                                            <td><?php
                                                                                if ($payment->payment_from == 'case') {
                                                                                    $from = lang('case');
                                                                                } elseif ($payment->payment_from == 'pre_service') {
                                                                                    $from = lang('pre_surgery') . ' ' . lang('service');
                                                                                } elseif ($payment->payment_from == 'post_service') {
                                                                                    $from = lang('post_surgery') . ' ' . lang('service');
                                                                                } elseif ($payment->payment_from == 'surgery') {
                                                                                    $from = lang('surgery');
                                                                                } elseif ($payment->payment_from == 'pre_surgery_medical_analysis') {
                                                                                    $from = lang('pre_surgery') . ' ' . lang('medical_analysis');
                                                                                } elseif ($payment->payment_from == 'post_surgery_medical_analysis') {
                                                                                    $from = lang('post_surgery') . ' ' . lang('medical_analysis');
                                                                                } elseif ($payment->payment_from == 'pre_surgery_medicine') {
                                                                                    $from = lang('pre_surgery') . ' ' . lang('medicine');
                                                                                } elseif ($payment->payment_from == 'post_surgery_medicine') {
                                                                                    $from = lang('post_surgery') . ' ' . lang('medicine');
                                                                                }
                                                                                echo $from;
                                                                                ?></td>
                                                                            <td><?php
                                                                                $amount[] = $payment->amount;
                                                                                echo $settings->currency . ' ' . $payment->amount;
                                                                                ?></td>
                                                                            <td><?php
                                                                                $discount = $payment->discount;
                                                                                if (empty($discount)) {
                                                                                    $discount = 0;
                                                                                }
                                                                                $discount_up[] = $payment->discount;
                                                                                echo $settings->currency . ' ' . $discount;
                                                                                ?></td>
                                                                            <td><?php
                                                                                $gross[] = $payment->gross_total;
                                                                                echo $settings->currency . ' ' . $payment->gross_total;
                                                                                ?></td>
                                                                            <td><?php
                                                                                $deposit[] = $this->finance_model->getDepositAmountByPaymentId($payment->id);
                                                                                echo $settings->currency . ' ' . $this->finance_model->getDepositAmountByPaymentId($payment->id);
                                                                                ?></td>
                                                                            <td><?php echo $settings->currency . ' ' . ($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id)); ?></td>

                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                } elseif ($status == 'unpaid') {
                                                                    if ($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id) > 0) {
                                                                        ?>
                                                                        <tr>
                                                                             <td><a class="" title="<?php echo lang('invoice'); ?> " href="finance/invoice?id=<?php echo $payment->id; ?>"target="_blank"> <?php echo $payment->id ;?></a></td>
                                                                            <td><?php
                                                                                $patient_info = $this->db->get_where('patient', array('id' => $payment->patient))->row();
                                                                                if (!empty($patient_info)) {
                                                                                    $patient_details = $patient_info->name . '</br>' . $patient_info->address . '</br>' . $patient_info->phone . '</br>';
                                                                                } else {
                                                                                    $patient_details = ' ';
                                                                                }
                                                                                echo $patient_details;
                                                                                ?></td>
                                                                            <td><?php echo date('d-m-y', $payment->date); ?></td>
                                                                            <td><?php
                                                                                if ($payment->payment_from == 'case') {
                                                                                    $from = lang('case');
                                                                                } elseif ($payment->payment_from == 'pre_service') {
                                                                                    $from = lang('pre_surgery') . ' ' . lang('service');
                                                                                } elseif ($payment->payment_from == 'post_service') {
                                                                                    $from = lang('post_surgery') . ' ' . lang('service');
                                                                                } elseif ($payment->payment_from == 'surgery') {
                                                                                    $from = lang('surgery');
                                                                                } elseif ($payment->payment_from == 'pre_surgery_medical_analysis') {
                                                                                    $from = lang('pre_surgery') . ' ' . lang('medical_analysis');
                                                                                } elseif ($payment->payment_from == 'post_surgery_medical_analysis') {
                                                                                    $from = lang('post_surgery') . ' ' . lang('medical_analysis');
                                                                                } elseif ($payment->payment_from == 'pre_surgery_medicine') {
                                                                                    $from = lang('pre_surgery') . ' ' . lang('medicine');
                                                                                } elseif ($payment->payment_from == 'post_surgery_medicine') {
                                                                                    $from = lang('post_surgery') . ' ' . lang('medicine');
                                                                                }
                                                                                echo $from;
                                                                                ?></td>
                                                                            <td><?php
                                                                                $amount[] = $payment->amount;
                                                                                echo $settings->currency . ' ' . $payment->amount;
                                                                                ?></td>
                                                                            <td><?php
                                                                                $discount = $payment->discount;
                                                                                if (empty($discount)) {
                                                                                    $discount = 0;
                                                                                }
                                                                                $discount_up[] = $payment->discount;
                                                                                echo $settings->currency . ' ' . $discount;
                                                                                ?></td>
                                                                            <td><?php
                                                                                $gross[] = $payment->gross_total;
                                                                                echo $settings->currency . ' ' . $payment->gross_total;
                                                                                ?></td>
                                                                            <td><?php
                                                                                $deposit[] = $this->finance_model->getDepositAmountByPaymentId($payment->id);
                                                                                echo $settings->currency . ' ' . $this->finance_model->getDepositAmountByPaymentId($payment->id);
                                                                                ?></td>
                                                                            <td><?php echo $settings->currency . ' ' . ($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id)); ?></td>

                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <tr>
                                                                         <td><a class="" title="<?php echo lang('invoice'); ?> " href="finance/invoice?id=<?php echo $payment->id; ?>"target="_blank"> <?php echo $payment->id ;?></a></td>
                                                                        <td><?php
                                                                            $patient_info = $this->db->get_where('patient', array('id' => $payment->patient))->row();
                                                                            if (!empty($patient_info)) {
                                                                                $patient_details = $patient_info->name . '</br>' . $patient_info->address . '</br>' . $patient_info->phone . '</br>';
                                                                            } else {
                                                                                $patient_details = ' ';
                                                                            }
                                                                            echo $patient_details;
                                                                            ?></td>
                                                                        <td><?php echo date('d-m-y', $payment->date); ?></td>
                                                                        <td><?php
                                                                            if ($payment->payment_from == 'case') {
                                                                                $from = lang('case');
                                                                            } elseif ($payment->payment_from == 'pre_service') {
                                                                                $from = lang('pre_surgery') . ' ' . lang('service');
                                                                            } elseif ($payment->payment_from == 'post_service') {
                                                                                $from = lang('post_surgery') . ' ' . lang('service');
                                                                            } elseif ($payment->payment_from == 'surgery') {
                                                                                $from = lang('surgery');
                                                                            } elseif ($payment->payment_from == 'pre_surgery_medical_analysis') {
                                                                                $from = lang('pre_surgery') . ' ' . lang('medical_analysis');
                                                                            } elseif ($payment->payment_from == 'post_surgery_medical_analysis') {
                                                                                $from = lang('post_surgery') . ' ' . lang('medical_analysis');
                                                                            } elseif ($payment->payment_from == 'pre_surgery_medicine') {
                                                                                $from = lang('pre_surgery') . ' ' . lang('medicine');
                                                                            } elseif ($payment->payment_from == 'post_surgery_medicine') {
                                                                                $from = lang('post_surgery') . ' ' . lang('medicine');
                                                                            }
                                                                            echo $from;
                                                                            ?></td>
                                                                        <td><?php
                                                                            $amount[] = $payment->amount;
                                                                            echo $settings->currency . ' ' . $payment->amount;
                                                                            ?></td>
                                                                        <td><?php
                                                                            $discount = $payment->discount;
                                                                            if (empty($discount)) {
                                                                                $discount = 0;
                                                                            }
                                                                            $discount_up[] = $payment->discount;
                                                                            echo $settings->currency . ' ' . $discount;
                                                                            ?></td>
                                                                        <td><?php
                                                                            $gross[] = $payment->gross_total;
                                                                            echo $settings->currency . ' ' . $payment->gross_total;
                                                                            ?></td>
                                                                        <td><?php
                                                                            $deposit[] = $this->finance_model->getDepositAmountByPaymentId($payment->id);
                                                                            echo $settings->currency . ' ' . $this->finance_model->getDepositAmountByPaymentId($payment->id);
                                                                            ?></td>
                                                                        <td><?php echo $settings->currency . ' ' . ($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id)); ?></td>

                                                                    </tr>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                    } elseif ($filter_by == 'payment_proccedure') {
                                                        if ($payment->payment_from == 'case' || $payment->payment_from == 'surgery' || $payment->payment_from == 'pre_surgery_medical_analysis' || $payment->payment_from == 'post_surgery_medical_analysis') {
                                                            $payment_cat = explode("##", $payment->category_name);
                                                            $pay_final = array();
                                                            foreach ($payment_cat as $value) {
                                                                $pay = array();
                                                                $pay = explode("**", $value);
                                                                if ($pay[0] == 'Medical Analysis' || $pay[0] == 'Surgery' || $pay[0] == 'MedicalAnalysis_pre_surgery' || $pay[0] == 'MedicalAnalysis_post_surgery') {

                                                                    $department_id = $this->db->get_where('payment_category', array('id' => $pay[2]))->row();

                                                                    if ($department_id->type == $type_choose) {

                                                                        $pay_final[] = '1';
                                                                    }
                                                                } else {
                                                                    $package_id = $this->db->get_where('packages', array('id' => $pay[2]))->row();
                                                                    $package_separate = explode("##", $package_id->price_cat);
                                                                    foreach ($package_separate as $value2) {
                                                                        $pay_single = array();
                                                                        $pay_single = explode("**", $value2);
                                                                        $department_id = $this->db->get_where('payment_category', array('id' => $pay_single[1]))->row();
                                                                        if ($department_id->type == $type_choose) {
                                                                            $pay_final[] = '1';
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                            if (in_array("1", $pay_final)) {
                                                                if ($status == 'paid') {
                                                                    if ($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id) == 0) {
                                                                        ?>
                                                                        <tr>
                                                                             <td><a class="" title="<?php echo lang('invoice'); ?> " href="finance/invoice?id=<?php echo $payment->id; ?>"target="_blank"> <?php echo $payment->id ;?></a></td>
                                                                            <td><?php
                                                                                $patient_info = $this->db->get_where('patient', array('id' => $payment->patient))->row();
                                                                                if (!empty($patient_info)) {
                                                                                    $patient_details = $patient_info->name . '</br>' . $patient_info->address . '</br>' . $patient_info->phone . '</br>';
                                                                                } else {
                                                                                    $patient_details = ' ';
                                                                                }
                                                                                echo $patient_details;
                                                                                ?></td>
                                                                            <td><?php echo date('d-m-y', $payment->date); ?></td>
                                                                            <td><?php
                                                                                if ($payment->payment_from == 'case') {
                                                                                    $from = lang('case');
                                                                                } elseif ($payment->payment_from == 'pre_service') {
                                                                                    $from = lang('pre_surgery') . ' ' . lang('service');
                                                                                } elseif ($payment->payment_from == 'post_service') {
                                                                                    $from = lang('post_surgery') . ' ' . lang('service');
                                                                                } elseif ($payment->payment_from == 'surgery') {
                                                                                    $from = lang('surgery');
                                                                                } elseif ($payment->payment_from == 'pre_surgery_medical_analysis') {
                                                                                    $from = lang('pre_surgery') . ' ' . lang('medical_analysis');
                                                                                } elseif ($payment->payment_from == 'post_surgery_medical_analysis') {
                                                                                    $from = lang('post_surgery') . ' ' . lang('medical_analysis');
                                                                                } elseif ($payment->payment_from == 'pre_surgery_medicine') {
                                                                                    $from = lang('pre_surgery') . ' ' . lang('medicine');
                                                                                } elseif ($payment->payment_from == 'post_surgery_medicine') {
                                                                                    $from = lang('post_surgery') . ' ' . lang('medicine');
                                                                                }
                                                                                echo $from;
                                                                                ?></td>
                                                                            <td><?php
                                                                                $amount[] = $payment->amount;
                                                                                echo $settings->currency . ' ' . $payment->amount;
                                                                                ?></td>
                                                                            <td><?php
                                                                                $discount = $payment->discount;
                                                                                if (empty($discount)) {
                                                                                    $discount = 0;
                                                                                }
                                                                                $discount_up[] = $payment->discount;
                                                                                echo $settings->currency . ' ' . $discount;
                                                                                ?></td>
                                                                            <td><?php
                                                                                $gross[] = $payment->gross_total;
                                                                                echo $settings->currency . ' ' . $payment->gross_total;
                                                                                ?></td>
                                                                            <td><?php
                                                                                $deposit[] = $this->finance_model->getDepositAmountByPaymentId($payment->id);
                                                                                echo $settings->currency . ' ' . $this->finance_model->getDepositAmountByPaymentId($payment->id);
                                                                                ?></td>
                                                                            <td><?php echo $settings->currency . ' ' . ($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id)); ?></td>

                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                } elseif ($status == 'unpaid') {
                                                                    if ($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id) > 0) {
                                                                        ?>
                                                                        <tr>
                                                                             <td><a class="" title="<?php echo lang('invoice'); ?> " href="finance/invoice?id=<?php echo $payment->id; ?>"target="_blank"> <?php echo $payment->id ;?></a></td>
                                                                            <td><?php
                                                                                $patient_info = $this->db->get_where('patient', array('id' => $payment->patient))->row();
                                                                                if (!empty($patient_info)) {
                                                                                    $patient_details = $patient_info->name . '</br>' . $patient_info->address . '</br>' . $patient_info->phone . '</br>';
                                                                                } else {
                                                                                    $patient_details = ' ';
                                                                                }
                                                                                echo $patient_details;
                                                                                ?></td>
                                                                            <td><?php echo date('d-m-y', $payment->date); ?></td>
                                                                            <td><?php
                                                                                if ($payment->payment_from == 'case') {
                                                                                    $from = lang('case');
                                                                                } elseif ($payment->payment_from == 'pre_service') {
                                                                                    $from = lang('pre_surgery') . ' ' . lang('service');
                                                                                } elseif ($payment->payment_from == 'post_service') {
                                                                                    $from = lang('post_surgery') . ' ' . lang('service');
                                                                                } elseif ($payment->payment_from == 'surgery') {
                                                                                    $from = lang('surgery');
                                                                                } elseif ($payment->payment_from == 'pre_surgery_medical_analysis') {
                                                                                    $from = lang('pre_surgery') . ' ' . lang('medical_analysis');
                                                                                } elseif ($payment->payment_from == 'post_surgery_medical_analysis') {
                                                                                    $from = lang('post_surgery') . ' ' . lang('medical_analysis');
                                                                                } elseif ($payment->payment_from == 'pre_surgery_medicine') {
                                                                                    $from = lang('pre_surgery') . ' ' . lang('medicine');
                                                                                } elseif ($payment->payment_from == 'post_surgery_medicine') {
                                                                                    $from = lang('post_surgery') . ' ' . lang('medicine');
                                                                                }
                                                                                echo $from;
                                                                                ?></td>
                                                                            <td><?php
                                                                                $amount[] = $payment->amount;
                                                                                echo $settings->currency . ' ' . $payment->amount;
                                                                                ?></td>
                                                                            <td><?php
                                                                                $discount = $payment->discount;
                                                                                if (empty($discount)) {
                                                                                    $discount = 0;
                                                                                }
                                                                                $discount_up[] = $payment->discount;
                                                                                echo $settings->currency . ' ' . $discount;
                                                                                ?></td>
                                                                            <td><?php
                                                                                $gross[] = $payment->gross_total;
                                                                                echo $settings->currency . ' ' . $payment->gross_total;
                                                                                ?></td>
                                                                            <td><?php
                                                                                $deposit[] = $this->finance_model->getDepositAmountByPaymentId($payment->id);
                                                                                echo $settings->currency . ' ' . $this->finance_model->getDepositAmountByPaymentId($payment->id);
                                                                                ?></td>
                                                                            <td><?php echo $settings->currency . ' ' . ($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id)); ?></td>

                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <tr>
                                                                         <td><a class="" title="<?php echo lang('invoice'); ?> " href="finance/invoice?id=<?php echo $payment->id; ?>"target="_blank"> <?php echo $payment->id ;?></a></td>
                                                                        <td><?php
                                                                            $patient_info = $this->db->get_where('patient', array('id' => $payment->patient))->row();
                                                                            if (!empty($patient_info)) {
                                                                                $patient_details = $patient_info->name . '</br>' . $patient_info->address . '</br>' . $patient_info->phone . '</br>';
                                                                            } else {
                                                                                $patient_details = ' ';
                                                                            }
                                                                            echo $patient_details;
                                                                            ?></td>
                                                                        <td><?php echo date('d-m-y', $payment->date); ?></td>
                                                                        <td><?php
                                                                            if ($payment->payment_from == 'case') {
                                                                                $from = lang('case');
                                                                            } elseif ($payment->payment_from == 'pre_service') {
                                                                                $from = lang('pre_surgery') . ' ' . lang('service');
                                                                            } elseif ($payment->payment_from == 'post_service') {
                                                                                $from = lang('post_surgery') . ' ' . lang('service');
                                                                            } elseif ($payment->payment_from == 'surgery') {
                                                                                $from = lang('surgery');
                                                                            } elseif ($payment->payment_from == 'pre_surgery_medical_analysis') {
                                                                                $from = lang('pre_surgery') . ' ' . lang('medical_analysis');
                                                                            } elseif ($payment->payment_from == 'post_surgery_medical_analysis') {
                                                                                $from = lang('post_surgery') . ' ' . lang('medical_analysis');
                                                                            } elseif ($payment->payment_from == 'pre_surgery_medicine') {
                                                                                $from = lang('pre_surgery') . ' ' . lang('medicine');
                                                                            } elseif ($payment->payment_from == 'post_surgery_medicine') {
                                                                                $from = lang('post_surgery') . ' ' . lang('medicine');
                                                                            }
                                                                            echo $from;
                                                                            ?></td>
                                                                        <td><?php
                                                                            $amount[] = $payment->amount;
                                                                            echo $settings->currency . ' ' . $payment->amount;
                                                                            ?></td>
                                                                        <td><?php
                                                                            $discount = $payment->discount;
                                                                            if (empty($discount)) {
                                                                                $discount = 0;
                                                                            }
                                                                            $discount_up[] = $payment->discount;
                                                                            echo $settings->currency . ' ' . $discount;
                                                                            ?></td>
                                                                        <td><?php
                                                                            $gross[] = $payment->gross_total;
                                                                            echo $settings->currency . ' ' . $payment->gross_total;
                                                                            ?></td>
                                                                        <td><?php
                                                                            $deposit[] = $this->finance_model->getDepositAmountByPaymentId($payment->id);
                                                                            echo $settings->currency . ' ' . $this->finance_model->getDepositAmountByPaymentId($payment->id);
                                                                            ?></td>
                                                                        <td><?php echo $settings->currency . ' ' . ($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id)); ?></td>

                                                                    </tr>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                    } elseif ($filter_by == 'laboratorist') {
                                                        if ($payment->payment_from == 'case' || $payment->payment_from == 'surgery' || $payment->payment_from == 'pre_surgery_medical_analysis' || $payment->payment_from == 'post_surgery_medical_analysis') {

                                                            $payment_cat = explode("##", $payment->category_name);
                                                            $pay_final = array();
                                                            foreach ($payment_cat as $value) {
                                                                $pay = array();
                                                                $pay = explode("**", $value);
                                                                if ($pay[0] == 'Medical Analysis' || $pay[0] == 'MedicalAnalysis_pre_surgery' || $pay[0] == 'MedicalAnalysis_post_surgery') {
                                                                    if ($pay[0] == 'Medical Analysis') {
                                                                        $lab_to_be_id = 'case-medical-' . $payment->case_id . '-' . $pay[2];
                                                                    } elseif ($pay[0] == 'MedicalAnalysis_pre_surgery') {
                                                                        $lab_to_be_id = 'precase-medical-' . $payment->pre_medical_surgery_id . '-' . $pay[2];
                                                                    } elseif ($pay[0] == 'MedicalAnalysis_post_surgery') {
                                                                        $lab_to_be_id = 'postcase-medical-' . $payment->post_medical_surgery_id . '-' . $pay[2];
                                                                    }
                                                                    $lab_recent = $this->db->get_where('lab', array('to_be_id' => $lab_to_be_id, 'laboratorist' => $laboratorist_choose))->row();

                                                                    if (!empty($lab_recent)) {

                                                                        $pay_final[] = '1';
                                                                    }
                                                                } else {
                                                                    $package_id = $this->db->get_where('packages', array('id' => $pay[2]))->row();
                                                                    $package_separate = explode("##", $package_id->price_cat);
                                                                    foreach ($package_separate as $value2) {
                                                                        $pay_single = array();
                                                                        $pay_single = explode("**", $value2);
                                                                        if ($pay_single[0] == 'Medical Analysis') {
                                                                            $lab_to_be_id = 'case-package-' . $payment->case_id . '-' . $pay[2];
                                                                        } elseif ($pay_single[0] == 'Package_pre_surgery_medical') {
                                                                            $lab_to_be_id = 'precase-package-' . $payment->pre_medical_surgery_id . '-' . $pay[2];
                                                                        } elseif ($pay_single[0] == 'Package_post_surgery_medical') {
                                                                            $lab_to_be_id = 'postcase-package-' . $payment->post_medical_surgery_id . '-' . $pay[2];
                                                                        }
                                                                        $lab_recent = $this->db->get_where('lab', array('to_be_id' => $lab_to_be_id, 'laboratorist' => $laboratorist_choose))->row();
                                                                        if (!empty($lab_recent)) {

                                                                            $pay_final[] = '1';
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                            if (in_array("1", $pay_final)) {
                                                                if ($status == 'paid') {
                                                                    if ($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id) == 0) {
                                                                        ?>
                                                                        <tr>
                                                                             <td><a class="" title="<?php echo lang('invoice'); ?> " href="finance/invoice?id=<?php echo $payment->id; ?>"target="_blank"> <?php echo $payment->id ;?></a></td>
                                                                            <td><?php
                                                                                $patient_info = $this->db->get_where('patient', array('id' => $payment->patient))->row();
                                                                                if (!empty($patient_info)) {
                                                                                    $patient_details = $patient_info->name . '</br>' . $patient_info->address . '</br>' . $patient_info->phone . '</br>';
                                                                                } else {
                                                                                    $patient_details = ' ';
                                                                                }
                                                                                echo $patient_details;
                                                                                ?></td>
                                                                            <td><?php echo date('d-m-y', $payment->date); ?></td>
                                                                            <td><?php
                                                                                if ($payment->payment_from == 'case') {
                                                                                    $from = lang('case');
                                                                                } elseif ($payment->payment_from == 'pre_service') {
                                                                                    $from = lang('pre_surgery') . ' ' . lang('service');
                                                                                } elseif ($payment->payment_from == 'post_service') {
                                                                                    $from = lang('post_surgery') . ' ' . lang('service');
                                                                                } elseif ($payment->payment_from == 'surgery') {
                                                                                    $from = lang('surgery');
                                                                                } elseif ($payment->payment_from == 'pre_surgery_medical_analysis') {
                                                                                    $from = lang('pre_surgery') . ' ' . lang('medical_analysis');
                                                                                } elseif ($payment->payment_from == 'post_surgery_medical_analysis') {
                                                                                    $from = lang('post_surgery') . ' ' . lang('medical_analysis');
                                                                                } elseif ($payment->payment_from == 'pre_surgery_medicine') {
                                                                                    $from = lang('pre_surgery') . ' ' . lang('medicine');
                                                                                } elseif ($payment->payment_from == 'post_surgery_medicine') {
                                                                                    $from = lang('post_surgery') . ' ' . lang('medicine');
                                                                                }
                                                                                echo $from;
                                                                                ?></td>
                                                                            <td><?php
                                                                                $amount[] = $payment->amount;
                                                                                echo $settings->currency . ' ' . $payment->amount;
                                                                                ?></td>
                                                                            <td><?php
                                                                                $discount = $payment->discount;
                                                                                if (empty($discount)) {
                                                                                    $discount = 0;
                                                                                }
                                                                                $discount_up[] = $payment->discount;
                                                                                echo $settings->currency . ' ' . $discount;
                                                                                ?></td>
                                                                            <td><?php
                                                                                $gross[] = $payment->gross_total;
                                                                                echo $settings->currency . ' ' . $payment->gross_total;
                                                                                ?></td>
                                                                            <td><?php
                                                                                $deposit[] = $this->finance_model->getDepositAmountByPaymentId($payment->id);
                                                                                echo $settings->currency . ' ' . $this->finance_model->getDepositAmountByPaymentId($payment->id);
                                                                                ?></td>
                                                                            <td><?php echo $settings->currency . ' ' . ($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id)); ?></td>

                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                } elseif ($status == 'unpaid') {
                                                                    if ($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id) > 0) {
                                                                        ?>
                                                                        <tr>
                                                                             <td><a class="" title="<?php echo lang('invoice'); ?> " href="finance/invoice?id=<?php echo $payment->id; ?>"target="_blank"> <?php echo $payment->id ;?></a></td>
                                                                            <td><?php
                                                                                $patient_info = $this->db->get_where('patient', array('id' => $payment->patient))->row();
                                                                                if (!empty($patient_info)) {
                                                                                    $patient_details = $patient_info->name . '</br>' . $patient_info->address . '</br>' . $patient_info->phone . '</br>';
                                                                                } else {
                                                                                    $patient_details = ' ';
                                                                                }
                                                                                echo $patient_details;
                                                                                ?></td>
                                                                            <td><?php echo date('d-m-y', $payment->date); ?></td>
                                                                            <td><?php
                                                                                if ($payment->payment_from == 'case') {
                                                                                    $from = lang('case');
                                                                                } elseif ($payment->payment_from == 'pre_service') {
                                                                                    $from = lang('pre_surgery') . ' ' . lang('service');
                                                                                } elseif ($payment->payment_from == 'post_service') {
                                                                                    $from = lang('post_surgery') . ' ' . lang('service');
                                                                                } elseif ($payment->payment_from == 'surgery') {
                                                                                    $from = lang('surgery');
                                                                                } elseif ($payment->payment_from == 'pre_surgery_medical_analysis') {
                                                                                    $from = lang('pre_surgery') . ' ' . lang('medical_analysis');
                                                                                } elseif ($payment->payment_from == 'post_surgery_medical_analysis') {
                                                                                    $from = lang('post_surgery') . ' ' . lang('medical_analysis');
                                                                                } elseif ($payment->payment_from == 'pre_surgery_medicine') {
                                                                                    $from = lang('pre_surgery') . ' ' . lang('medicine');
                                                                                } elseif ($payment->payment_from == 'post_surgery_medicine') {
                                                                                    $from = lang('post_surgery') . ' ' . lang('medicine');
                                                                                }
                                                                                echo $from;
                                                                                ?></td>
                                                                            <td><?php
                                                                                $amount[] = $payment->amount;
                                                                                echo $settings->currency . ' ' . $payment->amount;
                                                                                ?></td>
                                                                            <td><?php
                                                                                $discount = $payment->discount;
                                                                                if (empty($discount)) {
                                                                                    $discount = 0;
                                                                                }
                                                                                $discount_up[] = $payment->discount;
                                                                                echo $settings->currency . ' ' . $discount;
                                                                                ?></td>
                                                                            <td><?php
                                                                                $gross[] = $payment->gross_total;
                                                                                echo $settings->currency . ' ' . $payment->gross_total;
                                                                                ?></td>
                                                                            <td><?php
                                                                                $deposit[] = $this->finance_model->getDepositAmountByPaymentId($payment->id);
                                                                                echo $settings->currency . ' ' . $this->finance_model->getDepositAmountByPaymentId($payment->id);
                                                                                ?></td>
                                                                            <td><?php echo $settings->currency . ' ' . ($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id)); ?></td>

                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <tr>
                                                                         <td><a class="" title="<?php echo lang('invoice'); ?> " href="finance/invoice?id=<?php echo $payment->id; ?>"target="_blank"> <?php echo $payment->id ;?></a></td>
                                                                        <td><?php
                                                                            $patient_info = $this->db->get_where('patient', array('id' => $payment->patient))->row();
                                                                            if (!empty($patient_info)) {
                                                                                $patient_details = $patient_info->name . '</br>' . $patient_info->address . '</br>' . $patient_info->phone . '</br>';
                                                                            } else {
                                                                                $patient_details = ' ';
                                                                            }
                                                                            echo $patient_details;
                                                                            ?></td>
                                                                        <td><?php echo date('d-m-y', $payment->date); ?></td>
                                                                        <td><?php
                                                                            if ($payment->payment_from == 'case') {
                                                                                $from = lang('case');
                                                                            } elseif ($payment->payment_from == 'pre_service') {
                                                                                $from = lang('pre_surgery') . ' ' . lang('service');
                                                                            } elseif ($payment->payment_from == 'post_service') {
                                                                                $from = lang('post_surgery') . ' ' . lang('service');
                                                                            } elseif ($payment->payment_from == 'surgery') {
                                                                                $from = lang('surgery');
                                                                            } elseif ($payment->payment_from == 'pre_surgery_medical_analysis') {
                                                                                $from = lang('pre_surgery') . ' ' . lang('medical_analysis');
                                                                            } elseif ($payment->payment_from == 'post_surgery_medical_analysis') {
                                                                                $from = lang('post_surgery') . ' ' . lang('medical_analysis');
                                                                            } elseif ($payment->payment_from == 'pre_surgery_medicine') {
                                                                                $from = lang('pre_surgery') . ' ' . lang('medicine');
                                                                            } elseif ($payment->payment_from == 'post_surgery_medicine') {
                                                                                $from = lang('post_surgery') . ' ' . lang('medicine');
                                                                            }
                                                                            echo $from;
                                                                            ?></td>
                                                                        <td><?php
                                                                            $amount[] = $payment->amount;
                                                                            echo $settings->currency . ' ' . $payment->amount;
                                                                            ?></td>
                                                                        <td><?php
                                                                            $discount = $payment->discount;
                                                                            if (empty($discount)) {
                                                                                $discount = 0;
                                                                            }
                                                                            $discount_up[] = $payment->discount;
                                                                            echo $settings->currency . ' ' . $discount;
                                                                            ?></td>
                                                                        <td><?php
                                                                            $gross[] = $payment->gross_total;
                                                                            echo $settings->currency . ' ' . $payment->gross_total;
                                                                            ?></td>
                                                                        <td><?php
                                                                            $deposit[] = $this->finance_model->getDepositAmountByPaymentId($payment->id);
                                                                            echo $settings->currency . ' ' . $this->finance_model->getDepositAmountByPaymentId($payment->id);
                                                                            ?></td>
                                                                        <td><?php echo $settings->currency . ' ' . ($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id)); ?></td>

                                                                    </tr>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        if ($status == 'paid') {
                                                            if ($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id) == 0) {
                                                                ?>
                                                                <tr>
                                                                     <td><a class="" title="<?php echo lang('invoice'); ?> " href="finance/invoice?id=<?php echo $payment->id; ?>"target="_blank"> <?php echo $payment->id ;?></a></td>
                                                                    <td><?php
                                                                        $patient_info = $this->db->get_where('patient', array('id' => $payment->patient))->row();
                                                                        if (!empty($patient_info)) {
                                                                            $patient_details = $patient_info->name . '</br>' . $patient_info->address . '</br>' . $patient_info->phone . '</br>';
                                                                        } else {
                                                                            $patient_details = ' ';
                                                                        }
                                                                        echo $patient_details;
                                                                        ?></td>
                                                                    <td><?php echo date('d-m-y', $payment->date); ?></td>
                                                                    <td><?php
                                                                        if ($payment->payment_from == 'case') {
                                                                            $from = lang('case');
                                                                        } elseif ($payment->payment_from == 'pre_service') {
                                                                            $from = lang('pre_surgery') . ' ' . lang('service');
                                                                        } elseif ($payment->payment_from == 'post_service') {
                                                                            $from = lang('post_surgery') . ' ' . lang('service');
                                                                        } elseif ($payment->payment_from == 'surgery') {
                                                                            $from = lang('surgery');
                                                                        } elseif ($payment->payment_from == 'pre_surgery_medical_analysis') {
                                                                            $from = lang('pre_surgery') . ' ' . lang('medical_analysis');
                                                                        } elseif ($payment->payment_from == 'post_surgery_medical_analysis') {
                                                                            $from = lang('post_surgery') . ' ' . lang('medical_analysis');
                                                                        } elseif ($payment->payment_from == 'pre_surgery_medicine') {
                                                                            $from = lang('pre_surgery') . ' ' . lang('medicine');
                                                                        } elseif ($payment->payment_from == 'post_surgery_medicine') {
                                                                            $from = lang('post_surgery') . ' ' . lang('medicine');
                                                                        }
                                                                        echo $from;
                                                                        ?></td>
                                                                    <td><?php
                                                                        $amount[] = $payment->amount;
                                                                        echo $settings->currency . ' ' . $payment->amount;
                                                                        ?></td>
                                                                    <td><?php
                                                                        $discount = $payment->discount;
                                                                        if (empty($discount)) {
                                                                            $discount = 0;
                                                                        }
                                                                        $discount_up[] = $payment->discount;
                                                                        echo $settings->currency . ' ' . $discount;
                                                                        ?></td>
                                                                    <td><?php
                                                                        $gross[] = $payment->gross_total;
                                                                        echo $settings->currency . ' ' . $payment->gross_total;
                                                                        ?></td>
                                                                    <td><?php
                                                                        $deposit[] = $this->finance_model->getDepositAmountByPaymentId($payment->id);
                                                                        echo $settings->currency . ' ' . $this->finance_model->getDepositAmountByPaymentId($payment->id);
                                                                        ?></td>
                                                                    <td><?php echo $settings->currency . ' ' . ($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id)); ?></td>

                                                                </tr>
                                                                <?php
                                                            }
                                                        } elseif ($status == 'unpaid') {
                                                            if ($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id) > 0) {
                                                                ?>
                                                                <tr>
                                                                     <td><a class="" title="<?php echo lang('invoice'); ?> " href="finance/invoice?id=<?php echo $payment->id; ?>"target="_blank"> <?php echo $payment->id ;?></a></td>
                                                                    <td><?php
                                                                        $patient_info = $this->db->get_where('patient', array('id' => $payment->patient))->row();
                                                                        if (!empty($patient_info)) {
                                                                            $patient_details = $patient_info->name . '</br>' . $patient_info->address . '</br>' . $patient_info->phone . '</br>';
                                                                        } else {
                                                                            $patient_details = ' ';
                                                                        }
                                                                        echo $patient_details;
                                                                        ?></td>
                                                                    <td><?php echo date('d-m-y', $payment->date); ?></td>
                                                                    <td><?php
                                                                        if ($payment->payment_from == 'case') {
                                                                            $from = lang('case');
                                                                        } elseif ($payment->payment_from == 'pre_service') {
                                                                            $from = lang('pre_surgery') . ' ' . lang('service');
                                                                        } elseif ($payment->payment_from == 'post_service') {
                                                                            $from = lang('post_surgery') . ' ' . lang('service');
                                                                        } elseif ($payment->payment_from == 'surgery') {
                                                                            $from = lang('surgery');
                                                                        } elseif ($payment->payment_from == 'pre_surgery_medical_analysis') {
                                                                            $from = lang('pre_surgery') . ' ' . lang('medical_analysis');
                                                                        } elseif ($payment->payment_from == 'post_surgery_medical_analysis') {
                                                                            $from = lang('post_surgery') . ' ' . lang('medical_analysis');
                                                                        } elseif ($payment->payment_from == 'pre_surgery_medicine') {
                                                                            $from = lang('pre_surgery') . ' ' . lang('medicine');
                                                                        } elseif ($payment->payment_from == 'post_surgery_medicine') {
                                                                            $from = lang('post_surgery') . ' ' . lang('medicine');
                                                                        }
                                                                        echo $from;
                                                                        ?></td>
                                                                    <td><?php
                                                                        $amount[] = $payment->amount;
                                                                        echo $settings->currency . ' ' . $payment->amount;
                                                                        ?></td>
                                                                    <td><?php
                                                                        $discount = $payment->discount;
                                                                        if (empty($discount)) {
                                                                            $discount = 0;
                                                                        }
                                                                        $discount_up[] = $payment->discount;
                                                                        echo $settings->currency . ' ' . $discount;
                                                                        ?></td>
                                                                    <td><?php
                                                                        $gross[] = $payment->gross_total;
                                                                        echo $settings->currency . ' ' . $payment->gross_total;
                                                                        ?></td>
                                                                    <td><?php
                                                                        $deposit[] = $this->finance_model->getDepositAmountByPaymentId($payment->id);
                                                                        echo $settings->currency . ' ' . $this->finance_model->getDepositAmountByPaymentId($payment->id);
                                                                        ?></td>
                                                                    <td><?php echo $settings->currency . ' ' . ($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id)); ?></td>

                                                                </tr>
                                                                <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <tr> 
                                                                 <td><a class="" title="<?php echo lang('invoice'); ?> " href="finance/invoice?id=<?php echo $payment->id; ?>"target="_blank"> <?php echo $payment->id ;?></a></td>
                                                                <td><?php
                                                                    $patient_info = $this->db->get_where('patient', array('id' => $payment->patient))->row();
                                                                    if (!empty($patient_info)) {
                                                                        $patient_details = $patient_info->name . '</br>' . $patient_info->address . '</br>' . $patient_info->phone . '</br>';
                                                                    } else {
                                                                        $patient_details = ' ';
                                                                    }
                                                                    echo $patient_details;
                                                                    ?></td>
                                                                <td><?php echo date('d-m-y', $payment->date); ?></td>
                                                                <td><?php
                                                                    if ($payment->payment_from == 'case') {
                                                                        $from = lang('case');
                                                                    } elseif ($payment->payment_from == 'pre_service') {
                                                                        $from = lang('pre_surgery') . ' ' . lang('service');
                                                                    } elseif ($payment->payment_from == 'post_service') {
                                                                        $from = lang('post_surgery') . ' ' . lang('service');
                                                                    } elseif ($payment->payment_from == 'surgery') {
                                                                        $from = lang('surgery');
                                                                    } elseif ($payment->payment_from == 'pre_surgery_medical_analysis') {
                                                                        $from = lang('pre_surgery') . ' ' . lang('medical_analysis');
                                                                    } elseif ($payment->payment_from == 'post_surgery_medical_analysis') {
                                                                        $from = lang('post_surgery') . ' ' . lang('medical_analysis');
                                                                    } elseif ($payment->payment_from == 'pre_surgery_medicine') {
                                                                        $from = lang('pre_surgery') . ' ' . lang('medicine');
                                                                    } elseif ($payment->payment_from == 'post_surgery_medicine') {
                                                                        $from = lang('post_surgery') . ' ' . lang('medicine');
                                                                    }
                                                                    echo $from;
                                                                    ?></td>
                                                                <td><?php
                                                                    $amount[] = $payment->amount;
                                                                    echo $settings->currency . ' ' . $payment->amount;
                                                                    ?></td>
                                                                <td><?php
                                                                    $discount = $payment->discount;
                                                                    if (empty($discount)) {
                                                                        $discount = 0;
                                                                    }
                                                                    $discount_up[] = $payment->discount;
                                                                    echo $settings->currency . ' ' . $discount;
                                                                    ?></td>
                                                                <td><?php
                                                                    $gross[] = $payment->gross_total;
                                                                    echo $settings->currency . ' ' . $payment->gross_total;
                                                                    ?></td>
                                                                <td><?php
                                                                    $deposit[] = $this->finance_model->getDepositAmountByPaymentId($payment->id);
                                                                    echo $settings->currency . ' ' . $this->finance_model->getDepositAmountByPaymentId($payment->id);
                                                                    ?></td>
                                                                <td><?php echo $settings->currency . ' ' . ($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id)); ?></td>

                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>

                                            </tbody>

                                            <tfoot>
                                                <tr>
                                                    <td></td><td></td><td><b><h4><?php echo lang('total'); ?></h4></b></td><td></td>
                                                    <td><?php echo $settings->currency . ' ' . array_sum($amount); ?></td>
                                                    <td><?php echo $settings->currency . ' ' . array_sum($discount_up); ?></td>
                                                    <td><?php echo $settings->currency . ' ' . array_sum($gross); ?></td>
                                                    <td><?php echo $settings->currency . ' ' . array_sum($deposit); ?></td>
                                                    <td><?php echo $settings->currency . ' ' . (array_sum($gross) - array_sum($deposit)); ?></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                </section>
                                <!-- page end-->
                                </section>
                                </section>
                                <!--main content end-->
                                <!--footer start-->



                                <script src="common/js/codearistos.min.js"></script>
                                <script>
                                    $(document).ready(function () {
                                        $(".flashmessage").delay(3000).fadeOut(100);
                                    });</script>



                                <script>


                                    $(document).ready(function () {
                                        var table = $('#editable-sample').DataTable({
                                            responsive: true,
                                            //   dom: 'lfrBtip',

                                            "processing": true,
                                            "serverSide": false,
                                            "searchable": true,

                                            scroller: {
                                                loadingIndicator: true
                                            },
                                            dom: "<'row'<'col-md-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
                                                    "<'row'<'col-sm-12'tr>>" +
                                                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",

                                            buttons: [
                                                {extend: 'copyHtml5', exportOptions: {columns: [1, 2, 3, 4, 5, 6, 7, 8, 9], }},
                                                {extend: 'excelHtml5', exportOptions: {columns: [1, 2, 3, 4, 5, 6, 7, 8, 9], }},
                                                {extend: 'csvHtml5', exportOptions: {columns: [1, 2, 3, 4, 5, 6, 7, 8, 9], }},
                                                {extend: 'pdfHtml5', exportOptions: {columns: [1, 2, 3, 4, 5, 6, 7, 8, 9], }},
                                                {extend: 'print', exportOptions: {columns: [1, 2, 3, 4, 5, 6, 7, 8, 9], }},
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
                                                "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json"
                                            }
                                        });
                                        table.buttons().container().appendTo('.custom_buttons');
                                    });
                                </script>
                              