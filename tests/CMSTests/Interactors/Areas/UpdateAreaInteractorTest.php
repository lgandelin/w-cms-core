<?php

use CMS\Context;
use CMS\Entities\Area;
use CMS\Interactors\Areas\UpdateAreaInteractor;
use CMS\Structures\AreaStructure;

class UpdateAreaInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp()
    {
        CMSTestsSuite::clean();
        $this->interactor = new UpdateAreaInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateNonExistingArea()
    {
        $this->interactor->run(1, new AreaStructure());
    }

    public function testUpdateArea()
    {
        $areaID = $this->createSampleArea();

        $this->interactor->run($areaID, new AreaStructure([
            'name' => 'Test area updated'
        ]));

        $areaUpdated = Context::getRepository('area')->findByID($areaID);
        $this->assertEquals('Test area updated', $areaUpdated->getName());
    }

    private function createSampleArea()
    {
        $area = new Area();
        $area->setName('Test area');

        return Context::getRepository('area')->createArea($area);
    }

    public function testUpdateMasterArea()
    {
        $masterArea = new Area();
        $masterArea->setID(1);
        $masterArea->setIsMaster(true);
        $masterArea->setName('Test area');
        Context::getRepository('area')->createArea($masterArea);

        $childArea1 = new Area();
        $childArea1->setID(2);
        $childArea1->setMasterAreaID($masterArea->getID());
        $childArea1->setName('Test area');
        Context::getRepository('area')->createArea($childArea1);

        $childArea2 = new Area();
        $childArea2->setID(3);
        $childArea2->setMasterAreaID($masterArea->getID());
        $childArea2->setName('Test area');
        Context::getRepository('area')->createArea($childArea2);

        $areaStructure = new AreaStructure([
            'name' => 'Test area updated'
        ]);
        $this->interactor->run($masterArea->getID(), $areaStructure);

        $childArea1 = Context::getRepository('area')->findByID($childArea1->getID());
        $childArea2 = Context::getRepository('area')->findByID($childArea2->getID());

        $this->assertEquals('Test area updated', $childArea1->getName());
        $this->assertEquals('Test area updated', $childArea2->getName());
    }
}
