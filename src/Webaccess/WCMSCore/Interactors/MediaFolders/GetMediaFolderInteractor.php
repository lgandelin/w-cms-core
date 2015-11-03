<?php

namespace Webaccess\WCMSCore\Interactors\MediaFolders;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Interactors\Interactor;

class GetMediaFolderInteractor extends Interactor
{
    public function getMediaFolderByID($mediaFolderID, $structure = false)
    {
        if (!$mediaFolder = Context::get('media_folder_repository')->findByID($mediaFolderID)) {
            throw new \Exception('The media folder was not found');
        }

        return ($structure) ? $mediaFolder->toStructure() : $mediaFolder;
    }

    public static function getParentMediaFolderPath($mediaFolder)
    {
        if ($parentMediaFolder = Context::get('media_folder_repository')->findByID($mediaFolder->getParentID())) {
            return $parentMediaFolder->getPath();
        }

        return '';
    }
}
