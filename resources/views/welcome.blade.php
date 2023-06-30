@extends('_layouts.guest', [
    'title'         => 'Home',
    'hasHero'       => true,
    'hasBreadcrumb' => false,
])

@section('breadcrumbs')
    <li><a href="{{url('/')}}">Home</a></li>
    <li>Home</li>
@endsection

@section('content')
    <section class="inner-page">
        <div class="container">
            <p>Example inner page template</p>
        </div>
    </section>
@endsection
