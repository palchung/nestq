<!DOCTYPE html>
<html ng-app='nestq'>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf8"/>
    <meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=yes"/>

    <title>Nestq</title>
    {{ HTML::style( asset('css/style.css') ) }}

    <script type="text/javascript" src='{{ asset("js/libs/angular.min.js")}}'></script>
    <script type="text/javascript" src='{{ asset("js/libs/jquery.js")}}'></script>


    <script type="text/javascript" src='{{ asset("js/libs/bootstrap.3.0.3.min.js")}}'></script>
    <script type="text/javascript" src='{{ asset("js/libs/modernizr.custom.js")}}'></script>

    <script type="text/javascript" src='{{ asset("js/libs/jquery.mmenu.min.all.js")}}'></script>
    <script type="text/javascript" src='{{ asset("js/libs/ui-bootstrap.min.js")}}'></script>
    <script type="text/javascript" src='{{ asset("js/libs/jquery.slimscroll.min.js")}}'></script>
    <script type="text/javascript" src='{{ asset("js/libs/lightbox.min.js")}}'></script>


    <script type="text/javascript" src='{{ asset("js/layout.js")}}'></script>
    <script type="text/javascript" src='{{ asset("js/components.js")}}'></script>


    <!-- augularJs -->
    <script type="text/javascript" src='{{ asset("js/angularJS/filter.js")}}'></script>
    <script type="text/javascript" src='{{ asset("js/angularJS/service.js")}}'></script>
    <script type="text/javascript" src='{{ asset("js/angularJS/controller.js")}}'></script>


</head>
<body>

    <!-- Main content goes here -->
    <div id="page">

        <div class="container">

            <div>
                <span class="main-title">Nestq   </span>
                @if(Auth::check())
                <a class="button_normal_red pull-right" href="{{ url('backoffice/logout')}}" role="button">Logout</a>
                @endif
            </div>
            <hr>


            @if (Auth::check() && Auth::user()->permission <= 2)

            @include('backoffice.menu')


            @include('frontpage.flashmessage')
            <!-- Main Content -->
            {{ $content }}







            @elseif (!Auth::check())

            @include('backoffice.login')


            @endif
        </div>


    </div>


</body>
</html>