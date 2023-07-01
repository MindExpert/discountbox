<?php

namespace App\Enums;

enum DiscountTypeEnum: string
{
    case PERCENTAGE = 'percentage';
    case VALUE     = 'value';

    public static function default(): self
    {
        return self::PERCENTAGE;
    }

    public static function values(): array
    {
        return array_map(function (DiscountTypeEnum $case) {
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
            self::PERCENTAGE->value => 'primary',
            self::VALUE->value      => 'success',
        ][$this->value];
    }

}
