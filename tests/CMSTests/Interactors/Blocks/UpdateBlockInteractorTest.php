<?php

use CMS\Context;
use CMS\Entities\Blocks\HTMLBlock;
use CMS\Interactors\Blocks\UpdateBlockInteractor;
use CMS\Structures\Blocks\HTMLBlockStructure;

class UpdateBlockInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new UpdateBlockInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateNonExistingBlock()
    {
        $blockStructure = new HTMLBlockStructure([
            'name' => 'Block'
        ]);

        $this->interactor->run(1, $blockStructure);
    }

    public function testUpdate()
    {
        $blockID = $this->createSampleBlock();

        $blockStructure = new HTMLBlockStructure([
            'name' => 'Block test updated'
        ]);

        $this->interactor->run($blockID, $blockStructure);

        $block = Context::$blockRepository->findByID($blockID);
        $this->assertEquals('Block test updated', $block->getName());
    }

    private function createSampleBlock()
    {
        $block = new HTMLBlock();
        $block->setName('Block');
        $block->setType('html');
        $block->setAreaID(null);

        return Context::$blockRepository->createBlock($block);
    }

    public function testUpdateMasterBlock()
    {
        $masterBlock = new HTMLBlock();
        $masterBlock->setID(1);
        $masterBlock->setIsMaster(true);
        $masterBlock->setName('Test block');
        $masterBlock->setAreaID(null);
        Context::$blockRepository->createBlock($masterBlock);

        $childBlock1 = new HTMLBlock();
        $childBlock1->setID(2);
        $childBlock1->setMasterBlockID($masterBlock->getID());
        $childBlock1->setName('Test block');
        $childBlock1->setAreaID(null);
        Context::$blockRepository->createBlock($childBlock1);

        $childBlock2 = new HTMLBlock();
        $childBlock2->setID(3);
        $childBlock2->setMasterBlockID($masterBlock->getID());
        $childBlock2->setName('Test block');
        $childBlock2->setAreaID(null);
        Context::$blockRepository->createBlock($childBlock2);

        $blockStructure = new HTMLBlockStructure([
            'name' => 'Test block updated'
        ]);
        $this->interactor->run($masterBlock->getID(), $blockStructure);

        $childBlock1 = Context::$blockRepository->findByID($childBlock1->getID());
        $childBlock2 = Context::$blockRepository->findByID($childBlock2->getID());

        $this->assertEquals('Test block updated', $childBlock1->getName());
        $this->assertEquals('Test block updated', $childBlock2->getName());
    }

    public function testUpdateHTMLBlock()
    {
        $block = new HTMLBlock();
        $block->setID(1);
        $block->setHTML('<h1>Hello World</h1>');
        Context::$blockRepository->createBlock($block);

        $blockStructure = new HTMLBlockStructure([
           'html' => '<h1>Goodbye World</h1>'
        ]);
        $this->interactor->run(1, $blockStructure);

        $blockUpdated = Context::$blockRepository->findByID(1);
        $this->assertEquals('<h1>Goodbye World</h1>', $blockUpdated->getHTML());
    }
}
