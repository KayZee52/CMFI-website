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
                <x-icon name="calendar" class="w-4 h-4" /> Sync Calendar
            </button>
        </div>
    </section>

    <!-- Stats Overview (Dashboard Style) -->
    <div class="stats-grid" style="margin-top: 32px;">
        <div class="stat-card dark">
            <div class="stat-header">
                <span>Interviews Today</span>
                <div class="arrow-icon">
                    <x-icon name="calendar" />
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
                    <x-icon name="calendar" />
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
                    <x-icon name="dashboard" />
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
                    <x-icon name="mail" />
                </div>
            </div>
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-footer">
                <span class="growth-tag">+5</span>
                <span>added recently</span>
            </div>
        </div>
    </div>

    <!-- Shadcn-inspired Table Section -->
    <div class="table-container" style="margin-top: 32px; box-shadow: var(--shadow-md);">
        <div class="list-header">
            <h2>Full Timeline Overview</h2>
            <div class="search-bar" style="width: 380px; background: white; border-radius: 10px; padding: 8px 16px; border: 1px solid #E2E8F0;">
                <x-icon name="search" class="w-4 h-4" style="color: #64748B;" />
                <input type="text" placeholder="Filter by candidate or interview type..." style="font-size: 13px; color: #1E293B;">
            </div>
        </div>

        <table class="premium-table">
            <thead>
                <tr>
                    <th>Candidate</th>
                    <th>Interview Type</th>
                    <th>Date & Time</th>
                    <th>Status</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($interviews as $interview)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <img src="{{ asset('images/avatars/avatar_' . (strtolower($interview->application?->applicant?->gender ?? 'neutral') == 'male' ? 'male' : (strtolower($interview->application?->applicant?->gender ?? 'neutral') == 'female' ? 'female' : 'neutral')) . '.png') }}" 
                                     alt="Avatar" 
                                     style="width: 36px; height: 36px; border-radius: 10px; object-fit: cover; border: 1px solid #E2E8F0;">
                                <div>
                                    <div style="font-weight: 600; font-size: 14px; color: #0F172A;">{{ $interview->application?->applicant?->full_name ?? 'Unknown Applicant' }}</div>
                                    <div style="font-size: 12px; color: #64748B;">{{ $interview->application?->jobOpening?->position?->title ?? $interview->application?->position_applying_for ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 32px; height: 32px; border-radius: 8px; background: #F8FAFC; display: flex; align-items: center; justify-content: center; color: #64748B; border: 1px solid #F1F5F9;">
                                    <x-icon name="mail" class="w-4 h-4" />
                                </div>
                                <span style="font-size: 14px; color: #1E293B; font-weight: 500;">{{ ucfirst($interview->type) }}</span>
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; flex-direction: column;">
                                <span style="font-size: 14px; font-weight: 600; color: #0F172A;">{{ \Carbon\Carbon::parse($interview->scheduled_at)->format('l, M d') }}</span>
                                <span style="font-size: 12px; color: #94A3B8;">{{ \Carbon\Carbon::parse($interview->scheduled_at)->format('H:i A') }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="status-tag {{ $interview->status === 'Completed' ? 'completed' : 'pending' }}" style="padding: 4px 10px; border-radius: 6px; font-size: 11px;">
                                {{ $interview->status }}
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <a href="{{ route('interviews.show', $interview->id) }}" class="btn-action {{ $interview->status === 'Completed' ? '' : 'btn-action-primary' }}">
                                {{ $interview->status === 'Completed' ? 'View Result' : 'Enter Scores' }}
                                <x-icon name="chevron-right" class="w-4 h-4" />
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 80px 24px; text-align: center;">
                            <div style="background: #F8FAFC; width: 56px; height: 56px; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; border: 1px solid #F1F5F9;">
                                <x-icon name="calendar" class="w-6 h-6" style="color: #94A3B8;" />
                            </div>
                            <h3 style="font-size: 16px; font-weight: 600; color: #0F172A; margin-bottom: 4px;">No interviews scheduled</h3>
                            <p style="font-size: 14px; color: #64748B;">Coordinate sessions by visiting an applicant's profile.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="padding: 20px 24px; border-top: 1px solid #F1F5F9; background: #FAFBFC;">
            {{ $interviews->links() }}
        </div>
    </div>
@endsection
