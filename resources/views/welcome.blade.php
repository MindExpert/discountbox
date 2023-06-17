@extends('_layouts.guest')

@section('content')
    <!-- HERO START -->
    <section class="section hero-section bg-light pb-0" id="hero">
        <div class="bg-overlay bg-overlay-pattern"></div>
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-5">
                    <div>
                        <h1 class="display-6 fw-semibold text-capitalize mb-3 lh-base">ScontaTU</h1>
                        <p class="lead text-muted lh-base mb-4">
                            Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        </p>
                    </div>
                </div>
                <!--end col-->
                <div class="col-lg-6">
                    <div class="position-relative home-img text-center mt-5 mt-lg-0">
                        <img src="{{ asset('assets/images/hero-section-img.png') }}" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>

    <!-- SUBSCRIBE -->
    <section class="py-5 position-relative">
        <div class="bg-overlay bg-overlay-pattern opacity-50"></div>
        <div class="container">
            <div class="row align-items-center">
                <!-- end col -->
                <div class="col-10 offset-1">
                    <!-- Start footer -->
                    <div class="d-flex flex-column align-items-center pt-5">
                        <div class="pb-3">
                            <img src="{{ asset('assets/images/logo_asta_dark.png') }}" alt="logo light" height="20">
                        </div>

                        <p class="fw-bold">Subscribe to our newsletter.</p>

                        <div class="input-group mb-3" style="max-width: 560px">
                            <input type="text" class="form-control"
                                   placeholder="Recipient's username"
                                   aria-label="Recipient's username"
                                   aria-describedby="button-addon2">
                            <button class="btn btn-success waves-effect" type="button">Subscribe</button>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>
@endsection
