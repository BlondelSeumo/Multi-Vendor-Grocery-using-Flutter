<?php echo form_open( $module_site_url . '/push_message_flutter', array( 'id' => 'gcm-form','enctype' => 'multipart/form-data' ));?>

<div class="container-fluid">
	<div class="col-sm-6" style="padding: 30px 20px 20px 20px;">
		<div class="card earning-widget">
	    	<div class="card-header" style="border-top: 2px solid red;">
	    		<h3 class="card-title"><?php echo get_msg('noti_info')?></h3>
			</div>
        	<!-- /.card-header -->
        	<div class="card-body">
        		<div class="form-group">
					<label> 
						<?php 
							if($this->Notitoken->count_all() > 0) {
								
								echo get_msg( 'total_label' );

								echo $this->Notitoken->count_all();
								
								if($this->Notitoken->count_all() == 1) {
									echo get_msg( 'device_label' );
								} else {
									echo get_msg( 'device_label' );
								}

								echo get_msg( 'registered_label' );
							}
							?> 
					</label>
					<br>
					
					<label> <span style="font-size: 17px; color: red;">*</span>
						<?php echo get_msg('noti_message_label') ?> 
						<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('noti_message_tooltips')?>">
							<span class='glyphicon glyphicon-info-sign menu-icon'>
						</a>
					</label>
					
					<textarea class="form-control" name="message" placeholder="<?php echo get_msg('noti_message_label')?>" rows="8"></textarea>
				</div>

				<div class="form-group">
					<label> <span style="font-size: 17px; color: red;">*</span>
						<?php echo get_msg('noti_des_label') ?> 
						<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('noti_message_tooltips')?>">
							<span class='glyphicon glyphicon-info-sign menu-icon'>
						</a>
					</label>
					
					<textarea class="form-control" name="description" placeholder="<?php echo get_msg('noti_des_label')?>" rows="5"></textarea>
				</div>
				<?php if ( !isset( $noti )): ?>

						<div class="form-group">
						
							<label> <span style="font-size: 17px; color: red;">*</span>
								<?php echo get_msg('noti_img')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo get_msg('cat_photo_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
							</label>

							<br/>

							<input class="btn btn-sm" type="file" name="images1">
						</div>

						
				<?php endif; ?>	
        	</div>
			
			<div class="card-footer">
				<?php 
				if($this->Notitoken->count_all() > 0) {
				?>
				  
				<button type="submit" class="btn btn-primary"><?php echo get_msg('noti_send_btn')?></button>
				
				<?php 
					} else {
						echo get_msg('sorry_no_device');
					}
				?>
			</div>
			
		</div>
	</div>
</div>

<?php echo form_close();?>

