<?php

namespace App\Services\Payment\Gateways;

use App\Services\Payment\Contracts\AbstractGatewayInterface;
use App\Services\Payment\Contracts\PayableInterface;
use App\Services\Payment\Contracts\verifiableInterface;

class Bank1Gateway extends AbstractGatewayInterface implements PayableInterface, verifiableInterface
{
  public function pay()
  {
  /*  نمونه api یک درگاه پرداخت که به ما آدرس درگاه پرداخت را برمیگرداند یا در صورت وجود خطا کد و متن آن را
      $curl = curl_init();

    $data = [
    "merchant_id"=> "baa9a950-7e8d-4ae9-9868-603b3fd2a455",
    "amount"=> $this->request->getAmount,
    "callback_url"=> Route('payment.callback'),
    "description"=> "Transaction description.",
    "order_id" => $this->request->getOrderId,
    "metadata"=> [
    "mobile"=> $this->request->getMobileNumber,
    "email"=> $this->request->getEmail
  ]
    ];

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://sandbox.zarinpal.com/pg/v4/payment/request.json',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
  "merchant_id": "baa9a950-7e8d-4ae9-9868-603b3fd2a455",
  "amount": "1100",
  "callback_url": "http://example.com/verify",
  "description": "Transaction description.",
  "metadata": {
    "mobile": "09121234567",
    "email": "info.test@example.com"
  }
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Accept: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

$result = json_decode($result, true);   

          if(isset($result['error_code'])){
              throw new \InvalidArgumentException($result['error_message']);
          }

          return redirect()->away($result['link']);
    }
          */
    try {
        if (!str_starts_with($this->request->getSheba(), 'IR')) {
            throw new \Exception('شماره شبا نامعتبر است.');
        }

        // در اصل باید به روت callback برود
      return [
    'success' => true,
    'message' => 'پرداخت با موفقیت انجام شد.',
];

    } catch (\Throwable $e) {
        throw new \RuntimeException("خطای درگاه پرداخت: " . $e->getMessage());
    }

  }

  public function verify()
  {
    // متدی که باید بعد از انجام تراکنش صدا زده شده و سرویس ما تراکنش را تایید کند
    /* $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://payment.zarinpal.com/pg/v4/payment/verify.json',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
  "merchant_id": "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx",
  "amount": "1000",
  "authority": "A0000000000000000000000000000wwOGYpd"
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Accept: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

  } */

}

}