<?php

namespace CMSTests\Interactors\Medias;

use CMS\Context;
use CMS\Interactors\Medias\CreateMediaInteractor;
use CMS\DataStructure;
use CMSTestsSuite;

class CreateMediaInteractorTest extends \PHPUnit_Framework_TestCase {

    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new CreateMediaInteractor();
    }

    public function testCreateMedia()
    {
        $media = new DataStructure([
            'ID' => 1,
            'name' => 'Test media',
            'file_name' => '/path/to/media'
        ]);

        $this->interactor->run($media);

        $this->assertEquals(1, count(Context::getRepository('media')->findByID(1)));
    }
}
