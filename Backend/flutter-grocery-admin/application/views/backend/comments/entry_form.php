
<?php
	$attributes = array( 'id' => 'comm-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>


	<div class="panel-body">
		<div class="row">
			<?php 
					$comment = strip_tags($comm->header_comment);

					if (strlen($comment) > 40) {
                    	
                    	    $stringCut = substr($comment, 0, 40);
                
                    	    $comment = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
                    	}

				echo $comment; ?>

				<div class="table-responsive animated fadeInRight">
					<table class="table m-0 table-striped">
						<tr>
							<th> <label> <?php echo get_msg('comm_user'); ?> </label> </th>
							<th> <label><?php echo get_msg('comm_desc'); ?></label></th>
							<th> <label><?php echo get_msg('comm_date'); ?></label></th>
						
						</tr>
					<?php 
						$conds['header_id'] = $comm->id;
						$all_detail =  $this->Commentdetail->get_all_by( $conds );
						foreach($all_detail->result() as $comm_detail) { 
					?>
					<tr>
						<td><label><?php echo $this->User->get_one($comm_detail->user_id)->user_name ?></label></td>
						<td><label><?php echo $comm_detail->detail_comment ?></label></td>
						<td><label><?php echo $comm_detail->added_date ?></label></td>
					</tr>

					<?php } ?>
				</table>
			</div>
		</div>
	</div>

<div class="row my-4 animated fadeInRight">
	<div class="col-6">
			
		<div class="card card-info">
          <div class="card-header">
            <h3 class="card-title"><?php echo get_msg('write_reply')?></h3>
          </div>

	        <form role="form">
	            <div class="card-body">
					<div class="form-group">
						
						<?php echo form_textarea( array(
							'name' => 'detail_comment',
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg('write_reply_label'),
							'id' => 'detail_comment',
							'rows' => "5"
						)); ?>

					</div>
				</div>	

				<div class="card-footer">
					<button type="submit" class="btn btn-sm btn-primary">
						<?php echo get_msg('btn_reply')?>
					</button>
					<input type="hidden" name="header_id" id="header_id" value="<?php echo @$comm->id ?>">

					<a href="<?php echo $module_site_url; ?>" class="btn btn-sm btn-primary">
						<?php echo get_msg('btn_cancel')?>
					</a>
				</div>	
			</form>
		</div>	
	</div>
</div>

<?php echo form_close(); ?>


				