<?php

namespace App\Repository;

use Carbon\Carbon;
use DB;

class BusinessRepo 
{
    public function getByDowAndTime($day_of_week,$time)
    {

        $data = DB::table('business_hours')
        ->where('day',$day_of_week)
        ->where('start_time','<',$time)
        ->where('end_time','>',$time)
        ->get();

        return $data;
    }

    public function getByDow($day_of_week)
    {

        $data = DB::table('business_hours')
        ->where('day',$day_of_week)
        ->select('phar_id')->distinct()
        ->get();

        return $data;
    }
}