


<div class="two-col-panel">



  <div class="left-panel">


    <div class="namecard-grid">
        <div class="std-thumbnail">

            <div class="media">
              <a class="pull-left" href="#">
                  @if($property->account_profile_pic)
                  {{ HTML::image('profilepic/' . $property->account_profile_pic, $property->account_firstname . $property->account_lastname, array('class' => '')) }}
                  @else
                  <i class="icon-user-5x"></i>
                  @endif
              </a>
              <div class="media-body">
                <h4 class="media-heading">{{$property->account_firstname}} {{$property->account_lastname}}</h4>
                @if($property->account_identity == 1)
                <small> - 物業代理</small>
                @elseif($property->account_identity == 0)
                <small> - 業主 / 用家</small>
                @endif
            </div>
        </div>

        <div class="caption">

            <hr/>

            已發佈物業數量: <span class="pull-right std-bold">{{$nosOfProperty}}</span> <br/>
            <hr/>
            Email:
            <span class="pull-right std-bold">{{$property->account_email}} </span> <br/>
            電話: <span class="pull-right std-bold">{{$property->account_tel}}</span> <br/>
            手機: <span class="pull-right std-bold">{{$property->account_cell_tel}}</span></li> <br/>

            @if ($property->account_identity == 1)
            <hr/>
            評級: <span class="pull-right std-bold">{{$property->account_rating}}</span> <br/>
            牌照: <span class="pull-right std-bold">{{$property->account_license}}</span></li> <br/>
            公司: <span class="pull-right std-bold">{{$property->account_company}}</span></li> <br/>
            <hr/>
            介紹: <br/>
            <div class="std-bold wrap-text">
                {{$property->account_description}}
            </div>

            @endif

        </div>
    </div>
</div>






















</div>








<div class="right-panel">

    <div class="std-border white-bg large-padding">

        @include('property.propertyInfo')


        <hr/>




        <!-- link for request -->

        @if($showRequest =='yes')
        <span class="sub-title">代理請求</span>
        <br/>
        <br/>


        {{ Form::open(array('url'=>'property/requisition', 'class'=>'')) }}

        {{ Form::textarea('template', $template[0]->template,
        array('class'=>'textarea-60', 'placeholder'=>'Write something for your request')) }}
        <br/>

        {{ Form::hidden('propertyId', $property->property_id) }}
        {{ Form::submit('送出', array('class'=>'button_normal'))}}
        {{ Form::close() }}

        @elseif(Auth::check() && Auth::user()->identity == 1 && $showRequest == 'no')

        <span ></span><span class="sub-title">代理請求</span>
        <br/>
        <br/>

        <div class="media">
          <a class="pull-left" href="{{ url('inquiry/guide')}}">
            <i class="icon-user-guide"></i>
        </a>
        <div class="media-body">
            <h4 class="media-heading"><a href="{{ url('inquiry/guide')}}" ><span class="underline">用戶指南</span></a></h4>
            瀏覽用戶指南，了解更多！
        </div>
    </div>



    @endif




    @if(!Auth::check())


    <span class="sub-title">登入後才可留言。</span>


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
    {{$message->message_message}}
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
{{ Form::submit('送出', array('class'=>'button_normal'))}}
{{ Form::close() }}
@endif


@endif




</div>

</div>




</div>









































<!--
        <a class ='btn btn-large btn-primary btn-block'  href="{{URL::previous()}}">Back</a>
    -->






