<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel-body col-md-6">
            <header class="panel-heading">
                <?php
                if (!empty($medicine->id))
                    echo lang('edit_medicine');
                else
                    echo lang('add_medicine');
                ?>
            </header>
            <div class="row">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <div class="col-md-12">
                            <section class="panel row">
                                <div class = "panel-body">
                                    <?php echo validation_errors(); ?>
                                    <form role="form"  id="addMedicineInternal" action="medicine/addNewInternalMedicine" class="clearfix" method="post" enctype="multipart/form-data">

                                        <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                                            <div class="form-group col-md-12">
                                                <label for="exampleInputEmail1"> <?php echo lang('department'); ?></label>
                                                <select class="form-control m-bot15 js-example-basic-single" id="department_add" name="department" value='' required="">
                                                    <option value=""><?php echo lang('select'); ?></option>                    
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
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputEmail1"> <?php echo lang('name'); ?></label>
                                                <select class="form-control m-bot15 js-example-basic-single" name="name_id" id="name_add" value='' required="">
                                                    <?php if (!empty($medicine)) { ?>
                                                        <?php
                                                        foreach ($medicines as $medicine_list) {
                                                            if (!empty($medicine) && $medicine->medicine_id == $medicine_list->id) {
                                                                ?>
                                                                <option value="<?php echo $medicine_list->id; ?>" <?php
                                                                if (!empty($medicine->medicine_id)) {
                                                                    if ($medicine_list->id == $medicine->medicine_id) {
                                                                        echo 'selected';
                                                                    }
                                                                }
                                                                ?> > <?php echo $medicine_list->name; ?> </option>
                                                                    <?php
                                                                    }
                                                                    if (!in_array($medicine_list->id, $internal)) {
                                                                        ?>
                                                                <option value="<?php echo $medicine_list->id; ?>" <?php
                                                                if (!empty($medicine->medicine_id)) {
                                                                    if ($medicine_list->id == $medicine->medicine_id) {
                                                                        echo 'selected';
                                                                    }
                                                                }
                                                                ?> > <?php echo $medicine_list->name; ?> </option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?> 
    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputEmail1"> <?php echo lang('category'); ?></label>
                                                <select class="form-control m-bot15 js-example-basic-single" name="category" id="category_add" value='' required="">
                                                    <?php if (!empty($medicine)) { ?>
                                                        <?php foreach ($categories as $category) { ?>
                                                            <option value="<?php echo $category->category; ?>" <?php
                                                            if (!empty($medicine->category)) {
                                                                if ($category->category == $medicine->category) {
                                                                    echo 'selected';
                                                                }
                                                            }
                                                            ?> > <?php echo $category->category; ?> </option>
        <?php } ?> 
                                            <?php } ?>
                                                </select>
                                            </div>
<?php } else { ?>
                                            <div class="form-group col-md-5">
                                                <label for="exampleInputEmail1"> <?php echo lang('medicine'); ?></label>
                                                <select class="form-control m-bot15" name="name_id" value='' required="">
                                                    <?php
                                                    foreach ($medicines as $medicine_list) {
                                                        if (!empty($medicine) && $medicine->medicine_id == $medicine_list->id) {
                                                            ?>
                                                            <option value="<?php echo $medicine_list->id; ?>" <?php
                                                            if (!empty($medicine->medicine_id)) {
                                                                if ($medicine_list->id == $medicine->medicine_id) {
                                                                    echo 'selected';
                                                                }
                                                            }
                                                            ?> > <?php echo $medicine_list->name; ?> </option>
                                                        <?php
                                                        }
                                                        if (!in_array($medicine_list->id, $internal)) {
                                                            ?>
                                                            <option value="<?php echo $medicine_list->id; ?>" <?php
                                                            if (!empty($medicine->medicine_id)) {
                                                                if ($medicine_list->id == $medicine->medicine_id) {
                                                                    echo 'selected';
                                                                }
                                                            }
                                                            ?> > <?php echo $medicine_list->name; ?> </option>
            <?php
        }
    }
    ?> 
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="exampleInputEmail1"> <?php echo lang('category'); ?></label>
                                                <select class="form-control m-bot15" name="category" value='' required="">
                                                    <?php foreach ($categories as $category) { ?>
                                                        <option value="<?php echo $category->category; ?>" <?php
                                                        if (!empty($medicine->category)) {
                                                            if ($category->category == $medicine->category) {
                                                                echo 'selected';
                                                            }
                                                        }
                                                        ?> > <?php echo $category->category; ?> </option>
                                            <?php } ?> 
                                                </select>
                                            </div>

                                            <?php } ?>

                                        <div class="form-group col-md-3">
                                            <label for="exampleInputEmail1"> <?php echo lang('s_price'); ?></label>
                                            <input type="text" class="form-control" name="s_price" id="exampleInputEmail1" value='<?php
                                            if (!empty($medicine)) {
                                                echo $medicine->s_price;
                                            }
                                            ?>' placeholder="">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="exampleInputEmail1"> <?php echo lang('expiry_date'); ?></label>
                                            <input type="text" class="form-control default-date-picker" name="e_date" id="exampleInputEmail1" value='<?php
                                            if (!empty($medicine)) {
                                                echo $medicine->e_date;
                                            }
                                            ?>' placeholder="" readonly="">
                                        </div>
                                        <input type="hidden" name="id" id="internal_id" value='<?php
                                        if (!empty($medicine->id)) {
                                            echo $medicine->id;
                                        }
                                        ?>'>
                                        <div class="form-group col-md-12">
                                            <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                                        </div>
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
<script src="common/js/codearistos.min.js"></script>
<?php if(empty($medicine)) { ?>
<script>
    $(document).ready(function () {
        $('#addMedicineInternal').on('change', '#department_add', function () {
            var id = $(this).val();
            $('#name_add').html("");
            $('#category_add').html("");
            $.ajax({
                url: 'medicine/getInternalMedicineNameAndCategoryByDepartment?id=' + id,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                $('#name_add').html(response.option);
                $('#category_add').html(response.option1);
            });
        });
    });
</script>
<?php }else{ ?>
<script>
    $(document).ready(function () {
       $('#addMedicineInternal').on('change', '#department_add', function () {
            var id = $(this).val();
            var internal_med_id = $('#internal_id').val();
            $('#name_add').html("");
            $('#category_add').html("");
            $.ajax({
                url: 'medicine/getInternalMedicineNameAndCategoryByDepartmentForEdit?id=' + id + '&med_id=' + internal_med_id,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                $('#name_add').html(response.option);
                $('#category_add').html(response.option1);
            });
        });
    });
</script>
 <?php  } ?>
<style>
    .wrapper{
        padding: 24px 30px;
    }
</style>
