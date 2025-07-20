<?php

namespace App\Services\Payment\Contracts;

use App\Services\Payment\Requests\PayRequest;

abstract class AbstractGatewayInterface
{
    public function __construct(protected PayRequest $request) {

    }
}