<?php

namespace CMS\Interactors\Langs;

use CMS\Context;

class GetLangInteractor
{
    public function getLangByID($langID, $structure = false)
    {
        if (!$lang = Context::get('lang')->findByID($langID)) {
            throw new \Exception('The lang was not found');
        }

        return  ($structure) ? $lang->toStructure() : $lang;
    }

    public function getDefaultLangID()
    {
        return Context::get('lang')->findDefautLangID();
    }

    public function getLangFromURI($uri, $structure = false)
    {
        $langID = $this->getDefaultLangID();
        foreach ((new GetLangsInteractor())->getAll($structure) as $lang) {
            if ($this->langPrefixMatchesURI($uri, $lang, $structure)) {
                $langID = ($structure ? $lang->ID : $lang->getID());
            }
        }

        return $this->getLangByID($langID, $structure);
    }

    private function langPrefixMatchesURI($uri, $lang, $structure = false)
    {
        preg_match('#' . ($structure ? $lang->prefix : $lang->getPrefix()). '#', $uri, $matches);

        return count($matches) > 0;
    }
}
