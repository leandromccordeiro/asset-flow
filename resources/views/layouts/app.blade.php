{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle Patrimonial</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @vite('resources/css/app.css')
    <style>
        :root {
            --sidebar-width: 250px;
            --header-height: 60px;
            --primary-color: #2c3e50;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f6fa;
        }

        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--header-height);
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            z-index: 1000;
            display: flex;
            align-items: center;
            padding: 0 20px;
            transition: left 0.3s ease;
        }

        .header.sidebar-open {
            left: var(--sidebar-width);
        }

        .toggle-btn {
            background: none;
            border: none;
            color: var(--primary-color);
            font-size: 24px;
            cursor: pointer;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
        }

        .toggle-btn:hover {
            background-color: #f0f0f0;
        }

        .page-title {
            margin-left: 20px;
            font-size: 20px;
            color: var(--primary-color);
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background-color: var(--primary-color);
            transition: transform 0.3s ease;
            z-index: 999;
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        .sidebar-header {
            height: var(--header-height);
            display: flex;
            align-items: center;
            padding: 0 20px;
            background-color: rgba(0, 0, 0, 0.1);
        }

        .sidebar-header h2 {
            color: white;
            font-size: 20px;
        }

        .nav-links {
            padding: 20px 0;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-link i {
            width: 24px;
            margin-right: 10px;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--header-height);
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        /* Alert Messages */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @media (max-width: 768px) {
            .header.sidebar-open {
                left: 0;
            }

            .sidebar {
                width: 100%;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header" id="header">
        <button class="toggle-btn" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <h1 class="page-title">Controle Patrimonial</h1>
    </header>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2>Menu</h2>
        </div>
        <nav class="nav-links">
            <a href="{{ route('dashboard') }}" class="nav-link">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('employees.index') }}" class="nav-link">
                <i class="fas fa-users"></i>
                <span>Funcionários</span>
            </a>
            <a href="{{ route('cost-centers.index') }}" class="nav-link">
                <i class="fas fa-building"></i>
                <span>Centros de Custo</span>
            </a>
            <a href="{{ route('gadget-models.index') }}" class="nav-link">
                <i class="fas fa-laptop-code"></i>
                <span>Modelos</span>
            </a>
            <a href="{{ route('equipment.index') }}" class="nav-link">
                <i class="fas fa-laptop"></i>
                <span>Equipamentos</span>
            </a>
            <a href="{{ route('assignments.index') }}" class="nav-link">
                <i class="fas fa-exchange-alt"></i>
                <span>Atribuições</span>
            </a>

            <a href="{{ route('reports.index') }}" class="nav-link">
                <i class="fas fa-chart-bar"></i>
                <span>Relatórios</span>
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const header = document.getElementById('header');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            header.classList.toggle('sidebar-open');
        }
    </script>
</body>
</html>