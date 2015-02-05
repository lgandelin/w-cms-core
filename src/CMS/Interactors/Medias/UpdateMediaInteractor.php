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
            if (isset($mediaStructure->file_name) && $mediaStructure->file_name !== null && $media->getFileName() != $mediaStructure->file_name) {
                $media->setFileName($mediaStructure->file_name);
            }
            if (isset($mediaStructure->alt) && $mediaStructure->alt !== null && $media->getAlt() != $mediaStructure->alt) {
                $media->setAlt($mediaStructure->alt);
            }
            if (isset($mediaStructure->title) && $mediaStructure->title !== null && $media->getTitle() != $mediaStructure->title) {
                $media->setTitle($mediaStructure->title);
            }
            $media->valid();

            $this->repository->updateMedia($media);
        }
    }
}
