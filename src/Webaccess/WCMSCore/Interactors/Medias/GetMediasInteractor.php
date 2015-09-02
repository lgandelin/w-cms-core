<?php

namespace Webaccess\WCMSCore\Interactors\Medias;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Interactors\Interactor;

class GetMediasInteractor extends Interactor
{
    public function getAll($structure = false)
    {
        $medias = Context::get('media')->findAll();

        return ($structure) ? $this->getDataStructures($medias) : $medias;
    }

    private function getDataStructures($medias)
    {
        $mediaStructures = [];
        if (is_array($medias) && sizeof($medias) > 0) {
            foreach ($medias as $media) {
                $mediaStructures[] = $media->toStructure();
            }
        }

        return $mediaStructures;
    }
}
