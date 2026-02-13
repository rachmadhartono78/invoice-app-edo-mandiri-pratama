<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Invoice App') }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%234f46e5' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M13 10V3L4 14h7v7l9-11h-7z'/></svg>">
    <!-- Prevent flash of wrong theme -->
    <script>
        (function() {
            const saved = localStorage.getItem('theme');
            if (saved) {
                document.documentElement.setAttribute('data-theme', saved);
            } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
    </script>
    
    <style>
        /* ========================================
           LIGHT THEME (Default)
           ======================================== */
        [data-theme="light"] {
            color-scheme: light;
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --primary-light: #eef2ff;

            /* Sidebar */
            --sidebar-bg: #ffffff;
            --sidebar-text: #64748b;
            --sidebar-text-active: #111827;
            --sidebar-hover: #f8fafc;
            --sidebar-active-bg: #eef2ff;
            --sidebar-border: #e5e7eb;
            --sidebar-brand-color: #111827;

            /* Content */
            --bg-color: #f8fafc;
            --text-color: #1f2937;
            --text-secondary: #6b7280;
            --white: #ffffff;
            --border-color: #e5e7eb;

            /* Cards & Components */
            --card-bg: #ffffff;
            --card-border: #e5e7eb;
            --card-shadow: 0 1px 3px rgba(0,0,0,0.08);
            --input-bg: #ffffff;
            --input-border: #d1d5db;
            --table-header-bg: #f9fafb;
            --table-row-hover: #f9fafb;
            --footer-bg: #ffffff;
        }

        /* ========================================
           DARK THEME
           ======================================== */
        [data-theme="dark"] {
            color-scheme: dark;
            --primary-color: #818cf8;
            --primary-hover: #6366f1;
            --primary-light: rgba(99, 102, 241, 0.15);

            /* Sidebar */
            --sidebar-bg: #0f172a;
            --sidebar-text: #94a3b8;
            --sidebar-text-active: #f1f5f9;
            --sidebar-hover: #1e293b;
            --sidebar-active-bg: rgba(99, 102, 241, 0.15);
            --sidebar-border: #1e293b;
            --sidebar-brand-color: #f1f5f9;

            /* Content */
            --bg-color: #0f172a;
            --text-color: #e2e8f0;
            --text-secondary: #94a3b8;
            --white: #1e293b;
            --border-color: #334155;

            /* Cards & Components */
            --card-bg: #1e293b;
            --card-border: #334155;
            --card-shadow: 0 1px 3px rgba(0,0,0,0.3);
            --input-bg: #0f172a;
            --input-border: #475569;
            --table-header-bg: #1e293b;
            --table-row-hover: #263042;
            --footer-bg: #1e293b;
        }

        /* ========================================
           BASE STYLES
           ======================================== */
        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            margin: 0;
            display: flex;
            min-height: 100vh;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* ========================================
           SIDEBAR
           ======================================== */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            color: var(--sidebar-text);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 50;
            border-right: 1px solid var(--sidebar-border);
            transition: transform 0.3s ease-in-out, background-color 0.3s ease, border-color 0.3s ease;
        }

        .sidebar-brand {
            height: 64px;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--sidebar-brand-color);
            text-decoration: none;
            border-bottom: 1px solid var(--sidebar-border);
            transition: color 0.3s ease, border-color 0.3s ease;
            gap: 0.75rem;
        }

        .sidebar-nav {
            padding: 0.75rem 0;
            flex: 1;
            overflow-y: auto;
        }

        .nav-section-label {
            padding: 0.75rem 1.5rem 0.5rem;
            font-size: 0.6875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-secondary);
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.625rem 1.5rem;
            margin: 0.125rem 0.75rem;
            color: var(--sidebar-text);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            border-radius: 0.5rem;
            transition: all 0.15s ease;
        }

        .nav-link:hover {
            background-color: var(--sidebar-hover);
            color: var(--sidebar-text-active);
        }

        .nav-link.active {
            background-color: var(--sidebar-active-bg);
            color: var(--primary-color);
            font-weight: 600;
        }

        .nav-link svg, .nav-link .nav-icon {
            width: 1.25rem;
            height: 1.25rem;
            margin-right: 0.75rem;
            flex-shrink: 0;
        }

        /* ========================================
           MAIN CONTENT AREA
           ======================================== */
        .main-wrapper {
            flex: 1;
            margin-left: 260px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin-left 0.3s ease-in-out;
        }

        .top-header {
            height: 64px;
            background-color: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 40;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .toggle-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-color);
            padding: 0.5rem;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        /* Theme Toggle Button */
        .theme-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 0.5rem;
            border: 1px solid var(--border-color);
            background-color: var(--card-bg);
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .theme-toggle:hover {
            background-color: var(--sidebar-hover);
            color: var(--text-color);
            border-color: var(--text-secondary);
        }

        .theme-toggle svg { width: 1.125rem; height: 1.125rem; }

        /* Show/hide sun/moon icons */
        [data-theme="light"] .icon-moon { display: block; }
        [data-theme="light"] .icon-sun  { display: none; }
        [data-theme="dark"]  .icon-moon { display: none; }
        [data-theme="dark"]  .icon-sun  { display: block; }

        .main-content {
            padding: 2rem;
            flex: 1;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        /* ========================================
           MOBILE RESPONSIVE
           ======================================== */
        /* ========================================
           MOBILE RESPONSIVE
           ======================================== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 260px; /* Ensure fixed width */
            }
            .sidebar.open {
                transform: translateX(0);
                box-shadow: 0 0 15px rgba(0,0,0,0.2); /* Add shadow for depth */
            }
            .main-wrapper {
                margin-left: 0;
                width: 100%; /* Full width on mobile */
            }
            .top-header {
                padding: 0 1rem; /* Smaller padding on mobile */
            }
            .main-content {
                padding: 1rem; /* Smaller padding on mobile */
            }
            .toggle-btn {
                display: flex; /* Flex to center icon */
                align-items: center;
                justify-content: center;
            }
            .overlay {
                display: none;
                position: fixed;
                top: 0; left: 0; right: 0; bottom: 0;
                background: rgba(0,0,0,0.5);
                backdrop-filter: blur(2px); /* Add blur effect */
                z-index: 45;
                transition: opacity 0.3s ease; /* Smooth fade */
            }
            .overlay.show { 
                display: block; 
            }
        }

        /* ========================================
           COMPONENTS & UTILITIES
           ======================================== */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid transparent;
            font-size: 0.875rem;
        }
        .btn-primary { background: var(--primary-color); color: white; }
        .btn-primary:hover { background: var(--primary-hover); }
        .btn-outline { background: transparent; border-color: var(--border-color); color: var(--text-color); }
        .btn-outline:hover { background: var(--sidebar-hover); border-color: var(--text-secondary); }
        
        .card {
            background: var(--card-bg);
            border-radius: 0.5rem;
            box-shadow: var(--card-shadow);
            padding: 1.5rem;
            border: 1px solid var(--card-border);
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        /* Dark mode overrides for inline-styled elements */
        [data-theme="dark"] input,
        [data-theme="dark"] select,
        [data-theme="dark"] textarea {
            background-color: var(--input-bg) !important;
            border-color: var(--input-border) !important;
            color: var(--text-color) !important;
        }

        [data-theme="dark"] select option {
            background-color: var(--card-bg) !important;
            color: var(--text-color) !important;
        }

        [data-theme="dark"] input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
        }

        [data-theme="dark"] input::placeholder { color: var(--text-secondary) !important; }

        [data-theme="dark"] table thead,
        [data-theme="dark"] table thead tr {
            background-color: var(--table-header-bg) !important;
        }

        [data-theme="dark"] table thead th {
            color: var(--text-secondary) !important;
        }

        [data-theme="dark"] table tbody tr {
            border-bottom-color: var(--border-color) !important;
        }

        /* Override hardcoded inline colors for dark mode */
        [data-theme="dark"] h1,
        [data-theme="dark"] h2,
        [data-theme="dark"] h3 {
            color: var(--text-color) !important;
        }

        [data-theme="dark"] p {
            color: var(--text-secondary) !important;
        }

        [data-theme="dark"] .card,
        [data-theme="dark"] [class*="card"] {
            background-color: var(--card-bg) !important;
            border-color: var(--card-border) !important;
        }

        [data-theme="dark"] table tbody tr:hover {
            background-color: var(--table-row-hover) !important;
        }

        [data-theme="dark"] td {
            color: var(--text-color) !important;
        }

        [data-theme="dark"] a:not(.btn):not(.nav-link):not(.sidebar-brand) {
            color: var(--primary-color) !important;
        }

        [data-theme="dark"] label {
            color: var(--text-secondary) !important;
        }

        [data-theme="dark"] footer {
            background-color: var(--footer-bg) !important;
            border-top-color: var(--border-color) !important;
        }

        /* Pagination */
        nav[role="navigation"] { display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; }
        nav[role="navigation"] svg { width: 1rem; height: 1rem; }
        span[aria-current="page"] > span { background-color: var(--primary-color); color: white; border-color: var(--primary-color); }

        /* Toast animations */
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes slideOut { from { transform: translateX(0); opacity: 1; } to { transform: translateX(100%); opacity: 0; } }
    </style>
