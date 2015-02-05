<?php

namespace CMS\Interactors\MediaFormats;

use CMS\Interactors\Interactor;
use CMS\Repositories\MediaFormatRepositoryInterface;
use CMS\Structures\MediaFormatStructure;

class GetMediaFormatsInteractor extends Interactor
{
    private $repository;

    public function __construct(MediaFormatRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll($structure = false)
    {
        $mediaFormats = $this->repository->findAll();

        return ($structure) ? $this->getMediaFormatStructures($mediaFormats) : $mediaFormats;
    }

    private function getMediaFormatStructures($mediaFormats)
    {
        $mediaFormatStructures = [];
        if (is_array($mediaFormats) && sizeof($mediaFormats) > 0) {
            foreach ($mediaFormats as $mediaFormat) {
                $mediaFormatStructures[] = MediaFormatStructure::toStructure($mediaFormat);
            }
        }

        return $mediaFormatStructures;
    }
}
