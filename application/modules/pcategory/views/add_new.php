
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php
                if (!empty($accountant->id))
                    echo '<i class="fa fa-edit"></i> ' . lang('edit_patient_category');
                else
                    echo '<i class="fa fa-plus-circle"></i> ' . lang('add_patient_category');
                ?>
            </header>
            <div class="panel-body col-md-7">
                <div class="adv-table editable-table ">
                    <div class="clearfix">

                        <div class="col-lg-12">
                            <section class="panel">
                                <div class="panel-body">
                                    <div class="col-lg-12">
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-6">
                                            <?php echo validation_errors(); ?>
                                            <?php echo $this->session->flashdata('feedback'); ?>
                                        </div>
                                        <div class="col-lg-3"></div>
                                    </div>
                                    <form role="form" action="pcategory/addNew" method="post" enctype="multipart/form-data">
                                        <div class="form-group">    
                                            <label for="exampleInputEmail1"><?php echo lang('name'); ?></label>
                                            <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='<?php
                                            if (!empty($setval)) {
                                                echo set_value('name');
                                            }
                                            if (!empty($pcategory->name)) {
                                                echo $pcategory->name;
                                            }
                                            ?>' placeholder="" required>   
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo lang('description'); ?></label>
                                            <input type="text" class="form-control" name="description" id="exampleInputEmail1" value='<?php
                                            if (!empty($setval)) {
                                                echo set_value('description');
                                            }
                                            if (!empty($pcategory->description)) {
                                                echo $pcategory->description;
                                            }
                                            ?>' placeholder="" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo lang('discount'); ?></label>
                                            <input type="text" class="form-control" name="discount" id="exampleInputEmail1" value='<?php
                                            if (!empty($setval)) {
                                                echo set_value('discount');
                                            }
                                            if (!empty($pcategory->discount)) {
                                                echo $pcategory->discount;
                                            }
                                            ?>' placeholder="" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo lang('status'); ?></label>
                                            <select class="js-example-basic-single" name="status">
                                                <option value="active"><?php echo lang('active'); ?></option>
                                                <option value="disable"><?php echo lang('in_active'); ?></option>
                                            </select>
                                        </div>

                                        <button type="submit" name="submit" class="btn btn-info"><?php echo lang('submit'); ?></button>
                                    </form>
                                </div>
                            </section>
                        </div>  
                    </div> 
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
