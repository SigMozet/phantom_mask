<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\RestLaravelController;
use App\Services\TransactionServices as TransactionServices;
use App\Services\UserServices as UserServices;
use App\Services\MasksServices as MasksServices;
use App\Services\PharmaciesServices as PharmaciesServices;




class TransactionController extends RestLaravelController
{
    public function __construct
    (
        TransactionServices $service, 
        UserServices $user_service,
        MasksServices $mask_service,
        PharmaciesServices $phar_service
    )
    {
        $this->service = $service;
        $this->user_service = $user_service;
        $this->mask_service = $mask_service;
        $this->phar_service = $phar_service;
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

    /**
     * 執行交易
     * @param  mixed $request
     * @return void
     */
    public function transaction(Request $request)
    {
        $phar_id = $request->phar_id;
        $mask_id = $request->mask_id;
        $user_id = $request->user_id;

        //檢查phar_id是否存在
        $pharid_existed = $this->phar_service->getDataById($phar_id);
        if(!$pharid_existed->count()){
            return $this->failureCode('E0004');
        }

        //檢查mask_id是否存在
        $maskid_existed = $this->mask_service->getDataById($mask_id);
        if(!$maskid_existed->count()){
            return $this->failureCode('E0005');
        }

        //檢查user_id是否存在
        $userid_existed = $this->user_service->getDataById($user_id);
        if(is_null($userid_existed)){
            return $this->failureCode('E0006');
        }

        //檢查藥局是否有該口罩
        $maskid_existed = $this->mask_service->getDataByPharAndMaskID($request);
        if(!$maskid_existed->count()){
            return $this->failureCode('E0007');
        }


        //藥局持有金額
        $phar_object = $this->phar_service->getDataById($phar_id);
        $phar_cash = $phar_object[0]->cashBalance;

        //交易金額
        $mask_object = $this->mask_service->getDataById($mask_id);
        $mask_price = $mask_object[0]->price;
        $mask_count = $mask_object[0]->count;

        //顧客持有金額
        $user_object = $this->user_service->getDataById($user_id);
        $user_cash = $user_object->cashBalance;

        if($mask_count<=0){
            return $this->failureCode('E0008');
        }
        if($user_cash < $mask_price){
            return $this->failureCode('E0009');
        }

        //交易後金額
        $phar_cash += $mask_price;
        $user_cash -= $mask_price;

        //更新交易後金額及口罩庫存
        $phar_edit = $this->phar_service->editCash($phar_id,$phar_cash);
        $user_edit = $this->user_service->editCash($user_id,$user_cash);

        $mask_count-=1;
        $mask_edit = $this->mask_service->editCount($mask_id,$mask_count);

        //將交易寫入資料庫
        $transaction_id = $this->service->create($user_id,$phar_id,$mask_id,$mask_price);
        return $this->success($this->service->getDataById($transaction_id));


    }
}
