<?php

use CMS\Context;
use CMS\Entities\Blocks\HTMLBlock;
use CMS\Interactors\Blocks\GetBlockInteractor;

class GetBlockInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new GetBlockInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testGetNonExistingBlock()
    {
        $this->interactor->getBlockByID(1);
    }

    public function testGetBlock()
    {
        $blockID = $this->createSampleBlock();

        $this->assertInstanceOf('\CMS\Entities\Block', $this->interactor->getBlockByID($blockID));
    }

    public function testGetBlockAsStructure()
    {
        $blockID = $this->createSampleBlock();

        $this->assertInstanceOf('\CMS\DataStructure', $this->interactor->getBlockByID($blockID, true));
    }

    private function createSampleBlock()
    {
        $block = new HTMLBlock();

        return Context::get('block')->createBlock($block);
    }
}
