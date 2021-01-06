<div class="table-responsive animated fadeInRight">
	<table class="table m-0 table-striped">
		<tr>
			<th><?php echo get_msg('no'); ?></th>
			<th><?php echo get_msg('language_id'); ?></th>
			<th><?php echo get_msg('lang_string_key'); ?></th>
			<th><?php echo get_msg('lang_string_value'); ?></th>
			
			<?php if ( $this->ps_auth->has_access( EDIT )): ?>
				
				<th><span class="th-title"><?php echo get_msg('btn_edit')?></span></th>
			
			<?php endif; ?>

		</tr>
		
	
	<?php $count = $this->uri->segment(4) or $count = 0; ?>

	<?php if ( !empty( $langstrings ) && count( $langstrings->result()) > 0 ): ?>

		<?php 
		$i = 1; 
		foreach($langstrings->result() as $langstr): 
		?>
			
			<tr>
				<td><?php echo ++$count;?></td>
				<td ><?php echo $this->Language->get_one($langstr->language_id)->symbol;?></td>
				<td ><?php echo $langstr->key;?></td>
				<td ><?php echo $langstr->value;?></td>

				<?php if ( $this->ps_auth->has_access( EDIT )): ?>
			
					<td>
						<a href='<?php echo $module_site_url .'/edit/'. $langstr->id.'/' . $langstr->language_id; ?>'>
							<i style='font-size: 18px;' class='fa fa-pencil-square-o'></i>
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

