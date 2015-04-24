<?php

namespace CMS\Interactors\Medias;

use CMS\Structures\MediaStructure;

class UpdateMediaInteractor extends GetMediaInteractor
{
    public function run($mediaID, MediaStructure $mediaStructure)
    {
        if ($media = $this->getMediaByID($mediaID)) {
            $properties = get_object_vars($mediaStructure);
            unset ($properties['ID']);
            foreach ($properties as $property => $value) {
                $method = ucfirst(str_replace('_', '', $property));
                $setter = 'set' . $method;

                if ($mediaStructure->$property !== null) {
                    call_user_func_array(array($media, $setter), array($value));
                }
            }

            $media->valid();

            $this->repository->updateMedia($media);
        }
    }
}
