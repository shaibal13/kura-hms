<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Roles
                <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                    <div class="col-md-4 no-print pull-right"> 
                        <a href="users/addGroup">
                            <div class="btn-group pull-right">
                                <button id="" class="btn green btn-xs">
                                    <i class="fa fa-plus-circle"></i> Add Roles
                                </button>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="space15"></div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                        <thead>
                            <tr>
                                <th> <?php echo lang('name'); ?></th>
                                <th> Permissions</th>
                                <th> <?php echo lang('options'); ?></th> 

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

                        </style>

                        <?php
                        foreach ($groups as $group) {
                            if (($group->name == 'members') || ($group->name == 'Nurse') || $group->name == 'Pharmacist' || $group->name == 'Laboratorist' || $group->name == 'Accountant' || $group->name == 'Receptionist' || $group->name == "Consultant" || $group->name == "Customer") {
                                ?>

                            <?php } else { ?>
                                <tr class="">
                                    <td><?php echo $group->name; ?></td>
                                    <td><?php echo $group->description; ?></td>
                                    <?php if ($group->name == "admin" || $group->name == "Super" || $group->name == "Dispatch") { ?>
                                        <td>
                                            <a class="btn btn-success btn-xs btn_width" href="users/editGroup?id=<?php echo $group->id; ?>"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?></a>
                                        </td>
                                    <?php } else { ?>
                                        <td>
                                            <a class="btn btn-success btn-xs btn_width" href="users/editGroup?id=<?php echo $group->id; ?>"><i class="fa fa-edit"></i><?php echo lang('edit'); ?></a>
                                            <a class="btn btn-info btn-xs btn_width delete_button" href="users/deleteGroup?id=<?php echo $group->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> <?php echo lang('delete'); ?></a>

                                        </td>
                                    <?php } ?>
                                </tr>
                                <?php
                            }
                        }
                        ?>
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

<script type="text/javascript">
                                                $(document).ready(function () {
                                                    $(".editOrder").click(function (e) {
                                                        e.preventDefault(e);
                                                        // Get the record's ID via attribute  
                                                        var iid = $(this).attr('data-id');
                                                        $('#myModal5').modal('show');
                                                        $.ajax({
                                                            url: 'order/editOrderByJason?id=' + iid,
                                                            method: 'GET',
                                                            data: '',
                                                            dataType: 'json',
                                                        }).success(function (response) {
                                                            var de = response.order.date * 1000;
                                                            var d = new Date(de);
                                                            var da = (d.getDate() + 1) + '-' + (d.getMonth() + 1) + '-' + d.getFullYear();
                                                            // Populate the form fields with the data returned from server
                                                            $('#orderEditForm').find('[name="id"]').val(response.order.id).end()
                                                            $('#orderEditForm').find('[name="date"]').val(da).end()
                                                            // Populate the form fields with the data returned from server
                                                            $('#orderEditForm').find('[name="customer"]').val(response.order.customer).end()
                                                            $('#orderEditForm').find('[name="consultant"]').val(response.order.consultant).end()

                                                            CKEDITOR.instances['editor1'].setData(response.order.symptom)
                                                            CKEDITOR.instances['editor2'].setData(response.order.medicine)
                                                            CKEDITOR.instances['editor3'].setData(response.order.note)
                                                        });
                                                    });
                                                });
</script>


<script>
    $(document).ready(function () {
        var table = $('#editable-sample').DataTable({
            responsive: true,

            dom: "<'row'<'col-sm-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2],
                    }
                },
            ],

            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            iDisplayLength: -1,
            "order": [[0, "desc"]],

            "language": {
                "lengthMenu": "_MENU_",
                search: "_INPUT_",
                searchPlaceholder: "Search..."
            },

        });

        table.buttons().container()
                .appendTo('.custom_buttons');
    });
</script>


<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>

