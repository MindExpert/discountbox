@props([
    'discountBox' => null,
])
@if($discountBox)
    <div class="homepage-discountbox-slider swiper">
        <div class="d-flex justify-content-between align-items-center">
            <h4>{{$discountBox->name}} ―</h4>
            <a href="{{ route('frontend.discount-boxes.products.index', ['discountBox' => $discountBox]) }}" class="text-muted d-flex justify-content-between align-items-center"><span>@lang('general.actions.view_more')</span><i class="bx bx-chevron-right"></i></a>
        </div>
        <div class="mb-5 swiper-wrapper">
            @forelse($discountBox->products as $product)
                <div class="card custom-height-card same-height swiper-slide">
                    @if($product->getFirstMediaUrl('featured_image'))
                        <img src="{{ $product->getFirstMediaUrl('featured_image', 'thumb') }}" class="feature-img card-img-top" alt="Responsive image">
                    @else
                        <img src="{{ asset('frontend/assets/img/placeholderx2.png') }}" class="feature-img card-img-top" alt="Responsive image">
                    @endif
                    <div class="card-body">
                        <h4 class="card-title">{{ str_tease($product->name, 15) }}</h4>
                        <p class="card-text">{!! getNWords($product->description, 5) !!} </p>
                        <p class="d-flex justify-content-between align-items-center">
                            <span>@lang('discount_box.fields.credits'): {{$discountBox->credits}}</span>
                            <span>@lang('discount_box.fields.participants'): 0</span>
                        </p>
                        <p class="card-text">
                            <small class="text-muted">@lang('discount_box.fields.expires_at') {{ $discountBox->expires_at?->diffForHumans() }}</small>
                        </p>
                        <a href="{{ route('frontend.discount-boxes.products.show', ['discountBox' => $discountBox, 'product' => $product]) }}" class="btn btn-sm btn-primary">@lang('product.actions.view_model')</a>
                    </div>
                </div>
            @empty
                <div class="text-center">
                    <div class="alert alert-warning" role="alert">
                        @lang('discount_box.messages.no_products')
                    </div>
                </div>
            @endforelse
        </div>
        <div class="swiper-pagination"></div>
    </div>
@endif
@push('partial-scripts')
    <script>
        $(document).ready(function () {
            /** DiscountBox Slider */
            new Swiper('.homepage-discountbox-slider', {
                speed: 800,
                loop: false,
                slidesPerView: 3,
                spaceBetween: 30,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false
                },
                pagination: {
                    el: '.swiper-pagination',
                    type: 'bullets',
                    clickable: true
                },
                breakpoints: {
                    320: {
                        slidesPerView: 1,
                        spaceBetween: 40
                    },
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 10,
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 20,
                    },
                    1200: {
                        slidesPerView: 4,
                        spaceBetween: 30
                    }
                }
            });
        });
    </script>
@endpush


{{--@if($discountBox)--}}
{{--    <div class="d-flex justify-content-between align-items-center">--}}
{{--        <h4>{{$discountBox->name}} ―</h4>--}}
{{--        <a href="javascript:void(0);" class="text-muted d-flex justify-content-between align-items-center"><span>@lang('general.actions.view_more')</span><i class="bx bx-chevron-right"></i></a>--}}
{{--    </div>--}}
{{--    <div class="row mb-5 custom-height-card">--}}
{{--        @forelse($discountBox->products as $product)--}}
{{--            <div class="col-md-3">--}}
{{--                <div class="card">--}}
{{--                    @if($product->getFirstMediaUrl('featured_image'))--}}
{{--                        <img src="{{ $product->getFirstMediaUrl('featured_image', 'thumb') }}" class="rounded  card-img-top" alt="Responsive image">--}}
{{--                    @else--}}
{{--                        <img src="{{ asset('frontend/assets/img/placeholderx2.png') }}" class="rounded  card-img-top" alt="Responsive image">--}}
{{--                    @endif--}}
{{--                    <div class="card-body">--}}
{{--                        <h4 class="card-title">{{ $product->name }}</h4>--}}
{{--                        <p class="card-text">{!! getNWords($product->description, 10) !!} </p>--}}
{{--                        <p class="d-flex justify-content-between align-items-center">--}}
{{--                            <span>@lang('discount_box.fields.credits'): {{$discountBox->credits}}</span>--}}
{{--                            <span>@lang('discount_box.fields.participants'): 0</span>--}}
{{--                        </p>--}}
{{--                        <p class="card-text">--}}
{{--                            <small class="text-muted">@lang('discount_box.fields.expires_at') {{ $discountBox->expires_at?->diffForHumans() }}</small>--}}
{{--                        </p>--}}
{{--                        <a href="#" class="btn btn-sm btn-primary">@lang('product.actions.view_model')</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @empty--}}
{{--            <div class="col-md-12">--}}
{{--                <div class="alert alert-warning" role="alert">--}}
{{--                    @lang('discount_box.messages.no_products')--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endforelse--}}
{{--    </div>--}}
{{--@endif--}}
