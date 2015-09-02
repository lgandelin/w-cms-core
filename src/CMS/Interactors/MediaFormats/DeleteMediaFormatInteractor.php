<?php

namespace CMS\Interactors\MediaFormats;

use CMS\Context;

class DeleteMediaFormatInteractor extends GetMediaFormatInteractor
{
    public function run($mediaFormatID)
    {
        if ($this->getMediaFormatByID($mediaFormatID)) {
            Context::get('media_format')->deleteMediaFormat($mediaFormatID);
        }
    }
}