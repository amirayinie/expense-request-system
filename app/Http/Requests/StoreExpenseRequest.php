<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreExpenseRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public const CATEGORIES = ['transport', 'equipment', 'meal', 'other'];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        
        return [
        'national_code' => 'required|string|size:10',
        'category' => ['required', Rule::in(self::CATEGORIES)],
        'description' => 'required|string',
        'amount' => 'required|integer|min:1000',
        'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'sheba_number' => 'required|string|starts_with:IR|min:26|max:34',
        ];
    }
}