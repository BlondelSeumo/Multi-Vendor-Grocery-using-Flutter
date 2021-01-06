  <?php $this->load->view( $template_path .'/partials/shop_nav' ); ?>

  <?php $this->load->view( $template_path .'/'. $view, $data ); ?>

 
  <?php 
	$form_script_path = $template_path .'/'. $module_path .'/entry_form_script';

	if ( is_view_exists( $form_script_path )) $this->load->view( $form_script_path );
?>