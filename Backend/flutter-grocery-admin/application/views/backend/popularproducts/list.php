<div class="table-responsive animated fadeInRight">
	<table class="table m-0 table-striped">
	<tr>
		<th><?php echo get_msg('no'); ?></th>
		<th><?php echo get_msg('prd_name'); ?></th>
		<th><?php echo get_msg('prd_code'); ?></th>
		<th><?php echo get_msg('product_price'); ?></th>
		<th><span class="th-title"><?php echo get_msg('view'); ?></span></th>
	</tr>

	<?php $count = $this->uri->segment(4) or $count = 0; ?>

	<?php if ( !empty( $popularproducts ) && count( $popularproducts->result()) > 0 ): ?>

		<?php foreach($popularproducts->result() as $popularproduct): ?>
			
			<tr>
				<td><?php echo ++$count;?></td>
				<td><?php echo $popularproduct->name;?></td>
				<td><?php echo $popularproduct->code;?></td>
				<td><?php echo $popularproduct->unit_price;?></td>

				<?php if ( $this->ps_auth->has_access( EDIT )): ?>
			
					<td>
						<a href='<?php echo $module_site_url .'/edit/'. $popularproduct->id; ?>'>
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