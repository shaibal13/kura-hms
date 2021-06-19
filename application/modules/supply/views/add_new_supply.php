<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <?php
        /* $group_permission = $this->ion_auth->get_users_groups()->row();

          if ($group_permission->name == 'admin' || $group_permission->name == 'Patient' || $group_permission->name == 'Doctor' || $group_permission->name == 'Nurse' || $group_permission->name == 'Pharmacist' || $group_permission->name == 'Laboratorist' || $group_permission->name == 'Accountant' || $group_permission->name == 'Receptionist' || $group_permission->name == 'members') {

          $pers = array();
          $permission_access_group_explode = array();
          } else {
          $pers = explode(',', $group_permission->description);

          $this->db->where('group_id', $group_permission->id);
          $query = $this->db->get('permission_access_group')->row();
          $permission_access_group = $query->permission_access;
          $permission_access_group_explode = explode('***', $permission_access_group);
          }
          $permis = '';
          $permis_2 = '';
          $permis_1 = '';
          foreach ($permission_access_group_explode as $perm) {
          $perm_explode = array();
          $perm_explode = explode(",", $perm);
          if (in_array('2', $perm_explode) && $perm_explode[0] == 'Finance') {
          $permis = 'ok';
          //  break;
          }
          if (in_array('3', $perm_explode) && $perm_explode[0] == 'Finance') {
          $permis_2 = 'ok';
          //  break;
          }
          if (in_array('1', $perm_explode) && $perm_explode[0] == 'Finance') {
          $permis_1 = 'ok';
          //  break;
          }
          } */
        ?>
        <section class="">
            <header class="panel-heading">
                <?php
                if (!empty($payment->id))
                    echo lang('edit_supply');
                else
                    echo lang('add_new_supply');
                ?>
            </header>
            <div class="">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <!--  <div class="col-lg-12"> -->
                        <div class="">
                           <!--   <section class="panel"> -->
                            <section class="">
                                <!--   <div class="panel-body"> -->
                                <div class="">
                                    <style> 
                                        .payment{
                                            padding-top: 10px;
                                            padding-bottom: 0px;
                                            border: none;

                                        }
                                        .pad_bot{
                                            padding-bottom: 5px;
                                        }  

                                        form{
                                            background: #f1f1f1;
                                            padding: 15px 0px;
                                        }

                                        .modal-body form{
                                            background: #fff;
                                            padding: 21px;
                                        }

                                        .remove{
                                            width: 20%;
                                            float: right;
                                            margin-bottom: 10px;
                                            padding: 10px;
                                            height: 39px;
                                            text-align: center;
                                            border-bottom: 1px solid #f1f1f1;
                                        }

                                        .remove1{
                                            width: 80%;
                                            float: left;
                                            margin-bottom: 10px;
                                            border-bottom: 1px solid #f1f1f1;
                                        }

                                        form input {
                                            border: none;
                                        }

                                        .pos_box_title{
                                            border: none;
                                        }

                                        .payment_label {
                                            text-align: left;
                                        }

                                    </style>

                                    <form role="form" id="editSupplyForm" class="clearfix" action="supply/addSupply" method="post" enctype="multipart/form-data">

                                        <div class="col-md-5 row">
                                            <div class="col-md-12"> 
                                                <div class="form-group col-md-6"> 
                                                <label for="exampleInputEmail1"> <?php echo lang('vendor_name'); ?></label>
                                                <input type="text" class="form-control" name="vendor_name" id="exampleInputEmail1" value='<?php if(!empty($supply)){
                                                    echo $supply->vendor_name;
                                                }?>' placeholder="" required="">
                                            </div>
                                                  <div class="form-group col-md-6"> 
                                                <label for="exampleInputEmail1"> <?php echo lang('address'); ?></label>
                                                <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='<?php if(!empty($supply)){
                                                    echo $supply->address;
                                                }?>' placeholder="" required="">
                                            </div>
                                                  <div class="form-group col-md-6"> 
                                                <label for="exampleInputEmail1"> <?php echo lang('phone'); ?></label>
                                                <input type="text" class="form-control" name="phone" id="exampleInputEmail1" value='<?php if(!empty($supply)){
                                                    echo $supply->phone;
                                                }?>' placeholder="" required="">
                                            </div>
                                                 <div class="form-group col-md-6"> 
                                                <label for="exampleInputEmail1"> <?php echo lang('nipt'); ?></label>
                                                <input type="text" class="form-control" name="nipt" id="exampleInputEmail1" value='<?php if(!empty($supply)){
                                                    echo $supply->nipt;
                                                }?>' placeholder="" required="">
                                            </div>
                                            </div>
                                            <div class="col-md-12 payment">
                                                <div class="form-group last"> 
                                                    <label for="exampleInputEmail1"> <?php echo lang('select'); ?></label>
                                                    <select name="medicine_id[]" id="" class="multi-select" multiple="" id="my_multi_select3" required="" >
                                                        <?php foreach ($medicines as $medicine) { ?>
                                                            <option class="ooppttiioonn"  data-idd="<?php echo $medicine->id; ?>" data-name="<?php echo $medicine->name; ?>" value="<?php echo $medicine->id; ?>"><?php echo $medicine->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                            </div>

                                        </div>


                                        <div class="col-md-4">


                                            <div class="col-md-12 qfloww">

                                                <label class=" col-md-10 pull-left remove1"><?php echo lang('items') ?></label><label class="pull-right col-md-2 remove"><?php echo lang('qty') ?></label>


                                            </div>
                                            <div class="form-group">
                                                <button type="submit" style="width:100%; margin: 0px !important;" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                                            </div>

                                        </div>
                                       
                                        <input type="hidden" name="id" value='<?php
                                        if (!empty($supply->id)) {
                                            echo $supply->id;
                                        }
                                        ?>'>
                                        <div class="row">
                                        </div>
                                        <div class="form-group">
                                        </div>


                                </div>
                                </form>





                        </div>
                        </section>
                    </div>
                </div>
            </div>
            </div>
        </section>

    </section>
</section>
<!--main content end-->
<!--footer start-->

<script src="common/js/codearistos.min.js"></script>
<script>

    $(document).ready(function () {

        $('.multi-select').change(function () {

            $(".ms-selected").click(function () {
                var idd = $(this).data('idd');
                $('#id-div' + idd).remove();
                $('#idinput-' + idd).remove();
                $('#categoryinput-' + idd).remove();

            });
            $.each($('select.multi-select option:selected'), function () {

                var idd = $(this).data('idd');
                //  tot = tot + curr_val;

                if ($('#idinput-' + idd).length)
                {

                } else {
                    if ($('#id-div' + idd).length)
                    {

                    } else {
                        $("#editSupplyForm .qfloww").append('<div class="remove1" id="id-div' + idd + '">  ' + $(this).data("name") + '</div>')
                    }


                    var input2 = $('<input>').attr({
                        type: 'text',
                        class: "remove",
                        id: 'idinput-' + idd,
                        min: '1',
                        name: 'quantity[]',
                        value: '1'

                    }).appendTo('#editSupplyForm .qfloww');

                    $('<input>').attr({
                        type: 'hidden',
                        class: "remove",
                        id: 'categoryinput-' + idd,
                        name: 'category_id[]',
                        value: idd,
                    }).appendTo('#editSupplyForm .qfloww');
                }
  $(document).ready(function () {
                    $('#idinput-' + idd).keyup(function () {
                     if ($(this).val() < 1){
    
                         $(this).val('1');
  }
                    });
                });



            });




        });
    });
</script>