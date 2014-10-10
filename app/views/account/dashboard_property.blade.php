@if ($properties != 'null')

<span class="title">物業</span>
<br/>
<br/>
<!-- property list -->

<table class="std-table">
    @foreach ($properties as $property)
    <tr>
        <td>
            <div class="std-border std-padding dashboard-property-wrapper white-bg">
                <ul class="media-list">
                    <li class="media">
                        <a class="pull-left" href="#">
                            @if($property->property_photo)
                            {{ HTML::image( 'upload/' . $property->property_photo . '/thumbnail/' . $photos[$property->property_id], 'alt-text') }}
                            @else
                            <i class="icon-home-5x"></i>
                            @endif
                        </a>
                        <div class="media-body">
                            <span class="media-heading underline">
                                {{ link_to_action('PropertyController@getPropertyDetail',
                                    $property->property_name,
                                    $parameters = array('id' => $property->property_id),
                                    $attributes = array('class' => 'std-link'))
                                }}
                            </span>

                            <!-- button -->
                            <span class="pull-right">
                                @if ($property->property_responsible_id == Auth::user()->id)
                                {{ Form::open(array('url'=>'property/edit', 'class'=>'')) }}
                                {{ Form::hidden('propertyId', $property->property_id) }}
                                {{ Form::hidden('directory', $property->property_photo) }}
                                {{ Form::submit('編輯', array('class'=>'button_normal'))}}
                                {{ Form::close() }}
                                @endif

                            </span>

                            <br/>
                            <small> - 最後更新: {{ $property->property_updated_at}}</small>
                            <br/>
                            售價: {{$property->property_price}} 萬 / 租金: {{$property->property_rentprice}} 千



                            @if ($property->property_owner_id != $property->property_responsible_id)
                            <hr/>
                            @if ($property->property_owner_id ==  Auth::user()->id)

                            {{HTML :: linkAction ('AccountController@getLookUpAccount', '代理資料', array ($property->property_responsible_id), array ('class' => 'std-link color-secondary'))}}
                            @elseif ($property->property_responsible_id ==  Auth::user()->id)
                            {{HTML :: linkAction ('AccountController@getLookUpAccount', '業主資料', array ($property->property_owner_id), array ('class' => 'std-link color-secondary'))}}
                            @endif

                            @elseif ($property->property_owner_id == $property->property_responsible_id)

                            @if($showPropertyRequest == 'yes')
                            <hr/>
                            @foreach ($requests as $request)
                            @if ($request->property_id == $property->property_id)
                            {{HTML :: linkAction ('PropertyController@getRequestByProperty',
                               '代理請求 :'. $request->nosrequest,
                               array ($property->property_id),
                               array ('class' => 'std-link color-secondary'))
                           }}
                           @endif
                           @endforeach
                           @endif

                           @endif

                           <hr/>

                           Nos of view: <span class="std-badge-primary">{{$property->view}}</span> -
                           Nos of activepush: <span class="std-badge-primary">{{$property->activepush}}</span> -
                           nos of activemail: <span class="std-badge-primary">{{$property->activemail}}</span> -
                           nos of conversation: <span class="std-badge-primary">{{$property->conversation}}</span>

                       </div>

                   </li>
               </ul>
           </div>

           <br/>

       </td>
   </tr>
   @endforeach
</table>


@else

暫沒有物業。<br/>
<br/>
您可以 <a href="{{ url('property/addproperty')}}" class="button_sm">發佈物業</a>
@endif








