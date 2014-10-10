



<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
@if (isset($property->id) )
{{  "<script>var latLng = new google.maps.LatLng(" . $property->geolocation . ")</script>" }}
@else
{{  "<script>var latLng = new google.maps.LatLng(22.366, 114.125)</script>" }}
@endif
<script type="text/javascript" src="{{ asset("js/map.js") }}"></script>


<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link type = "text/css" rel = "stylesheet" href = "{{ asset("/fileupload/css/jquery.fileupload.css") }}" />
<link type = "text/css" rel = "stylesheet" href = "{{ asset("/fileupload/css/jquery.fileupload-ui.css") }}" />
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link type = "text/css" rel = "stylesheet" href = "{{ asset("/fileupload/css/jquery.fileupload-noscript.css") }}" /></noscript>
<noscript><link type = "text/css" rel = "stylesheet" href = "{{ asset("/fileupload/css/jquery.fileupload-ui-noscript.css") }}" /></noscript>




<span class="main-title">物業表格</span>

@if ($errors)

<ul>
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>

@endif




<div class="two-col-panel">


    <div class="left-panel">

        <span class="title">
            小提示
        </span>
        <br/>
        <br/>
        <p>
            詳細的資料能讓用戶更容易搜尋到您的物業。
        </p>

    </div>


    <div class="right-panel">

        <div class="std-panel customWidth">
            <div class="panel-body">



                <span class="title">相片</span>
                <br/>
                <br/>

                <!-- The file upload form used as target for the file upload widget -->
                <form id="fileupload" action="{{ public_path() }}\fileupload\server\php\" method="POST" enctype="multipart/form-data">
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
                    <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>

                    <div class="dropzone">
                        把所有相片拉進這裏
                    </div>



                </form>
                <br>
                <!-- The blueimp Gallery widget -->
                <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
                    <div class="slides"></div>
                    <h3 class="title"></h3>
                    <a class="prev">‹</a>
                    <a class="next">›</a>
                    <a class="close">×</a>
                    <a class="play-pause"></a>
                    <ol class="indicator"></ol>
                </div>



                <hr/>



                {{ Form::open(array('url'=>'property/create', 'class'=>'std-form')) }}

                <?php
                if (isset($property->id)) {
                    $datas = array(
                        'name' => $property->name,
                        'region_id' => $property->region_id,
                        'category_id' => $property->category_id,
                        'structuresize' => $property->structuresize,
                        'actualsize' => $property->actualsize,
                        'price' => $property->price,
                        'rentprice' => $property->rentprice,
                        'soldorrent' => $property->soldorrent,
                        'nosroom' => $property->nosroom,
                        'noslivingroom' => $property->noslivingroom,
                        'address' => $property->address,
                        'floor' => $property->floor,
                        'room' => $property->room,
                        'block' => $property->block,
                        'id' => $property->id,
                        'regionList' => $regionList,
                        'categoryList' => $categoryList,
                        );
                } else {
                    $datas = array(
                        'name' => null,
                        'region_id' => null,
                        'category_id' => null,
                        'structuresize' => null,
                        'actualsize' => null,
                        'price' => null,
                        'rentprice' => null,
                        'soldorrent' => null,
                        'nosroom' => null,
                        'noslivingroom' => null,
                        'address' => null,
                        'floor' => null,
                        'room' => null,
                        'block' => null,
                        'id' => null,
                        'regionList' => $data['regionList'],
                        'categoryList' => $data['categoryList'],
                        );
                }
                ?>








<span class="title">基本資料</span>
<br/>
<br/>

