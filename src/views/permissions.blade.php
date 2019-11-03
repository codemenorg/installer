@extends('vendor.installer.layouts.master')

@section('title', $title)

@section('content')

    <ul class="list">
        @foreach($permissions['permissions'] as $permission)
        <li class="list__item list__item--permissions {{ $permission['isSet'] ? 'success' : 'error' }}">
            {{ $permission['folder'] }}
            <span>
                <i class="fa fa-fw fa-{{ $permission['isSet'] ? 'check-circle-o' : 'exclamation-circle' }}"></i>
                {{ $permission['permission'] }}
            </span>
        </li>
        @endforeach
    </ul>

    @if ( ! isset($permissions['errors']))
        <div class="buttons">
            <a href="{{ route($routeConfig['next_route']['name'],$routeConfig['next_route']['parameters']) }}" class="button">
                {{ __('Setup App Environment') }}
                <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
            </a>
        </div>
    @endif

@endsection
