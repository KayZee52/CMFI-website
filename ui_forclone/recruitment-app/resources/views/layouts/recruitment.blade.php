<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CMFI Recruitment') }}</title>

    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <div class="logo-icon">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="16" cy="16" r="14" stroke="var(--primary)" stroke-width="4" />
                        <circle cx="16" cy="16" r="6" fill="var(--primary)" />
                    </svg>
                </div>
                <span class="logo-text">CMFI Recruitment</span>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section">
                    <p class="section-title">MENU</p>
                    <ul class="nav-list">
                        <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; gap: 12px; color: inherit; text-decoration: none; width: 100%;">
                                <i data-lucide="layout-grid"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('applicants.*') ? 'active' : '' }}">
                            <a href="{{ route('applicants.index') }}" style="display: flex; align-items: center; gap: 12px; color: inherit; text-decoration: none; width: 100%;">
                                <i data-lucide="users"></i>
                                <span>Applicants</span>
                                <span class="badge">{{ \App\Models\Applicant::count() }}</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('interviews.*') ? 'active' : '' }}">
                            <a href="{{ route('interviews.index') }}" style="display: flex; align-items: center; gap: 12px; color: inherit; text-decoration: none; width: 100%;">
                                <i data-lucide="calendar"></i>
                                <span>Interviews</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('job-openings.*') ? 'active' : '' }}">
                            <a href="{{ route('job-openings.index') }}" style="display: flex; align-items: center; gap: 12px; color: inherit; text-decoration: none; width: 100%;">
                                <i data-lucide="briefcase"></i>
                                <span>Job Openings</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="nav-section">
                    <p class="section-title">GENERAL</p>
                    <ul class="nav-list">
                        <li class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                            <a href="{{ route('settings.index') }}" style="display: flex; align-items: center; gap: 12px; color: inherit; text-decoration: none; width: 100%;">
                                <i data-lucide="settings"></i>
                                <span>Settings</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <i data-lucide="help-circle"></i>
                            <span>Help</span>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                                @csrf
                                <button type="submit" style="background: none; border: none; padding: 0; display: flex; align-items: center; gap: 12px; color: inherit; font: inherit; cursor: pointer; width: 100%;">
                                    <i data-lucide="log-out"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Header -->
            <header class="top-header">
                <div class="search-bar">
                    <i data-lucide="search" style="width: 18px; color: #9A9FA5;"></i>
                    <input type="text" placeholder="Search applicant...">
                </div>
                <div class="header-actions">
                    <button class="icon-btn">
                        <i data-lucide="mail"></i>
                    </button>
                    <button class="icon-btn">
                        <i data-lucide="bell"></i>
                    </button>
                    <div class="user-profile">
                        <div class="avatar-crop" style="background-position: 15% 15%;"></div>
                        <div class="user-info">
                            <span class="user-name">{{ Auth::user()->name }}</span>
                            <span class="user-email">{{ Auth::user()->email }}</span>
                        </div>
                    </div>
                </div>
            </header>

            @yield('content')
        </main>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
    </script>
</body>
</html>
