<?php

namespace Webaccess\WCMSCore\Fixtures;

use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Interactors\BlockTypes\CreateBlockTypeInteractor;

class BlockTypesFixtures {

    public static function run()
    {
        $blockTypes = [
            ['code' => 'html', 'name' => 'Block HTML', 'entity' => 'Webaccess\WCMSCore\Entities\Blocks\HTMLBlock', 'back_controller' => null, 'back_view' => 'w-cms-laravel::back.editorial.pages.blocks.html', 'front_controller' => null, 'front_view' => 'blocks.standard.html', 'order' => 1],
            ['code' => 'menu', 'name' => 'Block Menu', 'entity' => 'Webaccess\WCMSCore\Entities\Blocks\MenuBlock', 'back_controller' => 'Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial\Blocks\MenuBlockController', 'back_view' => null, 'front_controller' => 'Webaccess\WCMSLaravel\Http\Controllers\Front\Blocks\MenuBlockController', 'front_view' => null, 'order' => 2],
            ['code' => 'article', 'name' => 'Block Article', 'entity' => 'Webaccess\WCMSCore\Entities\Blocks\ArticleBlock', 'back_controller' => 'Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial\Blocks\ArticleBlockController', 'back_view' => null, 'front_controller' => 'Webaccess\WCMSLaravel\Http\Controllers\Front\Blocks\ArticleBlockController', 'front_view' => null, 'order' => 3],
            ['code' => 'article_list', 'name' => 'Block Article list', 'entity' => 'Webaccess\WCMSCore\Entities\Blocks\ArticleListBlock', 'back_controller' => 'Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial\Blocks\ArticleListBlockController', 'back_view' => null, 'front_controller' => 'Webaccess\WCMSLaravel\Http\Controllers\Front\Blocks\ArticleListBlockController', 'front_view' => null, 'order' => 4],
            ['code' => 'media', 'name' => 'Block Media', 'entity' => 'Webaccess\WCMSCore\Entities\Blocks\MediaBlock', 'back_controller' => 'Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial\Blocks\MediaBlockController', 'back_view' => null, 'front_controller' => 'Webaccess\WCMSLaravel\Http\Controllers\Front\Blocks\MediaBlockController', 'front_view' => null, 'order' => 5],
            ['code' => 'view', 'name' => 'Block View', 'entity' => 'Webaccess\WCMSCore\Entities\Blocks\ViewBlock', 'back_controller' => null, 'back_view' => 'w-cms-laravel::back.editorial.pages.blocks.view', 'front_controller' => null, 'front_view' => 'blocks.standard.view', 'order' => 6],
            ['code' => 'controller', 'name' => 'Block Controller', 'entity' => 'Webaccess\WCMSCore\Entities\Blocks\ControllerBlock', 'back_controller' => null, 'back_view' => 'w-cms-laravel::back.editorial.pages.blocks.controller', 'front_controller' => 'Webaccess\WCMSLaravel\Http\Controllers\Front\Blocks\ControllerBlockController', 'front_view' => null, 'order' => 7],
        ];

        foreach ($blockTypes as $type) {
            $blockTypeStructure = new DataStructure();
            $blockTypeStructure->code = $type['code'];
            $blockTypeStructure->name = $type['name'];
            $blockTypeStructure->entity = $type['entity'];
            $blockTypeStructure->back_controller = $type['back_controller'];
            $blockTypeStructure->back_view = $type['back_view'];
            $blockTypeStructure->front_controller = $type['front_controller'];
            $blockTypeStructure->front_view = $type['front_view'];
            $blockTypeStructure->order = $type['order'];

            (new CreateBlockTypeInteractor())->run($blockTypeStructure);
        }
    }
}