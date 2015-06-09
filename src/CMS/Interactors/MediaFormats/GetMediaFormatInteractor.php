<?php

namespace CMS\Interactors\MediaFormats;

use CMS\Context;
use CMS\Interactors\Interactor;
use CMS\Structures\MediaFormatStructure;

class GetMediaFormatInteractor extends Interactor
{
    public function getMediaFormatByID($mediaFormatID, $structure = false)
    {
        if (!$mediaFormat = Context::getRepository('media_format')->findByID($mediaFormatID)) {
            throw new \Exception('The media format was not found');
        }

        return ($structure) ? MediaFormatStructure::toStructure($mediaFormat) : $mediaFormat;
    }
}
