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
            'first_name' => 'John'
        ]);

        $this->userRepository->createUser($userStructure);

        $userStructureUpdated = new UserStructure([
            'first_name' => 'Jack'
        ]);

        $this->interactor->run(1, $userStructureUpdated);

        $userStructure = $this->userRepository->findByID(1);
        $user = UserConverter::convertUserStructureToUser($userStructure);

        $this->assertEquals('Jack', $user->getFirstName());
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
}
 