<?php

use CMS\Context;
use CMS\Entities\Blocks\HTMLBlock;
use CMS\Interactors\Blocks\DeleteBlockInteractor;

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
        $this->assertEquals(1, sizeof(Context::get('block')->findAll()));

        $this->interactor->run($blockID);

        $this->assertEquals(0, sizeof(Context::get('block')->findAll()));
    }

    private function createSampleBlock()
    {
        $block = new HTMLBlock();
        $block->setName('Block');

        return Context::get('block')->createBlock($block);
    }

    public function testDeleteMasterBlock()
    {
        $block = new HTMLBlock();
        $block->setName('Block');
        $block->setIsMaster(1);
        Context::get('block')->createBlock($block);

        $childBlock = new HTMLBlock();
        $childBlock->setName('Child block');
        $childBlock->setMasterBlockID(1);
        Context::get('block')->createBlock($childBlock);

        $this->interactor->run(1);

        $this->assertFalse(Context::get('block')->findByID(2));
    }
}
