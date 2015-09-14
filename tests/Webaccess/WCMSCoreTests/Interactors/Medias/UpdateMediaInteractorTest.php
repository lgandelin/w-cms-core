<?php

namespace Webaccess\WCMSCoreTests\Interactors\Medias;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Media;
use Webaccess\WCMSCore\Interactors\Medias\UpdateMediaInteractor;
use Webaccess\WCMSCore\DataStructure;
use CMSTestsSuite;

class UpdateMediaInteractorTest extends \PHPUnit_Framework_TestCase
{
    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new UpdateMediaInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateNonExistingMedia()
    {
        $mediaStructure = new DataStructure([
            'ID' => 1,
            'name' => 'Test Media',
            'file_name' => '/file_name/to/image'
        ]);

        $this->interactor->run($mediaStructure);
    }

    public function testUpdateMedia()
    {
        $this->createSampleMedia(1);

        $mediaStructureUpdated = new DataStructure([
            'file_name' => '/new/file_name/to/image'
        ]);

        $this->interactor->run(1, $mediaStructureUpdated);

        $media = Context::get('media_repository')->findByID(1);

        $this->assertEquals('/new/file_name/to/image', $media->getFileName());
    }

    private function createSampleMedia($mediaID)
    {
        $media = new Media();
        $media->setID($mediaID);
        $media->setName('Test media');
        $media->setFileName('/file_name/to/image');
        Context::get('media_repository')->createMedia($media);

        return $media;
    }
}
 