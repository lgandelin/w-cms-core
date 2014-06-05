<?php

namespace CMS\Repositories;

interface MenuRepositoryInterface {

    public function findByIdentifier($identifier);
    public function findAll();
    public function createMenu(\CMS\Entities\Menu $menu);
    public function updateMenu(\CMS\Entities\Menu $menu);
    public function deleteMenu(\CMS\Entities\Menu $menu);
}