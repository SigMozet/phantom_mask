<?php
namespace App\Services;

use App\Repository\PharmaciesRepo as PharmaciesRepo;
use App\Repository\BusinessRepo as BusinessRepo;
use App\Repository\MasksRepo as MasksRepo;


class PharmaciesServices
{
    public function __construct
    (
        PharmaciesRepo $repo,
        BusinessRepo $business_repo,
        MasksRepo $masks_repo
    )
    {
        $this->repo = $repo;
        $this->business_repo = $business_repo;
        $this->masks_repo = $masks_repo;
    }

    public function getDataById($id)
    {
        return ($this->repo->getDataById($id)); 
    }

    public function checkOpenAtTime($request)
    {
        $day_of_week = $request->day;
        $time = $request->time;
        //先查詢星期幾與指定時間有營業之藥局id
        $phar_open = $this->business_repo->getByDowAndTime($day_of_week,$time);
    
        //藥局id存成array
        $id_array = array();
        foreach($phar_open as $phar_open){
            array_push($id_array,$phar_open->phar_id);
        }

        //以id撈藥局資料
        return ($this->repo->getDataByIdArray($id_array)); 
    }

    public function checkOpenOnDay($request)
    {
        $day_of_week = $request->day;
        //先查詢指定星期幾有營業之藥局id
        $phar_open = $this->business_repo->getByDow($day_of_week);
        
        //藥局id存成array
        $id_array = array();
        foreach($phar_open as $phar_open){
            array_push($id_array,$phar_open->phar_id);
        }

        //以id撈藥局資料
        return ($this->repo->getDataByIdArray($id_array));
    }

    public function getProductByPharID($phar_id)
    {
        //以id撈藥局資料
        return ($this->masks_repo->getProductByPharID($phar_id));
    }

    public function searchByName($phar_name)
    {
        //以姓名搜尋藥局
        return ($this->repo->searchByName($phar_name));
    }

    public function searchByPriceAndStock($request)
    {
        //以 價格範圍、庫存數 搜尋藥局
        $filterd_phar =  ($this->masks_repo->searchPharByPriceAndStock($request));
        /*
        $filterd_phar =
        {
            "phar_id": 2,
            "stocks": "30"
        },
        {
            "phar_id": 9,
            "stocks": "20"
        },
        */
        //將所有符合條件的phar_id存成陣列
        $phar_id_array = array();
        foreach($filterd_phar as $key=>$value){
            array_push($phar_id_array,$value->phar_id);
        }

        //以phar_id查符合條件的藥局資料，並將每筆藥局資料附上他所擁有的庫存數
        $phar_data = ($this->repo->getDataByIdArray($phar_id_array));
        foreach($phar_data as $key => $value){
            $value->stocks_in_price_range = $filterd_phar[$key]->stocks;
        }
        return $phar_data;
    }

    public function editName($id,$name)
    {
        //編輯藥局姓名
        $edit =  $this->repo->editName($id,$name);

        //回傳編輯後的藥局資料
        return $this->repo->getDataById($id);
    }
}