

<div class="two-col-panel">
    <div class="left-panel">

        <span class="title">Search</span>
        <br/>
        <br/>
        {{ Form::open(array('url'=>'adminOrder/account', 'class'=>'')) }}
        {{ Form::text('email', '', array('class'=>'form-control', 'placeholder'=>'Account Email')) }}
        <br/>
        {{ Form::submit('Search', array('class'=>'button_sm'))}}
        {{ Form::close() }}

        <hr/>

        {{ Form::open(array('url'=>'adminOrder/payment', 'class'=>'')) }}
        {{ Form::text('paymentId', '', array('class'=>'form-control', 'placeholder'=>'Payment No.')) }}
        <br/>
        {{ Form::submit('Search', array('class'=>'button_sm'))}}
        {{ Form::close() }}


    </div>
    <div class="right-panel">

        @if($toShow == 'index')

        index page


        @elseif($toShow == 'account_history')

        @if ($histories == 'no_record')

        沒有記錄。

        @else

        <table class="form-table">
            <thead>
                <tr>
                    <th>
                        Payment No.
                    </th>
                    <th>
                        Payment status.
                    </th>
                    <th>
                        Amount
                    </th>
                    <th>
                        Transaction No.
                    </th>
                    <th>
                        Transaction Date
                    </th>

                </tr>
            </thead>
            <tbody>
                @foreach($histories as $history)
                <tr>
                    <td>
                        {{$history->payment_id}}
                    </td>
                    <td>
                        @if($history->payment_status == 0)
                        Not Paid
                        @elseif($history->payment_status == 1)
                        Paid
                        @endif
                    </td>
                    <td>
                        {{$history->payment_amount}}
                    </td>
                    <td>
                        {{$history->transaction_id}}
                    </td>
                    <td>
                        {{$history->transaction_updated_at}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @endif


        @endif







    </div>
</div>