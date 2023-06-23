@extends('_layouts.app', [
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
                    <div class="btn-group btn-group-sm" role="group" aria-label="">
                        @can('update', $user)
                            <a href="{{route('management.users.edit', ['user' => $user->id])}}" class="btn btn-outline-warning tippy-btn" title="@lang('user.actions.edit')">
                                <i class="fa fa-pencil-alt"></i> @lang('user.actions.edit')
                            </a>
                        @endcan
                        @can('delete', $user)
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
                                    <td class="value">{{ $user->role->label() }}</td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('user.fields.mobile')</th>
                                    <td class="value"><a href="tel:{{ $user->mobile }}">{{ $user->mobile }}</a></td>
                                </tr>
                                <tr>
                                    <th class="label">@lang('user.fields.email')</th>
                                    <td class="value"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                                </tr>
                                {{--<tr>--}}
                                {{--    <th class="label">@lang('user.fields.locale')</th>--}}
                                {{--    <td class="value">@lang("general.locales.{$user->locale}")</td>--}}
                                {{--</tr>--}}
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
