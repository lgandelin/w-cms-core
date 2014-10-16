<?php

use CMS\Entities\User;
use CMS\Interactors\Users\GetUsersInteractor;
use CMS\Repositories\InMemory\InMemoryUserRepository;

class GetUsersInteractorTest extends PHPUnit_Framework_TestCase {

    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryUserRepository();
        $this->interactor = new GetUsersInteractor($this->repository);
    }

    public function testGetAllWithoutUsers()
    {
        $this->assertCount(0, $this->interactor->getAll());
    }

    public function testGetAll()
    {
        $this->createSampleUser(1);
        $this->createSampleUser(2);

        $users = $this->interactor->getAll();

        $this->assertCount(2, $users);
        $this->assertInstanceOf('\CMS\Entities\User', $users[0]);
    }

    public function testGetByStructures()
    {
        $this->createSampleUser(1);
        $this->createSampleUser(2);

        $users = $this->interactor->getAll(true);

        $this->assertCount(2, $users);
        $this->assertInstanceOf('\CMS\Structures\UserStructure', $users[0]);
    }

    private function createSampleUser($userID)
    {
        $user = new User();
        $user->setID($userID);
        $user->setLastName('User lastname');
        $this->repository->createUser($user);
    }

}
 