<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Careers at CMFI') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    
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
                <div class="logo-wrapper" style="display: flex; align-items: center; gap: 16px;">
                    <img src="{{ asset('images/logo.png') }}" alt="CMFI Logo" style="height: 48px; width: auto;">
                    <div style="display: flex; flex-direction: column;">
                        <span class="logo-text" style="font-weight: 800; font-size: 24px; letter-spacing: -0.5px; line-height: 1; color: #0F172A;">Careers</span>
                        <span style="font-size: 14px; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 0.05em;">at CMFI</span>
                    </div>
                </div>
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
                    </ul>
                </div>
                        <li class="nav-item">
                            <x-icon name="help" />
                            <span>Help Center</span>
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
                    
                    <!-- User Profile Dropdown -->
                    <div x-data="{ open: false }" @click.away="open = false" style="position: relative;">
                        <button @click="open = !open" class="user-profile" style="background: none; border: none; padding: 0; cursor: pointer; display: flex; align-items: center; gap: 12px;">
                            <img src="{{ asset('images/avatars/admin.png') }}" alt="User Profile" style="width: 40px; height: 40px; border-radius: 12px; object-fit: cover; border: 1px solid var(--border-color);">
                            <div class="user-info" style="text-align: left;">
                                <span class="user-name" style="display: block; font-weight: 700; color: #0F172A; font-size: 14px;">{{ Auth::user()->name }}</span>
                                <span class="user-email" style="display: block; font-size: 12px; color: #64748B;">{{ Auth::user()->email }}</span>
                            </div>
                            <x-icon name="chevron-down" style="width: 16px; height: 16px; color: #94A3B8; transition: transform 0.2s;" ::style="open ? 'transform: rotate(180deg)' : ''" />
                        </button>

                        <!-- Dropdown Menu (Pops Down) -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="transform opacity-0 scale-95 -translate-y-4"
                             x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="transform opacity-0 scale-95 -translate-y-4"
                             style="position: absolute; top: calc(100% + 12px); right: 0; width: 240px; background: #fff; border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04); border: 1px solid #F1F5F9; padding: 8px; z-index: 100; display: none;"
                             :style="{ display: open ? 'block' : 'none' }">
                            
                            <div style="padding: 12px; border-bottom: 1px solid #F1F5F9; margin-bottom: 4px;">
                                <div style="font-weight: 600; font-size: 11px; color: #94A3B8; text-transform: uppercase; letter-spacing: 0.1em;">Account Management</div>
                            </div>

                            <a href="{{ route('profile.edit') }}" class="dropdown-item" style="display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 10px; text-decoration: none; color: #334155; font-size: 14px; font-weight: 500; transition: all 0.2s;">
                                <div style="width: 32px; height: 32px; background: #F8FAFC; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <x-icon name="user" style="width: 18px; height: 18px; color: #64748B;" />
                                </div>
                                My Profile
                            </a>

                            <a href="#" class="dropdown-item" style="display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 10px; text-decoration: none; color: #334155; font-size: 14px; font-weight: 500; transition: all 0.2s;">
                                <div style="width: 32px; height: 32px; background: #F8FAFC; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <x-icon name="settings" style="width: 18px; height: 18px; color: #64748B;" />
                                </div>
                                Settings
                            </a>

                            <div style="height: 1px; background: #F1F5F9; margin: 8px 4px;"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item" style="width: 100%; border: none; background: transparent; display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 10px; cursor: pointer; text-decoration: none; color: #EF4444; font-size: 14px; font-weight: 600; transition: all 0.2s;">
                                    <div style="width: 32px; height: 32px; background: #FEF2F2; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <x-icon name="logout" style="width: 18px; height: 18px; color: #EF4444;" />
                                    </div>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            @yield('content')
        </main>
    </div>
</body>
</html>
