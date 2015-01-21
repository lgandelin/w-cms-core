<?php

namespace CMS\Interactors\Medias;

use CMS\Structures\MediaStructure;

class UpdateMediaInteractor extends GetMediaInteractor
{
    public function run($mediaID, MediaStructure $mediaStructure)
    {
        if ($media = $this->getMediaByID($mediaID)) {
            if (isset($mediaStructure->name) && $mediaStructure->name !== null && $media->getName() != $mediaStructure->name) {
                $media->setName($mediaStructure->name);
            }
            if (isset($mediaStructure->path) && $mediaStructure->path !== null && $media->getPath() != $mediaStructure->path) {
                $media->setPath($mediaStructure->path);
            }

            $media->valid();


            $this->repository->updateMedia($media);
        }
    }
}
