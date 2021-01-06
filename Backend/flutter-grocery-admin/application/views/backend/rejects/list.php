<div class="table-responsive animated fadeInRight" style="padding: 50px 30px 10px 30px;">
	<table class="table m-0 table-striped">
		<tr>
			<th><?php echo get_msg('no'); ?></th>
			<th><?php echo get_msg('shop_name_label'); ?></th>
			<th><?php echo get_msg('address_label'); ?></th>
			<th><?php echo get_msg('user_email'); ?></th>
			
			<?php if ( $this->ps_auth->has_access( EDIT )): ?>
				
				<th><span class="th-title"><?php echo get_msg('btn_edit')?></span></th>
			
			<?php endif; ?>

		</tr>
		
	
	<?php $count = $this->uri->segment(5) or $count = 0; ?>

	<?php if ( !empty( $reject ) && count( $reject->result()) > 0 ): ?>

		<?php foreach($reject->result() as $rej): ?>
			
			<tr>
				<td><?php echo ++$count;?></td>
				<td><?php echo $rej->name;?></td>
				<td><?php echo $rej->address1;?></td>
				<td><?php echo $rej->email;?></td>

				<?php if ( $this->ps_auth->has_access( EDIT )): ?>
			
					<td>
						<a href='<?php echo $module_site_url .'/edit/'. $rej->id; ?>'>
							<i class='fa fa-pencil-square-o'></i>
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