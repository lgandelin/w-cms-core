<?php

namespace Webaccess\WCMSCore\Fixtures;

use Webaccess\WCMSCore\Entities\BlockType;
use Webaccess\WCMSCore\Context;

class BlockTypesFixtures {

    public static function run()
    {
        $blockTypes = [
            ['code' => 'html', 'name' => 'Block HTML', 'back_controller' => null, 'back_view' => 'w-cms-laravel::back.editorial.pages.blocks.html', 'front_view' => 'blocks.standard.html', 'order' => 1],
            ['code' => 'menu', 'name' => 'Block Menu', 'back_controller' => 'Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial\Blocks\MenuBlockFormController', 'back_view' => null, 'front_view' => 'blocks.standard.menu', 'order' => 2],
            ['code' => 'article', 'name' => 'Block Article', 'back_controller' => 'Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial\Blocks\ArticleBlockFormController', 'back_view' => null, 'front_view' => 'blocks.standard.article', 'order' => 3],
            ['code' => 'article_list', 'name' => 'Block Article list', 'back_controller' => 'Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial\Blocks\ArticleListBlockFormController', 'back_view' => null, 'front_view' => 'blocks.standard.article_list', 'order' => 4],
            ['code' => 'media', 'name' => 'Block Media', 'back_controller' => 'Webaccess\WCMSLaravel\Http\Controllers\Back\Editorial\Blocks\MediaBlockFormController', 'back_view' => null, 'front_view' => 'blocks.standard.media', 'order' => 5],
            ['code' => 'view', 'name' => 'Block View', 'back_controller' => null, 'back_view' => 'w-cms-laravel::back.editorial.pages.blocks.view', 'front_view' => 'blocks.standard.view', 'order' => 6],
            ['code' => 'controller', 'name' => 'Block Controller', 'back_controller' => null, 'back_view' => 'w-cms-laravel::back.editorial.pages.blocks.controller', 'front_view' => 'blocks.standard.controller', 'order' => 7],
        ];

        foreach ($blockTypes as $type) {
            self::addBlockType($type['code'], $type['name'], $type['back_controller'], $type['back_view'], $type['front_view'], $type['order']);
        }
    }
    
    public static function addBlockType($code, $name, $back_controller, $back_view, $front_view, $order)
    {
        $blockType = new BlockType();
        $blockType->setCode($code);
        $blockType->setName($name);
        $blockType->setBackController($back_controller);
        $blockType->setBackView($back_view);
        $blockType->setFrontView($front_view);
        $blockType->setOrder($order);
        
        Context::get('block_type_repository')->createBlockType($blockType);
    }
}