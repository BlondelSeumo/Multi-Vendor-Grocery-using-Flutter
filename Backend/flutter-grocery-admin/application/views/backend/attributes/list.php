<div class="table-responsive animated fadeInRight">
	<table class="table m-0 table-striped">
		<tr>
			<th><?php echo get_msg('no'); ?></th>
			<th><?php echo get_msg('att_name'); ?></th>
			<th><?php echo get_msg('product_name'); ?></th>

			<?php if ( $this->ps_auth->has_access( EDIT )): ?>
				
				<th><?php echo get_msg('count_detail'); ?></th>
			
			<?php endif; ?>

			<?php if ( $this->ps_auth->has_access( EDIT )): ?>
				
				<th><?php echo get_msg('add_att_detail'); ?></th>
			
			<?php endif; ?>
			
			<?php if ( $this->ps_auth->has_access( EDIT )): ?>
				
				<th><?php echo get_msg('btn_edit')?></th>
			
			<?php endif; ?>
			
			<?php if ( $this->ps_auth->has_access( DEL )): ?>
				
				<th><?php echo get_msg('btn_delete')?></th>
			
			<?php endif; ?>

		</tr>

		<?php $count = $this->uri->segment(4) or $count = 0; ?>

		<?php if ( !empty( $attributes ) && count( $attributes->result()) > 0 ): ?>

			<?php 
			$i = 1;
			foreach($attributes->result() as $attribute): ?>
				
				<tr>
					<td><?php echo $i++;?></td>
					<td><?php echo $attribute->name;?></td>
					<td><?php echo $this->Product->get_one( $attribute->product_id )->name; ?></td>
					<?php if ( $this->ps_auth->has_access( EDIT )): ?>
						
						<td>
							
							<?php
								$detail_count = 0;
								$conds['header_id'] = $attribute->id;
								$detail_count =  $this->Attributedetail->count_all_by( $conds );
							 ?>

							<a href="<?php echo site_url() . "/admin/attributedetails" .'/index/'. $attribute->id .'/' . $attribute->product_id; ?>" class="btn btn-sm btn-warning">
								<?php 
								echo $detail_count . " ";
								echo get_msg('detail_label')?>
							</a>
						</td>
					
					<?php endif; ?>

					<?php if ( $this->ps_auth->has_access( EDIT )): ?>
						
						<td>
							<a href='<?php echo site_url() . "/admin/attributedetails" .'/add/'. $attribute->id .'/' . $attribute->product_id; ?>'>
								<i class='fa fa-plus'></i>
							</a>
						</td>
					
					<?php endif; ?>

					<?php if ( $this->ps_auth->has_access( EDIT )): ?>
				
						<td>
							<a href='<?php echo $module_site_url .'/edit/'. $attribute->id .'/' . $attribute->product_id; ?>'>
								<i class='fa fa-pencil-square-o'></i>
							</a>
						</td>
					
					<?php endif; ?>
					
					<?php if ( $this->ps_auth->has_access( DEL )): ?>
						
						<td>
							<a herf='#' class='btn-delete' data-toggle="modal" data-target="#myModal" id="<?php echo $attribute->id;?>">
								<i class='fa fa-trash-o'></i>
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
