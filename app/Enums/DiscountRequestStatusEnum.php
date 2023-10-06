<?php

namespace App\Enums;

enum DiscountRequestStatusEnum: string
{
    case PENDING  = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    public static function default(): self
    {
        return self::PENDING;
    }

    public static function values(): array
    {
        return array_map(function (DiscountRequestStatusEnum $case) {
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
            self::PENDING->value  => 'secondary',
            self::APPROVED->value => 'success',
            self::REJECTED->value => 'warning',
        ][$this->value];
    }

}
