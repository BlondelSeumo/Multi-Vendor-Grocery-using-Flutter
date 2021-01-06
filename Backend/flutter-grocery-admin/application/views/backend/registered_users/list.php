<div class="table-responsive animated fadeInRight" style="padding: 10px 30px 10px 30px;">
	<table class="table m-0 table-striped">

		<tr>
			<th><?php echo get_msg('no')?></th>
			<th><?php echo get_msg('user_name')?></th>
			<th><?php echo get_msg('user_email')?></th>
			<th><?php echo get_msg('user_phone_label')?></th>
			<th><?php echo get_msg('role')?></th>

			<?php if ( $this->ps_auth->has_access( EDIT )): ?>
				
				<th><?php echo get_msg('btn_edit')?></th>

			<?php endif;?>


			<?php if ( $this->ps_auth->has_access( BAN )): ?>
				
				<th><?php echo get_msg('user_ban')?></th>

			<?php endif;?>

			<?php if ( $this->ps_auth->has_access( DEL )): ?>
				
				<th><span class="th-title"><?php echo get_msg('btn_delete')?></span></th>
			
			<?php endif; ?>

		</tr>

		<?php $count = $this->uri->segment(4) or $count = 0; ?>

		<?php if ( !empty( $users ) && count( $users->result()) > 0 ): ?>
				
			<?php foreach($users->result() as $user): ?>
				
				<tr>
					<td><?php echo ++$count;?></td>
					<td><?php echo $user->user_name;?></td>
					<td><?php echo $user->user_email;?></td>
					<td><?php echo $user->user_phone;?></td>
					<td><?php echo "Registered User";?></td>

					<?php if ( $this->ps_auth->has_access( EDIT )): ?>
					
					<td>
						<a href='<?php echo $module_site_url .'/edit/'. $user->user_id; ?>'>
							<i class='fa fa-pencil-square-o'></i>
						</a>
					</td>
				
				
					<?php endif; ?>

					<?php if ( $this->ps_auth->has_access( BAN )):?>
					
						<td>
							<?php if ( @$user->is_banned == 0 ): ?>
								
								<button class="btn btn-sm btn-primary-green ban" userid='<?php echo @$user->user_id;?>'>
									<?php echo get_msg( 'user_ban' ); ?>
								</button>
							
							<?php else: ?>
								
								<button class="btn btn-sm btn-danger unban" userid='<?php echo @$user->user_id;?>'>
									<?php echo get_msg( 'user_unban' ); ?>
								</button>
							
							<?php endif; ?>

						</td>

					<?php endif;?>

					<?php if ( $this->ps_auth->has_access( DEL )): ?>
					
					<td>
						<a herf='#' class='btn-delete' data-toggle="modal" data-target="#myModal" id="<?php echo $user->user_id;?>">
							<i style='font-size: 18px;' class='fa fa-trash-o'></i>
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
<script>
function runAfterJQ() {

	$(document).ready(function(){

		$(document).delegate('.ban','click',function(){
			var btn = $(this);
			var id = $(this).attr('userid');

			$.ajax({
				url: "<?php echo $module_site_url .'/ban/';?>"+id,
				method:'GET',
				success:function(msg){
					if(msg == 'true')
						btn.addClass('unban btn-danger')
							.removeClass('btn-primary-green ban')
							.html('User Unban');
					else
						console.log( 'System error occured. Please contact your system administrator.' );
				}
			});
		});
		
		$(document).delegate('.unban','click',function(){
			var btn = $(this);
			var id = $(this).attr('userid');

			$.ajax({
				url: "<?php echo $module_site_url .'/unban/';?>"+id,
				method:'GET',
				success:function(msg){
					if(msg == 'true')
						btn.addClass('ban btn-primary-green')
							.removeClass('btn-danger unban')
							.html('User Ban');
					else
						console.log( 'System error occured. Please contact your system administrator.' );
				}
			});
		});

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
		'title' => get_msg( 'delete_register_user_label' ),
		'message' =>  get_msg( 'register_user_delete_confirm_message' ),
		'no_only_btn' => get_msg( 'user_no_only_label' )
	);
	
	$this->load->view( $template_path .'/components/delete_confirm_modal', $data );
?>