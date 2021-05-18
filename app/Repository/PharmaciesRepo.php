<?php

namespace App\Repository;

use Carbon\Carbon;
use DB;

class PharmaciesRepo 
{

    public function getDataById($id){

        $data = DB::table('pharmacies')
        ->where('id',$id)
        ->SELECT('id','name','cashBalance','created_at','updated_at')
        ->get();

        return ($data) ? $data : null;
    }

    public function getDataByIdArray($id_array){

        $data = DB::table('pharmacies')
        ->whereIn('id',$id_array)
        ->SELECT('id','name','cashBalance')
        ->get();

        return ($data) ? $data : null;
    }

    public function searchByName($phar_name){

        $data = DB::table('pharmacies')
        ->where('name','LIKE','%'.$phar_name.'%')
        ->get();

        return ($data) ? $data : null;
    }

    public function editName($id,$name){

        $updated_at = Carbon::now();

        return $data = DB::table('pharmacies')
        ->where('id',$id)
        ->update(
            [
                'name' => $name,
                'updated_at' => $updated_at
            ]);
    }
}