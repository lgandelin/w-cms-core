<?php

use CMS\Context;
use CMS\Entities\Area;
use CMS\Interactors\Blocks\CreateBlockInteractor;
use CMS\DataStructure;

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
        $block = new DataStructure([]);

        $this->interactor->run($block);
    }

    public function testCreate()
    {
        $area = new Area();
        $area->setID(1);
        $area->setName('Area');
        Context::getRepository('area')->createArea($area);

        $block = new DataStructure([
            'ID' => 1,
            'name' => 'Test block',
            'area_id' => 1,
        ]);
        $this->interactor->run($block);

        $this->assertEquals(1, count(Context::getRepository('block')->findAll()));
        $this->assertEquals(1, count(Context::getRepository('block')->findByAreaID(1)));
    }

    public function testCreateBlockInMasterPage()
    {
        $area = new Area();
        $area->setID(1);
        $area->setName('Master area');
        $area->setIsMaster(1);
        Context::getRepository('area')->createArea($area);

        $childArea = new Area();
        $childArea->setID(2);
        $childArea->setName('Child area');
        $childArea->setMasterAreaID(1);
        Context::getRepository('area')->createArea($childArea);

        $block = new DataStructure([
            'name' => 'Test block',
            'area_id' => 2,
            'is_master' => 1
        ]);
        $this->interactor->run($block);

        $this->assertEquals(1, count(Context::getRepository('block')->findByAreaID(2)));
    }
}
