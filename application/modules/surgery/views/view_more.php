<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
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
            .input-category{
                border: none !important;
            }
            .price-indivudual{
                border: none !important;
            }
            .from_where{
                border: none !important;
            }
            .discount-price-indivudual{
                height: 37px !important;
                border: 1px solid #eee !important;
            }
            .discount-price-pre-services{
                height: 37px !important;
                border: 1px solid #eee !important;
                width: 42px;
            }
            .price-pre-services{
                border: none !important;
                width: 54px;
            }
            .discount-price-on-services{
                height: 37px !important;
                border: 1px solid #eee !important;
                width: 42px;
            }
            .price-on-services{
                border: none !important;
                width: 54px;
            }
            .discount-price-post-services{
                height: 37px !important;
                border: 1px solid #eee !important;
                width: 42px;
            }
            .price-post-services{
                border: none !important;
                width: 54px;
            }



        </style>
        <section class="col-md-9">
            <header class="panel-heading clearfix">
                <div class="col-md-9">
                    <?php echo lang('surgery'); ?> | <?php echo $surgeries->patient_name; ?>
                </div>

            </header>

            <section class="panel-body">   
                <header class="panel-heading tab-bg-dark-navy-blueee">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#checkin"><?php echo lang('check_in'); ?></a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#pre_surgery"><?php echo lang('pre_surgery'); ?></a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#surgery"><?php echo lang('surgery'); ?></a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#post_surgery"><?php echo lang('post_surgery'); ?></a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#discharge"><?php echo lang('discharge'); ?></a>
                        </li>

                    </ul>
                </header>
                <div class="panel">
                    <div class="tab-content">
                        <div id="checkin" class="tab-pane active">
                            <div class="">
                                <form role="form" action="" id="editSurgeryCheckin"class="clearfix" method="post" enctype="multipart/form-data">
                                    <div class="form-group col-md-12">

                                        <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('covid_19'); ?>:</label>

                                        <span></span>


                                        <input type="radio" name="covid_19" value="po"<?php
                                        if ($checkin->covid_19 == 'po') {
                                            echo 'checked';
                                        }
                                        ?>>
                                        <label style="margin-right: 56px;"><?php echo lang('po'); ?></label>
                                        <input type="radio" name="covid_19" value="jo"<?php
                                        if ($checkin->covid_19 == 'jo') {
                                            echo 'checked';
                                        }
                                        ?>>
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
                                            if (!empty($checkin->a_time)) {
                                                echo $checkin->a_time;
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
                                                if (!empty($checkin->category)) {
                                                    if ($checkin->category == $room->category) {
                                                        echo 'selected';
                                                    }
                                                }
                                                ?> > <?php echo $room->category; ?> </option>
                                                    <?php } ?> 
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="exampleInputEmail1"><?php echo lang('bed_id'); ?></label>
                                        <select class="form-control m-bot15" id="bed_id" name="bed_id" value=''> 
                                            <option value="select"><?php echo lang('select'); ?></option>
                                            <?php
                                            if (!empty($checkin->id)) {
                                                echo $option;
                                            }
                                            ?>
                                        </select>
                                    </div>



                                    <div class="form-group col-md-12">

                                        <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('category'); ?>:</label>

                                        <span></span>
                                        <?php $category_status = explode(',', $checkin->category_status);
                                        ?>

                                        <input type="checkbox" name="category_status[]" value="urgent" <?php
                                        if (in_array('urgent', $category_status)) {
                                            echo "checked";
                                        }
                                        ?>>
                                        <label style="margin-right: 56px;"><?php echo lang('urgent'); ?></label>
                                        <input type="checkbox" name="category_status[]" value="planned" <?php
                                        if (in_array('planned', $category_status)) {
                                            echo "checked";
                                        }
                                        ?>>
                                        <label><?php echo lang('planned'); ?></label>

                                    </div>
                                    <div class="form-group col-md-12">

                                        <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('reaksione'); ?>:</label>
                                        <textarea name="reaksione" class='form-control'><?php
                                            if (!empty($checkin->reaksione)) {
                                                echo $checkin->reaksione;
                                            }
                                            ?> </textarea>

                                    </div>
                                    <div class="form-group col-md-12">

                                        <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('transferred_from'); ?>:</label>
                                        <textarea name="transferred_from" class='form-control'> <?php
                                            if (!empty($checkin->transferred_from)) {
                                                echo $checkin->transferred_from;
                                            }
                                            ?></textarea>

                                    </div>
                                    <div class="form-group col-md-12">

                                        <label for="exampleInputEmail1"><?php echo lang('actual_illness'); ?>:</label>
                                        <textarea name="actual_illness" class='form-control'><?php
                                            if (!empty($checkin->actual_illness)) {
                                                echo $checkin->actual_illness;
                                            }
                                            ?> </textarea>

                                    </div>
                                    <div class="form-group col-md-12">

                                        <label for="exampleInputEmail1"><?php echo lang('addtional_illness'); ?>:</label>
                                        <textarea name="addtional_illness" class='form-control'><?php
                                            if (!empty($checkin->addtional_illness)) {
                                                echo $checkin->addtional_illness;
                                            }
                                            ?> </textarea>

                                    </div>
                                    <div class="form-group col-md-12">

                                        <label for="exampleInputEmail1"><?php echo lang('other_risk_factor'); ?>:</label>
                                        <textarea name="other_risk_factor" class='form-control'><?php
                                            if (!empty($checkin->other_risk_factor)) {
                                                echo $checkin->other_risk_factor;
                                            }
                                            ?> </textarea>

                                    </div>
                                    <div class="form-group col-md-12">

                                        <label for="exampleInputEmail1"><?php echo lang('diagnoza_pranimit'); ?>:</label>
                                        <textarea name="diagnoza_pranimit" class='form-control'><?php
                                            if (!empty($checkin->diagnoza_pranimit)) {
                                                echo $checkin->diagnoza_pranimit;
                                            }
                                            ?> </textarea>

                                    </div>
                                    <div class="form-group col-md-12">

                                        <label for="exampleInputEmail1"><?php echo lang('diagnoza_klinike'); ?>:</label>
                                        <textarea name="diagnoza_klinike" class='form-control'><?php
                                            if (!empty($checkin->diagnoza_klinike)) {
                                                echo $checkin->diagnoza_klinike;
                                            }
                                            ?> </textarea>

                                    </div>
                                    <div class="form-group col-md-12">

                                        <label for="exampleInputEmail1"><?php echo lang('diagnoza_imazherike'); ?>:</label>
                                        <textarea name="diagnoza_imazherike" class='form-control'><?php
                                            if (!empty($checkin->diagnoza_imazherike)) {
                                                echo $checkin->diagnoza_imazherike;
                                            }
                                            ?> </textarea>

                                    </div>
                                    <div class="form-group col-md-12">

                                        <label for="exampleInputEmail1"><?php echo lang('diagnoza_perfundimtare'); ?>:</label>
                                        <textarea name="diagnoza_perfundimtare" class='form-control'><?php
                                            if (!empty($checkin->diagnoza_perfundimtare)) {
                                                echo $checkin->diagnoza_perfundimtare;
                                            }
                                            ?> </textarea>

                                    </div>


                                    <input type="hidden" name="id" value='<?php
                                    if (!empty($checkin->id)) {
                                        echo $checkin->id;
                                    }
                                    ?>'>
                                    <input type="hidden" name="surgery_id" value='<?php
                                    if (!empty($surgeries->id)) {
                                        echo $surgeries->id;
                                    }
                                    ?>'>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-6">

                                        </div>
