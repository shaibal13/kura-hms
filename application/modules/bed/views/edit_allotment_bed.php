

<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->

        <section class="col-md-9">
            <header class="panel-heading clearfix">
                <div class="col-md-9">
                    <?php echo lang('bed_allotment'); ?> | <?php echo $patient->name; ?>
                </div>

            </header>

            <section class="panel-body">   
                <header class="panel-heading tab-bg-dark-navy-blueee">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#checkin"><?php echo lang('check_in'); ?></a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#daily_progress"><?php echo lang('daily_progress'); ?></a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#medicines"><?php echo lang('medicines'); ?></a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#services"><?php echo lang('service'); ?></a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#checkout"><?php echo lang('checkout'); ?></a>
                        </li>

                    </ul>
                </header>
                <div class="panel">
                    <div class="tab-content">
                        <div id="checkin" class="tab-pane active">
                            <div class="">
                                <form role="form" action="" id="editBedAllotment"class="clearfix" method="post" enctype="multipart/form-data">
                                    <div class="form-group col-md-12">

                                        <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('covid_19'); ?>:</label>

                                        <span></span>


                                        <input type="radio" name="covid_19" value="po"<?php
                                        if ($allotment->covid_19 == 'po') {
                                            echo 'checked';
                                            //  echo 'disabled';
                                        }
                                        ?>>
                                        <label style="margin-right: 56px;"><?php echo lang('po'); ?></label>
                                        <input type="radio" name="covid_19" value="jo"<?php
                                        if ($allotment->covid_19 == 'jo') {
                                            echo 'checked';
                                            // echo 'disabled';
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
                                                ?> > <?php echo $room->category; ?> </option>
                                                    <?php } ?> 
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="exampleInputEmail1"><?php echo lang('bed_id'); ?></label>
                                        <select class="form-control m-bot15" id="bed_id" name="bed_id" value=''> 
                                            <option value="select"><?php echo lang('select'); ?></option>
                                            <?php
                                            if (!empty($allotment->id)) {
                                                echo $option;
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="exampleInputEmail1"><?php echo lang('patient'); ?></label>
                                        <select class="form-control m-bot15" id="patientchoose" name="patient" value=''> 

                                        </select>
                                    </div>


                                    <div class="form-group col-md-12">

                                        <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('category'); ?>:</label>

                                        <span></span>
                                        <?php $category_status = explode(',', $allotment->category_status);
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
                                        <textarea name="reaksione" class='form-control'<?php
                                        if (!empty($allotment->d_time) && !$this->ion_auth->in_group(array('admin'))) {
                                            echo 'readonly';
                                        }
                                        ?>><?php
                                                      if (!empty($allotment->reaksione)) {
                                                          echo $allotment->reaksione;
                                                      }
                                                      ?> </textarea>

                                    </div>
                                    <div class="form-group col-md-12">

                                        <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('transferred_from'); ?>:</label>
                                        <textarea name="transferred_from" class='form-control'<?php
                                        if (!empty($allotment->d_time) && !$this->ion_auth->in_group(array('admin'))) {
                                            echo 'readonly';
                                        }
                                        ?>> <?php
                                                      if (!empty($allotment->transferred_from)) {
                                                          echo $allotment->transferred_from;
                                                      }
                                                      ?></textarea>

                                    </div>
                                    <div class="form-group col-md-12">

                                        <label for="exampleInputEmail1"><?php echo lang('diagnoza_a_shtrimit'); ?>:</label>
                                        <textarea name="diagnoza_a_shtrimit" class='form-control'<?php
                                        if (!empty($allotment->d_time) && !$this->ion_auth->in_group(array('admin'))) {
                                            echo 'readonly';
                                        }
                                        ?>><?php
                                                      if (!empty($allotment->diagnoza_a_shtrimit)) {
                                                          echo $allotment->diagnoza_a_shtrimit;
                                                      }
                                                      ?> </textarea>

                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="exampleInputEmail1"><?php echo lang('doctor'); ?></label>
                                        <select class="form-control m-bot15" id="doctors" name="doctor" value=''> 

                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">

                                        <label for="exampleInputEmail1"><?php echo lang('diagnosis'); ?>:</label>
                                        <textarea name="diagnosis" class='form-control'<?php
                                        if (!empty($allotment->d_time) && !$this->ion_auth->in_group(array('admin'))) {
                                            echo 'readonly';
                                        }
                                        ?>><?php
                                                      if (!empty($allotment->diagnosis)) {
                                                          echo $allotment->diagnosis;
                                                      }
                                                      ?> </textarea>

                                    </div>
                                    <div class="form-group col-md-12">

                                        <label for="exampleInputEmail1"><?php echo lang('other_illnesses'); ?>:</label>
                                        <textarea name="other_illnesses" class='form-control'<?php
                                        if (!empty($allotment->d_time) && !$this->ion_auth->in_group(array('admin'))) {
                                            echo 'readonly';
                                        }
                                        ?>><?php
                                                      if (!empty($allotment->other_illnesses)) {
                                                          echo $allotment->other_illnesses;
                                                      }
                                                      ?>  </textarea>

                                    </div>
                                    <div class="form-group col-md-12">

                                        <label for="exampleInputEmail1"><?php echo lang('anamneza'); ?>:</label>
                                        <textarea name="anamneza" class='form-control'<?php
                                        if (!empty($allotment->d_time) && !$this->ion_auth->in_group(array('admin'))) {
                                            echo 'readonly';
                                        }
                                        ?>><?php
                                                      if (!empty($allotment->anamneza)) {
                                                          echo $allotment->anamneza;
                                                      }
                                                      ?> </textarea>

                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="exampleInputEmail1"><?php echo lang('blood_group'); ?></label>
                                        <select class="form-control m-bot15" id="blood_group" name="blood_group" value=''> 
                                            <?php foreach ($blood_group as $blood_group) {
                                                ?>

                                                <option value="<?php echo $blood_group->id; ?>" <?php
                                                if ($blood_group->id == $allotment->blood_group) {
                                                    echo 'selected';
                                                }
                                                ?>><?php echo $blood_group->group; ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="exampleInputEmail1"><?php echo lang('accepting_doctor'); ?></label>
                                        <select class="form-control m-bot15" id="accepting_doctors" name="accepting_doctor" value=''> 

                                        </select>
                                    </div> 
                                    <input type="hidden" name="id" value='<?php
                                    if (!empty($allotment->id)) {
                                        echo $allotment->id;
                                    }
                                    ?>'>

                                    <div class="form-group col-md-12">
                                        <div class="col-md-6">

                                        </div>
                                        <?php if (empty($allotment->d_time) || $this->ion_auth->in_group(array('admin'))) { ?> 
                                            <div class="col-md-6">
                                                <button style="background: #7a2828;" type="submit" name="submit" class="btn btn-info pull-right" onclick="history.back()"><?php echo lang('exit'); ?></button>
                                                <button style="margin-right: 7px;" type="submit" name="submit2" class="btn btn-info pull-right" ><?php echo lang('submit'); ?></button>

                                            </div>
                                        <?php } ?> 
                                    </div>

                                </form>
                            </div>
                        </div>
                        <div id="daily_progress" class="tab-pane">
                            <div class="">



                                <div class="adv-table editable-table ">


                                    <table class="table table-striped table-hover table-bordered" id="edittable_table">
                                        <thead>
                                            <tr>

                                                <th><?php echo lang('date'); ?></th>
                                                <th><?php echo lang('time'); ?></th>
                                                <th><?php echo lang('description'); ?></th>
                                                <th><?php echo lang('nurse'); ?></th>

                                                <th class="no-print"><?php echo lang('view_more'); ?></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            foreach ($daily_progress as $daily) {
                                                ?>
                                                <tr id="<?php echo $daily->id; ?>">


                                                    <td data-target="date"><?php echo $daily->date; ?></td>
                                                    <td data-target="time"><?php echo $daily->time; ?></td>
                                                    <td data-target="description"><?php echo $daily->description; ?></td>
                                                    <td data-target="nurse"><?php echo $this->db->get_where('nurse', array('id' => $daily->nurse))->row()->name; ?></td>

                                                    <td class="no-print">
                                                        <button type="button" class="btn btn-info btn-xs btn_width editbutton_dailyprogress" title="<?php echo lang('more'); ?>" data-toggle="" data-id="<?php echo $daily->id; ?>"><i class="fa fa-edit"></i><?php echo lang('more'); ?> </button>   

                                                    </td>

                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>

                                </div>

                                <div>
                                    <form role="form" action="" id="editDailyProgress"class="clearfix" method="post" enctype="multipart/form-data">
                                        <div class="form-group col-md-12">
                                            <label for="exampleInputEmail1"><?php echo lang('nurse'); ?></label>
                                            <select class="form-control m-bot15" id="nurses" name="nurse" value='' required=""> 

                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
                                            <input type="text" class="form-control default-date-picker" id="date1" readonly="" name="date" id="exampleInputEmail1" value='' placeholder="" required="">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="exampleInputEmail1"> <?php echo lang('time'); ?></label>

                                            <input type="text" id="date2" class="form-control timepicker-default rounded" readonly="" name="time" id="exampleInputEmail1" value='' placeholder="" required="">
                                        </div>
                                        <div class="form-group col-md-12">

                                            <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('daily_description'); ?>:</label>
                                            <textarea name="daily_description" class='form-control'<?php
                                            if (!empty($allotment->d_time) && !$this->ion_auth->in_group(array('admin'))) {
                                                echo 'readonly';
                                            }
                                            ?>> </textarea>

                                        </div>
                                        <div class="form-group col-md-12">

                                            <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('description'); ?>:</label>
                                            <textarea name="description" class='form-control'<?php
                                            if (!empty($allotment->d_time) && !$this->ion_auth->in_group(array('admin'))) {
                                                echo 'readonly';
                                            }
                                            ?>> </textarea>

                                        </div>
                                        <input type="hidden" name="alloted_bed_id" value="<?php echo $allotment->id; ?>">
                                        <div id="daily_id"> <input type="hidden" name="daily_progress_id" value=""></div>
                                        <?php if (empty($allotment->d_time) || $this->ion_auth->in_group(array('admin'))) { ?> 
                                            <div class="form-group col-md-12">
                                                <button style="margin-right: 7px;" type="submit" name="submit" class="btn btn-info pull-right" ><?php echo lang('save'); ?></button>
                                            </div>
                                        <?php } ?>
                                    </form>
                                </div>

                            </div>
                        </div>

                        <div id="medicines" class="tab-pane"> 
                            <div class="">
                                <div class="col-md-12 pull-right">

                                    <button style="display: block;" id="save_button" type="submit" name="submit" class="btn btn-xs btn-info pull-right" ><i class="fa fa-save"></i> <?php echo lang('save'); ?></button>

                                </div>
                                <br>
                                <div class="adv-table editable-table ">
                                    <table style="width: 100% !important;" class="table table-striped table-hover table-bordered" id="editable-table1" >
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
                                                    <?php if ((empty($allotment->d_time)  && empty($medicine->payment_id))|| $this->ion_auth->in_group(array('admin'))) { ?>
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
                                        <form role="form" action="" id="editMedicine"class="clearfix" method="post" enctype="multipart/form-data">                             
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
                                                <input type="hidden" id="alloted" name="alloted_bed_id" value="<?php
                                                if (!empty($allotment->id)) {
                                                    echo $allotment->id;
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
                        <div id="services" class="tab-pane" > 
                            <div class="">
                                <div class="col-md-12 pull-right">

                                    <button style="display: block;" id="save_button_service" type="submit" name="submit" class="btn btn-xs btn-info pull-right" ><i class="fa fa-save"></i> <?php echo lang('save'); ?></button>

                                </div> 
                                <div class="adv-table editable-table ">
                                    <table style="width: 100% !important;" class="table table-striped table-hover table-bordered" id="editable-table2">
                                        <thead>
                                            <tr>
                                                <th style="width: 20%;"><?php echo lang('service'); ?></th>
                                                <th style="width: 20%;"><?php echo lang('date'); ?></th>
                                                <th style="width: 20%;"><?php echo lang('nurse'); ?></th>
                                                <th style="width: 10%;"><?php echo lang('price'); ?></th>
                                                <th style="width: 10%;"><?php echo lang('quantity'); ?></th>
                                                <th style="width: 10%;"><?php echo lang('total'); ?></th>
                                                <?php if (empty($allotment->d_time) || $this->ion_auth->in_group(array('admin'))) { ?>
                                                    <th style="width: 10%;" class="no-print"><?php echo lang('options'); ?></th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody id="paservice_table">
                                            <?php
                                            if (!empty($daily_service)) {
                                                foreach ($daily_service as $service) {
                                                    $price = explode("**", $service->price);

                                                    $service_update = explode("**", $service->service);
                                                    //  print_r($price);
                                                    // die();
                                                    
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
                                                            <tr id="<?php echo $service->date; ?>-<?php echo $service_update[$i]; ?>">
                                                                <td><?php echo $servicename->name; ?></td>
                                                                <td><?php echo $service->date; ?></td>
                                                                <td><?php echo $nursename; ?></td>
                                                                <td><?php echo $settings->currency; ?><?php echo $price[$i]; ?></td>
                                                                <td><?php echo "1" ?></td>
                                                                <td><?php echo $settings->currency; ?><?php echo $price[$i] * 1; ?></td>
                                                                <?php if (empty($allotment->d_time) || $this->ion_auth->in_group(array('admin'))) { ?>


                                                                <td class="no-print" id="delete-service-<?php echo date('d').'-'.$servicename->id;?>"><button type='button' class='btn btn-danger btn-xs btn_width delete_service' title='<?php echo lang('delete'); ?>' data-toggle='' data-id="<?php echo $service->id . "**" . $service_update[$i]; ?>"><i class='fa fa-trash'></i></button></td>
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
                                <?php if (empty($allotment->d_time) || $this->ion_auth->in_group(array('admin'))) { ?>
                                    <div>
                                        <label>--------------------------------------------------------------------------------------- <?php echo "Services" ?> -----------------------------------------------------------------------</label>
                                        <form role="form" action="" id="editService"class="clearfix" method="post" enctype="multipart/form-data">                             
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
                                                            <input type="checkbox" class="pservice" id="pservice-<?php echo $patient_service->id; ?>" name="pservice[]" value="<?php echo $patient_service->id; ?>" <?php
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

                                                <input type="hidden" id="alloted_service" name="alloted_bed_id" value="<?php
                                                if (!empty($allotment->id)) {
                                                    echo $allotment->id;
                                                }
                                                ?>">

                                                </form>
                                            </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>



                        <div id="checkout" class="tab-pane"> <div class="">

                                <div class="adv-table editable-table ">
                                    <div class="">
                                        <form role="form" action="" id="editCheckout"class="clearfix" method="post" enctype="multipart/form-data">                             
                                            <div class="form-group col-md-12">
                                                <label for="exampleInputEmail1"><?php echo lang('checkout'); ?> <?php echo lang('date'); ?> <?php echo lang('time'); ?></label>
                                                <div data-date="" class="input-group date form_datetime-meridian">
                                                    <div class="input-group-btn"> 
                                                        <button type="button" class="btn btn-info date-set"><i class="fa fa-calendar"></i></button>
                                                        <button type="button" class="btn btn-danger date-reset"><i class="fa fa-times"></i></button>
                                                    </div>
                                                    <input type="text" class="form-control" readonly="" name="d_time" id="exampleInputEmail1" value='<?php
                                                    if (!empty($bed_checkout->date)) {
                                                        echo $bed_checkout->date;
                                                    }
                                                    ?>' placeholder="" required=""<?php
                                                           if (!empty($allotment->d_time) && !$this->ion_auth->in_group(array('admin'))) {
                                                               echo 'readonly';
                                                           }
                                                           ?>>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">

                                                <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('final_diagnosis'); ?>:</label>
                                                <textarea name="final_diagnosis" class='form-control'<?php
                                                if (!empty($allotment->d_time) && !$this->ion_auth->in_group(array('admin'))) {
                                                    echo 'readonly';
                                                }
                                                ?>><?php
                                                              if (!empty($bed_checkout->final_diagnosis)) {
                                                                  echo $bed_checkout->final_diagnosis;
                                                              }
                                                              ?> </textarea>

                                            </div>
                                            <div class="form-group col-md-12">

                                                <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('anatomopatologic_diagnosis'); ?>:</label>
                                                <textarea name="anatomopatologic_diagnosis" class='form-control'<?php
                                                if (!empty($allotment->d_time) && !$this->ion_auth->in_group(array('admin'))) {
                                                    echo 'readonly';
                                                }
                                                ?>><?php
                                                              if (!empty($bed_checkout->anatomopatologic_diagnosis)) {
                                                                  echo $bed_checkout->anatomopatologic_diagnosis;
                                                              }
                                                              ?> </textarea>

                                            </div>
                                            <div class="form-group col-md-12">

                                                <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('dikordance'); ?>:</label>
                                                <textarea name="dikordance" class='form-control'<?php
                                                if (!empty($allotment->d_time) && !$this->ion_auth->in_group(array('admin'))) {
                                                    echo 'readonly';
                                                }
                                                ?>><?php
                                                              if (!empty($bed_checkout->dikordance)) {
                                                                  echo $bed_checkout->dikordance;
                                                              }
                                                              ?> </textarea>

                                            </div>
                                            <div class="form-group col-md-12">

                                                <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('checkout_diagnosis'); ?>:</label>
                                                <textarea name="checkout_diagnosis" class='form-control'<?php
                                                if (!empty($allotment->d_time) && !$this->ion_auth->in_group(array('admin'))) {
                                                    echo 'readonly';
                                                }
                                                ?>><?php
                                                              if (!empty($bed_checkout->checkout_diagnosis)) {
                                                                  echo $bed_checkout->checkout_diagnosis;
                                                              }
                                                              ?> </textarea>

                                            </div>
                                            <div class="form-group col-md-12">

                                                <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('checkout_state'); ?>:</label>
                                                <textarea name="checkout_state" class='form-control'<?php
                                                if (!empty($allotment->d_time) && !$this->ion_auth->in_group(array('admin'))) {
                                                    echo 'readonly';
                                                }
                                                ?>><?php
                                                              if (!empty($bed_checkout->checkout_state)) {
                                                                  echo $bed_checkout->checkout_state;
                                                              }
                                                              ?> </textarea>

                                            </div>
                                            <div class="form-group col-md-12">

                                                <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('epicrisis'); ?>:</label>
                                                <textarea name="epicrisis" class='form-control' <?php
                                                if (!empty($allotment->d_time) && !$this->ion_auth->in_group(array('admin'))) {
                                                    echo 'readonly';
                                                }
                                                ?>><?php
                                                              if (!empty($bed_checkout->epicrisis)) {
                                                                  echo $bed_checkout->epicrisis;
                                                              }
                                                              ?> </textarea>

                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="exampleInputEmail1"><?php echo lang('doctor'); ?></label>
                                                <select class="form-control m-bot15" id="doctors_checkout" name="doctors_checkout" value=''> 
                                                    <?php $doctor1 = $this->db->get_where('doctor', array('id' => $bed_checkout->doctor))->row();
                                                    ?>
                                                    <option value="<?php echo $bed_checkout->doctor; ?>"  <?php
                                                    if (!empty($allotment->d_time) && !$this->ion_auth->in_group(array('admin'))) {
                                                        echo 'selected';
                                                        echo 'disabled';
                                                    }
                                                    ?>><?php echo $doctor1->name . '(Id:' . $doctor1->id . ')'; ?></option>
                                                </select>
                                            </div>
                                            <input type="hidden" name="id" value="<?php
                                            if (!empty($bed_checkout->id)) {
                                                echo $bed_checkout->id;
                                            }
                                            ?>">
                                            <input type="hidden" name="alloted_bed_id" value="<?php
                                            if (!empty($allotment->id)) {
                                                echo $allotment->id;
                                            }
                                            ?>">
                                                   <?php if (empty($allotment->d_time) || $this->ion_auth->in_group(array('admin'))) { ?>
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
                                                    $('#edittable_table').on('click', '.editbutton_dailyprogress', function (e) {
                                                        // $('.').click(function () {
                                                        var id = $(this).attr('data-id');
                                                        $('#editDailyProgress').trigger("reset");
                                                        $.ajax({
                                                            url: "bed/getDailyProgress?id=" + id,
                                                            method: 'GET',
                                                            data: '',
                                                            dataType: 'json',
                                                        }).success(function (response) {
                                                            // Populate the form fields with the data returned from server
                                                            $('#editDailyProgress').find('[name="daily_progress_id"]').val(response.info.id).end()
                                                            $('#editDailyProgress').find('[name="alloted_bed_id"]').val(response.info.alloted_bed_id).end()
                                                            $('#editDailyProgress').find('[name="date"]').val(response.info.date).end()
                                                            $('#editDailyProgress').find('[name="time"]').val(response.info.time).end()
                                                            //  $('#editBedForm').find('[name="number"]').val(response.bed.number).end()
                                                            $('#editDailyProgress').find('[name="description"]').val(response.info.description).end()
                                                            $('#editDailyProgress').find('[name="daily_description"]').val(response.info.daily_description).end()
                                                            var option = new Option(response.nurse.name + '-' + response.nurse.id, response.nurse.id, true, true);
                                                            $('#editDailyProgress').find('[name="nurse"]').append(option).trigger('change');
                                                        });
                                                        e.preventDefault();
                                                    })

                                                    $("#editBedAllotment").submit(function (e) {

                                                        var dataString = $(this).serialize();
                                                        // alert(dataString); return false;

                                                        $.ajax({
                                                            type: "POST",
                                                            url: "bed/updateCheckin",
                                                            data: dataString,
                                                            success: function (response) {
                                                                var data = jQuery.parseJSON(response);
                                                                toastr.success(data.message);
                                                            }
                                                        });
                                                        e.preventDefault();
                                                    });
                                                    $("#editCheckout").submit(function (e) {

                                                        var dataString = $(this).serialize();
                                                        // alert(dataString); return false;

                                                        $.ajax({
                                                            type: "POST",
                                                            url: "bed/updateCheckout",
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
                                                    $("#editDailyProgress").submit(function (e) {

                                                        var dataString = $(this).serialize();
                                                        // alert(dataString); return false;

                                                        $.ajax({
                                                            type: "POST",
                                                            url: "bed/updateDailyProgress",
                                                            data: dataString,
                                                            success: function (response) {
                                                                var data = jQuery.parseJSON(response);
                                                                toastr.success(data.message.message);
                                                                if (data.added.redir === 'added') {
                                                                    var row_data = "";
                                                                    row_data += "<tr class=''><td>" + data.info.date + "</td><td>" + data.info.time + "</td><td>" + data.info.description + "</td><td>" + data.nurse.name + "</td><td class='no-print'> <button type='button' class='btn btn-info btn-xs btn_width editbutton_dailyprogress' title='<?php echo lang('more'); ?>' data-toggle='' data-id=" + data.info.id + "><i class='fa fa-edit'></i><?php echo lang('more'); ?></button></td></tr>";
                                                                    $("#edittable_table").append(row_data);
                                                                } else {
                                                                    var id = $('#editDailyProgress').find('[name="daily_progress_id"]').val();
                                                                    //  alert(data.info.id);
                                                                    $('#' + id).children('td[data-target=date]').text(data.info.date)
                                                                    $('#' + id).children('td[data-target=time]').text(data.info.time)
                                                                    $('#' + id).children('td[data-target=description]').text(data.info.description)
                                                                    $('#' + id).children('td[data-target=nurse]').text(data.nurse.name)
                                                                }
                                                                // $('#editBedAllotment')[0].reset();
                                                                $(':input', '#editDailyProgress')
                                                                        .not(':button, :submit, :reset, :hidden')
                                                                        .val('')
                                                                        .prop('checked', false)
                                                                        .prop('selected', false);
                                                                $('#daily_id').html("");
                                                                $('#daily_id').html("<input type='hidden' name='daily_progress_id' value=''>");
                                                                // $('#editDailyProgress').find('[name="daily_progress_id"]').val()
                                                            }
                                                        });
                                                        e.preventDefault();
                                                    });
                                                    //});


                                                    var option = new Option('<?php echo $patient->name; ?>' + '(Id:' + '<?php echo $patient->id; ?>' + ')', '<?php echo $patient->id; ?>', true, true);
                                                    $('#editBedAllotment').find('[name="patient"]').append(option).trigger('change');
                                                    var option1 = new Option('<?php echo $doctor->name; ?>' + '(Id:' + '<?php echo $doctor->id; ?>' + ')', '<?php echo $doctor->id; ?>', true, true);
                                                    $('#editBedAllotment').find('[name="doctor"]').append(option1).trigger('change');
                                                    var option2 = new Option('<?php echo $accepting_doctor->name; ?>' + '(Id:' + '<?php echo $accepting_doctor->id; ?>' + ')', '<?php echo $accepting_doctor->id; ?>', true, true);
                                                    $('#editBedAllotment').find('[name="accepting_doctor"]').append(option2).trigger('change');
                                                    
    <?php if ($allotment->category == 'Emergency' || $allotment->category == 'emergency') { 
        
        $url_link='medicine/getGenericNameInfoByEmergency';
    }else{
         $url_link='medicine/getGenericNameInfoByAll';
    }
?>
    $("#generic_name").select2({
                                                        placeholder: '<?php echo lang('medicine_gen_name'); ?>',
                                                        allowClear: true,
                                                        ajax: {
                                                            url: '<?php echo $url_link; ?>',
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
                                                    $("#nurses").select2({
                                                        placeholder: '<?php echo lang('select_murse'); ?>',
                                                        allowClear: true,
                                                        ajax: {
                                                            url: 'bed/getNurseInfo',
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
                                                    $("#nurse_service").select2({
                                                        placeholder: '<?php echo lang('select_murse'); ?>',
                                                        allowClear: true,
                                                        ajax: {
                                                            url: 'bed/getNurseInfo',
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
                                                    $('#medicines_option').change(function () {
                                                        var id = $(this).val();
                                                        $.ajax({
                                                            url: 'medicine/getInternalMedicine?id=' + id,
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
                                                    $('#editable-table2').on('click', '.delete_service', function (e) {
                                                        //$('.delete_service').click(function (e) {
                                                        var id = $(this).attr('data-id');
                                                        var splited = id.split("**");
                                                        // alert(id);
                                                        if (confirm("Are you sure you want to delete this Record?")) {
                                                            $.ajax({
                                                                type: "GET",
                                                                url: "bed/deleteServices?id=" + id,
                                                                data: '',
                                                                success: function (response) {
                                                                    var data = jQuery.parseJSON(response);
                                                                    toastr.warning(data.message.message);
                                                                    $('#' + data.message.date + '-' + splited[1]).remove();
                                                                    $("#pservice-" + splited[1]).prop("checked", false);
                                                                }
                                                            });
                                                        }
                                                        e.preventDefault();
                                                    });
                                                });</script>

<script>


    $(document).ready(function () {
        /*  $('#editable-table1').DataTable({
         responsive: true,
         //   dom: 'lfrBtip',
         "bAutoWidth": true,
         "processing": false,
         "serverSide": false,
         "searchable": false,
         scroller: {
         loadingIndicator: true
         },
         dom: "<'row'<'col-md-3'l><'col-sm-5 text-center'><'col-sm-4'>>" +
         "<'row'<'col-md-12'tr>>" +
         "<'row'<'col-sm-5'><'col-sm-7'p>>",
         buttons: [
         {extend: 'copyHtml5', exportOptions: {columns: [0, 1, 2,3,4,5,6], }},
         {extend: 'excelHtml5', exportOptions: {columns: [0, 1, 2,3,4,5,6], }},
         {extend: 'csvHtml5', exportOptions: {columns: [0, 1, 2,3,4,5,6], }},
         {extend: 'pdfHtml5', exportOptions: {columns: [0, 1, 2,3,4,5,6], }},
         {extend: 'print', exportOptions: {columns: [0, 1, 2,3,4,5,6], }},
         ],
         "columns": [
         {"width": "20%"},
         {"width": "20%"},
         {"width": "20%"},
         {"width": "20%"},
         {"width": "20%"},
         {"width": "20%"},
         {"width": "20%"},
         ],
         aLengthMenu: [
         [10, -1],
         [10, "All"]
         ],
         iDisplayLength: 10,
         "order": [[0, "desc"]],
         "language": {
         "lengthMenu": "_MENU_",
         search: "_INPUT_",
         "url": "common/assets/DataTables/languages/<?php //echo $this->language;       ?>.json"
         }
         });*/
        $('#editable-table2').DataTable({
            responsive: true,
            //   dom: 'lfrBtip',
            "bAutoWidth": true,
            "processing": true,
            "serverSide": false,
            "searchable": false,
            autoWidth: false,
            scroller: {
                loadingIndicator: true
            },
            dom: "<'row'<'col-md-3'l><'col-sm-5 text-center'><'col-sm-4'>>" +
                    "<'row'<'col-lg-12'tr>>" +
                    "<'row'<'col-sm-5'><'col-sm-7'p>>",

            "columns": [
                {"width": "20%"},
                {"width": "20%"},
                {"width": "20%"},
                {"width": "10%"},
                {"width": "10%"},
                {"width": "10%"},
                null
            ],
            aLengthMenu: [
                [10, -1],
                [10, "All"]
            ],
            iDisplayLength: 10,
            "order": [[0, "desc"]],
            "language":
                    {
                        "lengthMenu": "_MENU_",
                        search: "_INPUT_",
                        "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json"
                    }
        });
        $('.pservice').click(function () {
            var arr = [];
            $('input.pservice:checkbox:checked').each(function () {
                arr.push($(this).val());
            });
            //   var dataString = $(this).serialize();
            var nurse = $('#nurse_service').val();
            var alloted = $('#alloted').val();
            $.ajax({
                type: "POST",
                url: "bed/updateServices",
                data: {arr: arr, nurse: nurse, alloted: alloted},
                success: function (response) {
                    var data = jQuery.parseJSON(response);
                    toastr.success(data.message.message);
                    $('#paservice_table').html(" ");
                    $('#paservice_table').html(data.option.option)
                    var option = new Option(response.nurses.name + '-' + response.nurses.id, response.nurses.id, true, true);
                    $('#id="nurses_select"').find('[name="nurse_service"]').append(option).trigger('change');
                }
            })
            //var id = $(this).attr("id");
            // $('#output').append("<h3>" + id + " : " + status + "</h3>");
        });
    }
    );
</script>
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
                    var ids=response.ids;
                    var ids_split=ids.split(",");
                    toastr.success(response.message.message);
<?php if (!$this->ion_auth->in_group(array('admin'))) { ?>
                        $.each(ids_split, function (index, value) {
                          
                            $('#delete-'+value).remove();;
                        });
<?php } ?>
                }
            }) 
        })
    })
</script>

<script>
    $(document).ready(function () {
        $('#save_button_service').click(function () {
            var id = $('#alloted_service').val();
            $.ajax({
                type: "GET",
                url: "bed/createServiceInvoice?id=" + id,
                data: '',
                dataType: 'json',
                success: function (response) {
                    //  var data = jQuery.parseJSON(response);
                     toastr.success(response.message.message);
                     if(response.ids !== '1'){
                    var ids=response.ids;
                    var ids_split=ids.split(",");
                  //  toastr.success(response.message.message);
<?php if (!$this->ion_auth->in_group(array('admin'))) { ?>
                        $.each(ids_split, function (index, value) {
                          
                            $('#delete-service-'+response.date+'-'+value).remove();;
                        });
<?php } ?>
    }
                }
            }) 
        })
    })
</script>

