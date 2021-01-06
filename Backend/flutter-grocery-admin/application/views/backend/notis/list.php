<div class='row my-3'  style="padding: 10px 30px 10px 30px;">
	<div class='col-9'>
		<?php
			$attributes = array('class' => 'form-inline');

			echo form_open( $module_site_url . '/search', $attributes );
		?>
			<div class="form-group" style="padding-right: 3px;">
				
				<?php echo form_input(array(
					'name' => 'searchterm',
					'value' => set_value( 'searchterm' ),
					'class' => 'form-control form-control-sm',
					'placeholder' => get_msg( 'btn_search' ),
					'id' => ''
				)); ?>

		  	</div>

			<div class="form-group" style="padding-right: 2px;">
			  	<button type="submit" class="btn btn-sm btn-primary">
			  		<?php echo get_msg( 'btn_search' ); ?>
			  	</button>
		  	</div>

		  	<div class="form-group">
			  	<a href='<?php echo $module_site_url .'/index';?>' class='btn btn-sm btn-primary'>
					<?php echo get_msg( 'btn_reset' )?>
				</a>
		  	</div>
		
		<?php echo form_close(); ?>

	</div>

	<div class='col-3'>
		<a href='<?php echo $module_site_url .'/add';?>' class='btn btn-sm btn-primary pull-right'>
			<span class='fa fa-plus'></span> 
			<?php echo get_msg( 'push_message' )?>
		</a>
	</div>
</div>

<div class="container-fluid" style="padding: 10px 30px 10px 30px;">
	<div class="table-responsive">
		<table class="table m-0 table-striped">
			<tr>
				<th><?php echo get_msg('no')?></th>
				<th><?php echo get_msg('noti_message_label')?></th>
				<th><?php echo get_msg('noti_img')?></th>
				<th><?php echo get_msg('noti_des_label')?></th>
				
				<?php if ( $this->ps_auth->has_access( DEL )): ?>
					
					<th><?php echo get_msg('btn_delete')?></th>
				
				<?php endif; ?>
			</tr>

		<?php $count = $this->uri->segment(4) or $count = 0; ?>

		<?php if ( !empty( $notimsgs ) && count( $notimsgs->result()) > 0 ): ?>

			<?php foreach($notimsgs->result() as $noti): ?>
				
				<tr>
					<td><?php echo ++$count;?></td>
					<td><?php echo $noti->message;?></td>
					<?php 

					$default_photo = get_default_photo( $noti->id, 'noti' );

					if($default_photo->img_path != "") {
					 ?>		
					

					<td><img width="128" height="128" src="<?php echo img_url( '/thumbnail/'. $default_photo->img_path ); ?>"/></td>

					<?php } else { ?>

					<td><img width="128" height="128" src="<?php echo img_url( '/thumbnail/no_image.png'); ?>"/></td>

					<?php } ?>

					<td><?php echo $noti->description;?></td>

					<?php if ( $this->ps_auth->has_access( DEL )): ?>
						
						<td>
							<a herf='#' class='btn-delete' data-toggle="modal" data-target="#myModal" id="<?php echo $noti->id;?>">
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
</div>

<script>
function runAfterJQ() {

	$(document).ready(function(){
		
		// Delete Trigger
		$('.btn-delete').click(function(){
			
			// get id and links
			var id = $(this).attr('id');
			var btnYes = $('.btn-yes').attr('href');
			var btnNo = $('.btn-no').attr('href');

			// modify link with id
			$('.btn-yes').attr( 'href', btnYes + id );
			$('.btn-no').attr( 'href', btnNo + id );
		});

	});
}
</script>

<?php
	// Delete Confirm Message Modal
	$data = array(
		'title' => get_msg( 'delete_noti_label' ),
		'message' =>  get_msg( 'noti_yes_message' ) ,
		'noti_yes_btn' => get_msg( 'noti_yes_label' ),
		'noti_no_btn' => get_msg('noti_no_label')
	);
	
	$this->load->view( $template_path .'/components/delete_confirm_modal', $data );
?>