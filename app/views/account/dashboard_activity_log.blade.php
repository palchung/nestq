
@if ($activity_log != 'null')

<span class="title">資訊</span>
<br/>
<br/>


@foreach ($activity_log as $log)

<div class="std-border white-bg std-padding">

    @if ($log->logcode_id == Config::get('nestq.REQUEST_SUCCESS'))

    {{$log->user_firstname}} {{$log->user_lastname}} 同意了譲您代理以下物業。
    <br/>
    {{ link_to_action('PropertyController@getPropertyDetail',
        $log->property_name,
        $parameters = array('id' => $log->property_id),
        $attributes = array('class' => 'std-link'))
    }}


    @elseif ($log->logcode_id == Config::get('nestq.REQUEST_SUCCESS'))

    {{$log->user_firstname}} {{$log->user_lastname}} 就以下物業收回了譲您的代理權。
    <br/>
    {{ link_to_action('PropertyController@getPropertyDetail',
        $log->property_name,
        $parameters = array('id' => $log->property_id),
        $attributes = array('class' => 'std-link'))
    }}

    @endif

</div>


@endforeach


@else


暫沒有資訊


@endif