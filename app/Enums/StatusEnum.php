<?php

namespace App\Enums;

enum StatusEnum: string
{
    case IN_PROGRESS = 'in_progress';
    case AWARDED     = 'awarded';
    case CONCLUDED   = 'concluded';

    public static function default(): self
    {
        return self::IN_PROGRESS;
    }

    public static function values(): array
    {
        return array_map(function (StatusEnum $case) {
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
            self::IN_PROGRESS->value  => 'primary',
            self::AWARDED->value      => 'success',
            self::CONCLUDED->value    => 'warning',
        ][$this->value];
    }

}
