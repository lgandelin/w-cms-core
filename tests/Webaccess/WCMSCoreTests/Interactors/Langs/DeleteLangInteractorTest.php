<?php

namespace Webaccess\WCMSCoreTests\Interactors\Langs;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Lang;
use Webaccess\WCMSCore\Interactors\Langs\DeleteLangInteractor;
use CMSTestsSuite;

class DeleteLangInteractorTest extends \PHPUnit_Framework_TestCase {

    private $interactor;
    
    public function setUp()
    {
        CMSTestsSuite::clean();
        $this->interactor = new DeleteLangInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteNonExistingLang()
    {
        $this->interactor->run(1);
    }

    public function testDeleteLang()
    {
        $this->createSampleLang();

        $this->assertCount(1, Context::get('lang')->findAll());

        $this->interactor->run(1);

        $this->assertCount(0, Context::get('lang')->findAll());
    }

    private function createSampleLang()
    {
        $lang = new Lang();
        $lang->setName('Test lang');
        Context::get('lang')->createLang($lang);

        return $lang->getID();
    }
}
