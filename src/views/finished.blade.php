@extends('vendor.installer.layouts.master')

@section('title', $title)

@section('content')
    <h5 style="text-align: center">{{ __('Installation has been completed successfully.') }}</h5>
    <div class="buttons">
        <a class="button" href="{{ url('/') }}">{{ __('Home') }}</a>
    </div>
@endsection
