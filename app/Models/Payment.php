<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'expense_request_id', 'status', 'bank_code',
        'tracking_code', 'error_message', 'paid_at'
    ];

    public function expenseRequest()
    {
        return $this->belongsTo(ExpenseRequest::class);
    }

    public function logs()
    {
        return $this->hasMany(PaymentLog::class);
    }
}
