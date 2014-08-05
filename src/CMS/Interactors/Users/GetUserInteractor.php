<?php

namespace CMS\Interactors\Users;

use CMS\Repositories\UserRepositoryInterface;
use CMS\UseCases\Users\GetUserUseCase;

class GetUserInteractor implements GetUserUseCase
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getByID($userID)
    {
        $userStructure = $this->userRepository->findByID($userID);

        if (!$userStructure)
            throw new \Exception('The user was not found');

        return $userStructure;
    }

}