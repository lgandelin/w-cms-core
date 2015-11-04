<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\MediaFolder;
use Webaccess\WCMSCore\Interactors\MediaFolders\GetMediaFoldersInteractor;

class GetMediaFoldersInteractorTest extends PHPUnit_Framework_TestCase {

    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new GetMediaFoldersInteractor();
    }

    public function testGetAll()
    {
        $this->createSampleMediaFolder(1);
        $this->createSampleMediaFolder(2);

        $mediaFolders = $this->interactor->getAll();

        $this->assertEquals(2, count($mediaFolders));
    }

    private function createSampleMediaFolder($mediaFolderID)
    {
        $mediaFolder = new MediaFolder();
        $mediaFolder->setID($mediaFolderID);
        $mediaFolder->setName('MediaFolder' . $mediaFolderID);
        Context::get('media_folder_repository')->createMediaFolder($mediaFolder);
    }
}
 