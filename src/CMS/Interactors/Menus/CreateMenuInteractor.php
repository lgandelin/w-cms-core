<?php

namespace CMS\Interactors\Menus;

use CMS\Converters\MenuConverter;
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
        $menu = MenuConverter::convertMenuStructureToMenu($menuStructure);

        if ($menu->valid()) {
            if ($this->anotherExistingMenuWithSameIdentifier($menu->getIdentifier()))
                throw new \Exception('There is already a menu with the same identifier');

            return $this->repository->createMenu(MenuConverter::convertMenuToMenuStructure($menu));
        }
    }

    public function anotherExistingMenuWithSameIdentifier($identifier)
    {
        return $this->repository->findByIdentifier($identifier);
    }
} 