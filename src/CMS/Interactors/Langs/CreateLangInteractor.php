<?php

namespace CMS\Interactors\Langs;

use CMS\Context;
use CMS\Entities\Lang;
use CMS\Structures\LangStructure;

class CreateLangInteractor
{
    public function run(LangStructure $langStructure)
    {
        $lang = $this->createLangFromStructure($langStructure);

        $lang->valid();

        return Context::$langRepository->createLang($lang);
    }

    private function createLangFromStructure(LangStructure $langStructure)
    {
        $lang = new Lang();
        $lang->setName($langStructure->name);
        $lang->setPrefix($langStructure->prefix);
        $lang->setCode($langStructure->code);
        $lang->setIsDefault($langStructure->is_default);

        return $lang;
    }
}
