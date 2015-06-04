<?php

namespace CMSTests\Interactors\Langs;

use CMS\Context;
use CMS\Entities\Lang;
use CMS\Interactors\Langs\GetLangsInteractor;
use CMSTestsSuite;

class GetLangsInteractorTest extends \PHPUnit_Framework_TestCase {

    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new GetLangsInteractor();
    }

    public function testGetAll()
    {
        $this->createSampleLang();
        $this->createSampleLang();

        $langs = $this->interactor->getAll();

        $this->assertEquals(2, count($langs));
    }

    private function createSampleLang()
    {
        $lang = new Lang();
        $lang->setName('Lang X');
        Context::$langRepository->createLang($lang);

        return $lang->getID();
    }
}
 