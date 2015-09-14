<?php

namespace Webaccess\WCMSCore\Interactors\Medias;

use Webaccess\WCMSCore\Context;

class DeleteMediaInteractor extends GetMediaInteractor
{
    public function run($mediaID)
    {
        if ($this->getMediaByID($mediaID)) {
            Context::get('media_repository')->deleteMedia($mediaID);
        }
    }
}
