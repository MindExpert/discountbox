@extends('_layouts.app', [
    'title'           => __('coupon.actions.view_model'),
    'container_class' => 'container-fluid',
])

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('management.dashboard') }}">@lang('general.dashboard')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('management.coupons.index') }}">@lang('coupon.plural')</a></li>
    <li class="breadcrumb-item active">{{ $coupon->code }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header border-info border-3 d-inline-flex flex-column flex-md-row align-items-center justify-content-between">
                    <h4 class="card-title">@lang('coupon.actions.view_model')</h4>
                    <div class="btn-group btn-group-sm" role="group" aria-label="">
                        @can('delete', $coupon)
                            <a href="javascript:void(0);" class="btn btn-outline-danger action-button" title="@lang('coupon.actions.delete')"
                               data-action="{{ route('management.coupons.destroy', ['coupon' => $coupon->id]) }}"
                               data-method="DELETE"
                               data-title="@lang('coupon.actions.delete')"
                               data-message="@lang('coupon.actions.ask_delete')"
                               data-is-danger="true">
                                <i class="fa fa-pencil-alt"></i> @lang('coupon.actions.delete')
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
                                    <th class="label">@lang('coupon.fields.id')</th>
                                    <td class="value">{{ $coupon->id }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('coupon.fields.code')</th>
                                    <td class="value">{{ $coupon->code }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('coupon.fields.type')</th>
                                    <td class="value">
                                        <span class="badge badge-soft-{{ $coupon->type->color() }}">{{ $coupon->type->label() }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('coupon.fields.discount')</th>
                                    <td class="value">{{ $coupon->discount }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('coupon.fields.valid_from')</th>
                                    <td class="value">{{ $coupon->valid_from?->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('coupon.fields.expires_at')</th>
                                    <td class="value">{{ $coupon->expires_at?->format('d/m/Y') ?? '---' }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('coupon.fields.applied_at')</th>
                                    <td class="value">{{ $coupon->applied_at?->format('d/m/Y') ?? '---' }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('coupon.fields.created_at')</th>
                                    <td class="value">{{ $coupon->created_at?->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-end">
                            <a href="{{route('management.coupons.index')}}" class="btn btn-outline-secondary waves-effect"> <i class="fa fa-arrow-left"></i>
                                @lang('general.actions.back')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
