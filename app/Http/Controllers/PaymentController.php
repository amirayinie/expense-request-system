<?php

namespace App\Http\Controllers;

use App\Models\ExpenseRequest;
use App\Models\Payment;
use App\Models\PaymentLog;
use App\Services\Payment\Exceptions\GatewayNotFoundException;
use App\Services\Payment\PaymentService;
use App\Services\Payment\Requests\PayRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function index()
    {
        $approvedRequests = ExpenseRequest::with('user')
            ->where('status', 'approved')
            ->where('is_paid',false)
            ->get();

        return view('payments.index', compact('approvedRequests'));
    }

    public function manualPay(Request $request)
    {
        $id = $request->input('request_id');
        $expense = ExpenseRequest::findOrFail($id);

        $prefix = substr($expense->sheba_number, 2, 2);
        $map = [
            '12' => 'bank1',
            '22' => 'bank2',
            '33' => 'bank3',
        ];

        // ثبت رکورد اولیه پرداخت
        $payment = Payment::create([
            'expense_request_id' => $expense->id,
            'status' => 'failed',
            'bank_code' => $prefix,
        ]);

        // بررسی وجود درگاه مربوطه
        if (!isset($map[$prefix])) {
            PaymentLog::create([
                'payment_id' => $payment->id,
                'expense_request_id' => $expense->id,
                'status' => 'failed',
                'message' => "بانکی با کد $prefix تعریف نشده",
            ]);

            return back()->withErrors(['payment' => 'بانک انتخاب‌شده پشتیبانی نمی‌شود.']);
        }

        try {
            // آماده‌سازی درخواست
            $config = config("payment.gateways.{$map[$prefix]}");

            $payRequest = new PayRequest([
                'user' => $expense->user_id,
                'amount' => $expense->amount,
                'expenseRequetsId' => $expense->id,
                'sheba' => $expense->sheba_number,
                'apiKey' => $config['api_key'],
            ]);

            // اجرای پرداخت
            $paymentService = new PaymentService($config['name'], $payRequest);
            $result = $paymentService->pay();

            // موفقیت: به‌روزرسانی وضعیت‌ها
            $payment->update(['status' => 'success']);
            $expense['is_paid']= true; 
            $expense->save();

            PaymentLog::create([
                'payment_id' => $payment->id,
                'expense_request_id' => $expense->id,
                'status' => 'success',
                'message' => $result['message'] ?? 'پرداخت با موفقیت انجام شد.',
            ]);

            return redirect()->route('payments.index')->with('success', $result['message'] ?? 'پرداخت موفق بود.');

        } catch (\Throwable $e) {
            PaymentLog::create([
                'payment_id' => $payment->id,
                'expense_request_id' => $expense->id,
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);

            return back()->withErrors(['payment' => 'خطا در عملیات پرداخت: ' . $e->getMessage()]);
        }
    }

    public function callback(Request $request)
    {
        // در صورت نیاز در فاز توسعه‌ی واقعی برای verify
        // می‌توان اطلاعات بازگشتی را ثبت و تراکنش را تایید کرد.
    }
}
