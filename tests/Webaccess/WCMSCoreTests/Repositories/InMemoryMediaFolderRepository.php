<?php

namespace Webaccess\WCMSCoreTests\Repositories;

use Webaccess\WCMSCore\Entities\MediaFolder;
use Webaccess\WCMSCore\Repositories\MediaFolderRepositoryInterface;

class InMemoryMediaFolderRepository implements MediaFolderRepositoryInterface
{
    private $mediaFolders;

    public function __construct()
    {
        $this->mediaFolders = [];
    }

    public function findByID($mediaFolderID)
    {
        foreach ($this->mediaFolders as $mediaFolder) {
            if ($mediaFolder->getID() == $mediaFolderID) {
                return $mediaFolder;
            }
        }

        return false;
    }

    public function findByPath($mediaFolderPath)
    {
        foreach ($this->mediaFolders as $mediaFolder) {
            if ($mediaFolder->getPath() == $mediaFolderPath) {
                return $mediaFolder;
            }
        }

        return false;
    }

    public function findAll()
    {
        return $this->mediaFolders;
    }

    public function createMediaFolder(MediaFolder $mediaFolder)
    {
        $mediaFolderID = sizeof($this->mediaFolders) + 1;
        $mediaFolder->setID($mediaFolderID);
        $this->mediaFolders[]= $mediaFolder;

        return $mediaFolderID;
    }

    public function updateMediaFolder(MediaFolder $mediaFolder)
    {
        foreach ($this->mediaFolders as $mediaFolderModel) {
            if ($mediaFolderModel->getID() == $mediaFolder->getID()) {
                $mediaFolderModel->setName($mediaFolder->getName());
                $mediaFolderModel->setParentID($mediaFolder->getParentID());
                $mediaFolderModel->setPath($mediaFolder->getPath());
            }
        }
    }

    public function deleteMediaFolder($mediaFolderID)
    {
        foreach ($this->mediaFolders as $i => $mediaFolder) {
            if ($mediaFolder->getID() == $mediaFolderID) {
                unset($this->mediaFolders[$i]);
            }
        }
    }
}
