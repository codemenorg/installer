<?php
$routes = config('installer.routes');
$routeKeys = array_keys($routes);
$totalRoutes = count($routeKeys) - 1;
?>
    <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @if(config('installer.title'))
            {{ config('installer.title') }} | @yield('title', 'Codemen Web Installer')
        @else
             @yield('title', 'Codemen Web Installer')
        @endif
    </title>
    <link rel="icon" type="image/png" href="{{ asset('installer/img/favicon.png') }}" sizes="64x64"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <link href="{{ asset('vendor/installer/css/style.css') }}" rel="stylesheet"/>
    @if(!empty(request()->route()->parameter('types')))
        <style>
            @if($totalRoutes>=5)
            @foreach($routeKeys as $key => $value)
                {{'#installer-step-'.$key}}:checked ~ .installer-nav {
                display: none;
            }

            {{'#installer-step-'.$key}}:checked ~ {{'#installer-step-left-'.(empty($key) ? 0 : ($key-1))}} ,
            {{'#installer-step-'.$key}}:checked ~ {{'#installer-step-right-'.($key>=$totalRoutes ? $totalRoutes : ($key+1))}}        {
                display: initial;
                opacity: 1;
                cursor: pointer;
            }

            @if($key-1 <= 1)
                    {{'#installer-step-'.$key}}:checked ~ {{'#installer-step-left-'.(empty($key) ? 0 : ($key-1))}}        {
                color: #333;
                cursor: initial;
            }

            @endif
                @if($key+1 >= ($totalRoutes-1))
                    {{'#installer-step-'.$key}}:checked ~ {{'#installer-step-right-'.($key>=$totalRoutes ? $totalRoutes : ($key+1))}}        {
                color: #333;
                cursor: initial;
            }

            @endif
                @if($key > 2 && $key < ($totalRoutes-1))
                    {{'#installer-step-'.$key}}:checked ~ .installer-menu-wrapper .installer-first-menu-item {
                margin-left: -{{($key-2)*20}}%;
            }

            @elseif($key >= ($totalRoutes-1))
                    {{'#installer-step-'.$key}}:checked ~ .installer-menu-wrapper .installer-first-menu-item {
                margin-left: -{{($totalRoutes-4)*20}}%;
            }
            @endif
            @endforeach
            @endif
        </style>
    @endif
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
                @if(!empty(request()->route()->parameter('types')))
                    <div class="installation-menu">
                        @if($totalRoutes>=5)
                            @foreach($routeKeys as $key => $value)
                                <input id="installer-step-{{$key}}" name="installer_menu_step" type="radio"
                                       value="{{$key}}"
                                       class="installer-menu-step" {{request()->route()->parameter('types')==$value ? 'checked' : ''}}>
                                @if (empty($key))
                                    @continue;
                                @endif
                                @php($key--)
                                <label id="installer-step-left-{{$key}}"
                                       for="{{$key > 1 && $key < ($totalRoutes-2) ? 'installer-step-'.($key) : ($key >= ($totalRoutes-2) ? 'installer-step-'.($totalRoutes-3) : '') }}"
                                       class="installer-nav installer-nav-left"><i
                                        class="fa fa-chevron-left"></i></label>
                            @endforeach
                        @else
                            <label
                                class="installer-nav installer-nav-left installer-nav-disabled installer-nav-visible"><i
                                    class="fa fa-chevron-left"></i></label>
                        @endif
                        <div class="installer-menu-wrapper">
                            <div class="installer-menu-container">
                                @php($start=true)
                                @php($allInactive=false)
                                @foreach($routes as $route => $option)
                                    <div
                                        class="{{$start ? 'installer-first-menu-item' : ''}} {{$allInactive ? 'installer-inactive-menu-item' : ''}}">
                                        <a class="{{request()->route()->parameter('types')==$route ? 'active' : ''}}"
                                           href="{{$allInactive ? 'javascript:;' : route('installer.types',$route)}}"
                                           title="{{ucwords(str_replace('-',' ', $route))}}"><i
                                                class="{{$option['icon']}}"></i></a></div>
                                    @php($start=false)
                                    @if(request()->route()->parameter('types')==$route)
                                        @php($allInactive=true)
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @if($totalRoutes>=5)
                            @foreach($routeKeys as $key => $value)
                                @if ($key >= $totalRoutes)
                                    @continue;
                                @endif
                                @php($key++)
                                <label id="installer-step-right-{{$key}}"
                                       for="{{$key > 2 && $key < ($totalRoutes-1) ? 'installer-step-'.($key) : ($key <= 2 ? 'installer-step-'. 3 : '') }}"
                                       class="installer-nav installer-nav-right"><i
                                        class="fa fa-chevron-right"></i></label>
                            @endforeach
                        @else
                            <label
                                class="installer-nav installer-nav-right installer-nav-disabled installer-nav-visible"><i
                                    class="fa fa-chevron-right"></i></label>
                        @endif
                    </div>
                @endif
                @if (session('message'))
                    <p class="alert alert-success text-center">
                        <strong>
                            @if(is_array(session('message')))
                                {{ session('message')['message'] }}
                            @else
                                {{ session('message') }}
                            @endif
                        </strong>
                    </p>
                @endif
                @if (session('error'))
                    <p class="alert alert-error text-center">
                        <strong>
                            {{ session('error') }}
                        </strong>
                    </p>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
</div>
@yield('scripts')
</body>
</html>
