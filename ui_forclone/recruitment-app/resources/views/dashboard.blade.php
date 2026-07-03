@extends('layouts.recruitment')

@section('content')
    <!-- Dashboard Hero -->
    <section class="dashboard-hero">
        <div class="hero-text">
            <h1>Recruitment Dashboard</h1>
            <p>Manage teacher applications and recruitment workflow for {{ date('Y') }}/{{ date('Y') + 1 }} academic year.</p>
        </div>
        <div class="hero-actions">
            <button class="btn btn-primary"><i data-lucide="plus"></i> Add Job Opening</button>
            <button class="btn btn-secondary">Hiring Reports</button>
        </div>
    </section>

    <!-- Stats Grid -->
    <section class="stats-grid">
        <div class="stat-card dark">
            <div class="stat-header">
                <span>Total Applicants</span>
                <div class="arrow-icon"><i data-lucide="arrow-up-right"></i></div>
            </div>
            <div class="stat-value">{{ \App\Models\Applicant::count() }}</div>
            <div class="stat-footer">
                <div class="growth-tag">{{ \App\Models\Applicant::where('created_at', '>=', now()->subMonth())->count() }}</div> from last month
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <span>Shortlisted</span>
                <div class="arrow-icon"><i data-lucide="arrow-up-right"></i></div>
            </div>
            <div class="stat-value">{{ \App\Models\Application::where('decision_status', 'Shortlisted')->count() }}</div>
            <div class="stat-footer">
                <div class="growth-tag secondary">{{ \App\Models\Application::where('current_stage', 'In Review')->count() }}</div> in review
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <span>Hired</span>
                <div class="arrow-icon"><i data-lucide="arrow-up-right"></i></div>
            </div>
            <div class="stat-value">{{ \App\Models\Application::where('decision_status', 'Hired')->count() }}</div>
            <div class="stat-footer">
                Current academic year
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <span>Open Positions</span>
                <div class="arrow-icon"><i data-lucide="arrow-up-right"></i></div>
            </div>
            <div class="stat-value">{{ \App\Models\JobOpening::where('status', 'open')->count() }}</div>
            <div class="stat-footer">
                Across all departments
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
                    <div class="bar-group">
                        <div class="bar hatched" style="height: 10%;"></div>
                        <span>Received</span>
                    </div>
                    <div class="bar-group">
                        <div class="bar dark" style="height: 10%;"></div>
                        <span>Review</span>
                    </div>
                    <div class="bar-group">
                        <div class="bar light" style="height: 10%;"></div>
                        <span>Shortlist</span>
                    </div>
                    <div class="bar-group">
                        <div class="bar filled" style="height: 10%;"></div>
                        <span>Interview</span>
                    </div>
                    <div class="bar-group">
                        <div class="bar hatched" style="height: 10%;"></div>
                        <span>Offer</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Upcoming Interviews -->
        <section class="grid-item reminders">
            <div class="section-header">
                <h2>Upcoming Interviews</h2>
            </div>
            <div class="reminder-card">
                <p style="color: var(--text-muted); font-size: 14px; text-align: center; padding: 20px 0;">No interviews scheduled for today.</p>
                <button class="btn btn-secondary" style="width: 100%;">View Calendar</button>
            </div>
        </section>

        <!-- Recent Applicants -->
        <section class="grid-item project-list">
            <div class="section-header">
                <h2>Recent Applicants</h2>
                <button class="btn-add-small"><i data-lucide="external-link"></i> View All</button>
            </div>
            <div class="projects">
                @php $recentApplicants = \App\Models\Applicant::with('applications.jobOpening.position')->latest()->take(3)->get(); @endphp
                @forelse($recentApplicants as $applicant)
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #F9F9F9;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 12px;">
                                {{ substr($applicant->first_name, 0, 1) }}{{ substr($applicant->last_name, 0, 1) }}
                            </div>
                            <div>
                                <div style="font-weight: 600; font-size: 13px;">{{ $applicant->full_name }}</div>
                                <div style="font-size: 11px; color: var(--text-muted);">{{ $applicant->applications->first()->jobOpening->position->title ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <a href="{{ route('applicants.show', $applicant->id) }}" class="icon-btn-small"><i data-lucide="chevron-right"></i></a>
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
                <button class="btn-add-small outline"><i data-lucide="plus"></i> Add Reviewer</button>
            </div>
            <div class="team-list">
                <div class="team-item">
                    <div class="avatar-crop" style="background-position: 15% 85%;"></div>
                    <div class="member-info">
                        <h4>{{ Auth::user()->name }}</h4>
                        <p>Role: <span>Admin</span></p>
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
                <div class="gauge-chart">
                    <div class="gauge-center">
                        <span class="percentage">0%</span>
                        <span class="label">Positions Filled</span>
                    </div>
                </div>
                <div class="legend">
                    <div class="legend-item"><span class="dot completed"></span> Hired</div>
                    <div class="legend-item"><span class="dot in-progress"></span> Offered</div>
                    <div class="legend-item"><span class="dot pending"></span> Remaining</div>
                </div>
            </div>
        </section>

        <!-- Activity Feed -->
        <section class="grid-item time-tracker" style="background: none; border: none; padding: 0;">
            <div class="time-tracker-card" style="height: 100%;">
                <span class="card-title">Activity Feed</span>
                <div style="padding: 20px; color: rgba(255,255,255,0.7); font-size: 14px;">
                    No recent activity to show.
                </div>
                <div class="card-bg-waves"></div>
            </div>
        </section>
    </div>
@endsection
