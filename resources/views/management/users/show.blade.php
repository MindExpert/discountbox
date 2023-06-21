@extends('_layouts.management', [
    'title'           => __('user.actions.view_model'),
    'container_class' => 'container-fluid',
])

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('management.dashboard') }}">@lang('general.dashboard')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('management.users.index') }}">@lang('user.plural')</a></li>
    <li class="breadcrumb-item active">{{ $user->full_name }}</li>
@endsection

@section('styles')
    <style>
        .show-table th.label {
            min-width: 200px;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header border-info border-3 d-inline-flex flex-column flex-md-row align-items-center justify-content-between">
                    <h4 class="card-title">@lang('user.actions.view_model')</h4>
                    <div class="btn-group" role="group" aria-label="">
                        @can(\App\Policies\UserPolicy::UPDATE, $user)
                            <a href="{{route('management.users.edit', ['user' => $user->id])}}" class="btn btn-outline-warning tippy-btn" title="@lang('user.actions.edit')">
                                <i class="fa fa-pencil-alt"></i> @lang('user.actions.edit')
                            </a>
                        @endcan
                        @can(\App\Policies\UserPolicy::BAN, $user)
                            <a href="javascript:void(0);" class="btn btn-outline-secondary tippy-btn action-button" title="@lang('user.actions.ban')"
                               data-action="{{ route('management.users.ban', ['user' => $user->id]) }}"
                               data-method="PUT"
                               data-title="@lang('user.actions.ban')"
                               data-message="@lang('user.actions.ask_ban')"
                               data-is-danger="true">
                                <i class="fa fa-ban"></i> @lang('user.actions.ban')
                            </a>
                        @endcan
                        @can(\App\Policies\UserPolicy::UNBAN, $user)
                            <a href="javascript:void(0);" class="btn btn-outline-success action-button" title="@lang('user.actions.unban')"
                               data-action="{{ route('management.users.unban', ['user' => $user->id]) }}"
                               data-method="PUT"
                               data-title="@lang('user.actions.unban')"
                               data-message="@lang('user.actions.ask_unban')"
                               data-is-danger="true">
                                <i class="fa fa-check"></i> @lang('user.actions.unban')
                            </a>
                        @endcan
                        @can(\App\Policies\UserPolicy::DELETE, $user)
                            <a href="javascript:void(0);" class="btn btn-outline-danger action-button" title="@lang('user.actions.delete')"
                               data-action="{{ route('management.users.destroy', ['user' => $user->id]) }}"
                               data-method="DELETE"
                               data-title="@lang('user.actions.delete')"
                               data-message="@lang('user.actions.ask_delete')"
                               data-is-danger="true">
                                <i class="fa fa-pencil-alt"></i> @lang('user.actions.delete')
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
                                    <th class="label">@lang('user.fields.id')</th>
                                    <td class="value">{{ $user->id }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('user.fields.full_name')</th>
                                    <td class="value">{{ $user->full_name }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('user.fields.role')</th>
                                    <td class="value">{{ $user->role?->label }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('user.fields.mobile')</th>
                                    <td class="value"><a href="tel:{{ $user->mobile }}">{{ $user->mobile }}</a></td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('user.fields.email')</th>
                                    <td class="value"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('user.fields.locale')</th>
                                    <td class="value">@lang("general.locales.{$user->locale}")</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('user.fields.status')</th>
                                    <td class="value">
                                        @if($user->banned_at !== null)
                                            <span class="badge badge-outline-danger">
                                                @lang('user.fields.banned') - {{ $user->banned_at->format('d/m/Y H:i:s') }}
                                            </span>
                                        @else
                                            <span class="badge badge-outline-success">@lang('user.fields.active')</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('user.fields.pull_to_refresh')</th>
                                    <td class="value">
                                        @if($user->pull_to_refresh)
                                            <span class="badge badge-outline-success">@lang('general.yes')</span>
                                        @else
                                            <span class="badge badge-outline-danger">@lang('general.no')</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('user.fields.2fa_enabled')</th>
                                    <td class="value">
                                        @if($user->google2faEnabled())
                                            <span class="badge badge-outline-success">@lang('general.yes')</span>
                                        @else
                                            <span class="badge badge-outline-danger">@lang('general.no')</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('user.fields.companies')</th>
                                    <td class="value">{{ \App\Models\Company::query()->whereIn('id', $user->company_ids)->pluck('name')->implode(', ') }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('user.fields.accounts')</th>
                                    <td class="value">{{ \App\Models\Account::query()->whereIn('id', $user->account_ids)->pluck('name')->implode(', ') }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('user.fields.warehouses')</th>
                                    <td class="value">{{ \App\Models\Warehouse::query()->whereIn('id', $user->warehouse_ids)->pluck('name')->implode(', ') }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('user.fields.process_categories')</th>
                                    <td class="value">{{ \App\Models\ProcessCategory::query()->whereIn('id', $user->process_category_ids)->pluck('name')->implode(', ') }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('user.fields.departments')</th>
                                    <td class="value">{{ \App\Models\Department::query()->whereIn('id', $user->department_ids)->pluck('name')->implode(', ') }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('user.fields.invoice_templates')</th>
                                    <td class="value">{{ \App\Models\InvoiceTemplate::query()->whereIn('id', $user->invoice_template_ids)->pluck('name')->implode(', ') }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('user.fields.invoice_template_id')</th>
                                    <td class="value">{{ $user->invoice_template?->label }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('user.fields.default_warehouse_id')</th>
                                    <td class="value">{{ $user->default_warehouse?->label }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('user.fields.default_purchase_currency_id')</th>
                                    <td class="value">{{ $user->default_purchase_currency?->label }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('user.fields.default_invoice_currency_id')</th>
                                    <td class="value">{{ $user->default_invoice_currency?->label }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('user.fields.default_quote_currency_id')</th>
                                    <td class="value">{{ $user->default_quote_currency?->label }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('user.fields.default_purchase_account_id')</th>
                                    <td class="value">{{ $user->default_purchase_account?->label }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('user.fields.default_invoice_account_id')</th>
                                    <td class="value">{{ $user->default_invoice_account?->label }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('user.fields.created_at')</th>
                                    <td class="value">{{ $user->created_at?->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('user.fields.updated_at')</th>
                                    <td class="value">{{ $user->updated_at?->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-end">
                            <a href="{{route('management.users.index')}}" class="btn btn-outline-secondary waves-effect"> <i class="fa fa-arrow-left"></i>
                                @lang('general.actions.back')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
