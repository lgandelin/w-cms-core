<?php

namespace CMS\Interactors\Langs;

use CMS\Context;
use CMS\Entities\Lang;
use CMS\Structures\LangStructure;

class CreateLangInteractor
{
    public function run(LangStructure $langStructure)
    {
        $lang = new Lang();
        $lang->setInfos($langStructure);
        $lang->valid();

        return Context::getRepository('lang')->createLang($lang);
    }
}
