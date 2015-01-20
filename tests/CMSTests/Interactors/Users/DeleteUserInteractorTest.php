<?php

use CMS\Entities\User;
use CMS\Interactors\Users\DeleteUserInteractor;
use CMSTests\Repositories\InMemoryUserRepository;

class DeleteUserInteractorTest extends PHPUnit_Framework_TestCase
{
    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryUserRepository();
        $this->interactor = new DeleteUserInteractor($this->repository);
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteNonExistingUser()
    {
        $this->interactor->run(1);
    }

    public function testDeleteUser()
    {
        $this->createSampleUser();

        $this->assertCount(1, $this->repository->findAll());

        $this->interactor->run(1);

        $this->assertCount(0, $this->repository->findAll());
    }

    private function createSampleUser()
    {
        $user = new User();
        $user->setID(1);
        $user->setLastName('User lastname');
        $this->repository->createUser($user);
    }
}
