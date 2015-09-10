<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Interactors\Areas\CreateAreaInteractor;
use Webaccess\WCMSCore\Interactors\Blocks\CreateBlockInteractor;
use Webaccess\WCMSCore\Interactors\Pages\CreatePageFromMasterInteractor;
use Webaccess\WCMSCore\DataStructure;

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

        //$this->assertInstanceOf('\Webaccess\WCMSCore\Entities\Area', Context::get('area_repository')->findByID(1));
        //$this->assertInstanceOf('\Webaccess\WCMSCore\Entities\Block', Context::get('block_repository')->findByID(2));
    }
}