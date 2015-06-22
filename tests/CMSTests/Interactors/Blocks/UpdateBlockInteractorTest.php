<?php

use CMS\Context;
use CMS\Entities\Blocks\HTMLBlock;
use CMS\Interactors\Blocks\UpdateBlockInteractor;
use CMS\DataStructure;

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
        $blockStructure = new DataStructure([
            'name' => 'Block'
        ]);

        $this->interactor->run(1, $blockStructure);
    }

    public function testUpdate()
    {
        $blockID = $this->createSampleBlock();

        $blockStructure = new DataStructure([
            'name' => 'Block test updated'
        ]);

        $this->interactor->run($blockID, $blockStructure);

        $block = Context::getRepository('block')->findByID($blockID);
        $this->assertEquals('Block test updated', $block->getName());
    }

    private function createSampleBlock()
    {
        $block = new HTMLBlock();
        $block->setName('Block');
        $block->setType('html');
        $block->setAreaID(null);

        return Context::getRepository('block')->createBlock($block);
    }

    public function testUpdateMasterBlock()
    {
        $masterBlock = new HTMLBlock();
        $masterBlock->setIsMaster(true);
        $masterBlock->setName('Test block');
        $masterBlock->setAreaID(null);
        Context::getRepository('block')->createBlock($masterBlock);

        $childBlock1 = new HTMLBlock();
        $childBlock1->setMasterBlockID($masterBlock->getID());
        $childBlock1->setName('Test block');
        $childBlock1->setAreaID(null);
        Context::getRepository('block')->createBlock($childBlock1);

        $childBlock2 = new HTMLBlock();
        $childBlock2->setMasterBlockID($masterBlock->getID());
        $childBlock2->setName('Test block');
        $childBlock2->setAreaID(null);
        Context::getRepository('block')->createBlock($childBlock2);

        $blockStructure = new DataStructure([
            'name' => 'Test block updated'
        ]);
        $this->interactor->run($masterBlock->getID(), $blockStructure);

        $childBlock1 = Context::getRepository('block')->findByID($childBlock1->getID());
        $childBlock2 = Context::getRepository('block')->findByID($childBlock2->getID());

        $this->assertEquals('Test block updated', $childBlock1->getName());
        $this->assertEquals('Test block updated', $childBlock2->getName());
    }

    public function testUpdateHTMLBlock()
    {
        $block = new HTMLBlock();
        $block->setHTML('<h1>Hello World</h1>');
        $blockID = Context::getRepository('block')->createBlock($block);

        $blockStructure = new DataStructure([
           'html' => '<h1>Goodbye World</h1>'
        ]);
        $this->interactor->run($blockID, $blockStructure);

        $blockUpdated = Context::getRepository('block')->findByID($blockID);
        $this->assertEquals('<h1>Goodbye World</h1>', $blockUpdated->getHTML());
    }
}
