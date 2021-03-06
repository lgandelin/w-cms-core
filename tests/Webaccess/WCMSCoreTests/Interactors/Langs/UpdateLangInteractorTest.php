<?php

namespace Webaccess\WCMSCoreTests\Interactors\Langs;

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Entities\Lang;
use Webaccess\WCMSCore\Interactors\Langs\UpdateLangInteractor;
use Webaccess\WCMSCore\DataStructure;
use CMSTestsSuite;

class UpdateLangInteractorTest extends \PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new UpdateLangInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateNonExistingLang()
    {
        $langStructure = new DataStructure([
            'ID' => 1,
            'name' => 'Test Lang',
            'prefix' => 'fr'
        ]);

        $this->interactor->run($langStructure);
    }

    public function testUpdateLang()
    {
        $this->createSampleLang();

        $langStructureUpdated = new DataStructure([
            'prefix' => '/fr/updated'
        ]);

        $this->interactor->run(1, $langStructureUpdated);

        $lang = Context::get('lang_repository')->findByID(1);

        $this->assertEquals('/fr/updated', $lang->getPrefix());
    }

    private function createSampleLang()
    {
        $lang = new Lang();
        $lang->setName('Français');
        $lang->setPrefix('/fr');
        Context::get('lang_repository')->createLang($lang);

        return $lang->getID();
    }
}
 