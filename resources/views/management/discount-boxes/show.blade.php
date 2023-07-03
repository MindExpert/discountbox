@extends('_layouts.app', [
    'title'           => __('product.actions.view_model'),
    'container_class' => 'container-fluid',
])

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('management.dashboard') }}">@lang('general.dashboard')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('management.products.index') }}">@lang('product.plural')</a></li>
    <li class="breadcrumb-item active">{{ $product->label }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header border-info border-3 d-inline-flex flex-column flex-md-row align-items-center justify-content-between">
                    <h4 class="card-title">@lang('product.actions.view_model')</h4>
                    <div class="btn-group btn-group-sm" role="group" aria-label="">
                        @can('update', $product)
                            <a href="{{route('management.products.edit', ['product' => $product->id])}}" class="btn btn-outline-warning tippy-btn" title="@lang('product.actions.edit')">
                                <i class="fa fa-pencil-alt"></i> @lang('product.actions.edit')
                            </a>
                        @endcan
                        @can('delete', $product)
                            <a href="javascript:void(0);" class="btn btn-outline-danger action-button" title="@lang('product.actions.delete')"
                               data-action="{{ route('management.products.destroy', ['product' => $product->id]) }}"
                               data-method="DELETE"
                               data-title="@lang('product.actions.delete')"
                               data-message="@lang('product.actions.ask_delete')"
                               data-is-danger="true">
                                <i class="fa fa-pencil-alt"></i> @lang('product.actions.delete')
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
                                    <th class="label">@lang('product.fields.id')</th>
                                    <td class="value">{{ $product->id }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('product.fields.serial')</th>
                                    <td class="value">{{ $product->serial }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('product.fields.name')</th>
                                    <td class="value">{{ $product->name }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('product.fields.created_at')</th>
                                    <td class="value">{{ $product->created_at?->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('product.fields.updated_at')</th>
                                    <td class="value">{{ $product->updated_at?->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-end">
                            <a href="{{route('management.products.index')}}" class="btn btn-outline-secondary waves-effect"> <i class="fa fa-arrow-left"></i>
                                @lang('general.actions.back')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
