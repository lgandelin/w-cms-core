<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Entities\MediaFolder;
use Webaccess\WCMSCore\Interactors\MediaFolders\UpdateMediaFolderInteractor;

class UpdateMediaFolderInteractorTest extends PHPUnit_Framework_TestCase {
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new UpdateMediaFolderInteractor();
    }

    public function testUpdateMediaFolder() {
        $mediaFolder = new MediaFolder();
        $mediaFolder->setID(1);
        $mediaFolder->setName('Test media folder');
        $mediaFolder->setPath('/test-media-folder');
        Context::get('media_folder_repository')->createMediaFolder($mediaFolder);

        $media = new DataStructure([
            'name' => 'My media folder',
        ]);

        $this->interactor->run(1, $media);
        $mediaFolder = Context::get('media_folder_repository')->findByID(1);
        $this->assertEquals('My media folder', $mediaFolder->getName());
        $this->assertEquals('/my-media-folder', $mediaFolder->getPath());
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateMediaFolderWithExistingPath()
    {
        $existingMediaFolder = new MediaFolder();
        $existingMediaFolder->setID(1);
        $existingMediaFolder->setName('Test media Folder');
        $existingMediaFolder->setPath('/test-media-folder');
        Context::get('media_folder_repository')->createMediaFolder($existingMediaFolder);

        $anotherMediaFolder = new MediaFolder();
        $anotherMediaFolder->setID(2);
        $anotherMediaFolder->setName('Another media Folder');
        $anotherMediaFolder->setPath('/another-media-folder');
        Context::get('media_folder_repository')->createMediaFolder($anotherMediaFolder);

        $mediaFolder = new DataStructure([
            'name' => 'Test media Folder',
        ]);

        $this->interactor->run(2, $mediaFolder);
    }
}
