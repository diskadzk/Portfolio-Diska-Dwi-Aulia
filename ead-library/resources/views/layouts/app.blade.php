<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Manajemen Buku')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
            background:
                radial-gradient(circle at top, rgb(56 189 248 / 0.14), transparent 30%),
                radial-gradient(circle at right, rgb(253 224 71 / 0.18), transparent 35%),
                linear-gradient(180deg, #f8fbff, #eef5ff);
            color: #0f172a;
        }

        ::selection {
            background: rgb(251 191 36 / 0.35);
            color: #fff;
        }

        input,
        select,
        textarea,
        button {
            outline: none;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 1rem;
            background: #0ea5e9;
            padding: 0.625rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #fff;
            box-shadow: 0 8px 16px -8px rgb(14 165 233 / 0.45);
            transition: transform 0.15s ease, background-color 0.15s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            background: #0284c7;
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 1rem;
            border: 1px solid #cbd5e1;
            background: #fff;
            padding: 0.625rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #0f172a;
            box-shadow: 0 6px 14px -10px rgb(15 23 42 / 0.35);
            transition: transform 0.15s ease, background-color 0.15s ease, border-color 0.15s ease;
        }

        .btn-secondary:hover {
            transform: translateY(-1px);
            border-color: #94a3b8;
            background: #f8fafc;
        }

        .nav-link {
            font-size: 0.95rem;
            font-weight: 600;
            color: #334155;
            text-decoration: none;
            padding: 0.3rem 0;
            border-bottom: 2px solid transparent;
            transition: color 0.15s ease, border-color 0.15s ease;
        }

        .nav-link:hover {
            color: #0369a1;
            border-color: #7dd3fc;
        }

        .user-menu {
            position: relative;
        }

        .user-icon-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.2rem;
            height: 2.2rem;
            border-radius: 9999px;
            border: 1px solid #dbe3ee;
            background: #f8fafc;
            color: #334155;
            cursor: pointer;
            list-style: none;
        }

        .user-icon-btn:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        .user-menu summary::-webkit-details-marker {
            display: none;
        }

        .user-menu-panel {
            position: absolute;
            right: 0;
            margin-top: 0.55rem;
            min-width: 10.5rem;
            border: 1px solid #dbe3ee;
            border-radius: 0.75rem;
            background: #fff;
            box-shadow: 0 12px 22px -14px rgb(15 23 42 / 0.45);
            padding: 0.45rem;
            z-index: 30;
        }

        .user-menu-name {
            font-size: 0.8rem;
            color: #64748b;
            padding: 0.35rem 0.5rem 0.45rem;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 0.35rem;
            white-space: nowrap;
        }

        .logout-link {
            display: block;
            width: 100%;
            text-align: left;
            border: none;
            background: transparent;
            color: #b91c1c;
            font-size: 0.9rem;
            font-weight: 600;
            padding: 0.35rem 0.5rem;
            border-radius: 0.5rem;
            cursor: pointer;
        }

        .logout-link:hover {
            background: #fef2f2;
        }

        .user-chip {
            display: inline-flex;
            align-items: center;
            border-radius: 9999px;
            border: 1px solid #dbe3ee;
            background: #f8fafc;
            padding: 0.5rem 0.9rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #334155;
            line-height: 1;
            cursor: default;
        }

        .btn-mini {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.375rem;
            border: 1px solid #cbd5e1;
            background: #fff;
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #0f172a;
        }

        .btn-danger {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 1rem;
            border: 1px solid #fecdd3;
            background: #fff1f2;
            padding: 0.625rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #be123c;
        }

        .app-input,
        .app-select,
        .app-textarea {
            width: 100%;
            border-radius: 1rem;
            border: 1px solid #cbd5e1;
            background: #fff;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            color: #0f172a;
            box-shadow: inset 0 1px 2px rgb(15 23 42 / 0.06);
        }

        .app-textarea {
            min-height: 8rem;
        }

        .app-label {
            margin-bottom: 0.5rem;
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #334155;
        }

        .app-error {
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: #dc2626;
        }

        .stat-card,
        .auth-shell {
            border-radius: 1.5rem;
            border: 1px solid #dbe3ee;
            background: #fff;
            box-shadow: 0 15px 25px -18px rgb(15 23 42 / 0.35);
            backdrop-filter: blur(24px);
        }

        .stat-card {
            padding: 1.25rem;
        }

        .stat-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.24em;
            color: #64748b;
        }

        .stat-value {
            margin-top: 0.75rem;
            font-weight: 700;
            color: #0f172a;
        }

        .stat-value {
            font-size: 1.875rem;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            border-radius: 9999px;
            border: 1px solid #dbe3ee;
            background: #f8fafc;
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #334155;
        }

        .badge-success {
            border-color: #a7f3d0;
            background: #ecfdf5;
            color: #065f46;
        }

        .badge-warning {
            border-color: #fde68a;
            background: #fffbeb;
            color: #92400e;
        }

        .pagination-wrap nav {
            color: #475569;
            font-size: 0.875rem;
        }

        .pagination-wrap nav .flex {
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .pagination-wrap nav .relative.inline-flex {
            border-radius: 0.75rem;
            border: 1px solid #dbe3ee;
            background: #fff;
            color: #334155;
        }
    </style>
</head>
<body class="min-h-screen text-slate-900">
    <div class="pointer-events-none fixed inset-0 overflow-hidden">
        <div class="absolute -top-24 left-1/2 h-80 w-80 -translate-x-1/2 rounded-full bg-sky-300/20 blur-3xl"></div>
        <div class="absolute right-0 top-32 h-72 w-72 rounded-full bg-amber-200/30 blur-3xl"></div>
        <div class="absolute left-0 bottom-0 h-72 w-72 rounded-full bg-emerald-200/30 blur-3xl"></div>
    </div>

    <div class="relative mx-auto flex min-h-screen w-full max-w-7xl flex-col px-4 py-6 sm:px-6 lg:px-8">
        <header class="mb-8 rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm sm:px-5">
            <nav class="flex flex-wrap items-center justify-between gap-3">
                <a href="{{ auth()->check() ? route('books.index') : route('login') }}" class="text-lg font-bold tracking-tight text-slate-900">
                    EAD Library - Laravel App
                </a>

                <div class="flex flex-wrap items-center gap-16">
                    @auth
                        <div class="flex items-center gap-3">
                            <a href="{{ route('books.index') }}" class="nav-link">Daftar Buku</a>
                            <a href="{{ route('books.create') }}" class="nav-link">Tambah Buku</a>
                        </div>

                        <details class="user-menu ml-2">
                            <summary class="user-icon-btn" aria-label="Akun pengguna">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="16" height="16" aria-hidden="true">
                                    <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-4.42 0-8 2.24-8 5v1h16v-1c0-2.76-3.58-5-8-5Z" />
                                </svg>
                            </summary>
                            <div class="user-menu-panel">
                                <p class="user-menu-name">{{ auth()->user()->name }}</p>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="logout-link">Logout</button>
                                </form>
                            </div>
                        </details>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}" class="nav-link">Login</a>
                        <a href="{{ route('register') }}" class="nav-link">Register</a>
                    @endguest
                </div>
            </nav>
        </header>

        <main class="flex-1">
            @if (session('error'))
                <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>