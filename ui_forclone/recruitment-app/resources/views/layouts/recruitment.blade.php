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
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div x-data="{ sidebarOpen: false }" class="app-container">
        <!-- Mobile Header -->
        <header class="mobile-header">
            <div style="display: flex; align-items: center; gap: 12px;">
                <button @click="sidebarOpen = true" class="menu-btn">
                    <x-icon name="menu" />
                </button>
                <div class="logo-wrapper" style="display: flex; align-items: center; gap: 8px;">
                    <img src="{{ asset('images/logo.png') }}" alt="CMFI Logo" style="height: 32px; width: auto;">
                    <span style="font-weight: 800; font-size: 18px; color: #0F172A;">Careers</span>
                </div>
            </div>
            
            <div class="mobile-header-actions">
                <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/avatars/admin.png') }}" alt="User Profile" style="width: 32px; height: 32px; border-radius: 10px; object-fit: cover;">
            </div>
        </header>

        <!-- Sidebar Overlay -->
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false" 
             class="sidebar-overlay"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none;">
        </div>

        <!-- Sidebar -->
        <aside class="sidebar" :class="{ 'open': sidebarOpen }">
            <div class="sidebar-header">
                <div class="logo-wrapper" style="display: flex; align-items: center; gap: 12px; min-width: 0;">
                    <img src="{{ asset('images/logo.png') }}" alt="CMFI Logo" style="height: 40px; width: auto; flex-shrink: 0;">
                    <div style="display: flex; flex-direction: column; min-width: 0; overflow: hidden;">
                        <span class="logo-text" style="font-weight: 800; font-size: 20px; letter-spacing: -0.5px; line-height: 1; color: #0F172A; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Careers</span>
                        <span style="font-size: 12px; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 0.05em; white-space: nowrap;">at CMFI</span>
                    </div>
                </div>
                
                <button @click="sidebarOpen = false" class="mobile-close-btn">
                    <x-icon name="close" />
                </button>
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
                        <li class="nav-item {{ request()->routeIs('applicants.index') || request()->routeIs('applicants.show') ? 'active' : '' }}">
                            <a href="{{ route('applicants.index') }}" style="display: flex; align-items: center; gap: 12px; color: inherit; text-decoration: none; width: 100%;">
                                <x-icon name="users" />
                                <span>Applicants</span>
                                <span class="badge">{{ \App\Models\Applicant::count() }}</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('applicants.pipeline') ? 'active' : '' }}">
                            <a href="{{ route('applicants.pipeline') }}" style="display: flex; align-items: center; gap: 12px; color: inherit; text-decoration: none; width: 100%;">
                                <x-icon name="dashboard" />
                                <span>Pipeline Board</span>
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
            </nav>
        </aside>

        <!-- Main Wrapper -->
        <div style="flex: 1; display: flex; flex-direction: column; min-width: 0; height: 100vh;">
            <!-- Top Header -->
            <header class="top-header" style="background: white; border-bottom: 1px solid #F1F5F9; padding: 20px 48px; margin-bottom: 0;">
                <div class="search-container">
                    <button class="icon-btn mobile-search-btn">
                        <x-icon name="search" />
                    </button>
                    <div class="search-bar desktop-search-bar">
                        <x-icon name="search" class="w-5 h-5" style="color: #9A9FA5;" />
                        <input type="text" placeholder="Search applicant...">
                    </div>
                </div>
                <div class="header-actions">
                    <button class="icon-btn">
                        <x-icon name="mail" />
                    </button>
                    
                    <!-- Notification Dropdown -->
                    <div x-data="{ open: false }" @click.away="open = false" style="position: relative;">
                        <button @click="open = !open" class="icon-btn" style="position: relative;">
                            <x-icon name="bell" />
                            @if(Auth::user()->unreadNotifications->count() > 0)
                                <span style="position: absolute; top: 8px; right: 8px; width: 8px; height: 8px; background: #EF4444; border-radius: 50%; border: 2px solid white;"></span>
                            @endif
                        </button>

                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             style="position: absolute; right: 0; top: 100%; margin-top: 12px; width: 360px; background: white; border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04); border: 1px solid #F1F5F9; z-index: 50; overflow: hidden; display: none;"
                             :style="{ display: open ? 'block' : 'none' }">
                            
                            <div style="padding: 16px 20px; border-bottom: 1px solid #F1F5F9; display: flex; justify-content: space-between; align-items: center; background: #F8FAFC;">
                                <h3 style="font-size: 16px; font-weight: 700; color: #0F172A;">Notifications</h3>
                                @if(Auth::user()->unreadNotifications->count() > 0)
                                    <form method="POST" action="{{ route('notifications.read-all') }}">
                                        @csrf
                                        <button type="submit" style="font-size: 13px; color: var(--primary); font-weight: 600; background: none; border: none; cursor: pointer;">Mark all as read</button>
                                    </form>
                                @endif
                            </div>

                            <div style="max-height: 400px; overflow-y: auto;">
                                @forelse(Auth::user()->unreadNotifications->take(5) as $notification)
                                    <div style="padding: 16px 20px; border-bottom: 1px solid #F1F5F9; transition: background 0.2s; cursor: pointer;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background='white'">
                                        <div style="display: flex; gap: 12px;">
                                            <div style="width: 40px; height: 40px; border-radius: 10px; background: #EFF6FF; display: flex; align-items: center; justify-content: center; color: var(--primary); flex-shrink: 0;">
                                                <x-icon name="bell" style="width: 20px; height: 20px;" />
                                            </div>
                                            <div style="flex: 1;">
                                                <p style="font-size: 14px; color: #0F172A; font-weight: 500; line-height: 1.4; margin-bottom: 4px;">{{ $notification->data['message'] ?? 'New notification' }}</p>
                                                <span style="font-size: 12px; color: #94A3B8;">{{ $notification->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div style="padding: 40px 20px; text-align: center;">
                                        <div style="width: 64px; height: 64px; background: #F1F5F9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                                            <x-icon name="bell" style="width: 32px; height: 32px; color: #94A3B8;" />
                                        </div>
                                        <p style="font-size: 15px; color: #64748B; font-weight: 500;">No new notifications</p>
                                        <p style="font-size: 13px; color: #94A3B8; margin-top: 4px;">We'll let you know when something happens.</p>
                                    </div>
                                @endforelse
                            </div>

                            @if(Auth::user()->notifications->count() > 0)
                                <a href="{{ route('notifications.index') }}" style="display: block; padding: 14px; text-align: center; font-size: 14px; color: #64748B; font-weight: 600; text-decoration: none; background: #F8FAFC; border-top: 1px solid #F1F5F9; transition: color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='#64748B'">
                                    View all notifications
                                </a>
                            @endif
                        </div>
                    </div>
                    
                    <!-- User Profile Dropdown -->
                    <div x-data="{ open: false }" @click.away="open = false" style="position: relative;">
                        <button @click="open = !open" class="user-profile" style="background: none; border: none; padding: 0; cursor: pointer; display: flex; align-items: center; gap: 12px;">
                            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/avatars/admin.png') }}" alt="User Profile" style="width: 40px; height: 40px; border-radius: 12px; object-fit: cover; border: 1px solid var(--border-color);">
                            <div class="user-info desktop-only" style="text-align: left;">
                                <span class="user-name" style="display: block; font-weight: 700; color: #0F172A; font-size: 14px;">{{ Auth::user()->name }}</span>
                                <span class="user-email" style="display: block; font-size: 12px; color: #64748B;">{{ Auth::user()->email }}</span>
                            </div>
                            <x-icon name="chevron-down" class="desktop-only" style="width: 16px; height: 16px; color: #94A3B8; transition: transform 0.2s;" ::style="open ? 'transform: rotate(180deg)' : ''" />
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

            <main class="main-content" style="flex: 1; overflow-y: auto; padding: 0;">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
