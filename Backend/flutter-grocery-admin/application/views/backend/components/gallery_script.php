<script>
var baseUrl = "<?php echo base_url();?>";
var siteUrl ="<?php echo site_url()?>";
</script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?php echo base_url('assets/fileupload/vendor/jquery.ui.widget.js');?>"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="<?php echo base_url('assets/fileupload/blueimp/js/tmpl.min.js');?>"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="<?php echo base_url('assets/fileupload/blueimp/js/load-image.min.js');?>"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="<?php echo base_url('assets/fileupload/blueimp/js/canvas-to-blob.min.js');?>"></script>
<!-- blueimp Gallery script -->
<script src="<?php echo base_url('assets/fileupload/blueimp/js/jquery.blueimp-gallery.min.js');?>"></script>

<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo base_url('assets/fileupload/jfileupload/js/jquery.iframe-transport.js');?>"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url('assets/fileupload/jfileupload/js/jquery.fileupload.js');?>"></script>
<!-- The File Upload processing plugin -->
<script src="<?php echo base_url('assets/fileupload/jfileupload/js/jquery.fileupload-process.js');?>"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?php echo base_url('assets/fileupload/jfileupload/js/jquery.fileupload-image.js');?>"></script>
<!-- The File Upload audio preview plugin -->
<script src="<?php echo base_url('assets/fileupload/jfileupload/js/jquery.fileupload-audio.js');?>"></script>
<!-- The File Upload video preview plugin -->
<script src="<?php echo base_url('assets/fileupload/jfileupload/js/jquery.fileupload-video.js');?>"></script>
<!-- The File Upload validation plugin -->
<script src="<?php echo base_url('assets/fileupload/jfileupload/js/jquery.fileupload-validate.js');?>"></script>
<!-- The File Upload user interface plugin -->
<script src="<?php echo base_url('assets/fileupload/jfileupload/js/jquery.fileupload-ui.js');?>"></script>
<!-- The main application script -->
<script src="<?php echo base_url('assets/fileupload/jfileupload/js/main.js');?>"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="<?php echo base_url('assets/fileupload/jfileupload/cors/jquery.xdr-transport.js');?>"></script>
<![endif]-->
