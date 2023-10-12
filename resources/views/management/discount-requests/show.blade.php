@extends('_layouts.app', [
    'title'           => __('discount_request.actions.view_model'),
    'container_class' => 'container-fluid',
])

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('management.dashboard') }}">@lang('general.dashboard')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('management.discount-requests.index') }}">@lang('transaction.plural')</a></li>
    <li class="breadcrumb-item active">{{ $discountRequest->label }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header border-info border-3 d-inline-flex flex-column flex-md-row align-items-center justify-content-between">
                    <h4 class="card-title">@lang('discount_request.actions.view_model')</h4>
                    <div class="btn-group btn-group-sm" role="group" aria-label="">
                        @can('update', $discountRequest)
                            <a href="{{route('management.discount-requests.edit', ['discountRequest' => $discountRequest->id])}}" class="btn btn-outline-warning tippy-btn" title="@lang('discount_request.actions.edit')">
                                <i class="fa fa-pencil-alt"></i> @lang('discount_request.actions.edit')
                            </a>
                        @endcan
                        @can('delete', $discountRequest)
                            <a href="javascript:void(0);" class="btn btn-outline-danger action-button" title="@lang('transaction.actions.delete')"
                               data-action="{{ route('management.discount-requests.destroy', ['discountRequest' => $discountRequest->id]) }}"
                               data-method="DELETE"
                               data-title="@lang('discount_request.actions.delete')"
                               data-message="@lang('discount_request.actions.ask_delete')"
                               data-is-danger="true">
                                <i class="fa fa-pencil-alt"></i> @lang('discount_request.actions.delete')
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
                                    <th class="label">@lang('discount_request.fields.id')</th>
                                    <td class="value">{{ $discountRequest->id }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('discount_request.fields.user_id')</th>
                                    <td class="value">
                                        <a href="{{route('management.users.show', ['user' => $discountRequest->user->id])}}" target="_blank" class="btn-link">
                                            {{ $discountRequest->user->label }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('discount_request.fields.discount_box_id')</th>
                                    <td class="value">
                                        <a href="{{route('management.discount-boxes.show', ['discountBox' => $discountRequest->discount_box->id])}}" target="_blank" class="btn-link">
                                            {{ $discountRequest->discount_box->label }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('discount_request.fields.status')</th>
                                    <td class="value">
                                        <span class="fs-6 badge bg-{{ $discountRequest->status->color() }}">
                                            {{ $discountRequest->status->label() }}
                                        </span>
                                    </td>
                                </tr>
                                @if($discountRequest->approved_at !== null)
                                    <tr>
                                        <th class="label">@lang('discount_request.fields.approved_at')</th>
                                        <td class="value">
                                            <span class="fs-6 badge bg-info bg-opacity-25 text-muted">
                                                {{ $discountRequest->approved_at?->format('d/m/Y H:i:s') }}
                                            </span>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <th class="label">@lang('discount_request.fields.credit')</th>
                                    <td class="value">{{ $discountRequest->credit }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('discount_request.fields.percentage')</th>
                                    <td class="value">{{ $discountRequest->percentage }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('discount_request.fields.created_at')</th>
                                    <td class="value">{{ $discountRequest->created_at?->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('discount_request.fields.updated_at')</th>
                                    <td class="value">{{ $discountRequest->updated_at?->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-end">
                            <a href="{{route('management.transactions.index')}}" class="btn btn-outline-secondary waves-effect"> <i class="fa fa-arrow-left"></i>
                                @lang('general.actions.back')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
