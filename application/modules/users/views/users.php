<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Users
                <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                    <div class="col-md-4 no-print pull-right"> 
                        <a href="users/addUser">
                            <div class="btn-group pull-right">
                                <button id="" class="btn green btn-xs">
                                    <i class="fa fa-plus-circle"></i> Add Users
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
                                <th> <?php echo lang('email'); ?></th>
                                <th> <?php echo lang('phone'); ?></th>
                                <th> Role</th>
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

                        <?php foreach ($users as $user) { ?>
                            <?php if($this->ion_auth->get_users_groups($user->id)->row()->name == 'Nurse' || $this->ion_auth->get_users_groups($user->id)->row()->name == 'Receptionist' || $this->ion_auth->get_users_groups($user->id)->row()->name == 'Accountant' || $this->ion_auth->get_users_groups($user->id)->row()->name == 'Laboratorist' || $this->ion_auth->get_users_groups($user->id)->row()->name == 'Pharmacist' || $this->ion_auth->get_users_groups($user->id)->row()->name == 'members' || $this->ion_auth->get_users_groups($user->id)->row()->name == 'Consultant' || $this->ion_auth->get_users_groups($user->id)->row()->name == 'Customer') {
                                
                            } else { ?>
                                <tr class="">
                                <td><?php echo $user->first_name ." ".$user->last_name; ?></td>
                                <td><?php echo $user->email; ?></td>
                                <td><?php echo $user->phone; ?></td>
                                <?php $this->db->where('user_id',$user->id);
                                $gid = $this->db->get('users_groups')->row()->group_id;
                                $this->db->where('id',$gid);
                                $gn = $this->db->get('groups')->row()->name;
                                ?>
                                <td> <?php echo ucfirst($gn); ?> </td>
                                <td>
                                    <a class="btn btn-info btn-xs btn_width" href="users/editUser?id=<?php echo $user->id; ?>"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?></a>
                                    <a class="btn btn-danger btn-xs btn_width delete_button" href="users/deleteUser?id=<?php echo $user->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> <?php echo lang('delete'); ?></a>
                                </td>
                            </tr>
                            <?php }?>
                        <?php } ?>
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

