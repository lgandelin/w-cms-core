<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;
use Webaccess\WCMSCore\Entities\MediaFolder;
use Webaccess\WCMSCore\Interactors\MediaFolders\CreateMediaFolderInteractor;
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
    
    public function testGetAllByMediaFolder()
    {
        $parentMediaFolder = new MediaFolder();
        $parentMediaFolder->setID(1);
        $parentMediaFolder->setName('Parent media folder');
        $parentMediaFolder->setPath('/parent-media-folder');
        Context::get('media_folder_repository')->createMediaFolder($parentMediaFolder);

        $childMediaFolder = new MediaFolder();
        $childMediaFolder->setID(2);
        $childMediaFolder->setName('Child 1 media folder');
        $childMediaFolder->setPath('/parent-media-folder/child-1-media-folder');
        $childMediaFolder->setParentID(1);
        Context::get('media_folder_repository')->createMediaFolder($childMediaFolder);

        $childMediaFolder = new MediaFolder();
        $childMediaFolder->setID(3);
        $childMediaFolder->setName('Child 2 media folder');
        $childMediaFolder->setPath('/parent-media-folder/child-2-media-folder');
        $childMediaFolder->setParentID(1);
        Context::get('media_folder_repository')->createMediaFolder($childMediaFolder);

        $mediaFolders = $this->interactor->getAllByMediaFolder(1);

        $this->assertEquals(2, count($mediaFolders));
    }

    public function testGetAllByMediaFolder2()
    {
        $mediaFolderStructure1 = new DataStructure([
            'name' => 'Media folder 1',
        ]);
        (new CreateMediaFolderInteractor())->run($mediaFolderStructure1);

        $mediaFolderStructure2 = new DataStructure([
            'name' => 'Media folder 2',
        ]);
        (new CreateMediaFolderInteractor())->run($mediaFolderStructure2);

        $mediaFolderStructure3 = new DataStructure([
            'name' => 'Media folder 3',
            'parentID' => 1,
        ]);
        (new CreateMediaFolderInteractor())->run($mediaFolderStructure3);

        $mediaFolders = $this->interactor->getAllByMediaFolder(0);

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
 