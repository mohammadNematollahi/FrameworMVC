<?php

namespace System\Cookie;

class Cookie
{
    public function get($name)
    {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : false;
    }
    public function remove($name)
    {
        setcookie($name, '', time() - 3600);
    }
    public function set($name, $value, $expire)
    {
        setcookie($name, $value, $expire , '/');
        return true;
    }

    public static function __callStatic($method, $arguments)
    {
        $instance = new self();
        return call_user_func_array(array($instance, $method), $arguments);
    }
}