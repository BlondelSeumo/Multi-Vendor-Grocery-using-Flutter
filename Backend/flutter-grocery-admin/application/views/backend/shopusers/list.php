
<div class="table-responsive animated fadeInRight">
	<table class="table m-0 table-striped">
		<tr>
			<th><?php echo get_msg('no')?></th>
			<th><?php echo get_msg('user_name')?></th>
			<th><?php echo get_msg('user_email')?></th>
			<th><?php echo get_msg('role')?></th>
			
			<?php if ( $this->ps_auth->has_access( EDIT )): ?>
				
				<th><span class="th-title"><?php echo get_msg('btn_edit')?></span></th>

			<?php endif;?>

			<?php if ( $this->ps_auth->has_access( DEL )) { ?>
				
				<th><span class="th-title"><?php echo get_msg('btn_delete')?></span></th>
			
			<?php } else { ?>
				<th><span class="th-title"><?php echo get_msg('btn_delete')?></span></th>
			<?php } ?>

		</tr>

		<?php $count = $this->uri->segment(4) or $count = 0; ?>
			
		<?php 

		//print_r($users); die;
		if ( !empty( $users ) && count( $users->result()) > 0 ): ?>
				
			<?php foreach($users->result() as $user): 
				$role_id = $this->User->get_one($user->user_id)->role_id;
			?>
				
				<tr>
					<td><?php echo ++$count;?></td>
					<td><?php echo $this->User->get_one($user->user_id)->user_name;?></td>
					<td><?php echo $this->User->get_one($user->user_id)->user_email;?></td>
					<td><?php echo $this->Role->get_name( $role_id );?></td>
					
					<?php if ( $this->ps_auth->has_access( EDIT )):?>

						<td>
							<a href='<?php echo $module_site_url .'/edit/'. $user->user_id;?>'>
								<i class='fa fa-pencil-square-o'></i>
							</a>
						</td>

					<?php endif;?>

					<?php 
						$role_id = $this->User->get_one($user->user_id)->role_id;

						if ( $role_id != 1 ){ 
					?>
					<?php if ( $this->ps_auth->has_access( DEL )){ ?>
					
						<td>
							<a herf='#' class='btn-delete' data-toggle="modal" data-target="#myModal" id="<?php echo $user->user_id;?>">
								<i style='font-size: 18px;' class='fa fa-trash-o'></i>
							</a>
					</td>
				
					<?php } else { ?>
						<!-- for Entry role -->
						<td></td>
					<?php } ?>
					<?php } else { ?>
						<td></td>
					<?php } ?>

				</tr>
			
			<?php endforeach; ?>

		<?php else: ?>
				
			<?php $this->load->view( $template_path .'/partials/no_data' ); ?>

		<?php endif; ?>

	</table>
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
		'title' => get_msg( 'delete_system_user_label' ),
		'message' =>  get_msg( 'system_user_delete_confirm_message' ),
	);
	
	$this->load->view( $template_path .'/components/delete_confirm_modal', $data );
?>	