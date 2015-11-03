<?php

namespace Webaccess\WCMSCore\Repositories;

use Webaccess\WCMSCore\Entities\MediaFolder;

interface MediaFolderRepositoryInterface
{
    public function findByID($mediaFolderID);

    public function findAll();

    public function createMediaFolder(MediaFolder $mediaFolder);

    public function updateMediaFolder(MediaFolder $mediaFolder);

    public function deleteMediaFolder($mediaFolderID);
}
