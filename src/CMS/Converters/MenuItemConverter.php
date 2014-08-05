<?php

namespace CMS\Converters;

use CMS\Entities\MenuItem;
use CMS\Structures\MenuItemStructure;
use CMS\Structures\PageStructure;
use CMS\Repositories\PageRepositoryInterface;

class MenuItemConverter {

    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
        $this->pageConverter = new PageConverter();
    }

    public function convertMenuItemToMenuItemStructure(MenuItem $item)
    {
        return new MenuItemStructure([
            'label' => $item->getLabel(),
            'order' => $item->getOrder(),
            'page' => ($item->getPage()) ? $this->pageConverter->convertPageToPageStructure($item->getPage()) : null
        ]);
    }

    public function convertMenuItemStructureToMenuItem($itemS)
    {
        $item = new MenuItem();
        $item->setLabel($itemS->label);
        $item->setOrder($itemS->order);
        if ($itemS->page) {
            $page = $this->pageRepository->findByIdentifier($itemS->page);

            if ($page)
                $item->setPage($page);
        }

        return $item;
    }
} 