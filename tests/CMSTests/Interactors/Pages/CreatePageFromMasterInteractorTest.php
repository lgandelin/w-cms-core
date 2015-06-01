<?php

use CMS\Context;
use CMS\Interactors\Areas\CreateAreaInteractor;
use CMS\Interactors\Blocks\CreateBlockInteractor;
use CMS\Interactors\Pages\CreatePageFromMasterInteractor;
use CMS\Structures\Blocks\HTMLBlockStructure;
use CMS\Structures\AreaStructure;
use CMS\Structures\PageStructure;

class CreatePageFromMasterInteractorTest extends PHPUnit_Framework_TestCase {

    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new CreatePageFromMasterInteractor();
    }

    public function testCreatePageFromMasterPage()
    {
        //Create master page
        $pageStructure = new PageStructure([
            'ID' => 1,
            'uri' => '/master',
            'identifier' => 'master',
            'name' => 'Master page',
            'is_master' => 1
        ]);
        $this->interactor->run($pageStructure);

        $area = new AreaStructure([
            'ID' => 1,
            'page_id' => 1,
            'name' => 'Test area'
        ]);
        (new CreateAreaInteractor())->run($area);

        $block = new HTMLBlockStructure([
            'ID' => 1,
            'area_id' => 1,
            'name' => 'Test block',
        ]);
        (new CreateBlockInteractor())->run($block);

        //Create child page
        $pageStructureChild = new PageStructure([
            'ID' => 2,
            'uri' => '/child',
            'identifier' => 'child',
            'name' => 'Child page',
            'master_page_id' => 1
        ]);
        $this->interactor->run($pageStructureChild);

        $this->assertInstanceOf('\CMS\Entities\Area', Context::$areaRepository->findByID(1));
        $this->assertInstanceOf('\CMS\Entities\Block', Context::$blockRepository->findByID(2));
    }
}