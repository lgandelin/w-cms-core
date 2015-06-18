<?php

use CMS\Context;
use CMS\Entities\Area;
use CMS\Entities\Blocks\HTMLBlock;
use CMS\Interactors\Blocks\DuplicateBlockInteractor;

class DuplicateBlockInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new DuplicateBlockInteractor();
    }

    public function testDuplicateHTMLBlock()
    {
        /*$area = new Area();
        $area->setID(1);
        Context::getRepository('area')->createArea($area);

        $block = new HTMLBlock();
        $block->setName('HTML Block');
        $block->setHTML('<h1>Hello World</h1>');
        Context::getRepository('block')->createBlock($block);

        $this->interactor->run($block->toStructure(), 1);

        $duplicatedBlock = Context::getRepository('block')->findByID(2);

        $this->assertEquals(1, count($duplicatedBlock));
        $this->assertEquals('<h1>Hello World</h1>', $duplicatedBlock->getHTML());*/
    }
}