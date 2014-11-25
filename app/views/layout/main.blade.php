<!DOCTYPE html>
<html ng-app='nestq'>
<head>
    <meta http-equiv = "content-type" content = "text/html;charset=utf8" />
    <meta name = "viewport" content = "width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=yes" />

    <title>Nestq</title>
    {{ HTML::style( asset('css/style.css') ) }}

    <script type="text/javascript" src='{{ asset("js/frontend.js")}}'></script>

</head>
<body>



    <div id="page">
        <div id="header">
            <a href="#menu-search" class='header-search-button'></a>
            <a href="#menu-top" class='header-menu-button'><i class="icon-menu-button"></i></a>
            @if(Auth::check())
            <a href="{{ url('account/dashboard/property')}}" class='user-name'>
                @if(Auth::user()->photo)
                {{ HTML::image('profilepic/' . Auth::user()->photo, Auth::user()->firstname, array('class' => '')) }}
                @else
                <i class="icon-user-1x"></i>
                @endif

                {{Auth::user()->firstname}} {{Auth::user()->lastname}}
            </a>
            @endif
            <a href="#menu-right-second" class='header-calculator-button right'><i class="icon-calculator-button"></i></a>
            <a href="#menu-right" class="header-messager-button right">
                @if (Auth::check())
                @if(Auth::user()->identity == 0 || (Auth::user()->identity == 1 && Service::checkServicePayment(Config::get('nestq.MESSENGER_ID') == 'paid')))
                <div ng-controller="NotificationCtrl">
                    <span class="std-badge notice">
                        <[notice.unread]>
                    </span>
                </div>
                @endif
                @endif
            </a>
        </div>

        <div class="brand-name">
            <a href="{{ url('/')}}" >
                Nestq <small>beta</small>
            </a>
        </div>

        @include('frontpage.activepush')

        @include('frontpage.flashmessage')

        <div class="container">
            {{ $content }}
        </div>



        <nav id="menu-search">
            @include('frontpage.searchbox')
        </nav>
        <nav id="menu-top">
            @include('frontpage.menu')
        </nav>
        <nav id="menu-right-second">
            @include('frontpage.calculator')
        </nav>
        <nav id="menu-right">
            @include('frontpage.messenger')
        </nav>

        <div class="footer">
            @include('frontpage.footer')
        </div>

    </div>





</body>
</html>