<script>
	function jqvalidate() {

		$(document).ready(function(){
			$('#about-form').validate({
				rules:{
					title:{
						required: true,
						minlength: 4
					}
				},
				messages:{
					title:{
						required: "Please fill title.",
						minlength: "The length of title must be greater than 4"
					}
				}
			});
		});
	}

	$('.delete-img').click(function(e){
		e.preventDefault();

		// get id and image
		var id = $(this).attr('id');

		// do action
		var action = '<?php echo $module_site_url .'/delete_cover_photo/'; ?>' + id + '/<?php echo @$about->about_id; ?>';
		console.log( action );
		$('.btn-delete-image').attr('href', action);
	});

</script>

<?php
// replace cover photo modal
	$data = array(
		'title' => get_msg('upload_photo'),
		'img_type' => 'about',
		'img_parent_id' => @$about->about_id
	);

	$this->load->view( $template_path .'/components/photo_upload_modal', $data );

	// delete cover photo modal
	$this->load->view( $template_path .'/components/delete_cover_photo_modal' );

	// replace icon icon modal
	$data = array(
		'title' => get_msg('upload_icon'),
		'img_type' => 'nav',
		'img_parent_id' => @$about->about_id
	);
	$this->load->view( $template_path .'/components/sidebar_logo_upload', $data );

	$data = array(
		'title' => get_msg('upload_icon'),
		'img_type' => 'fav',
		'img_parent_id' => @$about->about_id
	);
	$this->load->view( $template_path .'/components/favicon_upload_modal', $data );
	// delete icon photo modal
	$this->load->view( $template_path .'/components/delete_icon_modal' ); 
?>