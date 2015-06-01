<?php

namespace CMS\Interactors\Medias;

use CMS\Context;
use CMS\Interactors\Interactor;
use CMS\Structures\MediaStructure;

class GetMediaInteractor extends Interactor
{
    public function getMediaByID($mediaID, $structure = false)
    {
        if (!$media = Context::$mediaRepository->findByID($mediaID)) {
            throw new \Exception('The media was not found');
        }

        return ($structure) ? MediaStructure::toStructure($media) : $media;
    }
}
