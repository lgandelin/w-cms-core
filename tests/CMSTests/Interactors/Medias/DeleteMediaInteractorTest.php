<?php

namespace CMSTests\Interactors\Medias;

use CMS\Context;
use CMS\Entities\Media;
use CMS\Interactors\Medias\DeleteMediaInteractor;
use CMSTestsSuite;

class DeleteMediaInteractorTest extends \PHPUnit_Framework_TestCase {

    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new DeleteMediaInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteNonExistingMedia()
    {
        $this->interactor->run(1);
    }

    public function testDeleteMedia()
    {
        $this->createSampleMedia();

        $this->assertCount(1, Context::get('media')->findAll());

        $this->interactor->run(1);

        $this->assertCount(0, Context::get('media')->findAll());
    }

    private function createSampleMedia()
    {
        $media = new Media();
        $media->setID(1);
        $media->setName('Test media');
        Context::get('media')->createMedia($media);
    }
}
