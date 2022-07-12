<?php

namespace App\Support;

class Str
{
    /**
     * @param  string $value
     * @param  string $seperator
     * @return string
     */
    public function slug($value, $seperator = '-')
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', $seperator, $value)));
    }

    /**
     * Limit the number of characters in a string.
     *
     * @param  string  $value
     * @param  int     $limit
     * @param  string  $end
     * @return string
     */
    public static function limit($value, $limit = 100, $end = '...')
    {
        if (mb_strwidth($value, 'UTF-8') <= $limit) {
            return $value;
        }

        return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')).$end;
    }
}