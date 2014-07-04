<?php

use CMS\Converters\UserConverter;
use CMS\Interactors\Users\UpdateUserInteractor;
use CMS\Structures\UserStructure;
use CMS\Repositories\InMemory\InMemoryUserRepository;

class UpdateUserInteractorTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->userRepository = new InMemoryUserRepository();
        $this->interactor = new UpdateUserInteractor($this->userRepository);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('\CMS\Interactors\Users\UpdateUserInteractor', $this->interactor);
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
        $userStructure = new UserStructure([
            'ID' => 1,
            'login' => 'jdoe',
            'last_name' => 'Doe',
            'first_name' => 'John',
            'email' => 'john.doe@gmail.com',
        ]);

        $this->userRepository->createUser($userStructure);

        $userStructure = $this->userRepository->findByID(1);

        $userStructureUpdated = new UserStructure([
            'first_name' => 'Jack'
        ]);

        $this->interactor->run(1, $userStructureUpdated);

        $userStructure = $this->userRepository->findByID(1);
        $user = UserConverter::convertUserStructureToUser($userStructure);

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
        $userStructure = new UserStructure([
            'ID' => 1,
            'login' => 'jdoe',
            'last_name' => 'Doe',
            'first_name' => 'John'
        ]);

        $this->userRepository->createUser($userStructure);

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
        $userStructure = new UserStructure([
            'ID' => 1,
            'login' => 'pmartin',
            'last_name' => 'Doe',
            'first_name' => 'John'
        ]);

        $this->userRepository->createUser($userStructure);

        $userStructure = new UserStructure([
            'ID' => 2,
            'login' => 'jdoe',
            'last_name' => 'Doe',
            'first_name' => 'Jane'
        ]);

        $this->userRepository->createUser($userStructure);

        $userStructureUpdated = new UserStructure([
            'login' => 'jdoe'
        ]);

        $this->interactor->run(1, $userStructureUpdated);
    }
}
 