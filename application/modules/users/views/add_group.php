<?php if(!empty($group->id)) {
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
        <section class="col-md-7 row">
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
                                        <div class="row">
                                        <div class="panel col-md-6">
                                            <?php if(!empty($group->id)){ ?>
                                            <div class="form-group"><label for="exampleInputEmail1">Group Name</label>
                                            <?php if($group->name == 'admin' || $group->name == 'Super' || $group->name == 'Dispatch') { ?>
                                        
                                                <input class="form-control" name="name" value="<?php if(!empty($group->id)) {
                                                    echo $group->name;
                                                    } ?>" readonly>
                                            <?php } else { ?>
                                               <input class="form-control" name="name" value="<?php if(!empty($group->id)) {
                                                    echo $group->name;
                                                } ?>">
                                            <?php } ?>
                                            </div>
                                        <?php } ?>
                                        <?php if(empty($group->id)){ ?>
                                                <div class="form-group"><label for="exampleInputEmail1">Group Name</label>
                                                        <input class="form-control" name="name" value="<?php
                                                        if (!empty($group->id)) {
                                                            echo $group->name;
                                                        }
                                                        ?>">
                                                    </div>
                                        <?php } ?>
                                            </div>
                                                <div class="panel col-md-4">
                                                    <div class="form-group pull-right">
                                                        <label for="exampleInputEmail1">Permission: </label><br>
                                                        <?php foreach ($permissions as $permission) {
                                                            if($permission->feature == 'Report') {} else { ?>
                                                        <input type="checkbox" name="permission[]" value="<?php echo $permission->feature; ?>" <?php if (!empty($group->id)) {
                                                            if (in_array($permission->feature, $pers)) {
                                                                    ?>
                                                                           checked
                                                                       <?php }
                                                                   }
                                                                   ?> /> <label for="exampleInputEmail1"><?php echo $permission->feature; ?></label><br>
                                                
                                                            
                                                        <?php  } } ?>
                                                    </div>
                                                </div>
                                        <input type="hidden" name="id" value='<?php
                                        if (!empty($group->id)) {
                                            echo $group->id;
                                        }
                                        ?>'>
                                        <section class="panel col-md-11">
                                            <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
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
