<?php

namespace CMS\Interactors\MediaFormats;

use CMS\Context;
use CMS\Structures\DataStructure;

class UpdateMediaFormatInteractor extends GetMediaFormatInteractor
{
    public function run($mediaFormatID, DataStructure $mediaFormatStructure)
    {
        if ($mediaFormat = $this->getMediaFormatByID($mediaFormatID)) {
            $mediaFormat->setInfos($mediaFormatStructure);
            $mediaFormat->valid();

            Context::getRepository('media_format')->updateMediaFormat($mediaFormat);
        }
    }
}
