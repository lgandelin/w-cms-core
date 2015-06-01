<?php

namespace CMS\Interactors\Langs;

use CMS\Context;
use CMS\Structures\LangStructure;

class UpdateLangInteractor extends GetLangInteractor
{
    public function run($langID, LangStructure $langStructure)
    {
        if ($lang = $this->getLangByID($langID)) {

            $properties = get_object_vars($langStructure);
            unset ($properties['ID']);
            foreach ($properties as $property => $value) {
                $method = ucfirst(str_replace('_', '', $property));
                $setter = 'set' . $method;

                if ($langStructure->$property !== null) {
                    call_user_func_array(array($lang, $setter), array($value));
                }
            }

            $lang->valid();

            Context::$langRepository->updateLang($lang);
        }
    }
}
