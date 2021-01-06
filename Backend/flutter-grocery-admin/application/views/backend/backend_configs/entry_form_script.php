<script>
	$('.delete-img').click(function(e){
		e.preventDefault();

		// get id and image
		var id = $(this).attr('id');

		// do action
		var action = '<?php echo $module_site_url .'/delete_cover_photo/'; ?>' + id + '/<?php echo @$backend->id; ?>';
		console.log( action );
		$('.btn-delete-image').attr('href', action);
	});

	$('input[name="landscape_width"]').keyup(function(e)
                                {
	  if (/[^\d.-]/g.test(this.value))
	  {
	    // Filter non-digits from input value.
	    this.value = this.value.replace(/[^\d.-]/g, '');
	  }

	});

	$('input[name="potrait_height"]').keyup(function(e)
                                {
	  if (/[^\d.-]/g.test(this.value))
	  {
	    // Filter non-digits from input value.
	    this.value = this.value.replace(/[^\d.-]/g, '');
	  }

	});

	$('input[name="square_height"]').keyup(function(e)
                                {
	  if (/[^\d.-]/g.test(this.value))
	  {
	    // Filter non-digits from input value.
	    this.value = this.value.replace(/[^\d.-]/g, '');
	  }

	});

	$('input[name="landscape_thumb_width"]').keyup(function(e)
                                {
	  if (/[^\d.-]/g.test(this.value))
	  {
	    // Filter non-digits from input value.
	    this.value = this.value.replace(/[^\d.-]/g, '');
	  }

	});

	$('input[name="potrait_thumb_height"]').keyup(function(e)
                                {
	  if (/[^\d.-]/g.test(this.value))
	  {
	    // Filter non-digits from input value.
	    this.value = this.value.replace(/[^\d.-]/g, '');
	  }

	});
</script>
<?php
	
	
	$data = array(
		'title' => get_msg('upload_backend_logo'),
		'img_type' => 'backend-logo',
		'img_parent_id' => @$backend->id
	);
	$this->load->view( $template_path .'/components/sidebar_logo_upload', $data );

	// replace icon icon modal
	$data = array(
		'title' => get_msg('upload_fav_icon'),
		'img_type' => 'fav-icon',
		'img_parent_id' => @$backend->id
	);
	$this->load->view( $template_path .'/components/favicon_upload_modal', $data );

	// delete icon photo modal
	$this->load->view( $template_path .'/components/delete_icon_modal' );


	$data = array(
		'title' => get_msg('upload_login_img'),
		'img_type' => 'login-image',
		'img_parent_id' => @$backend->id
	);

	$this->load->view( $template_path .'/components/photo_upload_modal', $data );

	// delete cover photo modal
	$this->load->view( $template_path .'/components/delete_cover_photo_modal' ); 


?>