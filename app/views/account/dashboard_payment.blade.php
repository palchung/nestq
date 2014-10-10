<span class="title">付款紀錄</span>
<br/>
<br/>
<div class="std-border white-bg std-padding">

<div>
    如有疑問，隨時聯絡我們吧。
</div>

<br/>

    <table class='stdTable'>
        <tr>
            <th>日期</th>
            <th>服務計劃</th>
            <th>金額</th>
            <th>服務時效</th>
            <th>到期日</th>
        </tr>
        @if ($payments)
        @foreach ($payments as $payment)
        <tr>
            <td>{{$payment->updated_at}}</td>
            <td>{{$payment->scheme}} </td>
            <td>{{$payment->amount}} </td>
            <td>{{$payment->period}} days</td>
            <td>{{$payment->due_date}} </td>
        </tr>
        @endforeach
        @else

        沒有紀錄。 <br/>
        到我們的 <a href="{{ url('payment/pricepage')}}" class="button_sm">講買中心</a> 留意服務計劃吧。
         <br/> <br/>

        @endif
    </table>
</div>