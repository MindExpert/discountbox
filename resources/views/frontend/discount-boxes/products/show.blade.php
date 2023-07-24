@extends('_layouts.guest', [
    'title'         => 'Come Funziona',
    'hasHero'       => false,
    'hasBreadcrumb' => true,
])

@section('breadcrumbs')
    <li><a href="{{url('/')}}">Home</a></li>
    <li><a href="{{url('/')}}">Products</a></li>
    <li>Show</a></li>
@endsection

@section('content')
    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
        <div class="container">

            <div class="row gy-4">

                <div class="col-lg-5">
                    <div class="portfolio-details-slider swiper">
                        <div class="swiper-wrapper align-items-center">
                            <div class="swiper-slide">
                                <img src="{{ asset('frontend/assets/img/placeholderx4.png') }}" alt="">
                            </div>

                            <div class="swiper-slide">
                                <img src="{{ asset('frontend/assets/img/placeholderx4.png') }}" alt="">
                            </div>

                            <div class="swiper-slide">
                                <img src="{{ asset('frontend/assets/img/placeholderx4.png') }}" alt="">
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="portfolio-info">
                        <h3>{{ $product->name }}</h3>
                        <ul>
                            <li><strong>@lang('product.fields.created_at')</strong>: {{ $product->created_at->format('d F, Y') }}</li>
                            <li><strong>@lang('product.fields.url')</strong>: <a href="#">{{ $product->url }}</a></li>
                            <li><strong>@lang('discount_box.plural')</strong>: {{ $product->discount_boxes->pluck('name')->implode(', ') }}</li>
                        </ul>
                    </div>
                    <div class="portfolio-description">
                        <p>
                            {{ $product->description }}
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- End Portfolio Details Section -->

@endsection
@section('script')
    <script>
        $(document).ready(function() {
            /**
             * Portfolio details slider
             */
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
        });
    </script>

@endsection
