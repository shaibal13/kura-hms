<style>
    .hidden {
        visibility: none;
    }
</style>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-7 row">
            <header class="panel-heading ">
                <?php
                if (!empty($user->id))
                    echo lang('edit_user_information');
                else
                    echo lang('add_user_information');
                ?>
            </header>
            <div class="">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <div class="">
                            <section class="">
                                <div class="panel-body">
                                    <div class="col-lg-12">
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-6">
                                            <?php echo validation_errors(); ?>
                                        </div>
                                        <div class="col-lg-3"></div>
                                    </div>
                                    <form role="form" action="users/addNew" method="post" enctype="multipart/form-data">
                                        <div class="form-group"><label for="exampleInputEmail1"><?php echo lang('first_name'); ?></label>
                                            <input class="form-control" name="name" value="<?php
                                            if (!empty($user->id)) {
                                                echo $user->first_name;
                                            }
                                            ?>" required="">
                                        </div>
                                        <div class="form-group"><label for="exampleInputEmail1"><?php echo lang('last_name'); ?></label>
                                            <input class="form-control" name="last_name" value="<?php
                                            if (!empty($user->id)) {
                                                echo $user->last_name;
                                            }
                                            ?>" required="">
                                        </div>
                                        <div class="form-group"><label for="exampleInputEmail1"><?php echo lang('email'); ?></label>
                                            <input class="form-control" name="email" value="<?php
                                            if (!empty($user->id)) {
                                                echo $user->email;
                                            }
                                            ?>" required>
                                        </div>
                                        <div class="form-group"><label for="exampleInputEmail1"><?php echo lang('password'); ?></label>
                                            <input type="password" class="form-control" name="password" placeholder="******" >
                                        </div>
                                        <div class="form-group"><label for="exampleInputEmail1"><?php echo lang('phone'); ?></label>
                                            <input class="form-control" name="phone" value="<?php
                                            if (!empty($user->id)) {
                                                echo $user->phone;
                                            }
                                            ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo lang('group'); ?></label>
                                            <select class="form-control m-bot15 oi" id="group" name="group" required>

                                                <?php
                                                foreach ($groups as $group) {
                                                    if ($group->name == 'Patient' || $group->name == 'Doctor' || $group->name == 'Nurse' || $group->name == 'Pharmacist' || $group->name == 'Laboratorist' || $group->name == 'Accountant' || $group->name == 'Receptionist' || $group->name == 'members') {
                                                        ?>
                                                    <?php } else {
                                                        ?>
                                                        <option value="<?php echo $group->id; ?>" <?php
                                                        if (!empty($user->id)) {
                                                            if ($gid->group_id == $group->id) {
                                                                ?> selected <?php
                                                                    }
                                                                }
                                                                ?>><?php echo $group->name; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                            </select>
                                        </div>
                                        <!--
                                        <input type="checkbox" id='manual' name="manual" value="ok" <?php
                                        if (!empty($user->id)) {
                                            if ($user->permission == 'ok') {
                                                ?>checked<?php
                                                   }
                                               }
                                               ?> ><label for="exampleInputEmail"> &nbsp; Select Permissions Maunally!</label>
                                               <?php
                                               if (!empty($user->id)) {
                                                   $pers = $this->settings_model->modules2($user->id);
                                               }
                                               ?>

                                        <div id="permission" class="hidden">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Permission: </label><br>
                                                <div id="perdiv">
                                                    <?php
                                                    foreach ($permissions as $permission) {
                                                        if ($permission->feature == 'Report') {
                                                            
                                                        } else {
                                                            ?>
                                                            <input type="checkbox" name="permission[]" value="<?php echo $permission->feature; ?>" <?php
                                                            if (!empty($user->id)) {
                                                                if (in_array($permission->feature, $pers)) {
                                                                    ?>
                                                                           checked
                                                                           <?php
                                                                       }
                                                                   }
                                                                   ?> /> <label for="exampleInputEmail1"><?php echo $permission->feature; ?></label><br>
                                                               <?php } ?>

                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
-->
                                        <input type="hidden" id="id" name="id" value='<?php
                                        if (!empty($user->id)) {
                                            echo $user->id;
                                        }
                                        ?>'>
                                        <section class="">
                                            <button type="submit" name="submit" class="btn btn-info"><?php echo lang('submit'); ?></button>
                                        </section>
                                    </form>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
<!-- js placed at the end of the document so the pages load faster -->
<script src="common/js/jquery.js"></script>l
<script>
    $(window).load(function () {
        var g = document.getElementById('group').value;
        if ($('#manual').is(":checked")) {
            $('#permission').removeClass('hidden');
        }
    });

    $(document).ready(function () {

        $('#group').on('change', function () {
            var g = document.getElementById('group').value;
            var id = document.getElementById('id').value;
            console.log(g);
            if ($('#manual').is(":checked")) {
                console.log(g);
                //$('#permission').removeClass('hidden').addClass('hidden');
                if (id == "") {
                    if (g != 0) {
                        $.ajax({
                            url: 'users/getPermissions?id=' + g,
                            method: 'GET',
                            data: '',
                            dataType: 'json',
                        }).success(function (response) {
                            $('#perdiv').html('');
                            $('#perdiv').append(response.view.view);
                        })
                    }
                } else {

                }
            } else {
                if (id == "") {
                    console.log(g);
                    $('#permission').removeClass('hidden').addClass('hidden');
                    if (g != 0) {
                        $.ajax({
                            url: 'users/getPermissions?id=' + g,
                            method: 'GET',
                            data: '',
                            dataType: 'json',
                        }).success(function (response) {
                            $('#perdiv').html('');
                            $('#perdiv').append(response.view.view);
                        })
                    }
                } else {
                    $('#permission').removeClass('hidden').addClass('hidden');
                }
            }
        })
        $('#manual').change(function () {
            if ($('#manual').is(":checked")) {
                $('#permission').removeClass('hidden');
            } else {
                $('#permission').removeClass('hidden').addClass('hidden');
            }
            /*
             c++; 
             var g = document.getElementById('group').value;
             console.log(g);
             if(c%2==1) {
             console.log(c);
             $('#permission').removeClass('hidden'); 
             }
             if(c%2==0) {
             $('#permission').removeClass('hidden').addClass('hidden');
             }*/
        })
    })
</script>
