<?php

namespace CMS\Interactors\Pages;

use CMS\Interactors\Areas\GetAreasInteractor;
use CMS\Interactors\Blocks\GetBlocksInteractor;
use CMS\Interactors\Langs\GetLangInteractor;

class GetPageContentInteractor
{
    public function run($uri, $structure = false)
    {
        $lang = (new GetLangInteractor())->getLangFromURI($uri);

        try {
            $page = (new GetPageInteractor())->getPageByUri($uri, $lang->ID, $structure);
            $areas = (new GetAreasInteractor())->getAll($page->getID(), $structure);

            if ($areas) {
                foreach ($areas as $area) {
                    $area->blocks = (new GetBlocksInteractor())->getAllByAreaID($area->getID(), $structure);
                    $page->areas[]= $area;
                }
            }

        } catch(\Exception $e) {
            $page = (new GetPageInteractor())->getPageByUri('/404', true);
        }

        return $page;
    }
} 