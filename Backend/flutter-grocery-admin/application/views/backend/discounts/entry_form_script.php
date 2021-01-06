<script>
	<?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>

function updateDataTableSelectAllCtrl(table){
	   var $table             = table.table().node();
	   var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
	   var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
	   var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);

	   // If none of the checkboxes are checked
	   if($chkbox_checked.length === 0){
	      chkbox_select_all.checked = false;
	      if('indeterminate' in chkbox_select_all){
	         chkbox_select_all.indeterminate = false;
	      }

	   // If all of the checkboxes are checked
	   } else if ($chkbox_checked.length === $chkbox_all.length){
	      chkbox_select_all.checked = true;
	      if('indeterminate' in chkbox_select_all){
	         chkbox_select_all.indeterminate = false;
	      }

	   // If some of the checkboxes are checked
	   } else {
	      chkbox_select_all.checked = true;
	      if('indeterminate' in chkbox_select_all){
	         chkbox_select_all.indeterminate = true;
	      }
	   }
	}

	function jqvalidate() {

		$('#discount-form').validate({
			rules:{
				name:{
					blankCheck : "",
					minlength: 3,
					remote: "<?php echo $module_site_url .'/ajx_exists/'.@$discount->id; ?>"
				},
				percent :{
					required : true
				},
		      	image:{
					required : true
				}
			},
			messages:{
				name:{
					blankCheck : "<?php echo get_msg( 'err_dis_name' ) ;?>",
					minlength: "<?php echo get_msg( 'err_dis_len' ) ;?>",
					remote: "<?php echo get_msg( 'err_dis_exist' ) ;?>."
				},
				percent:{
					required : "<?php echo get_msg( 'err_dis_percent' ) ;?>"
				},
			    image:{
					required : "<?php echo get_msg( 'err_image_missing' ) ;?>."
				}
			}
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
			var action = '<?php echo $module_site_url .'/delete_cover_photo/'; ?>' + id + '/<?php echo @$discount->id; ?>';
			console.log( action );
			$('.btn-delete-image').attr('href', action);
			
		});
		var rows_selected = [<?php 

			if(isset($discount->id)) {
				if ( $discount->id == "" ){
					$conds['discount_id'] = "000";
				} else {
					$conds['discount_id'] = $discount->id;
					
				}
			} else {
				$conds['discount_id'] = "000";
			}

			$dis_prd = $this->ProductDiscount->get_all_by($conds)->result();
			
			$oldchkval = "";
			foreach ($dis_prd as $pd)
			{
					$oldchkval = $oldchkval . $pd->product_id . ",";
			
			}

			$oldchkval = substr($oldchkval, 0, -1);

			$tmp_arr = explode(",", $oldchkval);

			$temp = $tmp_arr;

			$result = "'" . implode ( "', '", $temp ) . "'";

			echo $result; 

		 ?>];
		<?php
		 	if(isset($discount->id)) {

			 	if ($discount->id == "") {
			 		 $discount_id = '000';
			 	} else {

			 	 	 $discount_id = $discount->id;
			 	}

		 	} else {
		 		 $discount_id = '000';
		 	} 
		?>

		var table = $('#product-table').DataTable({
			 "pageLength": 20,
		      'ajax':'<?php echo site_url('/admin/products/get_all_products_for_discount/') .  $discount_id ?>',
		      'columnDefs': [{
		         'targets': 0,
		         'searchable':false,
		         'orderable':false,
		         'width':'1%',
		         'className': 'dt-body-center',
		         'render': function (data, type, full, meta){
		             return '<input type="checkbox">';
		         }
		      }],
		      "columns": [
			    null,
			    null,
			    null,
			    null
			  ],
		      
		      'rowCallback': function(row, data, dataIndex){
		         // Get row ID
		         var rowId = data[0];

		         // If row ID is in the list of selected row IDs
		         if($.inArray(rowId, rows_selected) !== -1){
		            $(row).find('input[type="checkbox"]').prop('checked', true);
		            $(row).addClass('selected');
		         }
		      }
		   });

	   // Handle click on checkbox
	   $('#product-table tbody').on('click', 'input[type="checkbox"]', function(e){
	      var $row = $(this).closest('tr');

	      // Get row data
	      var data = table.row($row).data();

	      // Get row ID
	      var rowId = data[0];

	      // Determine whether row ID is in the list of selected row IDs 

	      var index = $.inArray(rowId, rows_selected);

	      // If checkbox is checked and row ID is not in list of selected row IDs
	      if(this.checked && index === -1){
	         rows_selected.push(rowId);

	      // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
	      } else if (!this.checked && index !== -1){
	         rows_selected.splice(index, 1);
	      }

	      if(this.checked){
	         $row.addClass('selected');
	      } else {
	         $row.removeClass('selected');
	      }

	      // Update state of "Select all" control
	      updateDataTableSelectAllCtrl(table);

	      // Prevent click event from propagating to parent
	      e.stopPropagation();
	   });

		// Handle click on table cells with checkboxes
	   $('#product-table').on('click', 'tbody td, thead th:first-child', function(e){
	      $(this).parent().find('input[type="checkbox"]').trigger('click');
	   });

	   // Handle click on "Select all" control
	   $('thead input[name="select_all"]', table.table().container()).on('click', function(e){
	      if(this.checked){
	         $('#product-table tbody input[type="checkbox"]:not(:checked)').trigger('click');
	      } else {
	         $('#product-table tbody input[type="checkbox"]:checked').trigger('click');
	      }

	      // Prevent click event from propagating to parent
	      e.stopPropagation();
	   });

	   // Handle table draw event
	   table.on('draw', function(){
	      // Update state of "Select all" control
	      updateDataTableSelectAllCtrl(table);
	   });
	    
	   // Handle form submission event 
	   $('#discount-form').on('submit', function(e){
	      var form = this;

	      // Iterate over all selected checkboxes
	      $.each(rows_selected, function(index, rowId){
	         // Create a hidden element 
	         $(form).append(
	             $('<input>')
	                .attr('type', 'hidden')
	                .attr('name', 'id[]')
	                .val(rowId)
	         );
	      });

	      // FOR DEMONSTRATION ONLY     
	      $('#example-console-rows').text(rows_selected.join(","));
	      $('#newchkval').val($('#example-console-rows').text());
	      
	      // Output form data to a console     
	      $('#example-console').text($(form).serialize());
	      console.log("Form submission", $(form).serialize());
	       
	      // Remove added elements
	      $('input[name="id\[\]"]', form).remove();
	       
	      // Prevent actual form submission
	      //e.preventDefault();
	   }); 

	   $('input[name="percent"]').keyup(function(e)
                                {
		  if (/\D/g.test(this.value))
		  {
		    // Filter non-digits from input value.
		    this.value = this.value.replace(/\D/g, '');
		  }
		});
	   
      $('[data-toggle="tooltip"]').tooltip(); 
	
	}
		

</script>

<?php 
	// replace cover photo modal
	$data = array(
		'title' => get_msg('upload_photo'),
		'img_type' => 'discount',
		'img_parent_id' => @$discount->id
	);

	$this->load->view( $template_path .'/components/photo_upload_modal', $data );

	// delete cover photo modal
	$this->load->view( $template_path .'/components/delete_cover_photo_modal' ); 
?>