<?php
if (!empty($group->id)) {
    $this->db->where('id', $group->id);
    $query = $this->db->get('groups')->row()->description;
    $pers = explode(',', $query);
}
?>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-8 row">
            <header class="panel-heading">
                <?php
                if (!empty($group->id))
                    echo 'Edit Group';
                else
                    echo 'Create Group';
                ?>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <div class="">
                            <section class="panel">
                                <div class="">
                                    <div class="col-lg-12">
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-6">
                                            <?php echo validation_errors(); ?>
                                        </div>
                                        <div class="col-lg-3"></div>
                                    </div>
                                    <form role="form" action="users/addNewGroup" method="post" enctype="multipart/form-data">
                                        <div class="">
                                            <div class="panel col-md-6">
                                                <?php if (!empty($group->id)) { ?>
                                                    <div class="form-group"><label for="exampleInputEmail1"><?php echo lang('group_name'); ?></label>
                                                        <?php if ($group->name == 'admin') { ?>

                                                            <input class="form-control group_name" name="name" value="<?php
                                                            if (!empty($group->id)) {
                                                                echo $group->name;
                                                            }
                                                            ?>" readonly>
                                                               <?php } else { ?>
                                                            <input class="form-control group_name" name="name" value="<?php
                                                            if (!empty($group->id)) {
                                                                echo $group->name;
                                                            }
                                                            ?>">
                                                               <?php } ?>
                                                    </div>
                                                <?php } ?>
                                                <?php if (empty($group->id)) { ?>
                                                    <div class="form-group"><label for="exampleInputEmail1"><?php echo lang('group_name'); ?></label>
                                                        <input class="form-control group_name" name="name" value="<?php
                                                        if (!empty($group->id)) {
                                                            echo $group->name;
                                                        }
                                                        ?>">
                                                    </div>
                                                <?php } ?>
                                                <span class="group_name_alert" style="color:red;"></span>
                                            </div>
                                            <div class="panel col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"><?php echo lang('permission'); ?>: </label><br>
                                                    <?php
                                                    foreach ($permissions as $permission) {
                                                        if (!empty($group->id)) {
                                                            $permission_access_group = $permission_access->permission_access;
                                                            $permission_access_group_explode = explode('***', $permission_access_group);
                                                        }
                                                        ?>
                                                        <div class="col-md-6">
                                                            <div class="col-md-7">
                                                                <input type="checkbox" class="feature" id="<?php echo $permission->feature; ?>" name="permission[]" value="<?php echo $permission->feature; ?>"  <?php
                                                                if (!empty($group->id)) {
                                                                    if (in_array($permission->feature, $pers)) {
                                                                        ?>
                                                                               checked
                                                                               <?php
                                                                           }
                                                                       }
                                                                       ?> /> <label for="exampleInputEmail1"><?php echo $permission->feature; ?></label>
                                                            </div>
                                                            <?php if ($permission->feature != 'Payment Settings' && $permission->feature != 'Bulk Import') { ?>
                                                                <div class="col-md-5  <?php
                                                                if (!empty($group->id)) {
                                                                    if (!in_array($permission->feature, $pers)) {
                                                                        echo 'hidden';
                                                                    }
                                                                } else {
                                                                    echo 'hidden';
                                                                }
                                                                ?> " id="<?php echo $permission->feature; ?>_update">
                                                                    <input  class="permission_option" id="<?php echo $permission->feature; ?>-1" type="checkbox" name="<?php echo $permission->feature; ?>[]" value="1"
                                                                    <?php
                                                                    if (!empty($group->id)) {
                                                                        if (in_array($permission->feature, $pers)) {
                                                                            foreach ($permission_access_group_explode as $perm) {
                                                                                $perm_explode = array();
                                                                                $perm_explode = explode(",", $perm);
                                                                                if (in_array('1', $perm_explode) && $perm_explode[0] == $permission->feature) {
                                                                                    echo 'checked';
                                                                                    //  break;
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                            />
                                                                    <label for="exampleInputEmail1"><?php echo lang('r'); ?></label>
                                                                    <input class="permission_option" id="<?php echo $permission->feature; ?>-2" type="checkbox" name="<?php echo $permission->feature; ?>[]" value="2"
                                                                    <?php
                                                                    if (!empty($group->id)) {
                                                                        if (in_array($permission->feature, $pers)) {
                                                                            foreach ($permission_access_group_explode as $perm) {
                                                                                $perm_explode = array();
                                                                                $perm_explode = explode(",", $perm);
                                                                                if (in_array('2', $perm_explode) && $perm_explode[0] == $permission->feature) {
                                                                                    echo 'checked';
                                                                                    //  break;
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                           />
                                                                    <label for="exampleInputEmail1"><?php echo lang('w'); ?></label>
                                                                      <?php if ($permission->feature != 'Report') { ?>
                                                                    <input class="permission_option" id="<?php echo $permission->feature; ?>-3" type="checkbox" name="<?php echo $permission->feature; ?>[]" value="3"
                                                                    <?php
                                                                    if (!empty($group->id)) {
                                                                        if (in_array($permission->feature, $pers)) {
                                                                            foreach ($permission_access_group_explode as $perm) {
                                                                                $perm_explode = array();
                                                                                $perm_explode = explode(",", $perm);
                                                                                if (in_array('3', $perm_explode) && $perm_explode[0] == $permission->feature) {
                                                                                    echo 'checked';
                                                                                    //   break;
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                           />
                                                                    <label  for="exampleInputEmail1"><?php echo lang('d'); ?></label>
                                                                      <?php } ?>
                                                                </div>
    <?php } ?>
                                                        </div>


                                            <?php }
                                            ?>
                                                </div>
                                            </div>
                                            <input type="hidden" name="id" value='<?php
                                            if (!empty($group->id)) {
                                                echo $group->id;
                                            }
                                            ?>'>
                                            <input type="hidden" name="access_id" value='<?php
                                            if (!empty($group->id)) {
                                                echo $permission_access->id;
                                            }
                                            ?>'>
                                            <section class="panel col-md-11">
                                                <button type="submit" name="submit" class="btn btn-info pull-right submit_button" id="submit-btn"><?php echo lang('submit'); ?></button>
                                            </section>
                                        </div>
                                    </form>
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
<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".group_name").keyup(function () {
            var name = $(this).val();
            $.ajax({
                url: 'users/getGroupNameAvailable?name=' + name,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                if (response.response === '0') {

                    $('.group_name_alert').html('<?php echo lang('group_name_already_existed'); ?>');

                    $(".submit_button").addClass("disabled");
                } else {
                    $('.group_name_alert').html(" ");
                    $(".submit_button").removeClass("disabled");

                }
            });
        });
        $(".feature").click(function () {
            var id = $(this).attr('id');
            if ($('#' + id).is(":checked")) {
                $('#' + id + '-1').prop('checked', true);
                $('#' + id + '-2').prop('checked', true);
                $('#' + id + '-3').prop('checked', true);
                $('#' + id + '_update').removeClass('hidden');

            } else {
                $('#' + id + '_update').addClass('hidden');
            }
        });
        $(".permission_option").click(function () {
            var id = $(this).attr('id');

            var res = id.split("-");
            //   alert(id);
            if (!$('#' + res[0] + '-1').is(':checked') && !$('#' + res[0] + '-2').is(':checked') && !$('#' + res[0] + '-3').is(':checked'))
            {
                $('#' + res[0] + '_update').addClass('hidden');
                $('#' + res[0]).prop('checked', false);
            }
        });
    });
</script>