
<span class="title">Agreement</span>
<br/>
<br/>


<div class="two-col-panel">
    <div class="left-panel">

        <span class="sub-title">Rule</span>
        <br/>

        some description goes here

    </div>
    <div class="right-panel">


        <div class="std-border white-bg std-padding">



            <div class="two-col">

                <div class="left">


                    <span class="sub-title">Property</span>
                    <hr/>






                    <div class="media">
                      <a href="{{ url('upload/' . $agreement->property_photo . '/' )}}"
                       class="pull-left" data-lightbox="roadtrip">
                       {{ HTML::image( 'upload/' . $agreement->property_photo . '/thumbnail/' , 'alt-text') }}
                   </a>
                   <div class="media-body">
                    <h4 class="media-heading">{{$agreement->property_name}}</h4>

                    Structure Area: <span class="pull-right">{{$agreement->property_structuresize}}</span> <br/>
                    Actual Size: <span class="pull-right">{{$agreement->property_actualsize}}</span> <br/>
                    Price: <span class="pull-right">{{$agreement->property_price}}</span> <br/>
                    Rent Price: <span class="pull-right">{{$agreement->property_rentprice}}</span> <br/>
                    Nos of Living room: <span class="pull-right">{{$agreement->property_noslivingroom}}</span> <br/>
                    Nos of Room: <span class="pull-right">{{$agreement->property_nosroom}}</span> <br/>

                    <hr/>

                    Address: <br/> <span class="">{{$agreement->property_address}}</span> <br/>
                    Floor: <span class="pull-right">{{$agreement->property_floor}}</span> <br/>
                    room: <span class="pull-right">{{$agreement->property_room}}</span> <br/>
                    Block: <span class="pull-right">{{$agreement->property_block}}</span> <br/>

                </div>
            </div>













        </div>

        <div class="right">

            <span class="sub-title">Agent</span>
            <hr/>

            <div class="media">
              <a href="" class="pull-left" data-lightbox="roadtrip">
               {{ HTML::image( 'upload/', 'alt-text') }}
           </a>
           <div class="media-body">
            <h4 class="media-heading">{{ $agreement->agent_firstname }} {{ $agreement->agent_lastname }}</h4>

            <small>Rating:</small> <span class="">{{$agreement->agent_rating}}</span> <br/>
            <small>Email:</small> <span class="">{{$agreement->agent_email}}</span> <br/>
            <small>Cell Tel:</small>  <span class="">{{$agreement->agent_cell_tel}}</span> <br/>
            <small>Tel:</small>  <span class="">{{$agreement->agent_tel}}</span> <br/>
            <small>Company:</small> <span class="">{{$agreement->agent_company}}</span> <br/>


        </div>
    </div>

    <hr/>

    <span>
        By checking "Confirm" that mean babababahababaha.
    </span>

    <br/>
    <br/>

    {{ Form::open(array('url'=>'property/accept', 'class'=>'form-signup')) }}
    {{ Form::hidden('requestId', $agreement->requisition_id) }}
    {{ Form::hidden('agentId', $agreement->requisition_agent_id) }}
    {{ Form::hidden('propertyId', $agreement->property_id) }}
    {{ Form::submit('Confirm', array('class'=>'btn btn-large btn-primary btn-block'))}}
    {{ Form::close() }}




</div>


</div>








</div>










</div>

</div>











