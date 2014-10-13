<?php

use CMS\Entities\User;
use CMS\Interactors\Users\GetUserInteractor;
use CMS\Repositories\InMemory\InMemoryUserRepository;

class GetUserInteractorTest extends PHPUnit_Framework_TestCase {

    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryUserRepository();
        $this->interactor = new GetUserInteractor($this->repository);
    }

    /**
     * @expectedException Exception
     */
    public function testGetNonExistingUser()
    {
        $this->interactor->getUserByID(1);
    }

    public function testGetUser()
    {
        $user = $this->createSampleUser();
        
        $this->assertEquals($user, $this->interactor->getUserByID(1));
    }

    private function createSampleUser()
    {
        $user = new User();
        $user->setID(1);
        $user->setLastName('User lastname');
        $this->repository->createUser($user);

        return $user;
    }

}
 