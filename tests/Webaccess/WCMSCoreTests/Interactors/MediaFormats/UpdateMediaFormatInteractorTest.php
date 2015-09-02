<?php

namespace Webaccess\WCMSCoreTests\Interactors\MediaFormats;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\MediaFormat;
use Webaccess\WCMSCore\Interactors\MediaFormats\UpdateMediaFormatInteractor;
use Webaccess\WCMSCore\DataStructure;
use CMSTestsSuite;

class UpdateMediaFormatInteractorTest extends \PHPUnit_Framework_TestCase
{
    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new UpdateMediaFormatInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateNonExistingMediaFormat()
    {
        $mediaFormatStructure = new DataStructure([
            'ID' => 1,
            'name' => 'Test MediaFormat',
        ]);

        $this->interactor->run($mediaFormatStructure);
    }

    public function testUpdateMediaFormat()
    {
        $this->createSampleMediaFormat(1);

        $mediaFormatStructureUpdated = new DataStructure([
            'name' => 'new Media Format'
        ]);

        $this->interactor->run(1, $mediaFormatStructureUpdated);

        $mediaFormat = Context::get('media_format')->findByID(1);

        $this->assertEquals('new Media Format', $mediaFormat->getName());
    }

    private function createSampleMediaFormat($mediaFormatID)
    {
        $mediaFormat = new MediaFormat();
        $mediaFormat->setID($mediaFormatID);
        $mediaFormat->setName('Test media Format');
        Context::get('media_format')->createMediaFormat($mediaFormat);

        return $mediaFormat;
    }
}
 