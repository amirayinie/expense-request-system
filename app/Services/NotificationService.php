<?php

namespace App\Services;

use App\Models\ExpenseRequest;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public static function notifyRejection(ExpenseRequest $request): void
    {
        $user = $request->user;

        // ارسال ایمیل فرضی
        /*
        Mail::to($user->email)->send(new RequestRejectedMail($request));
        */

        // ارسال پیامک فرضی
        /*
        SmsService::send($user->phone, "درخواست هزینه شما با شماره پیگیری {$request->id} رد شده است.");
        */

        Log::info("نوتیفیکیشن رد شدن برای کاربر {$user->email} (درخواست {$request->id}) ارسال شد.");
    }
}
