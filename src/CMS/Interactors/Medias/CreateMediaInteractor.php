<?php

namespace CMS\Interactors\Medias;

use CMS\Context;
use CMS\Entities\Media;
use CMS\Interactors\Interactor;
use CMS\Structures\DataStructure;

class CreateMediaInteractor extends Interactor
{
    public function run(DataStructure $mediaStructure)
    {
        $media = new Media();
        $media->setInfos($mediaStructure);
        $media->valid();

        return Context::getRepository('media')->createMedia($media);
    }
}
