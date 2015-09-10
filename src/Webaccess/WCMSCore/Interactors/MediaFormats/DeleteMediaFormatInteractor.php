<?php

namespace Webaccess\WCMSCore\Interactors\MediaFormats;

use Webaccess\WCMSCore\Context;

class DeleteMediaFormatInteractor extends GetMediaFormatInteractor
{
    public function run($mediaFormatID)
    {
        if ($this->getMediaFormatByID($mediaFormatID)) {
            Context::get('media_format_repository')->deleteMediaFormat($mediaFormatID);
        }
    }
}
