<?php

use CMS\Entities\User;
use CMS\Services\UserManager;
use CMS\Structures\UserStructure;
    
class UserManagerTest extends PHPUnit_Framework_TestCase {

    private function _createUserObject($login, $password = null, $last_name = null, $first_name = null, $email = null)
    {
        $user = new User();
        $user->setLogin($login);
        if ($password) $user->setPassword($password);
        $user->setLastName($last_name);
        $user->setFirstName($first_name);
        $user->setEmail($email);

        return $user;
    }

    public function setUp()
    {
        $this->userRepository = Phake::mock('\CMS\Repositories\UserRepositoryInterface');
    }

    private function _getUserManager()
    {
        return new UserManager($this->userRepository);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf('CMS\Services\UserManager', $this->_getUserManager());
    }

    /**
     * @expectedException Exception
     */
    public function testGetByLoginNonExisting()
    {
        $user = $this->_getUserManager()->getByLogin('jdoe');
    }

    public function testGetByLogin()
    {
        $user = $this->_createUserObject('jdoe', '', 'Doe', 'John');
        $userS = UserStructure::convertUserToUserStructure($user);

        Phake::when($this->userRepository)->findByLogin('jdoe')->thenReturn($user);

        $this->assertInstanceOf('CMS\Structures\UserStructure', $this->_getUserManager()->getByLogin('jdoe'));
        $this->assertEquals($userS, $this->_getUserManager()->getByLogin('jdoe'));
    }
    
    public function testGetAllWithoutUser()
    {
        Phake::when($this->userRepository)->findAll()->thenReturn(null);

        $this->assertEquals(null, $this->_getUserManager()->getAll());
    }

    public function testGetAll()
    {
        $user1 = $this->_createUserObject('jdoe');
        $user2 = $this->_createUserObject('asmith');
        $user1S = UserStructure::convertUserToUserStructure($user1);
        $user2S = UserStructure::convertUserToUserStructure($user2);

        Phake::when($this->userRepository)->findAll()->thenReturn([$user1, $user2]);

        $this->assertEquals([$user1S, $user2S], $this->_getUserManager()->getAll());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCreateUserWithInvalidArguments()
    {
        $invalidUserS = new UserStructure([
            'last_name' => 'Doe',
            'first_name' => 'John'
        ]);

        $this->_getUserManager()->createUser($invalidUserS);
    }

    /**
     * @expectedException Exception
     */
    public function testCreateUserWithAlreadyExistingLogin()
    {
        $user1 = $this->_createUserObject('jdoe', '', 'Doe', 'John');
        $user2S = new UserStructure([
            'login' => 'jdoe',
            'last_name' => 'Doe',
            'first_name' => 'John'
        ]);

        Phake::when($this->userRepository)->findByLogin('jdoe')->thenReturn($user1);

        $this->_getUserManager()->createUser($user2S);
    }

    public function testCreateUser()
    {
        $user1 = $this->_createUserObject('jdoe', '', 'Doe', 'John');
        $user2 = $this->_createUserObject('asmith', '', 'Smith', 'Albert');
        $user3 = $this->_createUserObject('pmartin', '', 'Martin', 'Paul');
        $user1S = UserStructure::convertUserToUserStructure($user1);
        $user2S = UserStructure::convertUserToUserStructure($user2);
        $user3S = UserStructure::convertUserToUserStructure($user3);

        Phake::when($this->userRepository)->findAll()
            ->thenReturn([$user1, $user2]);

        //Before create
        $this->assertEquals([$user1S, $user2S], $this->_getUserManager()->getAll());

        //Create
        $this->_getUserManager()->createUser($user3S);

        Phake::when($this->userRepository)->findAll()
            ->thenReturn([$user1, $user2, $user3]);

        //After create
        $this->assertEquals([$user1S, $user2S, $user3S], $this->_getUserManager()->getAll());
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateNonExistingUser()
    {
        $userS = new UserStructure([
            'login' => 'pmartin',
            'last_name' => 'Martin',
            'first_name' => 'Paul'
        ]);

        $this->_getUserManager()->updateUser($userS);
    }

    public function testUpdateUser()
    {
        $user = $this->_createUserObject('pmartin', '111aaa', 'Martin', 'Paul');
        $userS = UserStructure::convertUserToUserStructure($user);
        $userUpdated = $this->_createUserObject('pmartin', '222bbb', 'Martin', 'Paul');
        $userUpdatedS = UserStructure::convertUserToUserStructure($userUpdated);
        $userUpdatedWithPasswordS = new UserStructure([
            'login' => 'pmartin',
            'password' => '222bbb',
            'last_name' => 'Martin',
            'first_name' => 'Paul'
        ]);

        Phake::when($this->userRepository)->findByLogin('pmartin')->thenReturn($user)->thenReturn($userUpdated)->thenReturn($userUpdated);

        //Before update
        $this->assertEquals($userS, $this->_getUserManager()->getByLogin('pmartin'));

        //Update
        $this->_getUserManager()->updateUser($userUpdatedS);

        //After update
        $this->assertEquals($userUpdatedWithPasswordS, $this->_getUserManager()->getByLogin('pmartin'));
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteNonExistingUser()
    {
        $this->_getUserManager()->deleteUser('my-user');
    }

    public function testDeleteUser()
    {
        $user1 = $this->_createUserObject('jdoe', '', 'Doe', 'John');
        $user2 = $this->_createUserObject('asmith', '', 'Smith', 'Albert');
        $user1S = UserStructure::convertUserToUserStructure($user1);
        $user2S = UserStructure::convertUserToUserStructure($user2);

        Phake::when($this->userRepository)->findAll()
            ->thenReturn([$user1, $user2])
            ->thenReturn([$user2]);
        Phake::when($this->userRepository)->findByLogin('jdoe')->thenReturn($user1);

        //Before delete
        $this->assertEquals([$user1S, $user2S], $this->_getUserManager()->getAll());

        //Delete
        $this->_getUserManager()->deleteUser('jdoe');

        //After delete
        $this->assertEquals([$user2S], $this->_getUserManager()->getAll());
    }

}