<?php

namespace CMS\Interactors\MediaFormats;

use CMS\Context;
use CMS\Interactors\Interactor;
use CMS\Structures\MediaFormatStructure;

class GetMediaFormatsInteractor extends Interactor
{
    public function getAll($structure = false)
    {
        $mediaFormats = Context::getRepository('media_format')->findAll();

        return ($structure) ? $this->getMediaFormatStructures($mediaFormats) : $mediaFormats;
    }

    private function getMediaFormatStructures($mediaFormats)
    {
        $mediaFormatStructures = [];
        if (is_array($mediaFormats) && sizeof($mediaFormats) > 0) {
            foreach ($mediaFormats as $mediaFormat) {
                $mediaFormatStructures[] = MediaFormatStructure::toStructure($mediaFormat);
            }
        }

        return $mediaFormatStructures;
    }
}
