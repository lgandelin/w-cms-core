<?php

namespace CMS\Interactors\Langs;

use CMS\Entities\Lang;
use CMS\Repositories\LangRepositoryInterface;
use CMS\Structures\LangStructure;

class CreateLangInteractor
{
    private $repository;

    public function __construct(LangRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run(LangStructure $langStructure)
    {
        $lang = $this->createLangFromStructure($langStructure);

        $lang->valid();

        return $this->repository->createLang($lang);
    }

    private function createLangFromStructure(LangStructure $langStructure)
    {
        $lang = new Lang();
        $lang->setName($langStructure->name);
        $lang->setPrefix($langStructure->prefix);
        $lang->setCode($langStructure->code);
        $lang->setIsDefault($langStructure->is_default);

        return $lang;
    }
}
