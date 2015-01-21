<?php

namespace CMSTests\Interactors\Medias;

use CMS\Entities\Media;
use CMS\Interactors\Medias\UpdateMediaInteractor;
use CMS\Structures\MediaStructure;
use CMSTests\Repositories\InMemoryMediaRepository;

class UpdateMediaInteractorTest extends \PHPUnit_Framework_TestCase
{
    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryMediaRepository();
        $this->interactor = new UpdateMediaInteractor($this->repository);
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateNonExistingMedia()
    {
        $mediaStructure = new MediaStructure([
            'ID' => 1,
            'name' => 'Test Media',
            'path' => '/path/to/image'
        ]);

        $this->interactor->run($mediaStructure);
    }

    public function testUpdateMedia()
    {
        $this->createSampleMedia(1);

        $mediaStructureUpdated = new MediaStructure([
            'path' => '/new/path/to/image'
        ]);

        $this->interactor->run(1, $mediaStructureUpdated);

        $media = $this->repository->findByID(1);

        $this->assertEquals('/new/path/to/image', $media->getPath());
    }

    private function createSampleMedia($mediaID)
    {
        $media = new Media();
        $media->setID($mediaID);
        $media->setName('Test media');
        $media->setPath('/path/to/image');
        $this->repository->createMedia($media);

        return $media;
    }
}
 