<div class="row">
    <section class="col-sm-2">
        {{ Form::label('地區') }}
    </section>
    <section class="col-sm-2">
        {{ Form::select('region_id', $datas['regionList'], $datas['region_id'] - 1, array('class' => 'form-control')) }}
    </section>
    <section class="col-sm-2">
        {{ Form::label('類別') }}
    </section>
    <section class="col-sm-2">
        {{ Form::select('category_id', $datas['categoryList'], $datas['category_id'] - 1, array('class' => 'form-control')) }}
    </section>
    <section class="col-sm-2">
        {{ Form::label('交易類別') }}
    </section>
    <section class="col-sm-2">
        {{ Form::select('soldorrent', array('0' => '出租', '1' => '出售',  '2' => '出租及出售'), $datas['soldorrent'],  array('class' => 'form-control')) }}
    </section>

</div>
<br/>
<div class="row">
    <section class="col-sm-12">
        {{ Form::text('name', $datas['name'], array('class'=>'form-control', 'placeholder'=>'發佈標題')) }}
    </section>
</div>
<br/>



<div class="row">
    <section class="col-sm-6">
        {{ Form::text('price', $datas['price'], array('class'=>'form-control', 'placeholder'=>'售價 (萬)')) }}
    </section>
    <section class="col-sm-6">
        {{ Form::text('rentprice', $datas['rentprice'], array('class'=>'form-control', 'placeholder'=>'租金 (千)')) }}
    </section>
</div>
<br/>


<div class="row">
    <section class="col-sm-8">
        {{ Form::text('address', $datas['address'], array('class'=>'form-control', 'placeholder'=>'大廈名稱')) }}
    </section>
    <section class="col-sm-4">
        {{ Form::text('block', $datas['block'], array('class'=>'form-control', 'placeholder'=>'座')) }}
    </section>
</div>
<br/>
<div class="row">
    <section class="col-sm-6">
        {{ Form::text('floor', $datas['floor'], array('class'=>'form-control', 'placeholder'=>'層數')) }}
    </section>
    <section class="col-sm-6">
        {{ Form::text('room', $datas['room'], array('class'=>'form-control', 'placeholder'=>'室')) }}
    </section>
</div>
<br/>
<div class="row">
    <section class="col-sm-6">
        {{ Form::text('noslivingroom', $datas['noslivingroom'], array('class'=>'form-control', 'placeholder'=>'客廳數目')) }}
    </section>
    <section class="col-sm-6">
        {{ Form::text('nosroom', $datas['nosroom'], array('class'=>'form-control', 'placeholder'=>'房間數目')) }}
    </section>
</div>
<br/>
<div class="row">
    <section class="col-sm-6">
        {{ Form::text('structuresize', $datas['structuresize'], array('class'=>'form-control', 'placeholder'=>'建築面積 (呎)')) }}
    </section>
    <section class="col-sm-6">
        {{ Form::text('actualsize', $datas['actualsize'], array('class'=>'form-control', 'placeholder'=>'實用面積 (呎)')) }}
    </section>
</div>
<br/>


<hr/>



@if (!isset($property->id) )
<?php $features = $data['features']; ?>
<?php $facilities = $data['facilities']; ?>
<?php $transportations = $data['transportations']; ?>
@endif
<?php $nosOfRow = 6; ?>

<span class="title">特色</span>
<br/>
<br/>
<table class="std-table">

    @foreach (array_chunk($features->all(), $nosOfRow) as $row)
    <span class='row'>
        <tr>
            @foreach($row as $feature)

            <?php $checked = null ?>

            @if (isset($property->id) )
            @for ($j = 0; $j < count($property->feature); $j++)
            @if ($property->feature[$j]->id == $feature->id)
            <?php $checked = true ?>
            @endif
            @endfor
            @endif

            <td>
                <div class="searchbox-label">{{ $feature->name }}</div>
            </td>
            <td>
                {{ Form::checkbox('featuresList[]', $feature->id,  $checked, ['class'=>'std-checkbox','id' => 'property-create-feature' . $feature->id]) }}<label class="checkbox-label" for = {{'property-create-feature' . $feature->id}}></label>
            </td>

            @endforeach
        </tr>
    </span>
    @endforeach

</table>

