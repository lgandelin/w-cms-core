<?php

namespace CMS\Interactors\Menus;

use CMS\Interactors\MenuItems\DeleteMenuItemInteractor;
use CMS\Interactors\MenuItems\GetMenuItemsInteractor;
use CMS\Repositories\MenuRepositoryInterface;

class DeleteMenuInteractor extends GetMenuInteractor
{
    protected $repository;
    private $getMenuItemsInteractor;
    private $deleteMenuItemInteractor;

    public function __construct(
        MenuRepositoryInterface $repository,
        GetMenuItemsInteractor $getMenuItemsInteractor,
        DeleteMenuItemInteractor $deleteMenuItemInteractor
    ) {
        $this->repository = $repository;
        $this->getMenuItemsInteractor = $getMenuItemsInteractor;
        $this->deleteMenuItemInteractor = $deleteMenuItemInteractor;
    }

    public function run($menuID)
    {
        if ($this->getMenuByID($menuID)) {
            $this->deleteMenuItems($menuID);
            $this->repository->deleteMenu($menuID);
        }
    }

    private function deleteMenuItems($menuID)
    {
        $menuItems = $this->getMenuItemsInteractor->getAll($menuID);

        foreach ($menuItems as $menuItem) {
            $this->deleteMenuItemInteractor->run($menuItem->getID());
        }
    }
}
