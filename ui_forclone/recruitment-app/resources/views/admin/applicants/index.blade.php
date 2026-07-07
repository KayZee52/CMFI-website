@extends('layouts.recruitment')

@section('content')
    <!-- Dashboard-style Header -->
    <section class="dashboard-hero">
        <div class="hero-text">
            <h1>Applicants Management</h1>
            <p>Review and process teacher applications across all departments.</p>
        </div>
        <div class="hero-actions">
            <button class="btn btn-secondary">
                <x-icon name="filter" class="w-4 h-4" /> Filter
            </button>
            <button class="btn btn-primary">
                <x-icon name="download" class="w-4 h-4" /> Export List
            </button>
        </div>
    </section>

    <!-- Stats Overview (Dashboard Style) -->
    <div class="stats-grid" style="margin-top: 32px;">
        <div class="stat-card dark">
            <div class="stat-header">
                <span>Total Applicants</span>
                <div class="arrow-icon">
                    <x-icon name="users" />
                </div>
            </div>
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-footer">
                <span class="growth-tag">+{{ $stats['new'] }}</span>
                <span>new this week</span>
            </div>
            <div class="card-bg-waves"></div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span>Shortlisted</span>
                <div class="arrow-icon">
                    <x-icon name="calendar" />
                </div>
            </div>
            <div class="stat-value">{{ $stats['shortlisted'] }}</div>
            <div class="stat-footer">
                <span>Candidates for panel review</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span>In Screening</span>
                <div class="arrow-icon">
                    <x-icon name="search" />
                </div>
            </div>
            <div class="stat-value">{{ $applicants->where('current_stage', 'Phone Screening')->count() }}</div>
            <div class="stat-footer">
                <span>Currently active screening</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span>Success Rate</span>
                <div class="arrow-icon">
                    <x-icon name="dashboard" />
                </div>
            </div>
            <div class="stat-value">12%</div>
            <div class="stat-footer">
                <span class="growth-tag">+2.4%</span>
                <span>since last month</span>
            </div>
        </div>
    </div>

    <!-- Shadcn-inspired Table Section -->
    <div class="table-container" style="margin-top: 32px; box-shadow: var(--shadow-md);">
        <div class="list-header">
            <h2>All Applicants List</h2>
            <div class="search-bar" style="max-width: 380px; width: 100%; background: white; border-radius: 10px; padding: 8px 16px; border: 1px solid #E2E8F0;">
                <x-icon name="search" class="w-4 h-4" style="color: #64748B;" />
                <input type="text" placeholder="Search by name, position or email..." style="font-size: 13px; color: #1E293B;">
                <div style="background: #F1F5F9; border: 1px solid #E2E8F0; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 700; color: #64748B;">⌘K</div>
            </div>
        </div>

        <table class="premium-table">
            <thead>
                <tr>
                    <th>Applicant Info</th>
                    <th>Position & Dept</th>
                    <th>Type</th>
                    <th>Stage Status</th>
                    <th>Submission</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applicants as $applicant)
                    @php $latestApp = $applicant->applications->first(); @endphp
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <img src="{{ asset('images/avatars/avatar_' . (strtolower($applicant->gender) == 'male' ? 'male' : (strtolower($applicant->gender) == 'female' ? 'female' : 'neutral')) . '.png') }}" 
                                     alt="Avatar" 
                                     style="width: 38px; height: 38px; border-radius: 10px; object-fit: cover; border: 1px solid #E2E8F0;">
                                <div>
                                    <div style="font-weight: 600; font-size: 14px; color: #0F172A;">{{ $applicant->full_name }}</div>
                                    <div style="font-size: 12px; color: #64748B;">{{ $applicant->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 500; font-size: 14px; color: #1E293B;">{{ $latestApp?->jobOpening?->position?->title ?? 'N/A' }}</div>
                            <div style="font-size: 12px; color: #94A3B8;">{{ $latestApp?->jobOpening?->position?->department?->name ?? 'General' }}</div>
                        </td>
                        <td>
                            @if($applicant->applicant_type === 'current_teacher')
                                <span class="badge-premium badge-yellow">
                                    Staff Reapp
                                </span>
                            @else
                                <span class="badge-premium badge-blue">
                                    New App
                                </span>
                            @endif
                        </td>
                        <td>
                            <span class="status-tag {{ Str::contains($latestApp?->current_stage ?? '', 'Interview') ? 'in-progress' : (($latestApp?->decision_status ?? '') === 'Hired' ? 'completed' : 'pending') }}" style="padding: 4px 10px; font-size: 11px; border-radius: 6px;">
                                {{ $latestApp?->current_stage ?? 'Pending' }}
                            </span>
                        </td>
                        <td style="font-size: 13px; color: #64748B;">
                            {{ $applicant->created_at->format('M d, Y') }}
                        </td>
                        <td style="text-align: right;">
                            <a href="{{ route('applicants.show', $applicant->id) }}" class="btn-action btn-action-primary">
                                Review Details <x-icon name="chevron-right" class="w-4 h-4" />
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 80px 24px; text-align: center;">
                            <div style="background: #F8FAFC; width: 56px; height: 56px; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; border: 1px solid #F1F5F9;">
                                <x-icon name="users" class="w-6 h-6" style="color: #94A3B8;" />
                            </div>
                            <h3 style="font-size: 16px; font-weight: 600; color: #0F172A; margin-bottom: 4px;">No applicants found</h3>
                            <p style="font-size: 14px; color: #64748B;">Try adjusting your filters or search terms.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="padding: 20px 24px; border-top: 1px solid #F1F5F9; display: flex; justify-content: space-between; align-items: center; background: #FAFBFC;">
            <div style="font-size: 13px; color: #64748B;">
                Showing <b>{{ $applicants->firstItem() }}</b> to <b>{{ $applicants->lastItem() }}</b> of <b>{{ $applicants->total() }}</b> applicants
            </div>
            <div class="pagination-container">
                {{ $applicants->links() }}
            </div>
        </div>
    </div>
@endsection
