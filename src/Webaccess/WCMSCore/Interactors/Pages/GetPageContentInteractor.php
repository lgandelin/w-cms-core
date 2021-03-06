<?php

namespace Webaccess\WCMSCore\Interactors\Pages;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Interactors\Areas\GetAreasInteractor;
use Webaccess\WCMSCore\Interactors\Blocks\GetBlocksInteractor;
use Webaccess\WCMSCore\Interactors\Langs\GetLangInteractor;

class GetPageContentInteractor
{
    public function run($uri, $versionID = false, $structure = false)
    {
        $lang = (new GetLangInteractor())->getLangFromURI($uri, $structure);
        try {
            $page = (new GetPageInteractor())->getPageByUri($uri, ($structure ? $lang->ID : $lang->getID()), $structure);
            $versionID = ($versionID) ? $versionID : $page->versionID;
            $version = Context::get('version_repository')->findByID($versionID);

            if ($version && $page->is_visible !== false) {
                $areas = (new GetAreasInteractor())->getByPageIDAndVersionNumber(($structure ? $page->ID : $page->getID()), $version->getNumber(), $structure);

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
                $page =  $this->run('/404', false, $structure);
            }
        } catch(\Exception $e) {
            $page =  $this->run('/404', false, $structure);
        }

        return $page;
    }
}
