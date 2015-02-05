<?php

namespace CMS\Interactors\MediaFormats;

use CMS\Structures\MediaFormatStructure;

class UpdateMediaFormatInteractor extends GetMediaFormatInteractor
{
    public function run($mediaFormatID, MediaFormatStructure $mediaFormatStructure)
    {
        if ($mediaFormat = $this->getMediaFormatByID($mediaFormatID)) {
            if (isset($mediaFormatStructure->name) && $mediaFormatStructure->name !== null && $mediaFormat->getName() != $mediaFormatStructure->name) {
                $mediaFormat->setName($mediaFormatStructure->name);
            }
            if (isset($mediaFormatStructure->width) && $mediaFormatStructure->width !== null && $mediaFormat->getWidth() != $mediaFormatStructure->width) {
                $mediaFormat->setWidth($mediaFormatStructure->width);
            }
            if (isset($mediaFormatStructure->height) && $mediaFormatStructure->height !== null && $mediaFormat->getHeight() != $mediaFormatStructure->height) {
                $mediaFormat->setHeight($mediaFormatStructure->height);
            }
            $mediaFormat->valid();

            $this->repository->updateMediaFormat($mediaFormat);
        }
    }
}
