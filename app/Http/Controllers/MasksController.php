<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MasksServices as MasksServices;

class MasksController extends Controller
{
    public function __construct(MasksServices $service)
    {
        $this->service = $service;
    }
    
    /**
     * 以 名稱 搜尋口罩
     *
     * @param  mixed $mask_name
     * @return void
     */
    public function search($mask_name)
    {
        return $this->service->searchByName($mask_name);
    }
}
