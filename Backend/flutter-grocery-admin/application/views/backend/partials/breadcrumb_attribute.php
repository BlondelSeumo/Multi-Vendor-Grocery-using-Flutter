<ul class="breadcrumb" style="background-color: #ffff;">

	<li class="breadcrumb-item">
		<a href="<?php echo $be_url; ?>">
			<?php echo get_msg( 'dashboard' ); ?>
		</a>
	</li>

	<?php if ( !empty( $urls )): ?>

	<li class="breadcrumb-item">
		<span class="divider"></span>

		<a href=" <?php echo site_url() . "/admin/products/" ?> ">
			<?php 

				if(isset($urls[3]['special_mod_url'])) {
					
						echo ucfirst($urls[3]['special_mod_url'] );
					
				} else {
					
						echo ucfirst($urls[1]['special_mod_url']);
					
					}
			?>
		</a>
	</li>	

		<?php if ( !is_array( $urls )): ?>
		
		<li class="breadcrumb-item">
			<span class="divider"></span>
			
			<?php echo $urls; ?>

		</li>

		<?php else: ?>

			<?php  foreach ( $urls as $url ):  ?>

				<li class="breadcrumb-item">

					<span class="divider"></span>

					<?php if ( !empty( $url['url'] )): ?>


						<?php 
						if(isset( $url['mod_name'])) {
						if($url['mod_name'] != "") {
							
								$link = $be_url .'/'. $url['mod_name'] .''. $url['url'];
							
						} else {
							$link = $be_url .'/'. strtolower( $module_name ) .'/'. $url['url'];
						}
					}
						?>
					
						<a href="<?php echo $link; ?>">
							
							<?php 
							if(isset($url['label'])) {
								echo $url['label']; 
							}
							?>
						
						</a>
					
					<?php else: ?>
				
						<?php echo $url['label']; ?>

					<?php endif; ?>
				</li>

			<?php endforeach; ?>

		<?php endif; ?>

	<?php else: ?>

	<li class="breadcrumb-item">
		<?php echo ucfirst( strtolower( "$module_name" )); ?>
	</li>	

	<?php endif; ?>

</ul>