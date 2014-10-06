<?php

namespace CMS\Repositories;

use CMS\Entities\Menu;
use CMS\Structures\MenuItemStructure;

interface MenuRepositoryInterface
{
    public function findByID($menuID);

    public function findByIdentifier($menuIdentifier);

    public function findAll();

    public function createMenu(Menu $menu);

    public function updateMenu(Menu $menu);

    public function deleteMenu($menuID);

    public function findItemByID($menuID, $menuItemID);

    public function addItem($menuID, MenuItemStructure $menuItemStructure);

    public function deleteItem($menuID, $menuItemID);

    public function updateItem($menuID, $menuItemID, MenuItemStructure $menuItemStructure);
}