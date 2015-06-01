<?php

namespace CMS\Interactors\Medias;

use CMS\Context;
use CMS\Interactors\Interactor;
use CMS\Structures\MediaStructure;

class GetMediasInteractor extends Interactor
{
    public function getAll($structure = false)
    {
        $medias = Context::$mediaRepository->findAll();

        return ($structure) ? $this->getMediaStructures($medias) : $medias;
    }

    private function getMediaStructures($medias)
    {
        $mediaStructures = [];
        if (is_array($medias) && sizeof($medias) > 0) {
            foreach ($medias as $media) {
                $mediaStructures[] = MediaStructure::toStructure($media);
            }
        }

        return $mediaStructures;
    }
}
