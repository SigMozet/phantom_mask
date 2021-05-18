<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\RestLaravelController;
use App\Services\MasksServices as MasksServices;
use App\Services\PharmaciesServices as PharmaciesServices;

class MasksController extends RestLaravelController
{
    public function __construct(MasksServices $service,PharmaciesServices $phar_service)
    {
        $this->service = $service;
        $this->phar_service = $phar_service;
    }
    
    /**
     * 以 名稱 搜尋口罩
     *
     * @param  mixed $mask_name
     * @return void
     */
    public function search($mask_name)
    {
        return $this->success($this->service->searchByName($mask_name));
    }

    /**
     * 編輯口罩名稱
     * @param  mixed $request
     * @return void
     */
    public function editName(Request $request)
    {
        //檢查phar_id是否存在
        $pharid_existed = $this->phar_service->getDataById($request->phar_id);
        if(!$pharid_existed->count()){
            return $this->failureCode('E0004');
        }

        //檢查mask_id是否存在
        $maskid_existed = $this->service->getDataById($request->mask_id);
        if(!$maskid_existed->count()){
            return $this->failureCode('E0005');
        }

        $edit = $this->service->editName($request);
        
        return ($edit) ? $this->success($edit) : $this->failureCode('E0003');
    }

    /**
     * 編輯口罩價格
     * @param  mixed $request
     * @return void
     */
    public function editPrice(Request $request)
    {
        //檢查phar_id是否存在
        $pharid_existed = $this->phar_service->getDataById($request->phar_id);
        if(!$pharid_existed->count()){
            return $this->failureCode('E0004');
        }

        //檢查mask_id是否存在
        $maskid_existed = $this->service->getDataById($request->mask_id);
        if(!$maskid_existed->count()){
            return $this->failureCode('E0005');
        }

        $edit = $this->service->editPrice($request);
        return ($edit) ? $this->success($edit) : $this->failureCode('E0003');
    }

    /**
     * 刪除口罩
     * @param  mixed $request
     * @return void
     */
    public function delete(Request $request)
    {
        $deleted_at = $this->service->delete($request);

        if(isset($deleted_at)){
            return $this->success('完成軟刪除，時間'.$deleted_at);
        }else{
            return $this->failureCode('E0003');
        }
    }
}
