        @if(!Auth::check())


        <span class="sub-title">登入後才可留言。</span>
        <br/>
        <br/>
        {{ Form::open(array('url'=>'', 'class'=>'')) }}
        {{ Form::textarea('message', null, array('class'=>'textarea-60', 'placeholder'=>'leave a message', 'disabled')) }}
        <br/>
        {{ Form::submit('送出', array('class'=>'button_normal', 'disabled'))}}
        {{ Form::close() }}


        @else


        @if ($showMessage == 'yes')

        <?php $cid = ''; ?>
        @foreach ($messages as $message)


        @if (($message->message_conversation_id != $cid))
        <div class="conversation-header width-60">
            <span>
              {{$message->account_firstname}}
              {{$message->account_lastname}}
          </span>
          <span class="pull-right">

              {{ Form::open(array('url'=>'conversation/replylink', 'class'=>'')) }}
              {{ Form::hidden('conversationId', $message->message_conversation_id) }}
              {{ Form::hidden('propertyId', $property->property_id) }}
              {{ Form::submit('回覆', array('class'=>'button_normal_red'))}}
              {{ Form::close() }}

          </span>
      </div>
      @endif

      <ul class="std-ul width-60">
        <li>
          <span class="std-bold">
            {{$message->account_firstname}}
            {{$message->account_lastname}}
        </span>
        <span class="pull-right">
            <small>{{$message->message_created_at}}</small>
        </span>
        <br/>
        <span class="break-word">{{$message->message_message}}</span>

        <hr>
    </li>
</ul>

<?php $cid = $message->message_conversation_id; ?>
@endforeach
@endif







@if(($property->property_responsible_id != Auth::user()->id) && ($identity != 'agent'))

{{ Form::open(array('url'=>'conversation/property', 'class'=>'')) }}
<span class="sub-title"> 留言 </span>

<br/>
<ul>
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>
{{ Form::textarea('message', null, array('class'=>'textarea-60', 'placeholder'=>'leave a message')) }}
{{ Form::hidden('propertyId', $property->property_id) }}
<br/>
{{ Form::honeypot('my_name', 'my_time') }}
{{ Form::submit('送出', array('class'=>'button_normal'))}}
{{ Form::close() }}
@endif


@endif













