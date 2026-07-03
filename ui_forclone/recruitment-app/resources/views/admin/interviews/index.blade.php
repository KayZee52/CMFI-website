@extends('layouts.recruitment')

@section('content')
    <!-- Dashboard-style Header -->
    <section class="dashboard-hero">
        <div class="hero-text">
            <h1>Interview Schedule</h1>
            <p>Coordinate and track all candidate assessments, panel reviews, and demo lessons.</p>
        </div>
        <div class="hero-actions">
            <button class="btn btn-secondary">
                <i data-lucide="calendar"></i> Sync Calendar
            </button>
        </div>
    </section>

    <!-- Stats Overview (Dashboard Style) -->
    <div class="stats-grid" style="margin-top: 32px;">
        <div class="stat-card dark">
            <div class="stat-header">
                <span>Interviews Today</span>
                <div class="arrow-icon">
                    <i data-lucide="calendar-check"></i>
                </div>
            </div>
            <div class="stat-value">{{ $stats['today'] }}</div>
            <div class="stat-footer">
                <span>Sessions scheduled for today</span>
            </div>
            <div class="card-bg-waves"></div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span>Upcoming</span>
                <div class="arrow-icon">
                    <i data-lucide="clock"></i>
                </div>
            </div>
            <div class="stat-value">{{ $stats['upcoming'] }}</div>
            <div class="stat-footer">
                <span>Future scheduled sessions</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span>Completed</span>
                <div class="arrow-icon">
                    <i data-lucide="check-square"></i>
                </div>
            </div>
            <div class="stat-value">{{ $stats['completed'] }}</div>
            <div class="stat-footer">
                <span>Evaluations recorded</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span>Total Sessions</span>
                <div class="arrow-icon">
                    <i data-lucide="mic"></i>
                </div>
            </div>
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-footer">
                <span class="growth-tag">+5</span>
                <span>added recently</span>
            </div>
        </div>
    </div>

    <!-- Interviews List Card -->
    <section class="grid-item" style="margin-top: 32px; padding: 0; overflow: hidden; border: 1px solid var(--border-color); background: var(--white); border-radius: 24px;">
        <div style="padding: 24px; border-bottom: 1px solid var(--border-color); background: #FAFBFC; display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 18px; font-weight: 600; margin: 0;">Full Timeline Overview</h2>
            <div class="search-bar" style="width: 300px; background: white;">
                <i data-lucide="search" style="width: 16px; color: var(--text-light);"></i>
                <input type="text" placeholder="Filter by candidate or type..." style="font-size: 13px;">
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left; background: #FAFBFC;">
                        <th style="padding: 16px 24px; font-weight: 600; font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Candidate</th>
                        <th style="padding: 16px 24px; font-weight: 600; font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Interview Type</th>
                        <th style="padding: 16px 24px; font-weight: 600; font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Date & Time</th>
                        <th style="padding: 16px 24px; font-weight: 600; font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Status</th>
                        <th style="padding: 16px 24px; font-weight: 600; font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($interviews as $interview)
                        <tr style="border-bottom: 1px solid var(--border-color); transition: background 0.2s;" onmouseover="this.style.background='#F8F9FA'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 20px 24px;">
                                <div style="display: flex; align-items: center; gap: 14px;">
                                    <div style="width: 40px; height: 40px; border-radius: 12px; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: 700;">
                                        {{ substr($interview->application->applicant->first_name, 0, 1) }}{{ substr($interview->application->applicant->last_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; font-size: 14px; color: var(--text-main);">{{ $interview->application->applicant->full_name }}</div>
                                        <div style="font-size: 12px; color: var(--text-muted);">{{ $interview->application->jobOpening->position->title }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 20px 24px;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    @php
                                        $icon = match(strtolower($interview->type)) {
                                            'phone' => 'phone',
                                            'panel' => 'users',
                                            'demo' => 'presentation',
                                            default => 'mic'
                                        };
                                    @endphp
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #F4F7F6; display: flex; align-items: center; justify-content: center; color: var(--text-light);">
                                        <i data-lucide="{{ $icon }}" style="width: 14px;"></i>
                                    </div>
                                    <span style="font-size: 14px; color: var(--text-main); font-weight: 500;">{{ ucfirst($interview->type) }}</span>
                                </div>
                            </td>
                            <td style="padding: 20px 24px;">
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-size: 14px; font-weight: 600; color: var(--text-main);">{{ \Carbon\Carbon::parse($interview->scheduled_at)->format('l, M d') }}</span>
                                    <span style="font-size: 12px; color: var(--text-light);">{{ \Carbon\Carbon::parse($interview->scheduled_at)->format('H:i A') }}</span>
                                </div>
                            </td>
                            <td style="padding: 20px 24px;">
                                <span class="status-tag {{ $interview->status === 'Completed' ? 'completed' : 'pending' }}" style="padding: 6px 14px; border-radius: 10px;">
                                    {{ $interview->status }}
                                </span>
                            </td>
                            <td style="padding: 20px 24px; text-align: right;">
                                <a href="{{ route('interviews.show', $interview->id) }}" class="btn {{ $interview->status === 'Completed' ? 'btn-secondary' : 'btn-primary' }}" style="display: inline-flex; padding: 8px 16px; font-size: 13px; text-decoration: none; border-radius: 10px;">
                                    {{ $interview->status === 'Completed' ? 'View Result' : 'Enter Scores' }}
                                    <i data-lucide="chevron-right" style="width: 14px;"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 64px 24px; text-align: center;">
                                <div style="background: #F8F9FA; width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                                    <i data-lucide="calendar" style="width: 32px; height: 32px; color: var(--text-light);"></i>
                                </div>
                                <h3 style="font-size: 16px; font-weight: 600; color: var(--text-main); margin-bottom: 4px;">No interviews scheduled</h3>
                                <p style="font-size: 14px; color: var(--text-light);">Coordinate sessions by visiting an applicant's profile.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="padding: 24px; border-top: 1px solid var(--border-color); background: #FAFBFC;">
            {{ $interviews->links() }}
        </div>
    </section>
@endsection
