<script>
	<?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>

	function jqvalidate() {
		
		$('#shop-form').validate({
			rules:{
				name:{
					blankCheck : "",
					minlength: 3,
					remote: "<?php echo $module_site_url .'/ajx_exists/'.@$shop->id; ?>"
					
				},
				description:{
					required : true
				},
				cover:{
					required : true
				},
				icon:{
					required : true
				},
				lat:{
                    blankCheck : "",
                    indexCheck : "",
                    validChecklat : ""
			    },
			    lng:{
			     blankCheck : "",
			     indexCheck : "",
			     validChecklng : ""
			    }
			},
			messages:{
				name:{
					blankCheck : "<?php echo get_msg( 'err_shop_name' ) ;?>",
					minlength: "<?php echo get_msg( 'err_shop_len' ) ;?>",
					remote: "<?php echo get_msg( 'err_shop_exist' ) ;?>."
				},
				cover:{
					required : "<?php echo get_msg( 'err_image_missing' ) ;?>."
				},
				icon:{
					required : "<?php echo get_msg( 'err_image_missing' ) ;?>."
				},
			    lat:{
				     blankCheck : "<?php echo get_msg( 'err_lat' ) ;?>",
				     indexCheck : "<?php echo get_msg( 'err_lat_lng' ) ;?>",
				     validChecklat : "<?php echo get_msg( 'lat_invlaid' ) ;?>"
			    },
			    lng:{
			     	blankCheck : "<?php echo get_msg( 'err_lng' ) ;?>",
			     	indexCheck : "<?php echo get_msg( 'err_lat_lng' ) ;?>",
			     	validChecklng : "<?php echo get_msg( 'lng_invlaid' ) ;?>"
			    }
			}

		});

		// custom validation
		jQuery.validator.addMethod("blankCheck",function( value, element ) {
			
			   if(value == "") {
			    	return false;
			   } else {
			    	return true;
			   }
		});

		
		jQuery.validator.addMethod("indexCheck",function( value, element ) {
			
			   if(value == 0) {
			    	return false;
			   } else {
			    	return true;
			   };
			   
		});

		jQuery.validator.addMethod("validChecklat",function( value, element ) {
			    if (value < -90 || value > 90) {
			    	return false;
			    } else {
			   	 	return true;
			    }
		});

		jQuery.validator.addMethod("validChecklng",function( value, element ) {
			    if (value < -180 || value > 180) {
			    	return false;
			   } else {
			   	 	return true;
			   }
		});
		

	}
	

	<?php endif; ?>

	$('.delete-img').click(function(e){
			e.preventDefault();

			// get id and image
			var id = $(this).attr('id');

			// do action
			var action = '<?php echo $module_site_url .'/delete_cover_photo/'; ?>' + id + '/<?php echo @$shop->id; ?>';
			console.log( action );
			$('.btn-delete-image').attr('href', action);
			
		});

		$('.delete-shop').click(function(e){
		e.preventDefault();
		var id = $(this).attr('id');
		var image = $(this).attr('image');
		var action = '<?php echo site_url('/admin/shops/delete/');?>';
		$('.btn-delete-shop').attr('href', action + id);
	});
		
	$('#shoptag').change(function(){
		var shop_tag = $(this).val();

    	$('#tagselect').val(shop_tag);
    	
	});

	
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

    		var target = $(e.target).attr("value") // activated tab
    		$('#current_tab').val(target);

	});

	$('input[name="overall_tax_label"]').keyup(function(e)
                                {
		  if (/\D/g.test(this.value))
		  {
		    // Filter non-digits from input value.
		    this.value = this.value.replace(/\D.\D/g, '');
		  }
	});

	$('input[name="shipping_tax_label"]').keyup(function(e)
                                {
		  if (/\D/g.test(this.value))
		  {
		    // Filter non-digits from input value.
		    this.value = this.value.replace(/\D.\D/g, '');
		  }
	});

	$('input[name="minimum_order_amount"]').keyup(function(e)
                                {
		  if (/\D/g.test(this.value))
		  {
		    // Filter non-digits from input value.
		    this.value = this.value.replace(/\D.\D/g, '');
		  }
	});

</script>

<?php 
	// replace cover photo modal
	$data = array(
		'title' => get_msg('upload_photo'),
		'img_type' => 'shop',
		'img_parent_id' => @$shop->id
	);
	
	$this->load->view( $template_path .'/components/shop_photo_upload_modal', $data );
	// delete cover photo modal
	$this->load->view( $template_path .'/components/delete_cover_photo_modal' );

	// replace icon photo modal
	$data = array(
		'title' => get_msg('upload_photo'),
		'img_type' => 'shop-icon',
		'img_parent_id' => @$shop->id
	);
	
	$this->load->view( $template_path .'/components/icon_upload_modal', $data );
	// delete icon photo modal
	$this->load->view( $template_path .'/components/delete_icon_modal' ); 
?>
