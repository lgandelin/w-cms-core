<?php

namespace CMS\Interactors\Langs;

use CMS\Context;
use CMS\Structures\LangStructure;

class GetLangsInteractor
{
    public function getAll($structure = false)
    {
        $langs = Context::$langRepository->findAll();

        return ($structure) ? $this->getLangStructures($langs) : $langs;
    }

    private function getLangStructures($langs)
    {
        $langStructures = [];
        if (is_array($langs) && sizeof($langs) > 0) {
            foreach ($langs as $lang) {
                $langStructures[] = LangStructure::toStructure($lang);
            }
        }

        return $langStructures;
    }
}
