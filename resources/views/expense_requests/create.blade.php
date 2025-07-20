<!-- resources/views/expense_requests/create.blade.php -->
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>ثبت درخواست هزینه</title>
    <style>
        body {
            font-family: Tahoma, sans-serif;
            direction: rtl;
            background-color: #f4f4f4;
            padding: 2rem;
        }
        .form-container {
            background-color: white;
            padding: 2rem;
            max-width: 600px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-top: 1rem;
            color: #444;
            font-weight: bold;
        }
        input, select, textarea {
            width: 100%;
            padding: 0.5rem;
            margin-top: 0.3rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            margin-top: 1.5rem;
            padding: 0.7rem 1.5rem;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .success {
            color: green;
            text-align: center;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h1>فرم ثبت درخواست هزینه</h1>

  @include('partials.alerts')
  @include('partials.validation-errors')
    <form action="{{route('expense-requests.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="national_code">کد ملی:</label>
        <input type="text" name="national_code" id="national_code" required>

        <label for="category">دسته‌بندی هزینه:</label>
        <select name="category" id="category" required>
            <option value="transport">ایاب‌ و ذهاب</option>
            <option value="equipment">خرید تجهیزات</option>
            <option value="meal">پذیرایی</option>
            <option value="other">سایر</option>
        </select>

        <label for="description">توضیحات:</label>
        <textarea name="description" id="description" rows="3" required></textarea>

        <label for="amount">مبلغ (تومان):</label>
        <input type="number" name="amount" id="amount" required>

        <label for="file">فایل پیوست:</label>
        <input type="file" name="file" id="file" required>

        <label for="sheba_number">شماره شبا:</label>
        <input type="text" name="sheba_number" id="sheba_number" required>

        <button type="submit">ثبت درخواست</button>
    </form>
</div>

</body>
</html>
