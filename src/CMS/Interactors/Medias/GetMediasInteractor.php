<?php

namespace CMS\Interactors\Medias;

use CMS\Interactors\Interactor;
use CMS\Repositories\MediaRepositoryInterface;
use CMS\Structures\MediaStructure;

class GetMediasInteractor extends Interactor
{
    private $repository;

    public function __construct(MediaRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll($structure = false)
    {
        $medias = $this->repository->findAll();

        return ($structure) ? $this->getMediaStructures($medias) : $medias;
    }

    private function getMediaStructures($medias)
    {
        $mediaStructures = [];
        if (is_array($medias) && sizeof($medias) > 0) {
            foreach ($medias as $media) {
                $mediaStructures[] = MediaStructure::toStructure($media);
            }
        }

        return $mediaStructures;
    }
}
