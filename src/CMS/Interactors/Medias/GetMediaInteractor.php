<?php

namespace CMS\Interactors\Medias;

use CMS\Interactors\Interactor;
use CMS\Repositories\MediaRepositoryInterface;
use CMS\Structures\MediaStructure;

class GetMediaInteractor extends Interactor
{
    protected $repository;

    public function __construct(MediaRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getMediaByID($mediaID, $structure = false)
    {
        if (!$media = $this->repository->findByID($mediaID)) {
            throw new \Exception('The media was not found');
        }

        return ($structure) ? MediaStructure::toStructure($media) : $media;
    }
}
