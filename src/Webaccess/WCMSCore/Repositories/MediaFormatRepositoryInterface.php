<?php

namespace Webaccess\WCMSCore\Repositories;

use Webaccess\WCMSCore\Entities\MediaFormat;

interface MediaFormatRepositoryInterface
{
    public function findByID($mediaFormatID);

    public function findAll();

    public function createMediaFormat(MediaFormat $mediaFormat);

    public function updateMediaFormat(MediaFormat $mediaFormat);

    public function deleteMediaFormat($mediaFormatID);
}
