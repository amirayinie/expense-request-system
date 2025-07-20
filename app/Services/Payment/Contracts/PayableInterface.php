<?php
namespace App\Services\Payment\Contracts;

interface PayableInterface
{
    /**
     * Process the payment.
     *
     * @return mixed
     */
    public function pay();
} 