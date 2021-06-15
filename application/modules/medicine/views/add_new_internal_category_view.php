<!--sidebar end--> 
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-6 row">
            <header class="panel-heading">
                <?php
                if (!empty($medicine->id))
                    echo lang('edit_medicine_category');
                else
                    echo lang('add_medicine_category');
                ?>
            </header>
            <div class="">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <div class="panel-body">
                            <?php echo validation_errors(); ?>
                            <form role="form" action="medicine/addInternalCategoryView" class="clearfix" method="post" enctype="multipart/form-data">
                                <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail1"> <?php echo lang('department'); ?></label>
                                        <select class="form-control m-bot15 js-example-basic-single" name="department" value=''>
                                            <?php foreach ($departments as $department) { ?>
                                                <option value="<?php echo $department->id; ?>" <?php
                                                if (!empty($medicine->department)) {
                                                    if ($department->id == $medicine->department) {
                                                        echo 'selected';
                                                    }
                                                }
                                                ?> > <?php echo $department->name; ?> </option>
                                                    <?php } ?> 
                                        </select>
                                    </div>
                                <?php } ?>
                                <div class="form-group"> 
                                    <label for="exampleInputEmail1"> <?php echo lang('category'); ?> <?php echo lang('name'); ?> </label>
                                    <input type="text" class="form-control" name="category" id="exampleInputEmail1" value='<?php
                                    if (!empty($medicine->category)) {
                                        echo $medicine->category;
                                    }
                                    ?>' placeholder="">    
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> <?php echo lang('description'); ?></label>
                                    <input type="text" class="form-control" name="description" id="exampleInputEmail1" value='<?php
                                    if (!empty($medicine->description)) {
                                        echo $medicine->description;
                                    }
                                    ?>' placeholder="">
                                </div>
                                <input type="hidden" name="id" value='<?php
                                if (!empty($medicine->id)) {
                                    echo $medicine->id;
                                }
                                ?>'>
                                <button type="submit" name="submit" class="btn btn-info"> <?php echo lang('submit'); ?></button>
                            </form>
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
