<script>

$('#shoptag').change(function(){
	var shop_tag = $(this).val();

	$('#tagselect').val(shop_tag);
	
});

$('.delete-img').click(function(e){

	e.preventDefault();

	// get id and image
	var id = $(this).attr('id');

	// do action
	var action = '<?php echo $module_site_url .'/delete_cover_photo/'; ?>' + id + '/<?php echo @$apv->id; ?>';
	console.log( action );
	$('.btn-delete-image').attr('href', action);
	
});

</script>

<?php 
	// replace cover photo modal
	$data = array(
		'title' => get_msg('upload_photo'),
		'img_type' => 'shop',
		'img_parent_id' => @$apv->id
	);
	
	$this->load->view( $template_path .'/components/shop_photo_upload_modal', $data );
	// delete cover photo modal
	$this->load->view( $template_path .'/components/delete_cover_photo_modal' );

	// replace icon photo modal
	$data = array(
		'title' => get_msg('upload_photo'),
		'img_type' => 'shop-icon',
		'img_parent_id' => @$apv->id
	);
	
	$this->load->view( $template_path .'/components/icon_upload_modal', $data );
	// delete icon photo modal
	$this->load->view( $template_path .'/components/delete_icon_modal' ); 
?>