<script>
function runAfterJQ() {

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

}
</script>

<?php
	// Delete Confirm Message Modal
	$data = array(
		'title' => get_msg( 'delete_att_label' ),
		'message' => get_msg( 'att_delete_confirm_message' ) .'<br>'. get_msg( 'att_yes_all_message' ) .'<br/>'. get_msg( 'att_no_only_message' ),
		'yes_all_btn' => get_msg( 'att_yes_all_label' ),
		'no_only_btn' => get_msg( 'att_no_only_label' )
	);
	
	$this->load->view( $template_path .'/components/delete_confirm_modal', $data );
?>