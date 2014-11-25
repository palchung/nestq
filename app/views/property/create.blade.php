<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
@if (isset($property->id) )
<script>var latLng = new google.maps.LatLng( {{$property->geolocation}} )</script>
@else
<script>var latLng = new google.maps.LatLng(22.366, 114.125)</script>
@endif
<script type="text/javascript" src="{{ asset('js/map.js') }}"></script>




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

                @include('property.photoUpload')

                <hr/>


                {{ Form::open(array('url'=>'property/create', 'class'=>'std-form')) }}

                <?php
                if (isset($property->id))
                {
                    $datas = array(
                        'name'          => $property->name,
                        'region_id'     => $property->region_id,
                        'category_id'   => $property->category_id,
                        'structuresize' => $property->structuresize,
                        'actualsize'    => $property->actualsize,
                        'price'         => $property->price,
                        'rentprice'     => $property->rentprice,
                        'soldorrent'    => $property->soldorrent,
                        'nosroom'       => $property->nosroom,
                        'noslivingroom' => $property->noslivingroom,
                        'address'       => $property->address,
                        'floor'         => $property->floor,
                        'room'          => $property->room,
                        'block'         => $property->block,
                        'id'            => $property->id,
                        'regionList'    => $regionList,
                        'categoryList'  => $categoryList,
                        );
} else
{
    $datas = array(
        'name'          => null,
        'region_id'     => null,
        'category_id'   => null,
        'structuresize' => null,
        'actualsize'    => null,
        'price'         => null,
        'rentprice'     => null,
        'soldorrent'    => null,
        'nosroom'       => null,
        'noslivingroom' => null,
        'address'       => null,
        'floor'         => null,
        'room'          => null,
        'block'         => null,
        'id'            => null,
        'regionList'    => $data['regionList'],
        'categoryList'  => $data['categoryList'],
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
        {{ Form::select('category_id', $datas['categoryList'], $datas['category_id'] - 1, array('class' =>
        'form-control')) }}
    </section>
    <section class="col-sm-2">
        {{ Form::label('交易類別') }}
    </section>
    <section class="col-sm-2">
        {{ Form::select('soldorrent', array('0' => '出租', '1' => '出售', '2' => '出租及出售'), $datas['soldorrent'],
        array('class' => 'form-control')) }}
    </section>

</div>
<br/>

<div class="row">
    <section class="col-sm-12">
        {{ Form::label('發佈標題') }}
        {{ Form::text('name', $datas['name'], array('class'=>'form-control', 'placeholder'=>'發佈標題')) }}
    </section>
</div>
<br/>


<div class="row">
    <section class="col-sm-6">
        {{ Form::label('售價') }}
        {{ Form::text('price', $datas['price'], array('class'=>'form-control', 'placeholder'=>'售價 (萬)')) }}
    </section>
    <section class="col-sm-6">
        {{ Form::label('租金') }}
        {{ Form::text('rentprice', $datas['rentprice'], array('class'=>'form-control', 'placeholder'=>'租金 (千)')) }}
    </section>
</div>
<br/>


<div class="row">
    <section class="col-sm-8">
        {{ Form::label('大廈名稱') }}
        {{ Form::text('address', $datas['address'], array('class'=>'form-control', 'placeholder'=>'大廈名稱')) }}
    </section>
    <section class="col-sm-4">
        {{ Form::label('座') }}
        {{ Form::text('block', $datas['block'], array('class'=>'form-control', 'placeholder'=>'座')) }}
    </section>
</div>
<br/>

<div class="row">
    <section class="col-sm-6">
        {{ Form::label('層數') }}
        {{ Form::text('floor', $datas['floor'], array('class'=>'form-control', 'placeholder'=>'層數')) }}
    </section>
    <section class="col-sm-6">
        {{ Form::label('室') }}
        {{ Form::text('room', $datas['room'], array('class'=>'form-control', 'placeholder'=>'室')) }}
    </section>
</div>
<br/>

<div class="row">
    <section class="col-sm-6">
        {{ Form::label('客廳數目') }}
        {{ Form::text('noslivingroom', $datas['noslivingroom'], array('class'=>'form-control', 'placeholder'=>'客廳數目'))
    }}
</section>
<section class="col-sm-6">
    {{ Form::label('房間數目') }}
    {{ Form::text('nosroom', $datas['nosroom'], array('class'=>'form-control', 'placeholder'=>'房間數目')) }}
</section>
</div>
<br/>

<div class="row">
    <section class="col-sm-6">
        {{ Form::label('建築面積') }}
        {{ Form::text('structuresize', $datas['structuresize'], array('class'=>'form-control', 'placeholder'=>'建築面積
        (呎)')) }}
    </section>
    <section class="col-sm-6">
        {{ Form::label('實用面積') }}
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

<span class="sub-title">特色</span>
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
                <div class="boxcheck-label">{{ $feature->name }}</div>
            </td>
            <td>
                {{ Form::checkbox('featuresList[]', $feature->id, $checked, ['class'=>'std-checkbox','id' =>
                'property-create-feature' . $feature->id]) }}<label class="checkbox-label"
                for={{'property-create-feature' .
                $feature->id}}></label>
            </td>

            @endforeach
        </tr>
    </span>
    @endforeach

</table>

<br/>
<span class="sub-title">附近設施</span>
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
                <div class="boxcheck-label">{{ $facility->name }}</div>
            </td>
            <td>
                {{ Form::checkbox('facilitiesList[]', $facility->id, $checked, ['class'=>'std-checkbox','id' =>
                'property-create-facility' . $facility->id]) }}<label class="checkbox-label"
                for={{'property-create-facility' .
                $facility->id}}></label>
            </td>

            @endforeach
        </tr>
    </span>
    @endforeach

</table>

<br/>

<span class="sub-title">交通</span>
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
                <div class="boxcheck-label">{{ $transportation->name }}</div>
            </td>
            <td>
                {{ Form::checkbox('transportationsList[]', $transportation->id, $checked, ['class'=>'std-checkbox','id'
                => 'property-create-transportation' . $transportation->id]) }}<label class="checkbox-label"
                for={{'property-create-transportation' . $transportation->id}}></label>
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
{{ Form::hidden('photo', $_SESSION['photofolder']) }}
{{ Form::hidden('geolocation', null, array('id' =>'info')) }}
{{ Form::honeypot('my_name', 'my_time') }}
{{ Form::submit('提交', array('class'=>'button_normal'))}}

<a class='button_normal' href="{{URL::previous()}}">取消</a>
{{ Form::close() }}


</div>
</div>
<!-- panel end -->

</div>


</div>

