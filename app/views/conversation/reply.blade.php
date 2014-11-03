<div class="two-col-panel-convert">


    <div class="left-panel-convert">

        <div class="std-border white-bg std-padding">
            @include('property.propertyInfo')
        </div>


    </div>


    <div class="right-panel-convert">

        <span class="title">Reply</span>
        <br/>
        <br/>

        {{ link_to_action('PropertyController@getPropertyDetail',
        'return to property',
        $parameters = array('id' => $property->property_id),
        $attributes = array('class' => 'button_normal'))
        }}

        <br/>
        <br/>

        <div class="std-border white-bg std-padding">
            @foreach ($messages as $message)


            <span class="std-bold">
                {{$message->account_firstname}}
                {{$message->account_lastname}}
            </span>
            <span class="pull-right"><small>{{$message->message_created_at}}</small></span>
            <br/>
            <span class="break-word">
                {{$message->message_message}}
            </span>

            <hr/>


            @endforeach


            <small>{{Auth::user()->firstname}} {{Auth::user()->lastname}}</small>


            {{ Form::open(array('url'=>'conversation/reply', 'class'=>'')) }}

            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            {{ Form::textarea('message', null, array('class'=>'textarea-100', 'placeholder'=>'leave a message')) }}

            {{ Form::hidden('conversationId', $conversation_id) }}
            {{ Form::hidden('propertyId', $property->property_id) }}

            <br/>
            {{ Form::honeypot('my_name', 'my_time') }}
            {{ Form::submit('Send', array('class'=>'button_normal'))}}
            {{ Form::close() }}


        </div>

    </div>


</div>




