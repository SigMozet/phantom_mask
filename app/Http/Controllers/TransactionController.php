<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\RestLaravelController;
use App\Services\TransactionServices as TransactionServices;
use App\Services\UserServices as UserServices;


class TransactionController extends RestLaravelController
{
    public function __construct(TransactionServices $service, UserServices $user_service)
    {
        $this->service = $service;
        $this->user_service = $user_service;
    }

        

    /**
     * 找出指定日期中，口罩交易量最高的x位用戶
     * @param  mixed $request
     * @return void
     */
    public function RankUserByMaskAmount(Request $request)
    {
        //排序出時間內，口罩交易數量前x位user_id與數目
        $user_rank_list = $this->service->RankUserByMaskAmount($request);

        //此部分不利用whereIN整筆作查詢，SQL會自動將ID SORT掉，打亂原本的USER ID排序(依照交易量)，故改逐筆查詢並MERGE成一個ARRAY
        $user_data_array = array();
        foreach($user_rank_list as $user){
            //以USER_ID查詢USER資料
            $user_object = $this->user_service->getDataById($user->user_id);

            //查完資料後將該user的口罩交易數加入其data object
            $user_object->total_amount = $user->total_amount;

            //將每筆資料merge進準備要回傳的array
            $user_data_array = array_merge($user_data_array, array($user_object));
        }

        return $this->success($user_data_array);
    }
    
    /**
     * 指定日期中，所有交易總額
     * @param  mixed $request
     * @return void
     */
    public function TotalValueInDateRange(Request $request)
    {
        return $this->success($this->service->totalValue($request));
    }

    /**
     * 指定日期中，所有口罩交易總數
     * @param  mixed $request
     * @return void
     */
    public function MaskAmountInDateRange(Request $request)
    {
        return $this->success($this->service->totalMask($request));
    }
}
