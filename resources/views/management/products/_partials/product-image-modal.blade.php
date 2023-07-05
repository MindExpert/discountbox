{{--<div class="modal fade" tabindex="-1" id="view-product-image-modal-{{$product->id}}" data-bs-backdrop="static" data-bs-keyboard="false">--}}
<div class="modal fade" tabindex="-1" id="view-product-image-modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-m">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('product.view_featured_image')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div style="text-align: center">
                    @if($product->getFirstMediaUrl('featured_image'))
                        <img src="{{ $product->getFirstMediaUrl('featured_image', 'image') }}" alt="" class="w-100" loading="lazy">
                    @else
                        <img src="{{ asset('assets/images/users/profile.png') }}" alt="" class="w-100" loading="lazy">
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('general.actions.close')</button>
            </div>
        </div>
    </div>
</div>
