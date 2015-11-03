<?php

namespace Webaccess\WCMSCore\Interactors\Medias;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Interactors\Interactor;

class GetMediasInteractor extends Interactor
{
    public function getAll($structure = false)
    {
        $medias = Context::get('media_repository')->findAll();

        return ($structure) ? $this->getDataStructures($medias) : $medias;
    }

    public function getAllByMediaFolder($mediaFolderID, $structure = false)
    {
        $medias = Context::get('media_repository')->findAllByMediaFolderID($mediaFolderID);

        return ($structure) ? $this->getDataStructures($medias) : $medias;
    }

    private function getDataStructures($medias)
    {
        return array_map(function($media) {
            return $media->toStructure();
        }, $medias);
    }
}
