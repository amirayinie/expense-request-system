<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseRequest;
use App\Models\ExpenseRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExpenseRequestApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request): JsonResponse
    {
         $validated = $request->validated();

        $user = User::where('national_code', $validated['national_code'])->first();

        if (!$user) {
            return response()->json([
                'message' => 'کاربری با این کد ملی یافت نشد.'
            ], 404);
        }

        $expenseRequest = ExpenseRequest::create([
            'user_id' => $user->id,
            'category' => $validated['category'],
            'description' => $validated['description'],
            'amount' => $validated['amount'],
            'sheba_number' => $validated['sheba_number'],
            'status' => 'pending',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = "attachments/{$user->national_code}/{$expenseRequest->id}";
            $storedFilePath = $file->store($path, 'public');

            $expenseRequest->update([
                'file_path' => $storedFilePath
            ]);
        }

        return response()->json([
            'message' => 'درخواست با موفقیت ثبت شد.',
            'data' => $expenseRequest->fresh()
        ], 201);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpenseRequest $expenseRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExpenseRequest $expenseRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpenseRequest $expenseRequest)
    {
        //
    }
}
