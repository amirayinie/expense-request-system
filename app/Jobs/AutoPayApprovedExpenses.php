<?php

namespace App\Jobs;

use App\Models\ExpenseRequest;
use App\Models\Payment;
use App\Models\PaymentLog;
use App\Services\Payment\Exceptions\GatewayNotFoundException;
use App\Services\Payment\PaymentService;
use App\Services\Payment\Requests\PayRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AutoPayApprovedExpenses
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
            Log::info('Job started');

        $requests = ExpenseRequest::with('user')
            ->where('status', 'approved')
            ->where('is_paid', false)
            ->get();

        foreach ($requests as $expense) {
            $prefix = substr($expense->sheba_number, 2, 2);
            $map = [
                '12' => 'bank1',
                '22' => 'bank2',
                '33' => 'bank3',
            ];

            $payment = Payment::create([
                "expense_request_id" => $expense->id,
                "status" => 'failed',
                "bank_code" => $prefix
            ]);

            if (!isset($map[$prefix])) {
                PaymentLog::create([
                    'payment_id' => $payment->id,
                    'expense_request_id' => $expense->id,
                    'status' => 'failed',
                    'message' => "بانکی با کد $prefix تعریف نشده.",
                ]);
                continue;
            }

            try {
                $config = config("payment.gateways.{$map[$prefix]}");

                $payRequest = new PayRequest([
                    'user' => $expense->user_id,
                    'amount' => $expense->amount,
                    'expenseRequetsId' => $expense->id,
                    'sheba' => $expense->sheba_number,
                    'apiKey' => $config['api_key'],
                ]);

                $paymentService = new PaymentService($config['name'], $payRequest);
                $result = $paymentService->pay();

                if ($result['success']) {
                    $expense->is_paid = true;
                    $expense->save();

                    $payment->update(['status' => 'success']);

                    PaymentLog::create([
                        'payment_id' => $payment->id,
                        'expense_request_id' => $expense->id,
                        'status' => 'success',
                        'message' => $result['message'],
                    ]);
                } else {
                    $payment->update(['status' => 'error']);
                    PaymentLog::create([
                        'payment_id' => $payment->id,
                        'expense_request_id' => $expense->id,
                        'status' => 'error',
                        'message' => $result['message'] ?? 'نامشخص',
                    ]);
                }

            } catch (\Throwable $e) {
                $payment->update(['status' => 'error']);
                PaymentLog::create([
                    'payment_id' => $payment->id,
                    'expense_request_id' => $expense->id,
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ]);
            }
        }
    }
}
