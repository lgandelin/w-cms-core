<?php

namespace Webaccess\WCMSCoreTests\Interactors\MediaFolders;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\DataStructure;
use CMSTestsSuite;
use Webaccess\WCMSCore\Entities\MediaFolder;
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
            'parentID' => null,
        ]);

        $mediaFolderID = $this->interactor->run($media);

        $mediaFolder = Context::get('media_folder_repository')->findByID($mediaFolderID);
        $this->assertEquals(1, count($mediaFolder));
        $this->assertEquals(1, count(Context::get('media_folder_repository')->findAll()));
        $this->assertEquals('/my-media-folder', $mediaFolder->getPath());
    }

    public function testCreateMediaFolderInParent()
    {
        $parentMediaFolder = new DataStructure([
            'name' => 'Parent media folder',
            'parentID' => null,
        ]);

        $parentMediaFolderID = $this->interactor->run($parentMediaFolder);

        $childMediaFolder = new DataStructure([
            'name' => 'Child media folder',
            'parentID' => $parentMediaFolderID,
        ]);

        $childMediaFolderID = $this->interactor->run($childMediaFolder);
        $childMediaFolder = Context::get('media_folder_repository')->findByID($childMediaFolderID);

        $this->assertEquals('/parent-media-folder/child-media-folder', $childMediaFolder->getPath());
    }

    public function testCreateMediaFolderInParent2()
    {
        $parentMediaFolder = new DataStructure([
            'name' => 'Grand parent media folder',
            'parentID' => null,
        ]);

        $grandParentMediaFolderID = $this->interactor->run($parentMediaFolder);

        $parentMediaFolder = new DataStructure([
            'name' => 'Parent media folder',
            'parentID' => $grandParentMediaFolderID,
        ]);

        $parentMediaFolderID = $this->interactor->run($parentMediaFolder);

        $childMediaFolder = new DataStructure([
            'name' => 'Child media folder',
            'parentID' => $parentMediaFolderID,
        ]);

        $childMediaFolderID = $this->interactor->run($childMediaFolder);
        $childMediaFolder = Context::get('media_folder_repository')->findByID($childMediaFolderID);

        $this->assertEquals('/grand-parent-media-folder/parent-media-folder/child-media-folder', $childMediaFolder->getPath());
    }

    /**
     * @expectedException Exception
     */
    public function testCreateMediaFolderWithExistingPath()
    {
        $existingMediaFolder = new MediaFolder();
        $existingMediaFolder->setID(1);
        $existingMediaFolder->setName('Test media Folder');
        $existingMediaFolder->setPath('/test-media-folder');
        Context::get('media_folder_repository')->createMediaFolder($existingMediaFolder);

        $mediaFolder = new DataStructure([
            'name' => 'Test media Folder',
        ]);

        $this->interactor->run($mediaFolder);
    }
}
