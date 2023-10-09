<?php

namespace App\Enums;

enum TransactionTypeEnum: string
{
    case LOGIN            = 'login';
    case SHARE            = 'share';
    case LIKE             = 'like';
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
            self::PROFILE_COMPLETE->value => 'info',
            self::SHARE->value            => 'danger',
            self::LIKE->value             => 'warning',
            self::EXPENDITURE->value      => 'secondary',
            self::MANUAL_CREDIT->value    => 'success',
            self::MANUAL_DEBIT->value     => 'danger',
        ][$this->value];
    }

    public function icon(): string
    {
        return [
            self::LOGIN->value            => 'bi-box-arrow-in-left',
            self::PROFILE_COMPLETE->value => 'bi-person-bounding-box',
            self::SHARE->value            => 'bi-share',
            self::LIKE->value             => 'bi-star',
            self::EXPENDITURE->value      => 'bi-currency-exchange',
            self::MANUAL_CREDIT->value    => 'bi-window-plus',
            self::MANUAL_DEBIT->value     => 'bi-window-dash',
        ][$this->value];
    }

    public function description(?int $value = null): string
    {
        return [
            self::LOGIN->value            => __('transaction.description.login', ['amount' => config('app.bonuses.login')]),
            self::PROFILE_COMPLETE->value => __('transaction.description.profile', ['amount' => config('app.bonuses.profile')]),
            self::SHARE->value            => __('transaction.description.share', ['amount' => config('app.bonuses.share')]),
            self::LIKE->value             => __('transaction.description.like', ['amount' => config('app.bonuses.like')]),
            self::EXPENDITURE->value      => __('transaction.description.expenditure', ['amount' => $value]),
            self::MANUAL_CREDIT->value    => __('transaction.description.manual', ['type' => 'CREDIT','amount' => $value]),
            self::MANUAL_DEBIT->value     => __('transaction.description.manual', ['type' => 'DEBIT','amount' => $value]),
        ][$this->value];
    }

}
