<?php
namespace App\Services;

use App\Repository\PharmaciesRepo as PharmaciesRepo;
use App\Repository\BusinessRepo as BusinessRepo;


class PharmaciesServices
{
    public function __construct
    (
        PharmaciesRepo $repo,
        BusinessRepo $business_repo
    )
    {
        $this->repo = $repo;
        $this->business_repo = $business_repo;
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
}