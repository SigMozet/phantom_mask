<?php

namespace App\Repository;

use Carbon\Carbon;
use DB;

class PharmaciesRepo 
{

    public function getDataByIdArray($id_array){

        $data = DB::table('pharmacies')
        ->whereIn('id',$id_array)
        ->get();

        return ($data) ? $data : null;
    }
}