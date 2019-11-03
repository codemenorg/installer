<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @hasSection('title')
            {{ config('app.name') }} {{ __('Installer') }} | @yield('title', config('app.name'))
        @else
            {{ config('app.name') }} {{ __('Installer') }}
        @endif
    </title>
    <link rel="icon" type="image/png" href="{{ asset('installer/img/favicon.png') }}" sizes="64x64"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <link href="{{ asset('installer/css/style.css') }}" rel="stylesheet"/>
    @yield('style')
</head>
<body>
<div class="installation-wrapper">
    <div class="installation-inner">
        <div class="installation-content">
            <div class="main-container">
                <div class="header">
                    <h1 class="header__title">@yield('title')</h1>
                </div>
                <div class="menu">
                    <a href="javascript:;" class="left-nav"><i class="fa fa-angle-left fa-fw" aria-hidden="true"></i></a>
                    <input class="test" type="checkbox" value="0">
                    <div>
                        <div style="margin-left: 5px;">test</div>
                    </div>
                    <a href="javascript:;" class="right-nav"><i class="fa fa-angle-right fa-fw" aria-hidden="true"></i></a>
                </div>
                @if (session('message'))
                    <p class="alert text-center">
                        <strong>
                            @if(is_array(session('message')))
                                {{ session('message')['message'] }}
                            @else
                                {{ session('message') }}
                            @endif
                        </strong>
                    </p>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
</div>
@yield('scripts')
<script type="text/javascript">
    var x = document.getElementById('error_alert');
    var y = document.getElementById('close_alert');
    y.onclick = function () {
        x.style.display = "none";
    };
</script>
</body>
</html>
