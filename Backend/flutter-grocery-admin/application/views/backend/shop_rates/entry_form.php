<?php
	$attributes = array( 'id' => 'shoprate-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>
	
<section class="content animated fadeInRight" style="padding: 30px 20px 20px 20px;">
	<div class="card">
	    <div class="card-header" style="border-top: 2px solid red;">
	        <h3 class="card-title"><?php echo get_msg('shop_rate_info')?></h3>
	    </div>
        <!-- /.card-header -->
        <form role="form">
        <div class="card-body">
            <div class="row">
             	<div class="col-md-6">
             		<div class="form-group">
						<label>
							<?php echo get_msg('user_name')?>:
							<input type="hidden" id="user_id" name="user_id" value="<?php echo $shoprating->user_id; ?>">
							<?php 
								$name = $this->User->get_one($shoprating->user_id)->user_name;
								echo $name;
							?>
						</label>
					</div>

					<div class="form-group">
						<label><span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('branch_description_label')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('branch_description_label')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>
						<textarea class="form-control" name="description" readonly="true" placeholder="<?php echo get_msg('branch_description_label')?>" rows="5"><?php echo $shoprating->description; ?></textarea>
					</div>

              	</div>

              	<div class="col-md-6">
              		<div class="form-group">
                   		<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('rating_title')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('name_tooltips')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>

						<?php echo form_input( array(
							'name' => 'title',
							'value' => set_value( 'title', show_data( @$shoprating->title ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'rating_title' ),
							'id' => 'title',
							'readonly' => "true"
						)); ?>
              		</div>

              		<div class="form-group">
                   		<label> <span style="font-size: 17px; color: red;">*</span>
							<?php echo get_msg('rating_value')?>
							<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('name_tooltips')?>">
								<span class='glyphicon glyphicon-info-sign menu-icon'>
							</a>
						</label>

						<?php echo form_input( array(
							'name' => 'rating',
							'value' => set_value( 'rating', show_data( @$shoprating->rating ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'rating_value' ),
							'id' => 'rating',
							'readonly' => "true"
						)); ?>
              		</div>
		
              	</div>
              	<!--  col-md-6  -->

            </div>
            <!-- /.row -->
        </div>
        <!-- /.card-body -->

        <!-- Grid row -->
        <div class="gallery" id="gallery" style="margin-left: 15px; margin-bottom: 15px;">
          <?php
              $conds = array( 'img_type' => 'shop_rate', 'img_parent_id' => $shoprating->id );
              $images = $this->Image->get_all_by( $conds )->result();
          ?>
          <?php $i = 0; foreach ( $images as $img ) :?>
            <!-- Grid column -->
            <div class="mb-3 pics animation all 2">
              <a href="#<?php echo $i;?>"><img class="img-fluid" src="<?php echo img_url('/' . $img->img_path); ?>" alt="Card image cap"></a>
            </div>
            <!-- Grid column -->
          <?php $i++; endforeach; ?>

          <?php $i = 0; foreach ( $images as $img ) :?>
            <a href="#_1" class="lightbox trans" id="<?php echo $i?>"><img src="<?php echo img_url('/' . $img->img_path); ?>"></a>
          <?php $i++; endforeach; ?>
        </div>
        <!-- Grid row -->

		<div class="card-footer">

			<a href="<?php echo $module_site_url; ?>" class="btn btn-sm btn-primary">
				<?php echo get_msg('btn_back')?>
			</a>
        </div>
       
    </div>
    <!-- card info -->
</section>
				
