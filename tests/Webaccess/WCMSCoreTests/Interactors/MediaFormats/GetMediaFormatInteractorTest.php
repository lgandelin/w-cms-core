<?php

namespace Webaccess\WCMSCoreTests\Interactors\MediaFormats;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\MediaFormat;
use Webaccess\WCMSCore\Interactors\MediaFormats\GetMediaFormatInteractor;
use CMSTestsSuite;

class GetMediaFormatInteractorTest extends \PHPUnit_Framework_TestCase {

    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new GetMediaFormatInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testGetNonExistingMediaFormat()
    {
        $this->interactor->getMediaFormatByID(1);
    }

    public function testGetMediaFormat()
    {
        $mediaFormatID = $this->createSampleMediaFormat();

        $this->assertInstanceOf('\Webaccess\WCMSCore\Entities\MediaFormat', $this->interactor->getMediaFormatByID($mediaFormatID));
    }

    public function testGetMediaFormatAsStructure()
    {
        $mediaFormatID = $this->createSampleMediaFormat();

        $this->assertInstanceOf('\Webaccess\WCMSCore\DataStructure', $this->interactor->getMediaFormatByID($mediaFormatID, true));
    }

    private function createSampleMediaFormat()
    {
        $mediaFormat = new MediaFormat();

        return Context::get('media_format')->createMediaFormat($mediaFormat);
    }
}
 