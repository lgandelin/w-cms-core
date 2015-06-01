<?php

namespace CMS\Interactors\Medias;

use CMS\Context;
use CMS\Entities\Media;
use CMS\Interactors\Interactor;
use CMS\Structures\MediaStructure;

class CreateMediaInteractor extends Interactor
{
    public function run(MediaStructure $mediaStructure)
    {
        $media = $this->createMediaFromStructure($mediaStructure);

        $media->valid();

        return Context::$mediaRepository->createMedia($media);
    }

    private function createMediaFromStructure($mediaStructure)
    {
        $media = new Media();
        $media->setID($mediaStructure->ID);
        $media->setName($mediaStructure->name);
        $media->setFileName($mediaStructure->file_name);
        $media->setAlt($mediaStructure->alt);
        $media->setTitle($mediaStructure->title);

        return $media;
    }
}
