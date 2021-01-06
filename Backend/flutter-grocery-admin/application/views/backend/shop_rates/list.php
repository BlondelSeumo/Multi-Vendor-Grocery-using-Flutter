<div class="table-responsive animated fadeInRight" style="padding: 50px 30px 10px 30px;">
	<table class="table m-0 table-striped">
	
		<tr>
			<th><?php echo get_msg('no'); ?></th>
			<th><?php echo get_msg('rating_shop_name'); ?></th>
			<th><?php echo get_msg('rating_user_name'); ?></th>
			<th><?php echo get_msg('rating_title'); ?></th>
			<th><?php echo get_msg('rating_description'); ?></th>
			<th><?php echo get_msg('rating_value'); ?></th>
			<th><?php echo get_msg('date'); ?></th>
			<th><span class="th-title"><?php echo get_msg('view'); ?></span></th>
		</tr>

	<?php $count = $this->uri->segment(4) or $count = 0; ?>

	<?php if ( !empty( $shopratings ) && count( $shopratings->result()) > 0 ): ?>

		<?php foreach($shopratings->result() as $shoprating): ?>
			
			<tr>
				<td><?php echo ++$count;?></td>
				<td><?php echo $this->Shop->get_one($shoprating->shop_id)->name?></td>
				<td><?php echo $this->User->get_one($shoprating->user_id)->user_name?></td>
				<td><?php echo $shoprating->title; ?></td>
				<td><?php echo $shoprating->description; ?></td>
				<td><?php echo $shoprating->rating; ?></td>
				<td><?php echo $shoprating->added_date; ?></td>
				<?php if ( $this->ps_auth->has_access( EDIT )): ?>
			
					<td>
						<a href='<?php echo $module_site_url .'/edit/'. $shoprating->id; ?>'>
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
