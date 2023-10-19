@props([
    'discount_boxes_progress' => $discount_boxes_progress ?? []
])
<div class="tab-pane" id="discount-box-progress-tab">
    <div class="col-lg-12 content">
        @foreach($discount_boxes_progress as $discountRequest)
            <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                <div class="col p-4 d-flex flex-column position-static">
                    <strong class="d-inline-block mb-2 text-primary-emphasis">{{$discountRequest->discount_box->serial}}</strong>
                    <h3 class="mb-0">{{getNWords($discountRequest->discount_box->name, 2)}}</h3>
                    <div class="mb-1 text-body-secondary">{{ $discountRequest->discount_box->expires_at }}</div>
                    <p class="card-text mb-auto">
                        @lang('user.credit'): {{ $discountRequest->discount_box->credits }} | @lang('discount_request.fields.percentage'): {{ $discountRequest->percentage }}%
                    </p>
                    <a href="{{ route('frontend.discount-boxes.show', ['discountBox' => $discountRequest->discount_box]) }}" class="icon-link gap-1 icon-link-hover stretched-link">
                        @lang('general.actions.view_more')
                    </a>
                </div>
                <div class="col-auto d-none d-lg-block">
                    @if($discountRequest->discount_box->product?->getFirstMediaUrl('featured_image'))
                        <img src="{{ $discountRequest->discount_box->product?->getFirstMediaUrl('featured_image', 'thumb') }}" height="250" class="feature-img" alt="Responsive image" loading="lazy">
                    @else
                        <img src="{{ asset('frontend/assets/img/placeholderx2.png') }}" height="250" class="feature-img" alt="Responsive image" loading="lazy">
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
