<?php
namespace App\Services;

use App\Repository\UserRepo as UserRepo;



class UserServices
{
    public function __construct(UserRepo $repo)
    {
        $this->repo = $repo;
    }

    public function getDataById($id)
    {
        return $this->repo->getDataById($id);
    }

}