<div class="row my-3" style="padding: 10px 30px 10px 30px;">	
	<div class='col-9'>
		<?php
			$attributes = array('id' => 'search-form', 'enctype' => 'multipart/form-data');
			echo form_open( $module_site_url .'/search', $attributes);
		?>
		<!-- end form-inline -->
		<div class="form-inline">

			<div class="form-group">
				<?php echo form_input(array(
					'name' => 'searchterm',
					'value' => set_value( 'searchterm' , $searchterm ),
					'class' => 'form-control form-control-sm',
					'placeholder' => get_msg( 'btn_search' ),
					'style' => 'float: left; margin-right: 20px;'
				)); ?>
			</div>

			<div class="form-group">
				<label>
					<?php echo get_msg('deli_status_label')?>
				</label>

				<select class="form-control form-control-sm mr-3 ml-3" name="deliboy_status" id="deliboy_status">
					<option value=""><?php echo get_msg('All');?></option>

					<?php
					$array = array('Pending' => 2, 'Approved' => 1, 'Reject' => 3);
						foreach ($array as $key=>$value) {
							
							if($value == $deliboy_status) {
	    						echo '<option value="'.$value.'" selected>'.$key.'</option>';
	    					} else {
	    						echo '<option value="'.$value.'">'.$key.'</option>';
	    					}
						}
					?>
				</select>

			</div>
			
			<div class="form-group" style="padding-left: 10px;padding-top: 5px;">
			  	<button type="submit" value="submit" name="submit" class="btn btn-sm btn-primary">
			  		<?php echo get_msg( 'btn_search' )?>
			  	</button>
		  	</div>

		  	<div class="row">
		  		<div class="form-group ml-3" style="padding-top: 5px;">
				  	<a href="<?php echo $module_site_url; ?>" class="btn btn-sm btn-primary">
						  		<?php echo get_msg( 'btn_reset' ); ?>
					</a>
				</div>
			</div>

		</div>
	</div>

	<div class='col-3'>
		<a href='<?php echo $module_site_url .'/add';?>' class='btn btn-sm btn-primary pull-right'>
			<i class='fa fa-plus'></i> 
			<?php echo get_msg( 'btn_add_new' ); ?>
		</a>
	</div>

</div>

<?php echo form_close(); ?>