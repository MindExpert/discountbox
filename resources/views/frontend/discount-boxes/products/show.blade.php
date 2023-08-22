@extends('_layouts.guest', [
    'title'         => 'Come Funziona',
    'hasHero'       => false,
    'hasBreadcrumb' => true,
])

@section('breadcrumbs')
    <li><a href="{{ url('/') }}">@lang('sidebar.menu.home')</a></li>
    <li><a href="{{ route('frontend.discount-boxes.products.index', ['discountBox' => $discountBox]) }}">{{$discountBox->label}}</a></li>
    <li><a href="{{ route('frontend.discount-boxes.products.show', ['discountBox' => $discountBox, 'product' => $product]) }}">{{$product->label}}</a></li>
    <li>@lang('general.actions.view')</li>
@endsection

@section('content')
    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
        <div class="container">

            <div class="row gy-4">
                <div class="col-lg-5">
                    <div class="portfolio-details-slider swiper">
                        <div class="swiper-wrapper align-items-center">
                            @if($media = $product->getFirstMedia('featured_image'))
                                <div class="swiper-slide">
                                    <img src="{{ $media->getFullUrl() }}" alt="" loading="lazy">
                                </div>
                            @endif
                            @forelse($product->getMedia('gallery_images') as $media)
                                <div class="swiper-slide">
                                    <img src="{{ $media->getFullUrl() }}" alt="" loading="lazy">
                                </div>
                            @empty
                                <div class="swiper-slide">
                                    <img src="{{ asset('frontend/assets/img/placeholderx4.png') }}" alt="" loading="lazy">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ asset('frontend/assets/img/placeholderx4.png') }}" alt="" loading="lazy">
                                </div>
                            @endforelse

                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="portfolio-info">
                        <h3>{{ $product->name }}</h3>
                        <ul>
                            <li><strong>@lang('product.fields.participation_fee')</strong>:&nbsp;{{ $discountBox->credits }}</li>
                            <li><strong>@lang('product.fields.created_at')</strong>:&nbsp; {{ $product->created_at->format('d F, Y') }}</li>
                        </ul>
                        <br>
                        <div class="slide-container gy-4">
                            <label for="credit-range">@lang('product.fields.discount_you')</label>
                            <input type="range" min="1" max="90" value="1" name="credit" class="range-slider" id="credit-range">
                            <button class="btn btn-secondary" id="js-btn-apply-discount">@lang('general.actions.apply')</button>
                        </div>
                        <br>
                        <ul>
                            <li><strong>@lang('product.fields.sales_sites')</strong>: <a href="{{$product->url}}">{{ $product->url }}</a></li>
                            <li><strong>@lang('product.fields.current_price')</strong>: {{ display_price($discountBox->total) }}</li>
                            <li><strong>@lang('discount_box.plural')</strong>: {{ $product->discount_boxes->pluck('name')->implode(', ') }}</li>
                            <li>@lang('discount_box.fields.validity_info')</li>
                            <li><strong>@lang('discount_box.fields.validity')</strong>: {{ $discountBox->coupon->expires_at?->format('d/m/Y') }}</li>
                        </ul>
                    </div>
                </div>

                <div class="col-12">
                    <div class="portfolio-description">
                        <p> {!! $product->description !!}</p>
                    </div>
                </div>
            </div>

        </div>
    </section><!-- End Portfolio Details Section -->

@endsection
@section('script')
    <script>
        $(document).ready(function() {
            let $applyBtn = $('#js-btn-apply-discount');

            /** Portfolio details slider **/
            new Swiper('.portfolio-details-slider', {
                speed: 400,
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false
                },
                pagination: {
                    el: '.swiper-pagination',
                    type: 'bullets',
                    clickable: true
                }
            });

            // REMOVE MEDICAL CARD HISTORY from Array Element
            $applyBtn.on('click', function (e) {
                e.preventDefault();

                swal.fire({
                    title: "{{ __('product_discount_request.actions.confirm') }}",
                    text: "{{ __('product_discount_request.actions.confirm_info') }}",
                    icon: "warning",
                    showCancelButton: true,
                    // confirmButtonColor: '#00BDD6FF',
                    // cancelButtonColor: '#F3F4F6FF',
                    confirmButtonText: "{{ __('product_discount_request.actions.confirm') }}",
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        // Make a request to the backend to create a new discount request
                        return fetch(`{{ route('frontend.discount-boxes.products.request-discount', ['discountBox' => $discountBox, 'product' => $product]) }}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                credit: $('#credit-range').val(),
                            })
                        })
                        .then(response => {
                            if (! response.ok && response.status === 422) {
                                return response.json().then(data => {
                                    throw new Error(data.message)
                                });
                            } else if (! response.ok && response.status === 404) {
                                return response.json().then(data => {
                                    throw new Error(data.message)
                                });
                            } else if (! response.ok) {
                                throw new Error(response.statusText);
                            }

                            return response.json();
                        })
                        .catch(error => {
                            Swal.showValidationMessage(
                                `Request failed: ${error}`
                            )
                        })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        /* Dispatch event to calculate item rows iteration */
                        document.querySelector("body").dispatchEvent(new CustomEvent('request-discount-added', {
                            bubbles: true,
                            cancelable: false,
                            composed: false,
                            detail: {
                                discountRequest: result.value.data,
                            }
                        }));
                        {{--toastr.success("{{ __('Hai inserito il tuo sconto') }}", "{{ __('Congratulazioni') }}");--}}
                        Swal.fire({
                            {{--imageUrl: "{{ asset('frontend/assets/img/illustrations/undraw_winners_ao2o.svg') }}",--}}
                            icon: 'success',
                            title: "{{ __('product_discount_request.messages.congrats') }}",
                            text: result.value.message,
                        })
                    }
                })
            });
        });
    </script>

@endsection
