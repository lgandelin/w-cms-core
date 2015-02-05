<?php

namespace CMSTests\Interactors\Medias;

use CMS\Entities\Media;
use CMS\Interactors\Medias\DeleteMediaInteractor;
use CMSTests\Repositories\InMemoryMediaRepository;

class DeleteMediaInteractorTest extends \PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->repository = new InMemoryMediaRepository();
        $this->interactor = new DeleteMediaInteractor($this->repository);
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

        $this->assertCount(1, $this->repository->findAll());

        $this->interactor->run(1);

        $this->assertCount(0, $this->repository->findAll());
    }

    private function createSampleMedia()
    {
        $media = new Media();
        $media->setID(1);
        $media->setName('Test media');
        $this->repository->createMedia($media);
    }
}
