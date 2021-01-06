<script>
	<?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>

	function jqvalidate() {

		$('#product-form').validate({
			rules:{
				"images[]":{
					required: true
				},
				cat_id: {
		       		indexCheck : ""
		      	},
		      	sub_cat_id: {
		       		indexCheck : ""
		      	}
			},
			messages:{
				"images[]":{
					required: "Please File Upload Photo."
				},
				cat_id:{
			       indexCheck: "<?php echo $this->lang->line('f_item_cat_required'); ?>"
			    },
			    sub_cat_id:{
			       indexCheck: "<?php echo $this->lang->line('f_item_subcat_required'); ?>"
			    }
			},

			submitHandler: function(form) {
		        if ($("#product-form").valid()) {
		            form.submit();
		        }
		    }

		});
		
		jQuery.validator.addMethod("indexCheck",function( value, element ) {
			
			   if(value == 0) {
			    	return false;
			   } else {
			    	return true;
			   };
			   
		});
			jQuery.validator.addMethod("blankCheck",function( value, element ) {
			
			   if(value == "") {
			    	return false;
			   } else {
			   	 	return true;
			   }
		});

	}

	<?php endif; ?>
	function runAfterJQ() {


		$('.delete-img').click(function(e){
			e.preventDefault();

			// get id and image
			var id = $(this).attr('id');

			// do action
			var action = '<?php echo $module_site_url .'/delete_cover_photo/'; ?>' + id + '/<?php echo @$product->id; ?>';
			console.log( action );
			$('.btn-delete-image').attr('href', action);
			
		});
		  
		$('#cat_id').on('change', function() {

				var value = $('option:selected', this).text().replace(/Value\s/, '');

				var catId = $(this).val();
				// alert("adfasd"+ catId);
				 
				$.ajax({
					url: '<?php echo site_url() . '/admin/products/get_all_sub_categories/';?>' + catId,
					method: 'GET',
					dataType: 'JSON',
					success:function(data){
						$('#sub_cat_id').html("");
						$.each(data, function(i, obj){
						    $('#sub_cat_id').append('<option value="'+ obj.id +'">' + obj.name+ '</option>');
						});
						$('#name').val($('#name').val() + " ").blur();
						$('#sub_cat_id').trigger('change');
					}
				});
			});

			//For File Upload 
			$("#fileUpload").on('change', function () {

			     //Get count of selected files
			     var countFiles = $(this)[0].files.length;

			     var imgPath = $(this)[0].value;
			     var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
			     var image_holder = $("#image-holder");
			     image_holder.empty();

			     if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
			         if (typeof (FileReader) != "undefined") {

			             //loop for each file selected for uploaded.
			             for (var i = 0; i < countFiles; i++) {

			                 var reader = new FileReader();
			                 reader.onload = function (e) {
			                     $("<img />", {
			                         "src": e.target.result,
			                             "class": "thumb-image"
			                     }).appendTo(image_holder);
			                 }

			                 image_holder.show();
			                 reader.readAsDataURL($(this)[0].files[i]);
			             }

			         } else {
			             alert("This browser does not support FileReader.");
			         }
			     } else {
			         alert("Pls select only images");
			     }
			 });

		// colorpicker
		$('.my-colorpicker2').colorpicker()

		// add input colorpicker and count colorpicker
     	$(document).ready(function () {

     		var edit_product_check = $('#edit_product').val();


     		if(edit_product_check == 0) {
     			//new product
     			var counter = 2;
     		} else {
     			//edit product
     			var counter =  parseInt($('#color_total_existing').val())+2;
     		}
     		$('#color_total_existing').val(counter);

      		$("#addColor").click(function () {
      			
				
      		 	var newTextBoxDiv = $(document.createElement('div'))
	     		.attr("id", "colorvalue"+counter)
	     		.attr("class", 'input-group my-colorpicker2 colorpicker-element');

	     		newTextBoxDiv.after().html(
	      		'<input class="form-control form-control-sm mt-1" type="text" name="colorvalue' + counter + 
	      		'" id="colorvalue' + counter + '" value="" ><div class="input-group-addon mt-1"><i></i></div>');

	      		newTextBoxDiv.appendTo("#color-picker-group");
				$('#colorvalue'+counter).colorpicker({});
				counter++;

				$( ".CounterTextBoxDiv" ).remove();
				var newCounterTextBoxDiv = $(document.createElement('div'))
	     		.attr("id", 'CounterTextBoxDiv' + counter);

	     		newCounterTextBoxDiv.after().html(
	      		'<input type="hidden" name="color_total" id="color_total" value=" '+ counter +'" >');

	      		newCounterTextBoxDiv.appendTo(".my-colorpicker2");

	      		

      		});
      	});

      	// add specification
      	$(document).ready(function () {
     		//add new product
      		var edit_product_check = $('#edit_product').val();


     		if(edit_product_check == 0) {
     			//new product
     			var counter = 2;
     		} else {
     			//edit product
     			var counter =  parseInt($('#spec_total_existing').val())+2;
     		}

      		$('#spec_total_existing').val(counter);

      		$('#addspec').click(function () {

      			var newTextBoxDiv = $(document.createElement('div'))
	     		.attr("class",'col-md-6',"id", 'TextBoxDiv' + counter);

	     		newTextBoxDiv.after().html(
	      		'<div class="form-group"><label>Title : '+counter+'</label><input class="form-control form-control-sm" type="text" name="prd_spec_title' + counter + 
	      		'" id="prd_spec_title' + counter + '" value="" ></div><div class="form-group"><label>Description : '+counter+'</label><input class="form-control form-control-sm" type="text" name="prd_spec_desc' + counter + 
	      		'" id="prd_spec_desc' + counter + '" value="" ></div>');
    
	      		newTextBoxDiv.appendTo("#spec_data");
	      		counter++;
	      		
	      		$( "#CounterTextBoxDiv" ).remove();
				var newCounterTextBoxDiv = $(document.createElement('div'))
	     		.attr("id", 'CounterTextBoxDiv' + counter);

	     		newCounterTextBoxDiv.after().html(
	      		'<input type="hidden" name="spec_total" id="spec_total" value=" '+ counter +'" >');

	      		newCounterTextBoxDiv.appendTo("#spec_data");

	      		
      		});
      	});
    }

</script>
<?php 
	// replace cover photo modal
	$data = array(
		'title' => get_msg('upload_photo'),
		'img_type' => 'product',
		'img_parent_id' => @$product->id
	);

	$this->load->view( $template_path .'/components/photo_upload_modal', $data );

	// delete cover photo modal
	$this->load->view( $template_path .'/components/delete_cover_photo_modal' ); 
?>