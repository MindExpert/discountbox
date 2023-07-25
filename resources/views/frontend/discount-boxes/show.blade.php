@extends('_layouts.guest', [
    'title'         => 'Product',
    'hasHero'       => false,
    'hasBreadcrumb' => true,
])

@section('breadcrumbs')
    <li><a href="{{url('/')}}">Home</a></li>
    <li><a href="{{url('/')}}">DiscountBox</a></li>
    <li>Show</li>
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
                                <img src="{{ asset('frontend/assets/img/placeholderx4.png') }}" alt="" loading="lazy">
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="portfolio-info">
                        <h3>{{ $discountBox->name }}</h3>
                        <ul>
                            <li><strong>@lang('product.fields.created_at')</strong>: {{ $discountBox->created_at->format('d F, Y') }}</li>
                        </ul>
                    </div>
                    <div class="portfolio-description">
                        <p>--------</p>
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
