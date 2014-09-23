<?php

namespace CMS\UseCases\Menus;

interface DuplicateMenuUseCase extends GetMenuUseCase
{
    public function run($menuID);
}