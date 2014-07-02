<?php

namespace CMS\Interactors\Users;

use CMS\Repositories\UserRepositoryInterface;
use CMS\UseCases\Users\DeleteUserUseCase;

class DeleteUserInteractor extends GetUserInteractor implements DeleteUserUseCase
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        parent::__construct($userRepository);
    }

    public function run($userID)
    {
        if ($this->getByID($userID))
            $this->userRepository->deleteUser($userID);
    }

}