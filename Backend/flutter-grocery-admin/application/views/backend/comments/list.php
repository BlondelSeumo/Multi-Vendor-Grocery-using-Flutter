<div class="table-responsive animated fadeInRight">
	<table class="table m-0 table-striped">
		<tr class="text-center">
			<th><?php echo get_msg('comment_header'); ?></th>
			<th><?php echo get_msg('date'); ?></th>
			<th><?php echo get_msg('reply'); ?></th>
		</tr>
		
	
	<?php $count = $this->uri->segment(4) or $count = 0; ?>

	<?php if ( !empty( $comments ) && count( $comments->result()) > 0 ): ?>
		<?php foreach($comments->result() as $comm): ?>
			
			<tr>
				<td><?php 
						$comment = strip_tags($comm->header_comment);

						if (strlen($comment) > 40) {
	                    	
	                    	    $stringCut = substr($comment, 0, 40);
	                
	                    	    $comment = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
	                    	}

					echo $comment . "( By : " . $this->User->get_one($comm->user_id)->user_name; ?>
						
				</td>
				<td><?php 
						$detail_count = 0;
						$conds['header_id'] = $comm->id;
						$detail_count = $this->Commentdetail->count_all_by( $conds );
						
					?>
					<?php
						echo "<small style='padding: 0 50px'>$comm->added_date</small>";
					?>
				</td>
			
				<td>
					<a class="pull-right btn btn-sm btn-primary" href="<?php echo $module_site_url .'/edit/'. $comm->id; ?>" aria-expanded="true" aria-controls="collapseOne" style="margin-right: 10px;">
								<?php echo "<medium style='padding: 0 50px'>" . $detail_count . " Reply </medium>"; ?>
					</a>
				</td>
				
			</tr>

		<?php endforeach; ?>

	<?php else: ?>
			
		<?php $this->load->view( $template_path .'/partials/no_data' ); ?>

	<?php endif; ?>

</table>
</div>

