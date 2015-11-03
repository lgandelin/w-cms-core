<?php

namespace Webaccess\WCMSCoreTests\Interactors\MediaFolders;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;
use CMSTestsSuite;
use Webaccess\WCMSCore\Interactors\MediaFolders\CreateMediaFolderInteractor;

class CreateMediaFolderInteractorTest extends \PHPUnit_Framework_TestCase {

    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new CreateMediaFolderInteractor();
    }

    public function testCreateMediaFolder()
    {
        $media = new DataStructure([
            'name' => 'My media folder',
            'parent_id' => null,
        ]);

        $mediaFolderID = $this->interactor->run($media);

        $mediaFolder = Context::get('media_folder_repository')->findByID($mediaFolderID);
        $this->assertEquals(1, count($mediaFolder));
        $this->assertEquals(1, count(Context::get('media_folder_repository')->findAll()));
        $this->assertEquals('/my-media-folder', $mediaFolder->getPath());
    }
}
