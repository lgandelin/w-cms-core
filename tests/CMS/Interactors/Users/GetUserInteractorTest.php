<?php

use CMS\Interactors\Users\GetUserInteractor;
use CMS\Repositories\InMemory\InMemoryUserRepository;
use CMS\Structures\UserStructure;

class GetUserInteractorTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->userRepository = new InMemoryUserRepository();
        $this->interactor = new GetUserInteractor($this->userRepository);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('\CMS\Interactors\Users\GetUserInteractor', $this->interactor);
    }

    /**
     * @expectedException Exception
     */
    public function testGetNonExistingUserByLogin()
    {
        $userStructure = new UserStructure([
            'ID' => 1,
            'login' => 'jdoe',
            'last_name' => 'Doe',
            'first_name' => 'John'
        ]);

        $this->interactor->getByID(1);
    }

    public function testGetUser()
    {
        $userStructure = new UserStructure([
            'ID' => 1,
            'login' => 'jdoe',
            'last_name' => 'Doe',
            'first_name' => 'John'
        ]);

        $this->userRepository->createUser($userStructure);

        $this->assertEquals($userStructure, $this->interactor->getByID(1));
    }

}
 