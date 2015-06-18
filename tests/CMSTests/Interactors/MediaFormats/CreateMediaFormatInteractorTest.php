<?php

namespace CMSTests\Interactors\MediaFormats;

use CMS\Context;
use CMS\Interactors\MediaFormats\CreateMediaFormatInteractor;
use CMS\Structures\DataStructure;
use CMSTestsSuite;

class CreateMediaFormatInteractorTest extends \PHPUnit_Framework_TestCase {

    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new CreateMediaFormatInteractor();
    }

    public function testCreateMediaFormat()
    {
        $mediaFormat = new DataStructure([
            'ID' => 1,
            'name' => 'Test media format',
        ]);

        $this->interactor->run($mediaFormat);

        $this->assertEquals(1, count(Context::getRepository('media_format')->findByID(1)));
    }
}
