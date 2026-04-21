<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #3498db, #6dd5fa);
        }

        .login-box {
            width: 360px;
            padding: 30px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            animation: fadeIn 0.4s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px);}
            to { opacity: 1; transform: translateY(0);}
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: 600;
            color: #2c3e50;
        }

        label {
            font-size: 14px;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 10px 12px;
            margin-top: 5px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            transition: 0.2s;
        }

        input:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 5px rgba(52,152,219,0.3);
        }

        button {
            width: 100%;
            padding: 12px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 500;
            transition: 0.2s;
        }

        button:hover {
            background: #2980b9;
        }

        .error {
            background: #ffe6e6;
            color: #e74c3c;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .success {
            background: #eafaf1;
            color: #27ae60;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
            font-size: 14px;
        }

        ul {
            padding-left: 18px;
            margin: 0;
        }
    </style>
</head>
<body>

<div class="login-box">

    <h2>🔐 Đăng nhập</h2>

    {{-- Thông báo --}}
    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    {{-- Lỗi validate --}}
    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf

        <label>Email</label>
        <input type="email" name="email" placeholder="Nhập email" value="{{ old('email') }}">

        <label>Mật khẩu</label>
        <input type="password" name="password" placeholder="Nhập mật khẩu">

        <button type="submit">Đăng nhập</button>
    </form>

</div>

</body>
</html>