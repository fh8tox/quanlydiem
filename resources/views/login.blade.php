<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
    <style>
        body {
            font-family: Arial;
            background: #f2f2f2;
        }
        .login-box {
            width: 350px;
            margin: 100px auto;
            padding: 25px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }
        h2 {
            text-align: center;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
        }
        button {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
        .success {
            color: green;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Đăng nhập hệ thống</h2>

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
        <input type="email" name="email" placeholder="Nhập email">

        <label>Mật khẩu</label>
        <input type="password" name="password" placeholder="Nhập mật khẩu">

        <button type="submit">Đăng nhập</button>
    </form>
</div>

</body>
</html>