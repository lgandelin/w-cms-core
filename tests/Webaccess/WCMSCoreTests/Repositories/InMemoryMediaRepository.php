<?php

namespace Webaccess\WCMSCoreTests\Repositories;

use Webaccess\WCMSCore\Entities\Media;
use Webaccess\WCMSCore\Repositories\MediaRepositoryInterface;

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

    public function findAllByMediaFolderID($mediaFolderID)
    {
        $medias = [];
        foreach ($this->medias as $media) {
            if ($media->getMediaFolderID() == $mediaFolderID) {
                $medias[]= $media;
            }
        }

        return $medias;
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
                $mediaModel->setFileName($media->getFileName());
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
