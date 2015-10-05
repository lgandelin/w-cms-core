<?php

namespace Webaccess\WCMSCore\Interactors\MediaFormats;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Interactors\Interactor;

class GetMediaFormatsInteractor extends Interactor
{
    public function getAll($structure = false)
    {
        $mediaFormats = Context::get('media_format_repository')->findAll();

        return ($structure) ? $this->getDataStructures($mediaFormats) : $mediaFormats;
    }

    private function getDataStructures($mediaFormats)
    {
        return array_map(function($mediaFormat) {
            return $mediaFormat->toStructure();
        }, $mediaFormats);
    }
}
