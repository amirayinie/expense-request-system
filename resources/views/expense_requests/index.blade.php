<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>کارتابل بررسی درخواست‌ها</title>
    <style>
        body {
            font-family: Tahoma, sans-serif;
            direction: rtl;
            background-color: #f9f9f9;
            padding: 2rem;
        }
        .container {
            max-width: 960px;
            margin: auto;
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 0.6rem;
            text-align: center;
        }
        th {
            background-color: #eee;
        }
        .actions {
            margin-top: 1.5rem;
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        select, input[type="text"], button {
            padding: 0.5rem;
            border-radius: 4px;
            border: 1px solid #aaa;
        }
        button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #388e3c;
        }
        .download-link {
            text-decoration: none;
            color: #2196f3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>کارتابل بررسی درخواست‌های هزینه</h2>

    @include('partials.alerts')
    @include('partials.validation-errors')
    <form action="{{ route('expense-requests.groupUpdate') }}" method="POST">
    @csrf
    <table>
        <thead>
            <tr>
                <th>نام</th>
                <th>کد ملی</th>
                <th>مبلغ</th>
                <th>عملیات</th>
                <th>دلیل رد</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pendingRequests as $request)
                <tr>
                    <td>{{ $request->user->name }}</td>
                    <td>{{ $request->user->national_code }}</td>
                    <td>{{ number_format($request->amount) }} تومان</td>
                    <td>
                        <select name="actions[{{ $request->id }}]">
                            <option value="">-- انتخاب کنید --</option>
                            <option value="approve">تأیید</option>
                            <option value="reject">رد</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="reasons[{{ $request->id }}]" placeholder="در صورت رد شدن">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <button type="submit">اجرای عملیات</button>
</form>


</div>


</body>
</html>
