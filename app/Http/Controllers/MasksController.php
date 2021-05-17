<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\RestLaravelController;
use App\Services\MasksServices as MasksServices;

class MasksController extends RestLaravelController
{
    public function __construct(MasksServices $service)
    {
        $this->service = $service;
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
        $edit = $this->service->editName($request);
        return ($edit>0) ? $this->success('編輯'.$edit.'筆資料') : $this->failureCode('E0003');
    }

    /**
     * 編輯口罩價格
     * @param  mixed $request
     * @return void
     */
    public function editPrice(Request $request)
    {
        $edit = $this->service->editPrice($request);
        return ($edit>0) ? $this->success('編輯'.$edit.'筆資料') : $this->failureCode('E0003');
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
