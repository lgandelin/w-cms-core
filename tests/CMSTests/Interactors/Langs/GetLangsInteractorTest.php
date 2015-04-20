<?php

namespace CMSTests\Interactors\Langs;

use CMS\Entities\Lang;
use CMS\Interactors\Langs\GetLangsInteractor;
use CMSTests\Repositories\InMemoryLangRepository;

class GetLangsInteractorTest extends \PHPUnit_Framework_TestCase {

    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryLangRepository();
        $this->interactor = new GetLangsInteractor($this->repository);
    }

    public function testGetAll()
    {
        $this->createSampleLang(1);
        $this->createSampleLang(2);

        $langs = $this->interactor->getAll();

        $this->assertEquals(2, count($langs));
    }

    private function createSampleLang($langID)
    {
        $lang = new Lang();
        $lang->setID($langID);
        $lang->setName('Lang' . $langID);
        $this->repository->createLang($lang);
    }


}
 