<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CMFI Recruitment') }}</title>

    
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
                <div class="logo-icon" style="background: var(--primary); color: white; width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(42, 133, 255, 0.3);">
                    <x-icon name="dashboard" class="w-6 h-6" />
                </div>
                <span class="logo-text" style="font-weight: 800; font-size: 18px; letter-spacing: -0.5px;">CMFI <span style="color: var(--primary);">Recruit</span></span>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section">
                    <p class="section-title">MENU</p>
                    <ul class="nav-list">
                        <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; gap: 12px; color: inherit; text-decoration: none; width: 100%;">
                                <x-icon name="dashboard" />
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('applicants.*') ? 'active' : '' }}">
                            <a href="{{ route('applicants.index') }}" style="display: flex; align-items: center; gap: 12px; color: inherit; text-decoration: none; width: 100%;">
                                <x-icon name="users" />
                                <span>Applicants</span>
                                <span class="badge">{{ \App\Models\Applicant::count() }}</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('interviews.*') ? 'active' : '' }}">
                            <a href="{{ route('interviews.index') }}" style="display: flex; align-items: center; gap: 12px; color: inherit; text-decoration: none; width: 100%;">
                                <x-icon name="calendar" />
                                <span>Interviews</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('job-openings.*') ? 'active' : '' }}">
                            <a href="{{ route('job-openings.index') }}" style="display: flex; align-items: center; gap: 12px; color: inherit; text-decoration: none; width: 100%;">
                                <x-icon name="briefcase" />
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
                                <x-icon name="settings" />
                                <span>Settings</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <x-icon name="help" />
                            <span>Help Center</span>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                                @csrf
                                <button type="submit" style="background: none; border: none; padding: 0; display: flex; align-items: center; gap: 12px; color: inherit; font: inherit; cursor: pointer; width: 100%;">
                                    <x-icon name="logout" />
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
                    <x-icon name="search" class="w-5 h-5" style="color: #9A9FA5;" />
                    <input type="text" placeholder="Search applicant...">
                </div>
                <div class="header-actions">
                    <button class="icon-btn">
                        <x-icon name="mail" />
                    </button>
                    <button class="icon-btn">
                        <x-icon name="bell" />
                    </button>
                    <div class="user-profile">
                        <img src="{{ asset('images/avatars/avatar_neutral.png') }}" alt="User Profile" style="width: 40px; height: 40px; border-radius: 12px; object-fit: cover; border: 1px solid var(--border-color);">
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
</body>
</html>
