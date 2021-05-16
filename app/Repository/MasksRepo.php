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

}