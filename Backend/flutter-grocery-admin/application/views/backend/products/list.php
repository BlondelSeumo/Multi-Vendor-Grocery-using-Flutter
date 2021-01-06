<?php
	$selected_shop_id = $this->session->userdata('selected_shop_id');
	$shop_id = $selected_shop_id['shop_id'];

?>
<div class="table-responsive animated fadeInRight">
	<table class="table m-0 table-striped">
		<tr>
			<th><?php echo get_msg('no'); ?></th>
			<th><?php echo get_msg('product_name'); ?></th>
			<th><?php echo get_msg('cat_name'); ?></th>
			<th><?php echo get_msg('subcat_name'); ?></th>
			<th><?php echo get_msg('unit_price')  . '(' . $this->Shop->get_one($shop_id)->currency_symbol . ')'; ?></th>
			<th><?php echo get_msg('original_price')  . '(' . $this->Shop->get_one($shop_id)->currency_symbol . ')'; ?></th>
			
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

	<?php if ( !empty( $products ) && count( $products->result()) > 0 ): ?>

		<?php foreach($products->result() as $product): ?>
			
			<tr>
				<td><?php echo ++$count;?></td>
				<?php if($product->is_featured == 1 ) { ?>
				<td><span class="fa fa-diamond" style="color:red;"></span>&nbsp;<?php echo $product->name;?></td>
				<?php } else { ?>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $product->name;?></td>
				<?php } ?>
				<td><?php echo $this->Category->get_one( $product->cat_id )->name; ?></td>
				<td><?php echo $this->Subcategory->get_one( $product->sub_cat_id )->name; ?></td>
				<td><?php  

						$unit_price = $product->unit_price;

						$unit_price = round($unit_price, 2) ;

						echo $unit_price;

				?></td>
				<td><?php  

						$original_price = $product->original_price;

						$original_price = round($original_price, 2) ;

						echo $original_price;

				?></td>

				<?php if ( $this->ps_auth->has_access( EDIT )): ?>
			
					<td>
						<a href='<?php echo $module_site_url .'/edit/'. $product->id; ?>'>
							<i class='fa fa-pencil-square-o'></i>
						</a>
					</td>
				
				<?php endif; ?>
				
				<?php if ( $this->ps_auth->has_access( DEL )): ?>
					
					<td>
						<a herf='#' class='btn-delete' data-toggle="modal" data-target="#myModal" id="<?php echo "$product->id";?>">
							<i class='fa fa-trash-o'></i>
						</a>
					</td>
				
				<?php endif; ?>
				
				<?php if ( $this->ps_auth->has_access( PUBLISH )): ?>
					
					<td>
						<?php if ( @$product->status== 1): ?>
							<button class="btn btn-sm btn-success unpublish" id='<?php echo $product->id;?>'>
							<?php echo get_msg('btn_yes'); ?></button>
						<?php else:?>
							<button class="btn btn-sm btn-danger publish" id='<?php echo $product->id;?>'>
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

