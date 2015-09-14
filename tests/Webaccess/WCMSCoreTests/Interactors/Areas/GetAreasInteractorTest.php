<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Area;
use Webaccess\WCMSCore\Entities\Page;
use Webaccess\WCMSCore\Interactors\Areas\GetAreasInteractor;

class GetAreasInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp()
    {
        CMSTestsSuite::clean();
        $this->interactor = new GetAreasInteractor();
    }

    public function testGetAllAreas()
    {
        $this->createSamplePage();
        $this->createSampleArea();
        $this->createSampleArea();

        $areas = $this->interactor->getAll(1);
        $this->assertEquals(2, count($areas));
        $this->assertInstanceOf('\Webaccess\WCMSCore\Entities\Area', $areas[0]);
    }

    public function testGetAllAreasAsStructures()
    {
        $this->createSamplePage();
        $this->createSampleArea();
        $this->createSampleArea();

        $areas = $this->interactor->getAll(1, true);
        $this->assertEquals(2, count($areas));
        $this->assertInstanceOf('\Webaccess\WCMSCore\DataStructure', $areas[0]);
    }

    private function createSamplePage()
    {
        $page = new Page();
        $page->setID(1);
        $page->setName('Test page');
        Context::get('page_repository')->createPage($page);
    }

    private function createSampleArea()
    {
        $area = new Area();
        $area->setPageID(1);
        Context::get('area_repository')->createArea($area);
    }
}
