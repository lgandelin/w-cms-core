<?php

namespace Webaccess\WCMSCoreTests\Interactors\Langs;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Lang;
use Webaccess\WCMSCore\Interactors\Langs\GetLangsInteractor;
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
        Context::get('lang')->createLang($lang);

        return $lang->getID();
    }
}
 