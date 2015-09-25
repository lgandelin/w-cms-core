<?php

namespace Webaccess\WCMSCore\Interactors\MediaFormats;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\MediaFormat;
use Webaccess\WCMSCore\Interactors\Interactor;
use Webaccess\WCMSCore\DataStructure;

class CreateMediaFormatInteractor extends Interactor
{
    public function run(DataStructure $mediaFormatStructure)
    {
        $mediaFormat = (new MediaFormat())->setInfos($mediaFormatStructure);
        $mediaFormat->valid();

        return Context::get('media_format_repository')->createMediaFormat($mediaFormat);
    }
}
