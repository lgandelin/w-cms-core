<?php

namespace CMSTests\Interactors\MediaFormats;

use CMS\Context;
use CMS\Entities\MediaFormat;
use CMS\Interactors\MediaFormats\UpdateMediaFormatInteractor;
use CMS\DataStructure;
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

        $mediaFormat = Context::getRepository('media_format')->findByID(1);

        $this->assertEquals('new Media Format', $mediaFormat->getName());
    }

    private function createSampleMediaFormat($mediaFormatID)
    {
        $mediaFormat = new MediaFormat();
        $mediaFormat->setID($mediaFormatID);
        $mediaFormat->setName('Test media Format');
        Context::getRepository('media_format')->createMediaFormat($mediaFormat);

        return $mediaFormat;
    }
}
 