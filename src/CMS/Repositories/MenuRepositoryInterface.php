<?php

namespace CMS\Repositories;

use CMS\Entities\Menu;

interface MenuRepositoryInterface
{
    public function findByID($menuID);

    public function findByIdentifier($menuIdentifier);

    public function findAll();

    public function createMenu(Menu $menu);

    public function updateMenu(Menu $menu);

    public function deleteMenu($menuID);
}
