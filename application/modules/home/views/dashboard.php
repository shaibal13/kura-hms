<!DOCTYPE html>
<html lang="en" <?php if ($this->db->get('settings')->row()->language == 'arabic' || $this->db->get('settings')->row()->language == 'persian') { ?> dir="rtl" <?php } ?>>
    <head>
        <base href="<?php echo base_url(); ?>">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Rizvi">
        <meta name="keyword" content="Php, Hospital, Clinic, Management, Software, Php, CodeIgniter, Hms, Accounting">
        <link rel="shortcut icon" href="uploads/favicon.png">
        <?php
        $class_name = $this->router->fetch_class();
        $class_name_lang = lang($class_name);
        if (empty($class_name_lang)) {
            $class_name_lang = $class_name;
        }
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
        ?>

        <title><?php echo $class_name_lang; ?> | <?php echo $this->db->get('settings')->row()->system_vendor; ?> </title>
        <!-- Bootstrap core CSS -->
        <link href="common/css/bootstrap.min.css" rel="stylesheet">
        <link href="common/css/bootstrap-reset.css" rel="stylesheet">
        <!--external css-->
        <link href="common/assets/fontawesome5pro/css/all.min.css" rel="stylesheet" />
        <link href="common/assets/DataTables/datatables.min.css" rel="stylesheet" />
        <!-- <link href="common/assets/font-awesome/css/font-awesome.css" rel="stylesheet" /> -->
        <!-- Custom styles for this template -->
        <link href="common/css/style.css" rel="stylesheet">
        <link href="common/css/style-responsive.css" rel="stylesheet" />
        <link rel="stylesheet" href="common/assets/bootstrap-datepicker/css/bootstrap-datepicker.css" />
        <link rel="stylesheet" type="text/css" href="common/assets/bootstrap-daterangepicker/daterangepicker-bs3.css" />
        <link rel="stylesheet" type="text/css" href="common/assets/bootstrap-datetimepicker/css/datetimepicker.css" />
        <link rel="stylesheet" type="text/css" href="common/assets/bootstrap-timepicker/compiled/timepicker.css">
        <link rel="stylesheet" type="text/css" href="common/assets/jquery-multi-select/css/multi-select.css" />
        <link href="common/css/invoice-print.css" rel="stylesheet" media="print">
        <link href="common/assets/fullcalendar/fullcalendar.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="common/assets/select2/css/select2.min.css"/>
        <link rel="stylesheet" type="text/css" href="common/css/lightbox.css"/>
        <link rel="stylesheet" type="text/css" href="common/assets/bootstrap-fileupload/bootstrap-fileupload.css" />
        <link rel="stylesheet" type="text/css" href="common/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />

        <link rel="stylesheet" type="text/css" href="common/assets/DataTables/DataTables-1.10.16/custom/css/datatable-responsive-cdn-version-1-0-7.css" />


        <!-- Google Fonts -->

        <style>
            @import url('https://fonts.googleapis.com/css?family=Ubuntu&display=swap');
        </style>





        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->


        <?php if ($this->db->get('settings')->row()->language == 'arabic' || $this->db->get('settings')->row()->language == 'persian') { ?>
            <style>

                #main-content {
                    margin-right: 211px;
                    margin-left: 0px; 
                }

                body {
                    background: #f1f1f1;

                }

            </style>

        <?php } ?>

    </head>

    <body>
        <section id="container" class="">
            <!--header start-->
            <header class="header white-bg">
                <div class="sidebar-toggle-box">
                    <div data-original-title="Toggle Navigation" data-placement="right" class="fa fa-dedent fa-bars fa-angle-double-left tooltips"></div>
                </div>
                <!--logo start-->
                <?php
                $settings_title = $this->db->get('settings')->row()->title;
                $settings_title = explode(' ', $settings_title);
                ?>

                <a href="home" class="logo">
                    <strong>
                        <?php echo $settings_title[0]; ?>


                        <?php
                        if (!empty($settings_title[1])) {
                            echo $settings_title[1];
                        }
                        ?>


                        <?php
                        if (!empty($settings_title[2])) {
                            echo $settings_title[2];
                        }
                        ?>

                    </strong>
                </a>

                <!--logo end-->
                <div class="nav notify-row" id="top_menu">
                    <!--  notification start -->
                    <ul class="nav top-menu">
                        <!-- Bed Notification start -->
                        <?php if ($this->ion_auth->in_group(array('admin', 'Doctor', 'Nurse')) || in_array('Bed', $pers)) { ?> 
                            <li class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <i class="fa fa-procedures"></i>
                                    <span class="badge bg-success">  



                                        <?php
                                        $query = $this->db->get('bed')->result();
                                        $available_bed = 0;
                                        foreach ($query as $bed) {
                                            $last_a_time = explode('-', $bed->last_a_time);
                                            $last_d_time = explode('-', $bed->last_d_time);
                                            if (!empty($last_d_time[1])) {
                                                $last_d_h_am_pm = explode(' ', $last_d_time[1]);
                                                $last_d_h = explode(':', $last_d_h_am_pm[1]);
                                                if ($last_d_h_am_pm[2] == 'AM') {
                                                    $last_d_m = ($last_d_h[0] * 60 * 60) + ($last_d_h[1] * 60);
                                                } else {
                                                    $last_d_m = (12 * 60 * 60) + ($last_d_h[0] * 60 * 60) + ($last_d_h[1] * 60);
                                                }
                                                $last_d_time_s = strtotime($last_d_time[0]) + $last_d_m;
                                                if (time() > $last_d_time_s) {
                                                    $available_bed = $available_bed + 1;
                                                }
                                            } else {
                                                $available_bed = $available_bed + 1;
                                            }
                                        }
                                        echo $available_bed;
                                        ?>

                                    </span>
                                </a>
                                <ul class="dropdown-menu extended tasks-bar">
                                    <div class="notify-arrow notify-arrow-green"></div>
                                    <li>
                                        <p class="green">
                                            <?php
                                            if (!empty($query)) {
                                                echo $available_bed;
                                            } else {
                                                $available_bed = 0;
                                                echo $available_bed;
                                            }
                                            ?> 
                                            <?php
                                            if ($available_bed <= 1) {
                                                echo lang('bed_is_available');
                                            } else {
                                                echo lang('beds_are_available');
                                            }
                                            ?>
                                        </p>
                                    </li>
                                    <?php ?>
                                    <li class="external">
                                        <a href="bed/bedAllotment"><p class="green"><?php
                                                if ($available_bed > 0) {
                                                    echo lang('add_a_allotment');
                                                } else {
                                                    echo lang('no_bed_is_available_for_allotment');
                                                }
                                                ?></p></a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- Bed notification end -->
                        <!-- Payment notification start-->
                        <?php if ($this->ion_auth->in_group(array('admin', 'Accountant')) || in_array('Finance', $pers)) { ?> 
                            <li id="header_inbox_bar" class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <i class="fa fa-money-check"></i>
                                    <span class="badge bg-important"> 
                                        <?php
                                        $query = $this->db->get('payment');
                                        $query = $query->result();
                                        foreach ($query as $payment) {
                                            $payment_date = date('y/m/d', $payment->date);
                                            if ($payment_date == date('y/m/d')) {
                                                $payment_number[] = '1';
                                            }
                                        }
                                        if (!empty($payment_number)) {
                                            echo $payment_number = array_sum($payment_number);
                                        } else {
                                            $payment_number = 0;
                                            echo $payment_number;
                                        }
                                        ?>        
                                    </span>
                                </a>
                                <ul class="dropdown-menu extended inbox">
                                    <div class="notify-arrow notify-arrow-red"></div>
                                    <li>
                                        <p class="red"> <?php
                                            echo $payment_number . ' ';
                                            if ($payment_number <= 1) {
                                                echo lang('payment_today');
                                            } else {
                                                echo lang('payments_today');
                                            }
                                            ?></p>
                                    </li>
                                    <li>
                                        <a href="finance/payment"><p class="green"> <?php echo lang('see_all_payments'); ?></p></a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- payment notification end -->  
                        <!-- patient notification start-->
                        <?php if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Doctor', 'Nurse', 'Laboratorist')) || in_array('Patient', $pers)) { ?> 
                            <li id="header_notification_bar" class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <i class="fa fa-user"></i>
                                    <span class="badge bg-warning">   
                                        <?php
                                        $this->db->where('add_date', date('m/d/y'));
                                        $query = $this->db->get('patient');
                                        $query = $query->result();
                                        foreach ($query as $patient) {
                                            $patient_number[] = '1';
                                        }
                                        if (!empty($patient_number)) {
                                            echo $patient_number = array_sum($patient_number);
                                        } else {
                                            $patient_number = 0;
                                            echo $patient_number;
                                        }
                                        ?>
                                    </span>
                                </a>
                                <ul class="dropdown-menu extended notification">
                                    <div class="notify-arrow notify-arrow-yellow"></div>
                                    <li>
                                        <p class="yellow"><?php
                                            echo $patient_number . ' ';
                                            if ($patient_number <= 1) {
                                                echo lang('patient_registerred_today');
                                            } else {
                                                echo lang('patients_registerred_today');
                                            }
                                            ?> </p>
                                    </li>    
                                    <li>
                                        <a href="patient"><p class="green"><?php echo lang('see_all_patients'); ?></p></a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- patient notification end -->  
                        <!-- donor notification start-->
                        <?php if ($this->ion_auth->in_group(array('admin', 'Doctor', 'Nurse', 'Laboratorist')) || in_array('Donor', $pers)) { ?> 
                            <li id="header_notification_bar" class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <i class="fa fa-user"></i>
                                    <span class="badge bg-success">       
                                        <?php
                                        $this->db->where('add_date', date('m/d/y'));
                                        $query = $this->db->get('donor');
                                        $query = $query->result();
                                        foreach ($query as $donor) {
                                            $donor_number[] = '1';
                                        }
                                        if (!empty($donor_number)) {
                                            echo $donor_number = array_sum($donor_number);
                                        } else {
                                            $donor_number = 0;
                                            echo $donor_number;
                                        }
                                        ?>
                                    </span>
                                </a>
                                <ul class="dropdown-menu extended notification">
                                    <div class="notify-arrow notify-arrow-yellow"></div>
                                    <li>
                                        <p class="green"><?php
                                            echo $donor_number . ' ';
                                            if ($donor_number <= 1) {
                                                echo lang('donor_registerred_today');
                                            } else {
                                                echo lang('donors_registerred_today');
                                            }
                                            ?> </p>
                                    </li>
                                    <li>
                                        <a href="donor"><p class="green"><?php echo lang('see_all_donors'); ?></p></a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?> 
                        <!-- donor notification end -->  
                        <!-- medicine notification start-->
                        <?php if ($this->ion_auth->in_group(array('admin', 'Pharmacist'))) { ?> 
                            <li id="header_notification_bar" class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <i class="fa fa-medkit"></i>
                                    <span class="badge bg-success">                          
                                        <?php
                                        $this->db->where('add_date', date('m/d/y'));
                                        $query = $this->db->get('medicine');
                                        $query = $query->result();
                                        foreach ($query as $medicine) {
                                            $medicine_number[] = '1';
                                        }
                                        if (!empty($medicine_number)) {
                                            echo $medicine_number = array_sum($medicine_number);
                                        } else {
                                            $medicine_number = 0;
                                            echo $medicine_number;
                                        }
                                        ?>
                                    </span>
                                </a>
                                <ul class="dropdown-menu extended notification">
                                    <div class="notify-arrow notify-arrow-yellow"></div>
                                    <li>
                                        <p class="yellow"><?php
                                            echo $medicine_number . ' ';
                                            if ($medicine_number <= 1) {
                                                echo lang('medicine_registerred_today');
                                            } else {
                                                echo lang('medicines_registered_today');
                                            }
                                            ?> </p>
                                    </li>
                                    <li>
                                        <a href="medicine"><p class="green"><?php echo lang('see_all_medicines'); ?></p></a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?> 

                        <!-- medicine notification end -->  
                        <?php if ($this->ion_auth->in_group(array('admin', 'Doctor')) || in_array('Medicine', $pers)) { ?> 
                            <li id="header_notification_bar" class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <i class="fa fa-medkit"></i>
                                    <span class="badge bg-success">                          
                                        <?php
                                        $this->db->where('add_date', date('m/d/y'));
                                        $query = $this->db->get('internal_medicine');
                                        $query = $query->result();
                                        foreach ($query as $medicine) {
                                            $medicine_number[] = '1';
                                        }
                                        if (!empty($medicine_number)) {
                                            echo $medicine_number = array_sum($medicine_number);
                                        } else {
                                            $medicine_number = 0;
                                            echo $medicine_number;
                                        }
                                        ?>
                                    </span>
                                </a>
                                <ul class="dropdown-menu extended notification">
                                    <div class="notify-arrow notify-arrow-yellow"></div>
                                    <li>
                                        <p class="yellow"><?php
                                            echo $medicine_number . ' ';
                                            if ($medicine_number <= 1) {
                                                echo lang('medicine_registerred_today');
                                            } else {
                                                echo lang('medicines_registered_today');
                                            }
                                            ?> </p>
                                    </li>
                                    <li>
                                        <a href="medicine/internalMedicine"><p class="green"><?php echo lang('see_all_medicines'); ?></p></a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?> 
                        <!-- report notification start-->
                        <?php if ($this->ion_auth->in_group(array('admin', 'Doctor', 'Laboratorist', 'Nurse')) || in_array('Report', $pers)) { ?> 
                            <li id="header_notification_bar" class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <i class="fa fa-notes-medical"></i>
                                    <span class="badge bg-success">                         
                                        <?php
                                        $this->db->where('add_date', date('m/d/y'));
                                        $query = $this->db->get('report');
                                        $query = $query->result();
                                        foreach ($query as $report) {
                                            $report_number[] = '1';
                                        }
                                        if (!empty($report_number)) {
                                            echo $report_number = array_sum($report_number);
                                        } else {
                                            $report_number = 0;
                                            echo $report_number;
                                        }
                                        ?>
                                    </span>
                                </a>
                                <ul class="dropdown-menu extended notification">
                                    <div class="notify-arrow notify-arrow-yellow"></div>
                                    <li>
                                        <p class="yellow"><?php
                                            echo $report_number . ' ';
                                            if ($report_number <= 1) {
                                                echo lang('report_added_today');
                                            } else {
                                                echo lang('reports_added_today');
                                            }
                                            ?> </p>
                                    </li>
                                    <li>
                                        <a href="report"><p class="green"><?php echo lang('see_all_reports'); ?></p></a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if ($this->ion_auth->in_group('Patient')) { ?> 
                            <li id="header_notification_bar" class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <i class="fa fa-notes-medical"></i>
                                    <span class="badge bg-success">                         
                                        <?php
                                        $query = $this->db->get('report');
                                        $query = $query->result();
                                        foreach ($query as $report) {
                                            if ($this->ion_auth->user()->row()->id == explode('*', $report->patient)[1]) {
                                                $report_number[] = '1';
                                            }
                                        }
                                        if (!empty($report_number)) {
                                            echo $report_number = array_sum($report_number);
                                        } else {
                                            $report_number = 0;
                                            echo $report_number;
                                        }
                                        ?>
                                    </span>
                                </a>
                                <ul class="dropdown-menu extended notification">
                                    <div class="notify-arrow notify-arrow-yellow"></div>
                                    <li>
                                        <p class="yellow"><?php
                                            echo $report_number . ' ';
                                            if ($report_number <= 1) {
                                                echo lang('report_is_available_for_you');
                                            } else {
                                                echo lang('reports_are_available_for_you');
                                            }
                                            ?> </p>
                                    </li>
                                    <li>
                                        <a href="report/myreports"><p class="green"><?php echo lang('see_your_reports'); ?></p></a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- report notification end -->
                    </ul>
                </div>
                <div class="top-nav ">

                    <ul class="nav pull-right top-menu">
                        <!-- user login dropdown start-->
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <img alt="" src="uploads/favicon.png" width="21" height="23">
                                <span class="username">
                                    <?php
                                    $username = $this->ion_auth->user()->row()->username;
                                    if (!empty($username)) {
                                        $username = explode(' ', $username);
                                        $first_name = $username[0];
                                        echo $first_name;
                                    }
                                    ?> 
                                </span>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu extended logout">
                                <div class="log-arrow-up"></div>
                                <?php if (!$this->ion_auth->in_group('admin')) { ?> 
                                    <li><a href=""><i class="fa fa-home"></i> <?php echo lang('dashboard'); ?></a></li>
                                <?php } ?>
                                <li><a href="profile"><i class=" fa fa-suitcase"></i><?php echo lang('profile'); ?></a></li>
                                <?php if ($this->ion_auth->in_group('admin') || in_array('Settings', $pers)) { ?> 
                                    <li><a href="settings"><i class="fa fa-cog"></i> <?php echo lang('settings'); ?></a></li>
                                <?php } ?>

                                <li><a><i class="fa fa-user"></i> <?php echo $this->ion_auth->get_users_groups()->row()->name ?></a></li>

                                <li><a href="auth/logout"><i class="fa fa-key"></i> <?php echo lang('log_out'); ?></a></li>
                            </ul>
                        </li>
                        <!-- user login dropdown end -->
                    </ul>
                    <?php
                    $message = $this->session->flashdata('feedback');
                    if (!empty($message)) {
                        ?>
                        <code class="flashmessage pull-right"> <?php echo $message; ?></code>
                    <?php } ?> 
                </div>
            </header>
            <!--header end-->
            <!--sidebar start-->

            <!--sidebar start-->
            <aside>
                <div id="sidebar"  class="nav-collapse">
                    <!-- sidebar menu start-->
                    <ul class="sidebar-menu" id="nav-accordion">
                        <li>
                            <a href="home"> 
                                <i class="fa fa-home"></i>
                                <span><?php echo lang('dashboard'); ?></span>
                            </a>
                        </li>
                        <?php if ($this->ion_auth->in_group('admin') || in_array('Department', $pers)) { ?>
                            <li>
                                <a href="department">
                                    <i class="fa fa-sitemap"></i>
                                    <span><?php echo lang('departments'); ?></span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php
                        if ($this->ion_auth->in_group('admin') || in_array('Users', $pers)) {
                            $permis = '';
                            $permis_1 = '';
                            foreach ($permission_access_group_explode as $perm) {
                                $perm_explode = array();
                                $perm_explode = explode(",", $perm);
                                if (in_array('2', $perm_explode) && $perm_explode[0] == 'Users') {
                                    $permis = 'ok';
                                    //  break;
                                }
                                if (in_array('1', $perm_explode) && $perm_explode[0] == 'Users') {
                                    $permis_1 = 'ok';
                                    //  break;
                                }
                            }
                            ?>
                            <li> <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-users"></i>
                                    <span><?php echo lang('users') ?></span>
                                </a>
                                <ul class="sub">

                                    <li><a href="users"><i class="fa fa-user"></i><?php echo lang('all_users'); ?></a></li>

                                    <?php if ($permis == 'ok' || $this->ion_auth->in_group('admin')) { ?>
                                        <li><a href="users/addUser"><i class="fa fa-plus-circle"></i><?php echo lang('add_user'); ?></a></li>
                                    <?php } ?>

                                    <li><a href="users/group"><i class="fa fa-user"></i><?php echo lang('all_roles'); ?></a></li>

                                    <?php if ($permis == 'ok' || $this->ion_auth->in_group('admin')) { ?>
                                        <li><a href="users/addGroup"><i class="fa fa-plus-circle"></i><?php echo lang('add_role'); ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if ($this->ion_auth->in_group(array('admin')) || in_array('Doctor', $pers) || in_array('Appointment', $pers) || in_array('Doctor-Visit', $pers)) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-user-md"></i>
                                    <span><?php echo lang('doctor'); ?></span>
                                </a>
                                <ul class="sub">
                                    <?php if ($this->ion_auth->in_group(array('admin')) || in_array('Doctor', $pers)) { ?>
                                        <li><a href="doctor"><i class="fa fa-user"></i><?php echo lang('list_of_doctors'); ?></a></li>
                                    <?php } ?>
                                    <?php if ($this->ion_auth->in_group(array('admin')) || in_array('Appointment', $pers)) { ?>
                                        <li><a href="appointment/treatmentReport"><i class="fa fa-history"></i><?php echo lang('treatment_history'); ?></a></li>
                                    <?php } ?>
                                    <?php if ($this->ion_auth->in_group(array('admin')) || in_array('Doctor-Visit', $pers)) { ?>
                                        <li><a href="doctor/doctorvisit"><i class="fa fa-clinic-medical"></i><?php echo lang('doctor_visit'); ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Nurse', 'Doctor', 'Laboratorist', 'Receptionist')) || in_array('Patient', $pers) || in_array('Patient-Category', $pers)) { ?>

                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-users-medical"></i> 
                                    <span><?php echo lang('patient'); ?></span>
                                </a>
                                <ul class="sub"> 
                                    <li><a href="patient"><i class="fa fa-user"></i><?php echo lang('patient_list'); ?></a></li>
                                    <?php if ($this->ion_auth->in_group(array('admin')) || in_array('Patient-Category', $pers)) { ?>
                                        <li><a href="pcategory"><i class="fa fa-list-alt"></i><?php echo lang('patient_category'); ?></a></li>
                                    <?php } ?>
                                    <?php if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Doctor', 'Receptionist')) || in_array('Patient', $pers)) { ?>
                                        <li><a href="patient/patientPayments"><i class="fa fa-money-check"></i><?php echo lang('payments'); ?></a></li>
                                    <?php } ?>
                                    <?php if (!$this->ion_auth->in_group(array('Accountant')) || in_array('Patient', $pers)) { ?>
                                        <li><a href="patient/caseList"><i class="fa fa-book"></i><?php echo lang('case'); ?> <?php echo lang('manager'); ?></a></li>

                                    <?php } if (!$this->ion_auth->in_group(array('Accountant', 'Receptionist')) || in_array('Patient', $pers)) { ?>
                                        <li><a href="patient/documents"><i class="fa fa-file"></i><?php echo lang('documents'); ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>


                        <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Receptionist')) || in_array('Schedule', $pers)) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-clock"></i> 
                                    <span><?php echo lang('schedule'); ?></span>
                                </a>
                                <ul class="sub"> 
                                    <li><a href="schedule"><i class="fa fa-list-alt"></i><?php echo lang('all'); ?> <?php echo lang('schedule'); ?></a></li>
                                    <li><a href="schedule/allHolidays"><i class="fa fa-list-alt"></i><?php echo lang('holidays'); ?></a></li> 
                                </ul>
                            </li>
                        <?php } ?>

                        <?php
                        if ($this->ion_auth->in_group(array('Doctor'))) {
                            ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-clock"></i> 
                                    <span><?php echo lang('schedule'); ?></span>
                                </a>
                                <ul class="sub"> 
                                    <li><a href="schedule/timeSchedule"><i class="fa fa-list-alt"></i><?php echo lang('all'); ?> <?php echo lang('schedule'); ?></a></li>
                                    <li><a href="schedule/holidays"><i class="fa fa-list-alt"></i><?php echo lang('holidays'); ?></a></li> 
                                </ul>
                            </li>
                        <?php } ?>

                        <?php
                        if ($this->ion_auth->in_group(array('admin', 'Doctor', 'Nurse', 'Receptionist')) || in_array('Appointment', $pers)) {
                            $permis = '';
                            $permis_1 = '';
                            foreach ($permission_access_group_explode as $perm) {
                                $perm_explode = array();
                                $perm_explode = explode(",", $perm);
                                if (in_array('2', $perm_explode) && $perm_explode[0] == 'Appointment') {
                                    $permis = 'ok';
                                    //  break;
                                }
                            }
                            ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-calendar-check"></i> 
                                    <span><?php echo lang('appointment'); ?></span>
                                </a>
                                <ul class="sub"> 
                                    <li><a href="appointment"><i class="fa fa-list-alt"></i><?php echo lang('all'); ?></a></li>
                                    <?php if ($permis == 'ok' || $this->ion_auth->in_group(array('admin', 'Doctor', 'Nurse', 'Receptionist'))) { ?>
                                        <li><a href="appointment/addNewView"><i class="fa fa-plus-circle"></i><?php echo lang('add'); ?></a></li>
                                    <?php } ?>
                                    <li><a href="appointment/todays"><i class="fa fa-list-alt"></i><?php echo lang('todays'); ?></a></li>
                                    <li><a href="appointment/upcoming"><i class="fa fa-list-alt"></i><?php echo lang('upcoming'); ?></a></li>
                                    <li><a href="appointment/calendar"><i class="fa fa-list-alt"></i><?php echo lang('calendar'); ?></a></li>
                                    <li><a href="appointment/request"><i class="fa fa-list-alt"></i><?php echo lang('request'); ?></a></li>                                   
                                </ul>
                            </li>
                        <?php } ?>


                        <?php if ($this->ion_auth->in_group(array(''))) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-headphones"></i> 
                                    <span><?php echo lang('live'); ?> <?php echo lang('meetings'); ?></span>
                                </a>
                                <ul class="sub"> 
                                    <?php if (!$this->ion_auth->in_group(array('Patient'))) { ?>
                                        <li><a href="meeting/addNewView"><i class="fa fa-plus-circle"></i><?php echo lang('create'); ?> <?php echo lang('meeting'); ?></a></li>
                                    <?php } ?>
                                    <li><a href="meeting"><i class="fa fa-video"></i><?php echo lang('live'); ?> <?php echo lang('now'); ?></a></li>
                                    <li><a href="meeting/upcoming"><i class="fa fa-list-alt"></i><?php echo lang('upcoming'); ?> <?php echo lang('meetings'); ?></a></li>
                                    <li><a href="meeting/previous"><i class="fa fa-list-alt"></i><?php echo lang('previous'); ?> <?php echo lang('meetings'); ?></a></li>
                                </ul>
                            </li>
                        <?php } ?> 



                        <?php if ($this->ion_auth->in_group(array(''))) { ?>
                            <li><a href="meeting"><i class="fa fa-headphones"></i><?php echo lang('join_live'); ?></a></li>
                        <?php } ?>

                        <?php if ($this->ion_auth->in_group(array('Patient'))) { ?>
                            <li><a href="appointment/myTodays"><i class="fa fa-headphones"></i><?php echo lang('todays'); ?> <?php echo lang('appointment'); ?></a></li>
                        <?php } ?>







                        <?php if ($this->ion_auth->in_group('admin') || in_array('Nurse', $pers) || in_array('Pharmacist', $pers) || in_array('Laboratorist', $pers) || in_array('Accountant', $pers) || in_array('Receptionist', $pers)) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-users"></i>
                                    <span><?php echo lang('human_resources'); ?></span>
                                </a>
                                <ul class="sub">
                                    <?php if ($this->ion_auth->in_group('admin') || in_array('Nurse', $pers)) { ?>
                                        <li><a href="nurse"><i class="fa fa-user"></i><?php echo lang('nurse'); ?></a></li>
                                    <?php } ?>
                                    <?php if ($this->ion_auth->in_group('admin') || in_array('Pharmacist', $pers)) { ?>
                                        <li><a href="pharmacist"><i class="fa fa-user"></i><?php echo lang('pharmacist'); ?></a></li>
                                    <?php } ?>
                                    <?php if ($this->ion_auth->in_group('admin') || in_array('Laboratorist', $pers)) { ?>
                                        <li><a href="laboratorist"><i class="fa fa-user"></i><?php echo lang('laboratorist'); ?></a></li>
                                    <?php } ?>
                                    <?php if ($this->ion_auth->in_group('admin') || in_array('Accountant', $pers)) { ?>
                                        <li><a href="accountant"><i class="fa fa-user"></i><?php echo lang('accountant'); ?></a></li>
                                    <?php } ?>
                                    <?php if ($this->ion_auth->in_group('admin') || in_array('Receptionist', $pers)) { ?>
                                        <li><a href="receptionist"><i class="fa fa-user"></i><?php echo lang('receptionist'); ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php
                        if ($this->ion_auth->in_group('admin') || in_array('Finance', $pers)) {
                            $permis = '';
                            $permis_1 = '';
                            foreach ($permission_access_group_explode as $perm) {
                                $perm_explode = array();
                                $perm_explode = explode(",", $perm);
                                if (in_array('2', $perm_explode) && $perm_explode[0] == 'Finance') {
                                    $permis = 'ok';
                                    //  break;
                                }
                            }
                            ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-money-check"></i>
                                    <span><?php echo lang('financial_activities'); ?></span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="finance/payment"><i class="fa fa-money-check"></i> <?php echo lang('payments'); ?></a></li>
                                    <?php if ($this->ion_auth->in_group('admin') || $permis == 'ok') { ?>
                                        <li><a  href="finance/addPaymentView"><i class="fa fa-plus-circle"></i><?php echo lang('add_payment'); ?></a></li>

                                    <?php } ?>

                                    <li><a  href="finance/expense"><i class="fa fa-money-check"></i><?php echo lang('expense'); ?></a></li>
                                    <?php if ($this->ion_auth->in_group('admin') || $permis == 'ok') { ?>

                                        <li><a  href="finance/addExpenseView"><i class="fa fa-plus-circle"></i><?php echo lang('add_expense'); ?></a></li>
                                    <?php } ?>
                                    <li><a  href="finance/expenseCategory"><i class="fa fa-edit"></i><?php echo lang('expense_categories'); ?> </a></li>


                                </ul>
                            </li> 
                        <?php } ?>
                        <?php
                        if ($this->ion_auth->in_group('admin') || in_array('Finance', $pers) || in_array('Medical-Data', $pers)) {
                            $permis = '';
                            $permis_1 = '';
                            foreach ($permission_access_group_explode as $perm) {
                                $perm_explode = array();
                                $perm_explode = explode(",", $perm);
                                if (in_array('2', $perm_explode) && $perm_explode[0] == 'Finance') {
                                    $permis = 'ok';
                                    //  break;
                                }
                            }
                            ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-file-medical-alt"></i>
                                    <span><?php echo lang('medical_data'); ?></span>
                                </a>
                                <ul class="sub">
                                    <?php if ($this->ion_auth->in_group('admin') || in_array('Medical-Data', $pers)) { ?>
                                        <li><a  href="finance/paymentCategory"><i class="fa fa-edit"></i><?php echo lang('payment_procedures'); ?></a></li>
                                    <?php } ?>
                                    <?php if ($this->ion_auth->in_group('admin') || in_array('Medical-Data', $pers)) { ?>
                                        <li><a  href="packages"><i class="fa fa-object-group"></i><?php echo lang('packages'); ?></a></li>
                                        <li><a  href="category"><i class="fa fa-list-alt"></i><?php echo lang('category'); ?></a></li>

                                    <?php } ?>


                                </ul>
                            </li> 
                        <?php } ?>
                        <?php if ($this->ion_auth->in_group('Receptionist')) { ?>
                            <li>
                                <a href="appointment/calendar" >
                                    <i class="fa fa-calendar"></i>
                                    <span> <?php echo lang('calendar'); ?> </span>
                                </a>
                            </li>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-money-check"></i>
                                    <span><?php echo lang('financial_activities'); ?></span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="finance/payment"><i class="fa fa-money-check"></i> <?php echo lang('payments'); ?></a></li>
                                    <li><a  href="finance/addPaymentView"><i class="fa fa-plus-circle"></i><?php echo lang('add_payment'); ?></a></li>
                                </ul>
                            </li> 
                        <?php } ?>



                        <?php if ($this->ion_auth->in_group(array('admin', 'Pharmacist')) || in_array('Prescription', $pers)) { ?>
                            <li>
                                <a href="prescription/all" >
                                    <i class="fas fa-prescription"></i>
                                    <span> <?php echo lang('prescription'); ?> </span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php
                        if ($this->ion_auth->in_group(array('Receptionist'))) {
                            ?>
                            <li>
                                <a href="lab/lab1">
                                    <i class="fas fa-file-medical"></i>
                                    <span><?php echo lang('lab_reports'); ?></span>
                                </a>
                            </li>
                            <?php
                        }
                        ?>

                        <?php
                        if ($this->ion_auth->in_group(array('Accountant', 'Receptionist'))) {
                            ?>
                            <li>
                                <a href="finance/UserActivityReport">
                                    <i class="fa fa-file-user"></i>
                                    <span><?php echo lang('user_activity_report'); ?></span>
                                </a>
                            </li>
                            <?php
                        }
                        ?>








                        <?php if ($this->ion_auth->in_group(array('Doctor'))) { ?>
                            <li>
                                <a href="prescription">
                                    <i class="fa fa-prescription"></i>
                                    <span><?php echo lang('prescription'); ?></span>
                                </a>
                            </li>
                        <?php } ?>



                        <?php
                        if ($this->ion_auth->in_group(array('admin', 'Doctor', 'Laboratorist')) || in_array('Lab', $pers)) {
                            $permis = '';
                            $permis_1 = '';
                            foreach ($permission_access_group_explode as $perm) {
                                $perm_explode = array();
                                $perm_explode = explode(",", $perm);
                                if (in_array('2', $perm_explode) && $perm_explode[0] == 'Lab') {
                                    $permis = 'ok';
                                    //  break;
                                }
                            }
                            ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa  fa-flask"></i>
                                    <span><?php echo lang('labs'); ?></span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="lab/toBeDone"><i class="fa fa-check"></i><?php echo lang('to_be_done'); ?></a></li>
                                    <li><a  href="lab"><i class="fa fa-file-medical"></i><?php echo lang('lab_reports'); ?></a></li>
                                    <?php if ($this->ion_auth->in_group(array('admin', 'Doctor', 'Laboratorist')) || $permis == 'ok') { ?>
                                        <li><a  href="lab/addLabView"><i class="fa fa-plus-circle"></i><?php echo lang('add_lab_report'); ?></a></li>
                                    <?php } ?>   
                                    <li><a  href="lab/template"><i class="fa fa-plus-circle"></i><?php echo lang('template'); ?></a></li>
                                </ul>
                            </li>
                        <?php } ?>







                        <?php
                        if ($this->ion_auth->in_group(array('admin')) || in_array('Hospital-Medicine', $pers)) {
                            $permis = '';
                            $permis_1 = '';
                            foreach ($permission_access_group_explode as $perm) {
                                $perm_explode = array();
                                $perm_explode = explode(",", $perm);
                                if (in_array('2', $perm_explode) && $perm_explode[0] == 'Hospital-Medicine') {
                                    $permis = 'ok';
                                    //  break;
                                }
                            }
                            ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa  fa-medkit"></i>
                                    <?php if ($this->ion_auth->in_group(array('admin'))) { ?> 
                                        <span><?php echo lang('hospital'); ?> <?php echo lang('medicine'); ?></span>
                                    <?php } else { ?><span><?php echo lang('medicine'); ?></span><?php } ?>
                                </a>
                                <ul class="sub">
                                    <li><a  href="medicine/internalMedicine"><i class="fa fa-medkit"></i><?php echo lang('medicine_list'); ?></a></li>
                                    <?php if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok') { ?>
                                        <li><a  href="medicine/addInternalMedicineView"><i class="fa fa-plus-circle"></i><?php echo lang('add_medicine'); ?></a></li>
                                    <?php } ?>
                                    <li><a  href="medicine/medicineInternalCategory"><i class="fa fa-edit"></i><?php echo lang('medicine_category'); ?></a></li>
                                    <?php if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok') { ?>
                                        <li><a  href="medicine/addInternalCategoryView"><i class="fa fa-plus-circle"></i><?php echo lang('add_medicine_category'); ?></a></li>
                                    <?php } ?>
                                    <li><a  href="medicine/medicineRequisition"><i class="fa fa-plus-circle"></i><?php echo lang('medicine_requisition'); ?></a></li>
                                    <li><a  href="medicine/internalMedicineStockAlert"><i class="fa fa-plus-circle"></i><?php echo lang('medicine_stock_alert'); ?></a></li>


                                </ul>
                            </li>
                        <?php } ?>








                        <?php
                        if ($this->ion_auth->in_group(array('admin', 'Pharmacist')) || in_array('Pharmacy', $pers)|| in_array('Medicine', $pers)) {
                            $permis = '';
                            $permis_1 = '';
                            foreach ($permission_access_group_explode as $perm) {
                                $perm_explode = array();
                                $perm_explode = explode(",", $perm);
                                if (in_array('2', $perm_explode) && $perm_explode[0] == 'Pharmacy') {
                                    $permis = 'ok';
                                    //  break;
                                }
                                if (in_array('1', $perm_explode) && $perm_explode[0] == 'Pharmacy') {
                                    $permis_1 = 'ok';
                                    //  break;
                                }
                                if (in_array('2', $perm_explode) && $perm_explode[0] == 'Medicine') {
                                    $permis_2 = 'ok';
                                    //  break;
                                }
                                if (in_array('1', $perm_explode) && $perm_explode[0] == 'Medicine') {
                                    $permis_3 = 'ok';
                                    //  break;
                                }
                            }
                            ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fas fa-capsules"></i>
                                    <span><?php echo lang('pharmacy'); ?></span>
                                </a>
                                <ul class="sub">
                                    <?php if ($this->ion_auth->in_group(array('admin')) || in_array('Medicine', $pers) ) { ?>


                                        <li class="sub-menu">
                                            <a href="javascript:;" >
                                                <i class="fa  fa-medkit"></i>
                                                <span><?php echo lang('medicine'); ?></span>
                                            </a>
                                            <ul class="sub">
                                                <li><a  href="medicine"><i class="fa fa-medkit"></i><?php echo lang('medicine_list'); ?></a></li>
                                                <?php if ($this->ion_auth->in_group(array('admin')) || $permis_2 == 'ok') { ?>
                                                    <li><a  href="medicine/addmedicineView"><i class="fa fa-plus-circle"></i><?php echo lang('add_medicine'); ?></a></li>
                                                <?php } ?>
                                                <li><a  href="medicine/medicineCategory"><i class="fa fa-edit"></i><?php echo lang('medicine_category'); ?></a></li>
                                                <?php if ($this->ion_auth->in_group(array('admin')) || $permis_2 == 'ok') { ?>
                                                    <li><a  href="medicine/addCategoryView"><i class="fa fa-plus-circle"></i><?php echo lang('add_medicine_category'); ?></a></li>
                                                <?php } ?>
                                                  <li><a  href="finance/pharmacy/medicineRequisition"><i class="fa fa-plus-circle"></i><?php echo lang('requisition'); ?> <?php echo lang('list') ?></a></li>
                                                <li><a  href="supply"><i class="fa fa-medkit"></i><?php echo lang('supply'); ?> <?php echo lang('invoices'); ?></a></li>
                                                <li><a  href="supply/addNewSupply"><i class="fa fa-medkit"></i><?php echo lang('add'); ?> <?php echo lang('supply'); ?> <?php echo lang('medicine'); ?></a></li>
                                                <li><a  href="medicine/medicineStockAlert"><i class="fa fa-plus-circle"></i><?php echo lang('medicine_stock_alert'); ?></a></li>


                                            </ul>
                                        </li>
                                    <?php } ?>
                                    <?php if (!$this->ion_auth->in_group(array('Pharmacist'))) { ?>
                                        <li><a  href="finance/pharmacy/home"><i class="fa fa-home"></i> <?php echo lang('dashboard'); ?></a></li>
                                    <?php } ?>
                                    <li><a  href="finance/pharmacy/payment"><i class="fa fa-money-check"></i> <?php echo lang('sales'); ?></a></li>
                                    <?php if ($this->ion_auth->in_group(array('admin', 'Pharmacist')) || $permis == 'ok') { ?>
                                        <li><a  href="finance/pharmacy/addPaymentView"><i class="fa fa-plus-circle"></i><?php echo lang('add_new_sale'); ?></a></li>
                                    <?php } ?>
                                    <li><a  href="finance/pharmacy/expense"><i class="fa fa-money-check"></i><?php echo lang('expense'); ?></a></li>
                                    <?php if ($this->ion_auth->in_group(array('admin', 'Pharmacist')) || $permis == 'ok') { ?>
                                        <li><a  href="finance/pharmacy/addExpenseView"><i class="fa fa-plus-circle"></i><?php echo lang('add_expense'); ?></a></li>
                                    <?php } ?>
                                    <li><a  href="finance/pharmacy/expenseCategory"><i class="fa fa-edit"></i><?php echo lang('expense_categories'); ?> </a></li>


                                    <?php if ($this->ion_auth->in_group(array('admin', 'Pharmacist')) || (in_array('Pharmacy', $pers) && $permis_1 == 'ok')) { ?>
                                        <li class="sub-menu">
                                            <a href="javascript:;" >
                                                <i class="fas fa-file-medical-alt"></i>
                                                <span><?php echo lang(''); ?> <?php echo lang('report'); ?></span>
                                            </a>
                                            <ul class="sub">
                                                <li><a  href="finance/pharmacy/financialReport"><i class="fa fa-book"></i><?php echo lang('pharmacy'); ?> <?php echo lang('report'); ?> </a></li>
                                                <?php if ($this->ion_auth->in_group(array('admin', 'Pharmacist')) || (in_array('Pharmacy', $pers))) { ?>
                                                    <li><a  href="finance/pharmacy/inventoryReport"><i class="fa fa-book"></i><?php echo lang('inventory'); ?> <?php echo lang('report'); ?> </a></li>
                                                <?php } ?>
                                                <li><a  href="finance/pharmacy/monthly"><i class="fa fa-chart-bar"></i> <?php echo lang('monthly_sales'); ?> </a></li>
                                                <li><a  href="finance/pharmacy/daily"><i class="fa fa-chart-bar"></i> <?php echo lang('daily_sales'); ?> </a></li>
                                                <li><a  href="finance/pharmacy/monthlyExpense"><i class="fa fa-chart-area"></i> <?php echo lang('monthly_expense'); ?> </a></li>
                                                <li><a  href="finance/pharmacy/dailyExpense"><i class="fa fa-chart-area"></i> <?php echo lang('daily_expense'); ?> </a></li>                              
                                            </ul>
                                        </li> 
                                    <?php } ?>



                                </ul>
                            </li> 
                        <?php } ?>










                        <?php
                        if ($this->ion_auth->in_group(array('admin', 'Laboratorist')) || in_array('Donor', $pers)) {
                            $permis = '';
                            $permis_1 = '';
                            foreach ($permission_access_group_explode as $perm) {
                                $perm_explode = array();
                                $perm_explode = explode(",", $perm);
                                if (in_array('2', $perm_explode) && $perm_explode[0] == 'Donor') {
                                    $permis = 'ok';
                                    //  break;
                                }
                            }
                            ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa  fa-hand-holding-water"></i>
                                    <span><?php echo lang('donor') ?></span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="donor"><i class="fa fa-user"></i><?php echo lang('donor_list'); ?></a></li>
                                    <?php if ($this->ion_auth->in_group(array('admin', 'Laboratorist')) || $permis == 'ok') { ?>
                                        <li><a  href="donor/addDonorView"><i class="fa fa-plus-circle"></i><?php echo lang('add_donor'); ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>


                        <?php if ($this->ion_auth->in_group(array('admin', 'Laboratorist')) || in_array('Donor', $pers)) { ?>
                            <li><a  href="donor/bloodBank"><i class="fa fa-tint"></i><?php echo lang('blood_bank'); ?></a></li>
                        <?php } ?>   




                        <?php
                        if ($this->ion_auth->in_group(array('admin')) || in_array('Bed', $pers) || in_array('Patient-Service', $pers)) {
                            $permis = '';
                            $permis_1 = '';
                            foreach ($permission_access_group_explode as $perm) {
                                $perm_explode = array();
                                $perm_explode = explode(",", $perm);
                                if (in_array('2', $perm_explode) && $perm_explode[0] == 'Bed') {
                                    $permis = 'ok';
                                    //  break;
                                }
                            }
                            ?>
                            <li class="sub-menu">
                                <a href="javascript:;" > 
                                    <i class="fas fa-procedures"></i>
                                    <span><?php echo lang('bed'); ?></span>
                                </a>
                                <ul class="sub">
                                    <?php if ($this->ion_auth->in_group(array('admin')) || in_array('Bed', $pers)) { ?>
                                        <li><a  href="bed"><i class="fas fa-procedures"></i><?php echo lang('bed_list'); ?></a></li>
                                    <?php } if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok') { ?>
                                        <li><a  href="bed/addBedView"><i class="fa fa-plus-circle"></i><?php echo lang('add_bed'); ?></a></li>
                                    <?php } ?>
                                    <?php if ($this->ion_auth->in_group(array('admin')) || in_array('Patient-Service', $pers)) { ?>
                                        <li><a  href="pservice"><i class="fa fa-smile"></i><?php echo lang('patient'); ?> <?php echo lang('service'); ?></a></li>
                                        <?php
                                    }
                                    if ($this->ion_auth->in_group(array('admin')) || in_array('Bed', $pers)) {
                                        ?>
                                        <li><a  href="bed/bedCategory"><i class="fa fa-edit"></i><?php echo lang('bed_category'); ?></a></li>
                                        <li><a  href="bed/bedAllotment"><i class="fas fa-bed"></i><?php echo lang('bed_allotments'); ?></a></li>
                                    <?php } if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok') { ?>
                                        <li><a  href="bed/addAllotmentView"><i class="fa fa-plus-circle"></i><?php echo lang('add_allotment'); ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php
                        if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Laboratorist', 'Doctor')) || in_array('Report', $pers)) {
                            $permis = '';
                            $permis_1 = '';
                            foreach ($permission_access_group_explode as $perm) {
                                $perm_explode = array();
                                $perm_explode = explode(",", $perm);
                                if (in_array('2', $perm_explode) && $perm_explode[0] == 'Report') {
                                    $permis_1 = 'ok';
                                    //  break;
                                }
                                if (in_array('1', $perm_explode) && $perm_explode[0] == 'Report') {
                                    $permis = 'ok';
                                    //  break;
                                }
                            }
                            ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fas fa-file-medical-alt"></i>
                                    <span><?php echo lang('report'); ?></span>
                                </a>
                                <ul class="sub">
                                    <?php if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok') { ?>
                                        <li><a  href="finance/faturime"><i class="fa fa-book"></i><?php echo lang('faturime'); ?></a></li>
                                        <li><a  href="finance/financialReport"><i class="fa fa-book"></i><?php echo lang('financial_report'); ?></a></li>
                                        <li> <a href="finance/AllUserActivityReport">  <i class="fa fa-home"></i>   <span><?php echo lang('user_activity_report'); ?></span> </a></li>
                                    <?php } ?>

                                    <?php if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok') { ?>
                                        <li><a  href="finance/doctorsCommission"><i class="fa fa-edit"></i><?php echo lang('doctors_commission'); ?> </a></li>
                                        <li><a  href="finance/monthly"><i class="fa fa-chart-bar"></i> <?php echo lang('monthly_sales'); ?> </a></li>
                                        <li><a  href="finance/daily"><i class="fa fa-chart-bar"></i> <?php echo lang('daily_sales'); ?> </a></li>
                                        <li><a  href="finance/monthlyExpense"><i class="fa fa-chart-area"></i> <?php echo lang('monthly_expense'); ?> </a></li>
                                        <li><a  href="finance/dailyExpense"><i class="fa fa-chart-area"></i> <?php echo lang('daily_expense'); ?> </a></li>                              



                                    <?php } ?>
                                    <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Laboratorist', 'Doctor')) || in_array("Report", $pers)) { ?>

                                        <li><a  href="report/birth"><i class="fas fa-file-medical"></i><?php echo lang('birth_report'); ?></a></li>
                                        <li><a  href="report/operation"><i class="fa fa-wheelchair"></i><?php echo lang('operation_report'); ?></a></li>
                                        <li><a  href="report/expire"><i class="fas fa-file-medical"></i><?php echo lang('expire_report'); ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>


                        <?php
                        if ($this->ion_auth->in_group(array('admin')) || in_array('Notice', $pers)) {
                            $permis = '';
                            $permis_1 = '';
                            foreach ($permission_access_group_explode as $perm) {
                                $perm_explode = array();
                                $perm_explode = explode(",", $perm);
                                if (in_array('2', $perm_explode) && $perm_explode[0] == 'Notice') {
                                    $permis = 'ok';
                                    //  break;
                                }
                            }
                            ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-bells"></i>
                                    <span><?php echo lang('notice'); ?></span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="notice"><i class="fa fa-bells"></i><?php echo lang('notice'); ?></a></li>
                                    <?php if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok') { ?>
                                        <li><a  href="notice/addNewView"><i class="fa fa-list-alt"></i><?php echo lang('add_new'); ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li> 
                        <?php } ?>

                        <?php
                        if ($this->ion_auth->in_group(array('admin')) || in_array('Email', $pers)) {
                            $permis = '';
                            $permis_1 = '';
                            $permis_2 = '';
                            foreach ($permission_access_group_explode as $perm) {
                                $perm_explode = array();
                                $perm_explode = explode(",", $perm);
                                if (in_array('2', $perm_explode) && $perm_explode[0] == 'Email') {
                                    $permis = 'ok';
                                    //  break;
                                }
                                if (in_array('1', $perm_explode) && $perm_explode[0] == 'Email') {
                                    $permis_1 = 'ok';
                                    //  break;
                                }
                                if (in_array('3', $perm_explode) && $perm_explode[0] == 'Email') {
                                    $permis_2 = 'ok';
                                    //  break;
                                }
                            }
                            ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-mail-bulk"></i>
                                    <span><?php echo lang('email'); ?></span>
                                </a>
                                <ul class="sub">

                                    <li><a  href="email/autoEmailTemplate"><i class="fa fa-robot"></i><?php echo lang('autoemailtemplate'); ?></a></li>

                                    <?php if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok') { ?>
                                        <li><a  href="email/sendView"><i class="fa fa-location-arrow"></i><?php echo lang('new'); ?></a></li>
                                    <?php } ?>

                                    <li><a  href="email/sent"><i class="fa fa-list-alt"></i><?php echo lang('sent'); ?></a></li>

                                    <?php if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok') { ?>
                                        <li><a  href="email/emailSettings"><i class="fa fa-cogs"></i><?php echo lang('settings'); ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li> 
                        <?php } ?>

                        <?php
                        if ($this->ion_auth->in_group(array('admin')) || in_array('SMS', $pers)) {
                            $permis = '';
                            $permis_1 = '';
                            $permis_2 = '';
                            foreach ($permission_access_group_explode as $perm) {
                                $perm_explode = array();
                                $perm_explode = explode(",", $perm);
                                if (in_array('2', $perm_explode) && $perm_explode[0] == 'SMS') {
                                    $permis = 'ok';
                                    //  break;
                                }
                                if (in_array('1', $perm_explode) && $perm_explode[0] == 'SMS') {
                                    $permis_1 = 'ok';
                                    //  break;
                                }
                                if (in_array('3', $perm_explode) && $perm_explode[0] == 'SMS') {
                                    $permis_2 = 'ok';
                                    //  break;
                                }
                            }
                            ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-sms"></i>
                                    <span><?php echo lang('sms'); ?></span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="sms/autoSMSTemplate"><i class="fa fa-robot"></i><?php echo lang('autosmstemplate'); ?></a></li>
                                    <?php if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok') { ?>
                                        <li><a  href="sms/sendView"><i class="fa fa-location-arrow"></i><?php echo lang('write_message'); ?></a></li>
                                    <?php } ?>
                                    <li><a  href="sms/sent"><i class="fa fa-list-alt"></i><?php echo lang('sent_messages'); ?></a></li>
                                    <?php if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok') { ?>
                                        <li><a  href="sms"><i class="fa fa-cogs"></i><?php echo lang('sms_settings'); ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li> 
                        <?php } ?>
                        <?php
                        if ($this->ion_auth->in_group(array('admin')) || in_array('Website', $pers)) {
                            $permis = '';
                            $permis_1 = '';
                            $permis_2 = '';
                            foreach ($permission_access_group_explode as $perm) {
                                $perm_explode = array();
                                $perm_explode = explode(",", $perm);
                                if (in_array('2', $perm_explode) && $perm_explode[0] == 'Website') {
                                    $permis = 'ok';
                                    //  break;
                                }
                                if (in_array('1', $perm_explode) && $perm_explode[0] == 'Website') {
                                    $permis_1 = 'ok';
                                    //  break;
                                }
                                if (in_array('3', $perm_explode) && $perm_explode[0] == 'Website') {
                                    $permis_2 = 'ok';
                                    //  break;
                                }
                            }
                            ?>

                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fas fa-globe"></i>
                                    <span><?php echo lang('website'); ?></span>
                                </a>
                                <ul class="sub">
                                    <li><a href="frontend" target="_blank" ><i class="fa fa-globe"></i><?php echo lang('visit_site'); ?></a></li>
                                    <?php if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok') { ?>
                                        <li><a href="frontend/settings"><i class="fa fa-cog"></i><?php echo lang('website_settings'); ?></a></li>
                                    <?php } ?>
                                    <li><a href="review"><i class="fa fa-cog"></i><?php echo lang('reviews'); ?></a></li>
                                    <li><a href="gridsection"><i class="fa fa-cog"></i><?php echo lang('gridsections'); ?></a></li>
                                    <li><a href="gallery"><i class="fa fa-cog"></i><?php echo lang('gallery'); ?></a></li>
                                    <li><a href="slide"><i class="fa fa-wrench"></i><?php echo lang('slides'); ?></a></li>
                                    <li><a href="service"><i class="fab fa-servicestack"></i><?php echo lang('services'); ?></a></li>
                                    <li><a href="featured"><i class="fa fa-address-card"></i><?php echo lang('featured_doctors'); ?></a></li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php
                        if ($this->ion_auth->in_group(array('admin')) || in_array('Settings', $pers) || in_array('Bulk Import', $pers) || in_array('Payment Settings', $pers)) {
                            $permis = '';
                            $permis_1 = '';
                            foreach ($permission_access_group_explode as $perm) {
                                $perm_explode = array();
                                $perm_explode = explode(",", $perm);
                                if (in_array('2', $perm_explode) && $perm_explode[0] == 'Settings') {
                                    $permis = 'ok';
                                    //  break;
                                }
                            }
                            ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-cogs"></i>
                                    <span><?php echo lang('settings'); ?></span>
                                </a>
                                <ul class="sub"> 
                                    <?php if ($this->ion_auth->in_group(array('admin')) || in_array('Settings', $pers)) { ?>
                                        <li><a href="settings"><i class="fa fa-cog"></i><?php echo lang('system_settings'); ?></a></li>
                                    <?php } ?>
                                    <?php if ($this->ion_auth->in_group(array('admin')) || in_array('Payment Settings', $pers)) { ?>
                                        <li><a href="pgateway"><i class="fa fa-credit-card"></i><?php echo lang('payment_gateway'); ?></a></li>
                                    <?php } ?>
                                    <?php if ($this->ion_auth->in_group(array('admin')) || in_array('Settings', $pers)) { ?>
                                        <li><a href="settings/language"><i class="fa fa-language"></i><?php echo lang('language'); ?></a></li>
                                    <?php } ?>
                                    <?php if ($this->ion_auth->in_group(array('admin')) || in_array('Bulk Import', $pers)) { ?>

                                        <li><a href="import"><i class="fa fa-arrow-right"></i><?php echo lang('bulk'); ?> <?php echo lang('import'); ?></a></li>
                                    <?php } ?>
                                    <?php if ($this->ion_auth->in_group(array('admin')) || $permis == 'ok') { ?>
                                        <li><a href="settings/backups"><i class="fa fa-database"></i><?php echo lang('backup_database'); ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>





                        <?php } ?>

                        <!--
                        <?php if ($this->ion_auth->in_group('Doctor')) { ?>
                                                                                                                                                            <li><a href="meeting/settings"><i class="fa fa-headphones"></i><?php echo lang('zoom'); ?> <?php echo lang('settings'); ?></a></li>
                        <?php } ?>
                        -->







                        <?php if ($this->ion_auth->in_group('Accountant')) { ?>

                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-money-bill-alt"></i>
                                    <span><?php echo lang('payments'); ?></span>
                                </a>
                                <ul class="sub">
                                    <li>
                                        <a href="finance/payment" >
                                            <i class="fa fa-money-check"></i>
                                            <span> <?php echo lang('payments'); ?> </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="finance/addPaymentView" >
                                            <i class="fa fa-plus-circle"></i>
                                            <span> <?php echo lang('add_payment'); ?> </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="finance/paymentCategory" >
                                            <i class="fa fa-edit"></i>
                                            <span> <?php echo lang('payment_procedures'); ?> </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="finance/expense" >
                                    <i class="fa fa-money-check"></i>
                                    <span> <?php echo lang('expense'); ?> </span>
                                </a>
                            </li>
                            <li>
                                <a href="finance/addExpenseView" >
                                    <i class="fa fa-plus-circle"></i>
                                    <span> <?php echo lang('add_expense'); ?> </span>
                                </a>
                            </li>
                            <li>
                                <a href="finance/expenseCategory" >
                                    <i class="fa fa-edit"></i>
                                    <span> <?php echo lang('expense_categories'); ?> </span>
                                </a>
                            </li>
                            <li>
                                <a href="finance/doctorsCommission" >
                                    <i class="fa fa-edit"></i>
                                    <span> <?php echo lang('doctors_commission'); ?> </span>
                                </a>
                            </li>
                            <li>
                                <a href="finance/financialReport" >
                                    <i class="fa fa-book"></i>
                                    <span> <?php echo lang('financial_report'); ?> </span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if ($this->ion_auth->in_group('Pharmacist')) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa  fa-medkit"></i>
                                    <span><?php echo lang('supply'); ?> <?php echo lang('medicine'); ?></span>
                                </a>
                                <ul class="sub">

                                    <li><a  href="supply"><i class="fa fa-medkit"></i><?php echo lang('supply'); ?> <?php echo lang('invoices'); ?></a></li>
                                    <li><a  href="supply/addNewSupply"><i class="fa fa-medkit"></i><?php echo lang('add'); ?> <?php echo lang('supply'); ?> <?php echo lang('medicine'); ?></a></li>


                                </ul>
                            </li>
                            <li><a  href="finance/pharmacy/medicineRequisition"><i class="fa fa-plus-circle"></i><?php echo lang('medicine_requisition'); ?> <?php echo lang('list') ?></a></li>
                            <li>
                                <a href="medicine" >
                                    <i class="fa fa-medkit"></i>
                                    <span> <?php echo lang('medicine_list'); ?> </span>
                                </a>
                            </li>
                            <li>
                                <a href="medicine/addMedicineView" >
                                    <i class="fa fa-plus-circle"></i>
                                    <span> <?php echo lang('add_medicine'); ?> </span>
                                </a>
                            </li>
                            <li>
                                <a href="medicine/medicineCategory" >
                                    <i class="fa fa-medkit"></i>
                                    <span> <?php echo lang('medicine_category'); ?> </span>
                                </a>
                            </li>
                            <li>
                                <a href="medicine/addCategoryView" >
                                    <i class="fa fa-plus-circle"></i>
                                    <span> <?php echo lang('add_medicine_category'); ?> </span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if ($this->ion_auth->in_group('Nurse')) { ?>
                            <li>
                                <a href="bed" >
                                    <i class="fa fa-procedures"></i>
                                    <span> <?php echo lang('bed_list'); ?> </span>
                                </a>
                            </li>
                            <li>
                                <a href="bed/bedCategory" >
                                    <i class="fa fa-edit"></i>
                                    <span> <?php echo lang('bed_category'); ?> </span>
                                </a>
                            </li>
                            <li>
                                <a href="bed/bedAllotment" >
                                    <i class="fa fa-plus-circle"></i>
                                    <span> <?php echo lang('bed_allotments'); ?> </span>
                                </a>
                            </li>
                            <li>
                                <a href="donor" >
                                    <i class="fa fa-medkit"></i>
                                    <span> <?php echo lang('donor'); ?> </span>
                                </a>
                            </li>
                            <li>
                                <a href="donor/bloodBank" >
                                    <i class="fa fa-tint"></i>
                                    <span> <?php echo lang('blood_bank'); ?> </span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if ($this->ion_auth->in_group('Patient')) { ?>

                            <li>
                                <a href="lab/myLab" >
                                    <i class="fa fa-file-medical-alt"></i>
                                    <span> <?php echo lang('diagnosis'); ?> <?php echo lang('reports'); ?> </span>
                                </a>
                            </li>

                            <li>
                                <a href="patient/calendar" >
                                    <i class="fa fa-calendar"></i>
                                    <span> <?php echo lang('appointment'); ?> <?php echo lang('calendar'); ?> </span>
                                </a>
                            </li>

                            <li>
                                <a href="patient/myCaseList" >
                                    <i class="fa fa-file-medical"></i>
                                    <span>  <?php echo lang('cases'); ?> </span>
                                </a>
                            </li>
                            <li>
                                <a href="patient/myPrescription" >
                                    <i class="fa fa-medkit"></i>
                                    <span> <?php echo lang('prescription'); ?>  </span>
                                </a>
                            </li>

                            <li>
                                <a href="patient/myDocuments" >
                                    <i class="fa fa-file-upload"></i>
                                    <span> <?php echo lang('documents'); ?> </span>
                                </a>
                            </li>

                            <li>
                                <a href="patient/myPaymentHistory" >
                                    <i class="fa fa-money-bill-alt"></i>
                                    <span> <?php echo lang('payment'); ?> </span>      
                                </a>
                            </li>

                            <li>
                                <a href="report/myreports" >
                                    <i class="fa fa-file-medical-alt"></i>
                                    <span> <?php echo lang('other'); ?> <?php echo lang('reports'); ?> </span>
                                </a>
                            </li>

                            <li>
                                <a href="donor" >
                                    <i class="fa fa-user"></i>
                                    <span><?php echo lang('donor'); ?></span>
                                </a>
                            </li>

                        <?php } ?>

                        <?php if ($this->ion_auth->in_group('im')) { ?>
                            <li>
                                <a href="patient/addNewView" >
                                    <i class="fa fa-user"></i>
                                    <span> <?php echo lang('add_patient'); ?> </span>
                                </a>
                            </li>
                            <li>
                                <a href="finance/addPaymentView" >
                                    <i class="fa fa-user"></i>
                                    <span> <?php echo lang('add_payment'); ?>  </span>
                                </a>
                            </li>
                        <?php } ?>


                        <?php if (!$this->ion_auth->in_group(array('admin', 'Patient')) && !in_array('Email', $pers)) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-mail-bulk"></i>
                                    <span><?php echo lang('email'); ?></span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="email/sendView"><i class="fa fa-location-arrow"></i><?php echo lang('new'); ?></a></li>
                                </ul>
                            </li> 
                        <?php } ?> 

                        <?php if ($this->ion_auth->in_group(array('admin')) || in_array('Log', $pers)) { ?>

                            <li>
                                <a href="log" >
                                    <i class="fa fa-history"></i>
                                    <span> <?php echo lang('log'); ?> </span>
                                </a>
                            </li>
                        <?php } ?>
                        <li>
                            <a href="profile" >
                                <i class="fa fa-user"></i>
                                <span> <?php echo lang('profile'); ?> </span>
                            </a>
                        </li>

                        <!--multi level menu start-->

                        <!--multi level menu end-->

                    </ul>
                    <!-- sidebar menu end-->
                </div>
            </aside>
            <!--sidebar end-->