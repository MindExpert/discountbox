@extends('_layouts.guest', [
    'title'         => 'Discount Boxes',
    'hasHero'       => false,
    'hasBreadcrumb' => true,
])

@section('breadcrumbs')
    <li><a href="{{url('/')}}">Home</a></li>
    <li>DisountBox</li>
@endsection

@section('content')
    <section class="inner-page">
        <div class="container">
            <div class="row">
                @foreach($discountBoxes as $discountBox)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3 d-flex align-items-stretch">
                        <div class="card @if($discountBox->highlighted) border border-success @endif">
                            @if($discountBox->highlighted)
                                <div class="ribbon green"><span>@lang('product.fields.highlighted')</span></div>
                                {{--<div class="ribbon ribbon-top-right">--}}
                                {{--    <span><i class="bx bx-star me-1"></i></span>--}}
                                {{--</div>--}}
                            @endif
                            <div class="custom-height-card">
                                @if($discountBox->getFirstMediaUrl('cover_image'))
                                    <img src="{{ $discountBox->getFirstMediaUrl('cover_image', 'thumb') }}" class="feature-img  card-img-top" alt="Responsive image" loading="lazy">
                                @else
                                    <img src="{{ asset('frontend/assets/img/placeholderx2.png') }}" class="feature-img  card-img-top" alt="Responsive image" loading="lazy">
                                @endif
                            </div>

                            <div class="p-2">
                                <h5><a href="{{ route('frontend.discount-boxes.products.index', ['discountBox' => $discountBox]) }}" class="text-dark">{{ str_tease($discountBox->name, 15) }}</a></h5>
                                <p class="text-muted mb-0">{{ $discountBox->created_at?->diffForHumans() }}</p>
                            </div>

                            <div class="p-2">
                                <ul class="list-inline">
                                    <li class="list-inline-item me-2">
                                        <a href="javascript: void(0);" class="text-muted">
                                            <i class="bx bx-credit-card align-middle text-muted me-1"></i> {{ $discountBox->credits }} Credits
                                        </a>
                                    </li>
                                    <li class="list-inline-item me-2">
                                        <a href="javascript: void(0);" class="text-muted">
                                            <i class="bx bx-user align-middle text-muted me-1"></i> 12 Participants
                                        </a>
                                    </li>
                                </ul>

                                <p>{!!  getNWords($discountBox->description, 10) !!}</p>

                                <div>
                                    <a href="{{ route('frontend.discount-boxes.products.index', ['discountBox' => $discountBox]) }}" class="text-primary">Vedi di Piu <i class="mdi mdi-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12 align-self-center">
                    {{ $discountBoxes->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
