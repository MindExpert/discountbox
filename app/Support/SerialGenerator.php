<?php

namespace App\Support;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

    /**
     * Generate a unique random string of characters
     *
     * @param  int  $length   - Desired length (optional)
     * @param  string  $table - name of the table
     * @param  string  $col   - name of the column that needs to be tested
     * @param  string  $flag  - Output type (NUMERIC, ALPHANUMERIC, NO_NUMERIC, RANDOM)
     *
     * @return string
     * @throws Exception
     */
    public static function uniqueRandom(
        int $length = 8,
        string $col = 'name',
        string $table = 'users',
        string $flag = 'ALPHANUMERIC'
    ): string {
        $unique = false;

        // Store tested results in array to not test them again
        $tested = [];

        if ($length <= 0) {
            $length = 8;
        }

        switch ($flag) {
            case 'NUMERIC':
                $str = '0123456789';
                break;
            case 'NO_NUMERIC':
                $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'RANDOM':
                $num_bytes = ceil($length * 0.75);
                $bytes = static::getBytes($num_bytes);
                return substr(rtrim(base64_encode($bytes), '='), 0, $length);
            case 'ALPHANUMERIC':
            default:
                $str = 'abcdefghijkmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
        }

        $bytes = static::getBytes($length);

        do {
            // Generate random string of characters
            $position = 0;
            $random = '';
            for ($i = 0; $i < $length; $i++) {
                $position = ($position + ord($bytes[$i])) % mb_strlen($str);
                $random .= $str[$position];
            }

            // Check if it's already testing If so, don't query the database again
            if (in_array($random, $tested)) {
                continue;
            }

            // assign postfix and prefix to the code
            $random = self::PREFIX . Str::upper($random) . self::POSTFIX;

            // Check if it is unique in the database
            $doesntExist = DB::table($table)->where($col, '=', $random)->doesntExist();

            // Store the random character in the tested array
            // To keep track which ones are already tested
            $tested[] = $random;

            // String appears to be unique
            if ($doesntExist) {
                // Set unique to true to break the loop
                $unique = true;
            }

            // If unique is still false at this point
            // it will just repeat all the steps until
            // it has generated a random string of characters
        } while (! $unique);

        return $random;
    }

    /**
     * Random bytes generator
     *
     * Thanks to Zend for entropy
     *
     * @param $length int desired length of random bytes
     *
     * @return bool|string Random bytes
     * @throws Exception
     */
    public static function getBytes(int $length): bool|string
    {
        if ($length <= 0) {
            $length = 8;
        }

        if (function_exists('openssl_random_pseudo_bytes')) {
            $bytes = openssl_random_pseudo_bytes($length, $crypto_strong);

            if ($crypto_strong === true) {
                return $bytes;
            }
        }

        if (function_exists('mcrypt_create_iv')) {
            $bytes = random_bytes($length);

            if (mb_strlen($bytes) === $length) {
                return $bytes;
            }
        }

        // Else try to get $length bytes of entropy.
        // Thanks to Zend

        $result         = '';
        $entropy        = '';
        $msec_per_round = 400;
        $bits_per_round = 2;
        $total          = $length;
        $hash_length    = 20;

        while (mb_strlen($result) < $length) {
            $bytes  = ($total > $hash_length) ? $hash_length : $total;
            $total -= $bytes;

            for ($i=1; $i < 3; $i++) {
                $t1 = microtime(true);
                $seed = mt_rand();

                for ($j=1; $j < 50; $j++) {
                    $seed = sha1($seed);
                }

                $t2 = microtime(true);
                $entropy .= $t1 . $t2;
            }

            $div = (int) (($t2 - $t1) * 1000000);

            if ($div <= 0) {
                $div = 400;
            }

            $rounds = (int) ($msec_per_round * 50 / $div);
            $iter = $bytes * (int) (ceil(8 / $bits_per_round));

            for ($i = 0; $i < $iter; $i ++) {
                $t1 = microtime();
                $seed = sha1(mt_rand());

                for ($j = 0; $j < $rounds; $j++) {
                    $seed = sha1($seed);
                }

                $t2 = microtime();
                $entropy .= $t1 . $t2;
            }

            $result .= sha1($entropy, true);
        }

        return substr($result, 0, $length);
    }


    public static function formatStringToArray(string $string, ?bool $onlyNumeric = false, string $delimiter = ','): array
    {
        //Explode the string into an array with the delimiter being a comma,
        // then trim the space from each element in the array
        // and check if the element is not empty and is a numeric value (int)
        if (empty($string)) {
            return [];
        }

        $array = array_map(function ($item) use ($onlyNumeric) {
            $item = trim($item);

            if (empty($item)) {
                return null;
            }

            if ($onlyNumeric) {
                if (! is_numeric($item)) {
                    return null;
                }

                return (int) $item;
            }

            return $item;
        }, explode($delimiter, $string));

        return array_values(array_filter($array));
    }
}
