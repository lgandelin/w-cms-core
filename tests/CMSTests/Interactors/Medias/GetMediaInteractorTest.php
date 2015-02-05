<?php

namespace CMSTests\Interactors\Medias;

use CMS\Entities\Media;
use CMS\Interactors\Medias\GetMediaInteractor;
use CMSTests\Repositories\InMemoryMediaRepository;

class GetMediaInteractorTest extends \PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->repository = new InMemoryMediaRepository();
        $this->interactor = new GetMediaInteractor($this->repository);
    }

    /**
     * @expectedException Exception
     */
    public function testGetNonExistingMedia()
    {
        $this->interactor->getMediaByID(1);
    }

    public function testGetMedia()
    {
        $mediaID = $this->createSampleMedia();

        $this->assertInstanceOf('\CMS\Entities\Media', $this->interactor->getMediaByID($mediaID));
    }

    public function testGetMediaAsStructure()
    {
        $mediaID = $this->createSampleMedia();

        $this->assertInstanceOf('\CMS\Structures\MediaStructure', $this->interactor->getMediaByID($mediaID, true));
    }

    private function createSampleMedia()
    {
        $media = new Media();

        return $this->repository->createMedia($media);
    }
}
 