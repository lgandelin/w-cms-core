<?php

namespace CMS\Interactors\Medias;

use CMS\Context;
use CMS\DataStructure;

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
