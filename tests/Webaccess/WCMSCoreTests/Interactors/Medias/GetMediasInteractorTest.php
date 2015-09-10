<?php

namespace Webaccess\WCMSCoreTests\Interactors\Medias;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Media;
use Webaccess\WCMSCore\Interactors\Medias\GetMediasInteractor;
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
        Context::get('media_repository')->createMedia($media);
    }


}
 