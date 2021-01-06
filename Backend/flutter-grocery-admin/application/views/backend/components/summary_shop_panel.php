<div class="container-fluid">
  <div class="row mt-3">
    <?php $count = $this->uri->segment(4) or $count = 0; ?>
      <?php if ( !empty( $shops ) && count( $shops->result()) > 0 ): ?>
      <?php 
        foreach ($shops->result() as $shop) :
      ?>

      <div class="col-md-4" style="padding-top: 30px;">
                <!-- USERS LIST -->
              <div class="box box-danger" style="border: 1px solid #bbb;">
                 <div class="card-header" style="border-top: 2px solid red;">
                  <h3 class="box-title" style="padding-top: 5px;">
                      <i class="fa fa-home"></i>
                      <a href="<?php echo site_url('admin/dashboard/index/'. $shop->id);?>">
                        <?php echo $shop->name; ?>
                      </a>
                    </h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="img-responsive img-portfolio img-hover" style="justify-content: center;padding: 10px 10px 20px 10px">
                    <a href="<?php echo site_url('admin/dashboard/index/'. $shop->id);?>">
                      <?php $default_photo = get_default_photo( $shop->id, 'shop' ); ?>
                      <div class="widget-user-header text-white" style="background: url(<?php echo img_url( '/'. $default_photo->img_path ) ?>) center center;height: 280px;padding: 0px; ">
                        <?php if($shop->is_featured == 1) { ?>
                          <span class="fa fa-bookmark" style="color: red;font-size: 50px;margin-top: -5px;"></span>
                        <?php } ?>
                      </div>
                    </a>
                </div>
                  <div class="box-body no-padding" style="padding-left: 10px;">
                      <strong><?php echo get_msg('address_label'); ?></strong>
                 <p><i class="fa fa-map-marker" style="padding-right: 5px;"></i><?php echo $shop->address1; ?></p>
                 <strong><?php echo get_msg('lbl_about_shop'); ?></strong>
                 <p> 
                    <?php 
                                    
                          $shopDesc = strip_tags($shop->description);
                          
                          if (strlen($shopDesc) > 200) {
                          
                              $stringCut = substr($shopDesc, 0, 200);
                    
                              $shopDesc = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
                          }
                          
                          echo $shopDesc;
                          
                        ?>
                   </p>
                  
                   <div class="row text-center m-t-20">
                                  
                      <div class="col-md-4">
                         <i class="ion ion-stats-bars" style="font-size: 20px;"></i>
                          <p>
                            <?php 
                              // $conds['no_publish_filter'] = 1;
                              $conds['shop_id'] = $shop->id;
                              echo $this->Transactionheader->count_all_by( $conds ) . " "; 
                            ?>
                            Transactions
                        </p>
                      </div>
                      <div class="col-md-4">
                           <i class="ion ion-stats-bars" style="font-size: 20px;"></i>
                          <p>
                            <?php 
                              $conds['no_publish_filter'] = 1;
                              $conds['shop_id'] = $shop->id;
                              echo $this->Discount->count_all_by( $conds ) . " "; 
                            ?>
                            Discounts
                        </p>
                      </div>
                      <div class="col-md-4">
                          <i class="ion ion-stats-bars" style="font-size: 20px;"></i>
                          <p>
                            <?php 
                              $conds['no_publish_filter'] = 1;
                              $conds['shop_id'] = $shop->id;
                              echo $this->Product->count_all_by( $conds ) . " "; 
                            ?>
                            Products
                          </p>
                      </div>
            </div>

                    <!-- /.users-list -->
                  </div>
                  <!-- /.box-body -->

                    <div class="card-footer" style="padding: 20px 55px 10px 55px;">
                      <div class="row">
                        <div class="col-sm-4" style="padding-top: 10px;">
                          <a href="<?php echo site_url('admin/dashboard/index/'. $shop->id);?>" class="btn btn-block btn-outline-primary">Dashboard</a>
                      </div>
                      <div class="col-sm-4" style="padding-top: 10px;">
                          <a href="<?php echo site_url('admin/shops/edit/'. $shop->id);?>" class="btn btn-block btn-outline-primary"><?php echo get_msg('btn_edit'); ?></a>
                        </div>
                        <div class="col-sm-4" style="padding-top: 10px;">
                          <input type="submit" value="<?php echo get_msg('btn_delete')?>" class="btn btn-block btn-outline-primary delete-shop" id="<?php echo $shop->id; ?>" data-toggle="modal" data-target="#deleteShop"/>
                        </div>
                      </div>
                    </div>
                  <!-- /.box-footer -->
              </div>
                <!--/.box -->
          </div>

        <?php endforeach; ?>
      <?php endif ?>
  </div>
</div>

<div style="text-align: center; font-size: 36px;">
  <?php if( $current!=1 ) { ?>
    <a href="<?php echo site_url('/admin/shops/index/'.($current-1)) ?>">

      <span class="fa fa-caret-left" style="color: red;font-size: 50px;margin-top: -5px;"></span>
      
    </a>
  <?php } ?> 
  <?php if( $noofpage > $current ) { ?>
    <a href="<?php echo site_url('/admin/shops/index/'.($current+1)) ?>">
      
      <span class="fa fa-caret-right" style="color: red;font-size: 50px;margin-top: -5px;"></span>

    </a>
  <?php } ?>
</div>

<div class="modal fade"  id="deleteShop">
    
  <div class="modal-dialog">
    
    <div class="modal-content">
    
      <div class="modal-header">
        <h4 class="modal-title"><?php echo get_msg('delete_shop_label')?></h4>

        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </button>

      </div>

      <div class="modal-body">
        <p><?php echo get_msg('delete_shop_confirm_message')?></p>
        <p>1. Categories</p>
        <p>2. Sub-Categories</p>
        <p>3. Products and Discounts</p>
        <p>4. Products and Collection</p>
        <p>5. News Feeds</p>
        <p>6. Shipping Areas</p>
        <p>7. Watch List</p>
        <p>8. Comments</p>
        <p>9. Transactions</p>
        <p>10. Reports</p>
        <p>11. User Shop</p>
        <p>12. Shop Tag</p>
        <p>13. Likes</p>
        <p>14. Favourites</p>
        <p>15. Coupon</p>
      </div>

      <div class="modal-footer">
        <a type="button" class="btn btn-default btn-delete-shop">Yes</a>
        <a type="button" class="btn btn-default" data-dismiss="modal">Cancel</a>
      </div>

    </div>
  
  </div>      
    
</div>