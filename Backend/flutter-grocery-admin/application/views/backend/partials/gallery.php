
<?php $this->load->view( $template_path .'/partials/nav' ); ?>

<div class="container-fluid" >
	<div class="content-wrapper"  style="background-color: #ffff;padding-left: 30px;">
		<div class="row">
			<div class="col-12 col-md-3 sidebar teamps-sidebar-open">
				
				<?php $this->load->view( $template_path .'/partials/sidebar' ); ?>
			</div>
			

			<div class="col-12 col-md-12 main teamps-sidebar-push">
				
				<?php 
					// load breadcrumb
					show_breadcrumb( $action_title );

					// show flash message
					flash_msg();
				?>
					
				<?php $this->load->view( $template_path .'/components/gallery' ); ?>

			</div>
		</div>
	</div>
</div>