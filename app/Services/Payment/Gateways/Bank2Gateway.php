<?php

namespace App\Services\Payment\Gateways;

use App\Services\Payment\Contracts\AbstractGatewayInterface;
use App\Services\Payment\Contracts\PayableInterface;
use App\Services\Payment\Contracts\verifiableInterface;
use Illuminate\Routing\Route;

class Bank2Gateway extends AbstractGatewayInterface implements PayableInterface, verifiableInterface
{
  public function pay()
  {
    
  }
  public function verify()
  {
    
  } 
}