<?php

namespace App\Services\Payment\Gateways;

use App\Services\Payment\Contracts\AbstractGatewayInterface;
use App\Services\Payment\Contracts\PayableInterface;
use App\Services\Payment\Contracts\verifiableInterface;

class Bank3Gateway extends AbstractGatewayInterface implements PayableInterface, verifiableInterface
{
  public function pay()
  {
    
  }
  public function verify()
  {
    
  } 
}