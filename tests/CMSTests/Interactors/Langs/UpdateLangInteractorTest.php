<?php

namespace CMSTests\Interactors\Langs;

use CMS\Entities\Lang;
use CMS\Interactors\Langs\UpdateLangInteractor;
use CMS\Structures\LangStructure;
use CMSTests\Repositories\InMemoryLangRepository;

class UpdateLangInteractorTest extends \PHPUnit_Framework_TestCase
{
    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryLangRepository();
        $this->interactor = new UpdateLangInteractor($this->repository);
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateNonExistingLang()
    {
        $langStructure = new LangStructure([
            'ID' => 1,
            'name' => 'Test Lang',
            'prefix' => 'fr'
        ]);

        $this->interactor->run($langStructure);
    }

    public function testUpdateLang()
    {
        $this->createSampleLang(1);

        $langStructureUpdated = new LangStructure([
            'prefix' => '/fr/updated'
        ]);

        $this->interactor->run(1, $langStructureUpdated);

        $lang = $this->repository->findByID(1);

        $this->assertEquals('/fr/updated', $lang->getPrefix());
    }

    private function createSampleLang($langID)
    {
        $lang = new Lang();
        $lang->setID($langID);
        $lang->setName('Français');
        $lang->setPrefix('/fr');
        $this->repository->createLang($lang);

        return $lang;
    }
}
 