<?php $this->load->view( $template_path .'/partials/shop_nav' ); ?>

<div class="container-fluid">
	<div class="row">
		
		<div class="col-12 col-md-12 main teamps-sidebar-push">

			<?php flash_msg(); ?>

			<?php $this->load->view( $template_path .'/'. $module_path .'/search_form'); ?>

			<br/>

			
				<?php $this->load->view( $template_path .'/'. $module_path .'/list'); ?>
				
			<br/>

				<div class="container-fluid" style="margin-left: 20px;">
				<?php $this->load->view( $template_path .'/partials/pag' ); ?>
				</div>

			
		</div>
	</div>
</div>

<?php 
	$list_script_path = $template_path .'/'. $module_path .'/list_script';
	
	if ( is_view_exists( $list_script_path )) $this->load->view( $list_script_path ); 
?>