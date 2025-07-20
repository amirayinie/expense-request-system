<?php

namespace App\Services\Payment\Requests;

use App\Services\Payment\Contracts\RequestInterface;
use Symfony\Component\VarDumper\Exception\ThrowingCasterException;

class PayRequest implements RequestInterface
{ 
    private $expenseRequetsId;
    private $user;
    private $amount;
    private $sheba;
    private $apiKey;
    

public function __construct(array $data){
    $this->expenseRequetsId= $data['expenseRequetsId'];
    $this->user= $data['user'];
    $this->amount= $data['amount'];
    $this->sheba = $data['sheba'];
    $this->apiKey = $data['apiKey'] ;
}

public function getUser()
{
    return $this->user;
}

public function getAmount()
{
    return $this->amount;
}
public function getExpenseRequetsId()
{
    return $this->expenseRequetsId;
}

public function getSheba()
{
    return $this->sheba;
}

public function getApiKey()
{
    return $this->apiKey;
}


}