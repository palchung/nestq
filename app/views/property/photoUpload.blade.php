

<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link type="text/css" rel="stylesheet" href="{{ asset('/fileupload/css/jquery.fileupload.css') }}"/>
<link type="text/css" rel="stylesheet" href="{{ asset('/fileupload/css/jquery.fileupload-ui.css') }}"/>
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript>
    <link type="text/css" rel="stylesheet" href="{{ asset('/fileupload/css/jquery.fileupload-noscript.css') }}"/>
</noscript>
<noscript>
    <link type="text/css" rel="stylesheet" href="{{ asset('/fileupload/css/jquery.fileupload-ui-noscript.css') }}"/>
</noscript>




<!-- The file upload form used as target for the file upload widget -->
<form id="fileupload" action="{{public_path()}}/fileupload/server/php/" method="POST" enctype="multipart/form-data">
    <!-- Redirect browsers with JavaScript disabled to the origin page -->
    <noscript><input type="hidden" name="redirect" value="http://blueimp.github.io/jQuery-File-Upload/"></noscript>
    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
    <div class="row fileupload-buttonbar">
        <div class="col-lg-12">
            <!-- The fileinput-button span is used to style the file input field as button -->
                            <span class="btn btn-success fileinput-button">
                                <i class="icon-plus-square"></i>
                                <span>新増相片...</span>
                                <input type="file" name="files[]" multiple>
                            </span>
            <button type="submit" class="btn btn-primary start">
                <i class="icon-arrow-up"></i>
                <span>開始上傳</span>
            </button>
            <button type="reset" class="btn btn-warning cancel">
                <i class="icon-times"></i>
                <span>取消</span>
            </button>
            <button type="button" class="btn btn-danger delete">
                <i class="icon-trash-o"></i>
                <span>刪除</span>
            </button>
            <input type="checkbox" class="toggle">
            <!-- The global file processing state -->
            <span class="fileupload-process"></span>
        </div>
        <!-- The global progress state -->
        <div class="col-lg-12 fileupload-progress fade">
            <!-- The global progress bar -->
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar progress-bar-success" style="width:0%;"></div>
            </div>
            <!-- The extended global progress state -->
            <div class="progress-extended">&nbsp;</div>
        </div>
    </div>
    <!-- The table listing the files available for upload/download -->
    <table role="presentation" class="table table-striped">
        <tbody class="files"></tbody>
    </table>

    <div class="dropzone">
        把所有相片拉進這裏
    </div>


</form>
<br>




<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
            <button class="btn btn-primary start" disabled>
                <i class="icon-arrow-up"></i>
                <span>Start</span>
            </button>
            {% } %}
            {% if (!i) { %}
            <button class="btn btn-warning cancel">
                <i class="icon-times"></i>
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
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
            <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
            <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                <i class="icon-trash-o"></i>
                <span>Delete</span>
            </button>
            <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
            <button class="btn btn-warning cancel">
                <i class="icon-times"></i>
                <span>Cancel</span>
            </button>
            {% } %}
        </td>
    </tr>
    {% } %}



</script>


<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script type="text/javascript" src="{{ asset('fileupload/js/vendor/jquery.ui.widget.js') }}"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<!--<script src="http://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>-->
<script type="text/javascript" src="{{ asset('js/libs/tmpl.min.js') }}"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script type="text/javascript" src="{{ asset('fileupload/js/load-image.all.min.js') }}"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<!--<script src="http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>-->
<script type="text/javascript" src="{{ asset('js/libs/canvas-to-blob.min.js') }}"></script>
<!-- blueimp Gallery script -->
<!--<script src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>-->
<script type="text/javascript" src="{{ asset('js/libs/jquery.blueimp-gallery.min.js') }}"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script type="text/javascript" src="{{ asset('fileupload/js/jquery.iframe-transport.js') }}"></script>
<!-- The basic File Upload plugin -->
<script type="text/javascript" src="{{ asset('fileupload/js/jquery.fileupload.js') }}"></script>
<!-- The File Upload processing plugin -->
<script type="text/javascript" src="{{ asset('/fileupload/js/jquery.fileupload-process.js') }}"></script>
<!-- The File Upload image preview & resize plugin -->
<script type="text/javascript" src="{{ asset('fileupload/js/jquery.fileupload-image.js') }}"></script>
<!-- The File Upload validation plugin -->
<script type="text/javascript" src="{{ asset('fileupload/js/jquery.fileupload-validate.js') }}"></script>
<!-- The File Upload user interface plugin -->
<script type="text/javascript" src="{{ asset('fileupload/js/jquery.fileupload-ui.js') }}"></script>
<!-- The main application script -->
<script type="text/javascript" src="{{ asset('fileupload/js/main.js') }}"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="js/cors/jquery.xdr-transport.js"></script>
<![endif]-->