<?php

namespace Webaccess\WCMSCore\Interactors\MediaFolders;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Tools\String;

class UpdateMediaFolderInteractor extends GetMediaFolderInteractor
{
    public function run($mediaFolderID, DataStructure $mediaFolderStructure)
    {
        if ($mediaFolder = $this->getMediaFolderByID($mediaFolderID)) {
            $mediaFolder->setInfos($mediaFolderStructure);
            $mediaFolder->setPath((new GetMediaFolderInteractor())->getParentMediaFolderPath($mediaFolder) . '/' . String::getSlug($mediaFolder->getName()));
            $mediaFolder->valid();

            if ($this->anotherExistingMediaFolderWithSamePath($mediaFolder->getPath(), $mediaFolder->getID())) {
                throw new \Exception('There is already a media folder with the same path');
            }

            Context::get('media_folder_repository')->updateMediaFolder($mediaFolder);
        }
    }

    private function anotherExistingMediaFolderWithSamePath($path, $mediaFolderID)
    {
        $existingDataStructure = Context::get('media_folder_repository')->findByPath($path);

        return ($existingDataStructure && $existingDataStructure->getID() != $mediaFolderID);
    }
}
