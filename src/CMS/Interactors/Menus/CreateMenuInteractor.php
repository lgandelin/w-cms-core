<?php

namespace CMS\Interactors\Menus;

use CMS\Entities\Menu;
use CMS\Repositories\MenuRepositoryInterface;
use CMS\Structures\MenuStructure;

class CreateMenuInteractor
{
    private $repository;

    public function __construct(MenuRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run(MenuStructure $menuStructure)
    {
        $menu = $this->createMenuFromStructure($menuStructure);

        $menu->valid();

        if ($this->anotherExistingMenuWithSameIdentifier($menu->getIdentifier())) {
            throw new \Exception('There is already a menu with the same identifier');
        }

        return $this->repository->createMenu($menu);
    }

    private function anotherExistingMenuWithSameIdentifier($identifier)
    {
        return $this->repository->findByIdentifier($identifier);
    }

    private function createMenuFromStructure(MenuStructure $menuStructure)
    {
        $menu = new Menu();
        $menu->setIdentifier($menuStructure->identifier);
        $menu->setName($menuStructure->name);

        return $menu;
    }
}
