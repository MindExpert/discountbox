@extends('_layouts.app', [
    'title'           => __('discount_box.actions.view_model'),
    'container_class' => 'container-fluid',
])

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('management.dashboard') }}">@lang('general.dashboard')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('management.discount-boxes.index') }}">@lang('discount_box.plural')</a></li>
    <li class="breadcrumb-item active">{{ $discountBox->label }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header border-info border-3 d-inline-flex flex-column flex-md-row align-items-center justify-content-between">
                    <h4 class="card-title">@lang('discount_box.actions.view_model')</h4>
                    <div class="btn-group btn-group-sm" role="group" aria-label="">
                        @can('update', $discountBox)
                            <a href="{{route('management.discount-boxes.edit', ['discountBox' => $discountBox->id])}}" class="btn btn-outline-warning tippy-btn" title="@lang('discount_box.actions.edit')">
                                <i class="fa fa-pencil-alt"></i> @lang('discount_box.actions.edit')
                            </a>
                        @endcan
                        @can('delete', $discountBox)
                            <a href="javascript:void(0);" class="btn btn-outline-danger action-button" title="@lang('discount_box.actions.delete')"
                               data-action="{{ route('management.discount-boxes.destroy', ['discountBox' => $discountBox->id]) }}"
                               data-method="DELETE"
                               data-title="@lang('discount_box.actions.delete')"
                               data-message="@lang('discount_box.actions.ask_delete')"
                               data-is-danger="true">
                                <i class="fa fa-pencil-alt"></i> @lang('discount_box.actions.delete')
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 table-responsive">
                            <table class="table show-table">
                                <tbody>
                                <tr>
                                    <th class="label">@lang('discount_box.fields.id')</th>
                                    <td class="value">{{ $discountBox->id }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('discount_box.fields.serial')</th>
                                    <td class="value">{{ $discountBox->serial }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('discount_box.fields.name')</th>
                                    <td class="value">{{ $discountBox->name }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('discount_box.fields.price')</th>
                                    <td class="value">{{ $discountBox->price }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('discount_box.fields.discount')</th>
                                    <td class="value">{{ $discountBox->discount }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('discount_box.fields.total')</th>
                                    <td class="value">{{ $discountBox->total }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('discount_box.fields.credits')</th>
                                    <td class="value">{{ $discountBox->credits }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('discount_box.fields.expires_at')</th>
                                    <td class="value">{{ $discountBox->expires_at?->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('discount_box.fields.created_at')</th>
                                    <td class="value">{{ $discountBox->created_at?->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('discount_box.fields.updated_at')</th>
                                    <td class="value">{{ $discountBox->updated_at?->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-end">
                            <a href="{{route('management.discount-boxes.index')}}" class="btn btn-outline-secondary waves-effect"> <i class="fa fa-arrow-left"></i>
                                @lang('general.actions.back')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">@lang('discount_box.fields.cover_image')</h4>
                    <div class="">
                        @if($discountBox->getFirstMediaUrl('cover_image'))
                            <img src="{{ $discountBox->getFirstMediaUrl('cover_image') }}" class="img-fluid" alt="Responsive image">
                        @else
                            <img src="{{ asset('frontend/assets/img/placeholderx2.png') }}" class="img-fluid" alt="Responsive image">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
