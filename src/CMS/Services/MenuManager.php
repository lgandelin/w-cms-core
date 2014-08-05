<?php

namespace CMS\Services;

use CMS\Converters\MenuConverter;
use CMS\Structures\MenuStructure;
use CMS\Repositories\MenuRepositoryInterface;
use CMS\Repositories\PageRepositoryInterface;

class MenuManager {

    public function __construct(MenuRepositoryInterface $menuRepository, PageRepositoryInterface $pageRepository)
    {
        $this->menuRepository = $menuRepository;
        $this->pageRepository = $pageRepository;
        $this->menuConverter = new MenuConverter($pageRepository);
    }

    public function getByIdentifier($identifier)
    {
        if (!$menu = $this->menuRepository->findByIdentifier($identifier))
            throw new \Exception('The menu was not found');

        return $this->menuConverter->convertMenuToMenuStructure($menu);
    }

    public function getAll()
    {
        $menus = $this->menuRepository->findAll();

        $menusS = [];
        if (is_array($menus) && sizeof($menus) > 0) {
            foreach ($menus as $i => $menu) {
                $menusS[]= $this->menuConverter->convertMenuToMenuStructure($menu);
            }

            return $menusS;
        }

        return false;
    }

    public function createMenu(MenuStructure $menuStructure)
    {
        if (!$menuStructure->identifier)
            throw new \InvalidArgumentException('You must provide an identifier for a menu');

        if ($this->menuRepository->findByIdentifier($menuStructure->identifier))
            throw new \Exception('There is already a menu with the same identifier');

        $menu = $this->menuConverter->convertMenuStructureToMenu($menuStructure);

        return $this->menuRepository->createMenu($menu);
    }

    public function updateMenu(MenuStructure $menuStructure)
    {
        if (!$menu = $this->menuRepository->findByIdentifier($menuStructure->identifier))
            throw new \Exception('The menu was not found');

        if ($menu != null && $menu->getIdentifier() != $menuStructure->identifier)
            throw new \Exception('There is already a menu with the same identifier');

        $menu = $this->menuConverter->convertMenuStructureToMenu($menuStructure);

        return $this->menuRepository->updateMenu($menu);
    }

    public function deleteMenu($identifier)
    {
        if (!$menu = $this->menuRepository->findByIdentifier($identifier))
            throw new \Exception('The menu was not found');

        return $this->menuRepository->deleteMenu($menu);
    }

    public function duplicateMenu($identifier)
    {
        if (!$menu = $this->menuRepository->findByIdentifier($identifier))
            throw new \Exception('The menu was not found');

        $menuS = $this->getByIdentifier($identifier);
        $menuS->name .= ' COPY';
        $menuS->identifier .= '-copy';

        return $this->createMenu($menuS);
    }
} 