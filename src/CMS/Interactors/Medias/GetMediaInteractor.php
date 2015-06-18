<?php

namespace CMS\Interactors\Medias;

use CMS\Context;
use CMS\Interactors\Interactor;

class GetMediaInteractor extends Interactor
{
    public function getMediaByID($mediaID, $structure = false)
    {
        if (!$media = Context::getRepository('media')->findByID($mediaID)) {
            throw new \Exception('The media was not found');
        }

        return ($structure) ? $media->toStructure() : $media;
    }
}
