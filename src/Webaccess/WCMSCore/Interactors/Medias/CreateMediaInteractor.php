<?php

namespace Webaccess\WCMSCore\Interactors\Medias;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Media;
use Webaccess\WCMSCore\Interactors\Interactor;
use Webaccess\WCMSCore\DataStructure;

class CreateMediaInteractor extends Interactor
{
    public function run(DataStructure $mediaStructure)
    {
        $media = new Media();
        $media->setInfos($mediaStructure);
        $media->valid();

        return Context::get('media_repository')->createMedia($media);
    }
}
