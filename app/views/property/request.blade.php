



<span class="title">Request</span>
<br/>
<br/>


<div class="two-col-panel">

    <div class="left-panel">


        <div class="namecard-grid">
            <div class="thumbnail">
                <img data-src="" alt="...">
                <div class="caption">
                    <h3> {{$property->property_name}} <small># {{$property->property_id}}</small></h3>

                    <hr/>

                    Structure Area: <span class="pull-right">{{$property->property_structuresize}}</span> <br/>
                    Actual Size: <span class="pull-right">{{$property->property_actualsize}}</span> <br/>
                    Price: <span class="pull-right">{{$property->property_price}}</span> <br/>
                    Rent Price: <span class="pull-right">{{$property->property_rentprice}}</span> <br/>
                    Nos of Living room: <span class="pull-right">{{$property->property_noslivingroom}}</span> <br/>
                    Nos of Room: <span class="pull-right">{{$property->property_nosroom}}</span> <br/>

                    <hr/>

                    Address: <br/> <span class="">{{$property->property_address}}</span> <br/>
                    Floor: <span class="pull-right">{{$property->property_floor}}</span> <br/>
                    room: <span class="pull-right">{{$property->property_room}}</span> <br/>
                    Block: <span class="pull-right">{{$property->property_block}}</span> <br/>

                </div>
            </div>
        </div>






    </div>

    <div class="right-panel">








        <table class="std-table">
            @foreach ($requests as $request)
            <tr>
                <td>
                    <div class="std-border std-padding dashboard-property-wrapper white-bg">
                        <ul class="media-list">
                            <li class="media">
                               <a href="" class="pull-left" data-lightbox="roadtrip">
                                 {{ HTML::image( 'upload/', 'alt-text') }}
                             </a>

                             <div class="media-body">
                                <span class="media-heading">

                                    {{ $request->agent_firstname }}
                                    {{ $request->agent_lastname }}
                                    - <span class="color-secondary">{{$request->agent_rating}}</span>

                                    - <small>last seen: {{$request->agent_last_seen}}</small>
                                </span>

                                <!-- button -->
                                <span class="pull-right">
                                 {{ Form::open(array('url'=>'property/agreement', 'class'=>'')) }}
                                 {{ Form::hidden('requestId', $request->id) }}
                                 {{ Form::submit('Accept', array('class'=>'button_normal'))}}
                                 {{ Form::close() }}
                             </span>
                             <br/>
                             <br/>

                             <small>Email:</small> <span class="">{{$request->agent_email}}</span> <br/>
                             <small>Cell Tel:</small>  <span class="">{{$request->agent_cell_tel}}</span> <br/>
                             <small>Tel:</small>  <span class="">{{$request->agent_tel}}</span> <br/>
                             <small>Company:</small> <span class="">{{$request->agent_company}}</span> <br/>

                             <hr/>
                            <small>Description:</small>
                            <br/>
                             {{$request->agent_description}}

                             <hr/>

                             <small> - Created at: {{ $request->created_at }}</small>
                             <br/>
                             {{ $request->requestmessage }}

                         </div>

                     </li>
                 </ul>
             </div>

             <br/>

         </td>
     </tr>
     @endforeach
 </table>

</div>



</div>

