<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <form role="form" style="padding: 0px 0px !important;" class="" action="finance/pharmacy/addInventoryReportExcel" method="post" enctype="multipart/form-data">
        <section class="">
            <header class="panel-heading">
                <?php echo $pharmacist->name; ?> <?php echo lang('inventory'); ?> <?php echo lang('report'); ?> 
                <div class="col-md-4 no-print pull-right"> 
                    <button type="submit" id="submit" name="submit" class="btn btn-info pull-right" style="margin-top: 0px;"> <?php echo lang('save'); ?></button>
                </div>

            </header>
            <style>

                .wrapper {
                    padding: 0px 10px 0px 15px !important;
                }

            </style>

            <div class="panel-body"> 
                <div class="adv-table editable-table">
                    <div class="space15">
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample1">
                        <thead>
                            <tr>
                                <th> <?php echo lang('id'); ?></th>
                                <th> <?php echo lang('name'); ?></th>
                                <th> <?php echo lang('category'); ?></th>
                                <th> <?php echo lang('store_box'); ?></th>
                                <th> <?php echo lang('p_price'); ?></th>
                                <th> <?php echo lang('s_price'); ?></th>
                                <th> <?php echo lang('quantity'); ?></th>
                                <th> <?php echo lang('generic_name'); ?></th>
                                <th> <?php echo lang('company'); ?></th>
                                <th> <?php echo lang('effects'); ?></th>
                                <th> <?php echo lang('expiry_date'); ?></th>

                            </tr>
                        </thead>
                        <tbody>
                     
                            <?php
                            $i = 0;
                            foreach ($medicines as $medicine) {
                                $i = $i + 1;
                                ?>
                                <tr><td><?php echo $i;
                                ?><input type="hidden" name="id[]" value="<?php echo $medicine->id; ?>">

                                    </td>
                                    <td><?php echo $medicine->name; ?></td>
                                    <td><?php echo $medicine->category; ?></td>
                                    <td><?php echo $medicine->box; ?></td>
                                    <td><?php echo $medicine->price; ?></td>
                                    <td><?php echo $medicine->s_price; ?></td>
                                    <td><input type="text" name="quantity[]" value="<?php echo $medicine->quantity; ?>" required=""></td>
                                    <td><?php echo $medicine->generic; ?></td>
                                    <td><?php echo $medicine->company; ?></td>
                                    <td><?php echo $medicine->effects; ?></td>
                                    <td><?php echo $medicine->e_date; ?></td>

                                </tr>
                            <?php } ?>
                            <input type="hidden" name="title" value="<?php echo $title; ?>">
                            <input type="hidden" name="date" value="<?php echo $date; ?>">
                            <input type="hidden" name="description" value="<?php echo $description; ?>">
                       

                        </tbody>
                    </table>




                </div>
            </div>
        </section>
        </form>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
<script src="common/js/codearistos.min.js"></script>
<!--<script>
    $(document).ready(function () {
        $("#submit").click(function () {

            $('.f_report').submit();
        });
    });
</script>-->