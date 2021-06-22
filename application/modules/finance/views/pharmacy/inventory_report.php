<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">

        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php echo lang('inventory'); ?> <?php echo lang('report'); ?>
               

            </header>
             <?php if ($this->ion_auth->in_group(array('Pharmacist'))){  ?>
            <div class="col-md-12">
                <div class="col-md-12 row">
                    <section>
                        <form role="form" class="f_report" action="finance/pharmacy/addInventoryReport" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <!--     <label class="control-label col-md-3">Date Range</label> -->
                                <div class="col-md-3" style="margin-top: -14px;">
                                    <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
                                    <input type="text" class="form-control default-date-picker" name="date" id="exampleInputEmail1" value='' placeholder="" required="" onkeypress="return false;">
                                    <div class="row"></div>
                                    <span class="help-block"></span> 
                                </div>
                                <div class="col-md-3 no-print" style="margin-top: -14px;">

                                    <label for="exampleInputEmail1"> <?php echo lang('title'); ?></label>
                                    <input type="text" class="form-control" name="title" id="exampleInputEmail1" value='' placeholder="" required="">
                                </div>

                                <div class="col-md-4 no-print form-group" id="department_choose" style="margin-top: -14px;">
                                    <label for="exampleInputEmail1"> <?php echo lang('description'); ?></label>
                                    <input type="text" class="form-control" name="description" id="exampleInputEmail1" value='' placeholder="">
                                </div>




                                <div class="col-md-2 no-print" style="margin-top: 6px;">
                                    <button type="submit" name="submit" class="btn btn-info range_submit"><?php echo lang('create'); ?></button>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
            <?php } ?>
            <div class="panel-body">
                <div class="adv-table editable-table ">

                    <div class="space15"></div>
                    <table class="table table-striped table-hover table-bordered" id="">
                        <thead>
                            <tr>
                                <th><?php echo lang('date'); ?></th>
                                <th><?php echo lang('title'); ?></th>
                                <th><?php echo lang('description'); ?></th>
                                <th><?php echo lang('options'); ?></th>
                                


                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($inventory as $inventories) { ?>
                            
                            <tr>
                                <td><?php echo $inventories->date; ?></td>
                                <td><?php echo $inventories->title; ?></td>
                                <td><?php echo $inventories->description; ?></td>
                                <td><?php  if ($this->ion_auth->in_group(array('admin'))) { ?>
                                     <a class="btn btn-info btn-xs btn_width editbutton" href="finance/pharmacy/editInventory?id=<?php echo $inventories->id; ?>" ><i class="fa fa-edit"> <?php echo lang('edit'); ?></i></a>
                                <?php } ?>
                                      <a class="btn btn-success btn-xs btn_width" href="finance/pharmacy/viewInventory?id=<?php echo $inventories->id; ?>" ><i class="fa fa-info"> <?php echo lang('view'); ?></i></a>
                                       <a class="btn btn-primary btn-xs btn_width" href="finance/pharmacy/compareInventory?id=<?php echo $inventories->id; ?>" ><i class="fa fa-abacus"> <?php echo lang('compare'); ?></i></a>
                                     <?php  if ($this->ion_auth->in_group(array('admin'))) { ?>
                                     <a class="btn btn-info btn-xs btn_width delete_button" href="finance/pharmacy/deleteInventory?id=<?php echo $inventories->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"> <?php echo lang('delete'); ?></i></a>
                                <?php } ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>

                        <tfoot>
                            
                        </tfoot>
                    </table>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->



<script src="common/js/codearistos.min.js"></script>
<script>
        $(document).ready(function () {
            $(".flashmessage").delay(3000).fadeOut(100);
        });</script>



<script>


    $(document).ready(function () {
        var table = $('#editable-sample').DataTable({
            responsive: true,
            //   dom: 'lfrBtip',

            "processing": true,
            "serverSide": false,
            "searchable": true,

            scroller: {
                loadingIndicator: true
            },
            dom: "<'row'<'col-md-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",

            buttons: [
                {extend: 'copyHtml5', exportOptions: {columns: [1, 2, 3, 4, 5, 6, 7, 8, 9], }},
                {extend: 'excelHtml5', exportOptions: {columns: [1, 2, 3, 4, 5, 6, 7, 8, 9], }},
                {extend: 'csvHtml5', exportOptions: {columns: [1, 2, 3, 4, 5, 6, 7, 8, 9], }},
                {extend: 'pdfHtml5', exportOptions: {columns: [1, 2, 3, 4, 5, 6, 7, 8, 9], }},
                {extend: 'print', exportOptions: {columns: [1, 2, 3, 4, 5, 6, 7, 8, 9], }},
            ],
            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            iDisplayLength: 100,

            "order": [[0, "desc"]],

            "language": {
                "lengthMenu": "_MENU_",
                search: "_INPUT_",
                "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json"
            }
        });
        table.buttons().container().appendTo('.custom_buttons');
    });
</script>
