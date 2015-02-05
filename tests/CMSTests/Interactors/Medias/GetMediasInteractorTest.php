<?php

namespace CMSTests\Interactors\Medias;

use CMS\Entities\Media;
use CMS\Interactors\Medias\GetMediasInteractor;
use CMSTests\Repositories\InMemoryMediaRepository;

class GetMediasInteractorTest extends \PHPUnit_Framework_TestCase {

    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryMediaRepository();
        $this->interactor = new GetMediasInteractor($this->repository);
    }

    public function testGetAll()
    {
        $this->createSampleMedia(1);
        $this->createSampleMedia(2);

        $medias = $this->interactor->getAll();

        $this->assertEquals(2, count($medias));
    }

    private function createSampleMedia($mediaID)
    {
        $media = new Media();
        $media->setID($mediaID);
        $media->setName('Media' . $mediaID);
        $this->repository->createMedia($media);
    }


}
 