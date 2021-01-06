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
		
		$('#collection-form').validate({
			rules:{
				name:{
					blankCheck : "",
					minlength: 3,
					remote: "<?php echo $module_site_url .'/ajx_exists/'.@$collection->id; ?>"
				},
		      	image:{
					required : true
				}
			},
			messages:{
				name:{
					blankCheck : "<?php echo get_msg( 'err_collect_name' ) ;?>",
					minlength: "<?php echo get_msg( 'err_collect_len' ) ;?>",
					remote: "<?php echo get_msg( 'err_collect_exist' ) ;?>."
				},
			    image:{
					required : "<?php echo get_msg( 'err_image_missing' ) ;?>."
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
		
	}

	<?php endif; ?>

	function runAfterJQ() {

		$('.delete-img').click(function(e){
			e.preventDefault();

			// get id and image
			var id = $(this).attr('id');

			// do action
			var action = '<?php echo $module_site_url .'/delete_cover_photo/'; ?>' + id + '/<?php echo @$collection->id; ?>';
			console.log( action );
			$('.btn-delete-image').attr('href', action);
			
		});
		var rows_selected = [<?php 

			if(isset($collection->id)) {
				if ( $collection->id == "" ){
					$conds['collection_id'] = "000";
				} else {
					$conds['collection_id'] = $collection->id;
					
				}
			} else {
				$conds['collection_id'] = "000";
			}

			$dis_prd = $this->Productcollection->get_all_by($conds)->result();
			
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
		 	if(isset($collection->id)) {

			 	if ($collection->id == "") {
			 		 $collection_id = '000';
			 	} else {

			 	 	 $collection_id = $collection->id;
			 	}

		 	} else {
		 		 $collection_id = '000';
		 	} 
		?>
		var table = $('#product-table').DataTable({
			 "pageLength": 20,
		      'ajax':'<?php echo site_url('/admin/products/get_all_products_for_collection/') .  $collection_id ?>',
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
	   $('#collection-form').on('submit', function(e){
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


	   
      $('[data-toggle="tooltip"]').tooltip(); 
	
	}
		

</script>

<?php 
	// replace cover photo modal
	$data = array(
		'title' => get_msg('upload_photo'),
		'img_type' => 'collection',
		'img_parent_id' => @$collection->id
	);

	$this->load->view( $template_path .'/components/photo_upload_modal', $data );

	// delete cover photo modal
	$this->load->view( $template_path .'/components/delete_cover_photo_modal' ); 
?>