<?php

namespace Webaccess\WCMSCoreTests\Interactors\Medias;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Media;
use Webaccess\WCMSCore\Interactors\Medias\GetMediaInteractor;
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

        $this->assertInstanceOf('\Webaccess\WCMSCore\Entities\Media', $this->interactor->getMediaByID($mediaID));
    }

    public function testGetMediaAsStructure()
    {
        $mediaID = $this->createSampleMedia();

        $this->assertInstanceOf('\Webaccess\WCMSCore\DataStructure', $this->interactor->getMediaByID($mediaID, null, true));
    }

    private function createSampleMedia()
    {
        $media = new Media();

        return Context::get('media_repository')->createMedia($media);
    }
}
 