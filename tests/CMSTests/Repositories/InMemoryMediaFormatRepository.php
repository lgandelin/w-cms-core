<?php

namespace CMSTests\Repositories;

use CMS\Entities\MediaFormat;
use CMS\Repositories\MediaFormatRepositoryInterface;

class InMemoryMediaFormatRepository implements MediaFormatRepositoryInterface
{
    private $mediaFormats;

    public function __construct()
    {
        $this->mediaFormats = [];
    }

    public function findByID($mediaFormatID)
    {
        foreach ($this->mediaFormats as $mediaFormat) {
            if ($mediaFormat->getID() == $mediaFormatID) {
                return $mediaFormat;
            }
        }

        return false;
    }

    public function findAll()
    {
        return $this->mediaFormats;
    }

    public function createMediaFormat(MediaFormat $mediaFormat)
    {
        $this->mediaFormats[]= $mediaFormat;
    }

    public function updateMediaFormat(MediaFormat $mediaFormat)
    {
        foreach ($this->mediaFormats as $mediaFormatModel) {
            if ($mediaFormatModel->getID() == $mediaFormat->getID()) {
                $mediaFormatModel->setName($mediaFormat->getName());
            }
        }
    }

    public function deleteMediaFormat($mediaFormatID)
    {
        foreach ($this->mediaFormats as $i => $mediaFormat) {
            if ($mediaFormat->getID() == $mediaFormatID) {
                unset($this->mediaFormats[$i]);
            }
        }
    }
}
