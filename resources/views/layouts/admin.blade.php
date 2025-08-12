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
            --primary-color: #cb2786; /* Physique: Inspiration, Sportive */
            --secondary-color: #00617a; /* Culture: Commitment, Growth */
            --accent-color: #f4b704; /* Reflection: Youthful */
            --text-dark: #343a40;
            --text-muted: #6c757d;
            --bg-light: #F8F8FF; /* Background for content */
            --bg-sidebar: #FFFFFF;
            --active-bg: rgba(203, 39, 134, 0.1); /* Light tint of primary color */
            --active-text: var(--primary-color);
            --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --shadow-md: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);

            --sidebar-width: 280px; /* Definisi lebar sidebar yang jelas */
        }

        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            background-color: var(--bg-light);
        }

        .wrapper {
            display: flex; /* Menggunakan Flexbox untuk layout utama */
            min-height: 100vh;
        }

        .sidebar {
            width: var(--sidebar-width); /* Menggunakan variabel lebar sidebar */
            height: 100vh;
            background-color: var(--bg-sidebar);
            box-shadow: var(--shadow-sm);
            padding-top: 30px;
            overflow-y: auto;
            flex-shrink: 0; /* Penting: mencegah sidebar mengecil */
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
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
            box-shadow: 0 2px 8px rgba(var(--primary-color-rgb), 0.15);
        }

        .main-content-wrapper { /* Tambahkan wrapper baru untuk konten utama */
            margin-left: var(--sidebar-width); /* Dorong konten utama sebesar lebar sidebar */
            flex-grow: 1; /* Biarkan konten utama mengisi sisa ruang */
            padding: 30px;
            background-color: var(--bg-light); /* Background untuk area di luar card */
        }

        .content {
            padding: 30px; /* Padding di dalam card, bukan di luar */
            background-color: var(--bg-light); /* Background untuk content di dalam card */
            border-radius: 15px;
            box-shadow: var(--shadow-md);
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
            background-color: rgba(var(--primary-color-rgb), 0.05);
            box-shadow: 0 2px 8px rgba(var(--primary-color-rgb), 0.2);
        }

        .btn-logout i {
            margin-right: 8px;
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
            border: 1px solid rgba(var(--primary-color-rgb), 0.2);
        }

        .logo-container .logo i {
            font-size: 30px;
            color: var(--primary-color);
        }

        .nav-links {
            flex-grow: 1;
        }

        /* Mobile Block Styling (unchanged, as it's a fallback) */
        .mobile-block {
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, var(--bg-light) 0%, var(--active-bg) 100%);
            padding: 2rem;
            text-align: center;
            overflow: hidden;
            position: relative;
            z-index: 9999;
        }

        .mobile-block-content {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 2.5rem 2rem;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
            width: 90%;
            max-width: 400px;
            animation: fadeIn 0.8s ease-out;
            border: 1px solid rgba(255, 255, 255, 0.6);
            position: relative;
            overflow: hidden;
        }

        .mobile-icon {
            font-size: 3.5rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            animation: pulse 2s infinite;
        }

        .mobile-block h2 {
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .mobile-block p {
            color: var(--text-muted);
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .desktop-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0 auto;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(var(--primary-color-rgb), 0.2);
        }

        .desktop-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(var(--primary-color-rgb), 0.3);
        }

        .bg-shapes::before, .bg-shapes::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            z-index: -1;
        }

        .bg-shapes::before {
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background-color: rgba(var(--primary-color-rgb), 0.1);
        }

        .bg-shapes::after {
            bottom: -70px;
            left: -70px;
            width: 250px;
            height: 250px;
            background-color: rgba(var(--primary-color-rgb), 0.08);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px);}
            to { opacity: 1; transform: translateY(0);}
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1);}
            50% { transform: scale(1.1);}
        }

        @media (max-width: 768px) {
            body > *:not(.mobile-block) {
                display: none !important;
            }
            .mobile-block {
                display: flex !important;
            }
        }
    </style>
</head>
<body>

<div class="mobile-block">
    <div class="mobile-block-content">
        <div class="bg-shapes"></div>
        <div class="mobile-icon">
            <i class="fas fa-laptop"></i>
        </div>
        <h2>Desktop Experience Required</h2>
        <p>This admin dashboard is optimized for larger screens to provide you with the best management experience. Please switch to a tablet or desktop device.</p>
        <button class="desktop-btn">
            <i class="fas fa-desktop"></i> Best on Desktop
        </button>
    </div>
</div>

<div class="wrapper"> {{-- Pembungkus baru untuk sidebar dan main content --}}
    <div class="sidebar">
        <div class="sidebar-content">
            <div class="logo-container">
                <div class="logo">
                    <i class="fas fa-layer-group"></i>
                </div>
                <h4>Admin Panel</h4>
            </div>

            <div class="nav-links">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="{{ route('admin.articles.index') }}" class="{{ request()->routeIs('admin.articles.index') || request()->routeIs('admin.articles.create') || request()->routeIs('admin.articles.edit') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i> Manage Articles
            </a>
            <a href="{{ route('admin.articles.approval') }}" class="{{ request()->routeIs('admin.articles.approval') ? 'active' : '' }}">
                <i class="fas fa-check-circle"></i> Article Approval
            </a>
            <a href="{{ route('admin.galleries.index') }}" class="{{ request()->routeIs('admin.galleries.index') || request()->routeIs('admin.galleries.create') || request()->routeIs('admin.galleries.edit') ? 'active' : '' }}">
                <i class="fas fa-image"></i> Manage Galleries
            </a>
            <a href="{{ route('admin.galleries.approval') }}" class="{{ request()->routeIs('admin.galleries.approval') ? 'active' : '' }}">
                <i class="fas fa-clipboard-check"></i> Gallery Approval
            </a>
            <a href="{{ route('admin.tournaments.index') }}" class="{{ request()->routeIs('admin.tournaments.index') || request()->routeIs('admin.tournaments.create') || request()->routeIs('admin.tournaments.edit') ? 'active' : '' }}">
                <i class="fas fa-trophy"></i> Manage Tournaments
            </a>
            <a href="{{ route('admin.host-requests.index') }}" class="{{ request()->routeIs('admin.host-requests.index') || request()->routeIs('admin.host-requests.show') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list"></i> Tournament Host Requests
            </a>
            <a href="{{ route('admin.sponsors.index') }}" class="{{ request()->routeIs('admin.sponsors.index') || request()->routeIs('admin.sponsors.create') || request()->routeIs('admin.sponsors.edit') ? 'active' : '' }}">
                <i class="fas fa-plus"></i> Manage Sponsors
            </a>
            <a href="{{ route('admin.donations.index') }}" class="{{ request()->routeIs('admin.donations.index') || request()->routeIs('admin.donations.show') ? 'active' : '' }}">
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

    <div class="main-content-wrapper"> {{-- Perubahan di sini --}}
        <div class="content">
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@stack('scripts')

</body>
</html>
