<?php

namespace CMS\Interactors\Medias;

use CMS\Context;
use CMS\Interactors\Interactor;
use CMS\Interactors\MediaFormats\GetMediaFormatInteractor;

class GetMediaInteractor extends Interactor
{
    public function getMediaByID($mediaID, $mediaFormatID = null, $structure = false)
    {
        if (!$media = Context::get('media')->findByID($mediaID)) {
            throw new \Exception('The media was not found');
        }

        $media = ($structure) ? $media->toStructure() : $media;

        if ($mediaFormatID) {
            $mediaFormat = (new GetMediaFormatInteractor())->getMediaFormatByID($mediaFormatID, true);
            $media->fileName = $mediaFormat->width . '_' . $mediaFormat->height . '_' . $media->fileName;
            $media->width = $mediaFormat->width;
            $media->height = $mediaFormat->height;
        }

        return $media;
    }
}
