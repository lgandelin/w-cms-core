<?php

use CMS\Interactors\Blocks\UpdateBlockInteractor;
use CMS\Repositories\InMemory\InMemoryBlockRepository;
use CMS\Structures\BlockStructure;

class UpdateBlockInteractorTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->repository = new InMemoryBlockRepository();
        $this->interactor = new UpdateBlockInteractor($this->repository);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('\CMS\Interactors\Blocks\UpdateBlockInteractor', $this->interactor);
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateNonExistingBlock()
    {
        $blockStructure = new BlockStructure([
            'ID' => 1,
            'name' => 'Block'
        ]);

        $this->interactor->run(1, $blockStructure);
    }

    public function testUpdate()
    {
        $blockStructure = new BlockStructure([
            'ID' => 1,
            'name' => 'Block',
            'type' => 'html',
            'html' => '<h1>Hello</h1>'
        ]);

        $this->repository->createBlock($blockStructure);

        $blockStructure = new BlockStructure([
            'html' => '<h1>Hello World</h1>'
        ]);

        $this->interactor->run(1, $blockStructure);

        $block = $this->repository->findByID(1);
        $this->assertEquals('<h1>Hello World</h1>', $block->getHTML());
    }
}
 