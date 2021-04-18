

<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->

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
                                            //  echo 'disabled';
                                        }
                                        ?>>
                                        <label style="margin-right: 56px;"><?php echo lang('po'); ?></label>
                                        <input type="radio" name="covid_19" value="jo"<?php
                                        if ($checkin->covid_19 == 'jo') {
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
                                        <label for="exampleInputEmail1"><?php echo lang('patient'); ?></label>
                                        <select class="form-control m-bot15" id="patientchoose" name="patient" value=''> 
                                            <?php if (!empty($checkin->id)) { ?>
                                                <option value="<?php echo $patients->id; ?>" selected="selected"><?php echo $patients->name; ?> - <?php echo $patients->id; ?></option>  
                                            <?php }
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
                                        <textarea name="reaksione" class='form-control'<?php
                                        //  if (!empty($allotment->d_time) && !$this->ion_auth->in_group(array('admin'))) {
                                        //      echo 'readonly';
                                        //   }
                                        ?>><?php
                                                      if (!empty($checkin->reaksione)) {
                                                          echo $checkin->reaksione;
                                                      }
                                                      ?> </textarea>

                                    </div>
                                    <div class="form-group col-md-12">

                                        <label for="exampleInputEmail1" style="margin-right: 20px;"><?php echo lang('transferred_from'); ?>:</label>
                                        <textarea name="transferred_from" class='form-control'<?php
                                        // if (!empty($allotment->d_time) && !$this->ion_auth->in_group(array('admin'))) {
                                        //     echo 'readonly';
                                        //   }
                                        ?>> <?php
                                                      if (!empty($checkin->transferred_from)) {
                                                          echo $checkin->transferred_from;
                                                      }
                                                      ?></textarea>

                                    </div>
                                    <div class="form-group col-md-12">

                                        <label for="exampleInputEmail1"><?php echo lang('actual_illness'); ?>:</label>
                                        <textarea name="actual_illness" class='form-control'<?php
                                        //   if (!empty($allotment->d_time) && !$this->ion_auth->in_group(array('admin'))) {
                                        //    echo 'readonly';
                                        //   }
                                        ?>><?php
                                                      if (!empty($checkin->actual_illness)) {
                                                          echo $checkin->actual_illness;
                                                      }
                                                      ?> </textarea>

                                    </div>
                                    <div class="form-group col-md-12">

                                        <label for="exampleInputEmail1"><?php echo lang('addtional_illness'); ?>:</label>
                                        <textarea name="addtional_illness" class='form-control'<?php
                                        //   if (!empty($allotment->d_time) && !$this->ion_auth->in_group(array('admin'))) {
                                        //    echo 'readonly';
                                        //   }
                                        ?>><?php
                                                      if (!empty($checkin->addtional_illness)) {
                                                          echo $checkin->addtional_illness;
                                                      }
                                                      ?> </textarea>

                                    </div>
                                    <div class="form-group col-md-12">

                                        <label for="exampleInputEmail1"><?php echo lang('other_risk_factor'); ?>:</label>
                                        <textarea name="other_risk_factor" class='form-control'<?php
                                        //   if (!empty($allotment->d_time) && !$this->ion_auth->in_group(array('admin'))) {
                                        //    echo 'readonly';
                                        //   }
                                        ?>><?php
                                                      if (!empty($checkin->other_risk_factor)) {
                                                          echo $checkin->other_risk_factor;
                                                      }
                                                      ?> </textarea>

                                    </div>
                                    <div class="form-group col-md-12">

                                        <label for="exampleInputEmail1"><?php echo lang('diagnoza_pranimit'); ?>:</label>
                                        <textarea name="diagnoza_pranimit" class='form-control'<?php
                                        //   if (!empty($allotment->d_time) && !$this->ion_auth->in_group(array('admin'))) {
                                        //     echo 'readonly';
                                        //    }
                                        ?>><?php
                                                      if (!empty($checkin->diagnoza_pranimit)) {
                                                          echo $checkin->diagnoza_pranimit;
                                                      }
                                                      ?> </textarea>

                                    </div>
                                    <div class="form-group col-md-12">

                                        <label for="exampleInputEmail1"><?php echo lang('diagnoza_klinike'); ?>:</label>
                                        <textarea name="diagnoza_klinike" class='form-control'<?php
                                        //   if (!empty($allotment->d_time) && !$this->ion_auth->in_group(array('admin'))) {
                                        //     echo 'readonly';
                                        //    }
                                        ?>><?php
                                                      if (!empty($checkin->diagnoza_klinike)) {
                                                          echo $checkin->diagnoza_klinike;
                                                      }
                                                      ?> </textarea>

                                    </div>
                                    <div class="form-group col-md-12">

                                        <label for="exampleInputEmail1"><?php echo lang('diagnoza_imazherike'); ?>:</label>
                                        <textarea name="diagnoza_imazherike" class='form-control'<?php
                                        //   if (!empty($allotment->d_time) && !$this->ion_auth->in_group(array('admin'))) {
                                        //     echo 'readonly';
                                        //    }
                                        ?>><?php
                                                      if (!empty($checkin->diagnoza_imazherike)) {
                                                          echo $checkin->diagnoza_imazherike;
                                                      }
                                                      ?> </textarea>

                                    </div>
                                    <div class="form-group col-md-12">

                                        <label for="exampleInputEmail1"><?php echo lang('diagnoza_perfundimtare'); ?>:</label>
                                        <textarea name="diagnoza_perfundimtare" class='form-control'<?php
                                        //   if (!empty($allotment->d_time) && !$this->ion_auth->in_group(array('admin'))) {
                                        //     echo 'readonly';
                                        //    }
                                        ?>><?php
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

                                        <div class="col-md-6">
                                            <button style="background: #7a2828;" type="submit" name="submit" class="btn btn-info pull-right" onclick="history.back()"><?php echo lang('exit'); ?></button>
                                            <button style="margin-right: 7px;" type="submit" name="submit2" class="btn btn-info pull-right" ><?php echo lang('submit'); ?></button>

                                        </div>

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
                                        hjkgjgjg
                                    </div>
                                    <div id="pre_medicines" class="tab-pane">
                                        qwerty  
                                    </div>
                                </div>
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
                                                });
</script>
<script>
    $("ul.nav-tabs a").click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
</script>