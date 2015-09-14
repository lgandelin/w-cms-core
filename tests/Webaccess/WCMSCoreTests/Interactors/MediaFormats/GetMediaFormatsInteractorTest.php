<?php

namespace Webaccess\WCMSCoreTests\Interactors\MediaFormats;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\MediaFormat;
use Webaccess\WCMSCore\Interactors\MediaFormats\GetMediaFormatsInteractor;
use CMSTestsSuite;

class GetMediaFormatsInteractorTest extends \PHPUnit_Framework_TestCase {

    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new GetMediaFormatsInteractor();
    }

    public function testGetAll()
    {
        $this->createSampleMediaFormat(1);
        $this->createSampleMediaFormat(2);

        $mediaFormats = $this->interactor->getAll();

        $this->assertEquals(2, count($mediaFormats));
    }

    private function createSampleMediaFormat($mediaFormatID)
    {
        $mediaFormat = new MediaFormat();
        $mediaFormat->setID($mediaFormatID);
        $mediaFormat->setName('MediaFormat' . $mediaFormatID);
        Context::get('media_format_repository')->createMediaFormat($mediaFormat);
    }


}
 