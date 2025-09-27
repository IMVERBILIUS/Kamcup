<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #cb2786;
            --secondary-color: #00617a;
            --accent-color: #f4b704;
            --text-dark: #343a40;
            --text-muted: #6c757d;
            --bg-light: #F8F8FF;
            --bg-sidebar: #FFFFFF;
            --active-bg: rgba(203, 39, 134, 0.1);
            --active-text: var(--primary-color);
            --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --shadow-md: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            --sidebar-width: 280px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            background-color: var(--bg-light);
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background-color: var(--bg-sidebar);
            box-shadow: var(--shadow-sm);
            padding-top: 20px; /* Disesuaikan */
            overflow-y: auto;
            flex-shrink: 0;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1030; /* Pastikan di atas konten */
            transition: transform 0.3s ease-in-out; /* BARU: Transisi untuk slide */
        }

        .sidebar-content {
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
            padding-bottom: 80px;
        }

        .sidebar h4 {
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
            text-align: center;
        }

        .sidebar a {
            font-weight: 500;
            display: flex;
            align-items: center;
            color: var(--text-dark);
            padding: 12px 20px;
            margin: 8px 15px;
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 10px;
        }

        .sidebar a i {
            margin-right: 10px;
            font-size: 18px;
        }

        .sidebar a:hover {
            background-color: var(--active-bg);
            color: var(--active-text);
            transform: translateX(5px);
        }

        .sidebar a.active {
            background-color: var(--active-bg);
            color: var(--active-text);
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(203, 39, 134, 0.15);
        }

        .main-content-wrapper {
            margin-left: var(--sidebar-width);
            flex-grow: 1;
            padding: 20px; /* Disesuaikan */
            background-color: var(--bg-light);
            width: calc(100% - var(--sidebar-width)); /* BARU */
            transition: margin-left 0.3s ease-in-out, width 0.3s ease-in-out; /* BARU */
        }

        .content {
            padding: 20px; /* Disesuaikan */
            background-color: #FFFFFF; /* Warna putih untuk card konten */
            border-radius: 15px;
            box-shadow: var(--shadow-sm);
        }

        .btn-logout {
            background-color: #fff;
            border: 1px solid var(--primary-color);
            padding: 12px 20px;
            border-radius: 10px;
            color: var(--primary-color);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            width: calc(100% - 30px);
            margin: 20px 15px 30px;
        }

        .btn-logout:hover {
            background-color: rgba(203, 39, 134, 0.05);
        }

        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-container .logo {
            width: 60px;
            height: 60px;
            background-color: var(--active-bg);
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            border: 1px solid rgba(203, 39, 134, 0.2);
        }

        .logo-container .logo i {
            font-size: 30px;
            color: var(--primary-color);
        }

        .nav-links {
            flex-grow: 1;
        }
        
        /* --- BARU: STYLING UNTUK MOBILE --- */
        .mobile-topbar {
            display: none; /* Sembunyi di desktop */
            background-color: #fff;
            padding: 0.75rem 1rem;
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 1020;
            justify-content: space-between;
            align-items: center;
        }

        .menu-toggle {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-dark);
        }
        
        .topbar-brand {
             font-weight: 600;
             color: var(--primary-color);
        }
        
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1029;
        }
        
        /* Tampilan di bawah 992px (Tablet dan Mobile) */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%); /* Sembunyikan sidebar ke kiri */
            }

            .sidebar.show {
                transform: translateX(0); /* Tampilkan sidebar */
            }

            .main-content-wrapper {
                margin-left: 0; /* Konten memenuhi layar */
                width: 100%;
                padding: 15px;
            }

            .mobile-topbar {
                display: flex; /* Tampilkan topbar di mobile */
            }
            
            .sidebar-overlay.show {
                display: block; /* Tampilkan overlay saat sidebar aktif */
            }
            
            .content {
                 padding: 15px;
            }
        }
        
    </style>
</head>

<body>

    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <div class="wrapper">
        <div class="sidebar" id="sidebar">
            <div class="sidebar-content">
                <div class="logo-container">
                    <div class="logo">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <h4>Admin Panel</h4>
                </div>

                <div class="nav-links">
                    <a href="{{ route('admin.dashboard') }}"
                        class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.articles.index') }}"
                        class="{{ request()->routeIs('admin.articles.index') || request()->routeIs('admin.articles.create') || request()->routeIs('admin.articles.edit') ? 'active' : '' }}">
                        <i class="fas fa-file-alt"></i> Manage Articles
                    </a>
                    <a href="{{ route('admin.articles.approval') }}"
                        class="{{ request()->routeIs('admin.articles.approval') ? 'active' : '' }}">
                        <i class="fas fa-check-circle"></i> Article Approval
                    </a>
                    <a href="{{ route('admin.galleries.index') }}"
                        class="{{ request()->routeIs('admin.galleries.index') || request()->routeIs('admin.galleries.create') || request()->routeIs('admin.galleries.edit') ? 'active' : '' }}">
                        <i class="fas fa-image"></i> Manage Galleries
                    </a>
                    <a href="{{ route('admin.galleries.approval') }}"
                        class="{{ request()->routeIs('admin.galleries.approval') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-check"></i> Gallery Approval
                    </a>
                    <a href="{{ route('admin.tournaments.index') }}"
                        class="{{ request()->routeIs('admin.tournaments.index') || request()->routeIs('admin.tournaments.create') || request()->routeIs('admin.tournaments.edit') ? 'active' : '' }}">
                        <i class="fas fa-trophy"></i> Manage Tournaments
                    </a>
                    <a href="{{ route('admin.matches.index') }}"
                        class="{{ request()->routeIs('admin.matches.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar"></i>Tournament Schedule
                    </a>
                    <a href="{{ route('admin.host-requests.index') }}"
                        class="{{ request()->routeIs('admin.host-requests.index') || request()->routeIs('admin.host-requests.show') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-list"></i> Tournament Host Requests
                    </a>
                    <a href="{{ route('admin.sponsors.index') }}"
                        class="{{ request()->routeIs('admin.sponsors.index') || request()->routeIs('admin.sponsors.create') || request()->routeIs('admin.sponsors.edit') ? 'active' : '' }}">
                        <i class="fas fa-plus"></i> Manage Sponsors
                    </a>
                    <a href="{{ route('admin.donations.index') }}"
                        class="{{ request()->routeIs('admin.donations.index') || request()->routeIs('admin.donations.show') ? 'active' : '' }}">
                        <i class="fas fa-donate"></i>Sponsors/Donations
                    </a>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <div class="main-content-wrapper">
            <div class="mobile-topbar">
                 <button class="menu-toggle" id="menu-toggle">
                     <i class="fas fa-bars"></i>
                 </button>
                 <span class="topbar-brand">Kamcup Admin</span>
                 <span></span> </div>
            
            <main class="content mt-3">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Hapus duplikasi Chart.js karena sudah ada di admin.blade.php (jika perlu) --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}} 
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuToggle = document.getElementById('menu-toggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            function toggleSidebar() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            }

            if (menuToggle) {
                menuToggle.addEventListener('click', toggleSidebar);
            }
            
            if (overlay) {
                overlay.addEventListener('click', toggleSidebar);
            }
        });
    </script>
    
    @stack('scripts')

</body>

</html>