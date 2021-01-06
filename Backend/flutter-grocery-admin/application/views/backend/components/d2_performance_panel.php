<!--Performance -->
<div class="card-header" style="border-top: 2px solid red;">
  <h3 class="card-title" style="margin-left: 10px;padding-top: 10px;text-transform: uppercase;font-weight: bold;">
    <?php echo $panel_title; ?>
  </h3>

  <div class="card-tools">
    <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
    </button>
    <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i>
    </button>
  </div>
</div>

<div class="card-body b-t collapse show">
    <table class="table v-middle no-border">
        <tbody>
            <?php 
                $selected_shop_id = $this->session->userdata('selected_shop_id');
                $shop_id = $selected_shop_id['shop_id'];
                $conds['shop_id'] = $shop_id;  

            ?>
            <tr>
                <td style="font-weight: bold;"><?php echo get_msg('prd_label'); ?></td>
                <td align="right">
                    <span class="text-info" style="font-size: 18px;font-weight: bold;">
                        <?php echo $this->Product->count_all_by( $conds ); ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;"><?php echo get_msg('cat_label'); ?></td>
                <td align="right">
                    <span class="text-success" style="font-size: 18px;font-weight: bold;">
                        <?php echo $this->Category->count_all_by( $conds ); ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;"><?php echo get_msg('subcat_label'); ?></td>
                <td align="right">
                    <span class="text-primary" style="font-size: 18px;font-weight: bold;">
                        <?php echo $this->Subcategory->count_all_by( $conds ); ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;"><?php echo get_msg('dis_label'); ?></td>
                <td align="right">
                    <span class="text-warning" style="font-size: 18px;font-weight: bold;">
                       <?php echo $this->Discount->count_all_by( $conds ); ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;"><?php echo get_msg('collect_label'); ?></td>
                <td align="right">
                    <span class="text-danger" style="font-size: 18px;font-weight: bold;">
                        <?php echo $this->Collection->count_all_by( $conds ); ?>
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</div>
