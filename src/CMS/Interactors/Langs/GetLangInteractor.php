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

    public function getLangFromURI($uri)
    {
        $langID = $this->getDefaultLangID();
        foreach ((new GetLangsInteractor())->getAll(true) as $lang) {
            if ($this->langPrefixMatchesURI($uri, $lang)) {
                $langID = $lang->ID;
            }
        }

        return LangStructure::toStructure($this->getLangByID($langID));
    }

    private function langPrefixMatchesURI($uri, $lang)
    {
        preg_match('#' . $lang->prefix . '#', $uri, $matches);

        return count($matches) > 0;
    }
}
