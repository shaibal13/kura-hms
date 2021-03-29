<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-6 row">
            <header class="panel-heading">
                <?php
                if (!empty($bed->id))
                    echo lang('edit_category');
                else
                    echo lang('add_new_category');
                ?>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <?php echo validation_errors(); ?>
                        <form role="form" action="category/addType" class="clearfix" method="post" enctype="multipart/form-data">
                           
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo lang('name'); ?></label>
                                <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('name');
                                }
                                if (!empty($bed->name)) {
                                    echo $bed->name;
                                }
                                ?>' placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo lang('description'); ?></label>
                                <input type="text" class="form-control" name="description" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('description');
                                }
                                if (!empty($bed->description)) {
                                    echo $bed->description;
                                }
                                ?>' placeholder="">
                            </div>

                            <input type="hidden" name="id" value='<?php
                            if (!empty($bed->id)) {
                                echo $bed->id;
                            }
                            ?>'>
                            <div class="form-group">
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
