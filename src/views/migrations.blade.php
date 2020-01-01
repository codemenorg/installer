@extends('vendor.installer.layouts.master')

@section('title', $title)

@section('content')
    @if(session()->has('response'))
        <div class="block">
            <p class="alert alert-success">{{ session()->get('response')['message'] }}</p>
            <pre><code>{{ session()->get('response')['dbOutputLog'] }}</code></pre>
        </div>
    @endif

    <div class="buttons">
        @if(session()->has('response') && !session()->get('isRollback', true))
            <form class="d-inline-block" action="{{ route('installer.types.store', $type) }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="action" value="rollback">
                <button class="button danger-button">{{ __('Rollback') }}</button>
            </form>
            <a href="{{ route($routeConfig['next_route']['name'],$routeConfig['next_route']['parameters']) }}"
               class="button">
                {{ __('Next') }}
                <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
            </a>
        @else
            <form action="{{ route('installer.types.store', $type) }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button class="button">{{ __('Run Migrations') }}</button>
            </form>
        @endif
    </div>

@endsection

