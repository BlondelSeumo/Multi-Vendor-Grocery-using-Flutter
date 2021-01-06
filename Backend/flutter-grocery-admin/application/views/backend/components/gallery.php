
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="<?php echo base_url('assets/fileupload/blueimp/css/blueimp-gallery.min.css');?>">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="<?php echo base_url('assets/fileupload/jfileupload/css/jquery.fileupload.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/fileupload/jfileupload/css/jquery.fileupload-ui.css');?>">

<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="<?php echo base_url('assets/fileupload/jfileupload/css/jquery.fileupload-noscript.css');?>"></noscript>
<noscript><link rel="stylesheet" href="<?php echo base_url('assets/fileupload/jfileupload/css/jquery.fileupload-ui-noscript.css');?>"></noscript>

    <!-- The file upload form used as target for the file upload widget -->
    <form id="fileupload" method="POST" enctype="multipart/form-data">
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="col-lg-7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Add files...</span>
                    <input type="file" name="files[]" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start upload</span>
                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel upload</span>
                </button>
                <button type="button" class="btn btn-danger delete">
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" class="toggle">
                <!-- The global file processing state -->
                <span class="fileupload-process"></span>
            </div>
            <!-- The global progress state -->
            <div class="col-lg-5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
                <!-- The extended global progress state -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        
        <div class="alert upload-success-message hide">
        </div>
        
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
    </form>
    
	<div clas="row">
		<div class="col-sm-12">
			<!-- The blueimp Gallery widget -->
			<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
			    <div class="slides"></div>
			    <h3 class="title"></h3>
			    <a class="prev">‹</a>
			    <a class="next">›</a>
			    <a class="close">×</a>
			    <a class="play-pause"></a>
			    <ol class="indicator"></ol>
			</div>
		</div>
	</div>

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload">
        <td>
            <span class="preview"></span>
        </td>
        <td class="title">
                <input type="hidden" name="id[]" value="0"/>
                <input type="hidden" name="parent_id" value="<?php echo $_SESSION['parent_id'];?>"/>
                <input type="hidden" name="type" value="<?php echo $_SESSION['type'];?>"/>
                <label>Desc:</label>
                <textarea class="form-control" name="description[]"></textarea>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}

    {% if(file.default == 1){ %}

        <tr class="template-download" id="row" style="background-color: #F55252;">  
    
    {% } else { %}

        <tr class="template-download btn-default" id="row">

    {% } %}  
  
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td class="title">
                <input class="id" type="hidden" name="id[]" value="{%=file.id%}"/>
                <input class="parent_id" type="hidden" name="parent_id" value="<?php echo $_SESSION['parent_id'];?>"/>
                <label>Desc:</label>
                <textarea class="form-control desc" name="description[]">{%=file.description%}</textarea>
                {% if (file.error) { %}
                    <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
                <button class="btn btn-primary edit" style="padding-right:5px;margin-top:5px;">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Update</span>
                </button>
                <button class="btn btn-success default" name="default[]" value="{%=file.default%}" style="padding-right:5px;margin-top:5px;">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Default</span>
                </button>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" style="margin-top:5px;" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" style="margin-top:5px;" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>