@extends('vendor.installer.layouts.master')

@section('title', $title)

@section('content')
    <p class="alert alert-success">{{ __('Installation has been completed successfully.') }}</p>
    <div class="buttons">
        <a class="button" href="{{ url('/') }}">{{ __('Home') }}</a>
    </div>
@endsection
