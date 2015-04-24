<?php

namespace CMS\Interactors\MediaFormats;

use CMS\Structures\MediaFormatStructure;

class UpdateMediaFormatInteractor extends GetMediaFormatInteractor
{
    public function run($mediaFormatID, MediaFormatStructure $mediaFormatStructure)
    {
        if ($mediaFormat = $this->getMediaFormatByID($mediaFormatID)) {

            $properties = get_object_vars($mediaFormatStructure);
            unset ($properties['ID']);
            foreach ($properties as $property => $value) {
                $method = ucfirst(str_replace('_', '', $property));
                $setter = 'set' . $method;

                if ($mediaFormatStructure->$property !== null) {
                    call_user_func_array(array($mediaFormat, $setter), array($value));
                }
            }

            $mediaFormat->valid();

            $this->repository->updateMediaFormat($mediaFormat);
        }
    }
}
