<?php

namespace CMS\Interactors\MediaFormats;

class DeleteMediaFormatInteractor extends GetMediaFormatInteractor
{
    public function run($mediaFormatID)
    {
        if ($this->getMediaFormatByID($mediaFormatID)) {
            $this->repository->deleteMediaFormat($mediaFormatID);
        }
    }
}
