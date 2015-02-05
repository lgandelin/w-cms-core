<?php

namespace CMS\Interactors\MediaFormats;

use CMS\Entities\MediaFormat;
use CMS\Interactors\Interactor;
use CMS\Structures\MediaFormatStructure;

class CreateMediaFormatInteractor extends Interactor
{
    private $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function run(MediaFormatStructure $mediaFormatStructure)
    {
        $mediaFormat = $this->createMediaFormatFromStructure($mediaFormatStructure);

        $mediaFormat->valid();

        return $this->repository->createMediaFormat($mediaFormat);
    }

    private function createMediaFormatFromStructure($mediaFormatStructure)
    {
        $mediaFormat = new MediaFormat();
        $mediaFormat->setID($mediaFormatStructure->ID);
        $mediaFormat->setName($mediaFormatStructure->name);
        $mediaFormat->setWidth($mediaFormatStructure->width);
        $mediaFormat->setHeight($mediaFormatStructure->height);

        return $mediaFormat;
    }
}