<?php

namespace CMS\Repositories;

use CMS\Entities\MediaFormat;

interface MediaFormatRepositoryInterface
{
    public function findByID($mediaFormatID);

    public function findAll();

    public function createMediaFormat(MediaFormat $mediaFormat);

    public function updateMediaFormat(MediaFormat $mediaFormat);

    public function deleteMediaFormat($mediaFormatID);
} 