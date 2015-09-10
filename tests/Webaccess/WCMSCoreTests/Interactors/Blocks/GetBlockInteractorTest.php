<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Blocks\HTMLBlock;
use Webaccess\WCMSCore\Interactors\Blocks\GetBlockInteractor;

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

        $this->assertInstanceOf('\Webaccess\WCMSCore\Entities\Block', $this->interactor->getBlockByID($blockID));
    }

    public function testGetBlockAsStructure()
    {
        $blockID = $this->createSampleBlock();

        $this->assertInstanceOf('\Webaccess\WCMSCore\DataStructure', $this->interactor->getBlockByID($blockID, true));
    }

    private function createSampleBlock()
    {
        $block = new HTMLBlock();

        return Context::get('block_repository')->createBlock($block);
    }
}
