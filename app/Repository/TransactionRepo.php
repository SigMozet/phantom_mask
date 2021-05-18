<?php

namespace App\Repository;

use Carbon\Carbon;
use DB;

class TransactionRepo 
{
    public function RankUserByMaskAmount($request)
    {
        $top_x = $request->top_x;
        $start_at = $request->start_at;
        $end_at = $request->end_at;

        //指定期間內，依照口罩交易數量由高到低排序USER
        $data = DB::select
        ('SELECT SUM(masks.number_per_packs) as total_amount,transaction.user_id FROM `transaction`
                INNER JOIN masks
                ON transaction.masks_id = masks.id
          WHERE transactionDate BETWEEN \''.$start_at.'\' AND \''.$end_at.'\'
          GROUP BY(transaction.user_id)
          ORDER BY total_amount desc LIMIT '.$top_x
        );

        return $data;
    }

    public function totalValue($request)
    {
        $total_amount = DB::table('transaction')
        ->whereBetween('transactionDate',[$request->start_at,$request->end_at])
        ->sum('transactionAmount');

        return number_format($total_amount,2);
    }

    public function totalMask($request)
    {
        return DB::table('transaction')
        ->join('masks', 'masks.id', '=' , 'transaction.masks_id')
        ->whereBetween('transactionDate',[$request->start_at,$request->end_at])
        ->sum('masks.number_per_packs');
    }
}