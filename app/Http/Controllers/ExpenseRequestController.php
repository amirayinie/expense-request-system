<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Models\ExpenseRequest;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpenseRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pendingRequests = ExpenseRequest::with('user')
        ->where('status', 'pending')->get();
    return view('expense_requests.index', compact('pendingRequests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('expense_requests.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request)
    {
        $validated = $request->validated();
        $user = User::where('national_code', $validated['national_code'])->first();

        if (!$user) {
        return back()->withErrors(['national_code' => 'کاربری با این کد ملی یافت نشد.'])->withInput();
        }
        $prefix = substr($validated->sheba_number, 2, 2);
        $map = [
            '12' => 'bank1',
            '22' => 'bank2',
            '33' => 'bank3',
        ];
        if (!isset($map[$prefix])){
            return back()->with('error','شماره شبای وارد شده متعلق به بانک تعریف شده ای نیست');
        }

    $storedRequest = ExpenseRequest::create([
    'user_id' => $user->id,
    'category' => $validated['category'],
    'description' => $validated['description'],
    'amount' => $validated['amount'],
    'sheba_number' => $validated['sheba_number'],
    'status' => 'pending',
    ]);
    
    if ($request->hasFile('file')) {
    $file = $request->file('file');
    $nationalCode = $user->national_code;
    $path = "attachments/{$nationalCode}/{$storedRequest->id}";
    $storedFilePath = $file->store($path, 'public');

    $storedRequest->update([
        'file_path' => $storedFilePath,
    ]);
}

    if(!$storedRequest) {
    return back()->with('error', 'خطا در ثبت درخواست');
}
    else{
    return back()->with('success', 'درخواست با موفقیت ثبت شد');  
}
    }



    /**
     * Display the specified resource.
     */
    public function show(ExpenseRequest $expenseRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExpenseRequest $expenseRequest)
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



    public function download($id)
{
    $request = ExpenseRequest::findOrFail($id);

    if (!$request->file_path || !Storage::disk('public')->exists($request->file_path)) {
        abort(404, 'فایل یافت نشد.');
    }
    return response()->download(storage_path('app/public/'.$request->file_path));
}


    public function groupUpdate(Request $request)
{
    $actions = $request->input('actions', []);
    $reasons = $request->input('reasons', []);

    foreach ($actions as $id => $action) {
    $expense = ExpenseRequest::find($id);
    if (!$expense || !in_array($action, ['approve', 'reject'])) {
        continue;
    }

    if ($action === 'reject') {
        $expense->status = 'rejected';
        $expense->rejection_reason = $reasons[$id] ?? null;
        NotificationService::notifyRejection($expense);
    } else {
        $expense->status = 'approved';
        $expense->rejection_reason = null;
    }

    $expense->save();
}


    return back()->with('success', 'درخواست‌ها با موفقیت بروزرسانی شدند.');
}

}
