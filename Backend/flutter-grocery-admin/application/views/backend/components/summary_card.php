<div class="card bg-light mb-3">
	
	<div class="card-header">
		<?php echo $panel_title; ?>
		<span class="badge badge-warning pull-right"> Total : <?php echo $total_count; ?></span>
	</div>

		<div class="card-body">
			
			<h4 class="card-title">
				
				
			</h4>
    		
    		<div class="card-text">
    			
    			<?php if ( ! empty( $data )): ?>

					<?php foreach ( $data as $val ): ?>

						<p>
							<?php echo $val->user_name; ?>
							<br/>
							<small class="m-r">
								<a href="<?php echo $be_url .'/'. $module_name .'/edit/'. $val->user_id; ?>">
									<?php echo get_msg( 'check_for_detail' ); ?>
								</a>
							</small>
						</p>

					<?php endforeach; ?>

				<?php endif; ?>

    		</div>
  		</div>

	</div>

</div>