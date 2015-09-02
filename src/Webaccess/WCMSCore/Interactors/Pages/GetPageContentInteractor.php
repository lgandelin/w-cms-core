<?php

namespace Webaccess\WCMSCore\Interactors\Pages;

use Webaccess\WCMSCore\Interactors\Areas\GetAreasInteractor;
use Webaccess\WCMSCore\Interactors\Blocks\GetBlocksInteractor;
use Webaccess\WCMSCore\Interactors\Langs\GetLangInteractor;

class GetPageContentInteractor
{
    public function run($uri, $structure = false)
    {
        $lang = (new GetLangInteractor())->getLangFromURI($uri, $structure);
        try {
            $page = (new GetPageInteractor())->getPageByUri($uri, ($structure ? $lang->ID : $lang->getID()), $structure);
            $areas = (new GetAreasInteractor())->getAll(($structure ? $page->ID : $page->getID()), $structure);

            if ($areas) {
                foreach ($areas as $area) {
                    $area->blocks = (new GetBlocksInteractor())->getAllByAreaID(($structure ? $area->ID : $area->getID()), $structure);
                    $page->areas[]= $area;
                }
            }
        } catch(\Exception $e) {
            $page = (new GetPageInteractor())->getPageByUri('/404', $structure);
        }

        return $page;
    }
}