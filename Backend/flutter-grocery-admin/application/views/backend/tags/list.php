<div class="container-fluid" style="padding: 10px 30px 10px 30px;">
	<div class="table-responsive">
		<table class="table m-0 table-striped">
			<tr>
				<th><?php echo get_msg('no'); ?></th>
				<th><?php echo get_msg('tag_name'); ?></th>
				<th><?php echo get_msg('tag_icon'); ?></th>
				
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

		<?php if ( !empty( $tags ) && count( $tags->result()) > 0 ): ?>

			<?php foreach($tags->result() as $tag): ?>
				
				<tr>
					<td><?php echo ++$count;?></td>
					<td><?php echo $tag->name;?></td>

					<?php $default_photo = get_default_photo( $tag->id, 'tag-icon' ); ?>	

					<td><img src="<?php echo img_url( '/thumbnail/'. $default_photo->img_path ); ?>"/ width="80px"; height="80px";></td>

					<?php if ( $this->ps_auth->has_access( EDIT )): ?>
				
						<td>
							<a href='<?php echo $module_site_url .'/edit/'. $tag->id; ?>'>
								<i class='fa fa-pencil-square-o'></i>
							</a>
						</td>
					
					<?php endif; ?>
					
					<?php if ( $this->ps_auth->has_access( DEL )): ?>
						
						<td>
							<a herf='#' class='btn-delete' data-toggle="modal" data-target="#tagmodal" id="<?php echo "$tag->id";?>">
								<i class='fa fa-trash-o'></i>
							</a>
						</td>
					
					<?php endif; ?>
					
					<?php if ( $this->ps_auth->has_access( PUBLISH )): ?>
						
						<td>
							<?php if ( @$tag->status == 1): ?>
								<button class="btn btn-sm btn-success unpublish" id='<?php echo $tag->id;?>'>
								<?php echo get_msg('btn_yes'); ?></button>
							<?php else:?>
								<button class="btn btn-sm btn-danger publish" id='<?php echo $tag->id;?>'>
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
</div>

<script>

		// Publish Trigger
		$(document).delegate('.publish','click',function(){
			
			// get button and id
			var btn = $(this);
			var id = $(this).attr('id');

			// Ajax Call to publish
			$.ajax({
				url: "<?php echo $module_site_url .'/ajx_publish/'; ?>" + id,
				method: 'GET',
				success: function( msg ) {
					if ( msg == true ){
						btn.addClass('unpublish').addClass('btn-success')
							.removeClass('publish').removeClass('btn-danger')
							.html('Yes');
					} else {
						alert( "<?php echo get_msg( 'err_sy888' ); ?>" );
					}
				}
			});
		});

		// Unpublish Trigger
		$(document).delegate('.unpublish','click',function(){

			// get button and id
			var btn = $(this);
			var id = $(this).attr('id');

			// Ajax call to unpublish
			$.ajax({
				url: "<?php echo $module_site_url .'/ajx_unpublish/'; ?>" + id,
				method: 'GET',
				success: function( msg ){
					if ( msg == true )
						btn.addClass('publish').addClass('btn-danger')
							.removeClass('unpublish').removeClass('btn-success')
							.html('No');
					else
						alert( "<?php echo get_msg( 'err_sy4444s' ); ?>" );
				}
			});
		});

		$('.btn-delete').click(function(){
		
			// get id and links
			var id = $(this).attr('id');
			var btnYes = $('.btn-yes').attr('href');
			var btnNo = $('.btn-no').attr('href');

			// modify link with id
			$('.btn-yes').attr( 'href', btnYes + id );
			$('.btn-no').attr( 'href', btnNo + id );
		});

</script>


<?php
	// Delete Confirm Message Modal
	$data = array(
		'title' => get_msg( 'delete_tag_label' ),
		'message' =>  get_msg( 'tag_delete_confirm_message' ),
		'no_only_btn' => get_msg( 'tag_no_only_label' )
	);
	
	$this->load->view( $template_path .'/components/tag_delete_confirm_modal', $data );
?>
