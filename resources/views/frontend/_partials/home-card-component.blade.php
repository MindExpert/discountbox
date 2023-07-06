@props([
    'discountBox' => null,
])
@if($discountBox)
    <h3>{{$discountBox->name}} ―</h3>
    <div class="row mb-5 custom-height-card">
        @forelse($discountBox->products as $product)
            <div class="col-md-4">
                <div class="card">
                    @if($product->getFirstMediaUrl('featured_image'))
                        <img src="{{ $product->getFirstMediaUrl('featured_image', 'thumb') }}" class="rounded  card-img-top" alt="Responsive image">
                    @else
                        <img src="{{ asset('frontend/assets/img/placeholderx2.png') }}" class="rounded  card-img-top" alt="Responsive image">
                    @endif
                    <div class="card-body">
                        <h4 class="card-title">{{ $product->name }}</h4>
                        <p class="card-text">{!! getNWords($product->description, 10) !!} </p>
                        <p class="d-flex justify-content-between align-items-center">
                            <span>@lang('discount_box.fields.credits'): {{$discountBox->credits}}</span>
                            <span>@lang('discount_box.fields.participants'): 0</span>
                        </p>
                        <p class="card-text">
                            <small class="text-muted">@lang('discount_box.fields.expires_at') {{ $discountBox->expires_at?->diffForHumans() }}</small>
                        </p>
                        <a href="#" class="btn btn-sm btn-primary">@lang('product.actions.view_model')</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12">
                <div class="alert alert-warning" role="alert">
                    @lang('discount_box.messages.no_products')
                </div>
            </div>
        @endforelse
    </div>
@endif
