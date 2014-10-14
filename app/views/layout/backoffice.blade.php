<!DOCTYPE html>
<html ng-app='nestq'>
<head>
    <meta http-equiv = "content-type" content = "text/html;charset=utf8" />
    <meta name = "viewport" content = "width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=yes" />

    <title>Nestq</title>
    {{ HTML::style( asset('css/style.css') ) }}
</head>
<body>
    <!-- Main content goes here -->
    <div id="page">






        <div class="container">
            <div>
                <span class="main-title">Nestq</span>
            </div>
            <div>
                @if (Auth::check() && Auth::user()->permission <= 2)
                @include('backoffice.menu')
                @endif
            </div>
            @include('frontpage.flashmessage')
            <!-- Main Content -->
            {{ $content }}
        </div>


    </div>

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

</body>
</html>