<div class="modal fade"  id="warningModal">

	<div class="modal-dialog">
		
		<div class="modal-content">

			<div class="modal-header">

				<h4 class="modal-title"><?php echo get_msg( 'lang_title' ); ?></h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
			</div>

			<div class="modal-body">
				<p><?php echo get_msg( 'lang_warning' ); ?></p>
			</div>

			<div class="modal-footer">

				<a href='#' class="btn btn-sm btn-primary" data-dismiss="modal">
				<?php echo get_msg( 'btn_ok' )?></a>
			</div>

		</div><!-- /.modal-content -->

	</div><!-- /.modal-dialog -->

</div><!-- /.modal -->