<?php

namespace CMSTests\Interactors\Langs;

use CMS\Context;
use CMS\Entities\Lang;
use CMS\Interactors\Langs\GetLangInteractor;
use CMSTestsSuite;

class GetLangInteractorTest extends \PHPUnit_Framework_TestCase {

    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new GetLangInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testGetNonExistingLang()
    {
        $this->interactor->getLangByID(1);
    }

    public function testGetLang()
    {
        $langID = $this->createSampleLang();

        $this->assertInstanceOf('\CMS\Entities\Lang', $this->interactor->getLangByID($langID));
    }

    public function testGetLangAsStructure()
    {
        $langID = $this->createSampleLang();

        $this->assertInstanceOf('\CMS\Structures\LangStructure', $this->interactor->getLangByID($langID, true));
    }

    private function createSampleLang()
    {
        $lang = new Lang();

        return Context::getRepository('lang')->createLang($lang);
    }
}
 