<br/>
<span class="title">附近設施</span>
<br/>
<br/>
<table class="std-table">

    @foreach (array_chunk($facilities->all(), $nosOfRow) as $row)
    <span class='row'>
        <tr>
            @foreach($row as $facility)

            <?php $checked = null ?>

            @if (isset($property->id) )
            @for ($j = 0; $j < count($property->facility); $j++)
            @if ($property->facility[$j]->id == $facility->id)
            <?php $checked = true ?>
            @endif
            @endfor
            @endif

            <td>
                <div class="searchbox-label">{{ $facility->name }}</div>
            </td>
            <td>
                {{ Form::checkbox('facilitiesList[]', $facility->id,  $checked, ['class'=>'std-checkbox','id' => 'property-create-facility' . $facility->id]) }}<label class="checkbox-label" for = {{'property-create-facility' . $facility->id}}></label>
            </td>

            @endforeach
        </tr>
    </span>
    @endforeach

</table>

<br/>

<span class="title">交通</span>
<br/>
<br/>
<table class="std-table">

    @foreach (array_chunk($transportations->all(), $nosOfRow) as $row)
    <span class='row'>
        <tr>
            @foreach($row as $transportation)

            <?php $checked = null ?>

            @if (isset($property->id) )
            @for ($j = 0; $j < count($property->transportation); $j++)
            @if ($property->transportation[$j]->id == $transportation->id)
            <?php $checked = true ?>
            @endif
            @endfor
            @endif

            <td>
                <div class="searchbox-label">{{ $transportation->name }}</div>
            </td>
            <td>
                {{ Form::checkbox('transportationsList[]', $transportation->id,  $checked, ['class'=>'std-checkbox','id' => 'property-create-transportation' . $transportation->id]) }}<label class="checkbox-label" for = {{'property-create-transportation' . $transportation->id}}></label>
            </td>

            @endforeach
        </tr>
    </span>
    @endforeach

</table>































<hr/>


<table class="std-table">
    <tr>
        <td>
            <span class="title">地圖位置 - </span><span id="address"></span>

        </td>
    </tr>
    <tr>
        <td>
            <div id="mapCanvas"></div>
        </td>
    </tr>

</table>


<hr/>




@if (isset($property->id) )
{{ Form::hidden('propertyId', $datas['id']) }}
@endif
{{ Form::hidden('photo',  $_SESSION['photofolder']) }}
{{ Form::hidden('geolocation', null, array('id' =>'info')) }}




{{ Form::submit('提交', array('class'=>'button_normal'))}}

<a class ='button_normal'  href="{{URL::previous()}}">取消</a>
{{ Form::close() }}





















</div>
</div> <!-- panel end -->

</div>



</div>



































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
<script type="text/javascript" src="{{ asset("fileupload/js/vendor/jquery.ui.widget.js") }}"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="http://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script type="text/javascript" src="{{ asset("fileupload/js/load-image.all.min.js") }}"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- blueimp Gallery script -->
<script src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script type="text/javascript" src="{{ asset("fileupload/js/jquery.iframe-transport.js") }}"></script>
<!-- The basic File Upload plugin -->
<script type="text/javascript" src="{{ asset("fileupload/js/jquery.fileupload.js") }}"></script>
<!-- The File Upload processing plugin -->
<script type="text/javascript" src="{{ asset("/fileupload/js/jquery.fileupload-process.js") }}"></script>
<!-- The File Upload image preview & resize plugin -->
<script type="text/javascript" src="{{ asset("fileupload/js/jquery.fileupload-image.js") }}"></script>
<!-- The File Upload validation plugin -->
<script type="text/javascript" src="{{ asset("fileupload/js/jquery.fileupload-validate.js") }}"></script>
<!-- The File Upload user interface plugin -->
<script type="text/javascript" src="{{ asset("fileupload/js/jquery.fileupload-ui.js") }}"></script>
<!-- The main application script -->
<script type="text/javascript" src="{{ asset("fileupload/js/main.js") }}"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="js/cors/jquery.xdr-transport.js"></script>
<![endif]-->