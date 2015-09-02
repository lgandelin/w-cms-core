<?php

namespace CMS\Interactors\Medias;

use CMS\Context;

class DeleteMediaInteractor extends GetMediaInteractor
{
    public function run($mediaID)
    {
        if ($this->getMediaByID($mediaID)) {
            Context::get('media')->deleteMedia($mediaID);
        }
    }
}