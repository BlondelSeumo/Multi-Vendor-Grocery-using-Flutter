<div class="table-responsive animated fadeInRight">
	<table class="table m-0 table-striped">
		<tr>
			<th><?php echo get_msg('no'); ?></th>
			<th><?php echo get_msg('food_add_img'); ?></th>
			<th><?php echo get_msg('food_add_name'); ?></th>
			<th><?php echo get_msg('food_add_description'); ?></th>
			<th><?php echo get_msg('food_add_price'); ?></th>
			
			<?php if ( $this->ps_auth->has_access( EDIT )): ?>
				
				<th><span class="th-title"><?php echo get_msg('btn_edit')?></span></th>
			
			<?php endif; ?>
			
			<?php if ( $this->ps_auth->has_access( DEL )): ?>
				
				<th><span class="th-title"><?php echo get_msg('btn_delete')?></span></th>
			
			<?php endif; ?>
			
			<?php if ( $this->ps_auth->has_access( PUBLISH )): ?>
				
				<th><span class="th-title"><?php echo get_msg('btn_publish')?></span></th>
			
			<?php endif; ?>

		</tr>
		
	
	<?php $count = $this->uri->segment(4) or $count = 0; ?>

	<?php if ( !empty( $additionals ) && count( $additionals->result()) > 0 ): ?>

		<?php 
		$i = 1;
		foreach($additionals->result() as $add): ?>
			
			<tr>
				<td><?php echo  $i++;?></td>
				<?php 

				$default_photo = get_default_photo( $add->id, 'food-additional' );

				if($default_photo->img_path != "") {
				 ?>		
				

				<td><img width="128" height="128" src="<?php echo img_url( '/thumbnail/'. $default_photo->img_path ); ?>"/></td>

				<?php } else { ?>

				<td><img width="128" height="128" src="<?php echo img_url( '/thumbnail/no_image.png'); ?>"/></td>

				<?php } ?>
				<td><?php echo $add->name;?></td>
				<td><?php echo $add->description;?></td>
				<td><?php echo $add->price;?></td>

				<?php if ( $this->ps_auth->has_access( EDIT )): ?>
			
					<td>
						<a href='<?php echo $module_site_url .'/edit/'. $add->id .'/' . $add->food_id; ?>'>
							<i class='fa fa-pencil-square-o'></i>
						</a>
					</td>
				
				<?php endif; ?>
				
				<?php if ( $this->ps_auth->has_access( DEL )): ?>
					
					<td>
						<a herf='#' class='btn-delete' data-toggle="modal" data-target="#myModal" id="<?php echo "$add->id";?>">
							<i class='fa fa-trash-o'></i>
						</a>
					</td>
				
				<?php endif; ?>
				
				<?php if ( $this->ps_auth->has_access( PUBLISH )): ?>
					
					<td>
						<?php if ( @$add->status == 1): ?>
							<button class="btn btn-sm btn-success unpublish" id='<?php echo $add->id;?>'>
							<?php echo get_msg('btn_yes'); ?></button>
						<?php else:?>
							<button class="btn btn-sm btn-danger publish" id='<?php echo $add->id;?>'>
							<?php echo get_msg('btn_no'); ?></button><?php endif;?>
					</td>
				
				<?php endif; ?>

			</tr>

		<?php endforeach; ?>

	<?php else: ?>
			
		<?php $this->load->view( $template_path .'/partials/no_data' ); ?>

	<?php endif; ?>

</table>
</div>

