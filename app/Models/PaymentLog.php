<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    protected $fillable = ['payment_id', 'level', 'message'];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
