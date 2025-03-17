{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle Patrimonial</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.x.x/dist/css/bootstrap.min.css">
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

        /* Estilos para submenu */
        .nav-item {
            position: relative;
        }

        .menu-toggle {
            display: flex !important;
            justify-content: space-between;
            cursor: pointer;
        }

        .menu-content {
            display: flex;
            align-items: center;
        }

        .menu-content i {
            width: 24px;
            margin-right: 10px;
        }

        .arrow {
            transition: transform 0.3s ease;
        }

        .menu-toggle.active .arrow {
            transform: rotate(180deg);
        }

        .submenu {
            display: none;
            background-color: rgba(0, 0, 0, 0.1);
        }

        .submenu.active {
            display: block;
        }

        .submenu-link {
            padding-left: 40px !important;
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
        
            {{-- Menu Funcionários com submenu --}}
            <div class="nav-item">
                <div class="nav-link menu-toggle" onclick="toggleSubmenu('employee-menu')">
                    <div class="menu-content">
                        <i class="fas fa-users"></i>
                        <span>Funcionários</span>
                    </div>
                    <i class="fas fa-chevron-down arrow"></i>
                </div>
                <div class="submenu" id="employee-menu">
                    <a href="{{ route('employees.index') }}" class="nav-link submenu-link">
                        <i class="fas fa-user-plus"></i>
                        <span>Cadastrar</span>
                    </a>
                    <a href="{{ route('employees.report') }}" class="nav-link submenu-link">
                        <i class="fas fa-list"></i>
                        <span>Listar</span>
                    </a>
                </div>
            </div>

            {{-- Menu Equipamentos com submenu --}}
            <div class="nav-item">
                <div class="nav-link menu-toggle" onclick="toggleSubmenu('equipment-menu')">
                    <div class="menu-content">
                        <i class="fas fa-laptop"></i>
                        <span>Equipamentos</span>
                    </div>
                    <i class="fas fa-chevron-down arrow"></i>
                </div>
                <div class="submenu" id="equipment-menu">
                    <a href="{{ route('equipment.index') }}" class="nav-link submenu-link">
                        <i class="fas fa-laptop"></i>
                        <span>Cadastrar</span>
                    </a>
                    <a href="{{ route('equipments.report') }}" class="nav-link submenu-link">
                        <i class="fas fa-list"></i>
                        <span>Listar</span>
                    </a>
                </div>
            </div>

            {{-- Menu Assignments com submenu --}}
            <div class="nav-item">
                <div class="nav-link menu-toggle" onclick="toggleSubmenu('assignments-menu')">
                    <div class="menu-content">
                        <i class="fas fa-exchange-alt"></i>
                        <span>Atribuições</span>
                    </div>
                    <i class="fas fa-chevron-down arrow"></i>
                </div>
                <div class="submenu" id="assignments-menu">
                    <a href="{{ route('assignments.index') }}" class="nav-link submenu-link">
                        <i class="fas fa-exchange-alt"></i>
                        <span>Registrar</span>
                    </a>
                    <a href="{{ route('assignments.report') }}" class="nav-link submenu-link">
                        <i class="fas fa-list"></i>
                        <span>Listar</span>
                    </a>
                    <a href="{{ route('assignments.active') }}" class="nav-link submenu-link">
                        <i class="fas fa-link""></i>
                        <span>Ativas</span>
                    </a>
                    <a href="{{ route('assignments.history') }}" class="nav-link submenu-link">
                        <i class="fas fa-clock"></i>
                        <span>Histórico</span>
                    </a>
                </div>
            </div>
        
            <a href="{{ route('cost-centers.index') }}" class="nav-link">
                <i class="fas fa-building"></i>
                <span>Centros de Custo</span>
            </a>
            <a href="{{ route('gadget-models.index') }}" class="nav-link">
                <i class="fas fa-laptop-code"></i>
                <span>Modelos</span>
            </a>
            {{-- <a href="{{ route('reports.index') }}" class="nav-link">
                <i class="fas fa-chart-bar"></i>
                <span>Relatórios</span>
            </a> --}}
        </nav>
    </div>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
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

        function toggleSubmenu(menuId) {
            const submenu = document.getElementById(menuId);
            const menuToggle = submenu.previousElementSibling;
            
            // Fecha todos os outros submenus
            document.querySelectorAll('.submenu.active').forEach(item => {
                if (item.id !== menuId) {
                    item.classList.remove('active');
                    item.previousElementSibling.classList.remove('active');
                }
            });

            // Toggle do submenu atual
            submenu.classList.toggle('active');
            menuToggle.classList.toggle('active');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>