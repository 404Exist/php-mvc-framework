<?php 

namespace App\Core\Support;

class Str
{
    /**
     * Convert the given string to lower-case.
     *
     * @param  string  $value
     * @return string
    */
    public static function lower($value)
    {
        return mb_strtolower($value, 'UTF-8');
    }

    /**
     * Convert a string to snake case.
     *
     * @param  string  $value
     * @param  string  $delimiter
     * @return string
    */
    public static function snake($value, $delimiter = '_')
    {
        $value = preg_replace('/\s+/u', '', ucwords($value));

        return static::lower(preg_replace('/(.)(?=[A-Z])/u', '$1'.$delimiter, $value) , 'UTF-8');
    }

    /**
     * Get the plural form of an English word.
     *
     * @param  string  $value
     * @param  int|array|\Countable  $count
     * @return string
    */
    public static function plural($value, $count = 2)
    {
        return Pluralizer::plural($value, $count);
    }

    /**
     * Pluralize the last word of an English, studly caps case string.
     *
     * @param  string  $value
     * @param  int|array|\Countable  $count
     * @return string
     */
    public static function pluralStudly($value, $count = 2)
    {
        $parts = preg_split('/(.)(?=[A-Z])/u', $value, -1, PREG_SPLIT_DELIM_CAPTURE);

        $lastWord = array_pop($parts);

        return implode('', $parts).self::plural($lastWord, $count);
    }
}