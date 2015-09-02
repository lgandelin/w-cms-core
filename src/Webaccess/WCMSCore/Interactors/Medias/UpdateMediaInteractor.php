<?php

namespace Webaccess\WCMSCore\Interactors\Medias;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;

class UpdateMediaInteractor extends GetMediaInteractor
{
    public function run($mediaID, DataStructure $mediaStructure)
    {
        if ($media = $this->getMediaByID($mediaID)) {
            $media->setInfos($mediaStructure);
            $media->valid();

            Context::get('media')->updateMedia($media);
        }
    }
}
