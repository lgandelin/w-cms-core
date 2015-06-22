<?php

namespace CMS\Interactors\MediaFormats;

use CMS\Context;
use CMS\Interactors\Interactor;

class GetMediaFormatsInteractor extends Interactor
{
    public function getAll($structure = false)
    {
        $mediaFormats = Context::getRepository('media_format')->findAll();

        return ($structure) ? $this->getDataStructures($mediaFormats) : $mediaFormats;
    }

    private function getDataStructures($mediaFormats)
    {
        $mediaFormatStructures = [];
        if (is_array($mediaFormats) && sizeof($mediaFormats) > 0) {
            foreach ($mediaFormats as $mediaFormat) {
                $mediaFormatStructures[] = $mediaFormat->toStructure();
            }
        }

        return $mediaFormatStructures;
    }
}
