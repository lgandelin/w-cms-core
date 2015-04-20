<?php

namespace CMSTests\Interactors\Langs;

use CMS\Interactors\Langs\CreateLangInteractor;
use CMS\Structures\LangStructure;
use CMSTests\Repositories\InMemoryLangRepository;

class CreateLangInteractorTest extends \PHPUnit_Framework_TestCase {

    public function testCreateLang()
    {
        $lang = new LangStructure([
            'ID' => 1,
            'name' => 'Test lang',
            'file_name' => '/path/to/lang'
        ]);

        $repository = new InMemoryLangRepository();
        $interactor = new CreateLangInteractor($repository);

        $interactor->run($lang);

        $this->assertEquals(1, count($repository->findByID(1)));
    }
}
