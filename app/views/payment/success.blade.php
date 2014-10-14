




<div class='two-col'>
<div class='left'>


<span class='main-title'> 交易總覽 </span>
<br/>
<br/>
<span class="color-secondary">交易成功，我們己經收到您的款項。</span>



<br/>

<br/>



<table class="stdTable">
    <tr>
        <td>
            <small>結賬號碼</small> <br/>
            # {{$payment->id}}
        </td>
        <td>
            <small>交易日期</small> <br/>
            {{$payment->created_at}}
        </td>
        <td>
            <small>存根號碼</small> <br/>
            {{$transaction}}
        </td>
        <td>
            <small>交易方法</small> <br/>
            {{$channel}}
        </td>
    </tr>
</table>

<hr/>

@if ($receipt)

<span class='title'>存根</span>
<br/>
<br/>
{{ HTML::image( 'receipt/' . $payment->receipt, 'alt-text') }}
<hr/>
@endif




<span class='title'>客戶資料</span>
<br/>
<br/>

<small>姓名</small> : {{$account->firstname}} {{$account->lastname}}
<br/>
<small>Email</small> : {{$account->email}}
<br/>
<small>聯絡電話</small> : {{$account->tel}}


<hr/>

<p>
    有疑問？找我們談談吧 :)<br/>
    <span class="std-bold">email: </span><span class="underline">service@nestq.com</span> <br/>

</p>
<br/>

</div>
<div class='right'>



<span class='title'>以下服務已經開啟</span>
<br/>
<br/>

<table class="stdTable">
    <tr>
        <th>服務</th>
        <th>到期日</th>
    </tr>

    @foreach ($services as $service)
    <tr>
        @foreach ($payment->pricepage as $purchase)
        @if ($service->item_id == $purchase->id)

        <td>
            {{$purchase->item}}
        </td>
        <td>
            {{$service->period}}
        </td>
        @endif
        @endforeach
    </tr>
    @endforeach

</table>


</div>
</div>











