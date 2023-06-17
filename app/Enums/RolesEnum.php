<?php

namespace App\Enums;

enum RolesEnum: string
{
    case ADMIN = 'admin';
    case USER  = 'user';

    public static function default(): self
    {
        return self::USER;
    }

    public static function values(): array
    {
        return array_map(function (RolesEnum $case) {
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
            self::ADMIN->value  => 'primary',
            self::USER->value   => 'secondary',
        ][$this->value];
    }

}
