<?php

namespace Webaccess\WCMSCoreTests\Interactors\Langs;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Lang;
use Webaccess\WCMSCore\Interactors\Langs\GetLangInteractor;
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

        $this->assertInstanceOf('\Webaccess\WCMSCore\Entities\Lang', $this->interactor->getLangByID($langID));
    }

    public function testGetLangAsStructure()
    {
        $langID = $this->createSampleLang();

        $this->assertInstanceOf('\Webaccess\WCMSCore\DataStructure', $this->interactor->getLangByID($langID, true));
    }

    private function createSampleLang()
    {
        $lang = new Lang();

        return Context::get('lang_repository')->createLang($lang);
    }
}
 