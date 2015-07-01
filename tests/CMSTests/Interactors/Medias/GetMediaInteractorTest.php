<?php

namespace CMSTests\Interactors\Medias;

use CMS\Context;
use CMS\Entities\Media;
use CMS\Interactors\Medias\GetMediaInteractor;
use CMSTestsSuite;

class GetMediaInteractorTest extends \PHPUnit_Framework_TestCase {

    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new GetMediaInteractor();
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

        $this->assertInstanceOf('\CMS\DataStructure', $this->interactor->getMediaByID($mediaID, null, true));
    }

    private function createSampleMedia()
    {
        $media = new Media();

        return Context::getRepository('media')->createMedia($media);
    }
}
 