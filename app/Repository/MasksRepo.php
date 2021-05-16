<?php

namespace App\Repository;

use Carbon\Carbon;
use DB;

class MasksRepo 
{
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



        $data = DB::select
        ('SELECT DISTINCT(phar_id), sub.stocks FROM masks
            INNER JOIN 
                (SELECT phar_id AS PID ,SUM(count) AS stocks 
                FROM `masks` 
                WHERE price > '.$low.' AND price < '.$high.' 
                GROUP BY phar_id) AS sub
          WHERE phar_id = sub.PID AND sub.stocks'.$stocks_type.' '.$stocks_num);
        return $data;
    }

}