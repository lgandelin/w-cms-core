<?php

namespace CMS\Interactors\Langs;

use CMS\Context;
use CMS\Structures\LangStructure;

class GetLangInteractor
{
    public function getLangByID($langID, $structure = false)
    {
        if (!$lang = Context::$langRepository->findByID($langID)) {
            throw new \Exception('The lang was not found');
        }

        return  ($structure) ? LangStructure::toStructure($lang) : $lang;
    }

    public function getDefaultLangID()
    {
        return Context::$langRepository->findDefautLangID();
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
