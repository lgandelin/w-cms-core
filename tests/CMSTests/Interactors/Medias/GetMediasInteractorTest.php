<?php

namespace CMSTests\Interactors\Medias;

use CMS\Context;
use CMS\Entities\Media;
use CMS\Interactors\Medias\GetMediasInteractor;
use CMSTestsSuite;

class GetMediasInteractorTest extends \PHPUnit_Framework_TestCase {

    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new GetMediasInteractor();
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
        Context::get('media')->createMedia($media);
    }


}
 