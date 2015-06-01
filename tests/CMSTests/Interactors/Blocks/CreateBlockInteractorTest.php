<?php

use CMS\Context;
use CMS\Entities\Area;
use CMS\Interactors\Blocks\CreateBlockInteractor;
use CMS\Structures\Blocks\HTMLBlockStructure;

class CreateBlockInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;
    
    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new CreateBlockInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testCreateInvalidBlock()
    {
        $block = new HTMLBlockStructure([]);

        $this->interactor->run($block);
    }

    public function testCreate()
    {
        $area = new Area();
        $area->setID(1);
        $area->setName('Area');
        Context::$areaRepository->createArea($area);

        $block = new HTMLBlockStructure([
            'ID' => 1,
            'name' => 'Test block',
            'area_id' => 1
        ]);
        $this->interactor->run($block);

        $this->assertEquals(1, count(Context::$blockRepository->findAll()));
        $this->assertEquals(1, count(Context::$blockRepository->findByAreaID(1)));
    }

    public function testCreateBlockInMasterPage()
    {
        $area = new Area();
        $area->setID(1);
        $area->setName('Master area');
        $area->setIsMaster(1);
        Context::$areaRepository->createArea($area);

        $childArea = new Area();
        $childArea->setID(2);
        $childArea->setName('Child area');
        $childArea->setMasterAreaID(1);
        Context::$areaRepository->createArea($childArea);

        $block = new HTMLBlockStructure([
            'name' => 'Test block',
            'area_id' => 2,
            'is_master' => 1
        ]);
        $this->interactor->run($block);

        $this->assertEquals(1, count(Context::$blockRepository->findByAreaID(2)));
    }
}
