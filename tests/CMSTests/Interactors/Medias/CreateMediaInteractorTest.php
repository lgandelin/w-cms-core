<?php

namespace CMSTests\Interactors\Medias;

use CMS\Context;
use CMS\Interactors\Medias\CreateMediaInteractor;
use CMS\Structures\MediaStructure;
use CMSTestsSuite;

class CreateMediaInteractorTest extends \PHPUnit_Framework_TestCase {

    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new CreateMediaInteractor();
    }

    public function testCreateMedia()
    {
        $media = new MediaStructure([
            'ID' => 1,
            'name' => 'Test media',
            'file_name' => '/path/to/media'
        ]);

        $this->interactor->run($media);

        $this->assertEquals(1, count(Context::$mediaRepository->findByID(1)));
    }
}
