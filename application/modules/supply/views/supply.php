<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
       
        <section class="">
            <header class="panel-heading">
               <?php echo lang('supply'); ?> <?php echo lang('medicine'); ?> 
                <?php if ($this->ion_auth->in_group(array('admin', 'Pharmacist')) || $permis == 'ok') { ?>
                    <div class="col-md-4 no-print pull-right"> 
                        <a data-toggle="modal" href="supply/addNewSupply">
                            <div class="btn-group pull-right">
                                <button id="" class="btn green btn-xs">
                                    <i class="fa fa-plus-circle"></i> <?php echo lang('add'); ?> <?php echo lang('new'); ?> <?php echo lang('supply'); ?>
                                </button>
                            </div>
                        </a>
                    </div>
                <?php } ?>
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
                                <th> <?php echo lang('invoice'); ?> <?php echo lang('id'); ?></th>
                                         <th> <?php echo lang('date'); ?></th>
                                <th> <?php echo lang('vendor_name'); ?></th>
                                <th> <?php echo lang('address'); ?></th>
                                <th> <?php echo lang('phone'); ?></th>
                                <th> <?php echo lang('nipt'); ?></th>
                                
                               
                                <?php if ($this->ion_auth->in_group(array('admin', 'Pharmacist'))) { ?>
                                    <th> <?php echo lang('options'); ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>

                        <style>

                            .img_url{
                                height:20px;
                                width:20px;
                                background-size: contain; 
                                max-height:20px;
                                border-radius: 100px;
                            }

                            .load{
                                float: right !important;
                            }

                        </style>


                        </tbody>
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
        var table = $('#editable-sample1').DataTable({
            responsive: true,
            //   dom: 'lfrBtip',

            "processing": true,
            "serverSide": true,
            "searchable": true,
            "ajax": {
                url: "supply/getSupplyList",
                type: 'POST',
            },
            scroller: {
                loadingIndicator: true
            },
            dom: "<'row'<'col-sm-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",

            buttons: [
                {extend: 'copyHtml5', exportOptions: {columns: [1, 2, 3, 4, 5, 6], }},
                {extend: 'excelHtml5', exportOptions: {columns: [1, 2, 3, 4, 5, 6], }},
                {extend: 'csvHtml5', exportOptions: {columns: [1, 2, 3, 4, 5, 6], }},
                {extend: 'pdfHtml5', exportOptions: {columns: [1, 2, 3, 4, 5, 6], }},
                {extend: 'print', exportOptions: {columns: [1, 2, 3, 4, 5, 6], }},
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
                searchPlaceholder: "Search...",
                "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json"
            },
        });
        table.buttons().container().appendTo('.custom_buttons');
    });
</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>

