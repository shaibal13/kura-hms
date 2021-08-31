<!DOCTYPE html>
<html lang="en">
    <?php
    $settings = $this->frontend_model->getSettings();
    $title = explode(' ', $settings->title);
    $site_name = $this->db->get('website_settings')->row()->title;
    ?>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link rel="icon" href="../../../../favicon.ico" />
        <title><?php echo $site_name; ?></title>

        <!-- Bootstrap Core CSS -->
        <link rel="stylesheet" href="<?php echo site_url('front/site_assets/vendor/bootstrap/css/bootstrap.min.css'); ?>" />
        <!-- Font-awesome -->
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />

        <!-- jQuery Plugins -->
        <link rel="stylesheet" href="<?php echo site_url('front/site_assets/vendor/owl-carousel/owl.carousel.min.css'); ?>" />
        <link rel="stylesheet" href="<?php echo site_url('front/site_assets/vendor/magnific-popup/magnific-popup.css'); ?>" />
        <link rel="stylesheet" href="<?php echo site_url('common/assets/bootstrap-datepicker/css/bootstrap-datepicker.css'); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo site_url('common/assets/bootstrap-timepicker/compiled/timepicker.css'); ?>">
        <!--<link rel="stylesheet" href="<?php echo site_url('front/css/style.css'); ?>">-->
        <link rel="stylesheet" href="<?php echo site_url('front/css/responsive.css'); ?>">

        <link rel="stylesheet" href="<?php echo site_url('front/assets/revolution_slider/css/rs-style.css'); ?>" media="screen">
        <link rel="stylesheet" href="<?php echo site_url('front/assets/revolution_slider/rs-plugin/css/settings.css'); ?>" media="screen">
        <!-- CSS Stylesheet -->
        <link href="<?php echo site_url('front/site_assets/css/style.css'); ?>" rel="stylesheet" />
        <link href="<?php echo site_url('front/site_assets/css/responsive.css') ?>" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo site_url('common/toastr/toastr.css'); ?>" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"/>
    </head>
    <style>
        .topbar-texts, .footer-description {
            font-family: "Roboto", sans-serif !important;
            font-size: 15px !important;
        }


    </style>
    <body onload="myFunction()">
        <div id="loading"></div>

        <!---------------- Start Main Navbar ---------------->
        <div id="header_menu_top" class="bg-dark text-white pt-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p class="topbar-texts"><?php echo $settings->address; ?></p>
                    </div>
                    <div class="col-md-4">
                        <p class="topbar-texts float-right ml-3">
                            <i class="fa fa-phone" aria-hidden="true"></i> &nbsp;
                            <span><?php echo $settings->phone; ?></span>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <a href="<?php echo site_url('auth/login') ?>" class="float-right"><i class="fa fa-sign-in" aria-hidden="true"></i> &nbsp; <span>Sign In</span></a>
                    </div>
                </div>
            </div>
        </div>
        <div id="header">
            <div class="navbar-wrap">
                <nav id="navbar_top" class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container">
                        <a class="navbar-brand" href="#">
                            <?php
                            if (!empty($settings->logo)) {
                                if (file_exists($settings->logo)) {
                                    echo '<img width="200" src=' . $settings->logo . '>';
                                } else {
                                    echo $title[0] . '<span> ' . $title[1] . '</span>';
                                }
                            } else {
                                echo $title[0] . '<span> ' . $title[1] . '</span>';
                            }
                            ?>
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item ml-3">
                                    <a class="nav-link" href="#"><?php echo lang('home'); ?></a>
                                </li>
                                <li class="nav-item ml-3">
                                    <a class="nav-link" href="#why_choose_us"><?php echo lang('book_an_appointment'); ?></a>
                                </li>
                                <li class="nav-item ml-3">
                                    <a class="nav-link" href="#featured_services"><?php echo lang('services'); ?></a>
                                </li>
                                <li class="nav-item ml-3">
                                    <a class="nav-link" href="#doctor"><?php echo lang('doctors'); ?></a>
                                </li>
                                <li class="nav-item ml-3">
                                    <a class="nav-link" href="#portfolio"><?php echo lang('portfolio'); ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="owl-carousel headerSlider">
                <?php foreach ($slides as $slide) { ?>
                    <div style="background-image: url('<?php echo site_url($slide->img_url); ?>'); background-size: cover; background-position: center;">
                        <div class="jumbotron jumbotron-fluid text-white">
                            <div class="container">
                                <h1><?php echo $slide->text1; ?></h1>
                                <h4><?php echo $slide->text2; ?></h4>
                                <p class="py-4"><?php echo $slide->text3; ?></p>
                                <a type="button" href="#why_choose_us" class="btn btn-light"><?php echo lang('get_started_now'); ?></a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!--<?php if (count($slides) > 1) {
                    ?>
                                                                            <style>
                                                                                #header .owl-nav,#header .owl-dots {
                                                                                        display: block;
                                                                                    }
                                                                            </style>
            <?php }
            ?>-->



            <!--<div class="jumbotron jumbotron-fluid text-white mt-3">
                <div class="container">
                    <h1><?php echo $slide->text1; ?></h1>
                    <h4><?php echo $slide->text2; ?></h4>
                    <p class="py-4">
            <?php echo $slide->text3; ?>
                    </p>
                    <h1>The best doctors in <b>Medicine!</b></h1>
                    <h4>in the world of modern medicine</h4>
                    <p class="py-4">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                    </p>
                    <a type="button" href="#why_choose_us" class="btn btn-light">Get Started Now</a>
                </div>
            </div> -->       
        </div>
        <!---------------- End Main Navbar ---------------->

        <!---------------- Start Why Choose Us ---------------->
        <div id="why_choose_us" class="my-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <?php
                        $message = $this->session->flashdata('feedback');
                        if (!empty($message)) {
                            ?>
                            <div class="flashmessage col-md-12" style="text-align: center;
                                 color: green;
                                 font-size: 23px;
                                 font-weight: 500;"> <?php echo $message; ?></div>

                        <?php } ?>
                    </div>
                    <div class="col-md-6 d-flex align-items-center mb-4">
                        <div>
                            <h6><?php echo $settings->appointment_subtitle; ?></h6>
                            <h4><?php echo $settings->appointment_title; ?></h4>
                            <p>
                                <?php echo $settings->appointment_description; ?>
                            </p>
                            <a type="button" data-toggle="modal" data-target="#exampleModal" href="#" class="btn btn-light">Book An Appointment</a>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content bg-success text-white">
                                        <div class="modal-header" style="background: #009988 !important;">
                                            <h5 class="modal-title" id="exampleModalLabel">
                                                <?php echo lang('book_an_appointment'); ?>
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" style="border: transparent !important;">
                                            <form action="<?php echo site_url('frontend/addNew'); ?>" method="post" id="addAppointmentForm">
                                                <!--   <form action="frontend/addNew" method="post">-->
                                                <label for="exampleInputEmail1"> <?php echo lang('patient'); ?></label>
                                                <select class="form-control m-bot15 js-example-basic-single pos_select" id="pos_select" name="patient" value=''> 
                                                    <option value=" ">Select .....</option>
                                                    <option value="patient_id" style="color: #41cac0 !important;"><?php echo lang('patient_id'); ?></option>
                                                    <option value="add_new" style="color: #41cac0 !important;"><?php echo lang('add_new'); ?></option>
                                                </select>

                                                <div class="pos_client_id clearfix">

                                                    <div class="col-md-12 payment pad_bot pull-right">
                                                        <div class="col-md-3 payment_label"> 
                                                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('id'); ?></label>
                                                        </div>
                                                        <div class="col-md-9"> 
                                                            <input type="text" class="form-control pay_in" name="patient_id" placeholder="">
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="pos_client clearfix">

                                                    <label for=""><?php echo lang('patient'); ?> <?php echo lang('name'); ?></label>
                                                    <input type="text" class="form-control" name="p_name">
                                                    <label for=""><?php echo lang('patient'); ?> <?php echo lang('email'); ?></label>
                                                    <input type="email" class="form-control" name="p_email">
                                                    <label for=""><?php echo lang('patient'); ?> <?php echo lang('phone'); ?></label>
                                                    <input type="text" class="form-control" name="p_phone">
                                                    <!-- <label for="">HOSPITAL PHONE</label>
                                                     <input type="text" class="form-control">-->
                                                    <label for=""><?php echo lang('patient'); ?> <?php echo lang('gender'); ?></label>
                                                    <select class="form-control" name="p_gender">
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
                                                <label for=""> <?php echo lang('doctor'); ?></label>
                                                <select class="form-control" name="doctor" id="adoctors">
                                                    <option value="">Select .....</option>
                                                    <?php foreach ($doctors as $doctor) { ?>
                                                        <option value="<?php echo $doctor->id; ?>"<?php
                                                        if (!empty($payment->doctor)) {
                                                            if ($payment->doctor == $doctor->id) {
                                                                echo 'selected';
                                                            }
                                                        }
                                                        ?>><?php echo $doctor->name; ?> </option>
                                                            <?php } ?>

                                                </select>

                                                <label for=""><?php echo lang('date'); ?></label>
                                                <input type="text" class="form-control default-date-picker" readonly="" id="date" name="date" id="" value='' placeholder="">
                                                <label for=""><?php echo lang('available_slots'); ?></label>
                                                <select class="form-control m-bot15" name="time_slot" id="aslots" value=''> 

                                                </select>

                                                <label class=""><?php echo lang('visit'); ?> <?php echo lang('description'); ?></label>

                                                <select class="form-control m-bot15" name="visit_description" id="visit_description" value=''>

                                                </select>
                                                <label for="exampleInputEmail1"> <?php echo lang('category'); ?> </label> 
                                                <select class="form-control m-bot15" name="category_appointment" value=''> 
                                                    <option value="Bed Allotment" <?php
                                                            ?> > <?php echo lang('bed_allotment'); ?> </option>
                                                    <option value="Ambulator" <?php
                                                            ?> > <?php echo lang('ambulator'); ?> </option>

                                                </select>
                                                <label for=""> <?php echo lang('remarks'); ?></label>
                                                <input type="text" class="form-control" name="remarks" id="" value='' placeholder="">

                                                <label for="exampleInputEmail1"><?php echo lang('visit'); ?> <?php echo lang('charges'); ?></label>
                                                <input type="number" class="form-control" name="visit_charges" id="visit_charges" value='' placeholder="" readonly="">
                                                <input type="hidden" name="discount" value='0'>
                                                <input type="hidden" name="grand_total" value='0'>
                                                <input type="hidden" name="redirectlink" value='frontend'>
                                                <input type="hidden" name="request" value=''>
                                                <div class="col-md-12">
                                                    <input type="checkbox" id="pay_now_appointment" name="pay_now_appointment" value="pay_now_appointment">
                                                    <label for=""> <?php echo lang('pay_now'); ?></label><br>

                                                </div>
                                                <div class="col-md-12">
                                                    <?php
                                                    $payment_gateway = $settings1->payment_gateway;
                                                    
                                                    ?>



                                                    <div class = "card1">

                                                        <hr>


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
                                                            <div class="col-md-12">
                                                                <label for="exampleInputEmail1"> <?php echo lang('cardholder'); ?> <?php echo lang('name'); ?></label>
                                                                <input type="text"  id="cardholder" class="form-control pay_in" name="cardholder" value='' placeholder="">
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($payment_gateway != 'Pay U Money' && $payment_gateway != 'Paystack' && $payment_gateway != 'SSLCOMMERZ' && $payment_gateway != 'Paytm') { ?>
                                                            <div class="col-md-12">
                                                                <label for="exampleInputEmail1"> <?php echo lang('card'); ?> <?php echo lang('number'); ?></label>
                                                                <input type="text"  id="card" class="form-control pay_in" name="card_number" value='' placeholder="">
                                                            </div>


                                                            <div class="col-md-12">
                                                                <div class="" style="">
                                                                    <label for="exampleInputEmail1"> <?php echo lang('expire'); ?> <?php echo lang('date'); ?></label>
                                                                    <input type="text" class="form-control pay_in" id="expire" data-date="" data-date-format="MM YY" placeholder="Expiry (MM/YY)" name="expire_date" maxlength="7" aria-describedby="basic-addon1" value='' placeholder="">
                                                                </div>
                                                                <div class="" style="">
                                                                    <label for="exampleInputEmail1"> <?php echo lang('cvv'); ?> </label>
                                                                    <input type="text" class="form-control pay_in" id="cvv" maxlength="3" name="cvv" value='' placeholder="">
                                                                </div>  </div> 
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>


                                                </div>
                                                  <?php $twocheckout = $this->db->get_where('paymentGateway', array('name =' => '2Checkout'))->row(); ?>
                                                <button type="submit" name="pay_now" id="submit-btn" class="btn btn-primary mt-3 pull-right" <?php if ($settings1->payment_gateway == 'Stripe') {
                                                            ?>onClick="stripePay(event);"<?php }
                                                        ?> <?php if ($settings1->payment_gateway == '2Checkout' && $twocheckout->status == 'live') {
                                                            ?>onClick="twoCheckoutPay(event);"<?php }
                                                        ?>> <?php echo lang('submit'); ?></button>


                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <img src="<?php echo $settings->appointment_img_url; ?>" class="img-fluid" alt="Doctor" />
                    </div>
                </div>
            </div>
        </div>
        <!---------------- End Why Choose Us ---------------->

        <!---------------- Start Featured Area ---------------->
        <div id="featured" class="text-white">
            <?php
            $gridCount = 0;
            foreach ($gridsections as $gridsection) {
                $gridCount++;
                $remainder = $gridCount % 2;
                if ($remainder == 0) {
                    ?>

                    <div class="featured_bottom">
                        <div class="row">
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="text-center px-5">
                                    <h6><?php echo $gridsection->category; ?></h6>
                                    <h3><?php echo $gridsection->title; ?></h3>
                                    <p>
                                        <?php echo $gridsection->description; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6" style="padding: 0;">
                                <img src="<?php echo $gridsection->img; ?>" class="img-fluid float-right" alt="" />
                            </div>
                        </div>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="featured_top">
                        <div class="row">
                            <div class="col-md-6" style="padding: 0;">
                                <img src="<?php echo $gridsection->img; ?>" class="img-fluid" alt="" />
                            </div>
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="text-center px-5">
                                    <h6><?php echo $gridsection->category; ?></h6>
                                    <h3><?php echo $gridsection->title; ?></h3>
                                    <p>
                                        <?php echo $gridsection->description; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div> 

                <?php }
                ?>

            <?php } ?>

        </div>
        <!---------------- End Featured Area ---------------->

        <!---------------- Start Featured Services ---------------->
        <div id="featured_services" class="text-center my-5" style="padding-top: 25px !important">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-4 text-center">
                        <h1><?php echo lang('OUR_SERVICES'); ?></h1>
                        <h6 class="lead"><?php echo $settings->service_block__text_under_title; ?></h6>
                    </div>
                    <?php foreach ($services as $service) { ?>
                        <div class="col-md-4 mb-4">
                            <img src="<?php echo $service->img_url; ?>" class="img-fluid" alt="" />
                            <h3 class="mt-3"><?php echo $service->title; ?></h3>
                            <p><?php echo $service->description; ?></p>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
        <!---------------- End Featured Services ---------------->

        <!---------------- Start Featured Doctor ---------------->
        <div id="doctor" class="text-center my-5">
            <div class="container">
                <h3><?php echo lang('Feature_Doctors'); ?></h3>
                <h6>
                    <?php echo $settings->doctor_block__text_under_title; ?>
                </h6>
                <div class="row mt-5">
                    <?php
                    $count = count($featureds);
                    $i = 1;
                    foreach ($featureds as $featured) {
                        ?>
                        <div class="col-md-4 mb-4">
                            <img src="<?php echo $featured->img_url; ?>" height="200px" alt="" />
                            <h4 class="mt-3"><?php echo $featured->name; ?></h4>
                            <p>
                                <?php echo $featured->description; ?>    
                            </p>
                        </div>
                        <?php
                        $i = $i + 1;
                    }
                    ?>

                </div>
            </div>
        </div>
        <!---------------- End Featured Doctor ---------------->

        <!---------------- Start Gallery area ---------------->
        <div id="gallery" class="bg-light text-center my-4">
            <div class="container">
                <div class="row">
                    <?php foreach ($images as $image) { ?>
                        <div class="col-md-4 mb-4">
                            <a href="<?php echo $image->img; ?>" class="gallery-item">
                                <img src="<?php echo $image->img; ?>" class="img-fluid" alt="" />
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!---------------- End Gallery area ---------------->

        <!---------------- Start Testimonials Slider Area ---------------->
        <div id="portfolio" class="my-5">
            <div class="portfolio-testimonials">
                <h2><?php echo lang('trusted_by_some_biggest_names'); ?></h2>
                <div class="owl-carousel owl-carousel1 owl-theme">
                    <?php foreach ($reviews as $review) { ?>
                        <div>
                            <div class="card text-center">
                                <img class="card-img-top" src="<?php echo $review->img; ?>" alt="" />
                                <div class="card-body">
                                    <h5>
                                        <?php echo $review->name; ?> <br />
                                        <span> <?php echo $review->designation; ?> </span>
                                    </h5>
                                    <p class="card-text">
                                        <?php echo $review->review; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!---------------- End Testimonials Slider Area ---------------->

        <!---------------- Start Footer Area ---------------->
        <div id="footer" class="text-white py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <img src="<?php echo $settings->logo; ?>" class="img-fluid">

                    </div>
                    <div class="col-md-3 mb-3">
                        <h6 class="my-2"><?php echo lang('about_us'); ?></h6>
                        <p class="footer-description">
                            <?php echo $settings->description; ?>
                        </p>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="social-media text-center">
                            <h6 class="my-2"><?php echo lang('STAY_CONNECTED'); ?></h6>
                            <div class="social-icon">

                                <?php if (!empty($settings->facebook_id)) { ?>
                                    <a href="<?php echo $settings->facebook_id; ?>"><div class=""><i class="fa fa-facebook"></i></div></a> <?php } ?>
                                <?php if (!empty($settings->google_id)) { ?>
                                    <a href="<?php echo $settings->google_id; ?>"><div><i class="fa fa-google-plus"></i></div></a> <?php } ?>
                                <?php if (!empty($settings->twitter_id)) { ?>
                                    <a href="<?php echo $settings->twitter_id; ?>"><div><i class="fa fa-twitter"></i></div></a> <?php } ?>
                                <?php if (!empty($settings->youtube_id)) { ?>
                                    <a href="<?php echo $settings->youtube_id; ?>"><div><i class="fa fa-youtube"></i></div></a> <?php } ?>

                            </div>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <h6 class="my-2"><?php echo lang('CONTACT_INFO'); ?></h6>
                        <address>
                            <strong><?php lang('address'); ?>: <?php echo $settings->address; ?></strong><br />
                            <strong><?php lang('phone'); ?>: <?php echo $settings->phone; ?></strong><br />
                            <strong><?php lang('email'); ?>: <span><?php echo $settings->email; ?></strong>
                        </address>
                    </div>
                </div>
            </div>
        </div>
        <!---------------- End Footer Area ---------------->

        <!-- Bootstrap core JavaScript  -->
        <script src="<?php echo site_url('front/site_assets/vendor/jquery/jquery.min.js'); ?>"></script>
        <script src="<?php echo site_url('front/site_assets/vendor/jquery/popper.min.js'); ?>"></script>
        <script src="<?php echo site_url('front/site_assets/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo site_url('front/site_assets/vendor/owl-carousel/owl.carousel.min.js'); ?>"></script>
        <script src="<?php echo site_url('front/site_assets/vendor/magnific-popup/jquery.magnific-popup.min.js'); ?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
        <!-- JS Main File -->
        <script src="<?php echo site_url('front/site_assets/js/main.js'); ?>"></script>
        <script src="<?php echo site_url('common/toastr/toastr.js'); ?>"></script>
        <!-- <link rel="stylesheet" href="<?php echo site_url('common/toastr/toastr.js'); ?>" />-->
       <!--<script src="front/js/jquery.js"></script>-->
        <script src="front/js/bootstrap/bootstrap.min.js"></script>
        <script src="<?php echo site_url('front/js/wow/wow.min.js'); ?>"></script>
        <script src="front/js/smoothscroll/jquery.smoothscroll.min.js"></script>
        <script src="<?php echo site_url('front/js/script.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo site_url('common/assets/bootstrap-datepicker/js/bootstrap-datepicker.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo site_url('common/assets/bootstrap-timepicker/js/bootstrap-timepicker.js'); ?>"></script>
        <script src="<?php echo site_url('front/assets/fancybox/source/jquery.fancybox.pack.js'); ?>"></script>

                    <!--<script type="text/javascript" src="<?php echo site_url('front/assets/revolution_slider/rs-plugin/js/jquery.themepunch.plugins.min.js'); ?>"></script>
                    <script type="text/javascript" src="<?php echo site_url('front/assets/revolution_slider/rs-plugin/js/jquery.themepunch.revolution.min.js'); ?>"></script>
                    <script src="front/js/revulation-slide.js"></script>-->
        <script>
<?php if ($this->session->flashdata('success')) { ?>
                                            toastr.success("<?php echo $this->session->flashdata('success'); ?>");
<?php } ?>
        </script>
        <script>
            $('.default-date-picker').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true
            });
            $('#date').on('changeDate', function () {
                $('#date').datepicker('hide');
            });
            $('#date1').on('changeDate', function () {
                $('#date1').datepicker('hide');
            });</script>

        <script>
            $(document).ready(function () {
                $('.timepicker-default').timepicker({defaultTime: 'value'});
            });</script>




        <script>
            $(document).ready(function () {
                $('.pos_client').hide();
                $('.pos_client_id').hide();
                $(document.body).on('change', '#pos_select', function () {

                    var v = $("select.pos_select option:selected").val()
                    if (v == 'add_new') {
                        $('.pos_client').show();
                        $('.pos_client_id').hide();
                    } else if (v == 'patient_id') {
                        $('.pos_client_id').show();
                        $('.pos_client').hide();
                    } else {
                        $('.pos_client_id').hide();
                        $('.pos_client').hide();
                    }
                });
            });</script>


        <script>
            $(document).ready(function () {
                $('.appointment').hide();
                $(document.body).on('click', '#appointment', function () {

                    if ($('.appointment').is(":hidden")) {
                        $('.appointment').show();
                    } else {
                        $('.appointment').hide();
                    }
                });
            });</script>






        <script type="text/javascript">
            $(document).ready(function () {
                $("#adoctors").change(function () {
                    // Get the record's ID via attribute  
                    var id = $('#appointment_id').val();
                    var date = $('#date').val();
                    var doctorr = $('#adoctors').val();
                    $('#aslots').find('option').remove();
                    $('#visit_description').html(" ");
                    // $('#default').trigger("reset");
                    $.ajax({
                        url: 'frontend/getAvailableSlotByDoctorByDateByJason?date=' + date + '&doctor=' + doctorr,
                        method: 'GET',
                        data: '',
                        dataType: 'json',
                    }).done(function (response) {
                        var slots = response.aslots;
                        $.each(slots, function (key, value) {
                            $('#aslots').append($('<option>').text(value).val(value)).end();
                        });
                        //   $("#default-step-1 .button-next").trigger("click");
                        if ($('#aslots').has('option').length == 0) {                    //if it is blank. 
                            $('#aslots').append($('<option>').text('No Available Time Slots').val('Not Selected')).end();
                        }
                        // Populate the form fields with the data returned from server
                        //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()

                        $('#visit_charges').val(" ");
                        $.ajax({
                            url: 'frontend/getDoctorVisit?id=' + doctorr,
                            method: 'GET',
                            data: '',
                            dataType: 'json',
                        }).done(function (response) {


                            $('#visit_description').html(response.response).end();

                        });
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
                    url: 'frontend/getAvailableSlotByDoctorByDateByJason?date=' + date + '&doctor=' + doctorr,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                }).done(function (response) {
                    var slots = response.aslots;
                    $.each(response.aslots, function (key, value) {
                        $('#aslots').append($('<option>').text(value).val(value)).end();
                    });
                    $("#aslots").val(response.current_value)
                            .find("option[value=" + response.current_value + "]").attr('selected', true);
                    //   $("#default-step-1 .button-next").trigger("click");
                    if ($('#aslots').has('option').length == 0) {                    //if it is blank. 
                        $('#aslots').append($('<option>').text('No Available Time Slots').val('Not Selected')).end();
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
                    url: 'frontend/getAvailableSlotByDoctorByDateByJason?date=' + date + '&doctor=' + doctorr,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                }).done(function (response) {
                    var slots = response.aslots;
                    $.each(response.aslots, function (key, value) {
                        $('#aslots').append($('<option>').text(value).val(value)).end();
                    });
                    //   $("#default-step-1 .button-next").trigger("click");
                    if ($('#aslots').has('option').length == 0) {                    //if it is blank. 
                        $('#aslots').append($('<option>').text('No Available Time Slots').val('Not Selected')).end();
                    }


                    // Populate the form fields with the data returned from server
                    //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
                });
            }

        </script>
        <script>
            $(document).ready(function () {
                $("#visit_description").change(function () {
                    // Get the record's ID via attribute  
                    var id = $(this).val();

                    $('#visit_charges').val(" ");
                      $('#grand_total').val(" ");
                    // $('#default').trigger("reset");

                    $.ajax({
                        url: 'frontend/getDoctorVisitCharges?id=' + id,
                        method: 'GET',
                        data: '',
                        dataType: 'json',
                    }).done(function (response) {


                        $('#visit_charges').val(response.response.visit_charges).end();
                        var discount = $('#discount').val();
                        $('#grand_total').val(parseFloat(response.response.visit_charges - discount)).end();

                    });
                });
                $('.card1').hide();
                $("#pay_now_appointment").change(function () {
                    if (this.checked) {
                        $('.card1').show();

<?php if ($payment_gateway != 'Pay U Money' && $payment_gateway != 'Paystack' && $payment_gateway != 'SSLCOMMERZ' && $payment_gateway != 'Paytm') { ?>
                            $('#expire').prop("required", true);
                            $('#cvv').prop("required", true);
<?php } ?>
                    } else {

                        $('.card1').hide();
<?php if ($payment_gateway != 'Pay U Money' && $payment_gateway != 'Paystack' && $payment_gateway != 'SSLCOMMERZ' && $payment_gateway != 'Paytm') { ?>
                            $('#expire').removeAttr("required");
                            $('#cvv').removeAttr("required");
<?php } ?>
                    }
                });
            });
        </script>
        <script>

            $(document).ready(function () {
                $('.caption img').removeAttr('style');
                var windowH = $(window).width();
                $('.caption img').css('width', (windowH) + 'px');
                $('.caption img').css('height', '500px');
            });

        </script>
        <script>

            RevSlide.initRevolutionSlider();
            $(window).load(function () {
                $('[data-zlname = reverse-effect]').mateHover({
                    position: 'y-reverse',
                    overlayStyle: 'rolling',
                    overlayBg: '#fff',
                    overlayOpacity: 0.7,
                    overlayEasing: 'easeOutCirc',
                    rollingPosition: 'top',
                    popupEasing: 'easeOutBack',
                    popup2Easing: 'easeOutBack'
                });
            });
            $(window).load(function () {
                $('.flexslider').flexslider({
                    animation: "slide",
                    start: function (slider) {
                        $('body').removeClass('loading');
                    }
                });
            });
            //    fancybox
            jQuery(".fancybox").fancybox();
            $(function () {
                $('a[href*=#]:not([href=#])').click(function () {
                    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                        var target = $(this.hash);
                        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                        if (target.length) {
                            $('html,body').animate({
                                scrollTop: target.offset().top
                            }, 1000);
                            return false;
                        }
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                $('.headerSlider').owlCarousel({
                    loop: true,
                    autoplay: true,
                    autoplayTimeout: 5000,
                    autoplayHoverPause: false,
                    dots: true,
                    nav: true,
                    navigation: true,
                    pagination: true,
                    responsiveClass: true,
                    responsive: {
                        0: {
                            items: 1,
                            loop: true
                        },
                        600: {
                            items: 1,
                            loop: true
                        },
                        1000: {
                            items: 1,
                            loop: true
                        }
                    }
                })
            });
        </script>
        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
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

<script src="common/js/moment.min.js"></script>

<script type="text/javascript" src="https://www.2checkout.com/checkout/api/2co.min.js"></script>
<?php if ($settings1->payment_gateway == '2Checkout') { ?> 
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


    </body>
</html>
