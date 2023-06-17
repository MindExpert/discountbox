<?php

namespace App\Support;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;

class Helper
{
    public const PREFIX = 'AL';
    public const POSTFIX = '';

    /**
     * @param int $id
     * @param string $type
     *
     * @return string
     * This function will be used to generate a unique serial code for a subject
     *
     * @example Helper::serial(1, 'D') // AL-D-12209481529692
     */
    public static function serial(int $id, string $type = 'D'): string
    {
        if (empty(trim($type))) {
            $type = self::POSTFIX;
        }

        $prefix = self::PREFIX;

        $generateNextNumber  = Carbon::now()->format('ym');
        $generateNextNumber1 = Carbon::now()->format('iHd');
        $generateNextNumber2 = substr(Carbon::now()->format('u'), 0, 3);

        return $prefix.'-'.$type.'-'.$id.$generateNextNumber.$generateNextNumber1.$generateNextNumber2;
    }

    /**
     * @param mixed $model
     *
     * @return string|null
     */
    public static function getClassName(mixed $model): ?string
    {
        try {
            if (property_exists($model, 'morph_key')) {
                return $model::$morph_key;
            }

            $reflect = new ReflectionClass($model);

            $className = Str::snake($reflect->getShortName());

            if ($className !== null && strlen($className) > 0) {
                return $className;
            }

            return get_class($model);
        } catch(ReflectionException $e) {
            report($e);

            return null;
        }
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
        } while (!$unique);

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

        return array_map(function ($item) use ($onlyNumeric) {
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
    }
}
