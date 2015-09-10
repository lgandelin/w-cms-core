<?php

namespace Webaccess\WCMSCore\Interactors\Langs;

use Webaccess\WCMSCore\Context;

class GetLangsInteractor
{
    public function getAll($structure = false)
    {
        $langs = Context::get('lang_repository')->findAll();

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
