<?php

use CMS\Entities\User;
use CMS\Interactors\Users\UpdateUserInteractor;
use CMS\Structures\UserStructure;
use CMS\Repositories\InMemory\InMemoryUserRepository;

class UpdateUserInteractorTest extends PHPUnit_Framework_TestCase {

    private $repository;
    private $interactor;

    public function setUp()
    {
        $this->repository = new InMemoryUserRepository();
        $this->interactor = new UpdateUserInteractor($this->repository);
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateNonExistingUser()
    {
        $userStructure = new UserStructure([
            'ID' => 1,
            'login' => 'jdoe',
            'last_name' => 'Doe',
            'first_name' => 'John'
        ]);

        $this->interactor->run($userStructure);
    }

    public function testUpdateUser()
    {

        $this->createSampleUser(1);

        $userStructureUpdated = new UserStructure([
            'first_name' => 'Jack'
        ]);

        $this->interactor->run(1, $userStructureUpdated);

        $user = $this->repository->findByID(1);

        $this->assertEquals('jdoe', $user->getLogin());
        $this->assertEquals('Doe', $user->getLastName());
        $this->assertEquals('Jack', $user->getFirstName());
        $this->assertEquals('john.doe@gmail.com', $user->getEmail());
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateUserWithEmptyLogin()
    {
        $this->createSampleUser(1);

        $userStructureUpdated = new UserStructure([
            'login' => ''
        ]);

        $this->interactor->run(1, $userStructureUpdated);
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateUserWithAnotherUserExistingWithSameLogin()
    {
        $this->createSampleUser(1);

        $user = new User();
        $user->setID(2);
        $user->setLogin('jane.doe');
        $this->repository->createUser($user);

        $userStructureUpdated = new UserStructure([
            'login' => 'jdoe'
        ]);

        $this->interactor->run(2, $userStructureUpdated);
    }

    private function createSampleUser($userID)
    {
        $user = new User();
        $user->setID($userID);
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setLogin('jdoe');
        $user->setEmail('john.doe@gmail.com');
        $this->repository->createUser($user);

        return $user;
    }
}
 