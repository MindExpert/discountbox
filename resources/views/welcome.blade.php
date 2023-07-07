@extends('_layouts.guest', [
    'title'         => 'Dashboard',
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
            @include('frontend._partials.home-card-component', ['discountBox' => $discountBoxInProgress])

            @include('frontend._partials.home-card-component', ['discountBox' => $discountBoxAwarded])

            @include('frontend._partials.home-card-component', ['discountBox' => $discountBoxConcluded])
        </div>
    </section>
@endsection
