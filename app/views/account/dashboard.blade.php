

<span class="main-title">看板 </span>

<br/>



<div class="two-col-panel">

    <div class="left-panel">




        @include('account.namecard')





        <div style="display:inline-block; min-height:290px;">
            <datepicker ng-model="dt" min-date="minDate" show-weeks="true" class="well well-sm"></datepicker>
        </div>




    </div>


    <div class="right-panel">
        <section class="tabs">
            <ul class="">
                <li>
                    <a class="" href="{{ url('account/dashboard/property')}}" role="button">
                        <i class="icon-home-1x"></i>
                        物業
                    </a>
                </li>
                @if(Auth::user()->identity == 1)
                <li>
                    <a class="" href="{{ url('account/dashboard/payment')}}" role="button">
                        <i class="icon-dollar-1x"></i>
                        付款紀錄
                    </a>
                </li>
                @endif
                <li>
                    <a class="" href="{{ url('account/dashboard/account_setting')}}" role="button">
                        <i class="icon-account-setting-1x"></i>
                        設置
                    </a>
                </li>
                <li>
                    <a class="" href="{{ url('account/dashboard/account_edit')}}" role="button">
                        <i class="icon-edit-account-1x"></i>
                        賬號管理
                    </a>
                </li>

            </ul>
        </section>


        <br/>
        <div class="dashboard-list-wrapper">
            @if ($dashboard_content == 'property')
            @include('account.dashboard_property')
            @elseif ($dashboard_content == 'payment' && Auth::user()->identity == 1)
            @include('account.dashboard_payment')
            @elseif ($dashboard_content == 'permission_deny')
            @include('account.dashboard_permission_deny')
            @elseif ($dashboard_content == 'account_setting')
            @include ('account.dashboard_account_setting')
            @elseif ($dashboard_content == 'account_edit')
            @include ('account.dashboard_account_edit')
            @endif
        </div>
    </div>

</div>




















