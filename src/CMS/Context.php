<?php

namespace CMS;

class Context
{
    public static $repositories;

    function __construct()
    {
        self::$repositories = [];
    }

    public static function addRepository($identifier, $repositoryObject) {
        self::$repositories[$identifier] = $repositoryObject;
    }

    public static function getRepository($identifier) {
        return self::$repositories[$identifier];
    }
}