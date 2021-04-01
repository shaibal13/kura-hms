<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-8 row">
            <header class="panel-heading">
                <?php
                if (!empty($package->id))
                    echo lang('edit_package');
                else
                    echo lang('add_new_package');
                ?>
            </header>
            <style>
                .separator {
                    display: flex;
                    align-items: center;
                    text-align: center;
                }

                .separator::before,
                .separator::after {
                    content: '';
                    flex: 1;
                    border-bottom: 1px solid #000;
                }

                .separator:not(:empty)::before {
                    margin-right: .25em;
                }

                .separator:not(:empty)::after {
                    margin-left: .25em;
                }
                .input-category{
                    border: none !important;
                }
                .price-indivudual{
                    border: none !important;
                }
            </style>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <?php echo validation_errors(); ?>
                        <form role="form" id="packages_add" action="packages/addPackage" class="clearfix" method="post" enctype="multipart/form-data">
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"><?php echo lang('code'); ?></label>
                                <input type="text" class="form-control" name="code" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('code');
                                }
                                if (!empty($package->code)) {
                                    echo $package->code;
                                }
                                ?>' placeholder="">
                            </div>
                            <div class="form-group  col-md-4">
                                <label for="exampleInputEmail1"><?php echo lang('name'); ?></label>
                                <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('name');
                                }
                                if (!empty($package->name)) {
                                    echo $package->name;
                                }
                                ?>' placeholder="" required="">
                            </div>
                            <div class="form-group  col-md-4">
                                <label for="exampleInputEmail1"><?php echo lang('price'); ?></label>
                                <input type="text" class="form-control" name="single_price" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('price');
                                }
                                if (!empty($package->single_price)) {
                                    echo $package->single_price;
                                }
                                ?>' placeholder="" required="">
                            </div>
                            <div class="adv-table editable-table ">
                                <table style="width: 100% !important;" class="table table-striped table-hover table-bordered" id="editable-table2">
                                    <thead>
                                        <tr>
                                            <th style="width: 20%;"><?php echo lang('category'); ?></th>
                                            <th style="width: 20%;"><?php echo lang('type'); ?></th>
                                            <th style="width: 20%;"><?php echo lang('value'); ?></th>


                                            <th style="width: 10%;" class="no-print"><?php echo lang('options'); ?></th>

                                        </tr>
                                    </thead>
                                    <tbody id="package_proccedure">
                                        <?php
                                        if (!empty($package->id)) {
                                            $cat_price = explode("##", $package->price_cat);
                                            foreach ($cat_price as $cat_individual) {

                                                $individual = array();
                                                $individual = explode("**", $cat_individual);
                                                ?>
                                                <tr class="proccedure" id="tr-<?php echo $individual[1] ?>">
                                                    <td> <?php echo $individual[3]; ?></td>
                                                    <td>
                                                        <input type="hidden" name="type_id[]" id="input_id-<?php echo $individual[1] ?>" value="<?php echo $individual[1] ?>" readonly>
                                                        <input type="text" class="input-category" name="type[]" id="input-<?php echo $individual[1]; ?>" value="<?php echo $individual[0]; ?>"> 
                                                    </td>
                                                    <td>
                                                        <input class="price-indivudual" type="text" name="price[]" style="width:100px;" id="price-<?php echo $individual[1]; ?>" value="<?php echo $individual[2]; ?>" >
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-info btn-xs btn_width delete_button" id="td-<?php echo $individual[1] ?>"><i class="fa fa-trash"> </i></button>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1"><?php echo lang('total_value'); ?></label>
                                <input type="text" class="form-control" name="total_value" id="total_value" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('total_value');
                                }
                                if (!empty($package->total_price)) {
                                    echo $package->total_price;
                                }
                                ?>' placeholder="" readonly="">
                            </div>

                            <div class="separator col-md-12"><?php echo lang('select'); ?></div>
                            <br>  <br>
                            <div class="col-md-12" style="margin-top:20px;">
                                <div class="col-md-5">

                                    <select style=" display: block;"class="form-control m-bot15 js-example-basic-single" id="category" name="category" value='' required=""> 
                                        <option><?php echo lang('select'); ?> <?php echo lang('category'); ?></option>
                                                <?php foreach ($categories as $category) { ?>
                                            <option value="<?php echo $category->id;
                                                    ?>"><?php echo $category->name; ?></option>
<?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-5">

                                    <select style="display: block;" class="form-control m-bot15 js-example-basic-single" id="payment_proccedure" name="payment_proccedure" value='' required=""> 

                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-info " id="add_type"><i class="fa fa-save"></i></button>

                                </div>
                            </div>
                            <input type="hidden" name="id" value='<?php
                            if (!empty($package->id)) {
                                echo $package->id;
                            }
                            ?>'>

                            <div class="form-group col-md-12" style="margin-top:20px;">
                                <button type="submit" id="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('add_package'); ?></button>
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
<script src="common/js/codearistos.min.js"></script>
<script src="common/toastr/js/toastr.js"></script>
<link rel="stylesheet" type="text/css" href="common/toastr/css/toastr.css">
<script>
    $(document).ready(function () {
        $('#category').change(function () {
            var id = $(this).val();

            $('#payment_proccedure').html("");
            $.ajax({
                url: 'packages/getPaymentProccedureByCategory?id=' + id,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                $('#payment_proccedure').html(response.option);
            })

        })
    })
</script>
<script>
    $(document).ready(function () {
        $('#add_type').click(function (e) {
            var proccedure_id = $('#payment_proccedure').val();
            if ($('table#editable-table2').find('#tr-' + proccedure_id).length > 0) {
                alert('Already in the List');
            } else {
                $.ajax({
                    url: 'packages/getTableTrValue?proccedure_id=' + proccedure_id,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                }).success(function (response) {
                    $('#package_proccedure').after(response.option);
                    var values = $("input[name^='price[]']").map(function (idx, ele) {
                        return $(ele).val();
                    }).get();
                    var sum = 0;
                    $.each(values, function (index, value) {
                        // alert(index + ": " + value);
                        var number = parseInt(value, 10);
                        sum += number;
                    });
                    $('#total_value').val(sum);
                })
            }
            e.preventDefault();
        })

    })
</script>

<script>
    $(document).ready(function () {
        $('#editable-table2').on('click', '.delete_button', function () {
            //  $('.delete_button').click(function () {
            // alert('sadas');
            var id = $(this).attr('id');
            var id_split = id.split("-");
            $('#tr-' + id_split[1]).remove();
            var values = $("input[name^='price[]']").map(function (idx, ele) {
                return $(ele).val();
            }).get();
          //  alert(values);
            var sum = 0;
            $.each(values, function (index, value) {
                // alert(index + ": " + value);
                var number = parseInt(value, 10);
                sum += number;
            });
            $('#total_value').val(sum);
        });
        /* $("#packages_add").submit(function (e) {
         var id = $(this).attr('id');
         alert(id);
         if (id === 'submit') {
         
         var dataString = $(this).serialize();
         // alert(dataString); return false;
         
         $.ajax({
         type: "POST",
         url: "packages/addPackage",
         data: dataString,
         success: function (response) {
         var data = jQuery.parseJSON(response);
         toastr.success(data.message.message);
         }
         });
         
         }else{
         e.preventDefault();
         }
         });*/

    })
</script>

