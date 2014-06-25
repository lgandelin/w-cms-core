<?php

namespace CMS\Repositories;

use CMS\Entities\Menu;

interface MenuRepositoryInterface {

    public function findByIdentifier($identifier);
    public function findAll();
    public function createMenu(Menu $menu);
    public function updateMenu(Menu $menu);
    public function deleteMenu(Menu $menu);
    
}