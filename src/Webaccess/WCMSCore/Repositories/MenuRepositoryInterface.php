<?php

namespace Webaccess\WCMSCore\Repositories;

use Webaccess\WCMSCore\Entities\Menu;

interface MenuRepositoryInterface
{
    public function findByID($menuID);

    public function findByIdentifier($menuIdentifier);

    public function findAll($langID = null);

    public function createMenu(Menu $menu);

    public function updateMenu(Menu $menu);

    public function deleteMenu($menuID);
}
