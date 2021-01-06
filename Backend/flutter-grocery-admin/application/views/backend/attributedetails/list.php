<div class="table-responsive animated fadeInRight">
	<table class="table m-0 table-striped">
		<tr>
			<th><label><?php echo get_msg('no'); ?></label></th>
			<th><label><?php echo get_msg('att_name'); ?></label></th>
			<th><label><?php echo get_msg('att_price'); ?></label></th>
			<th><label><?php echo get_msg('product_name'); ?></label></th>
			<?php if ( $this->ps_auth->has_access( EDIT )): ?>
				
				<th>
					<label>
						<?php echo get_msg('btn_edit')?>
					</label>
				</th>
			
			<?php endif; ?>
			
			<?php if ( $this->ps_auth->has_access( DEL )): ?>
				
				<th>
					<label>
						<?php echo get_msg('btn_delete')?>
					</label>
				</th>
			<?php endif; ?>
		</tr>

		<?php $count = $this->uri->segment(4) or $count = 0; ?>
		<?php if ( !empty( $attdetails ) && count( $attdetails->result()) > 0 ): ?>
			<?php $i=1; ?>
			<?php foreach($attdetails->result() as $attdetail): ?>
				
				<tr>
					<td><?php echo $i++;?></td>
					<td><label><?php echo $attdetail->name;?></label></td>
					<td><?php echo $attdetail->additional_price;?></td>
					<td><?php echo $this->Product->get_one($attdetail->product_id)->name; ?></td>

					<?php if ( $this->ps_auth->has_access( EDIT )): ?>
				
						<td>
							<a href="<?php echo site_url() . "/admin/attributedetails" .'/edit/'. $attdetail->id . "/" . $attdetail->header_id . "/" . $attdetail->product_id; ?>">
								<i class='fa fa-pencil-square-o'></i>
							</a>
						</td>
					
					<?php endif; ?>
					
					<?php if ( $this->ps_auth->has_access( DEL )): ?>
						
						<td>
							<a herf='#' class='btn-delete' data-toggle="modal" data-target="#myModal" id="<?php echo $attdetail->id;?>">
								<i class='fa fa-trash-o'></i>
							</a>
						</td>
					
					<?php endif; ?>
					
				</tr>

			<?php $i++; endforeach; ?>

		<?php else: ?>
				
			<?php $this->load->view( $template_path .'/partials/no_data' ); ?>

		<?php endif; ?>
	</table>
</div>	