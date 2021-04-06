<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php echo lang('my'); ?> <?php echo lang('cases'); ?> 
            </header> 
            <div class="panel-body"> 
                <div class="adv-table editable-table">
                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                        <thead>
                            <tr>
                                <th style="width: 10%"><?php echo lang('id'); ?></th>
                                <th style="width: 20%"><?php echo lang('case'); ?> <?php echo lang('title'); ?></th>
                                <th style="width: 20%"><?php echo lang('description'); ?></th> 
                                <th style="width: 15%"><?php echo lang('status'); ?> </th>
                                <th style="width: 15%"><?php echo lang('options'); ?> </th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($medical_histories as $medical_history) { ?>
                                <?php $patient_info = $this->db->get_where('patient', array('id' => $medical_history->patient_id))->row(); ?>

                                <tr class="">

                                    <td>
                                        <?php
                                        echo $medical_history->id;
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        echo $medical_history->title;
                                        ?>
                                    </td>

                                    <td><?php
                                        if (!empty($medical_history->description)) {
                                            $description = array();
                                            $option_description = '';
                                            $descriptions = explode('##', $medical_history->description);
                                            foreach ($descriptions as $description) {
                                                $description_single = array();
                                                $description_single = explode('**', $description);
                                                if ($description_single[0] == 'Package') {
                                                    $option_description .= '<ul><li>' . $description_single[0] . '-' . $description_single[1] . '</li></ul>';
                                                } else {
                                                    $option_description .= '<ul><li>' . $description_single[1] . '</li></ul>';
                                                }
                                            }
                                        }
                                        echo $option_description;
                                        ?></td>
                                    <td><?php
                                        if ($medical_history->status == 'Pending Confirmation') {
                                            $status = lang('pending_confirmation');
                                        } if ($medical_history->status == 'Confirmed') {
                                            $status = lang('confirmed');
                                        }
                                        echo $status;
                                        ?></td>
                                    <td>
                                        <?php if($medical_history->status== 'Confirmed'){
                                            ?>
                                            <a class="btn btn-success btn-xs btn_width" title="<?php echo lang('invoice'); ?>" href="patient/myInvoice?id=<?php echo $medical_history->payment_id; ?>"><i class="fa fa-file-invoice"></i> </a>
                                       <?php } ?>
                                            
                                    </td>

                                </tr>
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





<?php
$current_user = $this->ion_auth->get_user_id();
if ($this->ion_auth->in_group('Doctor')) {
    $doctor_id = $this->db->get_where('doctor', array('ion_user_id' => $current_user))->row()->id;
}
?>




<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".editbutton").click(function (e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#myModal2').modal('show');
            $.ajax({
                url: 'patient/editMedicalHistoryByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                // Populate the form fields with the data returned from server
                $('#medical_historyEditForm').find('[name="id"]').val(response.medical_history.id).end()
                $('#medical_historyEditForm').find('[name="date"]').val(response.medical_history.date).end()
                $('#medical_historyEditForm').find('[name="patient"]').val(response.medical_history.patient_id).end()
                CKEDITOR.instances['editor'].setData(response.medical_history.description)

                $('.js-example-basic-single.patient').val(response.medical_history.patient_id).trigger('change');
            });
        });
    });</script>


<script>
    $(document).ready(function () {
        var table = $('#editable-sample').DataTable({
            responsive: true,
            dom: "<'row'<'col-sm-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",

            buttons: [
                {extend: 'copyHtml5', exportOptions: {columns: [0, 1, 2, 3, 4, 5], }},
                {extend: 'excelHtml5', exportOptions: {columns: [0, 1, 2, 3, 4, 5], }},
                {extend: 'csvHtml5', exportOptions: {columns: [0, 1, 2, 3, 4, 5], }},
                {extend: 'pdfHtml5', exportOptions: {columns: [0, 1, 2, 3, 4, 5], }},
                {extend: 'print', exportOptions: {columns: [0, 1, 2, 3, 4, 5], }},
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
                "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json"
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
