<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\RestLaravelController;
use App\Services\PharmaciesServices as PharmaciesServices;


class PharmaciesController extends RestLaravelController
{
    public function __construct(PharmaciesServices $service)
    {
        $this->service = $service;
    }
    
    /**
     * 查詢 某天某時 有營業的藥局
     * @param  mixed $request
     * @return void
     */
    public function checkOpenAtTime(Request $request)
    {
        return $this->success($this->service->checkOpenAtTime($request));
    }
    
    /**
     * 查詢 某天 有營業的藥局
     * @param  mixed $request
     * @return void
     */
    public function checkOpenOnDay($day_of_week)
    {
        return $this->success($this->service->checkOpenOnDay($day_of_week));
    }

    /**
     * 查詢 指定藥局 販售的商品
     * @param  mixed $phar_id
     * @return void
     */
    public function getProduct($phar_id)
    {
        return $this->success($this->service->getProductByPharID($phar_id));
    }

    /**
     * 以 名稱 搜尋藥局
     * @param  mixed $phar_name
     * @return void
     */
    public function search($phar_name)
    {
        return $this->success($this->service->searchByName($phar_name));
    }

    /**
     * 以 價格範圍、庫存數 搜尋藥局
     * @param  mixed $request
     * @return void
     */
    public function searchByPriceAndStock(Request $request)
    {
        return $this->success($this->service->searchByPriceAndStock($request));
    }

    /**
     * 編輯藥局名稱
     * @param  mixed $request
     * @return void
     */
    public function editName(Request $request)
    {
        $phar_id = $request->id;
        $new_name = $request->name;

        //檢查phar_id是否存在
        $pharid_existed = $this->service->getDataById($phar_id);
        if(!$pharid_existed->count()){
            return $this->failureCode('E0004');
        }

        $edit = $this->service->editName($phar_id,$new_name);

        return ($edit) ? $this->success($edit) : $this->failureCode('E0003');
    }
}
