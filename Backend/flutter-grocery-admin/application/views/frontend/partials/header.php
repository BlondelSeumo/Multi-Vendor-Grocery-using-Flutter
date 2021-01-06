<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>
  	<?php echo $title; ?>
		<?php 
			if ( isset( $action_title )) {
				echo " | ";
				if ( is_string( $action_title )) echo $action_title;
				else if ( is_array( $action_title )) echo $action_title[count($action_title) - 1]['label'];
			} 
	?>
  </title>
  	<link rel="icon" href="<?php echo base_url('assets/img/favicon.ico'); ?>">
  	<!-- Tell the browser to be responsive to screen width -->
  	<meta name="viewport" content="width=device-width, initial-scale=1">
 	<!-- Font Icon -->
    <link rel="stylesheet" href="<?php echo base_url('assets/frontend/fonts/material-icon/css/material-design-iconic-font.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/frontend/vendor/nouislider/nouislider.min.css'); ?>">
  	<link rel="stylesheet" href="<?php echo base_url('assets/frontend/css/style.css'); ?>">

	<!-- bootstrap 4 - text editor -->
	<link rel="stylesheet" href="<?php echo base_url('assets/bootstrap4/css/bootstrap.min.css'); ?>">

  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

	<!-- jQuery -->
  <script src="<?php echo base_url( 'assets/plugins/jquery/jquery.min.js' ); ?>"></script>
  <!-- Include the PayPal JavaScript SDK -->
  <script src="https://www.paypal.com/sdk/js?client-id=SB_CLIENT_ID">></script>
	
</head>
<body>
