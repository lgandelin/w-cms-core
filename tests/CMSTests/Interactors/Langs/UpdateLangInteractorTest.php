<?php

namespace CMSTests\Interactors\Langs;

use CMS\Context;
use CMS\Entities\Lang;
use CMS\Interactors\Langs\UpdateLangInteractor;
use CMS\Structures\DataStructure;
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

        $lang = Context::getRepository('lang')->findByID(1);

        $this->assertEquals('/fr/updated', $lang->getPrefix());
    }

    private function createSampleLang()
    {
        $lang = new Lang();
        $lang->setName('Français');
        $lang->setPrefix('/fr');
        Context::getRepository('lang')->createLang($lang);

        return $lang->getID();
    }
}
 