<?php

namespace CMS\Structures;

use CMS\Entities\Media;

class MediaStructure extends DataStructure
{
    public $ID;
    public $name;
    public $path;
    public $alt;
    public $title;

    public static function toStructure(Media $media)
    {
        $mediaStructure = new MediaStructure();
        $mediaStructure->ID = $media->getID();
        $mediaStructure->name = $media->getName();
        $mediaStructure->path = $media->getPath();
        $mediaStructure->alt = $media->getAlt();
        $mediaStructure->title = $media->getTitle();

        return $mediaStructure;
    }
} 