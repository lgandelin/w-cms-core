<?php

use CMS\Context;
use CMS\Entities\Area;
use CMS\Interactors\Areas\GetAreaInteractor;

class GetAreaInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp()
    {
        CMSTestsSuite::clean();
        $this->interactor = new GetAreaInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testGetNonExistingArea()
    {
        $this->interactor->getAreaByID(1);
    }

    public function testGetArea()
    {
        $areaID = $this->createSampleArea();

        $this->assertInstanceOf('\CMS\Entities\Area', $this->interactor->getAreaByID($areaID));
    }

    public function testGetAreaAsStructure()
    {
        $areaID = $this->createSampleArea();

        $this->assertInstanceOf('\CMS\Structures\AreaStructure', $this->interactor->getAreaByID($areaID, true));
    }

    private function createSampleArea()
    {
        $area = new Area();

        return Context::$areaRepository->createArea($area);
    }
}
