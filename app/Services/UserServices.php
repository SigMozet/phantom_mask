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

    public function editCash($id,$cash)
    {
        //更改顧客持有金額
        return $this->repo->editCash($id,$cash);
    }

}