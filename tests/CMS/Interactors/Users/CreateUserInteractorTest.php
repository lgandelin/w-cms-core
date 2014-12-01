<?php

use CMS\Interactors\Users\CreateUserInteractor;
use CMS\Repositories\InMemory\InMemoryUserRepository;
use CMS\Structures\UserStructure;

class CreateUserInteractorTest extends PHPUnit_Framework_TestCase
{
    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryUserRepository();
        $this->interactor = new CreateUserInteractor($this->repository);
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
        $this->assertCount(0, $this->repository->findAll());

        $userStructure = new UserStructure([
            'login' => 'jdoe',
            'last_name' => 'Doe',
            'first_name' => 'John'
        ]);

        $this->interactor->run($userStructure);

        $this->assertCount(1, $this->repository->findAll());
    }
}
