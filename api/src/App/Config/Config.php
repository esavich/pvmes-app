<?php

namespace App\Config;


class Config
{
    public static $config = [];

    public static function load($config)
    {
        self::$config = $config;
    }

    public static function get($key, $default = null)
    {
        return self::$config[$key] ?? $default;
    }
}