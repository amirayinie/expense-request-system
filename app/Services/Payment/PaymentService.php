<?php

namespace App\Services\Payment;

use App\Services\Payment\Contracts\RequestInterface;
use App\Services\Payment\Exceptions\GatewayNotFoundException;
use App\Services\Payment\Requests\PayRequest;

class PaymentService 
{
    public function __construct(
        private string $GatewayName,
        private PayRequest $request
    ) {}

    public function pay()
    {
            $gateway = $this->findGateway();
            return $gateway->pay();
    }

    private function findGateway()
    {
        $className = 'App\Services\Payment\Gateways\\' . $this->GatewayName;

        if (!class_exists($className)) {
            throw new GatewayNotFoundException('درگاه پرداخت انتخاب شده وجود ندارد');
        }

        return new $className($this->request);
    }
}
