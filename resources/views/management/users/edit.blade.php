@extends('_layouts.management', [
    'title'           => __('user.actions.edit_model'),
    'container_class' => 'container-fluid',
])

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('management.dashboard') }}">@lang('general.dashboard')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('management.users.index') }}">@lang('user.plural')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('management.users.show', ['user' => $user->id]) }}">{{ $user->full_name }}</a></li>
    <li class="breadcrumb-item active">@lang('user.actions.edit')</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header border-info border-3">
                    <h4 class="card-title">@lang('user.actions.edit_model')</h4>
                </div>
                <div class="card-body">
                    <form class="ajax-form" method="POST" action="{{ route('management.users.update', ['user' => $user->id]) }}">
                    @csrf
                    @method('PUT')
                        <!-- USER NAME & LAST_NMAME -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name">@lang('user.fields.first_name')</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name"  value="{{ $user->first_name }}" autofocus placeholder="@lang('user.fields.first_name')">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name">@lang('user.fields.last_name')</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name"  value="{{ $user->last_name }}" autofocus placeholder="@lang('user.fields.last_name')">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>

                        <!-- EMAIL & MOBILE -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">@lang('user.fields.email')</label>
                                    <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}" placeholder="@lang('user.fields.email')">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mobile">@lang('user.fields.mobile')</label>
                                    <input type="tel" class="form-control" name="mobile" id="mobile"  value="{{ $user->mobile }}" placeholder="@lang('user.fields.mobile')">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>

                        <!-- ROLE & COMPANIES -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role_id">@lang('user.fields.role')</label>
                                    <select class="form-control select2" name="role_id" id="role_id">
                                        <option value="">@lang('user.fields.select_role')</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" @selected($user->role_id === $role->id)>{{ ucfirst($role->title) }}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="companies">@lang('user.fields.companies')</label>
                                    <select class="form-control" name="companies[]" id="companies" multiple>
                                        @if($user->companies)
                                            @foreach($user->companies as $company)
                                                <option value="{{ $company->id }}" @selected(true)>
                                                    {{ $company->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>

                        <!-- INVOICE_TEMPALTE & TEMPLATES -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="invoice_template_id">@lang('user.fields.invoice_template_id')</label>
                                    <select class="form-control" name="invoice_template_id" id="invoice_template_id" data-control="select2" data-allow-clear="true" data-placeholder="@lang('invoice_template.actions.search')">
                                        @if($user->invoice_template)
                                            <option value="{{ $user->invoice_template->id }}" @selected(true)>{{ $user->invoice_template->name }}</option>
                                        @endif
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="invoice_templates">@lang('user.fields.invoice_templates')</label>
                                    <select class="form-control" name="invoice_templates[]" id="invoice_templates" multiple>
                                        @if($user->invoice_templates)
                                            @foreach($user->invoice_templates as $invoiceTemplate)
                                                <option value="{{ $invoiceTemplate->id }}" @selected(true)>
                                                    {{ $invoiceTemplate->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>

                        <!-- ACCOUNTS & WAREHOUSES -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="accounts">@lang('user.fields.accounts')</label>
                                    <select class="form-control" name="accounts[]" id="accounts" multiple>
                                        @if($user->accounts)
                                            @foreach($user->accounts as $account)
                                                <option value="{{ $account->id }}" @selected(true)>
                                                    {{ $account->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="warehouses">@lang('user.fields.warehouses')</label>
                                    <select class="form-control" name="warehouses[]" id="warehouses" multiple>
                                        @if($user->warehouses)
                                            @foreach($user->warehouses as $warehouse)
                                                <option value="{{ $warehouse->id }}" @selected(true)>
                                                    {{ $warehouse->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>

                        <!-- DEFAULT_WAREHOUSE & LOCALE -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="default_warehouse_id">@lang('user.fields.default_warehouse_id')</label>
                                    <select class="form-control" name="default_warehouse_id" id="default_warehouse_id" data-control="select2" data-allow-clear="true" data-placeholder="@lang('user.fields.select_default_warehouse')">
                                        @if($user->default_warehouse)
                                            <option value="{{ $user->default_warehouse->id }}" @selected(true)>
                                                {{ $user->default_warehouse->name }}
                                            </option>
                                        @endif
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="locale">@lang('user.fields.locale')</label>
                                    <select class="form-control select2" name="locale" id="locale" data-allow-clear="true" data-placeholder="@lang('user.fields.select_locale')">
                                        <option value="">@lang('user.fields.locale')</option>
                                        @foreach(config('app.locales') as $locale)
                                            <option value="{{ $locale }}" {{ $user->locale === $locale ? 'selected="selected"' : '' }}>
                                                @lang("general.locales.{$locale}")
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mt-4">
                                    <div class="form-check form-switch form-switch-success">
                                        <input class="form-check-input" type="checkbox" id="pull_to_refresh" name="pull_to_refresh" value="1" @checked($user->pull_to_refresh)>
                                        <label class="form-check-label mt-1" for="pull_to_refresh">@lang('user.fields.pull_to_refresh')</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- DEFAULT PURCHASE_CURRENCY & INVOICE_CURRENCY -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="default_purchase_currency_id">@lang('user.fields.default_purchase_currency_id')</label>
                                    <select class="form-control" name="default_purchase_currency_id" id="default_purchase_currency_id" data-control="select2" data-allow-clear="true" data-placeholder="@lang('user.fields.select_currency')">
                                        @if($user->default_purchase_currency)
                                            <option value="{{ $user->default_purchase_currency->id }}" @selected(true)>
                                                {{ $user->default_purchase_currency->label }}
                                            </option>
                                        @endif
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="default_invoice_currency_id">@lang('user.fields.default_invoice_currency_id')</label>
                                    <select class="form-control" name="default_invoice_currency_id" id="default_invoice_currency_id" data-control="select2" data-allow-clear="true" data-placeholder="@lang('user.fields.select_currency')">
                                        @if($user->default_quote_currency)
                                            <option value="{{ $user->default_invoice_currency->id }}" @selected(true)>
                                                {{ $user->default_invoice_currency->label }}
                                            </option>
                                        @endif
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>

                        <!-- DEFAULT QUOTE_CURRENCY & PROCESSES_USER -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="default_quote_currency_id">@lang('user.fields.default_quote_currency_id')</label>
                                    <select class="form-control" name="default_quote_currency_id" id="default_quote_currency_id" data-control="select2" data-allow-clear="true" data-placeholder="@lang('user.fields.select_currency')">
                                        @if($user->default_quote_currency)
                                            <option value="{{ $user->default_quote_currency->id }}" @selected(true)>
                                                {{ $user->default_quote_currency->label }}
                                            </option>
                                        @endif
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="processes">@lang('user.fields.process_categories')</label>
                                    <select class="form-control" name="process_categories[]" id="process_categories"
                                            data-control="select2"
                                            data-allow-clear="true"
                                            data-placeholder="@lang('user.fields.select_process_categories')"
                                            multiple
                                    >
                                        @if($user->process_categories)
                                            @foreach($user->process_categories as $processCategory)
                                                <option value="{{ $processCategory->id }}" @selected(true)>
                                                    {{ $processCategory->label }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>

                        <!-- DEFAULT PURCHASE_ACCOUNT & INVOICE_ACCOUNT -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="default_purchase_account_id">@lang('user.fields.default_purchase_account_id')</label>
                                    <select class="form-control" name="default_purchase_account_id" id="default_purchase_account_id" data-control="select2" data-allow-clear="true" data-placeholder="@lang('user.fields.select_account')">
                                        @if($user->default_purchase_account)
                                            <option value="{{ $user->default_purchase_account->id }}" @selected(true)>
                                                {{ $user->default_purchase_account->label }}
                                            </option>
                                        @endif
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="default_invoice_account_id">@lang('user.fields.default_invoice_account_id')</label>
                                    <select class="form-control" name="default_invoice_account_id" id="default_invoice_account_id" data-control="select2" data-allow-clear="true" data-placeholder="@lang('user.fields.select_account')">
                                        @if($user->default_invoice_account)
                                            <option value="{{ $user->default_invoice_account->id }}" @selected(true)>
                                                {{ $user->default_invoice_account->label }}
                                            </option>
                                        @endif
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>

                        <div class="border-bottom border-2 border-light m-2"></div>

                        <!-- PASSWORD & CONFIRMATION -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">@lang('user.fields.password')</label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="@lang('user.fields.password')">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">@lang('user.fields.password_confirmation')</label>
                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="@lang('user.fields.password_confirmation')">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1 submit-btn">
                                    @lang('user.actions.edit_model')<i class="fa fa-spinner fa-spin d-none"></i>
                                </button>
                                <a href="{{route('management.users.index')}}" class="btn btn-secondary waves-effect"> <i class="fa fa-arrow-left"></i>
                                    @lang('general.actions.back')
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            let $companies         = $('#companies'),
                $invoiceTemplates  = $('#invoice_templates'),
                $accounts          = $('#accounts'),
                $invoiceTemplate   = $('#invoice_template_id'),
                $warehouses        = $('#warehouses'),
                $processCategories = $('#process_categories'),
                $defaultWarehouse  = $('#default_warehouse_id'),
                $defaultAccount    = $('#default_purchase_account_id, #default_invoice_account_id'),
                $defaultCurrency   = $('#default_purchase_currency_id, #default_invoice_currency_id, #default_quote_currency_id');

            $companies.select2({
                placeholder: "@lang('user.fields.select_companies')",
                allowClear: true,
                ajax: {
                    url: "{{ route('management.companies.search') }}",
                    dataType: 'json',
                    delay: 250,
                    cache: false,
                    data: function (params) {
                        return {
                            keyword: params.term,
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (company) {
                                return {
                                    id: company.id,
                                    text: company.label,
                                };
                            })
                        };
                    },
                }
            });

            $invoiceTemplates.select2({
                placeholder: "@lang('user.fields.select_templates')",
                allowClear: true,
                ajax: {
                    url: "{{ route('management.invoice-templates.search') }}",
                    dataType: 'json',
                    delay: 250,
                    cache: false,
                    data: function (params) {
                        return {
                            keyword: params.term,
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (company) {
                                return {
                                    id: company.id,
                                    text: company.label,
                                };
                            })
                        };
                    },
                }
            });

            $accounts.select2({
                placeholder: "@lang('user.fields.select_accounts')",
                allowClear: true,
                ajax: {
                    url: "{{ route('management.accounts.search') }}",
                    dataType: 'json',
                    delay: 250,
                    cache: false,
                    data: function (params) {
                        return {
                            keyword: params.term,
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (account) {
                                return {
                                    id: account.id,
                                    text: account.label,
                                };
                            })
                        };
                    },
                }
            });

            $warehouses.select2({
                placeholder: "@lang('user.fields.select_warehouses')",
                allowClear: true,
                ajax: {
                    url: "{{ route('management.warehouses.search') }}",
                    dataType: 'json',
                    delay: 250,
                    cache: false,
                    data: function (params) {
                        return {
                            keyword: params.term,
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (warehouse) {
                                return {
                                    id: warehouse.id,
                                    text: warehouse.label,
                                };
                            })
                        };
                    },
                }
            });

            $defaultWarehouse.select2({
                placeholder: "@lang('user.fields.select_default_warehouse')",
                allowClear: true,
                ajax: {
                    url: "{{ route('management.warehouses.search') }}",
                    dataType: 'json',
                    delay: 250,
                    cache: false,
                    data: function (params) {
                        return {
                            keyword: params.term,
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (warehouse) {
                                return {
                                    id: warehouse.id,
                                    text: warehouse.label,
                                };
                            })
                        };
                    },
                }
            });

            $defaultCurrency.select2({
                placeholder: "@lang('user.fields.select_currency')",
                allowClear: true,
                ajax: {
                    url: "{{ route('management.currencies.search') }}",
                    dataType: 'json',
                    delay: 250,
                    cache: false,
                    data: function (params) {
                        return {
                            keyword: params.term,
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (currency) {
                                return {
                                    id: currency.id,
                                    text: currency.label,
                                };
                            })
                        };
                    },
                }
            });

            $defaultAccount.select2({
                placeholder: "@lang('user.fields.select_account')",
                allowClear: true,
                ajax: {
                    url: "{{ route('management.accounts.search') }}",
                    dataType: 'json',
                    delay: 250,
                    cache: false,
                    data: function (params) {
                        return {
                            keyword: params.term,
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (account) {
                                return {
                                    id: account.id,
                                    text: account.label,
                                };
                            })
                        };
                    },
                }
            });

            $invoiceTemplate.select2({
                placeholder: "@lang('user.fields.select_template')",
                allowClear: true,
                ajax: {
                    url: "{{ route('management.invoice-templates.search') }}",
                    dataType: 'json',
                    delay: 250,
                    cache: false,
                    data: function (params) {
                        return {
                            keyword: params.term,
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (response) {
                                return {
                                    id: response.id,
                                    text: response.name,
                                };
                            })
                        };
                    },
                }
            });

            $processCategories.select2({
                placeholder: "@lang('user.fields.select_process_categories')",
                allowClear: true,
                ajax: {
                    url: "{{ route('management.process-categories.search') }}",
                    dataType: 'json',
                    delay: 250,
                    cache: false,
                    data: function (params) {
                        return {
                            keyword: params.term,
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (response) {
                                return {
                                    id: response.id,
                                    text: response.label,
                                };
                            })
                        };
                    },
                }
            });
        });
    </script>
@endsection
