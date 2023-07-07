@extends('_layouts.app', [
    'title' => 'management.dashboard',
])

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('management.dashboard') }}">@lang('general.dashboard')</a></li>
    <li class="breadcrumb-item active">@lang('sidebar.menu.home')</li>
@endsection

@section('content')
    <!-- end page title -->
    LOGGED IN
@endsection
