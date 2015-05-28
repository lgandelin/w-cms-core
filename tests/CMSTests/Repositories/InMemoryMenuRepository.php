<?php

namespace CMSTests\Repositories;

use CMS\Entities\Menu;
use CMS\Repositories\MenuRepositoryInterface;

class InMemoryMenuRepository implements MenuRepositoryInterface
{
    private $menus;

    public function __construct()
    {
        $this->menus = [];
    }

    public function findByID($menuID)
    {
        foreach ($this->menus as $menu) {
            if ($menu->getID() == $menuID) {
                return $menu;
            }
        }

        return false;
    }

    public function findByIdentifier($menuIdentifier)
    {
        foreach ($this->menus as $menu) {
            if ($menu->getIdentifier() == $menuIdentifier) {
                return $menu;
            }
        }

        return false;
    }

    public function findAll($langID = null)
    {
        return $this->menus;
    }

    public function createMenu(Menu $menu)
    {
        $this->menus[]= $menu;
    }

    public function updateMenu(Menu $menu)
    {
        foreach ($this->menus as $menuModel) {
            if ($menuModel->getID() == $menu->getID()) {
                $menuModel->setName($menu->getName());
                $menuModel->setIdentifier($menu->getIdentifier());
            }
        }
    }

    public function deleteMenu($menuID)
    {
        foreach ($this->menus as $i => $menu) {
            if ($menu->getID() == $menuID) {
                unset($this->menus[$i]);
            }
        }
    }
}
