<?php

namespace CMS\Interactors\Langs;

use CMS\Context;
use CMS\Structures\LangStructure;

class UpdateLangInteractor extends GetLangInteractor
{
    public function run($langID, LangStructure $langStructure)
    {
        if ($lang = $this->getLangByID($langID)) {
            $lang->setInfos($langStructure);
            $lang->valid();

            Context::$langRepository->updateLang($lang);
        }
    }
}
