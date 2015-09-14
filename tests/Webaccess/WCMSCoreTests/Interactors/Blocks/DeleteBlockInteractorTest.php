<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Blocks\HTMLBlock;
use Webaccess\WCMSCore\Interactors\Blocks\DeleteBlockInteractor;

class DeleteBlockInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new DeleteBlockInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteNonExistingBlock()
    {
        $this->interactor->run(1);
    }

    public function testDelete()
    {
        $blockID = $this->createSampleBlock();
        $this->assertEquals(1, sizeof(Context::get('block_repository')->findAll()));

        $this->interactor->run($blockID);

        $this->assertEquals(0, sizeof(Context::get('block_repository')->findAll()));
    }

    private function createSampleBlock()
    {
        $block = new HTMLBlock();
        $block->setName('Block');

        return Context::get('block_repository')->createBlock($block);
    }

    public function testDeleteMasterBlock()
    {
        $block = new HTMLBlock();
        $block->setName('Block');
        $block->setIsMaster(1);
        Context::get('block_repository')->createBlock($block);

        $childBlock = new HTMLBlock();
        $childBlock->setName('Child block');
        $childBlock->setMasterBlockID(1);
        Context::get('block_repository')->createBlock($childBlock);

        $this->interactor->run(1);

        $this->assertFalse(Context::get('block_repository')->findByID(2));
    }
}
