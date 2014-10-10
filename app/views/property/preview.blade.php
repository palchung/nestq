<?php session_start(); ?>


<span class="title"> 預覽</span>
<br/>
<br/>





@foreach ($properties as $property)


<div class="two-col-panel">

    <div class="left-panel">



        {{ Form::open(array('url'=>'property/edit', 'class'=>'form-signup')) }}
        {{ Form::hidden('propertyId', $property->property_id) }}
        {{ Form::hidden('directory', $property->property_photo) }}
        {{ Form::submit('編輯物業資訊', array('class'=>'button_lg'))}}
        {{ Form::close() }}

        <br/>

        {{ Form::open(array('url'=>'property/publish', 'class'=>'form-signup')) }}
        {{ Form::hidden('propertyId', $property->property_id) }}
        {{ Form::submit('發佈', array('class'=>'button_lg'))}}
        {{ Form::close() }}



    </div>


    <div class="right-panel">


<div class="std-border white-bg std-padding">

        <span class="main-title">{{ $property->property_name }}</span> 更新: {{$property->property_updated_at}}
        <br/>
        - {{$property->territory_name}} >> {{$property->region_name}} >> {{$property->category_name}}


        <br/>
        <hr/>

        <div class="two-col">
            <div class="left">

              @if ($photos != "no_photo")
              <div class="gallery">
                @foreach ($photos as $photo)
                <a href="{{ url('upload/' . $property->property_photo . '/' . $photo )}}" data-lightbox="roadtrip">
                  {{ HTML::image( 'upload/' . $property->property_photo . '/thumbnail/' . $photo, 'alt-text') }}
              </a>
              @endforeach
          </div>
          @else
          no photo
          @endif

      </div>

      <div class="right">
          <div class="property-info">
            <div class="ul-wrapper">
              <ul class="std-ul">
                <li class="">大廈: <span class="pull-right">{{$property->property_address}}</span></li>
                <li class="">層: <span class="pull-right">{{$property->property_floor}}</span></li>
                <li class="">室: <span class="pull-right">{{$property->property_room}}</span></li>
                <li class="">座: <span class="pull-right">{{$property->property_block}}</span></li>
            </ul>
        </div>
        <br/>
        <div class="ul-wrapper">
          <ul class="std-ul">
            <li class="">建築面積: <span class="pull-right">{{$property->property_structuresize}}</span></li>
            <li class="">實用面積: <span class="pull-right">{{$property->property_actualsize}}</span></li>
            <li class="">房間數量: <span class="pull-right">{{$property->property_nosroom}}</span></li>
            <li class="">客廳數量: <span class="pull-right">{{$property->property_noslivingroom}}</span></li>
            <li class=""><b>售價: <span class="pull-right">{{$property->property_price}}</span>萬</b></li>
            <li class=""><b>租金: <span class="pull-right">{{$property->property_rentprice}}</span>千</b></li>
        </ul>
    </div>
</div>
</div>


</div>



<hr/>

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

        @if (isset($attr->id) )
        @for ($j = 0; $j < count($attr->feature); $j++)
        @if ($attr->feature[$j]->id == $feature->id)
        <?php $checked = true ?>
        @endif
        @endfor
        @endif

        <td>
          <div class="searchbox-label">{{ $feature->name }}</div>
      </td>
      <td>
          {{ Form::checkbox('featuresList[]', $feature->id,  $checked, ['disabled','class'=>'std-checkbox','id' => 'property-create-feature' . $feature->id]) }}<label class="checkbox-label" for = {{'property-create-feature' . $feature->id}}></label>
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

        @if (isset($attr->id) )
        @for ($j = 0; $j < count($attr->facility); $j++)
        @if ($attr->facility[$j]->id == $facility->id)
        <?php $checked = true ?>
        @endif
        @endfor
        @endif

        <td>
          <div class="searchbox-label">{{ $facility->name }}</div>
      </td>
      <td>
          {{ Form::checkbox('facilitiesList[]', $facility->id,  $checked, ['disabled','class'=>'std-checkbox','id' => 'property-create-facility' . $facility->id]) }}<label class="checkbox-label" for = {{'property-create-facility' . $facility->id}}></label>
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

        @if (isset($attr->id) )
        @for ($j = 0; $j < count($attr->transportation); $j++)
        @if ($attr->transportation[$j]->id == $transportation->id)
        <?php $checked = true ?>
        @endif
        @endfor
        @endif

        <td>
          <div class="searchbox-label">{{ $transportation->name }}</div>
      </td>
      <td>
          {{ Form::checkbox('transportationsList[]', $transportation->id,  $checked, ['disabled','class'=>'std-checkbox','id' => 'property-create-transportation' . $transportation->id]) }}<label class="checkbox-label" for = {{'property-create-transportation' . $transportation->id}}></label>
      </td>

      @endforeach
  </tr>
</span>
@endforeach

</table>


<hr/>





</div>






</div>

</div>



@endforeach




















