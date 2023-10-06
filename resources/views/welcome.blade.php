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
            @include('frontend._partials.home-card-component', ['discountBoxes' => $discountBoxInProgress, 'status' => \App\Enums\StatusEnum::IN_PROGRESS])

            @include('frontend._partials.home-card-component', ['discountBoxes' => $discountBoxAwardedAndConcluded, 'status' => \App\Enums\StatusEnum::CONCLUDED])
        </div>
    </section>
@endsection
