<?php

namespace App\Repository;

use Carbon\Carbon;
use DB;

class UserRepo 
{
    public function getDataById($id)
    {
        $data = DB::table('user')
        ->where('id',$id)
        ->select('id','name','cashBalance','created_at')
        ->first();
        return $data;
    }

    public function editCash($id,$cash){

        $updated_at = Carbon::now();

        return $data = DB::table('user')
        ->where('id',$id)
        ->update(
            [
                'cashBalance' => $cash,
                'updated_at' => $updated_at
            ]);
    }
}