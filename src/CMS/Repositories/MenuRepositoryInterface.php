<?php

namespace CMS\Repositories;

use CMS\Structures\MenuItemStructure;
use CMS\Structures\MenuStructure;

interface MenuRepositoryInterface {

    public function findByID($menuID);
    public function findByIdentifier($menuIdentifier);
    public function findAll();
    public function createMenu(MenuStructure $menu);
    public function updateMenu($menuID, MenuStructure $menuStructure);
    public function deleteMenu($menuID);
    public function findItemByID($menuID, $menuItemID);
    public function addItem($menuID, MenuItemStructure $menuItemStructure);
    public function deleteItem($menuID, $menuItemID);
    public function updateItem($menuID, $menuItemID, MenuItemStructure $menuItemStructure);

}