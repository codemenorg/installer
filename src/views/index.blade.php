@extends('vendor.installer.layouts.master')

@section('title', __('Laravel Installer'))

@section('content')
    <p class="text-center">
        {{ __('Installation Wizard.') }}
    </p>
    <p class="text-center">
        <a href="{{ route('installer.types', $nextRoute) }}" class="button">
            {{ __('Check Server Requirements') }}
            <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
        </a>
    </p>
@endsection
