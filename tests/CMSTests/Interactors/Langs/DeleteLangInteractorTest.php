<?php

namespace CMSTests\Interactors\Langs;

use CMS\Context;
use CMS\Entities\Lang;
use CMS\Interactors\Langs\DeleteLangInteractor;
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

        $this->assertCount(1, Context::getRepository('lang')->findAll());

        $this->interactor->run(1);

        $this->assertCount(0, Context::getRepository('lang')->findAll());
    }

    private function createSampleLang()
    {
        $lang = new Lang();
        $lang->setName('Test lang');
        Context::getRepository('lang')->createLang($lang);

        return $lang->getID();
    }
}
