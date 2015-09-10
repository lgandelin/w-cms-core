<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Area;
use Webaccess\WCMSCore\Interactors\Blocks\CreateBlockInteractor;
use Webaccess\WCMSCore\DataStructure;

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
        Context::get('area_repository')->createArea($area);

        $block = new DataStructure([
            'ID' => 1,
            'name' => 'Test block',
            'area_id' => 1,
        ]);
        $this->interactor->run($block);

        $this->assertEquals(1, count(Context::get('block_repository')->findAll()));
        $this->assertEquals(1, count(Context::get('block_repository')->findByAreaID(1)));
    }

    public function testCreateBlockInMasterPage()
    {
        $area = new Area();
        $area->setID(1);
        $area->setName('Master area');
        $area->setIsMaster(1);
        Context::get('area_repository')->createArea($area);

        $childArea = new Area();
        $childArea->setID(2);
        $childArea->setName('Child area');
        $childArea->setMasterAreaID(1);
        Context::get('area_repository')->createArea($childArea);

        $block = new DataStructure([
            'name' => 'Test block',
            'area_id' => 2,
            'is_master' => 1
        ]);
        $this->interactor->run($block);

        $this->assertEquals(1, count(Context::get('block_repository')->findByAreaID(2)));
    }
}
