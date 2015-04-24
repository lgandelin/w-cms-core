<?php

namespace CMS\Structures;

use CMS\Entities\MediaFormat;

class MediaFormatStructure extends DataStructure
{
    public $ID;
    public $name;
    public $width;
    public $height;

    public static function toStructure(MediaFormat $media)
    {
        $mediaStructure = new MediaFormatStructure();
        $mediaStructure->ID = $media->getID();
        $mediaStructure->name = $media->getName();
        $mediaStructure->width = $media->getWidth();
        $mediaStructure->height = $media->getHeight();

        return $mediaStructure;
    }
}
