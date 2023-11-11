<?php

namespace App\Enums;

enum TransactionTypeEnum: string
{
    case LOGIN            = 'login';
    case SHARE            = 'share';
    case LIKE             = 'like';
    case INVITE           = 'invite';
    case REGISTER         = 'register';
    case PROFILE_COMPLETE = 'profile';
    case EXPENDITURE      = 'expenditure';
    case MANUAL_CREDIT    = 'manual_credit';
    case MANUAL_DEBIT     = 'manual_debit';

    public static function default(): self
    {
        return self::LOGIN;
    }

    public static function values(): array
    {
        return array_map(function (TransactionTypeEnum $case) {
            return $case->value;
        }, self::cases());
    }

    public function label(): string
    {
        $class = get_class($this);

        return __("enum.{$class}.label.{$this->value}");
    }

    public function color(): string
    {
        return [
            self::LOGIN->value            => 'primary',
            self::SHARE->value            => 'danger',
            self::LIKE->value             => 'warning',
            self::INVITE->value           => 'success',
            self::REGISTER->value         => 'info',
            self::PROFILE_COMPLETE->value => 'info',
            self::EXPENDITURE->value      => 'secondary',
            self::MANUAL_CREDIT->value    => 'success',
            self::MANUAL_DEBIT->value     => 'danger',
        ][$this->value];
    }

    public function icon(): string
    {
        return [
            self::LOGIN->value            => 'bi-box-arrow-in-left',
            self::SHARE->value            => 'bi-share',
            self::LIKE->value             => 'bi-star',
            self::INVITE->value           => 'bi-person-fill-up',
            self::REGISTER->value         => 'bi-person-plus',
            self::PROFILE_COMPLETE->value => 'bi-person-bounding-box',
            self::EXPENDITURE->value      => 'bi-currency-exchange',
            self::MANUAL_CREDIT->value    => 'bi-window-plus',
            self::MANUAL_DEBIT->value     => 'bi-window-dash',
        ][$this->value];
    }

    public function description(?int $value = null): string
    {
        return [
            self::LOGIN->value            => __('transaction.description.login', ['amount' => config('app.bonuses.login')]),
            self::SHARE->value            => __('transaction.description.share', ['amount' => config('app.bonuses.share')]),
            self::LIKE->value             => __('transaction.description.like', ['amount' => config('app.bonuses.like')]),
            self::INVITE->value           => __('transaction.description.invite', ['amount' => config('app.bonuses.invite')]),
            self::REGISTER->value         => __('transaction.description.register', ['amount' => config('app.bonuses.register')]),
            self::PROFILE_COMPLETE->value => __('transaction.description.profile', ['amount' => config('app.bonuses.profile')]),
            self::EXPENDITURE->value      => __('transaction.description.expenditure', ['amount' => $value]),
            self::MANUAL_CREDIT->value    => __('transaction.description.manual', ['type' => 'CREDIT','amount' => $value]),
            self::MANUAL_DEBIT->value     => __('transaction.description.manual', ['type' => 'DEBIT','amount' => $value]),
        ][$this->value];
    }

}
