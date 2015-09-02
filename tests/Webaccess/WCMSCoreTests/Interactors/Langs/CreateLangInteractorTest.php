<?php

namespace Webaccess\WCMSCoreTests\Interactors\Langs;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Interactors\Langs\CreateLangInteractor;
use Webaccess\WCMSCore\DataStructure;
use CMSTestsSuite;

class CreateLangInteractorTest extends \PHPUnit_Framework_TestCase {

    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new CreateLangInteractor();
    }

    public function testCreateLang()
    {
        $lang = new DataStructure([
            'ID' => 1,
            'name' => 'Test lang',
        ]);

        $this->interactor->run($lang);

        $this->assertEquals(1, count(Context::get('lang')->findByID(1)));
    }
}
