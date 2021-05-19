<?php

namespace App\Repository;

use Carbon\Carbon;
use DB;
use Illuminate\Support\Carbon as SupportCarbon;

class MasksRepo 
{
    public function getDataById($id){

        $data = DB::table('masks')
        ->where('id',$id)
        ->SELECT('id','phar_id','name','price','count','created_at','updated_at')
        ->get();

        return ($data) ? $data : null;
    }

    public function getDataByPharAndMaskID($request)
    {
        $phar_id = $request->phar_id;
        $mask_id = $request->mask_id;

        $data = DB::table('masks')
        ->where('phar_id',$phar_id)
        ->where('id',$mask_id)
        ->select('id','phar_id','name','price','created_at','updated_at')
        ->get();

        return $data;
    }

    public function getProductByPharID($phar_id)
    {

        $data = DB::table('masks')
        ->where('phar_id',$phar_id)
        ->orderBy('name','asc')
        ->get();

        return $data;
    }

    public function searchByName($mask_name)
    {

        $data = DB::table('masks')
        ->where('name','LIKE','%'.$mask_name.'%')
        ->get();

        return $data;
    }

    public function searchPharByPriceAndStock($request){

        /*  查詢藥局資料，且需符合以下條件
        /   1. A = 該藥局中販售價格介於$low 與 $high 之間的產品
        /   2. A的庫存數 必須>指定數量 或者 <指定數量
        /   最後回傳藥局ID與價格區間內的總庫存數
        */
        $low = $request->low;
        $high = $request->high;
        
        $stocks_num = $request->stocks_num;
        switch ($request->stocks_type) {
            case 'less':
                $stocks_type = '<';
                break;
            case 'more':
                $stocks_type = '>';
                break;
        }

        
        //搜尋出 口罩資料庫中符合價格區間的資料，並GROUP BY藥局ID，其中符合條件的總庫存要大於或小於條件
        $data = DB::select
        ('SELECT phar_id, SUM(count) AS stocks 
          FROM `masks` WHERE price > '.$low.' AND price < '.$high.' 
          GROUP BY phar_id 
          HAVING stocks '.$stocks_type.' '.$stocks_num
        );
        return $data;
    }

    public function editName($request){

        $updated_time = Carbon::now();

        return $data = DB::table('masks')
        ->where('id',$request->mask_id)
        ->update(['name' => $request->new_name, 'updated_at' => $updated_time]);
    }

    public function editPrice($request){

        return $data = DB::table('masks')
        ->where('id',$request->mask_id)
        ->update(['price' => $request->price]);
    }

    public function delete($request){

        $deleted_at = Carbon::now();
        $delete = DB::table('masks')
        ->where('id',$request->mask_id)
        ->where('phar_id',$request->phar_id)
        ->whereNull('deleted_at')
        ->update(['deleted_at' => $deleted_at]);

        return ($delete > 0) ? $deleted_at : null;
    }

    public function editCount($id,$count){

        $updated_time = Carbon::now();

        return $data = DB::table('masks')
        ->where('id',$id)
        ->update(['count' => $count, 'updated_at' => $updated_time]);
    }

}