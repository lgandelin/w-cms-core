<?php

namespace CMS\Interactors\Menus;

use CMS\Repositories\MenuRepositoryInterface;
use CMS\Structures\MenuStructure;

class GetMenusInteractor
{
    private $repository;

    public function __construct(MenuRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function getAll($structure = false)
    {
        $menus = $this->repository->findAll();

        return ($structure) ? $this->getMenuStructures($menus) : $menus;
    }

    private function getMenuStructures($menus)
    {
        $menuStructures = [];
        if (is_array($menus) && sizeof($menus) > 0) {
            foreach ($menus as $menu) {
                $menuStructures[] = MenuStructure::toStructure($menu);
            }
        }

        return $menuStructures;
    }
}
