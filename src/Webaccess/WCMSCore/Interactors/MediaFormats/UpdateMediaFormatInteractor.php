<?php

namespace Webaccess\WCMSCore\Interactors\MediaFormats;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;

class UpdateMediaFormatInteractor extends GetMediaFormatInteractor
{
    public function run($mediaFormatID, DataStructure $mediaFormatStructure)
    {
        if ($mediaFormat = $this->getMediaFormatByID($mediaFormatID)) {
            $mediaFormat->setInfos($mediaFormatStructure);
            $mediaFormat->valid();

            Context::get('media_format_repository')->updateMediaFormat($mediaFormat);
        }
    }
}
