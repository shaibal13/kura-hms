<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->

        <section class="">
            <header class="panel-heading">
                <?php echo $inventories->pharmacist_name; ?> <?php echo lang('inventory'); ?> <?php echo lang('report'); ?> 


            </header>
            <style>

                .wrapper {
                    padding: 0px 10px 0px 15px !important;
                }

            </style>

            <div class="panel-body"> 
                <div class="adv-table editable-table">
                    <div class="space15">
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample1">
                        <thead>
                            <tr>
                                <th> <?php echo lang('id'); ?></th>
                                <th> <?php echo lang('name'); ?></th>
                                <th> <?php echo lang('category'); ?></th>
                                <th> <?php echo lang('store_box'); ?></th>
                                <th> <?php echo lang('p_price'); ?></th>
                                <th> <?php echo lang('s_price'); ?></th>                               
                                <th> <?php echo lang('generic_name'); ?></th>
                                <th> <?php echo lang('company'); ?></th>
                                <th> <?php echo lang('effects'); ?></th>
                                <th> <?php echo lang('expiry_date'); ?></th>
                                <?php if ($text == 'compare') { ?>
                                    <th> <?php echo lang('registered_quantity'); ?></th>
                                    <th> <?php echo lang('current_quantity'); ?></th>
                                    <th> <?php echo lang('difference'); ?></th>
                                <?php } ?>

                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $i = 0;
                            if (!empty($inventories->item)) {
                                $items = explode(",", $inventories->item);
                                foreach ($items as $item) {
                                    $item_single = array();
                                    $item_single = explode("**", $item);
                                    $medicine = $this->db->get_where('medicine', array('id' => $item_single[0]))->row();
                                    $i = $i + 1;
                                    ?>
                                    <tr><td><?php echo $i;
                                    ?>

                                        </td>
                                        <td><?php echo $medicine->name; ?></td>
                                        <td><?php echo $medicine->category; ?></td>
                                        <td><?php echo $medicine->box; ?></td>
                                        <td><?php echo $medicine->price; ?></td>
                                        <td><?php echo $medicine->s_price; ?></td>

                                        <td><?php echo $medicine->generic; ?></td>
                                        <td><?php echo $medicine->company; ?></td>
                                        <td><?php echo $medicine->effects; ?></td>
                                        <td><?php echo $medicine->e_date; ?></td>
                                        <?php if ($text == 'compare') { ?>
                                            <td><?php echo $item_single[1]; ?></td>  
                                            <td><?php
                                                if (empty($medicine->quantity)) {
                                                    echo '0';
                                                } else {
                                                    echo $medicine->quantity;
                                                }
                                                ?></td>  
                                            <td><?php echo abs($item_single[1] - $medicine->quantity); ?></td>  
        <?php } ?>
                                    </tr>
    <?php }
}
?>



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
