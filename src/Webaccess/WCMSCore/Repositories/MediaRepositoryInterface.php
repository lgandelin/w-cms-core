<?php

namespace Webaccess\WCMSCore\Repositories;

use Webaccess\WCMSCore\Entities\Media;

interface MediaRepositoryInterface
{
    public function findByID($mediaID);

    public function findAllByMediaFolderID($mediaFolderID);

    public function findAll();

    public function createMedia(Media $media);

    public function updateMedia(Media $media);

    public function deleteMedia($mediaID);
}
