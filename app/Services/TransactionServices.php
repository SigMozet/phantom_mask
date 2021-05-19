<?php
namespace App\Services;

use App\Repository\TransactionRepo as TransactionRepo;



class TransactionServices
{
    public function __construct(TransactionRepo $repo)
    {
        $this->repo = $repo;
    }

    public function getDataById($id)
    {
        return $this->repo->getDataById($id);
    }

    public function RankUserByMaskAmount($request)
    {
        return $this->repo->RankUserByMaskAmount($request);
    }

    public function totalValue($request)
    {
        return $this->repo->totalValue($request);
    }

    public function totalMask($request)
    {
        return $this->repo->totalMask($request);
    }

    public function create($user,$phar,$mask,$amount)
    {
        return $this->repo->create($user,$phar,$mask,$amount);
    }

}