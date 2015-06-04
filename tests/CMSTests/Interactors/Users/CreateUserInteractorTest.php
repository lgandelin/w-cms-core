<?php

use CMS\Context;
use CMS\Interactors\Users\CreateUserInteractor;
use CMS\Structures\UserStructure;

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
        $userStructure = new UserStructure();

        $this->interactor->run($userStructure);
    }

    /**
     * @expectedException Exception
     */
    public function testCreateUserWithAnotherUserExistingWithSameLogin()
    {
        $userStructure = new UserStructure([
            'login' => 'jdoe',
            'last_name' => 'Doe',
            'first_name' => 'John'
        ]);

        $this->interactor->run($userStructure);

        $userStructure = new UserStructure([
            'login' => 'jdoe',
            'last_name' => 'Doe',
            'first_name' => 'Jane'
        ]);

        $this->interactor->run($userStructure);
    }

    public function testCreateUser()
    {
        $this->assertCount(0, Context::$userRepository->findAll());

        $userStructure = new UserStructure([
            'login' => 'jdoe',
            'last_name' => 'Doe',
            'first_name' => 'John'
        ]);

        $this->interactor->run($userStructure);

        $this->assertCount(1, Context::$userRepository->findAll());
    }
}
