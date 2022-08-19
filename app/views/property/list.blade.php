


<span class="main-title">物業</span>
<br/>
<br/>
    <ul class="list-inline">
        <li>
            <span class="color-secondary">排序:</span>
        </li>
        <li>
            <!-- by post date -->
            <a class="std-link" href="{{ url('search/property/period/')}}" role="button">發佈時間</a>
        </li>
        <li>
            <!-- by price -->
            <a class="std-link" href="{{ url('search/property/price')}}" role="button">售價</a>
        </li>
        <li>
            <!-- by rentprice -->
            <a class="std-link" href="{{ url('search/property/rentprice')}}" role="button">租金</a>
        </li>
    </ul>








    <ul class="cbp-rfgrid">
        @foreach (array_chunk($properties->all(), 4) as $row)
        <div class='row'>
            @foreach($row as $property)

            <a href= '{{action("PropertyController@getPropertyDetail", array("id"=>$property->property_id)) }}' >
                <li>
                    <div class="list-wrapper">
                        <div class="thumbnail std-padding">


                            <div class="two-col">
                                <div class="left center">
                                    @if($photos[$property->property_id] != 'no_photo')
                                    {{ HTML::image( 'upload/' . $property->property_photo . '/thumbnail/' . $photos[$property->property_id], 'alt-text') }}
                                    @else
                                    <i class="icon-home-5x"></i>
                                    @endif
                                </div>
                                <div class="right">

                                    建築面積:
                                    <span class="pull-right">
                                        {{$property->property_structuresize}} 呎
                                    </span>
                                    <br/>
                                    實用面積:
                                    <span class="pull-right">
                                        {{$property->property_actualsize}} 呎
                                    </span>
                                    <br/>
                                    房間數目:
                                    <span class="pull-right">
                                        {{$property->property_nosroom}} 間
                                    </span>
                                    <br/>
                                    客廳數目:
                                    <span class="pull-right">
                                        {{$property->property_noslivingroom}} 個
                                    </span>
                                    <br/>


                                </div>

                            </div>




                            <hr/>



                            <div class="caption std-padding">
                                <span class="title">
                                    {{$property->property_name}}
                                </span>
                                <br/>
                                <small>{{$property->property_updated_at}}</small>
                                <hr/>

                                <p>


                                    大廈名稱:
                                    <span class="pull-right">
                                        {{$property->property_address}}
                                    </span>
                                    <br/>
                                    座:
                                    <span class="pull-right">
                                        {{$property->property_block}}
                                    </span>
                                    <br/>
                                    層:
                                    <span class="pull-right">
                                        {{$property->property_floor}}
                                    </span>
                                    <br/>
                                    <span class="std-bold color-secondary">
                                        @if($property->property_price != 0)

                                        <span class="pull-right">
                                            售: {{$property->property_price}} 萬
                                        </span>
                                        <br/>
                                        @endif
                                        @if($property->property_rentprice != 0)

                                        <span class="pull-right">
                                            租: {{$property->property_rentprice}} 千
                                        </span>
                                        @endif
                                    </span>
                                    <br/>

                                </p>
                            </div>
                        </div>
                    </li>
                </a>
                @endforeach
            </div>
            @endforeach
        </ul>


    {{ $properties->appends($querystrings)->links() }}


