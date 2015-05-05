<?php

namespace CMS\Interactors\Pages;

use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\Blocks\GetBlockContentInteractor;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Interactors\Langs\GetLangInteractor;

class GetPageContentInteractor
{
    private $getLangInteractor;
    private $getPageInteractor;
    private $getAreasInteractor;
    private $getBlocksInteractor;
    private $getBlockContentInteractor;

    public function __construct(
        GetLangInteractor $getLangInteractor,
        GetPageInteractor $getPageInteractor,
        GetAreasInteractor $getAreasInteractor,
        GetBlocksInteractor $getBlocksInteractor,
        GetBlockContentInteractor $getBlockContentInteractor
    )
    {
        $this->getLangInteractor = $getLangInteractor;
        $this->getPageInteractor = $getPageInteractor;
        $this->getAreasInteractor = $getAreasInteractor;
        $this->getBlocksInteractor = $getBlocksInteractor;
        $this->getBlockContentInteractor = $getBlockContentInteractor;
    }
    public function run($uri)
    {
        $lang = $this->getLangInteractor->getLangFromURI($uri);

        try {
            $page = $this->getPageInteractor->getPageByUri($uri, $lang->ID, true);
            $areas = $this->getAreasInteractor->getAll($page->ID, true);

            if ($areas) {
                foreach ($areas as $area) {
                    $blocks = $this->getBlocksInteractor->getAllByAreaID($area->ID, true);
                    foreach ($blocks as $block) {
                        $area->blocks[]= $this->getBlockContentInteractor->run($block);
                    }
                    $page->areas[]= $area;
                }
            }

        } catch(\Exception $e) {
            $page = $this->getPageInteractor->getPageByUri('/404', true);
        }

        return $page;
    }
} 