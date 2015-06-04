<?php

namespace CMSTests\Interactors\MediaFormats;

use CMS\Context;
use CMS\Interactors\MediaFormats\CreateMediaFormatInteractor;
use CMS\Structures\MediaFormatStructure;
use CMSTestsSuite;

class CreateMediaFormatInteractorTest extends \PHPUnit_Framework_TestCase {

    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new CreateMediaFormatInteractor();
    }

    public function testCreateMediaFormat()
    {
        $mediaFormat = new MediaFormatStructure([
            'ID' => 1,
            'name' => 'Test media format',
        ]);

        $this->interactor->run($mediaFormat);

        $this->assertEquals(1, count(Context::$mediaFormatRepository->findByID(1)));
    }
}
