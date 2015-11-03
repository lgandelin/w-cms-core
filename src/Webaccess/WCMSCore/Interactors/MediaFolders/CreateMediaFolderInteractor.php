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
        $mediaFolder->valid();
        $mediaFolder->setPath('/' . String::getSlug($mediaFolder->getName()));

        return Context::get('media_folder_repository')->createMediaFolder($mediaFolder);
    }
} 