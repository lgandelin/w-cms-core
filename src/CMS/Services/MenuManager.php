<?php

namespace CMS\Services;

use CMS\Entities\Menu;
use CMS\Entities\MenuItem;
use CMS\Structures\PageStructure;
use CMS\Structures\MenuStructure;
use CMS\Structures\MenuItemStructure;
use CMS\Repositories\MenuRepositoryInterface;
use CMS\Repositories\PageRepositoryInterface;

class MenuManager {

    public function __construct(MenuRepositoryInterface $menuRepository, PageRepositoryInterface $pageRepository)
    {
        $this->menuRepository = $menuRepository;
        $this->pageRepository = $pageRepository;
    }

    public function getByIdentifier($identifier)
    {
        $menu = $this->menuRepository->findByIdentifier($identifier);

        if (!$menu)
            throw new \Exception('The menu was not found');

        $items = [];
        if (is_array($menu->getItems())) {
            foreach ($menu->getItems() as $item) {
                $pageS = ($item->getPage()) ? new PageStructure([
                    'name' => $item->getPage()->getName(),
                    'uri' => $item->getPage()->getUri(),
                    'identifier' => $item->getPage()->getIdentifier()
                ]) : null;

                $items[]= new MenuItemStructure([
                    'label' => $item->getLabel(),
                    'order' => $item->getOrder(),
                    'page' => $pageS
                ]);
            }
        }
            
        return new MenuStructure([
            'identifier' => $menu->getIdentifier(),
            'items' => $items,
            'name' => $menu->getName()
        ]);
    }

    public function getAll()
    {
        return $this->menuRepository->findAll();
    }

    public function createMenu(MenuStructure $menuStructure)
    {
        if (!$menuStructure->identifier)
            throw new \InvalidArgumentException('You must provide an identifier for a menu');

        if ($this->menuRepository->findByIdentifier($menuStructure->identifier))
            throw new \Exception('There is already a menu with the same identifier');

        $menu = new Menu();
        $menu->setIdentifier($menuStructure->identifier);
        $menu->setName($menuStructure->name);

        if (is_array($menuStructure->items)) {
            foreach ($menuStructure->items as $itemS) {
                $item = new MenuItem();
                $item->setLabel($itemS->label);
                $item->setOrder($itemS->order);
                if ($itemS->page) $item->setPage($itemS->page);
            }
        }

        return $this->menuRepository->createMenu($menu);
    }

    public function updateMenu(MenuStructure $menuStructure)
    {
        if (!$menu = $this->menuRepository->findByIdentifier($menuStructure->identifier))
            throw new \Exception('The menu was not found');

        if ($menu != null && $menu->getIdentifier() != $menuStructure->identifier)
            throw new \Exception('There is already a menu with the same identifier');

        $menu->setName($menuStructure->name);

        if (is_array($menuStructure->items)) {
            $menu->deleteItems();

            foreach ($menuStructure->items as $itemS) {
                $item = new MenuItem();
                $item->setLabel($itemS->label);
                $item->setOrder($itemS->order);
                if ($itemS->page) {
                    try {
                        $page = $this->pageRepository->findByIdentifier($itemS->page);
                        $item->setPage($page);
                    } catch (\Exception $e) {

                    }

                }
                $menu->addItem($item);
            }
        }

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