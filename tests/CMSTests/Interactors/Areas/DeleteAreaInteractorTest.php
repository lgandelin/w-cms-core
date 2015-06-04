<?php

use CMS\Context;
use CMS\Entities\Area;
use CMS\Interactors\Areas\DeleteAreaInteractor;

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
        $this->assertEquals(1, sizeof(Context::$areaRepository->findAll()));

        $this->interactor->run($areaID);

        $this->assertEquals(0, sizeof(Context::$areaRepository->findAll()));
    }

    private function createSampleArea()
    {
        $area = new Area();
        $area->setName('Test area');

        return Context::$areaRepository->createArea($area);
    }

    public function testDeleteMasterArea()
    {
        $area = new Area();
        $area->setID(2);
        $area->setName('Area');
        $area->setIsMaster(1);
        Context::$areaRepository->createArea($area);

        $childArea = new Area();
        $childArea->setID(2);
        $childArea->setName('Child area');
        $childArea->setMasterAreaID(1);
        Context::$areaRepository->createArea($childArea);

        $this->interactor->run(1);

        $this->assertFalse(Context::$areaRepository->findByID(2));
    }
}