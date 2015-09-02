<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Area;
use Webaccess\WCMSCore\Entities\Blocks\HTMLBlock;
use Webaccess\WCMSCore\Interactors\Blocks\DuplicateBlockInteractor;

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
        Context::get('area')->createArea($area);

        $block = new HTMLBlock();
        $block->setName('HTML Block');
        $block->setHTML('<h1>Hello World</h1>');
        Context::get('block')->createBlock($block);

        $this->interactor->run($block->toStructure(), 1);

        $duplicatedBlock = Context::get('block')->findByID(2);

        $this->assertEquals(1, count($duplicatedBlock));
        $this->assertEquals('<h1>Hello World</h1>', $duplicatedBlock->getHTML());*/
    }
}