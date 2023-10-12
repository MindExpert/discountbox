@props([
    'discountBox' => [],
    'status' => null,
])
@if($discountBoxes->count())
    <div class="homepage-discountbox-slider swiper">
        <div class="d-flex justify-content-between align-items-center">
            <h4>{{$status->label()}}  ―</h4>
            <a href="{{ route('frontend.discount-boxes.index-by-status', ['status' => $status]) }}" class="text-muted d-flex justify-content-between align-items-center"><span>@lang('general.actions.view_more')</span><i class="bx bx-chevron-right"></i></a>
        </div>
        <div class="mb-5 swiper-wrapper">
            @forelse($discountBoxes as $discountBox)
                <div class="card custom-height-card same-height swiper-slide @if($discountBox->highlighted) border border-primary @endif">
                    @if($discountBox->highlighted)
                        <div class="ribbon"><span>@lang('product.fields.highlighted')</span></div>
                    @endif
                    @if($discountBox->product->getFirstMediaUrl('featured_image'))
                        <img src="{{ $discountBox->product->getFirstMediaUrl('featured_image', 'thumb') }}" class="feature-img card-img-top" alt="Responsive image" loading="lazy">
                    @else
                        <img src="{{ asset('frontend/assets/img/placeholderx2.png') }}" class="feature-img card-img-top" alt="Responsive image" loading="lazy">
                    @endif
                    <div class="card-body">
                        <h4 class="card-title">{{ str_tease($discountBox->product->name, 15) }}</h4>
                        <p class="card-text">{!! getNWords($discountBox->product->description, 5) !!} </p>
                        <p class="d-flex justify-content-between align-items-center">
                            <span>@lang('discount_box.fields.credits'): {{$discountBox->credits}}</span>
                            <span>@lang('discount_box.fields.participants'): {{ $discountBox->discount_requests_count }}</span>
                        </p>
                        <p class="card-text">
                            <small class="text-muted">
                                @if($discountBox->expires_at != null && $discountBox->expires_at->isFuture())
                                    @lang('discount_box.fields.expires_at')
                                @else
                                    @lang('discount_box.fields.expired')
                                @endif
                                {{ $discountBox->expires_at?->diffForHumans() }}
                            </small>
                        </p>
                        <a href="{{ route('frontend.discount-boxes.show', ['discountBox' => $discountBox]) }}" class="btn btn-sm btn-primary">@lang('discount_box.actions.view_model')</a>
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
