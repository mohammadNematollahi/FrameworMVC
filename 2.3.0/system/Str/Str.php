<?php

namespace System\Str;

class Str
{
    public static function startsWith($str, $need): bool
    {
        $result = strpos($str, $need);
        return $result == 0 ? true : false;
    }

    public static function length($str): int
    {
        return strlen($str);
    }

    public static function limit($str, $num, $end = "..."): string
    {
        $str = trim(substr($str, 0, $num), " ");
        return $str .= $end;
    }

    public static function position($str, $need): string
    {
        return $str = strpos($str, $need);
    }

    public static function mask($str, $char, int $start, int $end = null): string
    {
        if ($end === null) {
            $end = strlen($str) - $start;
        }

        $subStr = substr($str, $start, $end);
        $chars = str_repeat($char, strlen($subStr));

        return str_replace($subStr, $chars, $str);
    }

    public static function remove($char, string $str): string
    {
        return str_replace($char, "", $str);
    }

    public static function reaplace($search, $replace, $subject): string
    {
        return str_replace($search, $replace, $subject);
    }

    public static function slug($str, $slug): string
    {
        $str = trim($str, " ");
        return str_replace(" ", $slug, $str);
    }

    public static function substr($str, $start, $end = null): string
    {
        if ($end === null) {
            $end = strlen($str);
        }
        return substr($str, $start, $end);
    }

    public static function substrReplace($str, $replace, $start, $end = null): string
    {
        if ($end === null) {
            $end = strlen($str);
        }
        return substr_replace($str, $replace, $start, $end);
    }
}
