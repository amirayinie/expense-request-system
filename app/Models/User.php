<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $fillable = ['name','email','national_code'];

    public function expenseRequest(){

        return $this->hasMany(ExpenseRequest::class);
    }
}
