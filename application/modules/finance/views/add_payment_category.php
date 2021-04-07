<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-7">
            <header class="panel-heading">
                <?php
                if (!empty($category->id))
                    echo lang('edit_payment_category');
                else
                    echo lang('create_payment_procedure');
                ?>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <?php echo validation_errors(); ?>
                        <form role="form" action="finance/addPaymentCategory" class="clearfix" method="post" enctype="multipart/form-data">
                            <div class="form-group"> 
                                <label for="exampleInputEmail1"><?php echo lang('category'); ?> <?php echo lang('name'); ?></label>
                                <input type="text" class="form-control" name="category" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('category');
                                }
                                if (!empty($category->category)) {
                                    echo $category->category;
                                }
                                ?>' placeholder="">    
                            </div> 
                            <div class="form-group"> 
                                <label for="exampleInputEmail1"><?php echo lang('code'); ?></label>
                                <input type="text" class="form-control" name="code" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('code');
                                }
                                if (!empty($category->code)) {
                                    echo $category->code;
                                }
                                ?>' placeholder="">    
                            </div> 
                             <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo lang('department'); ?></label>
                                <select class="form-control m-bot15 js-example-basic-single" name="department" value=''>  
                                    <?php foreach ($departments as $department) { ?>
                                        <option value="<?php echo $department->id; ?>" <?php
                                        if ($department->id == $category->department) {
                                            echo 'selected';
                                        } if (set_value('department') == $department->id) {
                                            echo 'selected';
                                        }
                                        ?> ><?php echo $department->name; ?></option>
                                            <?php } ?>

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo lang('description'); ?></label>
                                <input type="text" class="form-control" name="description" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('description');
                                }
                                if (!empty($category->description)) {
                                    echo $category->description;
                                }
                                ?>' placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo lang('category'); ?> <?php echo lang('price'); ?></label>
                                <input type="text" class="form-control" name="c_price" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('c_price');
                                }
                                if (!empty($category->c_price)) {
                                    echo $category->c_price;
                                }
                                ?>' placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo lang('doctors_commission'); ?> <?php echo lang('rate'); ?> (%)</label>
                                <input type="text" class="form-control" name="d_commission" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('d_commission');
                                }
                                if (!empty($category->d_commission)) {
                                    echo $category->d_commission;
                                }
                                ?>' placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo lang('type'); ?></label>
                                <select class="form-control m-bot15" name="type" value=''>  
                                    <?php foreach ($types as $type) { ?>
                                        <option value="<?php echo $type->id; ?>" <?php
                                        if ($type->id == $category->type) {
                                            echo 'selected';
                                        } if (set_value('type') == $type->id) {
                                            echo 'selected';
                                        }
                                        ?> ><?php echo $type->name; ?></option>
                                            <?php } ?>

                                </select>
                            </div>

                            <input type="hidden" name="id" value='<?php
                            if (!empty($category->id)) {
                                echo $category->id;
                            }
                            ?>'>

                            <div class="form-group col-md-12">
                                <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
