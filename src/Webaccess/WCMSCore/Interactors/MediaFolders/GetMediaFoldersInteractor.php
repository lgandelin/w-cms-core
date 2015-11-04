<?php

namespace Webaccess\WCMSCore\Interactors\MediaFolders;

use Webaccess\WCMSCore\Context;

class GetMediaFoldersInteractor
{
    public function getAll($structure = false)
    {
        $mediaFolder = Context::get('media_folder_repository')->findAll();

        return ($structure) ? $this->getMediaFolderStructures($mediaFolder) : $mediaFolder;
    }

    private function getMediaFolderStructures($mediaFolder)
    {
        return array_map(function($mediaFolderItem) {
            return $mediaFolderItem->toStructure();
        }, $mediaFolder);
    }
} 