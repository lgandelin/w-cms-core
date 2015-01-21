<?php

namespace CMS\Interactors\Medias;

class DeleteMediaInteractor extends GetMediaInteractor
{
    public function run($mediaID)
    {
        if ($this->getMediaByID($mediaID)) {
            $this->repository->deleteMedia($mediaID);
        }
    }
}
