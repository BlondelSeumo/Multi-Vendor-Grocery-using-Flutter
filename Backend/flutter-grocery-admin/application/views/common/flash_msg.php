<!-- Message -->
<?php if ( $this->session->flashdata( 'success' )): ?>

<div class="alert alert-success fade show">

	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	
	<?php echo $this->session->flashdata('success');?>

</div>

<?php elseif ( $this->session->flashdata( 'error' )): ?>

<div class="alert alert-danger fade show">

	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

	<?php echo $this->session->flashdata('error');?>
	
</div>

<?php elseif ( validation_errors() != false ): ?>

<div class="alert alert-danger fade show">

	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

	<?php echo validation_errors();?>
	
</div>

<?php elseif ( isset( $error )): ?>

<div class="alert alert-danger fade show">

	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

	<?php echo $error;?>
	
</div>

<?php endif; ?>