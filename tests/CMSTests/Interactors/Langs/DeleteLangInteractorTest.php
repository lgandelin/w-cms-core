<?php

namespace CMSTests\Interactors\Langs;

use CMS\Entities\Lang;
use CMS\Interactors\Langs\DeleteLangInteractor;
use CMS\Interactors\Langs\GetLangsInteractor;
use CMSTests\Repositories\InMemoryLangRepository;

class DeleteLangInteractorTest extends \PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->repository = new InMemoryLangRepository();
        $this->interactor = new DeleteLangInteractor($this->repository, new GetLangsInteractor($this->repository));
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

        $this->assertCount(1, $this->repository->findAll());

        $this->interactor->run(1);

        $this->assertCount(0, $this->repository->findAll());
    }

    private function createSampleLang()
    {
        $lang = new Lang();
        $lang->setID(1);
        $lang->setName('Test lang');
        $this->repository->createLang($lang);
    }
}
