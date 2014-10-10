<span class="title">設置</span>


<!--   xxxxxxxxxxxxxxxxxxxxxxxxxxx Agent section xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->


@if ($identity == 'agent')

<div class="two-col">
    <div class="left">
        <p>
            Nestq 致力幫助物業代理促成交易。其中各代理可以向各業主已發佈的物業進行“代理請求”。<br/>
            而每則“代理請求”，各代理可以附上一段請求內容給業主們參考，增加代理的成功機會。
        </p>
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
    </div>


    <div class="right">


        @foreach($templates as $template)

        @if ($template->template == 'no_template')
        <?php $temp_content = '' ?>
        @else
        <?php $temp_content = $template->template ?>
        @endif

        <span class="sub-title">代理請求預設內容</span>
        <br/>
        <br/>
        {{ Form::open(array('url'=>'account/template', 'class'=>'')) }}

        {{ Form::textarea('template', $temp_content, array('class'=>'textarea-100', 'placeholder'=>'入行年資 經驗 負責地區等')) }}
        <br/>
        {{ Form::submit('Submit', array('class'=>'button_normal'))}}
        {{ Form::close() }}

        @endforeach



    </div>

</div>

@else












<!--   xxxxxxxxxxxxxxxxxxxxxxxxxxx User section xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->


<div class="two-col-panel">



    <div class="left-panel">
        <span class="sub-title"> promotion text </span>
        <br/>
        sadasdasdasdas
    </div>













    <div class="right-panel">

        <div class="std-border white-bg std-padding">


            {{ Form::open(array('url'=>'account/config', 'class'=>'form-horizontal')) }}


            <div class="form-group">
                <label for="inputAllowAgent" class="col-sm-5 control-label">Allow agent request you</label>
                <div class="col-sm-3">
                    {{ Form::select('agent_request', array('0' => 'No', '1' => 'Yes'), $setting['agent_request'],  array('id' =>'inputAllowAgent', 'class' => 'form-control')) }}
                </div>
            </div>


            <div class="form-group">
                <label for="inputAllowContact" class="col-sm-5 control-label">Allow disclose contact</label>
                <div class="col-sm-3">
                    {{ Form::select('disclose_contact', array('0' => 'No', '1' => 'Yes'), $setting['disclose_contact'],  array('id' =>'inputAllowContact', 'class' => 'form-control')) }}
                </div>
            </div>


            <div class="form-group">
                <label for="inputAllowEmail" class="col-sm-5 control-label">allow promotion email</label>
                <div class="col-sm-3">
                    {{ Form::select('promotion_email', array('0' => 'No', '1' => 'Yes'), $setting['promotion_email'],  array('id' =>'inputAllowEmail', 'class' => 'form-control')) }}
                </div>
            </div>


            <hr/>




            <span class="sub-title"> Active Mail setting </span>
            <br/>
            <br/>


            <div class="form-group">
                <label for="inputSource" class="col-sm-5 control-label">Source</label>
                <div class="col-sm-3">
                    {{ Form::select('source', array('0' => 'user', '1' => 'agent', '2' => 'both'), $setting['source'],  array('id' =>'inputSource', 'class' => 'form-control')) }}
                </div>
            </div>

            <div class="form-group">
              <label for="inputPrice" class="col-sm-5 control-label">Price</label>
              <div class="col-sm-3">
                {{ Form::text('price', $setting['price'], array('id' => 'inputPrice','class'=>'form-control', 'placeholder'=>'Price')) }}
            </div>
        </div>

        <div class="form-group">
          <label for="inputSize" class="col-sm-5 control-label">Apartment Area</label>
          <div class="col-sm-3">
            {{ Form::text('actualsize', $setting['actualsize'], array('id' => 'inputSize','class'=>'form-control', 'placeholder'=>'Actual Size')) }}
        </div>
    </div>






    {{ Form::label('Regions') }}
    <br/>

    @for ($i = 0; $i < count($regions); $i++)
    <?php $checked = null ?>
    @for ($j = 0; $j < count($setting['region']); $j++)
    @if ($setting['region'][$j]->id == $regions[$i]->id)
    <?php $checked = true ?>
    @endif
    @endfor


    <table class="std-table">

        <tr>


            <td>
                <div class="searchbox-label">{{ $regions[$i]->name }}</div>
            </td>
            <td>
                {{ Form::checkbox('region[]', $regions[$i]->id,  $checked, ['class'=>'std-checkbox', 'id' => 'searcbox-region' . $regions[$i]->id]) }}<label class="checkbox-label" for={{'searcbox-region' . $regions[$i]->id}}></label>
            </td>


        </tr>

    </table>



    @endfor




    <hr/>















    {{ Form::hidden('settingId', $setting['id']) }}
    {{ Form::submit('Save', array('class'=>'button_normal'))}}
    {{ Form::close() }}


</div>


</div>


</div>

@endif






