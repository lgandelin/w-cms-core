<?php

namespace Webaccess\WCMSCoreTests\Interactors\MediaFormats;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Interactors\MediaFormats\CreateMediaFormatInteractor;
use Webaccess\WCMSCore\DataStructure;
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

        $this->assertEquals(1, count(Context::get('media_format')->findByID(1)));
    }
}
