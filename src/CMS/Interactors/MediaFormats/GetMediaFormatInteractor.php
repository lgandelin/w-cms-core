<?php

namespace CMS\Interactors\MediaFormats;

use CMS\Context;
use CMS\Interactors\Interactor;

class GetMediaFormatInteractor extends Interactor
{
    public function getMediaFormatByID($mediaFormatID, $structure = false)
    {
        if (!$mediaFormat = Context::get('media_format')->findByID($mediaFormatID)) {
            throw new \Exception('The media format was not found');
        }

        return ($structure) ? $mediaFormat->toStructure() : $mediaFormat;
    }
}
