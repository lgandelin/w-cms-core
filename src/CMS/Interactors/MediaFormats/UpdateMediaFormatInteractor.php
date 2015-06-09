<?php

namespace CMS\Interactors\MediaFormats;

use CMS\Context;
use CMS\Structures\MediaFormatStructure;

class UpdateMediaFormatInteractor extends GetMediaFormatInteractor
{
    public function run($mediaFormatID, MediaFormatStructure $mediaFormatStructure)
    {
        if ($mediaFormat = $this->getMediaFormatByID($mediaFormatID)) {
            $mediaFormat->setInfos($mediaFormatStructure);
            $mediaFormat->valid();

            Context::getRepository('media_format')->updateMediaFormat($mediaFormat);
        }
    }
}
