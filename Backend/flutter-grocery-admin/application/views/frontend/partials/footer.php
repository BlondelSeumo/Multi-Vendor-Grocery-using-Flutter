<!-- Bootstrap 4 -->
<script src="<?php echo base_url( 'assets/plugins/bootstrap4/js/bootstrap.bundle.min.js' ); ?>"></script>
<!-- jquery validate -->
<script src="<?php echo base_url( 'assets/validator/jquery.validate.js' ); ?>"></script>
        <script type="text/javascript">
          
          // functions to run after jquery is loaded
          if ( typeof runAfterJQ == "function" ) runAfterJQ();

          <?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>
            
            // functions to run after jquery is loaded
            if ( typeof jqvalidate == "function" ) jqvalidate();

          <?php endif; ?>

                $('.page-sidebar-menu li').removeClass('active');

                // highlight submenu item
                $('li a[href="' + this.location.pathname + '"]').parent().addClass('active');

                // Highlight parent menu item.
                $('ul a[href="' + this.location.pathname + '"]').parents('li').addClass('active');

                

        </script>

<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url('assets/select2/select2.min.css'); ?>">
<script src="<?php echo base_url( 'assets/select2/select2.full.min.js' ); ?>"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();                                    
    });
</script>

</body>
</html>