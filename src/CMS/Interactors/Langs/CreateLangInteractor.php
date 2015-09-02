<?php

namespace CMS\Interactors\Langs;

use CMS\Context;
use CMS\Entities\Lang;
use CMS\DataStructure;

class CreateLangInteractor
{
    public function run(DataStructure $langStructure)
    {
        $lang = new Lang();
        $lang->setInfos($langStructure);
        $lang->valid();

        return Context::get('lang')->createLang($lang);
    }
}