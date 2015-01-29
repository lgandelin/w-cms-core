<?php

namespace CMS\Interactors\MediaFormats;

use CMS\Interactors\Interactor;
use CMS\Repositories\MediaFormatRepositoryInterface;
use CMS\Structures\MediaFormatStructure;

class GetMediaFormatInteractor extends Interactor
{
    protected $repository;

    public function __construct(MediaFormatRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getMediaFormatByID($mediaFormatID, $structure = false)
    {
        if (!$mediaFormat = $this->repository->findByID($mediaFormatID)) {
            throw new \Exception('The media format was not found');
        }

        return ($structure) ? MediaFormatStructure::toStructure($mediaFormat) : $mediaFormat;
    }
}
