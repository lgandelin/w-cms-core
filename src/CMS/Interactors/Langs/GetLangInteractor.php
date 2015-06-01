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
            if (preg_match('#' . $lang->prefix . '#', $uri, $matches)) {
                if (count($matches) > 0) {
                    $langID = $lang->ID;
                }
            }
        }

        return LangStructure::toStructure($this->getLangByID($langID));
    }
}
