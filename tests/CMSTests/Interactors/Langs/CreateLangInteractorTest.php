<?php

namespace CMSTests\Interactors\Langs;

use CMS\Context;
use CMS\Interactors\Langs\CreateLangInteractor;
use CMS\Structures\LangStructure;
use CMSTestsSuite;

class CreateLangInteractorTest extends \PHPUnit_Framework_TestCase {

    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new CreateLangInteractor();
    }

    public function testCreateLang()
    {
        $lang = new LangStructure([
            'ID' => 1,
            'name' => 'Test lang',
            'file_name' => '/path/to/lang'
        ]);

        $this->interactor->run($lang);

        $this->assertEquals(1, count(Context::getRepository('lang')->findByID(1)));
    }
}
