<div class="table-responsive animated fadeInRight">
	<table class="table m-0 table-striped">
		<tr>
			<th><?php echo get_msg('no'); ?></th>
			<th><?php echo get_msg('Prd_name'); ?></th>
			<th><?php echo get_msg('prd_code'); ?></th>
			<th><?php echo get_msg('product_price'); ?></th>
			<th><span class="th-title"><?php echo get_msg('view'); ?></span></th>
		</tr>

	<?php $count = $this->uri->segment(4) or $count = 0; ?>

	<?php if ( !empty( $purchasedproducts ) && count( $purchasedproducts->result()) > 0 ): ?>

		<?php foreach($purchasedproducts->result() as $purchasedproduct): ?>
			
			<tr>
				<td><?php echo ++$count;?></td>
				<td><?php echo $purchasedproduct->name;?></td>
				<td><?php echo $purchasedproduct->code;?></td>
				<td><?php echo $purchasedproduct->unit_price;?></td>

				<?php if ( $this->ps_auth->has_access( EDIT )): ?>
			
					<td>
						<a href='<?php echo $module_site_url .'/edit/'. $purchasedproduct->id; ?>'>
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
