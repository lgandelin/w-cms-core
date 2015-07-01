<?php

namespace CMS;

class Context
{
    public static $objects;

    function __construct()
    {
        self::$objects = [];
    }

    public static function add($identifier, $object) {
        self::$objects[$identifier] = $object;
    }

    public static function addTo($identifier, $identifier2, $object) {
        if (!isset(self::$objects[$identifier])) {
            self::$objects[$identifier] = [];
        }
        self::$objects[$identifier][$identifier2] = $object;
    }

    public static function get($identifier) {
        return (isset(self::$objects[$identifier])) ? self::$objects[$identifier] : false;
    }
}