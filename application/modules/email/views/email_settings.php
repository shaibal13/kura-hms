<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-7 row"> 
            <header class="panel-heading">
                <?php echo lang('email'); ?> <?php echo lang('settings'); ?>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class=" panel clearfix"> 
                        <button class="export" onclick="javascript:window.print();">Print</button>  
                    </div>
                    <div class="space15"></div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo lang('name'); ?></th>
                                <th><?php echo lang('options'); ?></th>
                            </tr>
                        </thead>
                        <tbody> 
                            <?php
                            $i = 0;
                            foreach ($email as $email_setting) {
                              //  if($pgateway->name !='Paytm'){
                                $i = $i + 1;
                                ?>
                                <tr class="">
                                    <td><?php echo $i; ?></td>
                                    <td><?php
                                        if (!empty($email_setting->type)) {
                                            echo $email_setting->type;
                                        }
                                        ?>
                                    <br>
                                    
                                    </td>

                                    <td>
                                        <a class="btn btn-info btn-xs btn_width" href="email/settings?id=<?php echo $email_setting->id; ?>">   <?php echo lang('manage'); ?></a>
                                    </td>
                                </tr>
                                
                                <?php //}
                                
                                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>


        <section class="col-md-5"> 
            <header class="panel-heading">
                <?php echo lang('select'); ?> <?php echo lang('email'); ?> <?php echo lang('settings'); ?> 
            </header>
            <div class="panel-body">
                <form role="form" id="editAppointmentForm" action="settings/selectEmailGateway" class="clearfix" method="post" enctype="multipart/form-data">

                   
                        <?php foreach ($email as $email_setting) { 
                           // if($pgateway->name !='Paytm'){ ?>
                             <div class="form-group">
                                <input type="radio" class=""  readonly="" name="email_gateway" id="exampleInputEmail1" value='<?php echo $email_setting->type; ?>' placeholder="" <?php
                                if (!empty($email_setting->type)) {
                                    if ($settings->emailtype == $email_setting->type) {
                                        echo 'checked';
                                    }
                                }
                                ?>> <?php echo $email_setting->type; ?>
                             </div>
                        <?php //} 
                        
                                    } ?>
                  

                    <input type="hidden" name="id" value="<?php echo $settings->id; ?>">

                    <div class="col-md-12 panel">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>
            </div>
        </section>

        <!-- page end-->
    </section>
</section>
<!--main content end-->



<style>


    input[type=radio], input[type=checkbox]{
        height: auto !important;
    }

</style>

<script src="common/js/codearistos.min.js"></script>

<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
