<?php

use CMS\Interactors\Users\GetAllUsersInteractor;
use CMS\Repositories\InMemory\InMemoryUserRepository;
use CMS\Structures\UserStructure;

class GetAllUsersInteractorTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->userRepository = new InMemoryUserRepository();
        $this->interactor = new GetAllUsersInteractor($this->userRepository);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('\CMS\Interactors\Users\GetAllUsersInteractor', $this->interactor);
    }

    public function testGetAllWithoutUsers()
    {
        $this->assertCount(0, $this->interactor->getAll());
    }

    public function testGetAll()
    {
        $userStructure = new UserStructure([
            'login' => 'jdoe',
            'last_name' => 'Doe',
            'first_name' => 'John'
        ]);

        $userStructure2 = new UserStructure([
            'login' => 'pmartin',
            'last_name' => 'Martin',
            'first_name' => 'Paul'
        ]);

        $this->userRepository->createUser($userStructure);
        $this->userRepository->createUser($userStructure2);

        $this->assertCount(2, $this->interactor->getAll());
    }

}
 