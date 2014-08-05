<?php

use CMS\Interactors\Users\CreateUserInteractor;
use CMS\Repositories\InMemory\InMemoryUserRepository;
use CMS\Structures\UserStructure;

class CreateUserInteractorTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->userRepository = new InMemoryUserRepository();
        $this->interactor = new CreateUserInteractor($this->userRepository);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('\CMS\Interactors\Users\CreateUserInteractor', $this->interactor);
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
        $this->assertCount(0, $this->userRepository->findAll());

        $userStructure = new UserStructure([
            'login' => 'jdoe',
            'last_name' => 'Doe',
            'first_name' => 'John'
        ]);

        $this->interactor->run($userStructure);

        $this->assertCount(1, $this->userRepository->findAll());
    }

}
