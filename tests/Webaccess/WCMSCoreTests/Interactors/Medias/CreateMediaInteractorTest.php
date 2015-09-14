<?php

namespace Webaccess\WCMSCoreTests\Interactors\Medias;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Interactors\Medias\CreateMediaInteractor;
use Webaccess\WCMSCore\DataStructure;
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

        $this->assertEquals(1, count(Context::get('media_repository')->findByID(1)));
    }
}
