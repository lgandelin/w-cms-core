<?php

namespace Webaccess\WCMSCore\Interactors\MediaFolders;

use Webaccess\WCMSCore\Context;

class DeleteMediaFolderInteractor extends GetMediaFolderInteractor
{
    public function run($mediaFormatID)
    {
        if ($this->getMediaFolderByID($mediaFormatID)) {
            Context::get('media_folder_repository')->deleteMediaFolder($mediaFormatID);
        }
    }
} 