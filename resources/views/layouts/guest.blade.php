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
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
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
            --bg-color: #f8fafc;
            --text-color: #1f2937;
            --text-secondary: #6b7280;
            --white: #ffffff;
            --border-color: #e5e7eb;
            --card-bg: #ffffff;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --input-bg: #ffffff;
            --input-border: #d1d5db;
        }

        /* ========================================
           DARK THEME
           ======================================== */
        [data-theme="dark"] {
            color-scheme: dark;
            --primary-color: #818cf8;
            --primary-hover: #6366f1;
            --bg-color: #0f172a;
            --text-color: #e2e8f0;
            --text-secondary: #94a3b8;
            --white: #1e293b;
            --border-color: #334155;
            --card-bg: #1e293b;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.1);
            --input-bg: #0f172a;
            --input-border: #475569;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .navbar {
            background-color: var(--white);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 64px;
            box-sizing: border-box;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .navbar-brand {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--text-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .navbar-brand span {
            color: var(--primary-color);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .nav-link {
            text-decoration: none;
            color: var(--text-secondary);
            font-weight: 500;
            font-size: 0.875rem;
            transition: color 0.2s;
        }

        .nav-link:hover {
            color: var(--primary-color);
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            transition: background-color 0.2s;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-hover);
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
            background-color: var(--white);
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .theme-toggle:hover {
            color: var(--text-color);
            border-color: var(--text-secondary);
        }

        .theme-toggle svg { width: 1.125rem; height: 1.125rem; }

        /* Show/hide sun/moon icons */
        [data-theme="light"] .icon-moon { display: block; }
        [data-theme="light"] .icon-sun  { display: none; }
        [data-theme="dark"]  .icon-moon { display: none; }
        [data-theme="dark"]  .icon-sun  { display: block; }

        main {
            flex: 1;
            width: 100%;
            display: block; /* Remove flex centering */
            box-sizing: border-box;
        }

        footer {
            background-color: var(--white);
            padding: 1.5rem;
            text-align: center;
            color: var(--text-secondary);
            border-top: 1px solid var(--border-color);
            font-size: 0.8rem;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        @media (max-width: 640px) {
            .navbar {
                padding: 1rem;
            }
            .nav-actions {
                gap: 0.5rem;
            }
            .btn-primary {
                padding: 0.4rem 0.75rem;
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ url('/') }}" class="navbar-brand">
            <span>⚡</span> Invoice App
        </a>
        <div class="nav-actions">
            <!-- Theme Toggle -->
            <button class="theme-toggle" onclick="toggleTheme()" title="Toggle theme">
                <svg class="icon-moon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                <svg class="icon-sun" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </button>

            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a>
                @else
                    @if (request()->routeIs('register'))
                        <a href="{{ route('login') }}" class="nav-link">Log in</a>
                    @elseif (request()->routeIs('login'))
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-primary">Register</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="nav-link">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-primary">Get Started</a>
                        @endif
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        &copy; {{ date('Y') }} Invoice App Package. All rights reserved.
    </footer>

    <script>
        // Theme toggle
        function toggleTheme() {
            const html = document.documentElement;
            const current = html.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
        }
    </script>
</body>
</html>
