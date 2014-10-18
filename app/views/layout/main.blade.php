<!DOCTYPE html>
<html ng-app='nestq'>
<head>
    <meta http-equiv = "content-type" content = "text/html;charset=utf8" />
    <meta name = "viewport" content = "width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=yes" />

    <title>Nestq</title>
    {{ HTML::style( asset('css/style.css') ) }}


    <script type="text/javascript" src="{{ asset("js/libs/angular.min.js")}}"></script>
    <script type="text/javascript" src="{{ asset("js/libs/jquery.js")}}"></script>

    <script type="text/javascript" src="{{ asset("js/libs/bootstrap.3.0.3.min.js")}}"></script>
    <script type="text/javascript" src="{{ asset("js/libs/modernizr.custom.js")}}"></script>

    <script type="text/javascript" src="{{ asset("js/libs/jquery.mmenu.min.all.js")}}"></script>
    <script type="text/javascript" src="{{ asset("js/libs/ui-bootstrap.min.js")}}"></script>
    <script type="text/javascript" src="{{ asset("js/libs/jquery.slimscroll.min.js")}}"></script>
    <script type="text/javascript" src="{{ asset("js/libs/lightbox.min.js")}}"></script>


    <script type="text/javascript" src="{{ asset("js/layout.js")}}"></script>
    <script type="text/javascript" src="{{ asset("js/components.js")}}"></script>

    <!-- augularJs -->
    <script type="text/javascript" src="{{ asset("js/angularJS/filter.js")}}"></script>
    <script type="text/javascript" src="{{ asset("js/angularJS/service.js")}}"></script>
    <script type="text/javascript" src="{{ asset("js/angularJS/controller.js")}}"></script>


</head>
<body>
    <!-- Main content goes here -->
    <div id="page">
        <div id="header">
            <a href="#menu-search" class='header-search-button'></a>
            <a href="#menu-top" class='header-menu-button'><i class="icon-menu-button"></i></a>
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
                Nestq
            </a>
        </div>

        {{--@include('frontpage.activepush') --}}


        @include('frontpage.flashmessage')

        <div class="container">
            <!-- Main Content -->
            {{ $content }}
        </div>



        <nav id="menu-search">
            @include('frontpage.searchbox')
        </nav>
        <nav id="menu-top">
            @include('frontpage.menu')
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