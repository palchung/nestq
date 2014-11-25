<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>


{{  "<script>var latLng = new google.maps.LatLng(" . $property->property_geolocation . ")</script>" }}
<script type="text/javascript">
    function initialize() {
        var map = new google.maps.Map(document.getElementById('mapCanvas'), {
            zoom: 16,
            center: latLng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var marker = new google.maps.Marker({
            position: latLng,
            title: 'Address',
            map: map,
            draggable: false
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>

<span class="main-title">{{ $property->property_name }}</span>
<small>更新 - {{$property->property_updated_at}}</small>
<br/>
- {{$property->territory_name}} >> {{$property->region_name}} >> {{$property->category_name}}


<br/>
<hr/>

<div class="two-col">
    <div class="left">

        @if ($photos != 'no_photo')
        <div class="gallery">
            @foreach ($photos as $photo)
            <a href="{{ url('upload/' . $property->property_photo . '/' . $photo )}}" data-lightbox="roadtrip">
                {{ HTML::image( 'upload/' . $property->property_photo . '/thumbnail/' . $photo, 'alt-text') }}
            </a>
            @endforeach
        </div>
        @else


        <br/>


        <div class="media">
            <a class="pull-left" href="#">
                <i class="icon-home-5x"></i>
            </a>

            <div class="media-body">
                <h4 class="media-heading color-secondary">沒有相片</h4>
                ...
            </div>
        </div>


        @endif

    </div>

    <div class="right">
        <div class="property-info">
            <div class="ul-wrapper">
                <ul class="std-ul">
                    <li class="">大廈名稱: <span class="pull-right">{{$property->property_address}}</span></li>
                    <li class="">層: <span class="pull-right">{{$property->property_floor}}</span></li>
                    <li class="">室: <span class="pull-right">{{$property->property_room}}</span></li>
                    <li class="">座: <span class="pull-right">{{$property->property_block}}</span></li>
                </ul>
            </div>

            <div class="ul-wrapper">
                <ul class="std-ul">
                    <li class="">建築面積: <span class="pull-right">{{$property->property_structuresize}} 呎</span></li>
                    <li class="">實用面積: <span class="pull-right">{{$property->property_actualsize}} 呎</span></li>
                    <li class="">房間數量: <span class="pull-right">{{$property->property_nosroom}} 間</span></li>
                    <li class="">客廳數量: <span class="pull-right">{{$property->property_noslivingroom}} 個</span></li>
                    @if($property->property_price != 0)
                    <li class=""><span class="std-bold color-secondary">
                        <span class="pull-right">售: {{$property->property_price}} 萬</span></span></li>
                        @endif
                        @if($property->property_rentprice != 0)
                        <br/>
                        <li class=""><span class="std-bold color-secondary">
                            <span class="pull-right">租: {{$property->property_rentprice}} 千</span></span></li>
                            @endif


                        </ul>
                    </div>
                </div>
            </div>


        </div>


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

                  @if (isset($attr->id) )
                  @for ($j = 0; $j < count($attr->feature); $j++)
                  @if ($attr->feature[$j]->id == $feature->id)
                  <?php $checked = true ?>
                  @endif
                  @endfor
                  @endif

                  <td>
                      <div class="boxcheck-label">{{ $feature->name }}</div>
                  </td>
                  <td>
                      {{ Form::checkbox('featuresList[]', $feature->id, $checked, ['disabled','class'=>'std-checkbox','id' =>
                      'property-create-feature' . $feature->id]) }}<label class="checkbox-label" for={{'property-create-feature'
                      . $feature->id}}></label>
                  </td>

                  @endforeach
              </tr>
          </span>
          @endforeach

      </table>

      <hr/>
      <span class="sub-title">設施</span>
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
                  <div class="boxcheck-label">{{ $facility->name }}</div>
              </td>
              <td>
                  {{ Form::checkbox('facilitiesList[]', $facility->id, $checked, ['disabled','class'=>'std-checkbox','id' =>
                  'property-create-facility' . $facility->id]) }}<label class="checkbox-label"
                  for={{'property-create-facility' .
                  $facility->id}}></label>
              </td>

              @endforeach
          </tr>
      </span>
      @endforeach

  </table>

  <hr/>

  <span class="sub-title">交通</span>
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
              <div class="boxcheck-label">{{ $transportation->name }}</div>
          </td>
          <td>
              {{ Form::checkbox('transportationsList[]', $transportation->id, $checked,
                  ['disabled','class'=>'std-checkbox','id' => 'property-create-transportation' . $transportation->id])
              }}<label class="checkbox-label" for={{'property-create-transportation' . $transportation->id}}></label>
          </td>

          @endforeach
      </tr>
  </span>
  @endforeach

</table>



