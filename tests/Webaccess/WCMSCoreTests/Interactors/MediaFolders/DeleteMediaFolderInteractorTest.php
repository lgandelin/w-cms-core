<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\MediaFolder;
use Webaccess\WCMSCore\Interactors\MediaFolders\DeleteMediaFolderInteractor;

class DeleteMediaFolderInteractorTest extends PHPUnit_Framework_TestCase {

    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new DeleteMediaFolderInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteNonExistingMediaFolder()
    {
        $this->interactor->run(1);
    }

    public function testDeleteMediaFolder()
    {
        $this->createSampleMediaFolder();

        $this->assertCount(1, Context::get('media_folder_repository')->findAll());

        $this->interactor->run(1);

        $this->assertCount(0, Context::get('media_folder_repository')->findAll());
    }

    private function createSampleMediaFolder()
    {
        $mediaFolder = new MediaFolder();
        $mediaFolder->setID(1);
        $mediaFolder->setName('Test media folder');
        $mediaFolder->setPath('/test-media-folder');
        Context::get('media_folder_repository')->createMediaFolder($mediaFolder);
    }
}
