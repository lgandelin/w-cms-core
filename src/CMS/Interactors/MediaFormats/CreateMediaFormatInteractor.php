<?php

namespace CMS\Interactors\MediaFormats;

use CMS\Context;
use CMS\Entities\MediaFormat;
use CMS\Interactors\Interactor;
use CMS\Structures\DataStructure;

class CreateMediaFormatInteractor extends Interactor
{
    public function run(DataStructure $mediaFormatStructure)
    {
        $mediaFormat = new MediaFormat();
        $mediaFormat->setInfos($mediaFormatStructure);
        $mediaFormat->valid();

        return Context::getRepository('media_format')->createMediaFormat($mediaFormat);
    }
}
