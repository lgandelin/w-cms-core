<?php

namespace CMS\Structures;

use CMS\Entities\Media;

class MediaStructure extends DataStructure
{
    public $ID;
    public $name;
    public $file_name;
    public $alt;
    public $title;

    public static function toStructure(Media $media)
    {
        $mediaStructure = new MediaStructure();
        $mediaStructure->ID = $media->getID();
        $mediaStructure->name = $media->getName();
        $mediaStructure->file_name = $media->getFileName();
        $mediaStructure->alt = $media->getAlt();
        $mediaStructure->title = $media->getTitle();

        return $mediaStructure;
    }
} 