@extends('_layouts.app', [
    'title'           => __('user.actions.create_model'),
    'container_class' => 'container-fluid',
])

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('management.dashboard') }}">@lang('general.dashboard')</a></li>
    <li class="breadcrumb-item"><a href="{{ route('management.users.index') }}">@lang('user.plural')</a></li>
    <li class="breadcrumb-item active">@lang('user.actions.create')</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header border-info border-3">
                    <h4 class="card-title">@lang('user.actions.create_model')</h4>
                </div>
                <form class="ajax-form" method="POST" action="{{ route('management.users.store') }}">
                    @csrf
                    <div class="card-body">
                        <!-- FIRST_NAME & LAST_NAME -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="first_name" class="form-label">@lang('user.fields.first_name')</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name" placeholder="@lang('user.fields.first_name')">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="last_name" class="form-label">@lang('user.fields.last_name')</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name" placeholder="@lang('user.fields.last_name')">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>

                        <!-- EMAIL & MOBILE -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">@lang('user.fields.email')</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="@lang('user.fields.email')">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="mobile" class="form-label">@lang('user.fields.mobile')</label>
                                    <input type="tel" class="form-control" name="mobile" id="mobile" placeholder="@lang('user.fields.mobile')">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>

                        <!-- ROLE & COMPANIES -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="role_id">@lang('user.fields.role')</label>
                                    <select class="form-control select2" name="role_id" id="role_id"
                                            data-allow-clear="true"
                                            data-placeholder="@lang('user.fields.select_role')">
                                        <option value="">@lang('user.fields.select_role')</option>
                                        @foreach(\App\Enums\RolesEnum::cases() as $type)
                                            <option value="{{ $type->value }}">{{ $type->label() }}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="locale">@lang('user.fields.locale')</label>
                                    <select name="locale" id="locale"
                                            class="form-control select2"
                                            data-allow-clear="true"
                                            data-placeholder="@lang('user.fields.select_locale')">
                                        <option value="">@lang('user.fields.locale')</option>
                                        @foreach(config('app.locales') as $locale)
                                            <option value="{{ $locale }}">
                                                @lang("general.locales.{$locale}")
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="border-bottom border-2 border-light m-2"></div>

                        <!-- PASSWORD & CONFIRMATION -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="password">@lang('user.fields.password')</label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="@lang('user.fields.password')">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="password_confirmation">@lang('user.fields.password_confirmation')</label>
                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="@lang('user.fields.password_confirmation')">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-outline-primary mr-1 submit-btn">
                                @lang('user.actions.create_model')<i class="fa fa-spinner fa-spin d-none"></i>
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
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            //
        });
    </script>
@endsection
