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

            if ($page->is_visible !== false) {
                $areas = (new GetAreasInteractor())->getAll(($structure ? $page->ID : $page->getID()), $structure);

                if ($areas) {
                    foreach ($areas as $area) {
                        $blocks = (new GetBlocksInteractor())->getAllByAreaID(($structure ? $area->ID : $area->getID()), $structure);
                        foreach ($blocks as $block) {
                            if (isset($block->type->front_controller) && $block->type->front_controller) {
                                $block->front_content = (new $block->type->front_controller)->index($block);
                            }
                        }
                        $area->blocks = $blocks;

                        $page->areas[]= $area;
                    }
                }
            } else {
                $page =  $this->run('/404', $structure);
            }
        } catch(\Exception $e) {
            $page =  $this->run('/404', $structure);
        }

        return $page;
    }
}
