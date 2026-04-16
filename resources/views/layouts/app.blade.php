<!DOCTYPE html>
<html>
<head>
    <title>Quản lý sinh viên</title>

    <!-- SELECT2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        body {
            margin: 0;
            font-family: Arial;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 220px;
            background: #2c3e50;
            color: white;
            padding: 20px;
        }

        .sidebar h3 {
            margin-bottom: 20px;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .sidebar a:hover {
            background: #34495e;
        }

        /* Content */
        .content {
            flex: 1;
            padding: 20px;
            background: #f5f6fa;
        }

        .topbar {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }

        .logout {
            color: red;
        }

        /* đẹp hơn select */
        .select2-container {
            width: 300px !important;
        }
    </style>
</head>

<body>

@php
    $user = Auth::user();
@endphp

<div class="container">

    <!-- SIDEBAR -->
    <div class="sidebar">

        <h3>
            @if($user)
                🎓 {{ ucfirst($user->role) }}
            @endif
        </h3>

        @if($user)

            @if($user->role === 'admin')
                <a href="/admin">Dashboard</a>
                <a href="/users">Tài khoản</a>
                <a href="/students">Sinh viên</a>
                <a href="/departments">Khoa</a>
                <a href="/subjects">Môn học</a>
                <a href="{{ route('scores.index') }}">Điểm</a>
                <a href="/classes">Lớp</a>
            @endif

            @if($user->role === 'teacher')
                <a href="/teacher">Dashboard</a>
                <a href="/students">Xem sinh viên</a>
                <a href="{{ route('scores.index') }}">Nhập điểm</a>
            @endif

            @if($user->role === 'student')
                <a href="/student">Dashboard</a>
                <a href="/student/my-scores">Xem điểm</a>
            @endif

        @endif

        <hr>
        <a href="/logout">Đăng xuất</a>

    </div>

    <!-- CONTENT -->
    <div class="content">
        <div class="topbar"></div>

        @yield('content')
    </div>

</div>

</body>
</html>