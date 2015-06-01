<?php

namespace CMSTests\Interactors\MediaFormats;

use CMS\Context;
use CMS\Entities\MediaFormat;
use CMS\Interactors\MediaFormats\UpdateMediaFormatInteractor;
use CMS\Structures\MediaFormatStructure;
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
        $mediaFormatStructure = new MediaFormatStructure([
            'ID' => 1,
            'name' => 'Test MediaFormat',
        ]);

        $this->interactor->run($mediaFormatStructure);
    }

    public function testUpdateMediaFormat()
    {
        $this->createSampleMediaFormat(1);

        $mediaFormatStructureUpdated = new MediaFormatStructure([
            'name' => 'new Media Format'
        ]);

        $this->interactor->run(1, $mediaFormatStructureUpdated);

        $mediaFormat = Context::$mediaFormatRepository->findByID(1);

        $this->assertEquals('new Media Format', $mediaFormat->getName());
    }

    private function createSampleMediaFormat($mediaFormatID)
    {
        $mediaFormat = new MediaFormat();
        $mediaFormat->setID($mediaFormatID);
        $mediaFormat->setName('Test media Format');
        Context::$mediaFormatRepository->createMediaFormat($mediaFormat);

        return $mediaFormat;
    }
}
 