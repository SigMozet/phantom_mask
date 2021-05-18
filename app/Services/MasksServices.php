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

    public function getDataById($mask_name)
    {
        return ($this->repo->getDataById($mask_name));
    }

    public function searchByName($mask_name)
    {
        //以姓名搜尋口罩
        return ($this->repo->searchByName($mask_name));
    }

    public function editName($request)
    {
        //編輯口罩名稱
        $edit = $this->repo->editName($request);

        return $this->repo->getDataByPharAndMaskID($request);

    }

    public function editPrice($request)
    {
        //編輯口罩價格
        $edit = $this->repo->editPrice($request);

        return $this->repo->getDataByPharAndMaskID($request);
    }

    public function delete($request)
    {
        //刪除口罩
        return ($this->repo->delete($request));
    }
}