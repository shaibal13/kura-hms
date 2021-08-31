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
        $permis_3 = '';
        $permis_p = '';
        $permis_p_2 = '';
        $permis_p_3 = '';
        $permis_pr = '';
        $permis_pr_2 = '';
        $permis_pr_3 = '';
        $permis_b = '';
        $permis_b_2 = '';
        $permis_b_3 = '';
        $permis_s_2 = '';
        $permis_s = '';
        $permis_s_3 = '';
        foreach ($permission_access_group_explode as $perm) {
            $perm_explode = array();
            $perm_explode = explode(",", $perm);
            if (in_array('1', $perm_explode) && $perm_explode[0] == 'Appointment') {
                $permis = 'ok';
                //  break;
            }
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Appointment') {
                $permis_2 = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Appointment') {
                $permis_3 = 'ok';
                //  break;
            }
            if (in_array('1', $perm_explode) && $perm_explode[0] == 'Patient') {
                $permis_p = 'ok';
                //  break;
            }
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Patient') {
                $permis_p_2 = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Patient') {
                $permis_p_3 = 'ok';
                //  break;
            }

            if (in_array('1', $perm_explode) && $perm_explode[0] == 'Prescription') {
                $permis_pr = 'ok';
                //  break;
            }
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Prescription') {
                $permis_pr_2 = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Prescription') {
                $permis_pr_3 = 'ok';
                //  break;
            }
            if (in_array('1', $perm_explode) && $perm_explode[0] == 'Bed') {
                $permis_b = 'ok';
                //  break;
            }
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Bed') {
                $permis_b_2 = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Bed') {
                $permis_b_3 = 'ok';
                //  break;
            }
            if (in_array('1', $perm_explode) && $perm_explode[0] == 'Surgery') {
                $permis_s = 'ok';
                //  break;
            }
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Surgery') {
                $permis_s_2 = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Surgery') {
                $permis_s_3 = 'ok';
                //  break;
            }
        }
        ?>
        <section class="col-md-3">
            <header class="panel-heading clearfix">
                <div class="">
                    <?php echo lang('patient'); ?> <?php echo lang('info'); ?>
                </div>

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

                .input-category {
                    border: none !important;
                }

                .price-indivudual {
                    border: none !important;
                }

                .from_where {
                    border: none !important;
                }
                .discount-price-case{
                    border: none !important;
                }
            </style>

            <aside class="profile-nav">
                <section class="">
                    <div class="user-heading round">
                        <?php if (!empty($patient->img_url)) { ?>
                            <a href="#">
                                <img src="<?php echo $patient->img_url; ?>" alt="">
                            </a>
                        <?php } ?>
                        <h1> <?php echo $patient->name; ?> </h1>
                        <p> <?php echo $patient->email; ?> </p>
                        <?php if (!$this->ion_auth->in_group(array('Patient'))) { ?>
                            <button type="button" class="btn btn-info btn-xs btn_width editPatient" title="<?php echo lang('edit'); ?>" data-toggle="modal" data-id="<?php echo $patient->id; ?>"><i class="fa fa-edit"> </i> <?php echo lang('edit'); ?></button>
                        <?php } ?>
                    </div>

                    <ul class="nav nav-pills nav-stacked">
                        <!--  <li class="active"> <?php echo lang('patient'); ?> <?php echo lang('name'); ?><span class="label pull-right r-activity"><?php echo $patient->name; ?></span></li> -->
                        <li> <?php echo lang('patient_id'); ?> <span class="label pull-right r-activity"><?php echo $patient->id; ?></span></li>
                        <li> <?php echo lang('gender'); ?><span class="label pull-right r-activity"><?php echo $patient->sex; ?></span></li>
                        <li> <?php echo lang('birth_date'); ?><span class="label pull-right r-activity"><?php echo $patient->birthdate; ?></span></li>
                        <li> <?php echo lang('phone'); ?><span class="label pull-right r-activity"><?php echo $patient->phone; ?></span></li>
                        <li> <?php echo lang('email'); ?><span class="label pull-right r-activity"><?php echo $patient->email; ?></span></li>
                        <li style="height: 200px;"> <?php echo lang('address'); ?><span class="pull-right" style="height: 200px;"><?php echo $patient->address; ?></span></li>

                    </ul>

                </section>
            </aside>


        </section>





        <section class="col-md-9">
            <header class="panel-heading clearfix">
                <div class="col-md-7">
                    <?php echo lang('history'); ?> | <?php echo $patient->name; ?>
                </div>
            </header>

            <section class="panel-body">
                <header class="panel-heading tab-bg-dark-navy-blueee">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#appointments"><?php echo lang('appointments'); ?></a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#home"><?php echo lang('case_history'); ?></a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#about"><?php echo lang('prescription'); ?></a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#lab"><?php echo lang('lab'); ?></a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#profile"><?php echo lang('documents'); ?></a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#contact"><?php echo lang('bed'); ?></a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#emergency-med"><?php echo lang('emergency-med'); ?></a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#surgery"><?php echo lang('surgery'); ?></a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#timeline"><?php echo lang('timeline'); ?></a>
                        </li>
                    </ul>
                </header>
                <div class="panel">
                    <div class="tab-content">

                        <div id="appointments" class="tab-pane active">
                            <div class="">
                                <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Doctor', 'Laboratorist')) || $permis_2 == 'ok') { ?>
                                    <div class=" no-print">
                                        <a class="btn btn-info btn_width btn-xs" data-toggle="modal" href="#addAppointmentModal">
                                            <i class="fa fa-plus-circle"> </i> <?php echo lang('add_new'); ?>
                                        </a>
                                    </div>
                                    <?php
                                }
                                if ($this->ion_auth->in_group(array('Patient'))) {
                                    ?>
                                    <div class=" no-print">
                                        <a class="btn btn-info btn_width btn-xs" data-toggle="modal" href="#addAppointmentModal">
                                            <i class="fa fa-plus-circle"> </i> <?php echo lang('request_a_appointment'); ?>
                                        </a>
                                    </div>
                                <?php } ?>
                                <div class="adv-table editable-table ">
                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th><?php echo lang('date'); ?></th>
                                                <th><?php echo lang('time_slot'); ?></th>
                                                <th><?php echo lang('doctor'); ?></th>
                                                <th> <?php echo lang('payment'); ?> <?php echo lang('status'); ?></th>
                                                <th><?php echo lang('status'); ?></th>
                                                <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Doctor', 'Laboratorist', 'Patient')) || $permis_2 == 'ok') { ?>
                                                    <th class="no-print"><?php echo lang('options'); ?></th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($appointments as $appointment) { ?>
                                                <tr class="">

                                                    <td><?php echo date('d-m-Y', $appointment->date); ?></td>
                                                    <td><?php echo $appointment->time_slot; ?></td>
                                                    <td>
                                                        <?php
                                                        $doctor_details = $this->doctor_model->getDoctorById($appointment->doctor);
                                                        if (!empty($doctor_details)) {
                                                            $appointment_doctor = $doctor_details->name;
                                                        } else {
                                                            $appointment_doctor = '';
                                                        }
                                                        echo $appointment_doctor;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($appointment->payment_status == 'paid') {
                                                            $payment_status = lang('paid');
                                                        } else {
                                                            $payment_status = lang('unpaid');
                                                        }
                                                        echo $payment_status;
                                                        ?>
                                                    </td>
                                                    <td><?php
                                                        if ($appointment->status == 'Pending Confirmation') {
                                                            $appointment_status = lang('pending_confirmation');
                                                        } elseif ($appointment->status == 'Confirmed') {
                                                            $appointment_status = lang('confirmed');
                                                        } elseif ($appointment->status == 'Treated') {
                                                            $appointment_status = lang('treated');
                                                        } elseif ($appointment->status == 'Cancelled') {
                                                            $appointment_status = lang('cancelled');
                                                        } elseif ($appointment->status == 'Requested') {
                                                            $appointment_status = lang('requested');
                                                        }
                                                        echo $appointment_status;
                                                        ?></td>
                                                    <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Doctor', 'Laboratorist', 'Patient')) || $permis_2 == 'ok' || $permis_3 == 'ok') { ?>
                                                        <td class="no-print">
                                                            <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Doctor', 'Laboratorist')) || $permis_2 == 'ok') { ?>

                                                                <button type="button" class="btn btn-info btn-xs btn_width editAppointmentButton" title="<?php echo lang('edit'); ?>" data-toggle="modal" data-id="<?php echo $appointment->id; ?>"><i class="fa fa-edit"></i> </button>
                                                            <?php } ?>
                                                            <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Doctor', 'Laboratorist')) || $permis_3 == 'ok') { ?>
                                                                <a class="btn btn-info btn-xs btn_width delete_button" title="<?php echo lang('delete'); ?>" href="appointment/delete?id=<?php echo $appointment->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>
                                                            <?php } ?>
                                                            <?php if (!$this->ion_auth->in_group(array('Doctor')) && $appointment->status == 'Confirmed') { ?>
                                                                <a class="btn btn-info btn-xs btn_width" href="patient/myInvoice?id=<?php echo $appointment->payment_id ?>"><i class="fa fa-file-invoice"> </i></a>
                                                            <?php } ?>
                                                        </td>
                                                    <?php } ?>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="home" class="tab-pane">
                            <div class="">

                                <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Doctor', 'Laboratorist')) || $permis_p_2 == 'ok') { ?>
                                    <div class=" no-print">
                                        <a class="btn btn-info btn_width btn-xs" data-toggle="modal" href="#myModal">
                                            <i class="fa fa-plus-circle"> </i> <?php echo lang('add_new'); ?>
                                        </a>
                                    </div>
                                <?php } ?>

                                <div class="adv-table editable-table ">


                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th><?php echo lang('date'); ?></th>
                                                <th><?php echo lang('title'); ?></th>
                                                <th><?php echo lang('description'); ?></th>
                                                <th style=""><?php echo lang('status'); ?> </th>
                                                <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Doctor', 'Laboratorist')) || $permis_p_2 == 'ok' || $permis_p_3 == 'ok') { ?>
                                                    <th class="no-print"><?php echo lang('options'); ?></th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($medical_histories as $medical_history) { ?>
                                                <tr class="">

                                                    <td><?php echo date('d-m-Y', $medical_history->date); ?></td>
                                                    <td><?php echo $medical_history->title; ?></td>
                                                    <td><?php
                                                        $description = array();
                                                        $option_description = '';
                                                        $descriptions = explode('##', $medical_history->description);
                                                        foreach ($descriptions as $description) {
                                                            $description_single = array();
                                                            $description_single = explode('**', $description);
                                                            if ($description_single[0] == 'Package') {
                                                                $option_description .= '<ul><li>' . $description_single[0] . '-' . $description_single[1] . '</li></ul>';
                                                            } else {
                                                                $option_description .= '<ul><li>' . $description_single[1] . '</li></ul>';
                                                            }
                                                        }
                                                        echo $option_description;
                                                        ?></td>
                                                    <td><?php
                                                        if ($medical_history->status == 'Pending Confirmation') {
                                                            $status = lang('pending_confirmation');
                                                        }
                                                        if ($medical_history->status == 'Confirmed') {
                                                            $status = lang('confirmed');
                                                        }
                                                        echo $status;
                                                        ?></td>
                                                    <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Doctor', 'Laboratorist')) || $permis_p_2 == 'ok' || $permis_p_3 == 'ok') { ?>
                                                        <td class="no-print">
                                                            <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Doctor', 'Laboratorist')) || $permis_p_2 == 'ok') { ?>
                                                                <a class="btn btn-info btn-xs btn_width" title="<?php echo lang('edit'); ?>" href="patient/editCaseHistory?id=<?php echo $medical_history->id; ?>"><i class="fa fa-edit"></i> </a>
                                                                <!--  <button type="button" class="btn btn-info btn-xs btn_width editbutton" title="<?php echo lang('edit'); ?>" data-toggle="modal" data-id="<?php echo $medical_history->id; ?>"><i class="fa fa-edit"></i> </button>   -->
                                                            <?php } ?>
                                                            <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Doctor', 'Laboratorist')) || $permis_p_3 == 'ok') { ?>
                                                                <a class="btn btn-info btn-xs btn_width delete_button" title="<?php echo lang('delete'); ?>" href="patient/deleteCaseHistory?id=<?php echo $medical_history->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>
                                                            <?php } ?>
                                                            <?php if ($medical_history->status == 'Confirmed') { ?>
                                                                <a class="btn btn-success btn-xs btn_width" title="<?php echo lang('invoice'); ?>" href="finance/invoice?id=<?php echo $medical_history->payment_id; ?>"><i class="fa fa-file-invoice"></i> </a>
                                                            <?php } ?>
                                                        </td>
                                                    <?php } ?>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>




                                    <!--
                                                                        <form role="form" action="patient/addMedicalHistory" class="clearfix" method="post" enctype="multipart/form-data">
                                                                            <div class="form-group col-md-12">
                                                                                <label class=""> <?php echo lang('case'); ?> <?php echo lang('history'); ?></label>
                                                                                <div class="">
                                                                                    <textarea class="ckeditor form-control" name="description" id="description" value="" rows="100" cols="50">      
                                    <?php foreach ($medical_histories as $medical_history) { ?>         
                                                                                                                                                                                                                                                                                                    <td><?php echo $medical_history->description; ?></td>
                                    <?php } ?>
                                                                                    </textarea>
                                                                                </div>
                                                                            </div>
                                    
                                                                            <input type="hidden" name="patient_id" value='<?php echo $patient->id; ?>'>
                                                                            <input type="hidden" name="id" value='<?php echo $medical_history->id ?>'>
                                                                            <div class="form-group col-md-12">
                                                                                <button type="submit" name="submit" class="btn btn-info submit_button pull-right"><?php echo lang('save'); ?></button>
                                                                            </div>
                                                                        </form>
                                    
                                    -->



                                </div>
                            </div>
                        </div>

                        <div id="about" class="tab-pane">
                            <div class="">
                                <?php if ($this->ion_auth->in_group(array('Doctor')) || $permis_pr_2 == 'ok') { ?>
                                    <div class=" no-print">
                                        <a class="btn btn-info btn_width btn-xs" href="prescription/addPrescriptionView">
                                            <i class="fa fa-plus-circle"> </i> <?php echo lang('add_new'); ?>
                                        </a>
                                    </div>
                                <?php } ?>
                                <div class="adv-table editable-table ">
                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>

                                                <th><?php echo lang('date'); ?></th>
                                                <th><?php echo lang('doctor'); ?></th>
                                                <th><?php echo lang('medicine'); ?></th>
                                                <th class="no-print"><?php echo lang('options'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($prescriptions as $prescription) { ?>
                                                <tr class="">
                                                    <td><?php echo date('m/d/Y', $prescription->date); ?></td>
                                                    <td>
                                                        <?php
                                                        $doctor_details = $this->doctor_model->getDoctorById($prescription->doctor);
                                                        if (!empty($doctor_details)) {
                                                            $prescription_doctor = $doctor_details->name;
                                                        } else {
                                                            $prescription_doctor = '';
                                                        }
                                                        echo $prescription_doctor;
                                                        ?>

                                                    </td>
                                                    <td>

                                                        <?php
                                                        if (!empty($prescription->medicine)) {
                                                            $medicine = explode('###', $prescription->medicine);

                                                            foreach ($medicine as $key => $value) {
                                                                $medicine_id = explode('***', $value);
                                                                $medicine_details = $this->medicine_model->getMedicineById($medicine_id[0]);
                                                                if (!empty($medicine_details)) {
                                                                    $medicine_name_with_dosage = $medicine_details->name . ' -' . $medicine_id[1];
                                                                    $medicine_name_with_dosage = $medicine_name_with_dosage . ' | ' . $medicine_id[3] . '<br>';
                                                                    rtrim($medicine_name_with_dosage, ',');
                                                                    echo '<p>' . $medicine_name_with_dosage . '</p>';
                                                                }
                                                            }
                                                        }
                                                        ?>


                                                    </td>

                                                    <td class="no-print">
                                                        <a class="btn-xs green" href="prescription/viewPrescription?id=<?php echo $prescription->id; ?>"><i class="fa fa-eye"> <?php echo lang('view'); ?> </i></a>
                                                        <?php
                                                        if ($this->ion_auth->in_group('Doctor') || $permis_pr_2 == 'ok' || $permis_pr_3 == 'ok') {
                                                            if ($this->ion_auth->in_group('Doctor')) {
                                                                $current_user = $this->ion_auth->get_user_id();
                                                                $doctor_table_id = $this->doctor_model->getDoctorByIonUserId($current_user)->id;
                                                            } else {
                                                                $doctor_table_id = '';
                                                            }
                                                            if ($prescription->doctor == $doctor_table_id || $permis_pr_2 == 'ok' || $permis_pr_3 == 'ok') {
                                                                ?>
                                                                <?php if ($this->ion_auth->in_group('Doctor') || $permis_pr_2 == 'ok') { ?>
                                                                    <a type="button" class="btn-info btn-xs btn_width" data-toggle="modal" href="prescription/editPrescription?id=<?php echo $prescription->id; ?>"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?></a>
                                                                <?php } ?>
                                                                <?php if ($this->ion_auth->in_group('Doctor') || $permis_pr_3 == 'ok') { ?>
                                                                    <a class="btn-info btn-xs btn_width delete_button" href="prescription/delete?id=<?php echo $prescription->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> <?php echo lang('delete'); ?></a>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                        <a class="btn-xs invoicebutton" title="<?php echo lang('print'); ?>" style="color: #fff;" href="prescription/viewPrescriptionPrint?id=<?php echo $prescription->id; ?>" target="_blank"> <i class="fa fa-print"></i> <?php echo lang('print'); ?></a>
                                                    </td>

                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div id="lab" class="tab-pane">
                            <div class="">
                                <div class="adv-table editable-table ">
                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th><?php echo lang('id'); ?></th>
                                                <th><?php echo lang('date'); ?></th>
                                                <th><?php echo lang('doctor'); ?></th>
                                                <th class="no-print"><?php echo lang('options'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($labs as $lab) { ?>
                                                <tr class="">
                                                    <td><?php echo $lab->id; ?></td>
                                                    <td><?php echo date('m/d/Y', $lab->date); ?></td>
                                                    <td>
                                                        <?php
                                                        $doctor_details = $this->doctor_model->getDoctorById($lab->doctor);
                                                        if (!empty($doctor_details)) {
                                                            $lab_doctor = $doctor_details->name;
                                                        } else {
                                                            $lab_doctor = '';
                                                        }
                                                        echo $lab_doctor;
                                                        ?>
                                                    </td>
                                                    <td class="no-print">
                                                        <a class="btn btn-info btn-xs btn_width" href="lab/invoice?id=<?php echo $lab->id; ?>"><i class="fa fa-eye"> <?php echo lang('report'); ?> </i></a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div id="profile" class="tab-pane">
                            <div class="">
                                <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Doctor', 'Laboratorist')) || $permis_p_2 == 'ok') { ?>
                                    <div class=" no-print">
                                        <a class="btn btn-info btn_width btn-xs" data-toggle="modal" href="#myModal1">
                                            <i class="fa fa-plus-circle"> </i> <?php echo lang('add_new'); ?>
                                        </a>
                                    </div>
                                <?php } ?>
                                <div class="adv-table editable-table ">
                                    <div class="">
                                        <?php foreach ($patient_materials as $patient_material) { ?>
                                            <div class="panel col-md-3" style="height: 200px; margin-right: 10px; margin-bottom: 36px; background: #f1f1f1; padding: 34px;">

                                                <div>
                                                    <?php
                                                    $extension_url = explode(".", $patient_material->url);

                                                    $length = count($extension_url);
                                                    $extension = $extension_url[$length - 1];

                                                    if (strtolower($extension) == 'pdf') {
                                                        ?>
                                                        <a class="example-image-link" href="<?php echo $patient_material->url; ?>" target="_blank">
                                                            <img class="example-image" src="uploads/image/pdf.png" height="100" width="100" /></a>
                                                        <?php
                                                    } elseif (strtolower($extension) == 'docx') {
                                                        ?>

                                                        <a class="example-image-link" href="<?php echo $patient_material->url; ?>" target="_blank">
                                                            <img class="example-image" src="uploads/image/docx.png" height="100" width="100" /></a>
                                                        <?php
                                                    } elseif (strtolower($extension) == 'doc') {
                                                        ?>

                                                        <a class="example-image-link" href="<?php echo $patient_material->url; ?>" target="_blank">
                                                            <img class="example-image" src="uploads/image/doc.png" height="100" width="100" /></a>
                                                        <?php
                                                    } elseif (strtolower($extension) == 'odt') {
                                                        ?>

                                                        <a class="example-image-link" href="<?php echo $patient_material->url; ?>" target="_blank">
                                                            <img class="example-image" src="uploads/image/odt.png" height="100" width="100" /></a>
                                                    <?php } else {
                                                        ?>
                                                        <a class="example-image-link" href="<?php echo $patient_material->url; ?>" data-lightbox="example-1">
                                                            <img class="example-image" src="<?php echo $patient_material->url; ?>" alt="image-1" height="100" width="100" /></a>
                                                    <?php }
                                                    ?>

                                                                    <!--  <img src="<?php echo $patient_material->url; ?>" height="100" width="100">-->
                                                </div>
                                                <div class="post-info" style="text-align:center !important;">
                                                    <?php
                                                    if (!empty($patient_material->title)) {
                                                        echo $patient_material->title;
                                                    }
                                                    ?>

                                                </div>
                                                <p></p>
                                                <div class="post-info" style="font-family: sans-serif !important ;">
                                                    <div style="display:inline-block !important;">
                                                        <a class="btn btn-info btn-xs btn_width" href="<?php echo $patient_material->url; ?>" download> <?php echo lang('download'); ?> </a>
                                                    </div>
                                                    <?php if (!$this->ion_auth->in_group(array('Patient')) || $permis_p_3 == 'ok') { ?>
                                                        <div style="display:inline-block !important;">
                                                            <a class="btn btn-info btn-xs btn_width" title="<?php echo lang('delete'); ?>" href="patient/deletePatientMaterial?id=<?php echo $patient_material->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"> X </a>
                                                        </div>
                                                    <?php } ?>

                                                </div>

                                                <hr>

                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="contact" class="tab-pane">
                            <div class="">
                                <?php if ($this->ion_auth->in_group(array('Doctor')) || $permis_b_2 == 'ok') { ?>
                                    <div class=" no-print">
                                        <a class="btn btn-info btn_width btn-xs" data-toggle="modal" href="#myModal3">
                                            <i class="fa fa-plus-circle"> </i> <?php echo lang('add_new'); ?>
                                        </a>
                                    </div>
                                <?php } ?>
                                <div class="adv-table editable-table ">
                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th><?php echo lang('bed_id'); ?></th>
                                                <th><?php echo lang('alloted_time'); ?></th>
                                                <th><?php echo lang('discharge_time'); ?></th>
                                                <th><?php echo lang('view_more'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <style>
                                            .img_url {
                                                height: 20px;
                                                width: 20px;
                                                background-size: contain;
                                                max-height: 20px;
                                                border-radius: 100px;
                                            }
                                        </style>

                                        <?php foreach ($beds as $bed) { ?>
                                            <tr class="">
                                                <td><?php echo $bed->bed_id; ?></td>
                                                <td><?php echo $bed->a_time; ?></td>
                                                <td><?php echo $bed->d_time; ?></td>
                                                <td> <a class="btn btn-info btn-xs btn_width" href="bed/bedAllotmentDetails?id=<?php echo $bed->id; ?>"> <?php echo lang('more'); ?></a></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div id="emergency-med" class="tab-pane">
                            <div class="">
                                <div class="">
                                    <section class="panel ">
                                        <header class="panel-heading">
                                            Emergency
                                        </header>
                                        <div class="">
                                            <!-- Save BTN -->
                                            <div class="col-md-12 pull-right">
                                                <button style="display: block;" id="save_button" type="submit" name="submit" class="btn btn-xs btn-info pull-right"><i class="fa fa-save"></i> <?php echo lang('save'); ?></button>
                                            </div>
                                            <br>

                                            <div class="adv-table editable-table ">
                                                <table style="width: 100% !important;" class="table table-striped table-hover table-bordered" id="editable-table1">
                                                    <thead>
                                                        <tr>

                                                            <th><?php echo lang('date'); ?></th>
                                                            <th><?php echo lang('medicine_gen_name'); ?></th>
                                                            <th><?php echo lang('medicine'); ?> <?php lang('name'); ?></th>
                                                            <th><?php echo lang('sales'); ?> <?php lang('price'); ?></th>
                                                            <th><?php echo lang('quantity'); ?></th>
                                                            <th><?php echo lang('total'); ?></th>
                                                            <?php if (empty($allotment->d_time) || $this->ion_auth->in_group(array('admin'))) { ?>
                                                                <th class="no-print"><?php echo lang('options'); ?></th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="medicine_table">
                                                        <?php foreach ($daily_medicine as $medicine) { ?>
                                                            <tr id="<?php echo $medicine->id; ?>">
                                                                <td><?php echo $medicine->date; ?></td>
                                                                <td><?php echo $medicine->generic_name; ?></td>
                                                                <td><?php echo $medicine->medicine_name; ?></td>
                                                                <td><?php echo $settings->currency . $medicine->s_price; ?></td>
                                                                <td><?php echo $medicine->quantity; ?></td>
                                                                <td><?php echo $settings->currency . $medicine->total; ?></td>
                                                                <?php if ((empty($allotment->d_time) && empty($medicine->payment_id)) || $this->ion_auth->in_group(array('admin'))) { ?>
                                                                    <td class="no-print" id="delete-<?php echo $medicine->id; ?>"><button type='button' class='btn btn-danger btn-xs btn_width delete_medicine' title='<?php echo lang('delete'); ?>' data-toggle='' data-id="<?php echo $medicine->id; ?>"><i class='fa fa-trash'></i></button></td>
                                                                <?php } ?>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php if (empty($allotment->d_time) || $this->ion_auth->in_group(array('admin'))) { ?>
                                                <div>
                                                    <label>---------------------------------------------------------------------------------------<?php echo "Select Medicine" ?>-----------------------------------------------------------------------</label>
                                                    <form role="form" action="" id="editMedicine" class="clearfix" method="post" enctype="multipart/form-data">
                                                        <div class="form-group col-md-12">

                                                            <div class="col-md-3">

                                                                <select style=" display: block;" class="form-control m-bot15" id="generic_name" name="generic_name" value='' required="">

                                                                </select>
                                                            </div>
                                                            <div class="col-md-3">

                                                                <select style="display: block;" class="form-control m-bot15" id="medicines_option" name="medicine_name" value='' required="">

                                                                </select>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <input style="display: block;height: 37px;
                                                                       width: 283%;border: 1px solid;" class="input-md" type="text" id="sales_price" name="sales_price" value="" placeholder="<?php echo lang('sales'); ?>" readonly="">
                                                            </div>
                                                            <div class="col-md-1">

                                                                <input style="height: 37px;
                                                                       width: 283%;display: block;border: 1px solid;" class="input-md" id="quantity" type="number" placeholder="<?php echo lang('quantity'); ?>" name="quantity" value="">
                                                            </div>
                                                            <div class="col-md-1">

                                                                <input style="display: block;height: 37px;
                                                                       width: 283%;border: 1px solid;" class="input-md" type="text" id="total" name="total" value="" placeholder="<?php echo lang('total'); ?>" readonly="">
                                                            </div>
                                                            <input type="hidden" id="alloted" name="alloted_bed_id" value="<?php
                                                            if (!empty($allotment->id)) {
                                                                echo $allotment->id;
                                                            }
                                                            ?>">
                                                            <div class="col-md-2">

                                                                <button style="display: block;" type="submit" name="submit" class="btn btn-xs btn-info pull-right"><i class="fa fa-save"></i></button>

                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>
                                            <?php } ?>
                                        </div>

                                    </section>
                                </div>
                            </div>
                        </div>

                        <div id="timeline" class="tab-pane">
                            <div class="">
                                <div class="">
                                    <section class="panel ">
                                        <header class="panel-heading">
                                            Timeline
                                        </header>
                                        <!--
                                            <div class=" profile-activity" >
                                                <h5 class="pull-right">12 August 2013</h5>
                                                <div class="activity terques">
                                                    <span>
                                                        <i class="fa fa-shopping-cart"></i>
                                                    </span>
                                                    <div class="activity-desk">
                                                        <div class="panel">
                                                            <div class="">
                                                                <div class="arrow"></div>
                                                                <i class=" fa fa-clock-o"></i>
                                                                <h4>10:45 AM</h4>
                                                                <p>Purchased new equipments for zonal office setup and stationaries.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        -->

                                        <?php
                                        if (!empty($timeline)) {
                                            krsort($timeline);
                                            foreach ($timeline as $key => $value) {
                                                echo $value;
                                            }
                                        }
                                        ?>

                                    </section>
                                </div>
                            </div>
                        </div>

                        <div id="surgery" class="tab-pane">
                            <div class="">
                                <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Doctor', 'Laboratorist', 'Receptionist')) || $permis_s_2 == 'ok') { ?>
                                    <div class=" no-print">
                                        <a class="btn btn-info btn_width btn-xs" data-toggle="modal" href="#myModalSurgery">
                                            <i class="fa fa-plus-circle"> </i> <?php echo lang('add_new'); ?>
                                        </a>
                                    </div>
                                <?php } ?>
                                <div class="adv-table editable-table ">
                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th><?php echo lang('time_to_be_done'); ?></th>
                                                <th><?php echo lang('title'); ?></th>
                                                <th><?php echo lang('price'); ?></th>
                                                <th style=""><?php echo lang('status'); ?> </th>
                                                <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Doctor', 'Laboratorist')) || $permis_s_2 == 'ok' || $permis_s_3 == 'ok') { ?>
                                                    <th class="no-print"><?php echo lang('options'); ?></th>
                                                <?php } ?>

                                            </tr>
                                        </thead>
                                        <tbody>

                                        <style>
                                            .img_url {
                                                height: 20px;
                                                width: 20px;
                                                background-size: contain;
                                                max-height: 20px;
                                                border-radius: 100px;
                                            }
                                        </style>

                                        <?php foreach ($surgeries as $surgery) { ?>
                                            <tr class="">
                                                <td><?php echo $surgery->time_to_be_done; ?></td>
                                                <td><?php echo $surgery->title; ?></td>
                                                <td><?php echo $settings->currency; ?> <?php echo $surgery->total_price; ?></td>
                                                <td><?php
                                                    if ($surgery->status == 'Pending Confirmation') {
                                                        $status = lang('pending_confirmation');
                                                    }
                                                    if ($surgery->status == 'Confirmed') {
                                                        $status = lang('confirmed');
                                                    }
                                                    echo $status;
                                                    ?></td>
                                                <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Doctor', 'Laboratorist')) || $permis_s_2 == 'ok' || $permis_s_3 == 'ok') { ?>
                                                    <td> <a class="btn btn-info btn-xs btn_width" href="surgery/surgeryDetails?id=<?php echo $surgery->id; ?>"> <?php echo lang('more'); ?></a>
                                                        <a class="btn btn-success btn-xs btn_width" href="surgery/editSurgery?id=<?php echo $surgery->id; ?>"> <?php echo lang('edit'); ?></a>
                                                        <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Doctor', 'Laboratorist')) || $permis_s_3 == 'ok') { ?>
                                                            <a class="btn btn-danger btn-xs btn_width" title="<?php echo lang('delete'); ?>" href="surgery/deleteSurgery?id=<?php echo $surgery->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>
                                                        <?php } ?>
                                                        <a class="btn btn-info btn-xs" title="<?php echo lang('invoice'); ?>" style="color: #fff;margin-bottom: 20px;" href="finance/invoice?id=<?php echo $surgery->payment_id; ?>" target="_blank"> <i class="fa fa-file-invoice"></i> <?php echo lang('invoice'); ?></a>
                                                    </td>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>



                </div>
            </section>

        </section>



    </section>
    <!-- page end-->
</section>
</section>
<!--main content end-->
<!--footer start-->




<!-- Add Patient Material Modal-->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('add'); ?> <?php echo lang('files'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="patient/addPatientMaterial" class="clearfix row" method="post" enctype="multipart/form-data">

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('title'); ?></label>
                        <input type="text" class="form-control" name="title" id="exampleInputEmail1" placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('file'); ?></label>
                        <input type="file" name="img_url">
                    </div>

                    <input type="hidden" name="patient" value='<?php echo $patient->id; ?>'>

                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Patient Modal-->


<!-- Add Medical History Modal-->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 64% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('add_case'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="patient/addMedicalHistory" class="clearfix row" method="post" enctype="multipart/form-data">
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('date'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium default-date-picker" name="date" id="exampleInputEmail1" value='' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('title'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium" name="title" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"> <?php echo lang('status'); ?></label>
                        <select class="form-control m-bot15" name="status" value=''>
                            <option value="Pending Confirmation"> <?php echo lang('pending_confirmation'); ?> </option>
                            <option value="Confirmed"> <?php echo lang('confirmed'); ?> </option>

                        </select>
                    </div>
                    <input type="hidden" name="patient_id" value='<?php echo $patient->id; ?>'>
                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="redirect" value='case_list_history'>
                    <div class="adv-table editable-table ">
                        <table style="width: 100% !important;" class="table table-striped table-hover table-bordered" id="editable-table2">
                            <thead>
                                <tr>
                                    <th style=""><?php echo lang('items'); ?></th>
                                    <th style=""><?php echo lang('type'); ?></th>
                                    <th style=""><?php echo lang('price'); ?></th>
                                    <th style=""><?php echo lang('discount'); ?></th>
                                    <th style=";"><?php echo lang('grand_total'); ?></th>
                                    <th style=""><?php echo lang('date_to_be_done'); ?></th>
                                    <th style=""><?php echo lang('status'); ?></th>
                                    <th style="" class="no-print"><?php echo lang('options'); ?></th>

                                </tr>
                            </thead>
                            <tbody id="package_proccedure">

                            </tbody>
                        </table>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"><?php echo lang('total_value'); ?></label>
                            <input type="text" class="form-control total_value_case" name="total_value" id="total_value" value='<?php
                            echo '0';
                            ?>' placeholder="" readonly="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"><?php echo lang('total_discount'); ?></label>
                            <input type="text" class="form-control" name="total_discount" id="total_discount_case" value='<?php
                            echo '0';
                            ?>' placeholder="" readonly="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"><?php echo lang('grand_total'); ?></label>
                            <input type="text" class="form-control" name="grand_total" id="grand_total_case" value='<?php
                            echo '0';
                            ?>' placeholder="" readonly="">
                        </div>
                    </div>
                    <?php if ($this->ion_auth->in_group(array('admin')) || $permis_p_2 == 'ok') { ?>
                        <div class="separator col-md-12"><?php echo lang('select'); ?></div>
                        <br> <br>
                        <div class="col-md-12" style="margin-top:20px;">
                            <div class="col-md-5">

                                <select style=" display: block;" class="form-control m-bot15 js-example-basic-single" id="package" name="package" value='' required="">
                                    <option><?php echo lang('select'); ?> <?php echo lang('packages'); ?></option>
                                    <?php foreach ($packages as $package) { ?>
                                        <option value="<?php echo $package->id;
                                        ?>"><?php echo $package->name; ?></option>
                                            <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-5">

                                <select style=" display: block;" class="form-control m-bot15 js-example-basic-single" id="medical_analysis" name="medical_analysis" value='' required="">
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

                    <!-- <input type="hidden" name="patient_id" value='<?php echo $patient->id; ?>'>
                    <input type="hidden" name="id" value=''>-->
                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info submit_button pull-right">Submit</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- Add Medical History Modal-->

<!-- Edit Medical History Modal-->
<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('edit_case'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="medical_historyEditForm" class="clearfix row" action="patient/addMedicalHistory" method="post" enctype="multipart/form-data">
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('date'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium default-date-picker" name="date" id="exampleInputEmail1" value='' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('title'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium" name="title" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info submit_button pull-right">Submit</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<?php
$current_user = $this->ion_auth->get_user_id();
if ($this->ion_auth->in_group('Doctor')) {
    $doctor_id = $this->db->get_where('doctor', array('ion_user_id' => $current_user))->row()->id;
}
?>


<!-- Add Appointment Modal-->
<div class="modal fade" id="addAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg"">
        <div class=" modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('add_appointment'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="addAppointmentForm" action="appointment/addNew" class="clearfix row" method="post" enctype="multipart/form-data">
                    <div class="col-md-4 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('patient'); ?></label>
                        <select class="form-control m-bot15 js-example-basic-single pos_select" id="pos_select" name="patient" value=''>
                            <option value="">Select .....</option>
                            <option value="<?php echo $patient->id; ?>"><?php echo $patient->name; ?> </option>
                        </select>
                    </div>
                    <div class="col-md-4 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('doctor'); ?></label>
                        <select class="form-control m-bot15" id="adoctors" name="doctor" value=''>

                        </select>
                    </div>


                    <div class="col-md-4 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
                        <input type="text" class="form-control default-date-picker" id="date" readonly="" name="date" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="col-md-6 panel">
                        <label class=""><?php echo lang('available_slots'); ?></label>
                        <select class="form-control m-bot15" name="time_slot" id="aslots" value=''>

                        </select>
                    </div>

                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('appointment'); ?> <?php echo lang('status'); ?></label>
                        <select class="form-control m-bot15" name="status" value=''>

                            <?php if (!$this->ion_auth->in_group('Patient')) { ?>
                                <option value="Pending Confirmation" <?php ?>> <?php echo lang('pending_confirmation'); ?> </option>
                                <option value="Confirmed" <?php ?>> <?php echo lang('confirmed'); ?> </option>
                                <option value="Treated" <?php ?>> <?php echo lang('treated'); ?> </option>
                                <option value="Cancelled" <?php ?>> <?php echo lang('cancelled'); ?> </option>
                            <?php } else { ?>
                                <option value="Requested" <?php ?>> <?php echo lang('requested'); ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('category'); ?> </label>
                        <select class="form-control m-bot15" name="category_appointment" value=''>
                            <option value="Bed Allotment" <?php ?>> <?php echo lang('bed_allotment'); ?> </option>
                            <option value="Ambulator" <?php ?>> <?php echo lang('ambulator'); ?> </option>

                        </select>
                    </div>
                    <div class="col-md-6 panel">

                        <label class=""><?php echo lang('visit'); ?> <?php echo lang('description'); ?></label>

                        <select class="form-control m-bot15" name="visit_description" id="visit_description" value=''>

                        </select>

                    </div>






                    <!-- <div class="col-md-5 panel">
                             <input type="checkbox" name="sms" value="sms"> <?php echo lang('send_sms') ?><br>
                         </div>-->
                    <input type="hidden" name="redirectlink" value="med_his">
                    <input type="hidden" name="redirect" value='patient/medicalHistory?id=<?php echo $patient->id; ?>'>

                    <input type="hidden" name="request" value='<?php
                    if ($this->ion_auth->in_group(array('Patient'))) {
                        echo 'Yes';
                    }
                    ?>'>



                    <?php if (!$this->ion_auth->in_group(array('Patient'))) { ?>
                        <div class="col-md-12 panel">
                            <label for="exampleInputEmail1"> <?php echo lang('remarks'); ?></label>
                            <input type="text" class="form-control" name="remarks" id="exampleInputEmail1" value='' placeholder="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"><?php echo lang('visit'); ?> <?php echo lang('charges'); ?></label>
                            <input type="number" class="form-control" name="visit_charges" id="visit_charges" value='' placeholder="" readonly="">
                        </div>
                        <div class="form-group col-md-4" style="padding-top: 20px;">
                            <label for="exampleInputEmail1"><?php echo lang('discount'); ?></label>
                            <input type="number" class="form-control" name="discount" id="discount" value='0' placeholder="">
                        </div>
                        <div class="form-group col-md-4" style="padding-top: 20px;">
                            <label for="exampleInputEmail1"><?php echo lang('grand_total'); ?></label>
                            <input type="number" class="form-control" name="grand_total" id="grand_total" value='0' placeholder="" readonly="">
                        </div>
                    <?php } else { ?>
                        <div class="col-md-8 panel">
                            <label for="exampleInputEmail1"> <?php echo lang('remarks'); ?></label>
                            <input type="text" class="form-control" name="remarks" id="exampleInputEmail1" value='' placeholder="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"><?php echo lang('visit'); ?> <?php echo lang('charges'); ?></label>
                            <input type="number" class="form-control" name="visit_charges" id="visit_charges" value='' placeholder="" readonly="">
                        </div>


                        <input type="hidden" class="form-control" name="discount" id="discount" value='0' placeholder="">

                        <input type="hidden" class="form-control" name="grand_total" id="grand_total" value='0' placeholder="" readonly="">

                    <?php } ?>
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
                                    <?php if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Patient'))) { ?>
                                        <?php if (!$this->ion_auth->in_group(array('Patient'))) { ?>
                                            <option value="Cash"> <?php echo lang('cash'); ?> </option>
                                        <?php } ?>
                                        <?php if ($this->ion_auth->in_group(array('Patient'))) { ?>
                                            <option value="0"> <?php echo lang('select'); ?> </option>
                                        <?php } ?>

                                        <option value="Card"> <?php echo lang('card'); ?> </option>
                                    <?php } ?>

                                </select>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <?php
                            $payment_gateway = $settings->payment_gateway;
                            ?>



                            <div class="card">

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
                                            <option value="American Express"> <?php echo lang('american_express'); ?> </option>
                                        </select>
                                    </div>
                                <?php } ?>
                                <?php if ($payment_gateway == '2Checkout' || $payment_gateway == 'PayPal') {
                                    ?>
                                    <div class="col-md-12 payment pad_bot">
                                        <label for="exampleInputEmail1"> <?php echo lang('cardholder'); ?> <?php echo lang('name'); ?></label>
                                        <input type="text" id="cardholder" class="form-control pay_in" name="cardholder" value='' placeholder="">
                                    </div>
                                <?php } ?>
                                <?php if ($payment_gateway != 'Pay U Money' && $payment_gateway != 'Paystack' && $payment_gateway != 'SSLCOMMERZ' && $payment_gateway != 'Paytm') { ?>
                                    <div class="col-md-12 payment pad_bot">
                                        <label for="exampleInputEmail1"> <?php echo lang('card'); ?> <?php echo lang('number'); ?></label>
                                        <input type="text" id="card" class="form-control pay_in" name="card_number" value='' placeholder="">
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
                                    ?>onClick="stripePay(event);" <?php }
                                ?> <?php if ($settings->payment_gateway == '2Checkout' && $twocheckout->status == 'live') {
                                    ?>onClick="twoCheckoutPay(event);" <?php }
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







<!-- Edit Event Modal-->
<div class="modal fade" id="editAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg"">
        <div class=" modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('edit_appointment'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editAppointmentForm" class="clearfix row" action="appointment/addNew" method="post" enctype="multipart/form-data">
                    <div class="col-md-4 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('patient'); ?></label>
                        <select class="form-control m-bot15 js-example-basic-single pos_select patient" id="pos_select" name="patient" value=''>
                            <option value="">Select .....</option>
                            <option value="<?php echo $patient->id; ?>"><?php echo $patient->name; ?> </option>
                        </select>
                    </div>

                    <div class="col-md-4 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('doctor'); ?></label>
                        <select class="form-control m-bot15 doctor" id="adoctors1" name="doctor" value=''>

                        </select>
                    </div>


                    <div class="col-md-4 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
                        <input type="text" class="form-control default-date-picker" readonly="" id="date1" name="date" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="col-md-6 panel">
                        <label class=""><?php echo lang('available_slots'); ?></label>
                        <select class="form-control m-bot15" name="time_slot" id="aslots1" value=''>

                        </select>
                    </div>

                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('appointment'); ?> <?php echo lang('status'); ?></label>
                        <select class="form-control m-bot15" name="status" value=''>
                            <?php if (!$this->ion_auth->in_group('Patient')) { ?>
                                <option value="Pending Confirmation" <?php ?>> <?php echo lang('pending_confirmation'); ?> </option>
                                <option value="Confirmed" <?php ?>> <?php echo lang('confirmed'); ?> </option>
                                <option value="Treated" <?php ?>> <?php echo lang('treated'); ?> </option>
                                <option value="Cancelled" <?php ?>> <?php echo lang('cancelled'); ?> </option>
                            <?php } else { ?>
                                <option value="Requested" <?php ?>> <?php echo lang('requested'); ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('category'); ?> </label>
                        <select class="form-control m-bot15" name="category_appointment" value=''>
                            <option value="Bed Allotment" <?php
                            ?>> <?php echo lang('bed_allotment'); ?> </option>
                            <option value="Ambulator" <?php ?>> <?php echo lang('ambulator'); ?> </option>

                        </select>
                    </div>





                    <!--   <div class="col-md-6 panel">
                               <input type="checkbox" name="sms" value="sms"> <?php echo lang('send_sms') ?><br>
                           </div>-->

                    <input type="hidden" name="redirectlink" value="med_his">

                    <input type="hidden" name="redirect" value='patient/medicalHistory?id=<?php echo $patient->id; ?>'>>
                    <input type="hidden" name="id" id="appointment_id" value=''>

                    <?php if (!$this->ion_auth->in_group(array('Patient'))) { ?>
                        <div class="col-md-12 panel">
                            <label for="exampleInputEmail1"> <?php echo lang('remarks'); ?></label>
                            <input type="text" class="form-control" name="remarks" id="exampleInputEmail1" value='' placeholder="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"><?php echo lang('visit'); ?> <?php echo lang('charges'); ?></label>
                            <input type="number" class="form-control" name="visit_charges" id="visit_charges1" value='' placeholder="" readonly="">
                        </div>
                        <div class="form-group col-md-4" style="padding-top: 20px;">
                            <label for="exampleInputEmail1"><?php echo lang('discount'); ?></label>
                            <input type="number" class="form-control" name="discount" id="discount1" value='0' placeholder="">
                        </div>
                        <div class="form-group col-md-4" style="padding-top: 20px;">
                            <label for="exampleInputEmail1"><?php echo lang('grand_total'); ?></label>
                            <input type="number" class="form-control" name="grand_total" id="grand_total1" value='0' placeholder="" readonly="">
                        </div>
                    <?php } else { ?>
                        <div class="col-md-8 panel">
                            <label for="exampleInputEmail1"> <?php echo lang('remarks'); ?></label>
                            <input type="text" class="form-control" name="remarks" id="exampleInputEmail1" value='' placeholder="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"><?php echo lang('visit'); ?> <?php echo lang('charges'); ?></label>
                            <input type="number" class="form-control" name="visit_charges" id="visit_charges1" value='' placeholder="" readonly="">
                        </div>


                        <input type="hidden" class="form-control" name="discount" id="discount1" value='0' placeholder="">

                        <input type="hidden" class="form-control" name="grand_total" id="grand_total1" value='0' placeholder="" readonly="">

                    <?php } ?>
                    <?php if (!$this->ion_auth->in_group(array('Nurse', 'Doctor'))) { ?>
                        <div class="col-md-12 hidden pay_now">
                            <input type="checkbox" id="pay_now_appointment1" name="pay_now_appointment" value="pay_now_appointment">
                            <label for=""> <?php echo lang('pay_now'); ?></label><br>
                            <span style="color:red;"><?php echo lang('if_pay_now_checked_please_select_status_to_confirmed') ?></span>
                        </div>
                        <div class="col-md-12 hidden payment_status form-group">
                            <label for=""> <?php echo lang('payment'); ?> <?php echo lang('status'); ?></label><br>
                            <input type="text" class="form-control" id="pay_now_appointment" name="payment_status_appointment" value="paid" readonly="">


                        </div>
                        <div class="payment_label col-md-12 hidden deposit_type1" style="text-align: left !important ;margin: 0% !important ;">
                            <label for="exampleInputEmail1"><?php echo lang('deposit_type'); ?></label>

                            <div class="">
                                <select class="form-control m-bot15 js-example-basic-single selecttype1" id="selecttype1" name="deposit_type" value=''>
                                    <?php if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Patient'))) { ?>
                                        <?php if (!$this->ion_auth->in_group(array('Patient'))) { ?>
                                            <option value="Cash"> <?php echo lang('cash'); ?> </option>
                                        <?php } ?>
                                        <?php if ($this->ion_auth->in_group(array('Patient'))) { ?>
                                            <option value="0"> <?php echo lang('select'); ?> </option>
                                        <?php } ?>

                                        <option value="Card"> <?php echo lang('card'); ?> </option>
                                    <?php } ?>

                                </select>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <?php
                            $payment_gateway = $settings->payment_gateway;
                            ?>



                            <div class="card">

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
                                            <option value="American Express"> <?php echo lang('american_express'); ?> </option>
                                        </select>
                                    </div>
                                <?php } ?>
                                <?php if ($payment_gateway == '2Checkout' || $payment_gateway == 'PayPal') {
                                    ?>
                                    <div class="col-md-12 payment pad_bot">
                                        <label for="exampleInputEmail1"> <?php echo lang('cardholder'); ?> <?php echo lang('name'); ?></label>
                                        <input type="text" id="cardholder1" class="form-control pay_in" name="cardholder" value='' placeholder="">
                                    </div>
                                <?php } ?>
                                <?php if ($payment_gateway != 'Pay U Money' && $payment_gateway != 'Paystack' && $payment_gateway != 'SSLCOMMERZ' && $payment_gateway != 'Paytm') { ?>
                                    <div class="col-md-12 payment pad_bot">
                                        <label for="exampleInputEmail1"> <?php echo lang('card'); ?> <?php echo lang('number'); ?></label>
                                        <input type="text" id="card1" class="form-control pay_in" name="card_number" value='' placeholder="">
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
                                    ?>onClick="stripePay1(event);" <?php }
                                ?> <?php if ($settings->payment_gateway == '2Checkout' && $twocheckout->status == 'live') {
                                    ?>onClick="twoCheckoutPay1(event);" <?php }
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




<!-- Edit Patient Modal-->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('edit_patient'); ?></h4>
            </div>
            <div class="modal-body row">
                <form role="form" id="editPatientForm" action="patient/addNew" class="clearfix" method="post" enctype="multipart/form-data">

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('email'); ?></label>
                        <input type="text" class="form-control" name="email" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('change'); ?><?php echo lang('password'); ?></label>
                        <input type="password" class="form-control" name="password" id="exampleInputEmail1" placeholder="">
                    </div>



                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('address'); ?></label>
                        <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('phone'); ?></label>
                        <input type="text" class="form-control" name="phone" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('sex'); ?></label>
                        <select class="form-control m-bot15" name="sex" value=''>

                            <option value="Male" <?php
                            if (!empty($patient->sex)) {
                                if ($patient->sex == 'Male') {
                                    echo 'selected';
                                }
                            }
                            ?>> Male </option>
                            <option value="Female" <?php
                            if (!empty($patient->sex)) {
                                if ($patient->sex == 'Female') {
                                    echo 'selected';
                                }
                            }
                            ?>> Female </option>
                            <option value="Others" <?php
                            if (!empty($patient->sex)) {
                                if ($patient->sex == 'Others') {
                                    echo 'selected';
                                }
                            }
                            ?>> Others </option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label><?php echo lang('birth_date'); ?></label>
                        <input class="form-control form-control-inline input-medium default-date-picker" type="text" name="birthdate" value="" placeholder="" readonly="">
                    </div>


                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('blood_group'); ?></label>
                        <select class="form-control m-bot15" name="bloodgroup" value=''>
                            <?php foreach ($groups as $group) { ?>
                                <option value="<?php echo $group->group; ?>" <?php
                                if (!empty($patient->bloodgroup)) {
                                    if ($group->group == $patient->bloodgroup) {
                                        echo 'selected';
                                    }
                                }
                                ?>> <?php echo $group->group; ?> </option>
                                    <?php } ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('doctor'); ?></label>
                        <select class="form-control js-example-basic-single doctor" name="doctor" value=''>
                            <option value=""> </option>
                            <?php foreach ($doctors as $doctor) { ?>
                                <option value="<?php echo $doctor->id; ?>"><?php echo $doctor->name; ?> </option>
                            <?php } ?>
                        </select>
                    </div>



                    <div class="form-group last col-md-6">
                        <label class="control-label">Image Upload</label>
                        <div class="">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="//www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" id="img" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                        <input type="file" class="default" name="img_url" />
                                    </span>
                                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                                </div>
                            </div>

                        </div>
                    </div>


                    <!--
                    
                    <div class="form-group last col-md-6">
                        <div style="text-align:center;">
                            <video id="video" width="200" height="200" autoplay></video>
                            <div class="snap" id="snap">Capture Photo</div>
                            <canvas id="canvas" width="200" height="200"></canvas>
                            Right click on the captured image and save. Then select the saved image from the left side's Select Image button.
                        </div>
                    </div>
                    
                    -->








                    <div class="form-group col-md-6">
                        <input type="checkbox" name="sms" value="sms"> <?php echo lang('send_sms') ?><br>
                    </div>

                    <input type="hidden" name="redirect" value='patient/medicalHistory?id=<?php echo $patient->id; ?>'>>

                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="p_id" value='<?php
                    if (!empty($patient->patient_id)) {
                        echo $patient->patient_id;
                    }
                    ?>'>







                    <section class="col-md-12">
                        <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
                    </section>

                </form>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>
<!-- Edit Patient Modal-->
<!-- Add Medical History Modal-->
<div class="modal fade" id="myModalSurgery" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 64% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('add_surgery'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="surgery/addSurgery" class="clearfix row" method="post" enctype="multipart/form-data">
                    <!-- <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('date'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium default-date-picker" name="date" id="exampleInputEmail1" value='' placeholder="" readonly="">
                    </div>-->
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"> <?php echo lang('time_to_be_done'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium  form_datetime " name="time_to_be_done" id="exampleInputEmail1" value='' placeholder="" readonly="" required="">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('title'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium" name="title" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"> <?php echo lang('status'); ?></label>
                        <select class="form-control m-bot15" name="status" value=''>
                            <option value="Pending Confirmation"> <?php echo lang('pending_confirmation'); ?> </option>
                            <option value="Confirmed"> <?php echo lang('confirmed'); ?> </option>

                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('remarks'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium" name="remarks" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <input type="hidden" name="patient_id" value='<?php echo $patient->id; ?>'>
                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="redirect" value='surgery'>
                    <div class="adv-table editable-table ">
                        <table style="width: 100% !important;" class="table table-striped table-hover table-bordered" id="editable-tablesurgery">
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
                            <tbody id="surgery_proccedure">

                            </tbody>
                        </table>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('total_value'); ?></label>
                        <input type="text" class="form-control" name="total_value_surgery" id="total_value_surgery" value='' placeholder="" readonly="">
                    </div>

                    <div class="separator col-md-12"><?php echo lang('select'); ?></div>
                    <br> <br>
                    <div class="col-md-12" style="margin-top:20px;">
                        <div class="col-md-5">

                            <select style=" display: block;" class="form-control m-bot15 js-example-basic-single" id="surgery_type" name="surgery_proccedure" value='' required="">
                                <option><?php echo lang('select'); ?> </option>
                                <?php foreach ($surgery_category as $surgery) { ?>
                                    <option value="<?php echo $surgery->id;
                                    ?>"><?php echo $surgery->category; ?></option>
                                        <?php } ?>
                            </select>
                        </div>
                        <!--   <div class="col-md-5">

                                <select style=" display: block;"class="form-control m-bot15 js-example-basic-single" id="medical_analysis" name="medical_analysis" value='' required=""> 
                                    <option><?php echo lang('select'); ?> <?php echo lang('medical_analysis'); ?></option>
                        <?php foreach ($payment_category as $category) { ?>
                                                        <option value="<?php echo $category->id;
                            ?>"><?php echo $category->category; ?></option>
                        <?php } ?>
                                </select>
                            </div>-->
                        <div class="col-md-2">
                            <button class="btn btn-info" id="add_surgery"><i class="fa fa-save"></i></button>
                        </div>



                    </div>


                    <!-- <input type="hidden" name="patient_id" value='<?php echo $patient->id; ?>'>
                    <input type="hidden" name="id" value=''>-->
                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info submit_button pull-right">Submit</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- End Surgery -->
<div class="modal fade" id="myModal3" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 64% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('add_bed'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="bed/addAllotment" class="clearfix row" method="post" enctype="multipart/form-data">
                    <div class="form-group col-md-12">

                        <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('covid_19'); ?>:</label>

                        <span></span>
                        <input type="radio" name="covid_19" value="po">
                        <label style="margin-right: 56px;"><?php echo lang('po'); ?></label>
                        <input type="radio" name="covid_19" value="jo">
                        <label><?php echo lang('jo'); ?></label>

                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('alloted_time'); ?></label>
                        <div data-date="" class="input-group date form_datetime-meridian">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-info date-set"><i class="fa fa-calendar"></i></button>
                                <button type="button" class="btn btn-danger date-reset"><i class="fa fa-times"></i></button>
                            </div>
                            <input type="text" class="form-control" readonly="" name="a_time" id="alloted_time" value='<?php
                            if (!empty($allotment->a_time)) {
                                echo $allotment->a_time;
                            }
                            ?>' placeholder="">
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('room_no'); ?></label>
                        <select class="form-control m-bot15" id="room_no" name="category" value=''>
                            <option><?php echo lang('select'); ?></option>
                            <?php foreach ($room_no as $room) { ?>
                                <option value="<?php echo $room->category; ?>" <?php
                                if (!empty($allotment->category)) {
                                    if ($allotment->category == $room->category) {
                                        echo 'selected';
                                    }
                                }
                                ?>> <?php echo $room->category; ?> </option>
                                    <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('bed_id'); ?></label>
                        <select class="form-control m-bot15" id="bed_id" name="bed_id" value=''>
                            <option value="select"><?php echo lang('select'); ?></option>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('patient'); ?></label>
                        <select class="form-control m-bot15" id="patientchoose" name="patient" value=''>
                            <option value="<?php echo $patient->id; ?>"><?php echo $patient->name . '(id:' . $patient->id . ')'; ?></option>
                        </select>
                    </div>


                    <div class="form-group col-md-12">

                        <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('category'); ?>:</label>

                        <span></span>
                        <input type="checkbox" name="category_status[]" value="urgent">
                        <label style="margin-right: 56px;"><?php echo lang('urgent'); ?></label>
                        <input type="checkbox" name="category_status[]" value="planned">
                        <label><?php echo lang('planned'); ?></label>

                    </div>
                    <div class="form-group col-md-12">

                        <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('reaksione'); ?>:</label>
                        <textarea name="reaksione" class='form-control'> </textarea>

                    </div>
                    <div class="form-group col-md-12">

                        <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('transferred_from'); ?>:</label>
                        <textarea name="transferred_from" class='form-control'> </textarea>

                    </div>
                    <div class="form-group col-md-12">

                        <label for="exampleInputEmail1"><?php echo lang('diagnoza_a_shtrimit'); ?>:</label>
                        <textarea name="diagnoza_a_shtrimit" class='form-control'> </textarea>

                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('doctor'); ?></label>
                        <select class="form-control m-bot15" id="doctors" name="doctor" value=''>

                        </select>
                    </div>
                    <div class="form-group col-md-12">

                        <label for="exampleInputEmail1"><?php echo lang('diagnosis'); ?>:</label>
                        <textarea name="diagnosis" class='form-control'> </textarea>

                    </div>
                    <div class="form-group col-md-12">

                        <label for="exampleInputEmail1"><?php echo lang('other_illnesses'); ?>:</label>
                        <textarea name="other_illnesses" class='form-control'> </textarea>

                    </div>
                    <div class="form-group col-md-12">

                        <label for="exampleInputEmail1"><?php echo lang('anamneza'); ?>:</label>
                        <textarea name="anamneza" class='form-control'> </textarea>

                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('blood_group'); ?></label>
                        <select class="form-control m-bot15" id="blood_group" name="blood_group" value=''>
                            <?php foreach ($blood_group as $blood_group) {
                                ?>

                                <option value="<?php echo $blood_group->id; ?>"><?php echo $blood_group->group; ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('accepting_doctor'); ?></label>
                        <select class="form-control m-bot15" id="accepting_doctors" name="accepting_doctor" value=''>

                        </select>
                    </div>
                    <input type="hidden" name="redirect" value="redirect">

                    <input type="hidden" name="id" value=''>

                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
                    </div>

                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- End Surgery -->

<style>
    thead {
        background: #f1f1f1;
        border-bottom: 1px solid #ddd;
    }

    .btn_width {
        margin-bottom: 20px;
    }

    .tab-content {
        padding: 20px 0px;
    }

    .cke_editable {
        min-height: 1000px;
    }
</style>


<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">
                                        $(document).ready(function () {
                                            $(".editbutton").click(function (e) {
                                                e.preventDefault(e);
                                                // Get the record's ID via attribute  
                                                var iid = $(this).attr('data-id');
                                                $('#myModal2').modal('show');
                                                $.ajax({
                                                    url: 'patient/editMedicalHistoryByJason?id=' + iid,
                                                    method: 'GET',
                                                    data: '',
                                                    dataType: 'json',
                                                }).success(function (response) {
                                                    // Populate the form fields with the data returned from server
                                                    var date = new Date(response.medical_history.date * 1000);
                                                    var de = date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();

                                                    $('#medical_historyEditForm').find('[name="id"]').val(response.medical_history.id).end()
                                                    $('#medical_historyEditForm').find('[name="date"]').val(de).end()
                                                    $('#medical_historyEditForm').find('[name="title"]').val(response.medical_history.title).end()

                                                    CKEDITOR.instances['editor'].setData(response.medical_history.description)
                                                });
                                            });
                                        });
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $(".editPrescription").click(function (e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#myModal5').modal('show');
            $.ajax({
                url: 'prescription/editPrescriptionByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                // Populate the form fields with the data returned from server
                $('#prescriptionEditForm').find('[name="id"]').val(response.prescription.id).end()
                $('#prescriptionEditForm').find('[name="patient"]').val(response.prescription.patient).end()
                $('#prescriptionEditForm').find('[name="doctor"]').val(response.prescription.doctor).end()

                CKEDITOR.instances['editor1'].setData(response.prescription.symptom)
                CKEDITOR.instances['editor2'].setData(response.prescription.medicine)
                CKEDITOR.instances['editor3'].setData(response.prescription.note)
            });
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $(".editAppointmentButton").click(function (e) {
            e.preventDefault(e);
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
            $('#editAppointmentModal').modal('show');
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
                //  $('#editAppointmentForm').find('[name="doctor"]').val(response.appointment.doctor).end()
                $('#editAppointmentForm').find('[name="date"]').val(da).end()
                $('#editAppointmentForm').find('[name="status"]').val(response.appointment.status).end()
                $('#editAppointmentForm').find('[name="remarks"]').val(response.appointment.remarks).end()
                var option1 = new Option(response.doctor.name + '-' + response.doctor.id, response.doctor.id, true, true);
                $('#editAppointmentForm').find('[name="doctor"]').append(option1).trigger('change');
                // $('.js-example-basic-single.doctor').val(response.appointment.doctor).trigger('change');
                $('.js-example-basic-single.patient').val(response.appointment.patient).trigger('change');

                $('#editAppointmentForm').find('[name="category_appointment"]').val(response.appointment.category_appointment).end()
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
                    $('#editAppointmentForm').find('[name="discount"]').val(response.appointment.discount).end();
                    $('#editAppointmentForm').find('[name="grand_total"]').val(response.appointment.grand_total).end();
                } else {
                    $('.payment_status').removeClass('hidden');
                    $('.pay_now').addClass('hidden');
                    $('.consultant_fee_div').addClass('hidden');
                    //  $('.deposit_type1').addClass('hidden');
                    $("#editAppointmentForm").find('[id="adoctors1"]').select2([{
                            id: response.doctor.id,
                            text: response.doctor.name + '-' + response.doctor.id,
                            locked: true
                        }]);
                    $("#editAppointmentForm").find('[id="pos_select"]').select2([{
                            id: response.patient.id,
                            text: response.patient.name + '-' + response.patient.id,
                            locked: true
                        }]);
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
                    if ($('#aslots1').has('option').length == 0) { //if it is blank. 
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
                if ($('#aslots').has('option').length == 0) { //if it is blank. 
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
            if ($('#aslots').has('option').length == 0) { //if it is blank. 
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
            if ($('#aslots').has('option').length == 0) { //if it is blank. 
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
                if ($('#aslots1').has('option').length == 0) { //if it is blank. 
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
            if ($('#aslots1').has('option').length == 0) { //if it is blank. 
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
            if ($('#aslots1').has('option').length == 0) { //if it is blank. 
                $('#aslots1').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
            }


            // Populate the form fields with the data returned from server
            //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
        });

    }
</script>

<script>
    $(document).ready(function () {
        $('#editable-sample').DataTable({
            responsive: true,
            dom: "<'row'<'col-sm-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",

            buttons: [{
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, 1],
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [0, 1],
                    }
                },
                {
                    extend: 'csvHtml5',
                    exportOptions: {
                        columns: [0, 1],
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1],
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1],
                    }
                },
            ],
            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            iDisplayLength: -1,
            "order": [
                [0, "desc"]
            ],
            "language": {
                "lengthMenu": "_MENU_ records per page",
            }


        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $(".editPatient").click(function () {
            //    e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#editPatientForm').trigger("reset");
            $.ajax({
                url: 'patient/editPatientByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                // Populate the form fields with the data returned from server

                $('#editPatientForm').find('[name="id"]').val(response.patient.id).end()
                $('#editPatientForm').find('[name="name"]').val(response.patient.name).end()
                $('#editPatientForm').find('[name="password"]').val(response.patient.password).end()
                $('#editPatientForm').find('[name="email"]').val(response.patient.email).end()
                $('#editPatientForm').find('[name="address"]').val(response.patient.address).end()
                $('#editPatientForm').find('[name="phone"]').val(response.patient.phone).end()
                $('#editPatientForm').find('[name="sex"]').val(response.patient.sex).end()
                $('#editPatientForm').find('[name="birthdate"]').val(response.patient.birthdate).end()
                $('#editPatientForm').find('[name="bloodgroup"]').val(response.patient.bloodgroup).end()
                $('#editPatientForm').find('[name="p_id"]').val(response.patient.patient_id).end()

                if (typeof response.patient.img_url !== 'undefined' && response.patient.img_url != '') {
                    $("#img").attr("src", response.patient.img_url);
                }


                $('.js-example-basic-single.doctor').val(response.patient.doctor).trigger('change');
                $('#infoModal').modal('show');
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        $("#doctors").select2({
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
        $("#accepting_doctors").select2({
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
                var discount = $('#discount').val();
                $('#grand_total').val(parseFloat(response.response.visit_charges - discount)).end();

            });
        });
        $("#discount").keyup(function () {
            // Get the record's ID via attribute  
            var discount = $(this).val();
            var price = $('#visit_charges').val();
            $('#grand_total').val(parseFloat(price - discount)).end();

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
                var discount = $('#discount1').val();
                $('#grand_total1').val(parseFloat(response.response.visit_charges - discount)).end();


            });
        });
        $("#discount1").keyup(function () {
            // Get the record's ID via attribute  
            var discount = $(this).val();
            var price = $('#visit_charges1').val();
            $('#grand_total1').val(parseFloat(price - discount)).end();

        });
    });
</script>

<!-- Payment JS -->
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
            TCO.loadPubKey('sandbox', function () { // for sandbox environment
                publishableKey = "<?php echo $twocheckout->publishablekey; ?>" //your public key
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
            TCO.loadPubKey('sandbox', function () { // for sandbox environment
                publishableKey = "<?php echo $twocheckout->publishablekey; ?>" //your public key
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

<!-- Payment JS END-->
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
                        var number = parseFloat(value);
                        sum += number;
                    });
                    var discount_values = $("input[name^='discount_case[]']").map(function (idx1, ele1) {
                        return $(ele1).val();
                    }).get();
                    var dis_sum = 0;

                    $.each(discount_values, function (index1, value1) {
                        // alert(index + ": " + value);
                        var number1 = parseFloat(value1);
                        dis_sum += number1;
                    });
                    $('#total_discount_case').val(dis_sum);
                    $('#total_value').val(sum);
                    $('#grand_total_case').val(parseFloat(sum - dis_sum));
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
                        var number = parseFloat(value);
                        sum += number;
                    });
                    var discount_values = $("input[name^='discount_case[]']").map(function (idx1, ele1) {
                        return $(ele1).val();
                    }).get();
                    var dis_sum = 0;

                    $.each(discount_values, function (index1, value1) {
                        // alert(index + ": " + value);
                        var number1 = parseFloat(value1);
                        dis_sum += number1;
                    });
                    $('#total_discount_case').val(dis_sum);
                    $('#total_value').val(sum);
                    $('#grand_total_case').val(parseFloat(sum - dis_sum));
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
                        var number = parseFloat(value);
                        sum += number;
                    });
                    var discount_values = $("input[name^='discount_case[]']").map(function (idx1, ele1) {
                        return $(ele1).val();
                    }).get();
                    var dis_sum = 0;

                    $.each(discount_values, function (index1, value1) {
                        // alert(index + ": " + value);
                        var number1 = parseFloat(value1);
                        dis_sum += number1;
                    });
                    $('#total_discount_case').val(dis_sum);
                    $('#total_value').val(sum);
                    $('#grand_total_case').val(parseFloat(sum - dis_sum));
                })
            }
            e.preventDefault();
        })

    })
</script>

<script>
    $(document).ready(function () {
        $('#add_surgery').click(function (e) {
            var medical_analysis = $('#surgery_type').val();
            // var package = $('#package').val();

            if ($('table#editable-tablesurgery').find('#tr-med-surgery-' + medical_analysis).length > 0) {
                alert('Already in the List');
            } else if (medical_analysis === 'Select') {
                alert('Please Select a  Medical Analysis');
            } else if ($('table#editable-table2').find('#tr-med-surgery-' + medical_analysis).length <= 0) {
                $.ajax({
                    url: 'surgery/getTableTrValue?medical_analysis=' + medical_analysis,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                }).success(function (response) {
                    $('#surgery_proccedure').after(response.option);
                    var values = $("input[name^='price_surgery[]']").map(function (idx, ele) {
                        return $(ele).val();
                    }).get();
                    var sum = 0;
                    $.each(values, function (index, value) {
                        // alert(index + ": " + value);
                        var number = parseInt(value, 10);
                        sum += number;
                    });
                    $('#total_value_surgery').val(sum);
                })
            } else {

                var url = 'surgery/getTableTrValue?medical_analysis=' + medical_analysis;

                $.ajax({
                    url: url,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                }).success(function (response) {
                    $('#package_proccedure').after(response.option);
                    var values = $("input[name^='price_surgery[]']").map(function (idx, ele) {
                        return $(ele).val();
                    }).get();
                    var sum = 0;
                    $.each(values, function (index, value) {
                        // alert(index + ": " + value);
                        var number = parseInt(value, 10);
                        sum += number;
                    });
                    $('#total_value_surgery').val(sum);
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
                var number = parseFloat(value, 10);
                sum += number;
            });
            var discount_values = $("input[name^='discount_case[]']").map(function (idx1, ele1) {
                return $(ele1).val();
            }).get();
            var dis_sum = 0;

            $.each(discount_values, function (index1, value1) {
                // alert(index + ": " + value);
                var number1 = parseFloat(value1);
                dis_sum += number1;
            });
            $('#total_discount_case').val(dis_sum);
            $('#total_value').val(sum);
            $('#grand_total_case').val(parseFloat(sum - dis_sum));
        });
        $("#editable-table2").on("keyup", ".discount-price-case", function () {
            var id = $(this).attr('id');
            var discount_single = $('#' + id).val();


            var id_split = id.split("-");

            var price = '';
            var id_grand = '';
            if (id_split[2] === 'med') {
                price = $('#price-med-' + id_split[3]).val();
                $('#discount-case-med-' + id_split[3]).html(" ");
                id_grand = '#grand-case-med-';
            } else {
                price = $('#price-pack-' + id_split[3]).val();
                $('#discount-case-pack-' + id_split[3]).html(" ");
                id_grand = '#grand-case-pack-';
            }
            var grand_single = parseFloat(price - discount_single);
            $(id_grand + id_split[3]).html(grand_single);

            var discount_values = $("input[name^='discount_case[]']").map(function (idx, ele) {
                return $(ele).val();
            }).get();
            var dis_sum = 0;

            $.each(discount_values, function (index1, value1) {
                //   alert(index1 + ": " + value1);
                var number1 = parseFloat(value1);
                dis_sum += number1;
            });
            var total = $('#total_value').val();
            var grand = parseFloat(total) - parseFloat(dis_sum);
            $('#grand_total_case').val(grand);
            $('#total_discount_case').val(dis_sum);

            // alert(dis_sum);
        });

    })
</script>

<script>
    $(document).ready(function () {
        $('#editable-tablesurgery').on('click', '.delete_button', function () {
            //  $('.delete_button').click(function () {
            // alert('sadas');
            var id = $(this).attr('id');
            var id_split = id.split("-");
            // if(id_split[1]=='med'){
            $('#tr-' + id_split[1] + '-' + id_split[2] + '-' + id_split[3]).remove();
            //}

            var values = $("input[name^='price_surgery[]']").map(function (idx, ele) {
                return $(ele).val();
            }).get();
            //  alert(values);
            var sum = 0;
            $.each(values, function (index, value) {
                // alert(index + ": " + value);
                var number = parseInt(value, 10);
                sum += number;
            });
            $('#total_value_surgery').val(sum);
        });


    })
</script>

<script>
    $(document).ready(function () {

        $('body').on('focus', ".default-date-picker", function () {
            $(this).datepicker();
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#room_no').change(function () {
            var id = $(this).val();
            $('#bed_id').html(" ");
            var alloted_time = $('#alloted_time').val();
            $.ajax({
                url: 'bed/getBedByRoomNo?id=' + id + '&alloted_time=' + alloted_time,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                $('#bed_id').html(response.response);
            });

        })
    })
</script>

<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>

<script src="common/js/codearistos.min.js"></script>
<script src="common/toastr/js/toastr.js"></script>
<link rel="stylesheet" type="text/css" href="common/toastr/css/toastr.css">

<!-- Operation JS -->
<script>
    $(document).ready(function () {
        //Fill Drop-Down List
        $("#generic_name").select2({
            placeholder: '<?php echo lang('medicine_gen_name'); ?>',
            allowClear: true,
            ajax: {
                url: 'medicine/getGenericNameInfoByEmergency',
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

        //Generic Name
        $('#generic_name').change(function () {
            var id = $(this).val();
            $('#medicines_option').html(" ");
            $.ajax({
                url: 'medicine/getMedicineByGeneric?id=' + id,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                $('#medicines_option').html(response.response);
            });
        })

        //Medicine Options
        $('#medicines_option').change(function () {
            var id = $(this).val();
            $.ajax({
                url: 'medicine/getMedicine?id=' + id,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                $('#editMedicine').find('[name="sales_price"]').val(response.medicine.s_price).end();
                $('#editMedicine').find('[name="quantity"]').val("1").end();
                var total = response.medicine.s_price * 1;
                $('#editMedicine').find('[name="total"]').val(total).end();
            });
        })

        //Medicine Quantity
        $('#quantity').keyup(function () {
            var quantity = $(this).val();
            var s_price = $('#sales_price').val();
            //  alert(quantity);
            var total = quantity * s_price;
            $('#editMedicine').find('[name="sales_price"]').val(s_price).end();
            $('#editMedicine').find('[name="quantity"]').val(quantity).end();
            // var total = response.medicine.s_price * 1;
            $('#editMedicine').find('[name="total"]').val(total).end();
        })

        //Edit Medicine
        $("#editMedicine").submit(function (e) {

            var dataString = $(this).serialize();
            // alert(dataString); return false;

            $.ajax({
                type: "POST",
                url: "bed/updateMedicine",
                data: dataString,
                success: function (response) {
                    var data = jQuery.parseJSON(response);
                    toastr.success(data.message.message);
                    var row_data = "";
                    row_data += "<tr class=''id='" + data.info.id + "'><td>" + data.info.date + "</td><td>" + data.info.generic_name + "</td><td>" + data.info.medicine_name + "</td><td>" + data.info.s_price + "</td><td>" + data.info.quantity + "</td><td>" + data.info.total + "</td><td class='no-print' id='delete-" + data.info.id + "'> <button type='button' class='btn btn-danger btn-xs btn_width delete_medicine' title='<?php echo lang('delete'); ?>' data-toggle='' data-id=" + data.info.id + "><i class='fa fa-trash'></i></button></td></tr>";
                    $("#medicine_table").after(row_data);
                    $(':input', '#editMedicine')
                            .not(':button, :submit, :reset, :hidden')
                            .val('')
                            .prop('checked', false)
                            .prop('selected', false);
                    // $("#editMedicine").val('').change();

                }
            });
            e.preventDefault();
        });

        //Delete Medicine
        $('#editable-table1').on('click', '.delete_medicine', function (e) {
            //$('.delete_medicine').click(function (e) {
            var id = $(this).attr('data-id');
            // alert(id);
            if (confirm("Are you sure you want to delete this Record?")) {
                $.ajax({
                    type: "GET",
                    url: "bed/deleteMedicine?id=" + id,
                    data: '',
                    success: function (response) {
                        var data = jQuery.parseJSON(response);
                        toastr.warning(data.message.message);
                        $('#' + id).remove();
                    }
                });
            }
            e.preventDefault();
        });
    });
</script>

<!-- Create Medicine Invoice -->
<script>
    $(document).ready(function () {
        $('#save_button').click(function () {
            var id = $('#alloted').val();
            $.ajax({
                type: "GET",
                url: "bed/createMedicineInvoice?id=" + id,
                data: '',
                dataType: 'json',
                success: function (response) {
                    //  var data = jQuery.parseJSON(response);
                    var ids = response.ids;
                    var ids_split = ids.split(",");
                    toastr.success(response.message.message);
<?php if (!$this->ion_auth->in_group(array('admin'))) { ?>
                        $.each(ids_split, function (index, value) {

                            $('#delete-' + value).remove();
                            ;
                        });
<?php } ?>
                }
            })
        })
    })
</script>