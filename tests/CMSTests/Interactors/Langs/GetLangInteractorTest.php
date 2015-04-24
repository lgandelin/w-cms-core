<?php

namespace CMSTests\Interactors\Langs;

use CMS\Entities\Lang;
use CMS\Interactors\Langs\GetLangInteractor;
use CMSTests\Repositories\InMemoryLangRepository;

class GetLangInteractorTest extends \PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->repository = new InMemoryLangRepository();
        $this->interactor = new GetLangInteractor($this->repository);
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

        return $this->repository->createLang($lang);
    }
}
 