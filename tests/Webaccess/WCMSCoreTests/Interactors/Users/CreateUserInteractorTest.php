<?php

use Webaccess\WCMSCore\Context;
use Webaccess\WCMSCore\Interactors\Users\CreateUserInteractor;
use Webaccess\WCMSCore\DataStructure;

class CreateUserInteractorTest extends PHPUnit_Framework_TestCase
{
    private $interactor;

    public function setUp() {
        CMSTestsSuite::clean();
        $this->interactor = new CreateUserInteractor();
    }

    /**
     * @expectedException Exception
     */
    public function testCreateUserWithoutLogin()
    {
        $userStructure = new DataStructure();

        $this->interactor->run($userStructure);
    }

    /**
     * @expectedException Exception
     */
    public function testCreateUserWithAnotherUserExistingWithSameLogin()
    {
        $userStructure = new DataStructure([
            'login' => 'jdoe',
            'last_name' => 'Doe',
            'first_name' => 'John'
        ]);

        $this->interactor->run($userStructure);

        $userStructure = new DataStructure([
            'login' => 'jdoe',
            'last_name' => 'Doe',
            'first_name' => 'Jane'
        ]);

        $this->interactor->run($userStructure);
    }

    public function testCreateUser()
    {
        $this->assertCount(0, Context::get('user_repository')->findAll());

        $userStructure = new DataStructure([
            'login' => 'jdoe',
            'last_name' => 'Doe',
            'first_name' => 'John'
        ]);

        $this->interactor->run($userStructure);

        $this->assertCount(1, Context::get('user_repository')->findAll());
    }
}
