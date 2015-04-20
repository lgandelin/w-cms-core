<?php

namespace CMS\Interactors\Langs;

use CMS\Repositories\LangRepositoryInterface;
use CMS\Structures\LangStructure;

class GetLangInteractor
{
    protected $repository;

    public function __construct(LangRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getLangByID($langID, $structure = false)
    {
        if (!$lang = $this->repository->findByID($langID)) {
            throw new \Exception('The lang was not found');
        }

        return  ($structure) ? LangStructure::toStructure($lang) : $lang;
    }
}
