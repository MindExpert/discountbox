@extends('_layouts.guest', [
    'title'         => __('discount_box.plural'),
    'hasHero'       => false,
    'hasBreadcrumb' => true,
])

@section('breadcrumbs')
    <li><a href="{{url('/')}}">@lang('sidebar.menu.home')</a></li>
    <li>@lang('discount_box.plural')</li>
@endsection

@section('content')
    <section class="inner-page">
        <div class="container">
            <div class="section-title">
                <h2>@lang('discount_box.plural')</h2>
                <p>
                    Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem.
                    Sit sint consectetur velit. Quisquam quos quisquam cupiditate.
                </p>
            </div>
            <div class="row">
                @foreach($discountBoxes as $discountBox)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3 d-flex align-items-stretch">
                        <div class="card discountbox-card @if($discountBox->highlighted) highlighted @endif">
                            @if($discountBox->highlighted)
                                <div class="ribbon-main ribbon-main-top-right">
                                    <span><i class="bx bx-star me-1"></i></span>
                                </div>
                            @endif

                            <div class="p-2">
                                <h3 class="discountbox-name"><a href="{{ route('frontend.discount-boxes.show', ['discountBox' => $discountBox]) }}">{{ str_tease($discountBox->name, 15) }}</a></h3>
                                <span class="discountbox-created_at">{{ $discountBox->created_at?->diffForHumans() }}</span>
                            </div>

                            <div class="custom-height-card">
                                @if($discountBox->product->getFirstMediaUrl('featured_image'))
                                    <img src="{{ $discountBox->product->getFirstMediaUrl('featured_image', 'thumb') }}" class="feature-img card-img-top" alt="Responsive image" loading="lazy">
                                @else
                                    <img src="{{ asset('frontend/assets/img/placeholderx2.png') }}" class="feature-img card-img-top" alt="Responsive image" loading="lazy">
                                @endif
                            </div>

                            <div class="p-2">
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="text-muted">
                                            <i class="bx bxl-product-hunt align-middle text-muted me-1"></i> @lang('discount_box.fields.credits'): {{$discountBox->credits}}
                                        </a>
                                    </li>
                                    <li class="list-inline-item me-2">
                                        <a href="javascript: void(0);" class="text-muted">
                                            <i class="bx bx-user align-middle text-muted me-1"></i> {{ $discountBox->participants }} Participants
                                        </a>
                                    </li>
                                </ul>

                                <p>{!!  getNWords($discountBox->description, 10) !!}</p>

                                <div>
                                    <a href="{{ route('frontend.discount-boxes.show', ['discountBox' => $discountBox]) }}" class="get-started-btn">@lang('general.actions.view_more') <i class="mdi mdi-arrow-right"></i></a>
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
