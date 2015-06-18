<?php

use CMS\Context;
use CMS\Interactors\Areas\CreateAreaInteractor;
use CMS\Interactors\Blocks\CreateBlockInteractor;
use CMS\Interactors\Pages\CreatePageFromMasterInteractor;
use CMS\Structures\DataStructure;

class CreatePageFromMasterInteractorTest extends PHPUnit_Framework_TestCase {

    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new CreatePageFromMasterInteractor();
    }

    public function testCreatePageFromMasterPage()
    {
        //Create master page
        $pageStructure = new DataStructure([
            'ID' => 1,
            'uri' => '/master',
            'identifier' => 'master',
            'name' => 'Master page',
            'isMaster' => 1
        ]);
        $this->interactor->run($pageStructure);

        $area = new DataStructure([
            'ID' => 1,
            'pageID' => 1,
            'name' => 'Test area'
        ]);
        (new CreateAreaInteractor())->run($area);

        $block = new DataStructure([
            'ID' => 1,
            'areaID' => 1,
            'name' => 'Test block',
        ]);
        (new CreateBlockInteractor())->run($block);

        //Create child page
        $pageStructureChild = new DataStructure([
            'ID' => 2,
            'uri' => '/child',
            'identifier' => 'child',
            'name' => 'Child page',
            'masterPageID' => 1
        ]);
        $this->interactor->run($pageStructureChild);

        $this->assertInstanceOf('\CMS\Entities\Area', Context::getRepository('area')->findByID(1));
        $this->assertInstanceOf('\CMS\Entities\Block', Context::getRepository('block')->findByID(2));
    }
}