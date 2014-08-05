<?php

namespace CMS\UseCases\Menus;

use CMS\Structures\MenuStructure;

interface CreateMenuUseCase
{
    public function run(MenuStructure $menuStructure);
    public function anotherExistingMenuWithSameIdentifier($identifier);
}