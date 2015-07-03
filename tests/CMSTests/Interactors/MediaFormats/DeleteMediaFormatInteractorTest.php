<?php

namespace CMSTests\Interactors\MediaFormats;

use CMS\Context;
use CMS\Entities\MediaFormat;
use CMS\Interactors\MediaFormats\DeleteMediaFormatInteractor;
use CMSTestsSuite;

class DeleteMediaFormatInteractorTest extends \PHPUnit_Framework_TestCase {

    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new DeleteMediaFormatInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteNonExistingMediaFormat()
    {
        $this->interactor->run(1);
    }

    public function testDeleteMediaFormat()
    {
        $this->createSampleMediaFormat();

        $this->assertCount(1, Context::get('media_format')->findAll());

        $this->interactor->run(1);

        $this->assertCount(0, Context::get('media_format')->findAll());
    }

    private function createSampleMediaFormat()
    {
        $mediaFormat = new MediaFormat();
        $mediaFormat->setID(1);
        $mediaFormat->setName('Test media format');
        Context::get('media_format')->createMediaFormat($mediaFormat);
    }
}
