<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="">
            <header class="panel-heading">
                <?php
                if (!empty($internal_requisition->id))
                    echo lang('edit') . ' ' . lang('medicine_requisition');
                else
                    echo lang('add') . ' ' . lang('medicine_requisition');
                ?>
            </header>
            <div class="">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <style> 
                            .payment{
                                padding-top: 20px;
                                padding-bottom: 20px;
                                border: none;

                            }
                            .pad_bot{
                                padding-bottom: 10px;
                            }  

                            form{
                                border: 1px solid #ccc;
                                background: transparent;
                            }
                            .pos{
                                padding-left:0px;
                            }
                            .form-control{
                                font-size: 14px;
                                font-weight: 600;
                                box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
                            }
                        </style>

                        <form role="form" class="clearfix pos form1"  id="editPaymentForm" action="medicine/addNewMedicineRequisition" method="post" enctype="multipart/form-data">
                            <div class="col-md-6 row">     
                                <?php if (!empty($internal_requisition->id)) { ?>
                                    <div class="col-md-8 payment pad_bot">
                                        <div class="col-md-3 payment_label"> 
                                            <label for="exampleInputEmail1">  <?php echo lang('invoice_id'); ?> :</label>
                                        </div>
                                        <div class="col-md-6">                                                   
                                            <?php echo '00' . $internal_requisition->id; ?>                                                                                                       
                                        </div>                                              
                                    </div>                                           
                                <?php } ?>
                                <div class="col-md-8 payment">
                                    <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                                        <div class="form-group col-md-12">
                                            <label for="exampleInputEmail1"> <?php echo lang('department'); ?></label>
                                            <select class="form-control m-bot15 js-example-basic-single" name="department" id="department" value=''>
                                                <?php foreach ($departments as $department) { ?>
                                                    <option value="<?php echo $department->id; ?>" <?php
                                                    if (!empty($internal_requisition->department)) {
                                                        if ($department->id == $internal_requisition->department) {
                                                            echo 'selected';
                                                        }
                                                    }
                                                    ?> > <?php echo $department->name; ?> </option>
                                                        <?php } ?> 
                                            </select>
                                        </div>
                                    <?php } ?>
                                    <div class="form-group last">
                                        <div class="col-md-6 payment_label row"> 
                                            <label for="exampleInputEmail1"> <?php echo lang('select_item'); ?></label>
                                        </div>
                                        <div class="col-md-9 row" style="margin-left: 0px; width: 100%;">
                                            <?php if (empty($internal_requisition->id)) { ?>

                                                <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                                                    <select name="category_name[]" class="multi-select1 js-example-basic-multiple" id="my_multi_select4" multiple="multiple" required="">

                                                    </select>
                                                <?php } else { ?>
                                                    <select name="category_name[]" class="multi-select1" id="my_multi_select4" required="">

                                                    </select>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                                                    <select name="category_name[]"  class="multi-select1 js-example-basic-multiple"  multiple="multiple" id="my_multi_select4" required="" >
                                                        <?php
                                                        if (!empty($internal_requisition)) {
                                                            $category_name = $internal_requisition->category_name;
                                                            $category_name1 = explode(',', $category_name);
                                                            foreach ($category_name1 as $category_name2) {
                                                                $category_name3 = explode('*', $category_name2);
                                                                $selected_medicine[] = $category_name3[4];
                                                                $selected_quantity[] = $category_name3[2];
                                                            }
                                                            $item_quantity_array = array_combine($selected_medicine, $selected_quantity);
                                                            foreach ($internal_medicines as $internal_med) {
                                                                $medicine = $this->medicine_model->getMedicineById($internal_med->medicine_id);
                                                                if (in_array($internal_med->id, $selected_medicine)) {
                                                                    ?>
                                                                    <option value="<?php echo $internal_med->id . '*' . (float) $medicine->s_price . '*' . $medicine->name . '*' . $medicine->company . '*' . $medicine->quantity . '*' . $medicine->id; ?>" data-qtity="<?php echo $item_quantity_array[$internal_med->id]; ?>" selected="selected">
                                                                    <?php echo $medicine->name; ?>
                                                                    </option> 
                                                                    <?php } else { ?>
                                                                    <option value="<?php echo $internal_med->id . '*' . (float) $medicine->s_price . '*' . $medicine->name . '*' . $medicine->company . '*' . $medicine->quantity . '*' . $medicine->id; ?>" data-qtity="<?php echo '1'; ?>">
                                                                    <?php echo $medicine->name; ?>
                                                                    </option> 
                                                                <?php }
                                                                ?>

            <?php } ?> 


                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                <?php } else { ?>
                                                    <select name="category_name[]"  class="multi-select1"  multiple="multiple" id="my_multi_select4" required="" >
                                                        <?php
                                                        if (!empty($internal_requisition)) {

                                                            $category_name = $internal_requisition->category_name;
                                                            $category_name1 = explode(',', $category_name);
                                                            foreach ($category_name1 as $category_name2) {
                                                                $category_name3 = explode('*', $category_name2);
                                                                $medicine_list = $this->medicine_model->getInternalMedicineById($category_name3[4]);
                                                                $medicine = $this->medicine_model->getMedicineById($medicine_list->medicine_id);
                                                                ?>
                                                                <option value="<?php echo $medicine->id . '*' . (float) $medicine->s_price . '*' . $medicine->name . '*' . $medicine->company . '*' . $medicine->box; ?>" data-qtity="<?php echo $category_name3[2]; ?>" selected="selected">
                                                                    <?php echo $medicine->name; ?>
                                                                </option>                

                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                <?php } ?>

                                            <?php } ?>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 qfloww"><p class="title"><?php echo lang('selected_items'); ?></p></div>
                            <div class="col-md-4 right-six">
                                <div class="col-md-12 payment right-six">
                                    <div class="col-md-3 payment_label"> 
                                        <label for="exampleInputEmail1"> <?php echo lang('sub_total'); ?></label>
                                    </div>
                                    <div class="col-md-9"> 
                                        <input type="text" class="form-control pay_in" name="subtotal" id="subtotal" value='<?php
                                        if (!empty($internal_requisition->amount)) {

                                            echo $internal_requisition->amount;
                                        }
                                        ?>' placeholder=" " disabled>
                                    </div>

                                </div>
                                <!--     <div class="col-md-12 payment right-six">
                                         <div class="col-md-3 payment_label"> 
                                             <label for="exampleInputEmail1"> <?php echo lang('discount'); ?><?php
                                if ($discount_type == 'percentage') {
                                    echo ' (%)';
                                }
                                ?> </label>
                                         </div>
                                         <div class="col-md-9"> 
                                             <input type="text" class="form-control pay_in" name="discount" id="dis_id" value='<?php
                                if (!empty($internal_requisition->discount)) {
                                    $discount = explode('*', $internal_requisition->discount);
                                    echo $discount[0];
                                }
                                ?>' placeholder="Discount">
                                         </div>
                                     </div>
                                  
                                     <div class="col-md-12 payment right-six">
                                         <div class="col-md-3 payment_label"> 
                                             <label for="exampleInputEmail1"> <?php echo lang('gross_total'); ?></label>
                                         </div>
                                         <div class="col-md-9"> 
                                             <input type="text" class="form-control pay_in" name="grsss" id="gross" value='<?php
                                if (!empty($internal_requisition->gross_total)) {

                                    echo $internal_requisition->gross_total;
                                } else {
                                    echo '0';
                                }
                                ?>' placeholder=" " disabled>
                                         </div>
     
                                     </div>-->


                                <div class="col-md-12 payment right-six">
                                    <div class="col-md-12">
                                        <div class="col-md-3"> 
                                        </div>  
                                        <div class="col-md-6 pull-right"> 
                                            <button type="submit" name="submit" class="btn btn-info"> <?php echo lang('submit'); ?></button>
                                        </div>
                                        <div class="col-md-3"> 
                                        </div> 
                                    </div>
                                </div>


                                <input type="hidden" name="id" value='<?php
                                if (!empty($internal_requisition->id)) {
                                    echo $internal_requisition->id;
                                }
                                ?>'>
                                <div class="row">
                                </div>
                                <div class="form-group">
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </section>
</section>
<!--main content end-->
<!--footer start-->

<script src="common/js/codearistos.min.js"></script>


<style>

    .remove {
        margin: 27px;
        width: 50%;
        background: #f1f1f1 !important;
        float: right;
        margin: -25px 0px;
        border: 1px solid #eee;
    }


    .remove1 {
        margin-top: 10px;
        background: #fff; 
        color: #000;
        padding: 5px;
        box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    }


</style>

<script>
    $(document).ready(function () {
        var tot = 0;
        var selected = $('#my_multi_select4').find('option:selected');
        var unselected = $('#my_multi_select4').find('option:not(:selected)');
        selected.attr('data-selected', '1');
        $.each(unselected, function (index, value1) {
            if ($(this).attr('data-selected') == '1') {
                var value = $(this).val();
                var res = value.split("*");
                // var unit_price = res[1];
                var id = res[0];
                $('#id-div' + id).remove();
                $('#idinput-' + id).remove();
                $('#mediidinput-' + id).remove();
                // $('#removediv' + $(this).val() + '').remove();
                //this option was selected before

            }
        });

        $.each($('select.multi-select1 option:selected'), function () {
            var value = $(this).val();
            var res = value.split("*");
            var unit_price = res[1];
            var id = res[0];
            var qtity = $(this).data('qtity');
            if ($('#idinput-' + id).length)
            {

            } else {
                if ($('#id-div' + id).length)
                {

                } else {

                    $("#editPaymentForm .qfloww").append('<div class="remove1" id="id-div' + id + '"><div class="name pos_element"> Name: ' + res[2] + '</div><div class="company pos_element">Company: ' + res[3] + '</div><div class="price pos_element">price: ' + res[1] + '</div><div class="quantity pos_element">quantity:<div></div>')
                }
                var input2 = $('<input>').attr({
                    type: 'text',
                    class: "remove",
                    id: 'idinput-' + id,
                    name: 'quantity[]',
                    value: qtity,
                }).appendTo('#editPaymentForm .qfloww');

                $('<input>').attr({
                    type: 'hidden',
                    class: "remove",
                    id: 'mediidinput-' + id,
                    name: 'medicine_id[]',
                    value: id,
                }).appendTo('#editPaymentForm .qfloww');
            }
            $(document).ready(function () {
                $('#idinput-' + id).keyup(function () {
                    var qty = 0;
                    var total = 0;
                    $.each($('select.multi-select1 option:selected'), function () {
                        var value = $(this).val();
                        var res = value.split("*");
                        // var unit_price = res[1];
                        var id1 = res[0];
                        qty = $('#idinput-' + id1).val();
                        var ekokk = res[1];
                        total = total + qty * ekokk;
                    });
                    tot = total;
                    var discount = $('#dis_id').val();
                    var gross = tot - discount;
                    $('#editPaymentForm').find('[name="subtotal"]').val(tot).end()
                    $('#editPaymentForm').find('[name="grsss"]').val(gross)
                });
            });
            var curr_val = res[1] * $('#idinput-' + id).val();
            tot = tot + curr_val;
        });
        var discount = $('#dis_id').val();
        var gross = tot - discount;
        $('#editPaymentForm').find('[name="subtotal"]').val(tot).end()
        $('#editPaymentForm').find('[name="grsss"]').val(gross)
        //  });
    });
    $(document).ready(function () {
        $('#dis_id').keyup(function () {
            var val_dis = 0;
            var amount = 0;
            var ggggg = 0;
            amount = $('#subtotal').val();
            val_dis = this.value;
            ggggg = amount - val_dis;
            $('#editPaymentForm').find('[name="grsss"]').val(ggggg)
        });
    });

</script> 



<script>
    $(document).ready(function () {
        $('.multi-select1').change(function () {
            var tot = 0;
            var selected = $('#my_multi_select4').find('option:selected');
            var unselected = $('#my_multi_select4').find('option:not(:selected)');
            selected.attr('data-selected', '1');
            $.each(unselected, function (index, value1) {
                if ($(this).attr('data-selected') == '1') {
                    var value = $(this).val();
                    var res = value.split("*");
                    // var unit_price = res[1];
                    var id = res[0];
                    $('#id-div' + id).remove();
                    $('#idinput-' + id).remove();
                    $('#mediidinput-' + id).remove();
                    // $('#removediv' + $(this).val() + '').remove();
                    //this option was selected before

                }
            });
            $.each($('select.multi-select1 option:selected'), function () {
                var value = $(this).val();
                var res = value.split("*");
                var unit_price = res[1];
                var id = res[0];
                if ($('#idinput-' + id).length)
                {

                } else {
                    if ($('#id-div' + id).length)
                    {

                    } else {

                        $("#editPaymentForm .qfloww").append('<div class="remove1" id="id-div' + id + '"><div class="name pos_element"> Name: ' + res[2] + '</div><div class="company pos_element">Company: ' + res[3] + '</div><div class="price pos_element">price: ' + res[1] + '</div><div class="quantity pos_element">quantity:<div></div>')
                    }
                    var input2 = $('<input>').attr({
                        type: 'text',
                        class: "remove",
                        id: 'idinput-' + id,
                        name: 'quantity[]',
                        value: '1',
                    }).appendTo('#editPaymentForm .qfloww');

                    $('<input>').attr({
                        type: 'hidden',
                        class: "remove",
                        id: 'mediidinput-' + id,
                        name: 'medicine_id[]',
                        value: id,
                    }).appendTo('#editPaymentForm .qfloww');
                }

                $(document).ready(function () {
                    $('#idinput-' + id).keyup(function () {
                        var qty = 0;
                        var total = 0;
                        $.each($('select.multi-select1 option:selected'), function () {
                            var value = $(this).val();
                            var res = value.split("*");
                            // var unit_price = res[1];
                            var id1 = res[0];
                            qty = $('#idinput-' + id1).val();
                            var ekokk = res[1];
                            total = total + qty * ekokk;
                        });

                        tot = total;

                        var discount = $('#dis_id').val();
                        var gross = tot - discount;
                        $('#editPaymentForm').find('[name="subtotal"]').val(tot).end()
                        $('#editPaymentForm').find('[name="grsss"]').val(gross)
                    });
                });
                var curr_val = res[1] * $('#idinput-' + id).val();
                tot = tot + curr_val;
            });
            var discount = $('#dis_id').val();
            var gross = tot - discount;
            $('#editPaymentForm').find('[name="subtotal"]').val(tot).end()
            $('#editPaymentForm').find('[name="grsss"]').val(gross)
        });
    });
    $(document).ready(function () {
        $('#dis_id').keyup(function () {
            var val_dis = 0;
            var amount = 0;
            var ggggg = 0;
            amount = $('#subtotal').val();
            val_dis = this.value;
<?php if ($discount_type == 'percentage') { ?>
                ggggg = amount - amount * val_dis / 100;
<?php } ?>
<?php if ($discount_type == 'flat') { ?>
                ggggg = amount - val_dis;
<?php } ?>
            $('#editPaymentForm').find('[name="grsss"]').val(ggggg)
        });
    });

</script> 
<?php if (!$this->ion_auth->in_group(array('admin'))) { ?>
    <script>
        $(document).ready(function () {


            $("#my_multi_select4").select2({
                placeholder: '<?php echo lang('medicine'); ?>',
                multiple: true,
                allowClear: true,
                ajax: {
                    url: 'medicine/getMedicineForInternalMedicineByDepartment',
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            searchTerm: params.term // search term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }

            });
        });</script>

<?php } else { ?>
    <script>
        $(document).ready(function () {
            $('#department').change(function () {
                var department = $(this).val();
                var selected = $('#my_multi_select4').find('option:selected');
                var unselected = $('#my_multi_select4').find('option:not(:selected)');
                selected.attr('data-selected', '1');
                $.each(selected, function (index, value1) {
                    if ($(this).attr('data-selected') == '1') {
                        var value = $(this).val();
                        var res = value.split("*");
                        // var unit_price = res[1];
                        var id = res[0];
                        $('#id-div' + id).remove();
                        $('#idinput-' + id).remove();
                        $('#mediidinput-' + id).remove();
                        // $('#removediv' + $(this).val() + '').remove();
                        //this option was selected before

                    }
                });
                $('#editPaymentForm').find('[name="subtotal"]').val('0').end()
                $("#my_multi_select4").val(null).trigger("change");

                $.ajax({
                    url: 'medicine/getMedicineByDepartmentWiseForAdmin?id=' + department,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                }).success(function (response) {
                    $('#my_multi_select4').append(response.option);
                })
            })
        })
    </script>
<?php } ?>


<script src="common/js/codearistos.min.js"></script>
<script>
            $(document).ready(function () {
                $(".flashmessage").delay(3000).fadeOut(100);
            });
</script>