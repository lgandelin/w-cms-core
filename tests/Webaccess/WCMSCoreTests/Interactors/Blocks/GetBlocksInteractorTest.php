<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Area;
use Webaccess\WCMSCore\Entities\Blocks\HTMLBlock;
use Webaccess\WCMSCore\Interactors\Blocks\GetBlocksInteractor;

class GetBlocksInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new GetBlocksInteractor();
    }

    public function testGetBlocks()
    {
        $this->createSampleArea();
        $this->createSampleBlock();
        $this->createSampleBlock();

        $blocks = $this->interactor->getAllByAreaID(1);
        $this->assertEquals(2, count($blocks));

        $this->assertInstanceOf('\Webaccess\WCMSCore\Entities\Block', $blocks[0]);
    }

    public function testGetBlocksAsStructures()
    {
        $this->createSampleArea();
        $this->createSampleBlock();
        $this->createSampleBlock();

        $blocks = $this->interactor->getAllByAreaID(1, true);
        $this->assertEquals(2, count($blocks));

        $this->assertInstanceOf('\Webaccess\WCMSCore\DataStructure', $blocks[0]);
    }

    private function createSampleArea()
    {
        $area = new Area();
        $area->setID(1);
        $area->setName('Test area');
        Context::get('area')->createArea($area);
    }

    private function createSampleBlock()
    {
        $block = new HTMLBlock();
        $block->setName('Block');
        $block->setAreaID(1);
        Context::get('block')->createBlock($block);
    }
}
