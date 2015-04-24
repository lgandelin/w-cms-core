<?php

namespace CMS\Repositories;

use CMS\Entities\Media;

interface MediaRepositoryInterface
{
    public function findByID($mediaID);

    public function findAll();

    public function createMedia(Media $media);

    public function updateMedia(Media $media);

    public function deleteMedia($mediaID);
}
