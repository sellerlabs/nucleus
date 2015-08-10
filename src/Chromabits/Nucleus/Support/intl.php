<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

if (!function_exists('mb_lcfirst')) {
    /**
     * Multi-byte version of lcfirst().
     *
     * @param string $str
     * @param null|string $encoding
     *
     * @return string
     */
    function mb_lcfirst($str, $encoding = null)
    {
        $encoding = coalesce($encoding, mb_internal_encoding());

        $first = mb_strtolower(
            mb_substr($str, 0, 1, $encoding),
            $encoding
        );

        return $first . mb_substr($str, 1, null, $encoding);
    }
}

if (!function_exists('mb_ucfirst')) {
    /**
     * Multi-byte version of ucfirst().
     *
     * @param string $str
     * @param null|string $encoding
     *
     * @return string
     */
    function mb_ucfirst($str, $encoding = null)
    {
        $encoding = coalesce($encoding, mb_internal_encoding());

        $first = mb_strtoupper(
            mb_substr($str, 0, 1, $encoding),
            $encoding
        );

        return $first . mb_substr($str, 1, null, $encoding);
    }
}

if (!function_exists('mb_ctype_lower')) {
    /**
     * Multi-byte version of ctype_lower().
     *
     * @param string $text
     * @param null|string $encoding
     *
     * @return bool
     */
    function mb_ctype_lower($text, $encoding = null)
    {
        $encoding = coalesce($encoding, mb_internal_encoding());
        $characters = preg_split('//u', $text, -1, PREG_SPLIT_NO_EMPTY);

        foreach ($characters as $char) {
            if (mb_strtolower($char, $encoding) != $char) {
                return false;
            }
        }

        return true;
    }
}

if (!function_exists('mb_ucwords')) {
    /**
     * Multibyte version of ucwords().
     *
     * @param string $str
     * @param string $delimiters
     * @param null|string $encoding
     *
     * @return mixed|string
     */
    function mb_ucwords($str, $delimiters = '', $encoding = null)
    {
        $encoding = coalesce($encoding, mb_internal_encoding());

        if (is_string($delimiters)) {
            $delimiters = str_split(str_replace(' ', '', $delimiters));
        }

        $firstPattern = [];
        $firstReplace = [];
        $secondPattern = [];
        $secondReplace = [];

        foreach ($delimiters as $delimiter) {
            $id = uniqid();
            $firstPattern[] = '/' . preg_quote($delimiter) . '/';
            $firstReplace[] = $delimiter . $id . ' ';
            $secondPattern[] = '/' . preg_quote($delimiter . $id . ' ') . '/';
            $secondReplace[] = $delimiter;
        }

        $result = preg_replace($firstPattern, $firstReplace, $str);

        $words = explode(' ', $result);

        foreach ($words as $index => $word) {
            $words[$index] = mb_ucfirst($word, $encoding);
        }

        $result = implode(' ', $words);

        $result = preg_replace($secondPattern, $secondReplace, $result);

        return $result;
    }
}
