<?php

use CMS\Interactors\Users\DeleteUserInteractor;
use CMS\Repositories\InMemory\InMemoryUserRepository;
use CMS\Structures\UserStructure;

class DeleteUserInteractorTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->userRepository = new InMemoryUserRepository();
        $this->interactor = new DeleteUserInteractor($this->userRepository);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('\CMS\Interactors\Users\DeleteUserInteractor', $this->interactor);
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteNonExistingUser()
    {
        $userStructure = new UserStructure([
            'login' => 'jdoe',
            'last_name' => 'Doe',
            'first_name' => 'John'
        ]);

        $this->interactor->run($userStructure);
    }

    public function testDeleteUser()
    {
        $userStructure = new UserStructure([
            'ID' => 1,
            'login' => 'jdoe',
            'last_name' => 'Doe',
            'first_name' => 'John'
        ]);

        $this->userRepository->createUser($userStructure);

        $this->assertCount(1, $this->userRepository->findAll());

        $this->interactor->run(1);

        $this->assertCount(0, $this->userRepository->findAll());
    }


}