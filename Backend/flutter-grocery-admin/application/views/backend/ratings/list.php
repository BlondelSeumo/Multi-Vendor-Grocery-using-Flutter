<div class="table-responsive animated fadeInRight">
	<table class="table m-0 table-striped">
	
		<tr>
			<th><?php echo get_msg('no'); ?></th>
			<th><?php echo get_msg('rating_product_name'); ?></th>
			<th><?php echo get_msg('rating_user_name'); ?></th>
			<th><?php echo get_msg('rating_title'); ?></th>
			<th><?php echo get_msg('rating_value'); ?></th>
			<th><?php echo get_msg('date'); ?></th>
			<?php if ( $this->ps_auth->has_access( DEL )): ?>
    		
	          	<th><span class="th-title"><?php echo get_msg('btn_delete')?></span></th>
	          
	        <?php endif; ?>
		</tr>

	<?php $count = $this->uri->segment(4) or $count = 0; ?>

	<?php if ( !empty( $ratings ) && count( $ratings->result()) > 0 ): ?>

		<?php foreach($ratings->result() as $rating): ?>
			
			<tr>
				<td><?php echo ++$count;?></td>
				<td><?php echo $this->Product->get_one($rating->product_id)->name ?></td>
				<td><?php echo $this->User->get_one($rating->user_id)->user_name?></td>
				<td><?php echo $rating->title; ?></td>
				<td><?php echo $rating->rating; ?></td>
				<td><?php echo $rating->added_date; ?></td>
				<td>
					<a herf='#' class='btn-delete' data-toggle="modal" data-target="#reportsmodal" id="<?php echo "$rating->id";?>">
						<i class='fa fa-trash-o'></i>
					</a>
				</td>
			</tr>
		<?php endforeach; ?>

		<?php else: ?>
			
		<?php $this->load->view( $template_path .'/partials/no_data' ); ?>

	<?php endif; ?>
</table>
</div>
<script>
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
</script>
<?php
	// Delete Confirm Message Modal
	$data = array(
		'title' => get_msg( 'delete_rating_label' ),
		'message' =>  get_msg( 'rating_yes_all_message' ),
		'no_only_btn' => get_msg( 'cat_no_only_label' )
	);
	
	$this->load->view( $template_path .'/components/report_delete_confirm_modal', $data );
?>