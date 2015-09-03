<?php

namespace Webaccess\WCMSCore\Fixtures;

use Webaccess\WCMSCore\Entities\BlockType;
use Webaccess\WCMSCore\Context;

class BlockTypesFixtures {

    public static function run()
    {
        $blockTypes = [
            ['code' => 'html', 'name' => 'Block HTML', 'content_view' => 'w-cms-laravel::back.editorial.pages.blocks.html', 'front_view' => 'blocks.standard.html', 'order' => 1],
            ['code' => 'menu', 'name' => 'Block Menu', 'content_view' => 'w-cms-laravel::back.editorial.pages.blocks.menu', 'front_view' => 'blocks.standard.menu', 'order' => 2],
            ['code' => 'article', 'name' => 'Block Article', 'content_view' => 'w-cms-laravel::back.editorial.pages.blocks.article', 'front_view' => 'blocks.standard.article', 'order' => 3],
            ['code' => 'article_list', 'name' => 'Block Article list', 'content_view' => 'w-cms-laravel::back.editorial.pages.blocks.article_list', 'front_view' => 'blocks.standard.article_list', 'order' => 4],
            ['code' => 'media', 'name' => 'Block Media', 'content_view' => 'w-cms-laravel::back.editorial.pages.blocks.media', 'front_view' => 'blocks.standard.media', 'order' => 5],
            ['code' => 'view', 'name' => 'Block View', 'content_view' => 'w-cms-laravel::back.editorial.pages.blocks.view', 'front_view' => 'blocks.standard.view', 'order' => 6],
        ];

        foreach ($blockTypes as $type) {
            $blockType = new BlockType();
            $blockType->setCode($type['code']);
            $blockType->setName($type['name']);
            $blockType->setContentView($type['content_view']);
            $blockType->setFrontView($type['front_view']);
            $blockType->setOrder($type['order']);

            Context::get('block_type')->createBlockType($blockType);
        }
    }
}