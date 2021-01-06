<div class="table-responsive animated fadeInRight">
	<table class="table m-0 table-striped">
		<tr>
			<th><?php echo get_msg('no'); ?></th>
			<th><?php echo get_msg('lang_name'); ?></th>
			
			<?php if ( $this->ps_auth->has_access( EDIT )): ?>
				
				<th><span class="th-title"><?php echo get_msg('btn_edit')?></span></th>
			
			<?php endif; ?>
			
			<?php if ( $this->ps_auth->has_access( DEL )): ?>
				
				<th><span class="th-title"><?php echo get_msg('btn_delete')?></span></th>
			
			<?php endif; ?>
			
			<?php if ( $this->ps_auth->has_access( PUBLISH )): ?>
				
				<th><span class="th-title"><?php echo get_msg('btn_active')?></span></th>
			
			<?php endif; ?>

			<?php if ( $this->ps_auth->has_access( EDIT )): ?>
				<th><span class="th-title"><?php echo get_msg('lang_string'); ?></span></th>
			<?php endif; ?>

		</tr>
		
	
	<?php $count = $this->uri->segment(4) or $count = 0; ?>

	<?php if ( !empty( $languages ) && count( $languages->result()) > 0 ): ?>

		<?php foreach($languages->result() as $lang): ?>
			
			<tr>
				<td><?php echo ++$count;?></td>
				<td ><?php echo $lang->name;?></td>

				<?php if ( $this->ps_auth->has_access( EDIT )): ?>
			
					<td>
						<a href='<?php echo $module_site_url .'/edit/'. $lang->id; ?>'>
							<i style='font-size: 18px;' class='fa fa-pencil-square-o'></i>
						</a>
					</td>
				
				<?php endif; ?>
				
				<?php if ( $this->ps_auth->has_access( DEL )): ?>
					<?php if(@$lang->status == 1) { ?>
					<td>
						<a herf='#' class='btn-delete' data-toggle="modal" data-target="#warningModal" id="<?php echo $lang->id;?>">
							<i style='font-size: 18px;' class='fa fa-trash-o'></i>
						</a>
					</td>
					<?php } else { ?>
					<td>
						<a herf='#' class='btn-delete' data-toggle="modal" data-target="#myModal" id="<?php echo $lang->id;?>">
							<i style='font-size: 18px;' class='fa fa-trash-o'></i>
						</a>
					</td>
					<?php } ?>
				<?php endif; ?>
				
				<?php if ( $this->ps_auth->has_access( PUBLISH )): ?>
					
					<td>
						<?php if ( @$lang->status == 1): ?>
							<button class="btn btn-sm btn-success unpublish" id='<?php echo $lang->id;?>'>
							<?php echo get_msg('lang_active'); ?></button>
						<?php else:?>
							<button class="btn btn-sm btn-danger publish" id='<?php echo $lang->id;?>'>
							<?php echo get_msg('lang_deactive'); ?></button><?php endif;?>
					</td>
				
				<?php endif; ?>

				<?php if ( $this->ps_auth->has_access( EDIT )): ?>
			
					<td>
						<a href='<?php echo site_url() . "/admin/language_strings" .'/lang_list/'.$lang->id; ?>'>
							<i style='font-size: 18px;' class='fa fa-language'></i>
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