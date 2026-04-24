<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý sinh viên</title>

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            margin: 0;
            background: #f4f6f9;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 240px;
            background: linear-gradient(180deg, #2c3e50, #1a252f);
            color: #fff;
            padding: 20px;
            transition: 0.3s;
            overflow: hidden;
        }

        /* 🔥 thu gọn */
        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar h3 {
            margin-bottom: 25px;
            font-weight: 600;
        }

        .sidebar.collapsed h3 span {
            display: none;
        }

        /* 🔥 nút toggle */
        .menu-toggle {
            cursor: pointer;
            background: #1abc9c;
            padding: 10px;
            border-radius: 6px;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .menu-toggle:hover {
            background: #16a085;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 10px 12px;
            margin-bottom: 8px;
            color: #ecf0f1;
            text-decoration: none;
            border-radius: 6px;
            transition: 0.2s;
        }

        .sidebar a:hover {
            background: #34495e;
        }

        .sidebar a span {
            margin-left: 10px;
        }

        /* 🔥 ẩn text khi thu gọn */
        .sidebar.collapsed a span {
            display: none;
        }

        /* ===== CONTENT ===== */
        .content {
            flex: 1;
            padding: 20px 30px;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            background: #fff;
            padding: 10px 20px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        .topbar .user {
            font-weight: 500;
        }

        .logout {
            color: red;
            text-decoration: none;
            font-weight: 500;
        }

        /* ===== CARD ===== */
        .card {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
        }

        /* ===== BUTTON ===== */
        .btn {
            padding: 8px 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-primary {
            background: #3498db;
            color: #fff;
        }

        .btn-danger {
            background: #e74c3c;
            color: #fff;
        }

        .btn-success {
            background: #2ecc71;
            color: #fff;
        }

        /* ===== TABLE ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th {
            background: #34495e;
            color: #fff;
            padding: 10px;
        }

        table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        table tr:hover {
            background: #f9f9f9;
        }

        /* ===== INPUT ===== */
        input, select {
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }

        /* Select2 fix */
        .select2-container {
            width: 300px !important;
        }

        .select2-selection {
            height: 38px !important;
            padding: 5px;
        }
        .btn-reset {
            background: #3498db;
            color: #2c3e50;
            border: 1px solid #ccc;
            transition: 0.2s;
            color: #fff;
        }

    </style>
</head>

<body>

@php
    $user = Auth::user();
@endphp

<div class="container">

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">

        <!-- 🔥 NÚT 3 GẠCH TRONG MENU -->
        <div class="menu-toggle" onclick="toggleSidebar()">
            ☰
        </div>

        <h3>
            🎓 <span>{{ $user ? ucfirst($user->role) : 'Guest' }}</span>
        </h3>

        @if($user)

            {{-- ===== ADMIN ===== --}}
            @if($user->role === 'admin')
                <a href="/admin">🏠 <span>Dashboard</span></a>
                <a href="/users">👤 <span>Tài khoản</span></a>
                <a href="/students">🎓 <span>Sinh viên</span></a>
                <a href="/departments">🏫 <span>Khoa</span></a>
                <a href="/subjects">📘 <span>Môn học</span></a>
                <a href="/classes">🏫 <span>Lớp hành chính</span></a>

                <a href="{{ route('scores.index') }}">📊 <span>Điểm</span></a>
                <a href="{{ route('course-classes.index') }}">📚 <span>Lớp tín chỉ</span></a>
                {{-- ✅ THÊM NÚT ĐIỂM DANH --}}
                <a href="{{ route('attendances.index') }}">📋 <span>Điểm danh</span></a>

                <a href="/change-password">🔐 <span>Đổi mật khẩu</span></a>
            @endif


            {{-- ===== TEACHER ===== --}}
            @if($user->role === 'teacher')
                {{-- ❌ BỎ SINH VIÊN --}}
                {{-- <a href="/students">🎓 <span>Sinh viên</span></a> --}}

                <a href="{{ route('scores.index') }}">📊 <span>Nhập điểm</span></a>

                {{-- ✅ THÊM ĐIỂM DANH --}}
                <a href="{{ route('attendances.index') }}">📋 <span>Điểm danh</span></a>

                <a href="/change-password">🔐 <span>Đổi mật khẩu</span></a>
            @endif


            {{-- ===== STUDENT ===== --}}
            @if($user->role === 'student')
                <a href="/student/my-scores">📊 <span>Xem điểm</span></a>
                <a href="/change-password">🔐 <span>Đổi mật khẩu</span></a>
            @endif

        @endif

        <hr>

        <a href="/logout">🚪 <span>Đăng xuất</span></a>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <!-- TOPBAR -->
        <div class="topbar">
            <div class="user">
                👋 Xin chào: <b>{{ $user->name ?? 'Guest' }}</b>
            </div>
        </div>

        <!-- MAIN -->
        <div class="card">
            @yield('content')
        </div>

    </div>

</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('collapsed');
    }

    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Tìm kiếm...",
            allowClear: true
        });
    });
</script>

</body>
</html>