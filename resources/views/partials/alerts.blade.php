@if(session('success'))
    <div style="
        background-color: #e6fff2;
        color: #1a7f5a;
        padding: 1rem 1.5rem;
        border: 1px solid #b2f0d4;
        border-left: 5px solid #1a7f5a;
        border-radius: 6px;
        margin-bottom: 1rem;
        font-size: 15px;
    ">
        ✅ {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div style="
        background-color: #ffe6e6;
        color: #cc0000;
        padding: 1rem 1.5rem;
        border: 1px solid #f5b5b5;
        border-left: 5px solid #cc0000;
        border-radius: 6px;
        margin-bottom: 1rem;
        font-size: 15px;
    ">
        ❌ {{ session('error') }}
    </div>
@endif

