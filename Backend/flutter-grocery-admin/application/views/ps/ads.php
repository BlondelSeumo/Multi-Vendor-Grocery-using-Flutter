<?php if ( get_app_config( 'ads_on' ) == "1" ): ?>
    
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<!-- PanaceaSoft Website -->
	<ins class="adsbygoogle"
	     style="display:block"
	     data-ad-client="<?php echo get_app_config( 'ads_client' ); ?>"
	     data-ad-slot="<?php echo get_app_config( 'ads_slot' ); ?>"
	     data-ad-format="auto"></ins>
	<script>
	(adsbygoogle = window.adsbygoogle || []).push({});
	</script>
    
<?php endif; ?>