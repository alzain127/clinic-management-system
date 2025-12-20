<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'نظام إدارة العيادة') }}</title>

    <!-- Cairo Font from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap RTL -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

    <!-- Custom RTL Styles -->
    <style>
        * {
            font-family: 'Cairo', sans-serif;
        }

        body {
            direction: rtl;
            text-align: right;
        }

        .sidebar {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            padding: 20px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-link {
            color: #fff;
            padding: 12px 20px;
            margin: 5px 0;
            border-radius: 8px;
            text-decoration: none;
            display: block;
            transition: all 0.3s;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(-5px);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            padding: 10px 24px;
            font-weight: 600;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .table th {
            background: #f8f9fa;
            font-weight: 700;
        }

        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .stat-card h3 {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 10px 0;
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <h4 class="text-white text-center mb-4">إدارة العيادة</h4>

                @auth
                    <div class="text-white mb-4 text-center">
                        <div class="mb-2">{{ Auth::user()->name }}</div>
                        <small class="badge bg-light text-dark">{{ Auth::user()->role }}</small>
                    </div>

                    <a href="{{ route('dashboard') }}" class="sidebar-link">
                        📊 لوحة التحكم
                    </a>

                    <a href="{{ route('patients.index') }}" class="sidebar-link">
                        👥 المرضى
                    </a>

                    <a href="{{ route('doctors.index') }}" class="sidebar-link">
                        👨‍⚕️ الأطباء
                    </a>

                    <a href="{{ route('appointments.index') }}" class="sidebar-link">
                        📅 المواعيد
                    </a>

                    <a href="{{ route('invoices.index') }}" class="sidebar-link">
                        💰 الفواتير
                    </a>

                    <a href="{{ route('reports.index') }}" class="sidebar-link">
                        📈 التقارير
                    </a>

                    <hr class="bg-white">

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="sidebar-link w-100 border-0 text-end">
                            🚪 تسجيل الخروج
                        </button>
                    </form>
                @endauth
            </div>

            <!-- Main Content -->
            <div class="col-md-10 p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>