<?php

namespace CMS\Interactors\Langs;

use CMS\Context;
use CMS\DataStructure;

class UpdateLangInteractor extends GetLangInteractor
{
    public function run($langID, DataStructure $langStructure)
    {
        if ($lang = $this->getLangByID($langID)) {
            $lang->setInfos($langStructure);
            $lang->valid();

            Context::getRepository('lang')->updateLang($lang);
        }
    }
}
