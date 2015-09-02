<?php

namespace CMS\Interactors\MediaFormats;

use CMS\Context;
use CMS\DataStructure;

class UpdateMediaFormatInteractor extends GetMediaFormatInteractor
{
    public function run($mediaFormatID, DataStructure $mediaFormatStructure)
    {
        if ($mediaFormat = $this->getMediaFormatByID($mediaFormatID)) {
            $mediaFormat->setInfos($mediaFormatStructure);
            $mediaFormat->valid();

            Context::get('media_format')->updateMediaFormat($mediaFormat);
        }
    }
}