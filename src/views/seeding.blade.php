@extends('vendor.installer.layouts.master')

@section('title', $title)

@section('content')
    @if(session()->has('response'))
        <div class="block">
            <p class="alert alert-success"><strong>{{ session()->get('response')['message'] }}</strong></p>
            <pre><code>{{ session()->get('response')['dbOutputLog'] }}</code></pre>
        </div>
    @endif

    <div class="buttons">
        @if(session()->has('response'))
            <a class="button"
               href="{{ route($routeConfig['next_route']['name'],$routeConfig['next_route']['parameters']) }}">
                {{ __('Next') }}
                <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
            </a>
        @else
            <form class="d-inline-block" action="{{ route('installer.types.store', $type) }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button class="button">{{ __('Run Seeds') }}</button>
            </form>
            <a href="{{ route($routeConfig['next_route']['name'],$routeConfig['next_route']['parameters']) }}"
               class="button danger-button">
                {{ __('Skip') }}
                <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
            </a>
        @endif
    </div>

@endsection

