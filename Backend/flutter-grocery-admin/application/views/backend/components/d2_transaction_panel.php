 <!-- TABLE: LATEST ORDERS -->
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
<div class="card-body table-responsive p-0">
  
  <table class="table m-0 table-striped">
    <tr>
      <th><?php echo get_msg('no'); ?></th>
      <th><?php echo get_msg('name_label'); ?></th>
      <th><?php echo get_msg('trans_status'); ?></th>
      <th><?php echo get_msg('trans_date_label'); ?></th>
    </tr>
    
    <?php $total_count = $this->uri->segment(4) or $total_count = 0; ?>
    <?php if ( ! empty( $data )): ?>
      <?php 
        $i = 0;
        foreach($data as $d): 
      ?>
          <tr>
            <td><?php echo ++$i; ?></td>
            <td><?php echo $d->contact_name; ?></td>
            <td>
              <?php 
                $conds['id'] = $d->trans_status_id;
                $title = $this->Transactionstatus->get_one_by($conds)->title;
                if ($d->trans_status_id == 'trans_sts29a4b0cd2fa6ae0449e47e9568320f3a') { ?>
                  <span class="badge badge-secondary">
                    <?php echo $title; ?>
                  </span>
                <?php } elseif ($d->trans_status_id == 'trans_stsabda7751186eb039c98f7602553a0ba0') { ?>
                  <span class="badge badge-success">
                    <?php echo $title; ?>
                  </span>
                <?php } elseif ($d->trans_status_id == 'trans_sts3e03079b68d8c052480c22d91ca2a0b9') { ?>
                  <span class="badge badge-warning">
                    <?php echo $title; ?>
                  </span>
                <?php } elseif ($d->trans_status_id == 'trans_sts8a3df6bad54007f1db11ed9531828112') { ?>
                  <span class="badge badge-info">
                    <?php echo $title; ?>
                  </span>    
                <?php } else { ?>
                  <span class="badge badge-primary">
                    <?php echo $title; ?>
                  </span>
                <?php } ?>
            </td>
            <td><?php echo $d->added_date; ?></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
   
  </table>
</div>
  <!-- /.table-responsive -->

<?php 
    //get login user id
    $login_user = $this->ps_auth->get_user_info();
    $conds['user_id'] = $login_user->user_id;

    // get count from permission table
    $permission_data_count = $this->Permission->count_all_by($conds);

    if ($permission_data_count > 0) {
      /* for super admin and shop admin */
      //get module id
      $conds_moudle['module_name'] = "transactions";
      $cond_permission['module_id'] = $this->Module->get_one_by($conds_moudle)->module_id;
      $cond_permission['user_id'] = $login_user->user_id;

      $allowed_module_data = $this->Permission->get_one_by($cond_permission);

      if ($allowed_module_data->is_empty_object == 0) { ?>
        <!-- allowed this module to login user -->
        <div class="card-footer text-center">
          <a href="<?php echo site_url('admin/transactions'); ?>"><?php echo get_msg('view_all_label'); ?></a>
        </div>
        <!-- /.card-footer -->
      <?php } ?>
    <?php } else { ?>  
        <div class="card-footer text-center">
          <a href="<?php echo site_url('admin/transactions'); ?>"><?php echo get_msg('view_all_label'); ?></a>
        </div>
        <!-- /.card-footer -->
    <?php } ?>   
           