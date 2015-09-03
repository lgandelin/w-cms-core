<?php

namespace Webaccess\WCMSCore\Repositories;

use Webaccess\WCMSCore\Entities\MenuItem;

interface MenuItemRepositoryInterface
{
    public function findByID($menuItemID);

    public function findByMenuID($menuID);

    public function createMenuItem(MenuItem $menuItem);

    public function updateMenuItem(MenuItem $menuItem);

    public function deleteMenuItem($menuItemID);
}
