<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Area;
use Webaccess\WCMSCore\Interactors\Areas\DeleteAreaInteractor;

class DeleteAreaInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp()
    {
        CMSTestsSuite::clean();
        $this->interactor = new DeleteAreaInteractor();
    }

    public function testDelete()
    {
        $areaID = $this->createSampleArea();
        $this->assertEquals(1, sizeof(Context::get('area_repository')->findAll()));

        $this->interactor->run($areaID);

        $this->assertEquals(0, sizeof(Context::get('area_repository')->findAll()));
    }

    private function createSampleArea()
    {
        $area = new Area();
        $area->setName('Test area');

        return Context::get('area_repository')->createArea($area);
    }

    public function testDeleteMasterArea()
    {
        $area = new Area();
        $area->setID(2);
        $area->setName('Area');
        $area->setIsMaster(1);
        Context::get('area_repository')->createArea($area);

        $childArea = new Area();
        $childArea->setID(2);
        $childArea->setName('Child area');
        $childArea->setMasterAreaID(1);
        Context::get('area_repository')->createArea($childArea);

        $this->interactor->run(1);

        $this->assertFalse(Context::get('area_repository')->findByID(2));
    }
}