<?php

namespace CMS\Interactors\Langs;

use CMS\Repositories\LangRepositoryInterface;
use CMS\Structures\LangStructure;

class GetLangsInteractor
{
    private $repository;

    public function __construct(LangRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll($structure = false)
    {
        $langs = $this->repository->findAll();

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
