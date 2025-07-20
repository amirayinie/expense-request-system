<!-- resources/views/payments/index.blade.php -->
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>پرداخت‌های تایید شده</title>
    <style>
        body {
            font-family: Tahoma;
            background-color: #f8f9fa;
            padding: 2rem;
            direction: rtl;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 8px rgba(0,0,0,0.05);
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #f1f1f1;
        }
        form {
            margin: 0;
        }
        button {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    @include('partials.alerts')
    @include('partials.validation-errors')
    <h2>لیست درخواست‌های تایید شده برای پرداخت</h2>

    <table>
        <thead>
            <tr>
                <th>شناسه</th>
                <th>نام کاربر</th>
                <th>کد ملی</th>
                <th>مبلغ</th>
                <th>شماره شبا</th>
                <th>وضعیت</th>
                <th>پرداخت دستی</th>
            </tr>
        </thead>
        <tbody>
            @forelse($approvedRequests as $req)
                <tr>
                    <td>{{ $req->id }}</td>
                    <td>{{ $req->user->name }}</td>
                    <td>{{ $req->user->national_code }}</td>
                    <td>{{ number_format($req->amount) }} تومان</td>
                    <td>{{ $req->sheba_number }}</td>
                    <td>{{ __("statuses.$req->status") }}</td>
                    <td>
                        <form action="{{ route('payments.manual') }}" method="POST">
                            @csrf
                            <input type="hidden" name="request_id" value="{{ $req->id }}">
                            <button type="submit">پرداخت</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">درخواستی برای پرداخت وجود ندارد.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
