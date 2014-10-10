




<span class="main-title">Nestq 服務計劃</span>
<br/>
<br/>


@if(Auth::user()->identity == 1)



<table class="std-table cellspacing-table">
    <tr>
        @foreach($schemes as $scheme)
        <td>

            <div class="panel panel-default">
              <!-- Default panel contents -->
              <div class="panel-heading align-center"><h1>{{$scheme->scheme}}</h1></div>
              <div class="panel-body">
                <span class="align-center"><h1>HKD {{$scheme->multi * $packages['packagePrice']}}</h1></span>
            </div>

            <ul class="list-group">
                @foreach($packages['package'] as $package)



                <li class="list-group-item">
                    {{$package->item}}
                    <span class="pull-right">HKD {{$package->price}}</span>
                </li>


                @endforeach
                <li class="list-group-item align-center">
                    {{ Form::open(array('url'=>'payment/purchasepackage', 'class'=>'')) }}
                    {{ Form::hidden('packageNo', $packages['packageNo']) }}
                    {{ Form::hidden('multi', $scheme->multi) }}
                    {{ Form::hidden('pricingId', $scheme->id) }}
                    {{ Form::hidden('period', $scheme->period) }}
                    {{ Form::submit('購買', array('class'=>'button_lg'))}}
                    {{ Form::close() }}
                </li>
            </ul>

        </div>

    </td>
    @endforeach
</tr>
</table>









<hr/>


<span class="title">詳細內容</span>
<br/>
<br/>

<table class="std-table cellspacing-table">
    @foreach (array_chunk($packages['package'], 3) as $row)
    <tr>
    <div class='row'>
        @foreach($row as $package)
        <td>
        <a href= '' >

                <div class="thumbnail">
                    <div class="caption">
                        <span class="sub-title">
                            {{$package->item}}
                        </span>
                        <br/>
                        <br/>
                        <p>

                            {{$package->price}}


                        </p>
                    </div>
                </div>

        </a>
        </td>
        @endforeach
    </div>
    </tr>
    @endforeach
</table>


@else

<p>
    有關業主會員的服務計劃將會開放，請耐心等待。
</p>




@endif







<!-- <span class="title">Items</span>

<div class='two-col'>
    <div class='left'>
        <span class="sub-title">promotion texts goes here</span>
        <p>
            come buy buy buy.
        </p>
    </div>
    <div class='right'>

        <table class='stdTable'>
            <tr>
                <th>items</th>
                <th>Price</th>
                <th></th>
            </tr>
            @foreach($items as $item)
            <tr>
                <td>{{$item->item}}</td>
                <td>{{$item->price}}</td>
                <td>
                    {{ Form::open(array('url'=>'payment/purchaseitem', 'class'=>'')) }}
                    {{ Form::hidden('itemId', $item->id) }}
                    {{ Form::submit('Purchase', array('class'=>'button_sm'))}}
                    {{ Form::close() }}
                </td>
            </tr>
            @endforeach
        </table>

    </div>
</div>
 -->