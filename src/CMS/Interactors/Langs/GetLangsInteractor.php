<?php

namespace CMS\Interactors\Langs;

use CMS\Context;

class GetLangsInteractor
{
    public function getAll($structure = false)
    {
        $langs = Context::getRepository('lang')->findAll();

        return ($structure) ? $this->getDataStructures($langs) : $langs;
    }

    private function getDataStructures($langs)
    {
        $langStructures = [];
        if (is_array($langs) && sizeof($langs) > 0) {
            foreach ($langs as $lang) {
                $langStructures[] = $lang->toStructure();
            }
        }

        return $langStructures;
    }
}
