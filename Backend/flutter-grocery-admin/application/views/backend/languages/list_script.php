<script>
function runAfterJQ() {

	$(document).ready(function(){
		
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
					if ( msg == 'true' )
						btn.addClass('unpublish').addClass('btn-success')
							.removeClass('publish').removeClass('btn-danger')
							.html('Active');
							
					else
						alert( "<?php echo get_msg( 'err_sys' ); ?>" );
					location.reload();
				}
			});
		});
		
		// Unpublish Trigger
		$(document).delegate('.unpublish','click',function(e){
  			alert( "<?php echo get_msg( 'cannot_deactive' ); ?>" );
			e.preventDefault();
			
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
		'title' => get_msg( 'delete_lang_label' ),
		'message' => get_msg( 'lang_delete_confirm_message' ) .'<br>',
		'yes_all_btn' => get_msg( 'lang_yes_all_label' ),
		'no_only_btn' => get_msg( 'lang_no_only_label' )
	);
	
	$this->load->view( $template_path .'/components/delete_language_modal', $data );

	$this->load->view( $template_path .'/components/warning_confirm_modal');
?>
