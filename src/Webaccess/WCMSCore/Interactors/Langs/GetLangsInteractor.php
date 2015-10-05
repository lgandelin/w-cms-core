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
        return array_map(function($lang) {
            return $lang->toStructure();
        }, $langs);
    }
}
