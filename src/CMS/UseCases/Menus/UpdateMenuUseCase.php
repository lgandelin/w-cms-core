<?php

namespace CMS\UseCases\Menus;

interface UpdateMenuUseCase
{
    public function run($menuID, $menuStructure);
    public function getMenuUpdated($originalMenuStructure, $menuStructure);
    public function anotherMenuExistsWithSameIdentifier($menuID, $menuIdentifier);
}