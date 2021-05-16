<?php
namespace App\Services;

use App\Repository\MasksRepo as MasksRepo;


class MasksServices
{
    public function __construct
    (
        MasksRepo $repo
    )
    {
        $this->repo = $repo;
    }

    public function searchByName($mask_name)
    {
        //以姓名搜尋口罩
        return ($this->repo->searchByName($mask_name));
    }
}