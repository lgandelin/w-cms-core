<?php

namespace CMSTests\Repositories;

use CMS\Entities\Media;
use CMS\Repositories\MediaRepositoryInterface;

class InMemoryMediaRepository implements MediaRepositoryInterface
{
    private $medias;

    public function __construct()
    {
        $this->medias = [];
    }

    public function findByID($mediaID)
    {
        foreach ($this->medias as $media) {
            if ($media->getID() == $mediaID) {
                return $media;
            }
        }

        return false;
    }

    public function findAll()
    {
        return $this->medias;
    }

    public function createMedia(Media $media)
    {
        $this->medias[]= $media;
    }

    public function updateMedia(Media $media)
    {
        foreach ($this->medias as $mediaModel) {
            if ($mediaModel->getID() == $media->getID()) {
                $mediaModel->setName($media->getName());
                $mediaModel->setPath($media->getPath());
            }
        }
    }

    public function deleteMedia($mediaID)
    {
        foreach ($this->medias as $i => $media) {
            if ($media->getID() == $mediaID) {
                unset($this->medias[$i]);
            }
        }
    }
}
