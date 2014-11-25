
@if($showRequest =='yes')
<span class="sub-title">代理請求</span>
<br/>
<br/>


{{ Form::open(array('url'=>'property/requisition', 'class'=>'')) }}

{{ Form::textarea('template', $template[0]->template,
array('class'=>'textarea-60', 'placeholder'=>'Write something for your request')) }}
<br/>

{{ Form::hidden('propertyId', $property->property_id) }}
{{ Form::honeypot('my_name', 'my_time') }}
{{ Form::submit('送出', array('class'=>'button_normal'))}}
{{ Form::close() }}

@elseif(Auth::check() && Auth::user()->identity == 1 && $showRequest == 'no')

<span></span><span class="sub-title">代理請求</span>
<br/>
<br/>

<div class="media">
    <a class="pull-left" href="{{ url('inquiry/guide')}}">
        <i class="icon-user-guide"></i>
    </a>

    <div class="media-body">
        <h4 class="media-heading"><a href="{{ url('inquiry/guide')}}"><span class="underline">用戶指南</span></a>
        </h4>
        瀏覽用戶指南，了解更多！
    </div>
</div>


@endif

<hr/>