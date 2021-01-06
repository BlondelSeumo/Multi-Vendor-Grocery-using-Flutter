<div class="modal fade"  id="deletePhoto">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				
				<h4 class="modal-title"><?php echo get_msg('del_cover_photo')?></h4>
				
				<button class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>

			</div>
			<div class="modal-body">
				<p><?php echo get_msg('del_cover_photo_confirm')?></p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-sm btn-primary btn-delete-image"><?php echo get_msg('btn_yes')?></a>
				<a href='#' class="btn btn-sm btn-primary" data-dismiss="modal"><?php echo get_msg('btn_cancel')?></a>
			</div>
		</div>
	</div>			
</div>