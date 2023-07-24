@extends('_layouts.guest', [
    'title'         => 'Come Funziona',
    'hasHero'       => false,
    'hasBreadcrumb' => true,
])

@section('breadcrumbs')
    <li><a href="{{url('/')}}">Home</a></li>
    <li><a href="{{ route('frontend.discount-boxes.products.index', ['discountBox' => $discountBox]) }}">{{$discountBox->label}}</a></li>
    <li>Products</li>
@endsection

@section('content')
    <section class="inner-page">
        <div class="container">
            <div class="row">
                @foreach($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3 d-flex align-items-stretch">
                        <div class="card">
                            <div class="custom-height-card">
                                @if($product->getFirstMediaUrl('featured_image'))
                                    <img src="{{ $product->getFirstMediaUrl('featured_image', 'thumb') }}" class="feature-img  card-img-top" alt="Responsive image">
                                @else
                                    <img src="{{ asset('frontend/assets/img/placeholderx2.png') }}" class="feature-img  card-img-top" alt="Responsive image">
                                @endif
                            </div>

                            <div class="p-2">
                                <h5><a href="{{ route('frontend.discount-boxes.products.show', ['discountBox' => $discountBox, 'product' => $product]) }}" class="text-dark">{{ str_tease($product->name, 15) }}</a></h5>
                                <p class="text-muted mb-0">{{ $product->created_at?->diffForHumans() }}</p>
                            </div>

                            <div class="p-2">
                                <ul class="list-inline">
                                    <li class="list-inline-item me-2">
                                        <a href="javascript: void(0);" class="text-muted">
                                            <i class="bx bx-credit-card align-middle text-muted me-1"></i> Credits
                                        </a>
                                    </li>
                                    <li class="list-inline-item me-2">
                                        <a href="javascript: void(0);" class="text-muted">
                                            <i class="bx bx-user align-middle text-muted me-1"></i> 12 Participants
                                        </a>
                                    </li>
                                </ul>

                                <p>{!!  getNWords($product->description, 10) !!}</p>

                                <div>
                                    <a href="{{ route('frontend.discount-boxes.products.show', ['discountBox' => $discountBox, 'product' => $product]) }}" class="text-primary">Read more <i class="mdi mdi-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                {{ $products->appends(request()->except('products_page'))->links() }}
            </div>
        </div>
    </section>
@endsection
