<?php

namespace App\Support;

final class FlashNotification
{
    public const SESSION_NAME = 'FLASH_NOTIFICATIONS';
    public const INFO         = 'info';
    public const SUCCESS      = 'success';
    public const WARNING      = 'warning';
    public const ERROR        = 'error';

    public static function add(string $type, string $title, ?string $message = null): void
    {
        $notifications = [];

        if (session()->has(self::SESSION_NAME)) {
            $notifications = session()->get(self::SESSION_NAME);
        }

        $notifications[] = self::formatNotification($type, $title, $message);

        session()->flash(self::SESSION_NAME, $notifications);
    }

    public static function info(string $title, ?string $message = null): void
    {
        self::add(self::INFO, $title, $message);
    }

    public static function success(string $title, ?string $message = null): void
    {
        self::add(self::SUCCESS, $title, $message);
    }

    public static function warning(string $title, ?string $message = null): void
    {
        self::add(self::WARNING, $title, $message);
    }

    public static function error(string $title, ?string $message = null): void
    {
        self::add(self::ERROR, $title, $message);
    }

    private static function formatNotification(string $type, string $title, ?string $message = null): array
    {
        return [
            'type'    => $type,
            'title'   => $title,
            'message' => $message,
        ];
    }
}
