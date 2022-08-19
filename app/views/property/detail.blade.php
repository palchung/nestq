<div class="two-col-panel">


    <div class="left-panel">


        <div class="namecard-grid">
            <div class="std-thumbnail">

                <div class="media">
                    <a class="pull-left" href="#">
                        @if($property->account_profile_pic)
                        {{ HTML::image('profilepic/' . $property->account_profile_pic, $property->account_firstname .
                        $property->account_lastname, array('class' => '')) }}
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

                    @if ($discloseUserContact)
                    Email:
                    <span class="pull-right std-bold">{{$property->account_email}} </span> <br/>
                    電話: <span class="pull-right std-bold">{{$property->account_tel}}</span> <br/>
                    @else
                    業主資料: <span class="pull-right std-bold">不公開</span> <br/>

                    @endif


                    @if ($property->account_identity == 1)
                    手機: <span class="pull-right std-bold">{{$property->account_cell_tel}}</span></li> <br/>
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
            @include('property.requestBox')

            @include('property.conversation')

        </div>

    </div>


</div>


<!--
        <a class ='btn btn-large btn-primary btn-block'  href="{{URL::previous()}}">Back</a>
    -->






