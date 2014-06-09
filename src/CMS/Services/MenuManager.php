<?php

namespace CMS\Services;

class MenuManager {

    public function __construct($menuRepository = null, $pageRepository = null)
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
                    $pageS = ($item->getPage()) ? new \CMS\Structures\PageStructure([
                        'name' => $item->getPage()->getName(),
                        'uri' => $item->getPage()->getUri(),
                        'identifier' => $item->getPage()->getIdentifier()
                    ]) : null;

                    $items[]= new \CMS\Structures\MenuItemStructure([
                        'label' => $item->getLabel(),
                        'order' => $item->getOrder(),
                        'page' => $pageS
                    ]);
                }
            }
        return  new \CMS\Structures\MenuStructure([
            'identifier' => $menu->getIdentifier(),
            'items' => $items,
            'name' => $menu->getName()
        ]);
    }

    public function getAll()
    {
        return $this->menuRepository->findAll();
    }

    public function createMenu(\CMS\Structures\MenuStructure $menuStructure)
    {
        if (!$menuStructure->identifier)
            throw new \InvalidArgumentException('You must provide an identifier for a menu');

        if ($this->menuRepository->findByIdentifier($menuStructure->identifier))
            throw new \Exception('There is already a menu with the same identifier');

        $menu = new \CMS\Entities\Menu();
        $menu->setIdentifier($menuStructure->identifier);
        $menu->setName($menuStructure->name);

        if (is_array($menuStructure->items)) {
            foreach ($menuStructure->items as $itemS) {
                $item = new \CMS\Entities\MenuItem();
                $item->setLabel($itemS->label);
                $item->setOrder($itemS->order);
                if ($itemS->page) $item->setPage($itemS->page);
            }
        }

        return $this->menuRepository->createMenu($menu);
    }

    public function updateMenu(\CMS\Structures\MenuStructure $menuStructure)
    {
        if (!$menu = $this->menuRepository->findByIdentifier($menuStructure->identifier))
            throw new \Exception('The menu was not found');

        if ($menu != null && $menu->getIdentifier() != $menuStructure->identifier)
            throw new \Exception('There is already a menu with the same identifier');

        $menu->setName($menuStructure->name);

        if (is_array($menuStructure->items)) {
            $menu->deleteItems();

            foreach ($menuStructure->items as $itemS) {
                $item = new \CMS\Entities\MenuItem();
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