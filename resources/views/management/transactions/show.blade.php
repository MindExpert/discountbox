@extends('_layouts.app', [
    'title'           => __('transaction.actions.view_model'),
    'container_class' => 'container-fluid',
])

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('management.dashboard') }}">@lang('general.dashboard')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('management.transactions.index') }}">@lang('transaction.plural')</a></li>
    <li class="breadcrumb-item active">{{ $transaction->name }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header border-info border-3 d-inline-flex flex-column flex-md-row align-items-center justify-content-between">
                    <h4 class="card-title">@lang('transaction.actions.view_model')</h4>
                    <div class="btn-group btn-group-sm" role="group" aria-label="">
                        @can('update', $transaction)
                            <a href="{{route('management.transactions.edit', ['transaction' => $transaction->id])}}" class="btn btn-outline-warning tippy-btn" title="@lang('transaction.actions.edit')">
                                <i class="fa fa-pencil-alt"></i> @lang('transaction.actions.edit')
                            </a>
                        @endcan
                        @can('delete', $transaction)
                            <a href="javascript:void(0);" class="btn btn-outline-danger action-button" title="@lang('transaction.actions.delete')"
                               data-action="{{ route('management.transactions.destroy', ['transaction' => $transaction->id]) }}"
                               data-method="DELETE"
                               data-title="@lang('transaction.actions.delete')"
                               data-message="@lang('transaction.actions.ask_delete')"
                               data-is-danger="true">
                                <i class="fa fa-pencil-alt"></i> @lang('transaction.actions.delete')
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
                                    <th class="label">@lang('transaction.fields.id')</th>
                                    <td class="value">{{ $transaction->id }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('transaction.fields.name')</th>
                                    <td class="value">{{ $transaction->name }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('transaction.fields.notes')</th>
                                    <td class="value">{{ $transaction->notes }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('transaction.fields.type')</th>
                                    <td class="value">{{ $transaction->type->label() }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('transaction.fields.credit')</th>
                                    <td class="value">{{ $transaction->credit }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('transaction.fields.debit')</th>
                                    <td class="value">{{ $transaction->debit }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('transaction.fields.created_at')</th>
                                    <td class="value">{{ $transaction->created_at?->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('transaction.fields.updated_at')</th>
                                    <td class="value">{{ $transaction->updated_at?->format('d/m/Y H:i:s') }}</td>
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
