@extends('layouts.recruitment')

@section('content')
    <!-- Dashboard Hero -->
    <section class="dashboard-hero">
        <div class="hero-text">
            <h1>Recruitment Dashboard</h1>
            <p>Manage teacher applications and recruitment workflow for {{ date('Y') }}/{{ date('Y') + 1 }} academic year.</p>
        </div>
        <div class="hero-actions">
            @if(auth()->user()->hasRole(['super_admin', 'hr_admin']))
                <a href="{{ route('job-openings.create') }}" class="btn btn-primary" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    <x-icon name="dashboard" class="w-5 h-5" /> Add Job Opening
                </a>
            @endif
            <button class="btn btn-secondary">Hiring Reports</button>
        </div>
    </section>

    <!-- Stats Grid -->
    <section class="stats-grid">
        <div class="stat-card dark">
            <div class="stat-header">
                <span>Total Applicants</span>
                <div class="arrow-icon">
                    <x-icon name="users" />
                </div>
            </div>
            <div class="stat-value">{{ number_format($stats['total_applicants']) }}</div>
            <div class="stat-footer">
                From current active pool
            </div>
            <div class="card-bg-waves"></div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <span>Shortlisted</span>
                <div class="arrow-icon">
                    <x-icon name="dashboard" />
                </div>
            </div>
            <div class="stat-value">{{ number_format($stats['shortlisted']) }}</div>
            <div class="stat-footer">
                Candidates in shortlisting
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <span>Success Rate</span>
                <div class="arrow-icon">
                    <x-icon name="dashboard" />
                </div>
            </div>
            <div class="stat-value">12.5%</div>
            <div class="stat-footer">
                Hiring efficiency tracking
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <span>Open Positions</span>
                <div class="arrow-icon">
                    <x-icon name="briefcase" />
                </div>
            </div>
            <div class="stat-value">{{ number_format($stats['open_positions']) }}</div>
            <div class="stat-footer">
                Active vacancies
            </div>
        </div>
    </section>

    <!-- Dashboard Grid -->
    <div class="dashboard-grid">
        <!-- Recruitment Pipeline -->
        <section class="grid-item project-analytics">
            <div class="section-header">
                <h2>Hiring Pipeline</h2>
            </div>
            <div class="chart-container">
                <div class="bar-chart">
                    @php 
                        $max = max(array_values($pipeline)) ?: 1; 
                    @endphp
                    @foreach($pipeline as $stage => $count)
                        <div class="bar-group">
                            <div class="bar {{ $stage === 'Hired' ? 'filled' : ($stage === 'Received' ? 'hatched' : 'dark') }}" 
                                 style="height: {{ ($count / $max) * 100 }}%; min-height: 5px;">
                                <div class="tooltip">{{ $count }}</div>
                            </div>
                            <span>{{ $stage }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Upcoming Interviews -->
        <section class="grid-item reminders">
            <div class="section-header">
                <h2>Upcoming Interviews</h2>
            </div>
            <div class="reminder-card">
                @php $upcoming = \App\Models\Interview::with(['application.applicant'])->where('status', 'Scheduled')->latest()->take(2)->get(); @endphp
                @forelse($upcoming as $interview)
                    <div style="margin-bottom: 16px; border-bottom: 1px solid #F9F9F9; padding-bottom: 10px; display: flex; align-items: center; gap: 12px;">
                        <div style="width: 36px; height: 36px; border-radius: 10px; background: #F8F9FA; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                            <x-icon name="calendar" class="w-5 h-5" />
                        </div>
                        <div>
                            <p style="font-weight: 600; font-size: 13px; margin: 0;">{{ $interview->application->applicant->full_name }}</p>
                            <p style="font-size: 11px; color: var(--text-muted); margin: 0;">{{ ucfirst($interview->type) }} @ {{ \Carbon\Carbon::parse($interview->scheduled_at)->format('H:i') }}</p>
                        </div>
                    </div>
                @empty
                    <p style="color: var(--text-muted); font-size: 14px; text-align: center; padding: 20px 0;">No interviews scheduled for today.</p>
                @endforelse
                <a href="{{ route('interviews.index') }}" class="btn btn-secondary" style="width: 100%; text-decoration: none; display: block; text-align: center;">View Schedule</a>
            </div>
        </section>

        <!-- Recent Applicants -->
        <section class="grid-item project-list">
            <div class="section-header">
                <h2>Recent Applicants</h2>
                <a href="{{ route('applicants.index') }}" class="btn-add-small" style="text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">View All</a>
            </div>
            <div class="projects">
                @forelse($recentApplicants as $applicant)
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #F9F9F9;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <img src="{{ asset('images/avatars/avatar_' . (strtolower($applicant->gender) == 'male' ? 'male' : (strtolower($applicant->gender) == 'female' ? 'female' : 'neutral')) . '.png') }}" 
                                 alt="Avatar" 
                                 style="width: 32px; height: 32px; border-radius: 8px; object-fit: cover;">
                            <div>
                                <div style="font-weight: 600; font-size: 13px;">{{ $applicant->full_name }}</div>
                                <div style="font-size: 11px; color: var(--text-muted);">{{ $applicant->applications->first()?->jobOpening?->position?->title ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <a href="{{ route('applicants.show', $applicant->id) }}" class="icon-btn-small" style="color: var(--text-light);">
                            <x-icon name="chevron-right" class="w-4 h-4" />
                        </a>
                    </div>
                @empty
                    <p style="color: var(--text-muted); font-size: 14px; text-align: center; padding: 20px 0;">No recent applications.</p>
                @endforelse
            </div>
        </section>

        <!-- Recruitment Team -->
        <section class="grid-item team-collaboration">
            <div class="section-header">
                <h2>Recruitment Team</h2>
            </div>
            <div class="team-list">
                <div class="team-item">
                    <img src="{{ asset('images/avatars/avatar_neutral.png') }}" 
                         alt="Team Member" 
                         style="width: 40px; height: 40px; border-radius: 12px; object-fit: cover;">
                    <div class="member-info">
                        <h4>{{ Auth::user()->name }}</h4>
                        <p>Role: <span>{{ Auth::user()->roles->first()->name ?? 'HR Manager' }}</span></p>
                    </div>
                    <span class="status-tag completed">Online</span>
                </div>
            </div>
        </section>

        <!-- Hiring Progress -->
        <section class="grid-item project-progress">
            <div class="section-header">
                <h2>Hiring Goal</h2>
            </div>
            <div class="progress-container">
                @php 
                    $degree = ($hiringGoalPercentage / 100) * 360; 
                @endphp
                <div class="gauge-chart" style="background: conic-gradient(var(--primary) 0deg {{ $degree }}deg, #EFEFEF {{ $degree }}deg 360deg);">
                    <div class="gauge-center">
                        <span class="percentage">{{ $hiringGoalPercentage }}%</span>
                        <span class="label">Positions Filled</span>
                    </div>
                </div>
                <div class="legend">
                    <div class="legend-item"><span class="dot completed"></span> Hired</div>
                    <div class="legend-item"><span class="dot pending"></span> Remaining</div>
                </div>
            </div>
        </section>

        <!-- Activity Feed -->
        <section class="grid-item time-tracker" style="background: none; border: none; padding: 0;">
            <div class="time-tracker-card" style="height: 100%; overflow: hidden;">
                <span class="card-title">Activity Feed</span>
                <div style="padding: 20px; color: white; font-size: 14px; display: flex; flex-direction: column; gap: 20px;">
                    @forelse($activities as $activity)
                        <div style="display: flex; gap: 12px;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center;">
                                <x-icon name="dashboard" class="w-4 h-4" />
                            </div>
                            <div>
                                <p style="margin: 0; font-weight: 500;">{{ $activity->application->applicant->full_name ?? 'System' }}</p>
                                <p style="margin: 0; font-size: 12px; opacity: 0.8;">{{ $activity->content }}</p>
                                <span style="font-size: 10px; opacity: 0.6;">{{ $activity->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <p style="opacity: 0.7;">No recent activity to show.</p>
                    @endforelse
                </div>
                <div class="card-bg-waves"></div>
            </div>
        </section>
    </div>
@endsection
