
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <?php
        $group_permission = $this->ion_auth->get_users_groups()->row();

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
        foreach ($permission_access_group_explode as $perm) {
            $perm_explode = array();
            $perm_explode = explode(",", $perm);
            if (in_array('2', $perm_explode) && $perm_explode[0] == 'Lab') {
                $permis = 'ok';
                //  break;
            }
            if (in_array('3', $perm_explode) && $perm_explode[0] == 'Lab') {
                $permis_2 = 'ok';
                //  break;
            }
        }
        ?>

        <?php if ($this->ion_auth->in_group(array('admin', 'Doctor', 'Laboratorist')) || $permis == 'ok') { ?>
            <section class="col-md-5 no-print">
                <header class="panel-heading no-print">
                    <?php
                    if (!empty($lab_single->id))
                        echo lang('edit_lab_report');
                    else
                        echo lang('add_lab_report');
                    ?>
                </header>
                <div class="no-print">
                    <div class="adv-table editable-table ">
                        <div class="clearfix">
                            <style> 
                                .lab{
                                    padding-top: 10px;
                                    padding-bottom: 20px;
                                    border: none;

                                }
                                .pad_bot{
                                    padding-bottom: 5px;
                                }  

                                form{
                                    background: #ffffff;
                                    padding: 20px 0px;
                                }

                                .modal-body form{
                                    background: #fff;
                                    padding: 21px;
                                }

                                .remove{
                                    float: right;
                                    margin-top: -45px;
                                    margin-right: 42%;
                                    margin-bottom: 41px;
                                    width: 94px;
                                    height: 29px;
                                }

                                .remove1 span{
                                    width: 33%;
                                    height: 50px !important;
                                    padding: 10px

                                }

                                .qfloww {
                                    padding: 10px 0px;
                                    height: 370px;
                                    background: #f1f2f9;
                                    overflow: auto;
                                }

                                .remove1 {
                                    background: #5A9599;
                                    color: #fff;
                                    padding: 5px;
                                }


                                .span2{
                                    padding: 6px 12px;
                                    font-size: 14px;
                                    font-weight: 400;
                                    line-height: 1;
                                    color: #555;
                                    text-align: center;
                                    background-color: #eee;
                                    border: 1px solid #ccc
                                }

                            </style>

                            <form role="form" id="editLabForm" class="clearfix" action="lab/addLab" method="post" enctype="multipart/form-data">

                                <div class="">
                                    <div class="col-md-6 lab pad_bot">
                                        <label for="exampleInputEmail1"><?php echo lang('date'); ?></label>
                                        <input type="text" class="form-control pay_in default-date-picker" name="date" value='<?php
                                        if (!empty($lab_single->date)) {
                                            echo date('d-m-Y', $lab_single->date);
                                        } else {
                                            echo date('d-m-Y');
                                        }
                                        ?>' placeholder="">
                                    </div>

                                    <div class="col-md-6 lab pad_bot">
                                        <label for="exampleInputEmail1"><?php echo lang('patient'); ?></label>
                                        <select class="form-control m-bot15 pos_select" id="pos_select" name="patient" value=''> 
                                            <?php if (!empty($lab_single->patient)) { ?>
                                                <option value="<?php echo $patients->id; ?>" selected="selected"><?php echo $patients->name; ?> - <?php echo $patients->id; ?></option>  
                                            <?php } ?>
                                        </select>
                                    </div> 

                                    <div class="col-md-8 panel"> 
                                    </div>

                                    <div class="pos_client">
                                        <div class="col-md-8 lab pad_bot">
                                            <div class="col-md-3 lab_label"> 
                                                <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('name'); ?></label>
                                            </div>
                                            <div class="col-md-9"> 
                                                <input type="text" class="form-control pay_in" name="p_name" value='<?php
                                                if (!empty($lab_single->p_name)) {
                                                    echo $lab_single->p_name;
                                                }
                                                ?>' placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-8 lab pad_bot">
                                            <div class="col-md-3 lab_label"> 
                                                <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('email'); ?></label>
                                            </div>
                                            <div class="col-md-9"> 
                                                <input type="text" class="form-control pay_in" name="p_email" value='<?php
                                                if (!empty($lab_single->p_email)) {
                                                    echo $lab_single->p_email;
                                                }
                                                ?>' placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-8 lab pad_bot">
                                            <div class="col-md-3 lab_label"> 
                                                <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('phone'); ?></label>
                                            </div>
                                            <div class="col-md-9"> 
                                                <input type="text" class="form-control pay_in" name="p_phone" value='<?php
                                                if (!empty($lab_single->p_phone)) {
                                                    echo $lab_single->p_phone;
                                                }
                                                ?>' placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-8 lab pad_bot">
                                            <div class="col-md-3 lab_label"> 
                                                <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('age'); ?></label>
                                            </div>
                                            <div class="col-md-9"> 
                                                <input type="text" class="form-control pay_in" name="p_age" value='<?php
                                                if (!empty($lab_single->p_age)) {
                                                    echo $lab_single->p_age;
                                                }
                                                ?>' placeholder="">
                                            </div>
                                        </div> 
                                        <div class="col-md-8 lab pad_bot">
                                            <div class="col-md-3 lab_label"> 
                                                <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('gender'); ?></label>
                                            </div>
                                            <div class="col-md-9"> 
                                                <select class="form-control m-bot15" name="p_gender" value=''>

                                                    <option value="Male" <?php
                                                    if (!empty($patient->sex)) {
                                                        if ($patient->sex == 'Male') {
                                                            echo 'selected';
                                                        }
                                                    }
                                                    ?> > Male </option>   
                                                    <option value="Female" <?php
                                                    if (!empty($patient->sex)) {
                                                        if ($patient->sex == 'Female') {
                                                            echo 'selected';
                                                        }
                                                    }
                                                    ?> > Female </option>
                                                    <option value="Others" <?php
                                                    if (!empty($patient->sex)) {
                                                        if ($patient->sex == 'Others') {
                                                            echo 'selected';
                                                        }
                                                    }
                                                    ?> > Others </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 lab pad_bot">
                                        <label for="exampleInputEmail1"> <?php echo lang('refd_by_doctor'); ?></label> 
                                        <select class="form-control m-bot15  add_doctor" id="add_doctor" name="doctor" value=''>  
                                            <?php if (!empty($lab_single->doctor)) { ?>
                                                <option value="<?php echo $doctors->id; ?>" selected="selected"><?php echo $doctors->name; ?> - <?php echo $doctors->id; ?></option>  
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6 lab pad_bot">
                                        <label for="exampleInputEmail1">
                                            <?php echo lang('template'); ?>
                                        </label>
                                        <select class="form-control m-bot15 js-example-basic-multiple template" id="template" name="template" value=''> 
                                            <option value="">Select .....</option>
                                            <?php foreach ($templates as $template) { ?>
                                                <option value="<?php echo $template->id; ?>"><?php echo $template->name; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 lab pad_bot">
                                        <label for="exampleInputEmail1">
                                            <?php echo lang('laboratorist'); ?>
                                        </label>
                                        <?php
                                        if (empty($lab_single)) {
                                            if ($this->ion_auth->in_group(array('Laboratorist'))) {
                                                $user = $this->ion_auth->get_user_id();
                                                $lab_single_login = $this->db->get_where('laboratorist', array('ion_user_id' => $user))->row();
                                                ?>
                                                <select class="form-control m-bot15 js-example-basic-single" id="" name="laboratorist" value=''> 
                                                    <option value="<?php echo $lab_single_login->id; ?>" <?php
                                                    if (!empty($lab->laboratorist)) {
                                                        if ($lab_single_login->id == $lab_single->laboratorist) {
                                                            echo 'selected';
                                                        }
                                                    }
                                                    ?>><?php echo $lab_single_login->name; ?> - <?php echo $lab_single_login->id; ?></option>
                                                </select>
                                            <?php } else { ?>
                                                <select class="form-control m-bot15 laboratorist" id="laboratorist-select" name="laboratorist" value=''> 


                                                </select>
                                            <?php } ?>
                                        <?php } else { ?> 
                                            <?php
                                            if (empty($lab_single->to_be_id)) {
                                                if ($this->ion_auth->in_group(array('Laboratorist'))) {
                                                    $user = $this->ion_auth->get_user_id();
                                                    $lab_single_login = $this->db->get_where('laboratorist', array('ion_user_id' => $user))->row();
                                                    ?>
                                                    <select class="form-control m-bot15 js-example-basic-single" id="" name="laboratorist" value=''> 
                                                        <option value="<?php echo $lab_single_login->id; ?>" <?php
                                                        if (!empty($lab->laboratorist)) {
                                                            if ($lab_single_login->id == $lab_single->laboratorist) {
                                                                echo 'selected';
                                                            }
                                                        }
                                                        ?>><?php echo $lab_single_login->name; ?> - <?php echo $lab_single_login->id; ?></option>
                                                    </select>
                                                <?php } else {
                                                    ?>
                                                    <select class="form-control m-bot15 laboratorist" id="laboratorist-select" name="laboratorist" value=''> 
                                                        <?php if (!empty($lab_single->laboratorist)) { ?>
                                                            <option value="<?php echo $laboratorist->id; ?>" selected="selected" disabled=""><?php echo $laboratorist->name; ?> - <?php echo $laboratorist->id; ?></option>  
                                                        <?php } ?>

                                                    </select>
                                                <?php } ?>
                                                <?php
                                            } else {
                                                $lab_payment_category = explode("-", $lab_single->to_be_id);
                                                $category_payment_procccedures = $this->db->get_where('payment_category', array('id' => $lab_payment_category[3]))->row()->type;
                                                ?>
                                                <select class="form-control m-bot15 js-example-basic-single" id="" name="laboratorist" value=''> 
                                                    <?php
                                                    if ($this->ion_auth->in_group(array('Laboratorist'))) {
                                                        $user = $this->ion_auth->get_user_id();
                                                        $lab_single_login = $this->db->get_where('laboratorist', array('ion_user_id' => $user))->row();
                                                        ?>
                                                        <option value="<?php echo $lab_single_login->id; ?>" <?php
                                                        if (!empty($lab->laboratorist)) {
                                                            if ($lab_single_login->id == $lab_single->laboratorist) {
                                                                echo 'selected';
                                                            }
                                                        }
                                                        ?>><?php echo $lab_single_login->name; ?> - <?php echo $lab_single_login->id; ?></option>
                                                                <?php
                                                            } else {
                                                                foreach ($laboratorists as $laboratorist_single) {

                                                                    $category_laboratorist = array();
                                                                    $category_laboratorist = explode("***", $laboratorist_single->category);


                                                                    if (!empty($category_laboratorist)) {
                                                                        if (in_array($category_payment_procccedures, $category_laboratorist)) {
                                                                            ?>
                                                                    <option value="<?php echo $laboratorist_single->id; ?>" <?php
                                                                    if (!empty($lab->laboratorist)) {
                                                                        if ($laboratorist_single->id == $lab_single->laboratorist) {
                                                                            echo 'selected';
                                                                        }
                                                                    }
                                                                    ?>><?php echo $laboratorist_single->name; ?> - <?php echo $laboratorist_single->id; ?></option>  
                                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                                ?>


                                                    </select>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        <?php } ?>
                                    </div>
                                    <div class="pos_doctor">
                                        <div class="col-md-8 lab pad_bot">
                                            <div class="col-md-3 lab_label"> 
                                                <label for="exampleInputEmail1"> <?php echo lang('doctor'); ?> <?php echo lang('name'); ?></label>
                                            </div>
                                            <div class="col-md-9"> 
                                                <input type="text" class="form-control pay_in" name="d_name" value='<?php
                                                if (!empty($lab_single->p_name)) {
                                                    echo $lab_single->p_name;
                                                }
                                                ?>' placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-8 lab pad_bot">
                                            <div class="col-md-3 lab_label"> 
                                                <label for="exampleInputEmail1"> <?php echo lang('doctor'); ?> <?php echo lang('email'); ?></label>
                                            </div>
                                            <div class="col-md-9"> 
                                                <input type="text" class="form-control pay_in" name="d_email" value='<?php
                                                if (!empty($lab_single->p_email)) {
                                                    echo $lab_single->p_email;
                                                }
                                                ?>' placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-8 lab pad_bot">
                                            <div class="col-md-3 lab_label"> 
                                                <label for="exampleInputEmail1"> <?php echo lang('doctor'); ?> <?php echo lang('phone'); ?></label>
                                            </div>
                                            <div class="col-md-9"> 
                                                <input type="text" class="form-control pay_in" name="d_phone" value='<?php
                                                if (!empty($lab_single->p_phone)) {
                                                    echo $lab_single->p_phone;
                                                }
                                                ?>' placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-8 panel">
                                    </div>



                                </div>









                                <div class="col-md-12 lab pad_bot">
                                    <label for="exampleInputEmail1"> <?php echo lang('report'); ?></label>
                                    <textarea class="ckeditor form-control" id="editor" name="report" value="" rows="10"><?php
                                        if (!empty($setval)) {
                                            echo set_value('report');
                                        }
                                        if (!empty($lab_single->report)) {
                                            echo $lab_single->report;
                                        }
                                        ?>
                                    </textarea>
                                </div>

                                <input type="hidden" name="redirect" value="<?php
                                if (!empty($lab_single)) {
                                    echo 'lab?id=' . $lab_single->id;
                                } else {
                                    echo 'lab';
                                }
                                ?>">

                                <input type="hidden" name="id" value='<?php
                                if (!empty($lab_single->id)) {
                                    echo $lab_single->id;
                                }
                                ?>'>


                                <div class="col-md-12 lab"> 
                                    <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>



            </section>

        <?php } ?>






        <?php if ($this->ion_auth->in_group(array('admin', 'Doctor', 'Laboratorist')) || $permis == 'ok') { ?>
            <section class="col-md-7">
            <?php } else { ?>  <section class="col-md-12"> <?php } ?>
                <header class="panel-heading">
                    <?php echo lang('lab_report'); ?>
                    <?php if ($this->ion_auth->in_group(array('admin', 'Doctor', 'Laboratorist')) || $permis == 'ok') { ?>
                        <div class="col-md-4 no-print pull-right"> 
                            <a href="lab/addLabView">
                                <div class="btn-group pull-right">
                                    <button id="" class="btn green btn-xs">
                                        <i class="fa fa-plus-circle"></i> <?php echo lang('add_lab_report'); ?>
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
                                    <th><?php echo lang('report_id'); ?></th>
                                    <th><?php echo lang('patient'); ?></th>
                                    <th><?php echo lang('date'); ?></th>
                                    <?php //if ($this->ion_auth->in_group(array('admin', 'Doctor', 'Laboratorist')) || $permis == 'ok' || $permis_2 == 'ok') {   ?>
                                    <th class=""><?php echo lang('options'); ?></th>
                                    <?php //}     ?>
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
                                .option_th{
                                    width:18%;
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
            $(".flashmessage").delay(3000).fadeOut(100);
        });
    </script>


    <script>
        $(document).ready(function () {
            var table = $('#editable-sample').DataTable({
                responsive: true,

                "processing": true,
                "serverSide": true,
                "searchable": true,
                "ajax": {
                    url: "lab/getLab",
                    type: 'POST',
                },
                scroller: {
                    loadingIndicator: true
                },

                dom: "<'row'<'col-sm-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",

                buttons: [
                    {extend: 'copyHtml5', exportOptions: {columns: [0, 1, 2], }},
                    {extend: 'excelHtml5', exportOptions: {columns: [0, 1, 2], }},
                    {extend: 'csvHtml5', exportOptions: {columns: [0, 1, 2], }},
                    {extend: 'pdfHtml5', exportOptions: {columns: [0, 1, 2], }},
                    {extend: 'print', exportOptions: {columns: [0, 1, 2], }},
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
                    searchPlaceholder: "Search..."
                }
            });
            table.buttons().container().appendTo('.custom_buttons');
        });
    </script>





    <script>
        $(document).ready(function () {
            $('.pos_client').hide();
            $(document.body).on('change', '#pos_select', function () {

                var v = $("select.pos_select option:selected").val()
                if (v == 'add_new') {
                    $('.pos_client').show();
                } else {
                    $('.pos_client').hide();
                }
            });

        });


    </script>

    <script>
        $(document).ready(function () {
            $('.pos_doctor').hide();
            $(document.body).on('change', '#add_doctor', function () {

                var v = $("select.add_doctor option:selected").val()
                if (v == 'add_new') {
                    $('.pos_doctor').show();
                } else {
                    $('.pos_doctor').hide();
                }
            });

        });


    </script>



    <script type="text/javascript">
        $(document).ready(function () {
            $(document.body).on('change', '#template', function () {
                var iid = $("select.template option:selected").val();
                $.ajax({
                    url: 'lab/getTemplateByIdByJason?id=' + iid,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                }).success(function (response) {
                    var data = CKEDITOR.instances.editor.getData();
                    if (response.template.template != null) {
                        var data1 = data + response.template.template;
                    } else {
                        var data1 = data;
                    }
                    CKEDITOR.instances['editor'].setData(data1)
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $("#pos_select").select2({
                placeholder: '<?php echo lang('select_patient'); ?>',
                allowClear: true,
                ajax: {
                    url: 'patient/getPatientinfoWithAddNewOption',
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

            $("#add_doctor").select2({
                placeholder: '<?php echo lang('select_doctor'); ?>',
                allowClear: true,
                ajax: {
                    url: 'doctor/getDoctorWithAddNewOption',
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
            $("#laboratorist-select").select2({
                placeholder: '<?php echo lang('select_laboratorist'); ?>',
                allowClear: true,
                ajax: {
                    url: 'lab/getLaboratoristinfo',
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

        });
    </script>
