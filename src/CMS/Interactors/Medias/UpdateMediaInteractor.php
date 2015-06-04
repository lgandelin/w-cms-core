<?php

namespace CMS\Interactors\Medias;

use CMS\Context;
use CMS\Structures\MediaStructure;

class UpdateMediaInteractor extends GetMediaInteractor
{
    public function run($mediaID, MediaStructure $mediaStructure)
    {
        if ($media = $this->getMediaByID($mediaID)) {
            $media->setInfos($mediaStructure);
            $media->valid();

            Context::$mediaRepository->updateMedia($media);
        }
    }
}
