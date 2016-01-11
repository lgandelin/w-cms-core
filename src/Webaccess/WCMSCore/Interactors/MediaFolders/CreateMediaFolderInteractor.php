<?php

namespace Webaccess\WCMSCore\Interactors\MediaFolders;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Entities\MediaFolder;
use Webaccess\WCMSCore\Interactors\Interactor;
use Webaccess\WCMSCore\Tools\String;

class CreateMediaFolderInteractor extends Interactor
{
    public function run(DataStructure $mediaFolderStructure)
    {
        $mediaFolder = (new MediaFolder())->setInfos($mediaFolderStructure);
        $mediaFolder->setPath((new GetMediaFolderInteractor())->getParentMediaFolderPath($mediaFolder) . '/' . String::getSlug($mediaFolder->getName()));
        $mediaFolder->valid();

        if ($this->anotherExistingMediaFolderWithSamePath($mediaFolder->getPath())) {
            throw new \Exception('There is already a media folder with the same path');
        }

        return Context::get('media_folder_repository')->createMediaFolder($mediaFolder);
    }

    private function anotherExistingMediaFolderWithSamePath($path)
    {
        return Context::get('media_folder_repository')->findByPath($path);
    }
}