</head>
<body>
    <!-- Mobile Overlay -->
    <div id="overlay" class="overlay" onclick="toggleSidebar()"></div>

    <aside class="sidebar" id="sidebar">
        <a href="{{ url('/') }}" class="sidebar-brand">
            <x-application-logo class="w-8 h-8 text-primary" />
            <span style="font-weight: 800; letter-spacing: -0.025em; font-size: 1.25rem;">Invoice<span style="color: var(--primary-color);">App</span></span>
        </a>
        
        <nav class="sidebar-nav">
            @auth
                <div class="nav-section-label">Main Menu</div>
                <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <x-icons.dashboard class="w-5 h-5 mr-3" />
                    Dashboard
                </a>
                <a href="{{ url('/invoices') }}" class="nav-link {{ request()->is('invoices*') && !request()->is('invoice/print') ? 'active' : '' }}">
                    <x-icons.invoices class="w-5 h-5 mr-3" />
                    Invoices
                </a>
                <a href="{{ route('invoices.print_page') }}" class="nav-link {{ request()->is('invoice/print') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Invoice
                </a>

                <div class="nav-section-label">Management</div>
                <a href="{{ url('/products') }}" class="nav-link {{ request()->is('products*') ? 'active' : '' }}">
                    <x-icons.products class="w-5 h-5 mr-3" />
                    Products
                </a>
                <a href="{{ url('/clients') }}" class="nav-link {{ request()->is('clients*') ? 'active' : '' }}">
                    <x-icons.clients class="w-5 h-5 mr-3" />
                    Clients
                </a>
            @else
                <a href="{{ route('login') }}" class="nav-link">Login</a>
                <a href="{{ route('register') }}" class="nav-link">Register</a>
            @endauth
        </nav>

        @auth
        <div style="border-top: 1px solid var(--sidebar-border); padding: 0.75rem;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link" style="width: 100%; cursor: pointer; background: none; border: none; font-family: inherit; color: var(--sidebar-text);">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
        @endauth
    </aside>

    <!-- Main Content Wrapper -->
    <div class="main-wrapper">
        <!-- Top Header -->
        <header class="top-header">
            <button class="toggle-btn" onclick="toggleSidebar()">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            
            <div class="header-actions">
                <!-- Theme Toggle -->
                <button class="theme-toggle" onclick="toggleTheme()" title="Toggle theme" id="themeToggleBtn">
                    <!-- Moon icon (shown in light mode) -->
                    <svg class="icon-moon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    <!-- Sun icon (shown in dark mode) -->
                    <svg class="icon-sun" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </button>

                <div style="font-weight: 600; color: var(--text-color); font-size: 0.875rem;">
                    @auth {{ Auth::user()->name }} @endauth
                </div>
            </div>
        </header>

        <main class="main-content">
            @yield('content')
        </main>

        <footer style="text-align: center; padding: 1.5rem; color: var(--text-secondary); font-size: 0.8rem; border-top: 1px solid var(--border-color); background: var(--footer-bg); transition: all 0.3s ease;">
            &copy; {{ date('Y') }} Invoice App Package. All rights reserved.
        </footer>
    </div>

    <!-- Toast Notification Container -->
    <div id="toast-container" style="position: fixed; top: 1rem; right: 1rem; z-index: 9999; display: flex; flex-direction: column; gap: 0.5rem;"></div>

    <script>
        // Sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        }

        // Close sidebar when clicking a link on mobile
        document.querySelectorAll('.sidebar-nav .nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    toggleSidebar();
                }
            });
        });

        // Theme toggle
        function toggleTheme() {
            const html = document.documentElement;
            const current = html.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
        }

        // Toast Notification
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            const colors = {
                success: { bg: '#d1fae5', border: '#10b981', text: '#065f46', icon: '✓' },
                error: { bg: '#fee2e2', border: '#ef4444', text: '#991b1b', icon: '✗' },
            };
            const color = colors[type] || colors.success;
            
            toast.style.cssText = `background: ${color.bg}; border-left: 4px solid ${color.border}; color: ${color.text}; padding: 1rem; border-radius: 0.375rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1); min-width: 300px; animation: slideIn 0.3s forwards; display: flex; align-items: center; gap: 0.5rem; font-weight: 500;`;
            toast.innerHTML = `<span>${color.icon}</span> <span>${message}</span>`;
            
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.animation = 'slideOut 0.3s forwards';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        @if(session('success')) showToast('{{ session('success') }}', 'success'); @endif
        @if(session('error')) showToast('{{ session('error') }}', 'error'); @endif
    </script>
</body>
</html>
