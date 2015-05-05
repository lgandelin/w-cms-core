<?php

namespace CMS\Interactors\Langs;

use CMS\Repositories\LangRepositoryInterface;
use CMS\Structures\LangStructure;

class GetLangInteractor
{
    protected $repository;
    private $getLangsInteractor;

    public function __construct(LangRepositoryInterface $repository, GetLangsInteractor $getLangsInteractor)
    {
        $this->repository = $repository;
        $this->getLangsInteractor = $getLangsInteractor;
    }

    public function getLangByID($langID, $structure = false)
    {
        if (!$lang = $this->repository->findByID($langID)) {
            throw new \Exception('The lang was not found');
        }

        return  ($structure) ? LangStructure::toStructure($lang) : $lang;
    }

    public function getDefaultLangID()
    {
        return $this->repository->findDefautLangID();
    }

    public function getLangFromURI($uri)
    {
        $langID = $this->getDefaultLangID();
        foreach ($this->getLangsInteractor->getAll(true) as $lang) {
            if (preg_match('#' . $lang->prefix . '#', $uri, $matches)) {
                if (count($matches) > 0) {
                    $langID = $lang->ID;
                }
            }
        }

        return LangStructure::toStructure($this->getLangByID($langID));
    }
}
