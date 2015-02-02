<?php

use CMS\Entities\Blocks\HTMLBlock;
use CMS\Structures\Blocks\HTMLBlockStructure;
use CMS\Structures\BlockStructure;

class BlockStructureTest extends PHPUnit_Framework_TestCase
{
    public function testToStructure()
    {
        $block = new HTMLBlock();
        $block->setID(1);
        $block->setType('html');
        $block->setHTML('<h1>Hello world</h1>');

        $blockStructure = new HTMLBlockStructure([
            'ID' => 1,
            'type' => 'html',
            'html' => '<h1>Hello world</h1>'
        ]);

        $this->assertEquals($blockStructure, BlockStructure::toStructure($block));
    }
} 