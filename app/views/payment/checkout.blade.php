

<span class="main-title">購買總覽</span>
<br/>
<br/>


<p>
    您正在購買以下服務，如有疑問請聯絡我們。
</p>

<!-- <h1>Items</h1>
<br/>

@for ($i = 0; $i < count($payment->pricepage); $i++)
{{$payment->pricepage[$i]->item}}
<br/>
{{$payment->pricepage[$i]->price}}
@endfor

<br/>

<br/>
{{ $payment->amount}}
<br/>
{{ $payment->paid}}

{{ Form::open(array('url'=>'payment/checkout', 'class'=>'')) }}
{{ Form::hidden('paymentId', $payment->id) }}
{{ Form::submit('Checkout', array('class'=>'button_lg'))}}
{{ Form::close() }}

-->

<table class="stdTable">
    <tr>
        <th>服務計劃</th>
        <th>詳細</th>
        <th>服務時效</th>
        <th>總額</th>
    </tr>
    <tr>
        <td>{{$package->scheme}}</td>
        <td>
            @for ($i = 0; $i < count($payment->pricepage); $i++)
            - {{$payment->pricepage[$i]->item}}
            <br/>
            @endfor
        </td>
        <td>
            {{$package->period}} 日
        </td>
        <td>
            <span class="std-bold"> HKD {{$payment->amount}} </span><br/>
        </td>

    </tr>
</table>

<hr/>

<ul class="list-inline">

    <li>
        {{ Form::open(array('url'=>'payment/checkout', 'class'=>'')) }}
        {{ Form::hidden('paymentId', $payment->id) }}
        {{ Form::hidden('channel', 'paypal') }}
        {{ Form::submit('使用 Paypal', array('class'=>'button_normal'))}}
        {{ Form::close() }}
    </li>
    <li>
        <a class="underline" href="#" ng-click="isCollapsed = !isCollapsed">
            <b class="button_normal">銀行過賬</b>
        </a>
    </li>


</ul>



<div collapse="!isCollapsed">

    <hr/>

    <div class='two-col-panel'>

        <div class='left-panel'>


            {{ Form::open(array('url'=>'payment/checkout', 'files'=>true, 'class'=>'')) }}

            <h1>存根號碼</h1>
            <br/>
            {{ Form::file('receipt','',array('id'=>'','class'=>'')) }}
            {{ Form::text('transferNo', null, array('class'=>'form-control', 'placeholder'=>'e.g. 432-7896-089')) }}

            <br/>

            {{ Form::hidden('paymentId', $payment->id) }}
            {{ Form::hidden('channel', 'bank_in') }}
            {{ Form::submit('確認', array('class'=>'button_normal'))}}
            {{ Form::reset('重設', array('class'=>'button_normal')) }}
            {{ Form::close() }}

        </div>

        <div class='right-panel'>

            <span class="title">注意</span>
            <br/>
            <br/>
            <p>
                使用銀行過賬方式購買服務，必須待我們確定已經過數後，服務計劃才會生效。
            </p>

        </div>

    </div>

</div>


<hr/>


<span class='sub-title'>詢問</span>
<br/>
<br/>

<p>
    有疑問？找我們談談吧 :)<br/>
    <span class="std-bold">email: </span><span class="underline">service@nestq.com</span> <br/>

</p>

























