<div class="table-responsive animated fadeInRight">
	<table class="table m-0 table-striped">
		<tr>
			<th><?php echo get_msg('no'); ?></th>
			<th><?php echo get_msg('cat_name'); ?></th>
			<th><?php echo get_msg('cat_icon'); ?></th>
			<th><span class="th-title"><?php echo get_msg('view'); ?></span></th>
		</tr>

	<?php $count = $this->uri->segment(4) or $count = 0; ?>

	<?php if ( !empty( $popularcategories ) && count( $popularcategories->result()) > 0 ): ?>

		<?php foreach($popularcategories->result() as $popularcategory): ?>
			
			<tr>
				<td><?php echo ++$count;?></td>
				<td><?php echo $popularcategory->name; ?></td>	
				<?php 

				$default_photo = get_default_photo( $popularcategory->id, 'category-icon' );

				if($default_photo->img_path != "") {
				 ?>		
				

				<td><img width="128" height="128" src="<?php echo img_url( 'thumbnail/'. $default_photo->img_path ); ?>"/></td>

			<?php } else { ?>
				<td><img width="128" height="128" src="<?php echo img_url( 'thumbnail/no_image.png'); ?>"/></td>
			<?php } ?>

				<?php if ( $this->ps_auth->has_access( EDIT )): ?>
			
					<td>
						<a href='<?php echo $module_site_url .'/edit/'. $popularcategory->id; ?>'>
							<i class='fa fa-eye'></i>
						</a>
					</td>
				
				<?php endif; ?>
				
				
				
			</tr>

		<?php endforeach; ?>

	<?php else: ?>
			
		<?php $this->load->view( $template_path .'/partials/no_data' ); ?>

	<?php endif; ?>

	</table>
</div>