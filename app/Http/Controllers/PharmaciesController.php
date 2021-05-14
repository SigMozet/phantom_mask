<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PharmaciesServices as PharmaciesServices;


class PharmaciesController extends Controller
{
    public function __construct(PharmaciesServices $service)
    {
        $this->service = $service;
    }

    public function checkOpenAtTime(Request $request)
    {
        return $this->service->checkOpenAtTime($request);
    }

    public function checkOpenOnDay(Request $request)
    {
        return $this->service->checkOpenOnDay($request);
    }
}
