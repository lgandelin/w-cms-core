<?php

namespace Webaccess\WCMSCoreTests\Repositories;

use Webaccess\WCMSCore\Entities\Menu;
use Webaccess\WCMSCore\Repositories\MenuRepositoryInterface;

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
        $menuID = sizeof($this->menus) + 1;
        $menu->setID($menuID);
        $this->menus[]= $menu;

        return $menuID;
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
