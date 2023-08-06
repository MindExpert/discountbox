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

}
