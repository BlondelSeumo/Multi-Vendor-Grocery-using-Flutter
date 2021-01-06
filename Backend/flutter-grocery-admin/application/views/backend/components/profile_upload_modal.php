<div class="modal fade"  id="uploadProfile">

	<div class="modal-dialog">

		<div class="modal-content">

			<div class="modal-header">
				
				<h4 class="modal-title"><?php echo $title; ?></h4>
				
				<button class="close" data-dismiss="modal">					
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>

			</div>

			<?php
				$attributes = array('id' => 'upload-form','enctype' => 'multipart/form-data');
				echo form_open( $module_site_url ."/replace_profile_photo/". $img_parent_id, $attributes);
			?>

				<div class="modal-body">

					<div class="form-group">

						<label class="form-control-label"><?php echo get_msg('upload_photo')?></label>
						
						<br/>
						
						<input type="file" name="images1">

					</div>

				</div>

				<div class="modal-footer">

					<input type="submit" value="Upload" class="btn btn-sm btn-primary"/>

					<a href='#' class="btn btn-sm btn-primary" data-dismiss="modal"><?php echo get_msg('btn_cancel')?></a>

				</div>
			
			</form>

		</div>

	</div>

</div>