<!-- Comment -->
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
            <?php $count = $this->uri->segment(4) or $count = 0; ?>
                <?php if ( ! empty( $data )): ?>
                  <?php foreach($data as $d): ?>

                        <tr>
                            <td>
                                <?php 
                                    $logged_in_user = $this->ps_auth->get_user_info(); 
                                    // print_r($logged_in_user->user_profile_photo);die;
                                    if( $logged_in_user->user_profile_photo  != "" && file_exists(img_url( 'thumbnail/'. $logged_in_user->user_profile_photo )) ) {
                                ?>
                                        <img class="img-circle img-sm" src="<?php echo img_url( 'thumbnail/'. $logged_in_user->user_profile_photo ); ?>" class="user-image" alt="User Image">

                                    <?php }else if (!file_exists(img_url( 'thumbnail/'. $logged_in_user->user_profile_photo )) || $logged_in_user->user_profile_photo  == "") { ?>

                                        <img src="<?php echo img_url( 'thumbnail/avatar.png'); ?>" class="img-circle img-sm" alt="User Image">

                                    <?php } ?>
                                 <span style="padding-left: 10px;font-weight: bold;">
                                    <?php echo $this->User->get_one($d->user_id)->user_name; ?><br>
                                </span>
                                <p style="padding-left: 40px;"><?php echo $d->header_comment; ?></p>
                            </td>
                            <?php 
                                $detail_count = 0;
                                $conds['header_id'] = $d->id;
                                $detail_count = $this->Commentdetail->count_all_by( $conds );
                                if ( !$detail_count ) {
                            ?>
                                <td align="right"><i class="fa fa-dot-circle-o m-r-5 text-danger"></i></td>
                            <?php } else { ?>
                                <td align="right"><i class="fa fa-check-circle m-r-5 text-info"></i></td>
                            <?php } ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
 
        </tbody>
    </table>
</div>

<?php 
    //get login user id
    $login_user = $this->ps_auth->get_user_info();
    $conds['user_id'] = $login_user->user_id;

    // get count from permission table
    $permission_data_count = $this->Permission->count_all_by($conds);

    if ($permission_data_count > 0) {
      /* for super admin and shop admin */
      //get module id
      $conds_moudle['module_name'] = "comments";
      $cond_permission['module_id'] = $this->Module->get_one_by($conds_moudle)->module_id;
      $cond_permission['user_id'] = $login_user->user_id;

      $allowed_module_data = $this->Permission->get_one_by($cond_permission);

      if ($allowed_module_data->is_empty_object == 0) { ?>
        <!-- allowed this module to login user -->
        <div class="card-footer text-center">
          <a href="<?php echo site_url('admin/comments'); ?>"><?php echo get_msg('view_all_label'); ?></a>
        </div>
        <!-- /.card-footer -->
      <?php } ?>
    <?php } else { ?>  
        <div class="card-footer text-center">
          <a href="<?php echo site_url('admin/comments'); ?>"><?php echo get_msg('view_all_label'); ?></a>
        </div>
        <!-- /.card-footer -->
    <?php } ?>   
