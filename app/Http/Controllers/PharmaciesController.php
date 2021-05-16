<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PharmaciesServices as PharmaciesServices;


class PharmaciesController extends Controller
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
        return $this->service->checkOpenAtTime($request);
    }
    
    /**
     * 查詢 某天 有營業的藥局
     * @param  mixed $request
     * @return void
     */
    public function checkOpenOnDay(Request $request)
    {
        return $this->service->checkOpenOnDay($request);
    }

    /**
     * 查詢 指定藥局 販售的商品
     * @param  mixed $phar_id
     * @return void
     */
    public function getProduct($phar_id)
    {
        return $this->service->getProductByPharID($phar_id);
    }

    /**
     * 以 名稱 搜尋藥局
     * @param  mixed $phar_name
     * @return void
     */
    public function search($phar_name)
    {
        return $this->service->searchByName($phar_name);
    }
}
