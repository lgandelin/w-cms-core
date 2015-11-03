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

    public function findAll()
    {
        return $this->mediaFolders;
    }

    public function createMediaFolder(MediaFolder $mediaFolder)
    {
        $this->mediaFolders[]= $mediaFolder;
    }

    public function updateMediaFolder(MediaFolder $mediaFolder)
    {
        foreach ($this->mediaFolders as $mediaFolderModel) {
            if ($mediaFolderModel->getID() == $mediaFolder->getID()) {
                $mediaFolderModel->setName($mediaFolder->getName());
                $mediaFolderModel->setParentID($mediaFolder->getParentID());
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
