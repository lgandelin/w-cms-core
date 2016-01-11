<?php

namespace Webaccess\WCMSCore\Tools;

class String
{
    public static function getSlug($string)
    {
        $string = strtolower($string);
        $string = self::dropAccents($string);
        $string = preg_replace('#[^a-z0-9]#i', '-', $string);
        $string = preg_replace('#\-\-#', '', $string);

        return $string;
    }

    public static function dropAccents($string, $charset='utf-8')
    {
        $string = htmlentities($string, ENT_NOQUOTES, $charset);

        $string = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $string);
        $string = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $string);
        $string = preg_replace('#&[^;]+;#', '', $string);

        return $string;
    }
} 