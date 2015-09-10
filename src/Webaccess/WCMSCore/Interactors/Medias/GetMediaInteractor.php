<?php

namespace Webaccess\WCMSCore\Interactors\Medias;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Interactors\Interactor;
use Webaccess\WCMSCore\Interactors\MediaFormats\GetMediaFormatInteractor;

class GetMediaInteractor extends Interactor
{
    public function getMediaByID($mediaID, $mediaFormatID = null, $structure = false)
    {
        if (!$media = Context::get('media_repository')->findByID($mediaID)) {
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
