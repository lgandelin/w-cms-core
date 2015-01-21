<?php

namespace CMSTests\Interactors\Medias;

use CMS\Interactors\Medias\CreateMediaInteractor;
use CMS\Structures\MediaStructure;
use CMSTests\Repositories\InMemoryMediaRepository;

class CreateMediaInteractorTest extends \PHPUnit_Framework_TestCase {

    public function testCreateMedia()
    {
        $media = new MediaStructure([
            'ID' => 1,
            'name' => 'Test media',
            'path' => '/path/to/media'
        ]);

        $repository = new InMemoryMediaRepository();
        $interactor = new CreateMediaInteractor($repository);

        $interactor->run($media);

        $this->assertEquals(1, count($repository->findByID(1)));
    }
}
