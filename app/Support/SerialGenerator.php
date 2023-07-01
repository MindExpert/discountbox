<?php

namespace App\Support;
class SerialGenerator
{
    public const PREFIX = 'DB';
    public const POSTFIX = '';

    /**
     * @param string $prefix
     * @param int $id
     * @param string|null $type
     *
     * @return string
     *
     * @example Helper::generateSerialNumber('AL', '1' 'D') // AL-D-AAA-001
     * @example Helper::generateSerialNumber('AL', '1', 'F') // AL-F-AAA-001
     */
    public static function generateSerialNumber(string $prefix, int $id, ?string $type = null): string
    {
        if (empty(trim($type))) {
            $type = self::POSTFIX;
        }

        if (empty(trim($prefix))) {
            $prefix = self::PREFIX;
        }

        $start = 703; // 0 = A, 703 = AAA, adjust accordingly
        $letters_value = $start + (ceil($id / 999) - 1);
        $numbers = ($id % 999 === 0) ? 999 : $id % 999;

        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $base = strlen($characters);
        $letters = '';

        # while there are still positive integers to divide
        while ($letters_value) {
            $current = $letters_value % $base - 1; # We use -1 because we want to start at 0 index
            $letters = $characters[$current] . $letters;
            $letters_value = floor($letters_value / $base);
        }

        $unique = $prefix.'-'.$type.'-'.$letters.'-'.sprintf('%03d', $numbers);

        return str_replace('--', '-', $unique);
    }
}