<?php if (empty($bed_checkout->date) || $this->ion_auth->in_group(array('admin'))) { ?>
                                        <div class="col-md-6">
                                            <button style="background: #7a2828;" type="submit" name="submit" class="btn btn-info pull-right" onclick="history.back()"><?php echo lang('exit'); ?></button>
                                            <button style="margin-right: 7px;" type="submit" name="submit2" class="btn btn-info pull-right" ><?php echo lang('submit'); ?></button>

                                        </div>
<?php } ?>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <div id="pre_surgery" class="tab-pane">
                            <div class="">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#pre_medical_analysis"><?php echo lang('medical_analysis'); ?></a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#pre_medicines"><?php echo lang('medicines'); ?></a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#pre_services"><?php echo lang('service'); ?></a>
                                    </li>


                                </ul>
                                <div class="tab-content">
                                    <div id="pre_medical_analysis" class="tab-pane active">
                                        <div class="panel-body">
                                            <div class="adv-table editable-table ">
                                                <?php if (empty($bed_checkout->date) || $this->ion_auth->in_group(array('admin'))) { ?>
                                                <div class="clearfix no-print col-md-8 pull-right">
                                                    <a data-toggle="modal" href="#pre_surgery_medical_modal">
                                                        <div class="btn-group pull-right">
                                                            <button id="pre_modal" class="btn green btn-xs">
                                                                <i class="fa fa-plus-circle"></i>  <?php echo lang('add'); ?> 
                                                            </button>
                                                        </div>
                                                    </a>
                                                </div>
                                                <?php } ?>
                                                <div class="adv-table editable-table">

                                                    <table class="table table-striped table-hover table-bordered" id="editable-sample_pre_medical">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 10%"><?php echo lang('date'); ?></th>

                                                                <th style="width: 15%"><?php echo lang('case'); ?> <?php echo lang('title'); ?></th>
                                                                <th style="width: 15%"><?php echo lang('description'); ?> </th>
                                                                <th style="width: 15%"><?php echo lang('status'); ?> </th>

                                                                <th style="width: 15%"><?php echo lang('grand_total'); ?> </th>
                                                                <th style="width: 10%;" class="no-print"><?php echo lang('options'); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="pre_medical_surgery_show">
                                                            <?php foreach ($pre_medical as $pre_medical) { ?>
                                                                <tr id="table-<?php echo $pre_medical->id; ?>">
                                                                    <td><?php echo date('d-m-Y', $pre_medical->date); ?> </td>

                                                                    <td><?php echo $pre_medical->title; ?></td>
                                                                    <td><?php
                                                                        $descriptions = explode('##', $pre_medical->description);
                                                                        foreach ($descriptions as $description) {
                                                                            $description_single = array();
                                                                            $description_single = explode('**', $description);
                                                                            if ($description_single[0] == 'Package_pre_surgery_medical') {
                                                                                ?>
                                                                                <ul><li> <?php echo lang('package'); ?> - <?php echo $description_single[1]; ?></li></ul>
                                                                            <?php } else { ?>
                                                                                <ul><li> <?php echo $description_single[1]; ?></li></ul>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?></td>
                                                                    <td>  <?php
                                                                        if ($pre_medical->status == 'Pending Confirmation') {
                                                                            echo lang('pending_confirmation');
                                                                        } if ($pre_medical->status == 'Confirmed') {
                                                                            echo lang('confirmed');
                                                                        }
                                                                        ?> </td>

                                                                    <td><?php echo $pre_medical->grand_total; ?></td>
                                                                    <td>
                                                                        <?php if (empty($bed_checkout->date) || $this->ion_auth->in_group(array('admin'))) { ?>
                                                                        <button type="button" class="btn btn-info btn-xs btn_width editbutton_pre_medical_surgery" data-toggle="modal" data-id="<?php echo $pre_medical->id; ?>"><i class="fa fa-edit"></i></button>
                                                                      
                                                                        <button class="btn btn-danger btn-xs btn_width delete_button_medical_pre" id="delete-pre-surgery-medical-<?php echo $pre_medical->id; ?>"><i class="fa fa-trash"> </i></button>
                                                                        <?php } ?>
                                                                          <a class="btn btn-success btn-xs btn_width" title="<?php echo lang('invoice'); ?>" href="finance/invoice?id=<?php echo $pre_medical->payment_id; ?>" target="_blank"><i class="fa fa-file-invoice"></i></a>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div id="pre_medicines" class="tab-pane">
                                        <div class="">
                                             <?php if (empty($bed_checkout->date) || $this->ion_auth->in_group(array('admin'))) { ?>
                                            <div class="col-md-12 pull-right">

                                                <button style="display: block;" id="save_button_pre" type="submit" name="submit" class="btn btn-xs btn-info pull-right" ><i class="fa fa-save"></i> <?php echo lang('save'); ?></button>

                                            </div>
                                             <?php } ?>
                                            <br>
                                            <div class="adv-table editable-table ">
                                                <table style="width: 100% !important;" class="table table-striped table-hover table-bordered" id="editable-table_pre_medicine" >
                                                    <thead>
                                                        <tr>

                                                            <th><?php echo lang('date'); ?></th>
                                                            <th><?php echo lang('medicine_gen_name'); ?></th>
                                                            <th><?php echo lang('medicine'); ?> <?php lang('name'); ?></th>
                                                            <th><?php echo lang('sales'); ?> <?php lang('price'); ?></th>
                                                            <th><?php echo lang('quantity'); ?></th>
                                                            <th><?php echo lang('total'); ?></th>
                                                            <?php
                                                            if (empty($bed_checkout->date) || $this->ion_auth->in_group(array('admin'))) {
                                                           // if ($this->ion_auth->in_group(array('admin'))) {
                                                                ?>
                                                                <th class="no-print"><?php echo lang('options'); ?></th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="medicine_table_pre">
                                                        <?php foreach ($daily_medicine_pre as $medicine) { ?>
                                                            <tr id="pre-<?php echo $medicine->id; ?>">
                                                                <td><?php echo $medicine->date; ?></td>
                                                                <td><?php echo $medicine->generic_name; ?></td>
                                                                <td><?php echo $medicine->medicine_name; ?></td>
                                                                <td><?php echo $settings->currency . $medicine->s_price; ?></td>
                                                                <td><?php echo $medicine->quantity; ?></td>
                                                                <td><?php echo $settings->currency . $medicine->total; ?></td>
                                                                <?php
                                                              if ((empty($bed_checkout->date) && empty($medicine->payment_id)) || $this->ion_auth->in_group(array('admin'))) { 
                                                               // if ($this->ion_auth->in_group(array('admin'))) {
                                                                    ?>
                                                                    <td class="no-print" id="delete-<?php echo $medicine->id; ?>"><button type='button' class='btn btn-danger btn-xs btn_width delete_medicine' title='<?php echo lang('delete'); ?>' data-toggle='' data-id="<?php echo $medicine->id; ?>"><i class='fa fa-trash'></i></button></td>
                                                                <?php } ?>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                           <?php if (empty($bed_checkout->date) || $this->ion_auth->in_group(array('admin'))) { ?>
                                                <div>
                                                    <label>---------------------------------------------------------------------------------------<?php echo "Select Medicine" ?>-----------------------------------------------------------------------</label>
                                                    <form role="form" action="" id="editMedicine_pre"class="clearfix" method="post" enctype="multipart/form-data">                             
                                                        <div class="form-group col-md-12">

                                                            <div class="col-md-3">

                                                                <select style=" display: block;"class="form-control m-bot15" id="generic_name" name="generic_name" value='' required=""> 

                                                                </select>
                                                            </div>
                                                            <div class="col-md-3">

                                                                <select style="display: block;" class="form-control m-bot15" id="medicines_option" name="medicine_name" value='' required=""> 

                                                                </select>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <input style="display: block;height: 37px;
                                                                       width: 283%;border: 1px solid;" class="input-md" type="text" id="sales_price" name="sales_price" value="" placeholder="<?php echo lang('sales'); ?>"readonly="">
                                                            </div> 
                                                            <div class="col-md-1">

                                                                <input style="height: 37px;
                                                                       width: 283%;display: block;border: 1px solid;"  class="input-md" id="quantity" type="number" placeholder="<?php echo lang('quantity'); ?>"name="quantity" value="">
                                                            </div> 
                                                            <div class="col-md-1">

                                                                <input style="display: block;height: 37px;
                                                                       width: 283%;border: 1px solid;" class="input-md" type="text" id="total" name="total" value="" placeholder="<?php echo lang('total'); ?>" readonly="">
                                                            </div>
                                                            <input type="hidden" id="pre_surgery_medicine_id" name="surgery_id" value="<?php
                                                            if (!empty($surgeries->id)) {
                                                                echo $surgeries->id;
                                                            }
                                                            ?>">
                                                            <div class="col-md-2">

                                                                <button style="display: block;" type="submit" name="submit" class="btn btn-xs btn-info pull-right" ><i class="fa fa-save"></i></button>

                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>
                                            <?php } ?>
                                        </div>  
                                    </div>
                                    <div id="pre_services" class="tab-pane">
                                        <div class="">
                                             <?php if (empty($bed_checkout->date) || $this->ion_auth->in_group(array('admin'))) { ?>
                                            <div class="col-md-12 pull-right">

                                                <button style="display: block;" id="save_button_service_pre" type="submit" name="submit" class="btn btn-xs btn-info pull-right" ><i class="fa fa-save"></i> <?php echo lang('save'); ?></button>

                                            </div> 
                                             <?php } ?>
                                            <div class="adv-table editable-table ">
                                                <table style="width: 100% !important;" class="table table-striped table-hover table-bordered" id="editable-table_pre_services">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 20%;"><?php echo lang('service'); ?></th>
                                                            <th style="width: 20%;"><?php echo lang('date'); ?></th>
                                                            <th style="width: 20%;"><?php echo lang('nurse'); ?></th>
                                                            <th style="width: 10%;"><?php echo lang('price'); ?></th>
                                                            <th style="width: 10%;"><?php echo lang('quantity'); ?></th>
                                                            <th style="width: 10%;"><?php echo lang('total'); ?></th>
                                                            <th style="width: 10%;"><?php echo lang('discount'); ?></th>
                                                            <th style="width: 10%;"><?php echo lang('grand_total'); ?></th>
                                                            <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                                                                <th style="width: 10%;" class="no-print"><?php echo lang('options'); ?></th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="paservice_table_pre">
                                                        <?php
                                                        if (!empty($daily_service_pre)) {
                                                            foreach ($daily_service_pre as $service) {
                                                                $price = explode("**", $service->price);

                                                                $service_update = explode("**", $service->service);

                                                                $pre_service_discount_price = explode("**", $service->discount);
                                                                $total_discount_pre = array_sum($pre_service_discount_price);
                                                                $price_pre = array_sum($price);
                                                                $array = array_combine($service, $price);
                                                                $length = sizeof($price);
                                                                $length1 = sizeof($service_update);
                                                                if ($length == $length1) {
                                                                    $i = 0;
                                                                    for ($i = 0; $i < $length; $i++) {
                                                                        $servicename = $this->db->get_where('pservice', array('id' => $service_update[$i]))->row();

                                                                        if (!empty($service->nurse)) {
                                                                            $nursename = $this->db->get_where('nurse', array('id' => $service->nurse))->row()->name;
                                                                        } else {
                                                                            $nursename = " ";
                                                                        }
                                                                        ?>
                                                                        <tr id="pre-<?php echo $service->date; ?>-<?php echo $service_update[$i]; ?>">
                                                                            <td><?php echo $servicename->name; ?></td>
                                                                            <td class="pre-date" id="pre-<?php echo $service_update[$i]; ?>-<?php echo $service->date; ?>"><?php echo $service->date; ?></td>
                                                                            <td><?php echo $nursename; ?></td>
                                                                            <td><input type="number" min="0" name="price_pre_service[]" value="<?php echo $price[$i] ?>"class="price-pre-services" id="pre-service-price-<?php echo $servicename->id ?>"readonly></td>
                                                                            <td><?php echo "1" ?></td>
                                                                            <td><?php echo $settings->currency; ?><?php echo $price[$i] * 1; ?></td>
                                                                            <td><input type="number" min="0" name="discount_pre_service[]" value="<?php
                                                                                if (!empty($pre_service_discount_price[$i])) {
                                                                                    $dis = $pre_service_discount_price[$i];
                                                                                } else {
                                                                                    $dis = '0';
                                                                                } echo $dis;
                                                                                ?>"class="discount-price-pre-services" id="pre-service-discount-<?php echo $servicename->id; ?>-<?php echo $service->date; ?>" 
                                                                                    <?php if (!empty($bed_checkout->date) && !$this->ion_auth->in_group(array('admin'))) { ?>
                                                                                readonly=""
                                                                                <?php } ?>></td>
                                                                            <td id="discount-pre-<?php echo $service->date; ?>-<?php echo $servicename->id; ?>"><?php echo $price[$i] - $dis; ?></td>
                                                                           <?php if (empty($bed_checkout->date) || $this->ion_auth->in_group(array('admin'))) { ?>


                                                                                <td class="no-print" id="delete-service-<?php echo date('d') . '-' . $servicename->id; ?>"><button type='button' class='btn btn-danger btn-xs btn_width delete_service' title='<?php echo lang('delete'); ?>' data-toggle='' data-id="<?php echo $service->id . "**" . $service_update[$i]; ?>"><i class='fa fa-trash'></i></button></td>
                                                                            <?php } ?>
                                                                        </tr>

                                                                        <?php
                                                                    }
                                                                }
                                                                ?>


                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php
                                            $services_all = $this->db->get_where('pre_service', array('surgery_id' => $surgeries->id))->result();
                                            if (empty($services_all)) {
                                                $price_total = '0';
                                                $discount_total_new = '0';
                                                $grand_total_new = '0';
                                            } else {
                                                foreach ($services_all as $services) {
                                                    $price_u = explode("**", $services->price);
                                                    $discount_u = explode("**", $services->discount);
                                                    $price_ups[] = array_sum($price_u);
                                                    $discount_ups[] = array_sum($discount_u);
                                                }

                                                $price_total = array_sum($price_ups);
                                                $discount_total_new = array_sum($discount_ups);
                                                $grand_total_new = $price_total - $discount_total_new;
                                            }
                                            ?>
                                            <div class="form-group col-md-12">
                                                <div class="form-group col-md-4">
                                                    <label for="exampleInputEmail1"><?php echo lang('total_value'); ?></label>
                                                    <input type="text" class="form-control" name="total_value1" id="total_value_pre_service" value='<?php
                                                    echo $price_total;
                                                    ?>' placeholder="" readonly="">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="exampleInputEmail1"><?php echo lang('total_discount'); ?></label>
                                                    <input type="text" class="form-control" name="total_discount1" id="total_discount_pre_service" value='<?php
                                                    echo $discount_total_new;
                                                    ?>' placeholder="" readonly="">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="exampleInputEmail1"><?php echo lang('grand_total'); ?></label>
                                                    <input type="text" class="form-control" name="grand_total1" id="grand_total_pre_service" value='<?php
                                                    echo $grand_total_new;
                                                    ?>' placeholder="" readonly="">
                                                </div>
                                            </div>
                                   <?php if (empty($bed_checkout->date) || $this->ion_auth->in_group(array('admin'))) { ?>
                                                <div>
                                                    <label>--------------------------------------------------------------------------------------- <?php echo "Services" ?> -----------------------------------------------------------------------</label>
                                                    <form role="form" action="" id="editService_pre"class="clearfix" method="post" enctype="multipart/form-data">                             
                                                        <div class="form-group col-md-12">

                                                            <div class="col-md-12" id="nurses_select">
                                                                <label><?php echo lang('nurse'); ?></label>

                                                                <select style=" display: block;"class="form-control m-bot15" id="nurse_service" name="nurse_service" value=''> 

                                                                </select>
                                                            </div>
                                                            <div class="col-md-12">

                                                                <u>  <h4><?php echo lang('services'); ?></h4></u> <br>
                                                                <?php foreach ($pservice as $patient_service) { ?>
                                                                    <div class="col-md-4" >
                                                                        <input type="checkbox" class="pservice_pre" id="pservice-pre-<?php echo $patient_service->id; ?>" name="pservice[]" value="<?php echo $patient_service->id; ?>" <?php
                                                                        if (!empty($checked)) {
                                                                            if (in_array($patient_service->id, $checked)) {
                                                                                echo 'checked';
                                                                            }
                                                                        }
                                                                        ?>>
                                                                        <label><?php echo $patient_service->name; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>

                                                            <input type="hidden" id="pre_services_surgery_id" name="surgery_id" value="<?php
                                                            if (!empty($surgeries->id)) {
                                                                echo $surgeries->id;
                                                            }
                                                            ?>">

                                                            </form>
                                                        </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="surgery" class="tab-pane">
                            <div class="">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#on_medical_analysis"><?php echo lang('medical_analysis'); ?></a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#on_medicines"><?php echo lang('medicines'); ?></a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#on_services"><?php echo lang('service'); ?></a>
                                    </li>


                                </ul>
                                <div class="tab-content">
                                    <div id="on_medical_analysis" class="tab-pane active">
                                        <div class="panel-body">
                                            <div class="adv-table editable-table ">
                                                   <?php if (empty($bed_checkout->date) || $this->ion_auth->in_group(array('admin'))) { ?>
                                                <div class="clearfix no-print col-md-8 pull-right">
                                                    <a data-toggle="modal" href="#on_surgery_medical_modal">
                                                        <div class="btn-group pull-right">
                                                            <button id="on_modal" class="btn green btn-xs">
                                                                <i class="fa fa-plus-circle"></i>  <?php echo lang('add'); ?> 
                                                            </button>
                                                        </div>
                                                    </a>
                                                </div>
                                                   <?php } ?>
                                                <div class="adv-table editable-table">

                                                    <table class="table table-striped table-hover table-bordered" id="editable-sample_on_medical">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 10%"><?php echo lang('date'); ?></th>

                                                                <th style="width: 15%"><?php echo lang('case'); ?> <?php echo lang('title'); ?></th>
                                                                <th style="width: 15%"><?php echo lang('description'); ?> </th>
                                                                <th style="width: 15%"><?php echo lang('status'); ?> </th>

                                                                <th style="width: 15%"><?php echo lang('grand_total'); ?> </th>
                                                                
                                                                <th style="width: 10%;" class="no-print"><?php echo lang('options'); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="on_medical_surgery_show">
                                                            <?php foreach ($on_medical as $on_medical) { ?>
                                                                <tr id="table-on-<?php echo $on_medical->id; ?>">
                                                                    <td><?php echo date('d-m-Y', $on_medical->date); ?> </td>

                                                                    <td><?php echo $on_medical->title; ?></td>
                                                                    <td><?php
                                                                        $descriptions = explode('##', $on_medical->description);
                                                                        foreach ($descriptions as $description) {
                                                                            $description_single = array();
                                                                            $description_single = explode('**', $description);
                                                                            if ($description_single[0] == 'Package_on_surgery_medical') {
                                                                                ?>
                                                                                <ul><li> <?php echo lang('package') ?> - <?php echo $description_single[1]; ?></li></ul>
                                                                            <?php } else { ?>
                                                                                <ul><li> <?php echo $description_single[1]; ?></li></ul>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?></td>
                                                                    <td>  <?php
                                                                        if ($on_medical->status == 'Pending Confirmation') {
                                                                            echo lang('pending_confirmation');
                                                                        } if ($on_medical->status == 'Confirmed') {
                                                                            echo lang('confirmed');
                                                                        }
                                                                        ?> </td>

                                                                    <td><?php echo $on_medical->grand_total; ?></td>
                                                                    <td>
                                                                           <?php if (empty($bed_checkout->date) || $this->ion_auth->in_group(array('admin'))) { ?>
                                                                        <button type="button" class="btn btn-info btn-xs btn_width editbutton_on_medical_surgery" data-toggle="modal" data-id="<?php echo $on_medical->id; ?>"><i class="fa fa-edit"></i></button>
                                                                       <!-- <a class="btn btn-success btn-xs btn_width" title="<?php echo lang('invoice'); ?>" href="finance/invoice?id=<?php echo $on_medical->payment_id; ?>" target="_blank"><i class="fa fa-file-invoice"></i></a>-->
                                                                        <button class="btn btn-danger btn-xs btn_width delete_button_medical_on" id="delete-on-surgery-medical-<?php echo $on_medical->id; ?>"><i class="fa fa-trash"> </i></button>
                                                                           <?php } ?>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div id="on_medicines" class="tab-pane">
                                        <div class="">
                                            <!--  <div class="col-md-12 pull-right">
  
                                                  <button style="display: block;" id="save_button_on" type="submit" name="submit" class="btn btn-xs btn-info pull-right" ><i class="fa fa-save"></i> <?php echo lang('save'); ?></button>
  
                                              </div>-->
                                            <br>
                                            <div class="adv-table editable-table ">
                                                <table style="width: 100% !important;" class="table table-striped table-hover table-bordered" id="editable-table_on_medicine" >
                                                    <thead>
                                                        <tr>

                                                            <th><?php echo lang('date'); ?></th>
                                                            <th><?php echo lang('medicine_gen_name'); ?></th>
                                                            <th><?php echo lang('medicine'); ?> <?php lang('name'); ?></th>
                                                            <th><?php echo lang('sales'); ?> <?php lang('price'); ?></th>
                                                            <th><?php echo lang('quantity'); ?></th>
                                                            <th><?php echo lang('total'); ?></th>
                                                            <?php
                                                            if (empty($bed_checkout->date) || $this->ion_auth->in_group(array('admin'))) {
                                                           // if ($this->ion_auth->in_group(array('admin'))) {
                                                                ?>
                                                                <th class="no-print"><?php echo lang('options'); ?></th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="medicine_table_on">
                                                        <?php foreach ($daily_medicine_on as $medicine) { ?>
                                                            <tr id="pre-<?php echo $medicine->id; ?>">
                                                                <td><?php echo $medicine->date; ?></td>
                                                                <td><?php echo $medicine->generic_name; ?></td>
                                                                <td><?php echo $medicine->medicine_name; ?></td>
                                                                <td><?php echo $settings->currency . $medicine->s_price; ?></td>
                                                                <td><?php echo $medicine->quantity; ?></td>
                                                                <td><?php echo $settings->currency . $medicine->total; ?></td>
                                                                <?php
                                                                if ((empty($bed_checkout->date) && empty($medicine->payment_id)) || $this->ion_auth->in_group(array('admin'))) { 
                                                             //   if ($this->ion_auth->in_group(array('admin'))) {
                                                                    ?>
                                                                    <td class="no-print" id="delete-on-<?php echo $medicine->id; ?>"><button type='button' class='btn btn-danger btn-xs btn_width delete_medicine' title='<?php echo lang('delete'); ?>' data-toggle='' data-id="<?php echo $medicine->id; ?>"><i class='fa fa-trash'></i></button></td>
                                                                <?php } ?>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php if (empty($bed_checkout->date) || $this->ion_auth->in_group(array('admin'))) { ?> 
                                                <div>
                                                    <label>---------------------------------------------------------------------------------------<?php echo "Select Medicine" ?>-----------------------------------------------------------------------</label>
                                                    <form role="form" action="" id="editMedicine_on"class="clearfix" method="post" enctype="multipart/form-data">                             
                                                        <div class="form-group col-md-12">

                                                            <div class="col-md-3">

                                                                <select style=" display: block;"class="form-control m-bot15" id="generic_name_on" name="generic_name" value='' required=""> 

                                                                </select>
                                                            </div>
                                                            <div class="col-md-3">

                                                                <select style="display: block;" class="form-control m-bot15" id="medicines_option_on" name="medicine_name" value='' required=""> 

                                                                </select>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <input style="display: block;height: 37px;
                                                                       width: 283%;border: 1px solid;" class="input-md" type="text" id="sales_price_on" name="sales_price" value="" placeholder="<?php echo lang('sales'); ?>"readonly="">
                                                            </div> 
                                                            <div class="col-md-1">

                                                                <input style="height: 37px;
                                                                       width: 283%;display: block;border: 1px solid;"  class="input-md" id="quantity_on" type="number" placeholder="<?php echo lang('quantity'); ?>"name="quantity" value="">
                                                            </div> 
                                                            <div class="col-md-1">

                                                                <input style="display: block;height: 37px;
                                                                       width: 283%;border: 1px solid;" class="input-md" type="text" id="total_on" name="total" value="" placeholder="<?php echo lang('total'); ?>" readonly="">
                                                            </div>
                                                            <input type="hidden" id="on_surgery_medicine_id" name="surgery_id" value="<?php
                                                            if (!empty($surgeries->id)) {
                                                                echo $surgeries->id;
                                                            }
                                                            ?>">
                                                            <div class="col-md-2">

                                                                <button style="display: block;" type="submit" name="submit" class="btn btn-xs btn-info pull-right" ><i class="fa fa-save"></i></button>

                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>
                                            <?php } ?>
                                        </div>   
                                    </div>
                                    <div id="on_services" class="tab-pane">
                                        <div class="">
                                            <!--   <div class="col-md-12 pull-right">
   
                                                   <button style="display: block;" id="save_button_service_pre" type="submit" name="submit" class="btn btn-xs btn-info pull-right" ><i class="fa fa-save"></i> <?php echo lang('save'); ?></button>
   
                                               </div> -->
                                            <div class="adv-table editable-table ">
                                                <table style="width: 100% !important;" class="table table-striped table-hover table-bordered" id="editable-table_on_services">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 20%;"><?php echo lang('service'); ?></th>
                                                            <th style="width: 20%;"><?php echo lang('date'); ?></th>
                                                            <th style="width: 20%;"><?php echo lang('nurse'); ?></th>
                                                            <th style="width: 10%;"><?php echo lang('price'); ?></th>
                                                            <th style="width: 10%;"><?php echo lang('quantity'); ?></th>
                                                            <th style="width: 10%;"><?php echo lang('total'); ?></th>
                                                            <th style="width: 10%;"><?php echo lang('discount'); ?></th>
                                                            <th style="width: 10%;"><?php echo lang('grand_total'); ?></th>
                                                            <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                                                                <th style="width: 10%;" class="no-print"><?php echo lang('options'); ?></th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="paservice_table_on">
                                                        <?php
                                                        if (!empty($daily_service_on)) {
                                                            foreach ($daily_service_on as $service) {
                                                                $price = explode("**", $service->price);

                                                                $service_update = explode("**", $service->service);

                                                                $on_service_discount_price = explode("**", $service->discount);
                                                                $total_discount_pre = array_sum($pre_service_discount_price);
                                                                $price_pre = array_sum($price);
                                                                $array = array_combine($service, $price);
                                                                $length = sizeof($price);
                                                                $length1 = sizeof($service_update);
                                                                if ($length == $length1) {
                                                                    $i = 0;
                                                                    for ($i = 0; $i < $length; $i++) {
                                                                        $servicename = $this->db->get_where('pservice', array('id' => $service_update[$i]))->row();

                                                                        if (!empty($service->nurse)) {
                                                                            $nursename = $this->db->get_where('nurse', array('id' => $service->nurse))->row()->name;
                                                                        } else {
                                                                            $nursename = " ";
                                                                        }
                                                                        ?>
                                                                        <tr id="on-<?php echo $service->date; ?>-<?php echo $service_update[$i]; ?>">
                                                                            <td><?php echo $servicename->name; ?></td>
                                                                            <td class="on-date" id="on-<?php echo $service_update[$i]; ?>-<?php echo $service->date; ?>"><?php echo $service->date; ?></td>
                                                                            <td><?php echo $nursename; ?></td>
                                                                            <td><input type="number" min="0" name="price_on_service[]" value="<?php echo $price[$i] ?>"class="price-on-services" id="on-service-price-<?php echo $servicename->id ?>"readonly></td>
                                                                            <td><?php echo "1" ?></td>
                                                                            <td><?php echo $settings->currency; ?><?php echo $price[$i] * 1; ?></td>
                                                                            <td><input type="number" min="0" name="discount_on_service[]" value="<?php
                                                                                if (!empty($on_service_discount_price[$i])) {
                                                                                    $dis = $on_service_discount_price[$i];
                                                                                } else {
                                                                                    $dis = '0';
                                                                                } echo $dis;
                                                                                ?>"class="discount-price-on-services" id="on-service-discount-<?php echo $servicename->id; ?>-<?php echo $service->date; ?>"  <?php if (!empty($bed_checkout->date) && !$this->ion_auth->in_group(array('admin'))) { ?> readonly="" <?php } ?>></td>
                                                                            <td id="discount-on-<?php echo $service->date; ?>-<?php echo $servicename->id; ?>"><?php echo $price[$i] - $dis; ?></td>
                                                                            <?php if ($this->ion_auth->in_group(array('admin'))) { ?>


                                                                                <td class="no-print" id="delete-service-on-<?php echo date('d') . '-' . $servicename->id; ?>"><button type='button' class='btn btn-danger btn-xs btn_width delete_service' title='<?php echo lang('delete'); ?>' data-toggle='' data-id="<?php echo $service->id . "**" . $service_update[$i]; ?>"><i class='fa fa-trash'></i></button></td>
                                                                            <?php } ?>
                                                                        </tr>

                                                                        <?php
                                                                    }
                                                                }
                                                                ?>


                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php
                                            $services_all_on = $this->db->get_where('on_service', array('surgery_id' => $surgeries->id))->result();

                                            //    print_r($services_all_on);
                                            //  die();
                                            if (empty($services_all_on)) {
                                                $price_total = '0';
                                                $discount_total_new = '0';
                                                $grand_total_new = '0';
                                            } else {
                                                foreach ($services_all_on as $services) {
                                                    $price_u_on = explode("**", $services->price);
                                                    $discount_u_on = explode("**", $services->discount);
                                                    $price_ups_on[] = array_sum($price_u_on);
                                                    $discount_ups_on[] = array_sum($discount_u_on);
                                                }

                                                $price_total_on = array_sum($price_ups_on);
                                                $discount_total_new_on = array_sum($discount_u_on);
                                                $grand_total_new_on = $price_total_on - $discount_total_new_on;
                                            }
                                            ?>
                                            <div class="form-group col-md-12">
                                                <div class="form-group col-md-4">
                                                    <label for="exampleInputEmail1"><?php echo lang('total_value'); ?></label>
                                                    <input type="text" class="form-control" name="total_value1" id="total_value_on_service" value='<?php
                                                    echo $price_total_on;
                                                    ?>' placeholder="" readonly="">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="exampleInputEmail1"><?php echo lang('total_discount'); ?></label>
                                                    <input type="text" class="form-control" name="total_discount1" id="total_discount_on_service" value='<?php
                                                    echo $discount_total_new_on;
                                                    ?>' placeholder="" readonly="">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="exampleInputEmail1"><?php echo lang('grand_total'); ?></label>
                                                    <input type="text" class="form-control" name="grand_total1" id="grand_total_on_service" value='<?php
                                                    echo $grand_total_new_on;
                                                    ?>' placeholder="" readonly="">
                                                </div>
                                            </div>
                                            <?php if (empty($bed_checkout->date) || $this->ion_auth->in_group(array('admin'))) { ?>
                                                <div>
                                                    <label>--------------------------------------------------------------------------------------- <?php echo "Services" ?> -----------------------------------------------------------------------</label>
                                                    <form role="form" action="" id="editService_on"class="clearfix" method="post" enctype="multipart/form-data">                             
                                                        <div class="form-group col-md-12">

                                                            <div class="col-md-12" id="nurses_select">
                                                                <label><?php echo lang('nurse'); ?></label>

                                                                <select style=" display: block;"class="form-control m-bot15" id="nurse_service_on" name="nurse_service" value=''> 

                                                                </select>
                                                            </div>
                                                            <div class="col-md-12">

                                                                <u>  <h4><?php echo lang('services'); ?></h4></u> <br>
                                                                <?php foreach ($pservice as $patient_service) { ?>
                                                                    <div class="col-md-4" >
                                                                        <input type="checkbox" class="pservice_on" id="pservice-on-<?php echo $patient_service->id; ?>" name="pservice[]" value="<?php echo $patient_service->id; ?>" <?php
                                                                        if (!empty($checked_on)) {
                                                                            if (in_array($patient_service->id, $checked_on)) {
                                                                                echo 'checked';
                                                                            }
                                                                        }
                                                                        ?>>
                                                                        <label><?php echo $patient_service->name; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>

                                                            <input type="hidden" id="on_services_surgery_id" name="surgery_id" value="<?php
                                                            if (!empty($surgeries->id)) {
                                                                echo $surgeries->id;
                                                            }
                                                            ?>">

                                                            </form>
                                                        </div>
                                                </div>
                                            <?php } ?>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="post_surgery" class="tab-pane">
                            <div class="">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#post_medical_analysis"><?php echo lang('medical_analysis'); ?></a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#post_medicines"><?php echo lang('medicines'); ?></a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#post_services"><?php echo lang('service'); ?></a>
                                    </li>


                                </ul>
                                <div class="tab-content">
                                    <div id="post_medical_analysis" class="tab-pane active">
                                        <div class="panel-body">
                                            <div class="adv-table editable-table ">
                                                 <?php if (empty($bed_checkout->date) || $this->ion_auth->in_group(array('admin'))) { ?>
                                                <div class="clearfix no-print col-md-8 pull-right">
                                                    <a data-toggle="modal" href="#post_surgery_medical_modal">
                                                        <div class="btn-group pull-right">
                                                            <button id="post_modal" class="btn green btn-xs">
                                                                <i class="fa fa-plus-circle"></i>  <?php echo lang('add'); ?> 
                                                            </button>
                                                        </div>
                                                    </a>
                                                </div>
                                                 <?php } ?>
                                                <div class="adv-table editable-table">

                                                    <table class="table table-striped table-hover table-bordered" id="editable-sample_post_medical">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 10%"><?php echo lang('date'); ?></th>

                                                                <th style="width: 15%"><?php echo lang('case'); ?> <?php echo lang('title'); ?></th>
                                                                <th style="width: 15%"><?php echo lang('description'); ?> </th>
                                                                <th style="width: 15%"><?php echo lang('status'); ?> </th>

                                                                <th style="width: 15%"><?php echo lang('grand_total'); ?> </th>
                                                                <th style="width: 10%;" class="no-print"><?php echo lang('options'); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="post_medical_surgery_show">
                                                            <?php foreach ($post_medical as $post_medical) { ?>
                                                                <tr id="table-post-<?php echo $post_medical->id; ?>">
                                                                    <td><?php echo date('d-m-Y', $post_medical->date); ?> </td>

                                                                    <td><?php echo $post_medical->title; ?></td>
                                                                    <td><?php
                                                                        $descriptions = explode('##', $post_medical->description);
                                                                        foreach ($descriptions as $description) {
                                                                            $description_single = array();
                                                                            $description_single = explode('**', $description);
                                                                            if ($description_single[0] == 'Package_post_surgery_medical') {
                                                                                ?>
                                                                                <ul><li> <?php echo lang('package'); ?> - <?php echo $description_single[1]; ?></li></ul>
                                                                            <?php } else { ?>
                                                                                <ul><li> <?php echo $description_single[1]; ?></li></ul>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?></td>
                                                                    <td>  <?php
                                                                        if ($post_medical->status == 'Pending Confirmation') {
                                                                            echo lang('pending_confirmation');
                                                                        } if ($post_medical->status == 'Confirmed') {
                                                                            echo lang('confirmed');
                                                                        }
                                                                        ?> </td>

                                                                    <td><?php echo $post_medical->grand_total; ?></td>
                                                                    <td>
                                                                         <?php if (empty($bed_checkout->date) || $this->ion_auth->in_group(array('admin'))) { ?>
                                                                        <button type="button" class="btn btn-info btn-xs btn_width editbutton_post_medical_surgery" data-toggle="modal" data-id="<?php echo $post_medical->id; ?>"><i class="fa fa-edit"></i></button>
                                                                        
                                                                        <button class="btn btn-danger btn-xs btn_width delete_button_medical_post" id="delete-post-surgery-medical-<?php echo $post_medical->id; ?>"><i class="fa fa-trash"> </i></button>
                                                                   
                                                                         <?php } ?>
                                                                        <a class="btn btn-success btn-xs btn_width" title="<?php echo lang('invoice'); ?>" href="finance/invoice?id=<?php echo $post_medical->payment_id; ?>" target="_blank"><i class="fa fa-file-invoice"></i></a>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div id="post_medicines" class="tab-pane">
                                        <div class="">
                                            <div class="col-md-12 pull-right">

                                                <button style="display: block;" id="save_button_post" type="submit" name="submit" class="btn btn-xs btn-info pull-right" ><i class="fa fa-save"></i> <?php echo lang('save'); ?></button>

                                            </div>
                                            <br>
                                            <div class="adv-table editable-table ">
                                                <table style="width: 100% !important;" class="table table-striped table-hover table-bordered" id="editable-table_post_medicine" >
                                                    <thead>
                                                        <tr>

                                                            <th><?php echo lang('date'); ?></th>
                                                            <th><?php echo lang('medicine_gen_name'); ?></th>
                                                            <th><?php echo lang('medicine'); ?> <?php lang('name'); ?></th>
                                                            <th><?php echo lang('sales'); ?> <?php lang('price'); ?></th>
                                                            <th><?php echo lang('quantity'); ?></th>
                                                            <th><?php echo lang('total'); ?></th>
                                                            <?php
                                                            if (empty($bed_checkout->date) || $this->ion_auth->in_group(array('admin'))) {
                                                           // if ($this->ion_auth->in_group(array('admin'))) {
                                                                ?>
                                                                <th class="no-print"><?php echo lang('options'); ?></th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="medicine_table_post">
                                                        <?php foreach ($daily_medicine_post as $medicine) { ?>
                                                            <tr id="post-<?php echo $medicine->id; ?>">
                                                                <td><?php echo $medicine->date; ?></td>
                                                                <td><?php echo $medicine->generic_name; ?></td>
                                                                <td><?php echo $medicine->medicine_name; ?></td>
                                                                <td><?php echo $settings->currency . $medicine->s_price; ?></td>
                                                                <td><?php echo $medicine->quantity; ?></td>
                                                                <td><?php echo $settings->currency . $medicine->total; ?></td>
                                                                <?php
                                                                if ((empty($bed_checkout->date) && empty($medicine->payment_id)) || $this->ion_auth->in_group(array('admin'))) { 
                                                               // if ($this->ion_auth->in_group(array('admin'))) {
                                                                    ?>
                                                                    <td class="no-print" id="delete-post-<?php echo $medicine->id; ?>"><button type='button' class='btn btn-danger btn-xs btn_width delete_medicine' title='<?php echo lang('delete'); ?>' data-toggle='' data-id="<?php echo $medicine->id; ?>"><i class='fa fa-trash'></i></button></td>
                                                                <?php } ?>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                             <?php if (empty($bed_checkout->date) || $this->ion_auth->in_group(array('admin'))) { ?>
                                                <div>
                                                    <label>---------------------------------------------------------------------------------------<?php echo "Select Medicine" ?>-----------------------------------------------------------------------</label>
                                                    <form role="form" action="" id="editMedicine_post"class="clearfix" method="post" enctype="multipart/form-data">                             
                                                        <div class="form-group col-md-12">

                                                            <div class="col-md-3">

                                                                <select style=" display: block;"class="form-control m-bot15" id="generic_name_post" name="generic_name" value='' required=""> 

                                                                </select>
                                                            </div>
                                                            <div class="col-md-3">

                                                                <select style="display: block;" class="form-control m-bot15" id="medicines_option_post" name="medicine_name" value='' required=""> 

                                                                </select>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <input style="display: block;height: 37px;
                                                                       width: 283%;border: 1px solid;" class="input-md" type="text" id="sales_price_post" name="sales_price" value="" placeholder="<?php echo lang('sales'); ?>"readonly="">
                                                            </div> 
                                                            <div class="col-md-1">

                                                                <input style="height: 37px;
                                                                       width: 283%;display: block;border: 1px solid;"  class="input-md" id="quantity_post" type="number" placeholder="<?php echo lang('quantity'); ?>"name="quantity" value="">
                                                            </div> 
                                                            <div class="col-md-1">

                                                                <input style="display: block;height: 37px;
                                                                       width: 283%;border: 1px solid;" class="input-md" type="text" id="total_post" name="total" value="" placeholder="<?php echo lang('total'); ?>" readonly="">
                                                            </div>
                                                            <input type="hidden" id="post_surgery_medicine_id" name="surgery_id" value="<?php
                                                            if (!empty($surgeries->id)) {
                                                                echo $surgeries->id;
                                                            }
                                                            ?>">
                                                            <div class="col-md-2">

                                                                <button style="display: block;" type="submit" name="submit" class="btn btn-xs btn-info pull-right" ><i class="fa fa-save"></i></button>

                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>
                                            <?php } ?>
                                        </div>    
                                    </div>
                                    <div id="post_services" class="tab-pane">
                                        <div class="">
                                            <div class="col-md-12 pull-right">

                                                <button style="display: block;" id="save_button_service_post" type="submit" name="submit" class="btn btn-xs btn-info pull-right" ><i class="fa fa-save"></i> <?php echo lang('save'); ?></button>

                                            </div> 
                                            <div class="adv-table editable-table ">
                                                <table style="width: 100% !important;" class="table table-striped table-hover table-bordered" id="editable-table_post_services">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 20%;"><?php echo lang('service'); ?></th>
                                                            <th style="width: 20%;"><?php echo lang('date'); ?></th>
                                                            <th style="width: 20%;"><?php echo lang('nurse'); ?></th>
                                                            <th style="width: 10%;"><?php echo lang('price'); ?></th>
                                                            <th style="width: 10%;"><?php echo lang('quantity'); ?></th>
                                                            <th style="width: 10%;"><?php echo lang('total'); ?></th>
                                                            <th style="width: 10%;"><?php echo lang('discount'); ?></th>
                                                            <th style="width: 10%;"><?php echo lang('grand_total'); ?></th>
                                                            <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                                                                <th style="width: 10%;" class="no-print"><?php echo lang('options'); ?></th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="paservice_table_post">
                                                        <?php
                                                        if (!empty($daily_service_post)) {
                                                            foreach ($daily_service_post as $service) {
                                                                $price = explode("**", $service->price);

                                                                $service_update = explode("**", $service->service);

                                                                $post_service_discount_price = explode("**", $service->discount);
                                                                $total_discount_pre = array_sum($pre_service_discount_price);
                                                                $price_pre = array_sum($price);
                                                                $array = array_combine($service, $price);
                                                                $length = sizeof($price);
                                                                $length1 = sizeof($service_update);
                                                                if ($length == $length1) {
                                                                    $i = 0;
                                                                    for ($i = 0; $i < $length; $i++) {
                                                                        $servicename = $this->db->get_where('pservice', array('id' => $service_update[$i]))->row();

                                                                        if (!empty($service->nurse)) {
                                                                            $nursename = $this->db->get_where('nurse', array('id' => $service->nurse))->row()->name;
                                                                        } else {
                                                                            $nursename = " ";
                                                                        }
                                                                        ?>
                                                                        <tr id="post-<?php echo $service->date; ?>-<?php echo $service_update[$i]; ?>">
                                                                            <td><?php echo $servicename->name; ?></td>
                                                                            <td class="post-date" id="post-<?php echo $service_update[$i]; ?>-<?php echo $service->date; ?>"><?php echo $service->date; ?></td>
                                                                            <td><?php echo $nursename; ?></td>
                                                                            <td><input type="number" min="0" name="price_post_service[]" value="<?php echo $price[$i] ?>"class="price-post-services" id="post-service-price-<?php echo $servicename->id ?>"readonly></td>
                                                                            <td><?php echo "1" ?></td>
                                                                            <td><?php echo $settings->currency; ?><?php echo $price[$i] * 1; ?></td>
                                                                            <td><input type="number" min="0" name="discount_post_service[]" value="<?php
                                                                                if (!empty($post_service_discount_price[$i])) {
                                                                                    $dis = $post_service_discount_price[$i];
                                                                                } else {
                                                                                    $dis = '0';
                                                                                } echo $dis;
                                                                                ?>"class="discount-price-post-services" id="post-service-discount-<?php echo $servicename->id; ?>-<?php echo $service->date; ?>"  <?php if (!empty($bed_checkout->date) && !$this->ion_auth->in_group(array('admin'))) { ?> readonly=""<?php } ?>></td>
                                                                            <td id="discount-post-<?php echo $service->date; ?>-<?php echo $servicename->id; ?>"><?php echo $price[$i] - $dis; ?></td>
                                                                            <?php if ($this->ion_auth->in_group(array('admin'))) { ?>


                                                                                <td class="no-print" id="delete-service-post-<?php echo date('d') . '-' . $servicename->id; ?>"><button type='button' class='btn btn-danger btn-xs btn_width delete_service' title='<?php echo lang('delete'); ?>' data-toggle='' data-id="<?php echo $service->id . "**" . $service_update[$i]; ?>"><i class='fa fa-trash'></i></button></td>
                                                                            <?php } ?>
                                                                        </tr>

                                                                        <?php
                                                                    }
                                                                }
                                                                ?>


                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php
                                            $services_all_post = $this->db->get_where('post_service', array('surgery_id' => $surgeries->id))->result();
                                            if (empty($services_all_post)) {
                                                $price_total = '0';
                                                $discount_total_new = '0';
                                                $grand_total_new = '0';
                                            } else {
                                                foreach ($services_all_post as $services) {
                                                    $price_u_post = explode("**", $services->price);
                                                    $discount_u_post = explode("**", $services->discount);
                                                    $price_ups_post[] = array_sum($price_u_post);
                                                    $discount_ups_post[] = array_sum($discount_u_post);
                                                }

                                                $price_total_post = array_sum($price_ups_post);
                                                $discount_total_new_post = array_sum($discount_u_post);
                                                $grand_total_new_post = $price_total_post - $discount_total_new_post;
                                            }
                                            ?>
                                            <div class="form-group col-md-12">
                                                <div class="form-group col-md-4">
                                                    <label for="exampleInputEmail1"><?php echo lang('total_value'); ?></label>
                                                    <input type="text" class="form-control" name="total_value1" id="total_value_post_service" value='<?php
                                                    echo $price_total_post;
                                                    ?>' placeholder="" readonly="">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="exampleInputEmail1"><?php echo lang('total_discount'); ?></label>
                                                    <input type="text" class="form-control" name="total_discount1" id="total_discount_post_service" value='<?php
                                                    echo $discount_total_new_post;
                                                    ?>' placeholder="" readonly="">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="exampleInputEmail1"><?php echo lang('grand_total'); ?></label>
                                                    <input type="text" class="form-control" name="grand_total1" id="grand_total_post_service" value='<?php
                                                    echo $grand_total_new_post;
                                                    ?>' placeholder="" readonly="">
                                                </div>
                                            </div>
                                             <?php if (empty($bed_checkout->date) || $this->ion_auth->in_group(array('admin'))) { ?>
                                                <div>
                                                    <label>--------------------------------------------------------------------------------------- <?php echo "Services" ?> -----------------------------------------------------------------------</label>
                                                    <form role="form" action="" id="editService_post"class="clearfix" method="post" enctype="multipart/form-data">                             
                                                        <div class="form-group col-md-12">

                                                            <div class="col-md-12" id="nurses_select">
                                                                <label><?php echo lang('nurse'); ?></label>

                                                                <select style=" display: block;"class="form-control m-bot15" id="nurse_service_post" name="nurse_service" value=''> 

                                                                </select>
                                                            </div>
                                                            <div class="col-md-12">

                                                                <u>  <h4><?php echo lang('services'); ?></h4></u> <br>
                                                                <?php foreach ($pservice as $patient_service) { ?>
                                                                    <div class="col-md-4" >
                                                                        <input type="checkbox" class="pservice_post" id="pservice-post-<?php echo $patient_service->id; ?>" name="pservice[]" value="<?php echo $patient_service->id; ?>" <?php
                                                                        if (!empty($checked_post)) {
                                                                            if (in_array($patient_service->id, $checked_post)) {
                                                                                echo 'checked';
                                                                            }
                                                                        }
                                                                        ?>>
                                                                        <label><?php echo $patient_service->name; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>

                                                            <input type="hidden" id="post_services_surgery_id" name="surgery_id" value="<?php
                                                            if (!empty($surgeries->id)) {
                                                                echo $surgeries->id;
                                                            }
                                                            ?>">

                                                            </form>
                                                        </div>
                                                </div>
                                            <?php } ?>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="discharge" class="tab-pane"> <div class="">

                                <div class="adv-table editable-table ">
                                    <div class="">
                                        <form role="form" action="" id="editCheckout"class="clearfix" method="post" enctype="multipart/form-data">                             
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputEmail1"><?php echo lang('checkin'); ?> <?php echo lang('date'); ?> <?php echo lang('time'); ?></label>


                                                <input type="text" class="form-control" readonly="" name="a_time" id="exampleInputEmail1" value='<?php
                                                if (!empty($checkin->a_time)) {
                                                    echo $checkin->a_time;
                                                }
                                                ?>' placeholder="" required=""<?php
                                                       //  if (!empty($allotment->date) && !$this->ion_auth->in_group(array('admin'))) {
                                                       echo 'readonly';
                                                       // }
                                                       ?>>

                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputEmail1"><?php echo lang('checkout'); ?> <?php echo lang('date'); ?> <?php echo lang('time'); ?></label>
                                                <div data-date="" class="input-group date form_datetime-meridian">
                                                    <div class="input-group-btn"> 
                                                        <button type="button" class="btn btn-info date-set"><i class="fa fa-calendar"></i></button>
                                                        <button type="button" class="btn btn-danger date-reset"><i class="fa fa-times"></i></button>
                                                    </div>
                                                    <input type="text" class="form-control" readonly="" name="date" id="exampleInputEmail1" value='<?php
                                                    if (!empty($bed_checkout->date)) {
                                                        echo $bed_checkout->date;
                                                    }
                                                    ?>' placeholder="" required=""<?php
                                                           if (!empty($bed_checkout->date) && !$this->ion_auth->in_group(array('admin'))) {
                                                               echo 'readonly';
                                                           }
                                                           ?>>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">

                                                <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('type_of_admission'); ?>:</label>

                                                <span></span>
                                                <?php $type_of_admission = explode(',', $bed_checkout->type_of_admission);
                                                ?>

                                                <input type="checkbox" name="type_of_admission[]" value="emergency" <?php
                                                if (in_array('emergency', $type_of_admission)) {
                                                    echo "checked";
                                                }
                                                ?>>
                                                <label style="margin-right: 56px;"><?php echo lang('emergency'); ?></label>
                                                <input type="checkbox" name="type_of_admission[]" value="no_emergency" <?php
                                                if (in_array('no_emergency', $type_of_admission)) {
                                                    echo "checked";
                                                }
                                                ?>>
                                                <label style="margin-right: 56px;"><?php echo lang('no_emergency'); ?></label>
                                                <input type="checkbox" name="type_of_admission[]" value="planned" <?php
                                                if (in_array('planned', $type_of_admission)) {
                                                    echo "checked";
                                                }
                                                ?>>
                                                <label><?php echo lang('planned'); ?></label>

                                            </div>
                                            <div class="form-group col-md-12">

                                                <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('diagnosis_at_admission'); ?>:</label>
                                                <textarea name="diagnosis_at_admission" class='form-control'<?php
                                                if (!empty($bed_checkout->date) && !$this->ion_auth->in_group(array('admin'))) {
                                                    echo 'readonly';
                                                }
                                                ?>><?php
                                                              if (!empty($bed_checkout->diagnosis_at_admission)) {
                                                                  echo $bed_checkout->diagnosis_at_admission;
                                                              }
                                                              ?> </textarea>

                                            </div>
                                            <div class="form-group col-md-12">

                                                <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('patient_status_at_admission_objective_admission'); ?>:</label>
                                                <textarea name="patient_status_at_admission_objective_admission" class='form-control'<?php
                                                if (!empty($bed_checkout->date) && !$this->ion_auth->in_group(array('admin'))) {
                                                    echo 'readonly';
                                                }
                                                ?>><?php
                                                              if (!empty($bed_checkout->patient_status_at_admission_objective_admission)) {
                                                                  echo $bed_checkout->patient_status_at_admission_objective_admission;
                                                              }
                                                              ?> </textarea>

                                            </div>
                                            <div class="form-group col-md-12">

                                                <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('course_of_disease'); ?>:</label>
                                                <textarea name="course_of_disease" class='form-control'<?php
                                                if (!empty($bed_checkout->date) && !$this->ion_auth->in_group(array('admin'))) {
                                                    echo 'readonly';
                                                }
                                                ?>><?php
                                                              if (!empty($bed_checkout->course_of_disease)) {
                                                                  echo $bed_checkout->course_of_disease;
                                                              }
                                                              ?> </textarea>

                                            </div>
                                            <div class="form-group col-md-12">

                                                <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('laboratory_examination_results_imaging_and_other_examinations'); ?>:</label>
                                                <textarea name="laboratory_examination_results" class='form-control'<?php
                                                if (!empty($bed_checkout->date) && !$this->ion_auth->in_group(array('admin'))) {
                                                    echo 'readonly';
                                                }
                                                ?>><?php
                                                              if (!empty($bed_checkout->laboratory_examination_results)) {
                                                                  echo $bed_checkout->laboratory_examination_results;
                                                              }
                                                              ?> </textarea>

                                            </div>
                                            <div class="form-group col-md-12">

                                                <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('applied_therapy'); ?>:</label>
                                                <textarea name="applied_therapy" class='form-control'<?php
                                                if (!empty($bed_checkout->date) && !$this->ion_auth->in_group(array('admin'))) {
                                                    echo 'readonly';
                                                }
                                                ?>><?php
                                                              if (!empty($bed_checkout->applied_therapy)) {
                                                                  echo $bed_checkout->applied_therapy;
                                                              }
                                                              ?> </textarea>

                                            </div>
                                            <div class="form-group col-md-12">

                                                <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('diagnosis_at_discharge'); ?>:</label>
                                                <textarea name="diagnosis_at_discharge" class='form-control'<?php
                                                if (!empty($bed_checkout->date) && !$this->ion_auth->in_group(array('admin'))) {
                                                    echo 'readonly';
                                                }
                                                ?>><?php
                                                              if (!empty($bed_checkout->diagnosis_at_discharge)) {
                                                                  echo $bed_checkout->diagnosis_at_discharge;
                                                              }
                                                              ?> </textarea>

                                            </div>
                                            <div class="form-group col-md-12">

                                                <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('result'); ?>:</label>

                                                <span></span>
                                                <?php $result = explode(',', $bed_checkout->result);
                                                ?>

                                                <input type="checkbox" name="result[]" value="recovery" <?php
                                                if (in_array('recovery', $result)) {
                                                    echo "checked";
                                                }
                                                ?>>
                                                <label style="margin-right: 56px;"><?php echo lang('recovery'); ?></label>
                                                <input type="checkbox" name="result[]" value="improvement" <?php
                                                if (in_array('improvement', $result)) {
                                                    echo "checked";
                                                }
                                                ?>>
                                                <label style="margin-right: 56px;"><?php echo lang('improvement'); ?></label>
                                                <input type="checkbox" name="result[]" value="unchanged" <?php
                                                if (in_array('unchanged', $result)) {
                                                    echo "checked";
                                                }
                                                ?>>
                                                <label style="margin-right: 56px;"><?php echo lang('unchanged'); ?></label>
                                                <input type="checkbox" name="result[]" value="exit" <?php
                                                if (in_array('exit', $result)) {
                                                    echo "checked";
                                                }
                                                ?>>
                                                <label><?php echo lang('exit'); ?></label>

                                            </div>
                                            <div class="col-md-12">
                                                <u>  <h3><?php echo lang('rexommendation_at_discharge'); ?></h3></u>
                                            </div>
                                            <div class="form-group col-md-12">

                                                <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('therapy'); ?>:</label>
                                                <textarea name="therapy" class='form-control'<?php
                                                if (!empty($bed_checkout->date) && !$this->ion_auth->in_group(array('admin'))) {
                                                    echo 'readonly';
                                                }
                                                ?>><?php
                                                              if (!empty($bed_checkout->therapy)) {
                                                                  echo $bed_checkout->therapy;
                                                              }
                                                              ?> </textarea>

                                            </div>
                                            <div class="form-group col-md-6">

                                                <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('next_examination'); ?>:</label>
                                                <input type="text" name="next_examination" class='form-control default-date-picker' value="<?php
                                                if (!empty($bed_checkout->next_examination)) {
                                                    echo $bed_checkout->next_examination;
                                                }
                                                ?> "<?php
                                                       //  if (!empty($allotment->date) && !$this->ion_auth->in_group(array('admin'))) {
                                                       echo 'readonly';
                                                       //    }
                                                       ?>>

                                            </div>
                                            <div class="form-group col-md-6">

                                                <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('ability_to_work'); ?>:</label>
                                                <input type="text" name="ability_to_work" class='form-control default-date-picker' value="<?php
                                                if (!empty($bed_checkout->ability_to_work)) {
                                                    echo $bed_checkout->ability_to_work;
                                                }
                                                ?>"<?php
                                                       //if (!empty($allotment->date) && !$this->ion_auth->in_group(array('admin'))) {
                                                       echo 'readonly';
                                                       // }
                                                       ?>> 

                                            </div>
                                            <div class="form-group col-md-12">

                                                <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('advises_given_to'); ?>:</label>
                                                <textarea name="advises_given_to" class='form-control'<?php
                                                if (!empty($bed_checkout->date) && !$this->ion_auth->in_group(array('admin'))) {
                                                    echo 'readonly';
                                                }
                                                ?>><?php
                                                              if (!empty($bed_checkout->advises_given_to)) {
                                                                  echo $bed_checkout->advises_given_to;
                                                              }
                                                              ?> </textarea>

                                            </div>
                                            <div class="col-md-12">
                                                <u>  <h3><?php echo lang('patient_transfer'); ?></h3></u>
                                            </div>
                                            <div class="form-group col-md-4">

                                                <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('hospital_name'); ?>:</label>
                                                <input type="text" name="hospital_name" class='form-control' value="<?php
                                                if (!empty($bed_checkout->hospital_name)) {
                                                    echo $bed_checkout->hospital_name;
                                                }
                                                ?>"<?php
                                                       if (!empty($bed_checkout->date) && !$this->ion_auth->in_group(array('admin'))) {
                                                           echo 'readonly';
                                                       }
                                                       ?>> 

                                            </div>
                                            <div class="form-group col-md-4">

                                                <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('physican_name'); ?>:</label>
                                                <input type="text" name="physican_name" class='form-control' value="<?php
                                                if (!empty($bed_checkout->physican_name)) {
                                                    echo $bed_checkout->physican_name;
                                                }
                                                ?>"<?php
                                                       if (!empty($bed_checkout->date) && !$this->ion_auth->in_group(array('admin'))) {
                                                           echo 'readonly';
                                                       }
                                                       ?>> 

                                            </div>

                                            <div class="form-group col-md-4">

                                                <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('contact_no'); ?>:</label>
                                                <input type="text" name="contact_no" class='form-control' value="<?php
                                                if (!empty($bed_checkout->contact_no)) {
                                                    echo $bed_checkout->contact_no;
                                                }
                                                ?>"<?php
                                                       if (!empty($bed_checkout->date) && !$this->ion_auth->in_group(array('admin'))) {
                                                           echo 'readonly';
                                                       }
                                                       ?>> 

                                            </div>
                                            <div class="form-group col-md-6">

                                                <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('legal_custodiam'); ?>:</label>
                                                <input type="text" name="legal_custodiam" class='form-control' value="<?php
                                                if (!empty($bed_checkout->legal_custodiam)) {
                                                    echo $bed_checkout->legal_custodiam;
                                                }
                                                ?>"<?php
                                                       if (!empty($bed_checkout->date) && !$this->ion_auth->in_group(array('admin'))) {
                                                           echo 'readonly';
                                                       }
                                                       ?>> 

                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputEmail1"><?php echo lang('attending_doctor'); ?></label>
                                                <select class="form-control m-bot15" id="doctors_checkout" name="doctors_checkout" value=''> 
                                                    <?php $doctor1 = $this->db->get_where('doctor', array('id' => $bed_checkout->doctor))->row();

                                                    if (!empty($bed_checkout->doctor)) {
                                                        ?>
                                                        <option value="<?php echo $bed_checkout->doctor; ?>"  <?php
                                                        if (!empty($bed_checkout->date) && !$this->ion_auth->in_group(array('admin'))) {
                                                            echo 'selected';
                                                            echo 'disabled';
                                                        }
                                                        ?>><?php echo $doctor1->name . '(Id:' . $doctor1->id . ')'; ?></option>
<?php } ?>
                                                </select>
                                            </div>
                                            <input type="hidden" name="id" value="<?php
                                            if (!empty($bed_checkout->id)) {
                                                echo $bed_checkout->id;
                                            }
                                            ?>">
                                            <input type="hidden" id="discharge_surgery_id"name="surgery_id" value="<?php
                                            if (!empty($surgeries->id)) {
                                                echo $surgeries->id;
                                            }
                                            ?>">
<?php if (empty($bed_checkout->date) || $this->ion_auth->in_group(array('admin'))) { ?>
                                                <div class="col-md-12">

                                                    <button style="display: block;" id="checkout_submit" type="submit" name="submit" class="btn btn-xs btn-info pull-right" ><?php echo lang('save'); ?></button>

                                                </div>
<?php } ?>
                                        </form>
                                    </div>
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

<div class="modal fade" id="pre_surgery_medical_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('add'); ?> <?php echo lang('medical_analysis'); ?></h4>
            </div>
            <div class="modal-body row">
                <div class="clearfix">
<?php echo validation_errors(); ?>
                    <form role="form" id="pre_surgery_add_medical_analysis" class="clearfix" method="post" enctype="multipart/form-data">


                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"><?php echo lang('title'); ?></label>
                            <input type="text" class="form-control" name="title" id="exampleInputEmail1" value='<?php ?>' placeholder="">
                        </div>
                        <div class="col-md-6 panel">
                            <label for="exampleInputEmail1">  <?php echo lang('status'); ?></label> 
                            <select class="form-control m-bot15" name="status" value=''> 
                                <option value="Pending Confirmation"> <?php echo lang('pending_confirmation'); ?> </option>
                                <option value="Confirmed"> <?php echo lang('confirmed'); ?> </option>

                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1"><?php echo lang('remarks'); ?></label>
                            <input type="text" class="form-control" name="remarks" id="exampleInputEmail1" value='' placeholder="">
                        </div>

                        <div class="adv-table editable-table ">
                            <table style="width: 100% !important;" class="table table-striped table-hover table-bordered" id="editable-table_pre_medical_analysis">
                                <thead>
                                    <tr>
                                        <th style=""><?php echo lang('items'); ?></th>
                                        <th style=""><?php echo lang('type'); ?></th>
                                        <th style=""><?php echo lang('price'); ?></th>
                                        <th style=""><?php echo lang('discount'); ?></th>
                                        <th style="width:20%;"><?php echo lang('date_to_be_done'); ?></th>
                                        <th style=""><?php echo lang('status'); ?></th>
                                        <th style="" class="no-print"><?php echo lang('options'); ?></th>

                                    </tr>
                                </thead>
                                <tbody id="package_proccedure">

                                </tbody>
                            </table>
                        </div>
                        <input type="hidden" name="id" id="pre_surgery_medical_analysis" value=''>
                        <input type="hidden" name="surgery_id" value='<?php
                        if (!empty($pre_surgery_medical_analysis->surgery_id)) {
                            echo $pre_surgery_medical_analysis->surgery_id;
                        } else {
                            echo $surgeries->id;
                        }
                        ?>'>
                        <input type="hidden" name="redirect" value='case_list'>
                        <div class="form-group col-md-12">
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"><?php echo lang('total_value'); ?></label>
                                <input type="text" class="form-control" name="total_value" id="total_value" value='' placeholder="" readonly="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"><?php echo lang('total_discount'); ?></label>
                                <input type="text" class="form-control" name="total_discount" id="total_discount" value='0' placeholder="" readonly="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"><?php echo lang('grand_total'); ?></label>
                                <input type="text" class="form-control" name="grand_total" id="grand_total" value='' placeholder="" readonly="">
                            </div>
                        </div>
<?php if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Nurse', 'Doctor', 'Laboratorist', 'Receptionist')) || $permis == 'ok') { ?>
                            <div class="separator col-md-12"><?php echo lang('select'); ?></div>
                            <br>  <br>
                            <div class="col-md-12" style="margin-top:20px;">
                                <div class="col-md-5">

                                    <select style=" display: block;"class="form-control m-bot15 js-example-basic-single" id="package" name="package" value='' required=""> 
                                        <option><?php echo lang('select'); ?> <?php echo lang('packages'); ?></option>
                                                <?php foreach ($packages as $package) { ?>
                                            <option value="<?php echo $package->id;
                                                    ?>"><?php echo $package->name; ?></option>
    <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-5">

                                    <select style=" display: block;"class="form-control m-bot15 js-example-basic-single" id="medical_analysis" name="medical_analysis" value='' required=""> 
                                        <option><?php echo lang('select'); ?> <?php echo lang('medical_analysis'); ?></option>
                                                <?php foreach ($payment_category as $category) { ?>
                                            <option value="<?php echo $category->id;
                                                    ?>"><?php echo $category->category; ?></option>
    <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-info" id="add_pre_surgery_medical_analysis"><i class="fa fa-save"></i></button>     
                                </div>



                            </div>
<?php } ?>                  
                        <div class="form-group col-md-12" style="margin-top:20px;">
                            <button type="submit" id="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('add'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  Start Surgery -->
<div class="modal fade" id="on_surgery_medical_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('add'); ?> <?php echo lang('medical_analysis'); ?></h4>
            </div>
            <div class="modal-body row">
                <div class="clearfix">
<?php echo validation_errors(); ?>
                    <form role="form" id="on_surgery_add_medical_analysis" class="clearfix" method="post" enctype="multipart/form-data">


                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"><?php echo lang('title'); ?></label>
                            <input type="text" class="form-control" name="title" id="exampleInputEmail1" value='<?php ?>' placeholder="">
                        </div>
                        <div class="col-md-6 panel">
                            <label for="exampleInputEmail1">  <?php echo lang('status'); ?></label> 
                            <select class="form-control m-bot15" name="status" value=''> 
                                <option value="Pending Confirmation"> <?php echo lang('pending_confirmation'); ?> </option>
                                <option value="Confirmed"> <?php echo lang('confirmed'); ?> </option>

                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1"><?php echo lang('remarks'); ?></label>
                            <input type="text" class="form-control" name="remarks" id="exampleInputEmail1" value='' placeholder="">
                        </div>

                        <div class="adv-table editable-table ">
                            <table style="width: 100% !important;" class="table table-striped table-hover table-bordered" id="editable-table_on_medical_analysis">
                                <thead>
                                    <tr>
                                        <th style=""><?php echo lang('items'); ?></th>
                                        <th style=""><?php echo lang('type'); ?></th>
                                        <th style=""><?php echo lang('price'); ?></th>
                                        <th style=""><?php echo lang('discount'); ?></th>
                                        <th style="width:20%;"><?php echo lang('date_to_be_done'); ?></th>
                                        <th style=""><?php echo lang('status'); ?></th>
                                        <th style="" class="no-print"><?php echo lang('options'); ?></th>

                                    </tr>
                                </thead>
                                <tbody id="package_proccedure_on">

                                </tbody>
                            </table>
                        </div>
                        <input type="hidden" name="id" id="on_surgery_medical_analysis" value=''>
                        <input type="hidden" name="surgery_id" value='<?php
                        if (!empty($on_surgery_medical_analysis->surgery_id)) {
                            echo $on_surgery_medical_analysis->surgery_id;
                        } else {
                            echo $surgeries->id;
                        }
                        ?>'>

                        <div class="form-group col-md-12">
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"><?php echo lang('total_value'); ?></label>
                                <input type="text" class="form-control" name="total_value" id="total_value_on" value='' placeholder="" readonly="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"><?php echo lang('total_discount'); ?></label>
                                <input type="text" class="form-control" name="total_discount" id="total_discount_on" value='0' placeholder="" readonly="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"><?php echo lang('grand_total'); ?></label>
                                <input type="text" class="form-control" name="grand_total" id="grand_total_on" value='' placeholder="" readonly="">
                            </div>
                        </div>
<?php if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Nurse', 'Doctor', 'Laboratorist', 'Receptionist')) || $permis == 'ok') { ?>
                            <div class="separator col-md-12"><?php echo lang('select'); ?></div>
                            <br>  <br>
                            <div class="col-md-12" style="margin-top:20px;">
                                <div class="col-md-5">

                                    <select style=" display: block;"class="form-control m-bot15 js-example-basic-single" id="package_on" name="package" value='' required=""> 
                                        <option><?php echo lang('select'); ?> <?php echo lang('packages'); ?></option>
                                                <?php foreach ($packages as $package) { ?>
                                            <option value="<?php echo $package->id;
                                                    ?>"><?php echo $package->name; ?></option>
    <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-5">

                                    <select style=" display: block;"class="form-control m-bot15 js-example-basic-single" id="medical_analysis_on" name="medical_analysis" value='' required=""> 
                                        <option><?php echo lang('select'); ?> <?php echo lang('medical_analysis'); ?></option>
                                                <?php foreach ($payment_category as $category) { ?>
                                            <option value="<?php echo $category->id;
                                                    ?>"><?php echo $category->category; ?></option>
    <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-info" id="add_on_surgery_medical_analysis"><i class="fa fa-save"></i></button>     
                                </div>



                            </div>
<?php } ?>                  
                        <div class="form-group col-md-12" style="margin-top:20px;">
                            <button type="submit" id="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('add'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Surgery -->
<!--Start POst Surgery-->
<div class="modal fade" id="post_surgery_medical_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('add'); ?> <?php echo lang('medical_analysis'); ?></h4>
            </div>
            <div class="modal-body row">
                <div class="clearfix">
<?php echo validation_errors(); ?>
                    <form role="form" id="post_surgery_add_medical_analysis" class="clearfix" method="post" enctype="multipart/form-data">


                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"><?php echo lang('title'); ?></label>
                            <input type="text" class="form-control" name="title" id="exampleInputEmail1" value='<?php ?>' placeholder="">
                        </div>
                        <div class="col-md-6 panel">
                            <label for="exampleInputEmail1">  <?php echo lang('status'); ?></label> 
                            <select class="form-control m-bot15" name="status" value=''> 
                                <option value="Pending Confirmation"> <?php echo lang('pending_confirmation'); ?> </option>
                                <option value="Confirmed"> <?php echo lang('confirmed'); ?> </option>

                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1"><?php echo lang('remarks'); ?></label>
                            <input type="text" class="form-control" name="remarks" id="exampleInputEmail1" value='' placeholder="">
                        </div>

                        <div class="adv-table editable-table ">
                            <table style="width: 100% !important;" class="table table-striped table-hover table-bordered" id="editable-table_post_medical_analysis">
                                <thead>
                                    <tr>
                                        <th style=""><?php echo lang('items'); ?></th>
                                        <th style=""><?php echo lang('type'); ?></th>
                                        <th style=""><?php echo lang('price'); ?></th>
                                        <th style=""><?php echo lang('discount'); ?></th>
                                        <th style="width:20%;"><?php echo lang('date_to_be_done'); ?></th>
                                        <th style=""><?php echo lang('status'); ?></th>
                                        <th style="" class="no-print"><?php echo lang('options'); ?></th>

                                    </tr>
                                </thead>
                                <tbody id="package_proccedure_post">

                                </tbody>
                            </table>
                        </div>
                        <input type="hidden" name="id" id="post_surgery_medical_analysis" value=''>
                        <input type="hidden" name="surgery_id" value='<?php
                        if (!empty($post_surgery_medical_analysis->surgery_id)) {
                            echo $post_surgery_medical_analysis->surgery_id;
                        } else {
                            echo $surgeries->id;
                        }
                        ?>'>

                        <div class="form-group col-md-12">
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"><?php echo lang('total_value'); ?></label>
                                <input type="text" class="form-control" name="total_value" id="total_value_post" value='' placeholder="" readonly="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"><?php echo lang('total_discount'); ?></label>
                                <input type="text" class="form-control" name="total_discount" id="total_discount_post" value='0' placeholder="" readonly="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"><?php echo lang('grand_total'); ?></label>
                                <input type="text" class="form-control" name="grand_total" id="grand_total_post" value='' placeholder="" readonly="">
                            </div>
                        </div>
<?php if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Nurse', 'Doctor', 'Laboratorist', 'Receptionist')) || $permis == 'ok') { ?>
                            <div class="separator col-md-12"><?php echo lang('select'); ?></div>
                            <br>  <br>
                            <div class="col-md-12" style="margin-top:20px;">
                                <div class="col-md-5">

                                    <select style=" display: block;"class="form-control m-bot15 js-example-basic-single" id="package_post" name="package" value='' required=""> 
                                        <option><?php echo lang('select'); ?> <?php echo lang('packages'); ?></option>
                                                <?php foreach ($packages as $package) { ?>
                                            <option value="<?php echo $package->id;
                                                    ?>"><?php echo $package->name; ?></option>
    <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-5">

                                    <select style=" display: block;"class="form-control m-bot15 js-example-basic-single" id="medical_analysis_post" name="medical_analysis" value='' required=""> 
                                        <option><?php echo lang('select'); ?> <?php echo lang('medical_analysis'); ?></option>
                                                <?php foreach ($payment_category as $category) { ?>
                                            <option value="<?php echo $category->id;
                                                    ?>"><?php echo $category->category; ?></option>
    <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-info" id="add_post_surgery_medical_analysis"><i class="fa fa-save"></i></button>     
                                </div>



                            </div>
<?php } ?>                  
                        <div class="form-group col-md-12" style="margin-top:20px;">
                            <button type="submit" id="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('add'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Post Surgery-->
<?php
$current_user = $this->ion_auth->get_user_id();
if ($this->ion_auth->in_group('Doctor')) {
    $doctor_id = $this->db->get_where('doctor', array('ion_user_id' => $current_user))->row()->id;
}
?>

<style>


    thead {
        background: #f1f1f1; 
        border-bottom: 1px solid #ddd; 
    }

    .btn_width{
        margin-bottom: 20px;
    }

    .tab-content{
        padding: 20px 0px;
    }

    .cke_editable {
        min-height: 1000px;
    }




</style>


<script src="common/js/codearistos.min.js"></script>

<script>
                                                $(document).ready(function () {
                                                    $(".flashmessage").delay(3000).fadeOut(100);
                                                });</script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>-->
<script src="common/toastr/js/toastr.js"></script>
<link rel="stylesheet" type="text/css" href="common/toastr/css/toastr.css">


<script>
                                                $(document).ready(function () {
                                                    $('#editable-sample_pre_medical').on("click", ".editbutton_pre_medical_surgery", function () {
                                                        var iid = $(this).attr('data-id');
                                                        $('#pre_surgery_add_medical_analysis').trigger("reset");
                                                        $('.proccedure').html(" ");
                                                        $('#package_proccedure').html(" ");
                                                        $('#pre_surgery_medical_modal').modal('show');
                                                        $.ajax({
                                                            url: 'surgery/editPreMedicalSurgery?id=' + iid,
                                                            method: 'GET',
                                                            data: '',
                                                            dataType: 'json',
                                                        }).success(function (response) {
                                                            // if (response.edited == '1') {
                                                            //     $('#table-' + iid).html(" ");
                                                            // }
                                                            $('#pre_surgery_add_medical_analysis').find('[name="id"]').val(response.surgery_pre.id).end()
                                                            $('#pre_surgery_add_medical_analysis').find('[name="title"]').val(response.surgery_pre.title).end()
                                                            $('#pre_surgery_add_medical_analysis').find('[name="remarks"]').val(response.surgery_pre.remarks).end()
                                                            $('#pre_surgery_add_medical_analysis').find('[name="status"]').val(response.surgery_pre.status).trigger('change');
                                                            $('#pre_surgery_add_medical_analysis').find('[name="total_value"]').val(response.surgery_pre.total_price).end();
                                                            $('#pre_surgery_add_medical_analysis').find('[name="total_discount"]').val(response.surgery_pre.total_discount).end();
                                                            $('#pre_surgery_add_medical_analysis').find('[name="grand_total"]').val(response.surgery_pre.grand_total).end();
                                                            $('#package_proccedure').append(response.option);
                                                            //toastr.success(response.message.message);
                                                        })
                                                    })
                                                    $('#editable-sample_pre_medical').on("click", ".delete_button_medical_pre", function () {
                                                        var id = $(this).attr('id');
                                                        var id_separate = id.split("-");
                                                        $.ajax({
                                                            url: 'surgery/deletePreMedicalSurgery?id=' + id_separate[4],
                                                            method: 'GET',
                                                            data: '',
                                                            dataType: 'json',
                                                        }).success(function (response) {
                                                            toastr.warning(response.message);
                                                            $('#table-' + id_separate[4]).html(" ");
                                                        })
                                                    })

                                                });
</script>
<script>
    $(document).ready(function () {
        $('#add_pre_surgery_medical_analysis').click(function (e) {
            var medical_analysis = $('#medical_analysis').val();
            var package = $('#package').val();

            if ($('table#editable-table_pre_medical_analysis').find('#tr-med-' + medical_analysis).length > 0 && $('table#editable-table_pre_medical_analysis').find('#tr-pack-' + package).length > 0) {
                alert('Already in the List');
            } else if (package === 'Select Packages' && medical_analysis === 'Select Medical Analysis') {
                alert('Please Select a package or Medical Analysis');
            } else if ($('table#editable-table_pre_medical_analysis').find('#tr-med-' + medical_analysis).length > 0 && $('table#editable-table_pre_medical_analysis').find('#tr-pack-' + package).length <= 0) {
                $.ajax({
                    url: 'surgery/getTableTrValueForPreSurgeryMedicalAnalysis?package=' + package,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                }).success(function (response) {
                    $('#package_proccedure').after(response.option);
                    var values = $("input[name^='price[]']").map(function (idx, ele) {
                        return $(ele).val();
                    }).get();
                    var discount_values = $("input[name^='discount_price[]']").map(function (idx1, ele1) {
                        return $(ele1).val();
                    }).get();
                    var dis_sum = 0;

                    $.each(discount_values, function (index1, value1) {
                        // alert(index + ": " + value);
                        var number1 = parseInt(value1, 10);
                        dis_sum += number1;
                    });

                    var sum = 0;
                    $.each(values, function (index, value) {
                        // alert(index + ": " + value);
                        var number = parseInt(value, 10);
                        sum += number;
                    });

                    var grand = parseInt(sum, 10) - parseInt(dis_sum, 10);
                    $('#total_discount').val(dis_sum);
                    $('#grand_total').val(grand);
                    $('#total_value').val(sum);
                })
            } else if ($('table#editable-table_pre_medical_analysis').find('#tr-med-' + medical_analysis).length <= 0 && $('table#editable-table_pre_medical_analysis').find('#tr-pack-' + package).length > 0) {
                $.ajax({
                    url: 'surgery/getTableTrValueForPreSurgeryMedicalAnalysis?medical_analysis=' + medical_analysis,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                }).success(function (response) {
                    $('#package_proccedure').after(response.option);
                    var values = $("input[name^='price[]']").map(function (idx, ele) {
                        return $(ele).val();
                    }).get();
                    var discount_values = $("input[name^='discount_price[]']").map(function (idx1, ele1) {
                        return $(ele1).val();
                    }).get();
                    var dis_sum = 0;

                    $.each(discount_values, function (index1, value1) {
                        // alert(index + ": " + value);
                        var number1 = parseInt(value1, 10);
                        dis_sum += number1;
                    });

                    var sum = 0;
                    $.each(values, function (index, value) {
                        // alert(index + ": " + value);
                        var number = parseInt(value, 10);
                        sum += number;
                    });

                    var grand = parseInt(sum, 10) - parseInt(dis_sum, 10);
                    $('#total_discount').val(dis_sum);
                    $('#grand_total').val(grand);
                    $('#total_value').val(sum);
                })
            } else {
                if (package === 'Select Packages') {
                    var url = 'surgery/getTableTrValueForPreSurgeryMedicalAnalysis?medical_analysis=' + medical_analysis;
                } else if (medical_analysis === 'Select Medical Analysis') {
                    var url = 'surgery/getTableTrValueForPreSurgeryMedicalAnalysis?package=' + package;
                } else {
                    var url = 'surgery/getTableTrValueForPreSurgeryMedicalAnalysis?medical_analysis=' + medical_analysis + '&package=' + package;
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
                        var number = parseInt(value, 10);
                        sum += number;
                    });
                    $('#total_value').val(sum);
                    var discount_values = $("input[name^='discount_price[]']").map(function (idx1, ele1) {
                        return $(ele1).val();
                    }).get();
                    var dis_sum = 0;

                    $.each(discount_values, function (index1, value1) {
                        // alert(index + ": " + value);
                        var number1 = parseInt(value1, 10);
                        dis_sum += number1;
                    });



                    var grand = parseInt(sum, 10) - parseInt(dis_sum, 10);
                    // alert(grand);
                    $('#total_discount').val(dis_sum);
                    $('#grand_total').val(grand);

                })
            }
            e.preventDefault();
        })
    })


    $(document).ready(function () {
        $("#editable-table_pre_medical_analysis").on("keyup", ".discount-price-indivudual", function () {

            var discount_values = $("input[name^='discount_price[]']").map(function (idx, ele) {
                return $(ele).val();
            }).get();
            var dis_sum = 0;

            $.each(discount_values, function (index1, value1) {
                //   alert(index1 + ": " + value1);
                var number1 = parseInt(value1, 10);
                dis_sum += number1;
            });
            var total = $('#total_value').val();
            var grand = parseInt(total, 10) - parseInt(dis_sum, 10);
            $('#grand_total').val(grand);
            $('#total_discount').val(dis_sum);

            // alert(dis_sum);
        });

        $("#pre_surgery_add_medical_analysis").submit(function (e) {

            var dataString = $(this).serialize();
            // alert(dataString); return false;

            $.ajax({
                type: "POST",
                url: "surgery/preSurgeryMedicalAnalysisAdd",
                data: dataString,
                success: function (response) {
                    var data = jQuery.parseJSON(response);
                    if (data.how === 'updated') {
                        $('#table-' + data.inserted).html(" ");
                    }
                    $("#pre_surgery_medical_modal").modal('hide');
                    $('#pre_medical_surgery_show').append(data.option);
                    toastr.success(data.message);
                }
            });
            e.preventDefault();
        });
        $('#editable-table_pre_medical_analysis').on('click', '.delete_button', function () {
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
                var number = parseInt(value, 10);
                sum += number;
            });
            $('#total_value').val(sum);
            var discount_values = $("input[name^='discount_price[]']").map(function (idx1, ele1) {
                return $(ele1).val();
            }).get();
            var dis_sum = 0;

            $.each(discount_values, function (index1, value1) {
                // alert(index + ": " + value);
                var number1 = parseInt(value1, 10);
                dis_sum += number1;
            });



            var grand = parseInt(sum, 10) - parseInt(dis_sum, 10);
            // alert(grand);
            $('#total_discount').val(dis_sum);
            $('#grand_total').val(grand);
        });
        $('#pre_modal').click(function () {
            $('#pre_surgery_add_medical_analysis').trigger("reset");
            $('#package_proccedure').html(" ");
            $('#pre_surgery_medical_analysis').val("");
            $('.proccedure').html(" ");
        })
    });
</script>

<!--Start Surgery-->
<script>
    $(document).ready(function () {
        $('#editable-sample_on_medical').on("click", ".editbutton_on_medical_surgery", function () {
            var iid = $(this).attr('data-id');
            $('#on_surgery_add_medical_analysis').trigger("reset");
            $('.proccedure').html(" ");
            $('#package_proccedure_on').html(" ");
            $('#on_surgery_medical_modal').modal('show');
            $.ajax({
                url: 'surgery/editOnMedicalSurgery?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                // if (response.edited == '1') {
                //     $('#table-' + iid).html(" ");
                // }
                $('#on_surgery_add_medical_analysis').find('[name="id"]').val(response.surgery_pre.id).end()
                $('#on_surgery_add_medical_analysis').find('[name="title"]').val(response.surgery_pre.title).end()
                $('#on_surgery_add_medical_analysis').find('[name="remarks"]').val(response.surgery_pre.remarks).end()
                $('#on_surgery_add_medical_analysis').find('[name="status"]').val(response.surgery_pre.status).trigger('change');
                $('#on_surgery_add_medical_analysis').find('[name="total_value"]').val(response.surgery_pre.total_price).end();
                $('#on_surgery_add_medical_analysis').find('[name="total_discount"]').val(response.surgery_pre.total_discount).end();
                $('#on_surgery_add_medical_analysis').find('[name="grand_total"]').val(response.surgery_pre.grand_total).end();
                $('#package_proccedure_on').append(response.option);
                //toastr.success(response.message.message);
            })
        })
        $('#editable-sample_on_medical').on("click", ".delete_button_medical_on", function () {
            var id = $(this).attr('id');
            var id_separate = id.split("-");
            $.ajax({
                url: 'surgery/deleteOnMedicalSurgery?id=' + id_separate[4],
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                toastr.warning(response.message);
                $('#table-on-' + id_separate[4]).html(" ");
            })
        })

    });
</script>
<script>
    $(document).ready(function () {
        $('#add_on_surgery_medical_analysis').click(function (e) {
            var medical_analysis = $('#medical_analysis_on').val();
            var package = $('#package_on').val();

            if ($('table#editable-table_on_medical_analysis').find('#tr-med-' + medical_analysis).length > 0 && $('table#editable-table_on_medical_analysis').find('#tr-pack-' + package).length > 0) {
                alert('Already in the List');
            } else if (package === 'Select Packages' && medical_analysis === 'Select Medical Analysis') {
                alert('Please Select a package or Medical Analysis');
            } else if ($('table#editable-table_on_medical_analysis').find('#tr-med-' + medical_analysis).length > 0 && $('table#editable-table_on_medical_analysis').find('#tr-pack-' + package).length <= 0) {
                $.ajax({
                    url: 'surgery/getTableTrValueForOnSurgeryMedicalAnalysis?package=' + package,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                }).success(function (response) {
                    $('#package_proccedure_on').after(response.option);
                    var values = $("input[name^='price_on[]']").map(function (idx, ele) {
                        return $(ele).val();
                    }).get();
                    var discount_values = $("input[name^='discount_price_on[]']").map(function (idx1, ele1) {
                        return $(ele1).val();
                    }).get();
                    var dis_sum = 0;

                    $.each(discount_values, function (index1, value1) {
                        // alert(index + ": " + value);
                        var number1 = parseInt(value1, 10);
                        dis_sum += number1;
                    });

                    var sum = 0;
                    $.each(values, function (index, value) {
                        // alert(index + ": " + value);
                        var number = parseInt(value, 10);
                        sum += number;
                    });

                    var grand = parseInt(sum, 10) - parseInt(dis_sum, 10);
                    $('#total_discount_on').val(dis_sum);
                    $('#grand_total_on').val(grand);
                    $('#total_value_on').val(sum);
                })
            } else if ($('table#editable-table_on_medical_analysis').find('#tr-med-' + medical_analysis).length <= 0 && $('table#editable-table_on_medical_analysis').find('#tr-pack-' + package).length > 0) {
                $.ajax({
                    url: 'surgery/getTableTrValueForOnSurgeryMedicalAnalysis?medical_analysis=' + medical_analysis,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                }).success(function (response) {
                    $('#package_proccedure_on').after(response.option);
                    var values = $("input[name^='price_on[]']").map(function (idx, ele) {
                        return $(ele).val();
                    }).get();
                    var discount_values = $("input[name^='discount_price_on[]']").map(function (idx1, ele1) {
                        return $(ele1).val();
                    }).get();
                    var dis_sum = 0;

                    $.each(discount_values, function (index1, value1) {
                        // alert(index + ": " + value);
                        var number1 = parseInt(value1, 10);
                        dis_sum += number1;
                    });

                    var sum = 0;
                    $.each(values, function (index, value) {
                        // alert(index + ": " + value);
                        var number = parseInt(value, 10);
                        sum += number;
                    });

                    var grand = parseInt(sum, 10) - parseInt(dis_sum, 10);
                    $('#total_discount_on').val(dis_sum);
                    $('#grand_total_on').val(grand);
                    $('#total_value_on').val(sum);
                })
            } else {
                if (package === 'Select Packages') {
                    var url = 'surgery/getTableTrValueForOnSurgeryMedicalAnalysis?medical_analysis=' + medical_analysis;
                } else if (medical_analysis === 'Select Medical Analysis') {
                    var url = 'surgery/getTableTrValueForOnSurgeryMedicalAnalysis?package=' + package;
                } else {
                    var url = 'surgery/getTableTrValueForOnSurgeryMedicalAnalysis?medical_analysis=' + medical_analysis + '&package=' + package;
                }
                $.ajax({
                    url: url,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                }).success(function (response) {
                    $('#package_proccedure_on').after(response.option);
                    var values = $("input[name^='price_on[]']").map(function (idx, ele) {
                        return $(ele).val();
                    }).get();
                    var sum = 0;
                    $.each(values, function (index, value) {
                        // alert(index + ": " + value);
                        var number = parseInt(value, 10);
                        sum += number;
                    });
                    $('#total_value_on').val(sum);
                    var discount_values = $("input[name^='discount_price_on[]']").map(function (idx1, ele1) {
                        return $(ele1).val();
                    }).get();
                    var dis_sum = 0;

                    $.each(discount_values, function (index1, value1) {
                        // alert(index + ": " + value);
                        var number1 = parseInt(value1, 10);
                        dis_sum += number1;
                    });



                    var grand = parseInt(sum, 10) - parseInt(dis_sum, 10);
                    // alert(grand);
                    $('#total_discount_on').val(dis_sum);
                    $('#grand_total_on').val(grand);

                })
            }
            e.preventDefault();
        })
    })


    $(document).ready(function () {
        $("#editable-table_on_medical_analysis").on("keyup", ".discount-price-indivudual", function () {

            var discount_values = $("input[name^='discount_price_on[]']").map(function (idx, ele) {
                return $(ele).val();
            }).get();
            var dis_sum = 0;

            $.each(discount_values, function (index1, value1) {
                //   alert(index1 + ": " + value1);
                var number1 = parseInt(value1, 10);
                dis_sum += number1;
            });
            var total = $('#total_value_on').val();
            var grand = parseInt(total, 10) - parseInt(dis_sum, 10);
            $('#grand_total_on').val(grand);
            $('#total_discount_on').val(dis_sum);

            // alert(dis_sum);
        });

        $("#on_surgery_add_medical_analysis").submit(function (e) {

            var dataString = $(this).serialize();
            // alert(dataString); return false;

            $.ajax({
                type: "POST",
                url: "surgery/onSurgeryMedicalAnalysisAdd",
                data: dataString,
                success: function (response) {
                    var data = jQuery.parseJSON(response);
                    if (data.how === 'updated') {
                        $('#table-on-' + data.inserted).html(" ");
                    }
                    $("#on_surgery_medical_modal").modal('hide');
                    $('#on_medical_surgery_show').append(data.option);
                    toastr.success(data.message);
                }
            });
            e.preventDefault();
        });
        $('#editable-table_on_medical_analysis').on('click', '.delete_button', function () {
            //  $('.delete_button').click(function () {
            // alert('sadas');
            var id = $(this).attr('id');
            var id_split = id.split("-");
            // if(id_split[1]=='med'){
            $('#tr-' + id_split[1] + '-' + id_split[2]).remove();
            //}

            var values = $("input[name^='price_on[]']").map(function (idx, ele) {
                return $(ele).val();
            }).get();
            //  alert(values);
            var sum = 0;
            $.each(values, function (index, value) {
                // alert(index + ": " + value);
                var number = parseInt(value, 10);
                sum += number;
            });
            $('#total_value_on').val(sum);
            var discount_values = $("input[name^='discount_price_on[]']").map(function (idx1, ele1) {
                return $(ele1).val();
            }).get();
            var dis_sum = 0;

            $.each(discount_values, function (index1, value1) {
                // alert(index + ": " + value);
                var number1 = parseInt(value1, 10);
                dis_sum += number1;
            });



            var grand = parseInt(sum, 10) - parseInt(dis_sum, 10);
            // alert(grand);
            $('#total_discount_on').val(dis_sum);
            $('#grand_total_on').val(grand);
        });
        $('#on_modal').click(function () {
            $('#on_surgery_add_medical_analysis').trigger("reset");
            $('#package_proccedure_on').html(" ");
            $('#on_surgery_medical_analysis').val(" ");
            $('.proccedure').html(" ");
        })
    });
</script>

<!--ENd Surgery-->
<!--Start Post Surgery -->
<script>
    $(document).ready(function () {
        $('#editable-sample_post_medical').on("click", ".editbutton_post_medical_surgery", function () {
            var iid = $(this).attr('data-id');
            $('#post_surgery_add_medical_analysis').trigger("reset");
            $('.proccedure').html(" ");
            $('#package_proccedure_post').html(" ");
            $('#post_surgery_medical_modal').modal('show');
            $.ajax({
                url: 'surgery/editPostMedicalSurgery?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                // if (response.edited == '1') {
                //     $('#table-' + iid).html(" ");
                // }
                $('#post_surgery_add_medical_analysis').find('[name="id"]').val(response.surgery_post.id).end()
                $('#post_surgery_add_medical_analysis').find('[name="title"]').val(response.surgery_post.title).end()
                $('#post_surgery_add_medical_analysis').find('[name="remarks"]').val(response.surgery_post.remarks).end()
                $('#post_surgery_add_medical_analysis').find('[name="status"]').val(response.surgery_post.status).trigger('change');
                $('#post_surgery_add_medical_analysis').find('[name="total_value"]').val(response.surgery_post.total_price).end();
                $('#post_surgery_add_medical_analysis').find('[name="total_discount"]').val(response.surgery_post.total_discount).end();
                $('#post_surgery_add_medical_analysis').find('[name="grand_total"]').val(response.surgery_post.grand_total).end();
                $('#package_proccedure_post').append(response.option);
                //toastr.success(response.message.message);
            })
        })
        $('#editable-sample_post_medical').on("click", ".delete_button_medical_post", function () {
            var id = $(this).attr('id');
            var id_separate = id.split("-");
            $.ajax({
                url: 'surgery/deletePostMedicalSurgery?id=' + id_separate[4],
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                toastr.warning(response.message);
                $('#table-post-' + id_separate[4]).html(" ");
            })
        })

    });
</script>
<script>
    $(document).ready(function () {
        $('#add_post_surgery_medical_analysis').click(function (e) {
            var medical_analysis = $('#medical_analysis_post').val();
            var package = $('#package_post').val();

            if ($('table#editable-table_post_medical_analysis').find('#tr-med-' + medical_analysis).length > 0 && $('table#editable-table_post_medical_analysis').find('#tr-pack-' + package).length > 0) {
                alert('Already in the List');
            } else if (package === 'Select Packages' && medical_analysis === 'Select Medical Analysis') {
                alert('Please Select a package or Medical Analysis');
            } else if ($('table#editable-table_post_medical_analysis').find('#tr-med-' + medical_analysis).length > 0 && $('table#editable-table_post_medical_analysis').find('#tr-pack-' + package).length <= 0) {
                $.ajax({
                    url: 'surgery/getTableTrValueForPostSurgeryMedicalAnalysis?package=' + package,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                }).success(function (response) {
                    $('#package_proccedure_post').after(response.option);
                    var values = $("input[name^='price_post[]']").map(function (idx, ele) {
                        return $(ele).val();
                    }).get();
                    var discount_values = $("input[name^='discount_price_post[]']").map(function (idx1, ele1) {
                        return $(ele1).val();
                    }).get();
                    var dis_sum = 0;

                    $.each(discount_values, function (index1, value1) {
                        // alert(index + ": " + value);
                        var number1 = parseInt(value1, 10);
                        dis_sum += number1;
                    });

                    var sum = 0;
                    $.each(values, function (index, value) {
                        // alert(index + ": " + value);
                        var number = parseInt(value, 10);
                        sum += number;
                    });

                    var grand = parseInt(sum, 10) - parseInt(dis_sum, 10);
                    $('#total_discount_post').val(dis_sum);
                    $('#grand_total_post').val(grand);
                    $('#total_value_post').val(sum);
                })
            } else if ($('table#editable-table_post_medical_analysis').find('#tr-med-' + medical_analysis).length <= 0 && $('table#editable-table_post_medical_analysis').find('#tr-pack-' + package).length > 0) {
                $.ajax({
                    url: 'surgery/getTableTrValueForPostSurgeryMedicalAnalysis?medical_analysis=' + medical_analysis,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                }).success(function (response) {
                    $('#package_proccedure_post').after(response.option);
                    var values = $("input[name^='price_post[]']").map(function (idx, ele) {
                        return $(ele).val();
                    }).get();
                    var discount_values = $("input[name^='discount_price_post[]']").map(function (idx1, ele1) {
                        return $(ele1).val();
                    }).get();
                    var dis_sum = 0;

                    $.each(discount_values, function (index1, value1) {
                        // alert(index + ": " + value);
                        var number1 = parseInt(value1, 10);
                        dis_sum += number1;
                    });

                    var sum = 0;
                    $.each(values, function (index, value) {
                        // alert(index + ": " + value);
                        var number = parseInt(value, 10);
                        sum += number;
                    });

                    var grand = parseInt(sum, 10) - parseInt(dis_sum, 10);
                    $('#total_discount_post').val(dis_sum);
                    $('#grand_total_post').val(grand);
                    $('#total_value_post').val(sum);
                })
            } else {
                if (package === 'Select Packages') {
                    var url = 'surgery/getTableTrValueForPostSurgeryMedicalAnalysis?medical_analysis=' + medical_analysis;
                } else if (medical_analysis === 'Select Medical Analysis') {
                    var url = 'surgery/getTableTrValueForPostSurgeryMedicalAnalysis?package=' + package;
                } else {
                    var url = 'surgery/getTableTrValueForPostSurgeryMedicalAnalysis?medical_analysis=' + medical_analysis + '&package=' + package;
                }
                $.ajax({
                    url: url,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                }).success(function (response) {
                    $('#package_proccedure_post').after(response.option);
                    var values = $("input[name^='price_post[]']").map(function (idx, ele) {
                        return $(ele).val();
                    }).get();
                    var sum = 0;
                    $.each(values, function (index, value) {
                        // alert(index + ": " + value);
                        var number = parseInt(value, 10);
                        sum += number;
                    });
                    $('#total_value_post').val(sum);
                    var discount_values = $("input[name^='discount_price_post[]']").map(function (idx1, ele1) {
                        return $(ele1).val();
                    }).get();
                    var dis_sum = 0;

                    $.each(discount_values, function (index1, value1) {
                        // alert(index + ": " + value);
                        var number1 = parseInt(value1, 10);
                        dis_sum += number1;
                    });



                    var grand = parseInt(sum, 10) - parseInt(dis_sum, 10);
                    // alert(grand);
                    $('#total_discount_post').val(dis_sum);
                    $('#grand_total_post').val(grand);

                })
            }
            e.preventDefault();
        })
    })


    $(document).ready(function () {
        $("#editable-table_post_medical_analysis").on("keyup", ".discount-price-indivudual", function () {

            var discount_values = $("input[name^='discount_price_post[]']").map(function (idx, ele) {
                return $(ele).val();
            }).get();
            var dis_sum = 0;

            $.each(discount_values, function (index1, value1) {
                //   alert(index1 + ": " + value1);
                var number1 = parseInt(value1, 10);
                dis_sum += number1;
            });
            var total = $('#total_value_post').val();
            var grand = parseInt(total, 10) - parseInt(dis_sum, 10);
            $('#grand_total_post').val(grand);
            $('#total_discount_post').val(dis_sum);

            // alert(dis_sum);
        });

        $("#post_surgery_add_medical_analysis").submit(function (e) {

            var dataString = $(this).serialize();
            // alert(dataString); return false;

            $.ajax({
                type: "POST",
                url: "surgery/postSurgeryMedicalAnalysisAdd",
                data: dataString,
                success: function (response) {
                    var data = jQuery.parseJSON(response);
                    if (data.how === 'updated') {
                        $('#table-post-' + data.inserted).html(" ");
                    }
                    $("#post_surgery_medical_modal").modal('hide');
                    $('#post_medical_surgery_show').append(data.option);
                    toastr.success(data.message);
                }
            });
            e.preventDefault();
        });
        $('#editable-table_post_medical_analysis').on('click', '.delete_button', function () {
            //  $('.delete_button').click(function () {
            // alert('sadas');
            var id = $(this).attr('id');
            var id_split = id.split("-");
            // if(id_split[1]=='med'){
            $('#tr-' + id_split[1] + '-' + id_split[2]).remove();
            //}

            var values = $("input[name^='price_post[]']").map(function (idx, ele) {
                return $(ele).val();
            }).get();
            //  alert(values);
            var sum = 0;
            $.each(values, function (index, value) {
                // alert(index + ": " + value);
                var number = parseInt(value, 10);
                sum += number;
            });
            $('#total_value_post').val(sum);
            var discount_values = $("input[name^='discount_price_post[]']").map(function (idx1, ele1) {
                return $(ele1).val();
            }).get();
            var dis_sum = 0;

            $.each(discount_values, function (index1, value1) {
                // alert(index + ": " + value);
                var number1 = parseInt(value1, 10);
                dis_sum += number1;
            });



            var grand = parseInt(sum, 10) - parseInt(dis_sum, 10);
            // alert(grand);
            $('#total_discount_post').val(dis_sum);
            $('#grand_total_post').val(grand);
        });
        $('#post_modal').click(function () {
            $('#post_surgery_add_medical_analysis').trigger("reset");
            $('#package_proccedure_post').html(" ");
            $('#post_surgery_medical_analysis').val("");
            $('.proccedure').html(" ");
        })
    });
</script>

<!-- end Post Surgery -->
<script>
    $(document).ready(function () {
        $("#generic_name").select2({
            placeholder: '<?php echo lang('medicine_gen_name'); ?>',
            allowClear: true,
            ajax: {
                url: 'medicine/getGenericNameInfo',
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
        });
        $('#medicines_option').change(function () {
            var id = $(this).val();
            $.ajax({
                url: 'medicine/getMedicine?id=' + id,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                $('#editMedicine_pre').find('[name="sales_price"]').val(response.medicine.s_price).end();
                $('#editMedicine_pre').find('[name="quantity"]').val("1").end();
                var total = response.medicine.s_price * 1;
                $('#editMedicine_pre').find('[name="total"]').val(total).end();
            });
        });
        $('#quantity').keyup(function () {
            var quantity = $(this).val();
            var s_price = $('#sales_price').val();
            //  alert(quantity);
            var total = quantity * s_price;
            $('#editMedicine_pre').find('[name="sales_price"]').val(s_price).end();
            $('#editMedicine_pre').find('[name="quantity"]').val(quantity).end();
            // var total = response.medicine.s_price * 1;
            $('#editMedicine_pre').find('[name="total"]').val(total).end();
        });
        $("#editMedicine_pre").submit(function (e) {

            var dataString = $(this).serialize();
            // alert(dataString); return false;

            $.ajax({
                type: "POST",
                url: "surgery/updatePreSurgeryMedicine",
                data: dataString,
                success: function (response) {
                    var data = jQuery.parseJSON(response);
                    toastr.success(data.message.message);
                    var row_data = "";
                    row_data += "<tr class=''id=pre-" + data.info.id + "><td>" + data.info.date + "</td><td>" + data.info.generic_name + "</td><td>" + data.info.medicine_name + "</td><td>" + data.info.s_price + "</td><td>" + data.info.quantity + "</td><td>" + data.info.total + "</td><td class='no-print' id='delete-" + data.info.id + "'> <button type='button' class='btn btn-danger btn-xs btn_width delete_medicine' title='<?php echo lang('delete'); ?>' data-toggle='' data-id=" + data.info.id + "><i class='fa fa-trash'></i></button></td></tr>";
                    $("#medicine_table_pre").after(row_data);
                    $(':input', '#editMedicine_pre')
                            .not(':button, :submit, :reset, :hidden')
                            .val('')
                            .prop('checked', false)
                            .prop('selected', false);
                    // $("#editMedicine").val('').change();

                }
            });
            e.preventDefault();
        });
        $('#editable-table_pre_medicine').on('click', '.delete_medicine', function (e) {
            //$('.delete_medicine').click(function (e) {
            var id = $(this).attr('data-id');
            // alert(id);
            if (confirm("Are you sure you want to delete this Record?")) {
                $.ajax({
                    type: "GET",
                    url: "surgery/deletePreSurgeryMedicine?id=" + id,
                    data: '',
                    success: function (response) {
                        var data = jQuery.parseJSON(response);
                        toastr.warning(data.message.message);
                        $('#pre-' + id).remove();
                    }
                });
            }
            e.preventDefault();
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#save_button_pre').click(function () {
            var id = $('#pre_surgery_medicine_id').val();
            $.ajax({
                type: "GET",
                url: "surgery/createPreSurgeryMedicineInvoice?id=" + id,
                data: '',
                dataType: 'json',
                success: function (response) {
                    //  var data = jQuery.parseJSON(response);
                     toastr.success(response.message.message);
                    var ids = response.ids;
                    if(ids !== '1'){
                    var ids_split = ids.split(",");
                   
<?php if (!$this->ion_auth->in_group(array('admin'))) { ?>
                        $.each(ids_split, function (index, value) {

                            $('#delete-' + value).remove();
                            ;
                        });
<?php } ?>
    }
                }
            })
        })
    })
</script>

<!-- Start surgery med-->
<script>
    $(document).ready(function () {
        $("#generic_name_on").select2({
            placeholder: '<?php echo lang('medicine_gen_name'); ?>',
            allowClear: true,
            ajax: {
                url: 'medicine/getGenericNameInfo',
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
        $('#generic_name_on').change(function () {
            var id = $(this).val();
            $('#medicines_option_on').html(" ");
            $.ajax({
                url: 'medicine/getMedicineByGeneric?id=' + id,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                $('#medicines_option_on').html(response.response);
            });
        });
        $('#medicines_option_on').change(function () {
            var id = $(this).val();
            $.ajax({
                url: 'medicine/getMedicine?id=' + id,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                $('#editMedicine_on').find('[name="sales_price"]').val(response.medicine.s_price).end();
                $('#editMedicine_on').find('[name="quantity"]').val("1").end();
                var total = response.medicine.s_price * 1;
                $('#editMedicine_on').find('[name="total"]').val(total).end();
            });
        });
        $('#quantity_on').keyup(function () {
            var quantity = $(this).val();
            var s_price = $('#sales_price_on').val();
            //  alert(quantity);
            var total = quantity * s_price;
            $('#editMedicine_on').find('[name="sales_price"]').val(s_price).end();
            $('#editMedicine_on').find('[name="quantity"]').val(quantity).end();
            // var total = response.medicine.s_price * 1;
            $('#editMedicine_on').find('[name="total"]').val(total).end();
        });
        $("#editMedicine_on").submit(function (e) {

            var dataString = $(this).serialize();
            // alert(dataString); return false;

            $.ajax({
                type: "POST",
                url: "surgery/updateOnSurgeryMedicine",
                data: dataString,
                success: function (response) {
                    var data = jQuery.parseJSON(response);
                    toastr.success(data.message.message);
                    var row_data = "";
                    row_data += "<tr class=''id=on-" + data.info.id + "><td>" + data.info.date + "</td><td>" + data.info.generic_name + "</td><td>" + data.info.medicine_name + "</td><td>" + data.info.s_price + "</td><td>" + data.info.quantity + "</td><td>" + data.info.total + "</td><td class='no-print' id='delete-on-" + data.info.id + "'> <button type='button' class='btn btn-danger btn-xs btn_width delete_medicine' title='<?php echo lang('delete'); ?>' data-toggle='' data-id=" + data.info.id + "><i class='fa fa-trash'></i></button></td></tr>";
                    $("#medicine_table_on").after(row_data);
                    $(':input', '#editMedicine_on')
                            .not(':button, :submit, :reset, :hidden')
                            .val('')
                            .prop('checked', false)
                            .prop('selected', false);
                    // $("#editMedicine").val('').change();

                }
            });
            e.preventDefault();
        });
        $('#editable-table_on_medicine').on('click', '.delete_medicine', function (e) {
            //$('.delete_medicine').click(function (e) {
            var id = $(this).attr('data-id');
            // alert(id);
            if (confirm("Are you sure you want to delete this Record?")) {
                $.ajax({
                    type: "GET",
                    url: "surgery/deleteOnSurgeryMedicine?id=" + id,
                    data: '',
                    success: function (response) {
                        var data = jQuery.parseJSON(response);
                        toastr.warning(data.message.message);
                        $('#on-' + id).remove();
                    }
                });
            }
            e.preventDefault();
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#save_button_on').click(function () {
            var id = $('#on_surgery_medicine_id').val();
            $.ajax({
                type: "GET",
                url: "surgery/createOnSurgeryMedicineInvoice?id=" + id,
                data: '',
                dataType: 'json',
                success: function (response) {
                    //  var data = jQuery.parseJSON(response);
                    var ids = response.ids;
                    var ids_split = ids.split(",");
                    toastr.success(response.message.message);
<?php if (!$this->ion_auth->in_group(array('admin'))) { ?>
                        $.each(ids_split, function (index, value) {

                            $('#delete-on-' + value).remove();
                            ;
                        });
<?php } ?>
                }
            })
        })
    })
</script>
<!-- End-->

<!-- Start surgery med-->
<script>
    $(document).ready(function () {
        $("#generic_name_post").select2({
            placeholder: '<?php echo lang('medicine_gen_name'); ?>',
            allowClear: true,
            ajax: {
                url: 'medicine/getGenericNameInfo',
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
        $('#generic_name_post').change(function () {
            var id = $(this).val();
            $('#medicines_option_post').html(" ");
            $.ajax({
                url: 'medicine/getMedicineByGeneric?id=' + id,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                $('#medicines_option_post').html(response.response);
            });
        });
        $('#medicines_option_post').change(function () {
            var id = $(this).val();
            $.ajax({
                url: 'medicine/getMedicine?id=' + id,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                $('#editMedicine_post').find('[name="sales_price"]').val(response.medicine.s_price).end();
                $('#editMedicine_post').find('[name="quantity"]').val("1").end();
                var total = response.medicine.s_price * 1;
                $('#editMedicine_post').find('[name="total"]').val(total).end();
            });
        });
        $('#quantity_post').keyup(function () {
            var quantity = $(this).val();
            var s_price = $('#sales_price_post').val();
            //  alert(quantity);
            var total = quantity * s_price;
            $('#editMedicine_post').find('[name="sales_price"]').val(s_price).end();
            $('#editMedicine_post').find('[name="quantity"]').val(quantity).end();
            // var total = response.medicine.s_price * 1;
            $('#editMedicine_post').find('[name="total"]').val(total).end();
        });
        $("#editMedicine_post").submit(function (e) {

            var dataString = $(this).serialize();
            // alert(dataString); return false;

            $.ajax({
                type: "POST",
                url: "surgery/updatePostSurgeryMedicine",
                data: dataString,
                success: function (response) {
                    var data = jQuery.parseJSON(response);
                    toastr.success(data.message.message);
                    var row_data = "";
                    row_data += "<tr class=''id=post-" + data.info.id + "><td>" + data.info.date + "</td><td>" + data.info.generic_name + "</td><td>" + data.info.medicine_name + "</td><td>" + data.info.s_price + "</td><td>" + data.info.quantity + "</td><td>" + data.info.total + "</td><td class='no-print' id='delete-on-" + data.info.id + "'> <button type='button' class='btn btn-danger btn-xs btn_width delete_medicine' title='<?php echo lang('delete'); ?>' data-toggle='' data-id=" + data.info.id + "><i class='fa fa-trash'></i></button></td></tr>";
                    $("#medicine_table_post").after(row_data);
                    $(':input', '#editMedicine_post')
                            .not(':button, :submit, :reset, :hidden')
                            .val('')
                            .prop('checked', false)
                            .prop('selected', false);
                    // $("#editMedicine").val('').change();

                }
            });
            e.preventDefault();
        });
        $('#editable-table_post_medicine').on('click', '.delete_medicine', function (e) {
            //$('.delete_medicine').click(function (e) {
            var id = $(this).attr('data-id');
            // alert(id);
            if (confirm("Are you sure you want to delete this Record?")) {
                $.ajax({
                    type: "GET",
                    url: "surgery/deletePostSurgeryMedicine?id=" + id,
                    data: '',
                    success: function (response) {
                        var data = jQuery.parseJSON(response);
                        toastr.warning(data.message.message);
                        $('#post-' + id).remove();
                    }
                });
            }
            e.preventDefault();
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#save_button_post').click(function () {
            var id = $('#post_surgery_medicine_id').val();
            $.ajax({
                type: "GET",
                url: "surgery/createPostSurgeryMedicineInvoice?id=" + id,
                data: '',
                dataType: 'json',
                success: function (response) {
                    //  var data = jQuery.parseJSON(response);
                     toastr.success(response.message.message);
                     
                    var ids = response.ids;
                    if(ids !== '1'){
                    var ids_split = ids.split(",");
                   
<?php if (!$this->ion_auth->in_group(array('admin'))) { ?>
                        $.each(ids_split, function (index, value) {

                            $('#delete-post-' + value).remove();
                            ;
                        });
<?php } ?>
    }
                }
            })
        })
    })
</script>
<!-- End-->
<script>
    $(document).ready(function () {

        $("#nurse_service").select2({
            placeholder: '<?php echo lang('select_murse'); ?>',
            allowClear: true,
            ajax: {
                url: 'surgery/getNurseInfo',
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
        $('#editable-table_pre_services').on('click', '.delete_service', function (e) {
            //$('.delete_service').click(function (e) {
            var id = $(this).attr('data-id');
            var splited = id.split("**");
            // alert(id);
            if (confirm("Are you sure you want to delete this Record?")) {
                $.ajax({
                    type: "GET",
                    url: "surgery/deletePreSurgeryServices?id=" + id,
                    data: '',
                    success: function (response) {
                        var data = jQuery.parseJSON(response);
                        toastr.warning(data.message.message);
                        $('#pre-' + data.message.date + '-' + splited[1]).remove();
                        $('#total_value_pre_service').val(data.message.total);
                        $('#total_discount_pre_service').val(data.message.discount);
                        $('#grand_total_pre_service').val(data.message.grand);
                        $("#pservice-pre-" + splited[1]).prop("checked", false);
                    }
                });
            }
            e.preventDefault();
        });
        $('.pservice_pre').click(function () {
            var arr = [];
            $('input.pservice_pre:checkbox:checked').each(function () {
                arr.push($(this).val());
            });
            //   var dataString = $(this).serialize();
            var nurse = $('#nurse_service').val();
            var alloted = $('#pre_services_surgery_id').val();
            // alert(alloted);
            // var discount_id=$('.discount-price-pre-services').attr('id');
            // var discount=$('.discount-price-pre-services').val();
            //alert(discount_id);
            $.ajax({
                type: "POST",
                url: "surgery/updateServicesPreSurgery",
                data: {arr: arr, nurse: nurse, alloted: alloted},
                success: function (response) {
                    var data = jQuery.parseJSON(response);
                    toastr.success(data.message.message);
                    $('#paservice_table_pre').html(" ");
                    $('#paservice_table_pre').html(data.option.option);
                    $('#total_value_pre_service').val(data.option.total);
                    $('#total_discount_pre_service').val(data.option.discount);
                    $('#grand_total_pre_service').val(data.option.grand);
                    var option = new Option(response.nurses.name + '-' + response.nurses.id, response.nurses.id, true, true);
                    $('#id="nurses_select"').find('[name="nurse_service"]').append(option).trigger('change');
                }
            })

        });
        $('#editable-table_pre_services').on('keyup', '.discount-price-pre-services', function () {

            var discount_id = $(this).attr('id');
            //alert(discount_id);
            var id_split = discount_id.split("-");
            var price_individual = $('#pre-service-price-' + id_split[3]).val();
            var date = id_split[4] + '-' + id_split[5] + '-' + id_split[6];

            var discount_individual = $('#' + discount_id).val();
            var id = $('.pre-date').attr('id');

            var nurse = $('#nurse_service').val();
            var alloted = $('#pre_services_surgery_id').val();

            $.ajax({
                type: "POST",
                url: "surgery/updateDiscount",
                data: {discount: discount_individual, alloted: alloted, price: price_individual, date: date, service: id_split[3]},
                success: function (response) {
                    $('#discount-pre-' + date + '-' + id_split[3]).html(parseInt(price_individual, 10) - parseInt(discount_individual, 10));
                    var data = jQuery.parseJSON(response);
                    $('#total_value_pre_service').val(data.total);
                    $('#total_discount_pre_service').val(data.discount);
                    $('#grand_total_pre_service').val(data.grand_total);
                }
            });

        });
        $('#save_button_service_pre').click(function () {
            var id = $('#pre_services_surgery_id').val();
            $.ajax({
                type: "GET",
                url: "surgery/createPreServiceInvoice?id=" + id,
                data: '',
                dataType: 'json',
                success: function (response) {
                    //  var data = jQuery.parseJSON(response);
                    toastr.success(response.message.message);
                    if (response.ids !== '1') {
                        var ids = response.ids;
                        var ids_split = ids.split(",");

<?php if (!$this->ion_auth->in_group(array('admin'))) { ?>
                            $.each(ids_split, function (index, value) {

                                $('#delete-service-' + response.date + '-' + value).remove();;
                            });
<?php } ?>
                    }
                }
            })
        })
    });
</script>
<!-- Start On Service -->
<script>
    $(document).ready(function () {

        $("#nurse_service_on").select2({
            placeholder: '<?php echo lang('select_murse'); ?>',
            allowClear: true,
            ajax: {
                url: 'surgery/getNurseInfo',
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
        $('#editable-table_on_services').on('click', '.delete_service', function (e) {
            //$('.delete_service').click(function (e) {
            var id = $(this).attr('data-id');
            var splited = id.split("**");
            // alert(id);
            if (confirm("Are you sure you want to delete this Record?")) {
                $.ajax({
                    type: "GET",
                    url: "surgery/deleteOnSurgeryServices?id=" + id,
                    data: '',
                    success: function (response) {
                        var data = jQuery.parseJSON(response);
                        toastr.warning(data.message.message);
                        $('#on-' + data.message.date + '-' + splited[1]).remove();
                        $('#total_value_on_service').val(data.message.total);
                        $('#total_discount_on_service').val(data.message.discount);
                        $('#grand_total_on_service').val(data.message.grand);
                        $("#pservice-on-" + splited[1]).prop("checked", false);
                    }
                });
            }
            e.preventDefault();
        });
        $('.pservice_on').click(function () {
            var arr = [];
            $('input.pservice_on:checkbox:checked').each(function () {
                arr.push($(this).val());
            });
            //   var dataString = $(this).serialize();
            var nurse = $('#nurse_service_on').val();
            var alloted = $('#on_services_surgery_id').val();
            // alert(alloted);
            // var discount_id=$('.discount-price-pre-services').attr('id');
            // var discount=$('.discount-price-pre-services').val();
            //alert(discount_id);
            $.ajax({
                type: "POST",
                url: "surgery/updateServicesOnSurgery",
                data: {arr: arr, nurse: nurse, alloted: alloted},
                success: function (response) {
                    var data = jQuery.parseJSON(response);
                    toastr.success(data.message.message);
                    $('#paservice_table_on').html(" ");
                    $('#paservice_table_on').html(data.option.option);
                    $('#total_value_on_service').val(data.option.total);
                    $('#total_discount_on_service').val(data.option.discount);
                    $('#grand_total_on_service').val(data.option.grand);
                    var option = new Option(response.nurses.name + '-' + response.nurses.id, response.nurses.id, true, true);
                    $('#id="nurses_select_on"').find('[name="nurse_service"]').append(option).trigger('change');
                }
            })

        });
        $('#editable-table_on_services').on('keyup', '.discount-price-on-services', function () {

            var discount_id = $(this).attr('id');
            //alert(discount_id);
            var id_split = discount_id.split("-");
            var price_individual = $('#on-service-price-' + id_split[3]).val();
            var date = id_split[4] + '-' + id_split[5] + '-' + id_split[6];

            var discount_individual = $('#' + discount_id).val();
            var id = $('.on-date').attr('id');

            var nurse = $('#nurse_service_on').val();
            var alloted = $('#on_services_surgery_id').val();

            $.ajax({
                type: "POST",
                url: "surgery/updateOnDiscount",
                data: {discount: discount_individual, alloted: alloted, price: price_individual, date: date, service: id_split[3]},
                success: function (response) {
                    $('#discount-on-' + date + '-' + id_split[3]).html(parseInt(price_individual, 10) - parseInt(discount_individual, 10));
                    var data = jQuery.parseJSON(response);
                    $('#total_value_on_service').val(data.total);
                    $('#total_discount_on_service').val(data.discount);
                    $('#grand_total_on_service').val(data.grand_total);
                }
            });

        });
        $('#save_button_service_on').click(function () {
            var id = $('#on_services_surgery_id').val();
            $.ajax({
                type: "GET",
                url: "surgery/createOnServiceInvoice?id=" + id,
                data: '',
                dataType: 'json',
                success: function (response) {
                    //  var data = jQuery.parseJSON(response);
                    toastr.success(response.message.message);
                    if (response.ids !== '1') {
                        var ids = response.ids;
                        var ids_split = ids.split(",");

<?php if (!$this->ion_auth->in_group(array('admin'))) { ?>
                            $.each(ids_split, function (index, value) {

                                $('#delete-service-on-' + response.date + '-' + value).remove();;
                            });
<?php } ?>
                    }
                }
            })
        })
    });
</script>
<!-- End Service On-->

<!-- Start Post Service -->
<script>
    $(document).ready(function () {

        $("#nurse_service_post").select2({
            placeholder: '<?php echo lang('select_murse'); ?>',
            allowClear: true,
            ajax: {
                url: 'surgery/getNurseInfo',
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
        $('#editable-table_post_services').on('click', '.delete_service', function (e) {
            //$('.delete_service').click(function (e) {
            var id = $(this).attr('data-id');
            var splited = id.split("**");
            // alert(id);
            if (confirm("Are you sure you want to delete this Record?")) {
                $.ajax({
                    type: "GET",
                    url: "surgery/deletePostSurgeryServices?id=" + id,
                    data: '',
                    success: function (response) {
                        var data = jQuery.parseJSON(response);
                        toastr.warning(data.message.message);
                        $('#post-' + data.message.date + '-' + splited[1]).remove();
                        $('#total_value_post_service').val(data.message.total);
                        $('#total_discount_post_service').val(data.message.discount);
                        $('#grand_total_post_service').val(data.message.grand);
                        $("#pservice-post-" + splited[1]).prop("checked", false);
                    }
                });
            }
            e.preventDefault();
        });
        $('.pservice_post').click(function () {
            var arr = [];
            $('input.pservice_post:checkbox:checked').each(function () {
                arr.push($(this).val());
            });
            //   var dataString = $(this).serialize();
            var nurse = $('#nurse_service_post').val();
            var alloted = $('#post_services_surgery_id').val();

            $.ajax({
                type: "POST",
                url: "surgery/updateServicesPostSurgery",
                data: {arr: arr, nurse: nurse, alloted: alloted},
                success: function (response) {
                    var data = jQuery.parseJSON(response);
                    toastr.success(data.message.message);
                    $('#paservice_table_post').html(" ");
                    $('#paservice_table_post').html(data.option.option);
                    $('#total_value_post_service').val(data.option.total);
                    $('#total_discount_post_service').val(data.option.discount);
                    $('#grand_total_post_service').val(data.option.grand);
                    var option = new Option(response.nurses.name + '-' + response.nurses.id, response.nurses.id, true, true);
                    $('#id="nurses_select_post"').find('[name="nurse_service"]').append(option).trigger('change');
                }
            })

        });
        $('#editable-table_post_services').on('keyup', '.discount-price-post-services', function () {

            var discount_id = $(this).attr('id');
            //alert(discount_id);
            var id_split = discount_id.split("-");
            var price_individual = $('#post-service-price-' + id_split[3]).val();
            var date = id_split[4] + '-' + id_split[5] + '-' + id_split[6];

            var discount_individual = $('#' + discount_id).val();
            var id = $('.post-date').attr('id');

            var nurse = $('#nurse_service_post').val();
            var alloted = $('#post_services_surgery_id').val();

            $.ajax({
                type: "POST",
                url: "surgery/updatePostDiscount",
                data: {discount: discount_individual, alloted: alloted, price: price_individual, date: date, service: id_split[3]},
                success: function (response) {
                    $('#discount-post-' + date + '-' + id_split[3]).html(parseInt(price_individual, 10) - parseInt(discount_individual, 10));
                    var data = jQuery.parseJSON(response);
                    $('#total_value_post_service').val(data.total);
                    $('#total_discount_post_service').val(data.discount);
                    $('#grand_total_post_service').val(data.grand_total);
                }
            });

        });
        $('#save_button_service_post').click(function () {
            var id = $('#post_services_surgery_id').val();
            $.ajax({
                type: "GET",
                url: "surgery/createPostServiceInvoice?id=" + id,
                data: '',
                dataType: 'json',
                success: function (response) {
                    //  var data = jQuery.parseJSON(response);

                    toastr.success(response.message.message);
                    if (response.ids !== '1') {
                        var ids = response.ids;
                        var ids_split = ids.split(",");
<?php if (!$this->ion_auth->in_group(array('admin'))) { ?>
                            $.each(ids_split, function (index, value) {

                                $('#delete-service-post-' + response.date + '-' + value).remove();
                                ;
                            });
<?php } ?>
                    }
                }
            })
        })
    });
</script>
<!-- End Service Post-->
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
        $("#patientchoose").select2({
            placeholder: '<?php echo lang('select_patient'); ?>',
            allowClear: true,
            ajax: {
                url: 'patient/getPatientinfo',
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

        $("#editSurgeryCheckin").submit(function (e) {

            var dataString = $(this).serialize();
            // alert(dataString); return false;

            $.ajax({
                type: "POST",
                url: "surgery/updateCheckin",
                data: dataString,
                success: function (response) {
                    var data = jQuery.parseJSON(response);
                    $('#editSurgeryCheckin').find('[name="id"]').val(data.inserted).end()
                    toastr.success(data.message);
                }
            });
            e.preventDefault();
        });
        $("#doctors_checkout").select2({
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
        $("#editCheckout").submit(function (e) {

            var dataString = $(this).serialize();
            // alert(dataString); return false;

            $.ajax({
                type: "POST",
                url: "surgery/updateCheckout",
                data: dataString,
                success: function (response) {
                    var data = jQuery.parseJSON(response);
                    toastr.success(data.message.message);
                    $('#editCheckout').find('[name="id"]').val(data.checkout.id).end()
<?php if (!$this->ion_auth->in_group(array('admin'))) { ?>
                        $('input').prop('readonly', true);
                        $('textarea').prop('readonly', true);
                        $('#checkout_submit').remove();
<?php } ?>
                    // $('#editBedAllotment')[0].reset();
                }
            });
            e.preventDefault();
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('body').on('focus', ".default-date-picker", function () {
            $(this).datepicker();
        });
    });
    $("ul.nav-tabs a").click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
</script>