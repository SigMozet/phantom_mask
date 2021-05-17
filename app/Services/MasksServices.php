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

    public function editName($mask_name)
    {
        //編輯口罩名稱
        return ($this->repo->editName($mask_name));
    }

    public function editPrice($mask_name)
    {
        //編輯口罩價格
        return ($this->repo->editPrice($mask_name));
    }

    public function delete($mask_name)
    {
        //刪除口罩
        return ($this->repo->delete($mask_name));
    }
}