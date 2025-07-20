@if ($errors->any())
    <div style="background-color: #fff3cd; color: #856404; padding: 1rem; border-radius: 6px; margin-bottom: 1rem;">
        <strong>⚠️ خطا در ورود اطلاعات:</strong>
        <ul style="margin-top: 0.5rem; padding-right: 1.2rem;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif