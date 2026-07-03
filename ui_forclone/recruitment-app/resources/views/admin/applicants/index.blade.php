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
                <i data-lucide="filter"></i> Filter
            </button>
            <button class="btn btn-primary">
                <i data-lucide="download"></i> Export List
            </button>
        </div>
    </section>

    <!-- Stats Overview (Same style as Dashboard) -->
    <div class="stats-grid" style="margin-top: 32px;">
        <div class="stat-card dark">
            <div class="stat-header">
                <span>Total Applicants</span>
                <div class="arrow-icon">
                    <i data-lucide="users"></i>
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
                    <i data-lucide="star"></i>
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
                    <i data-lucide="search"></i>
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
                    <i data-lucide="trending-up"></i>
                </div>
            </div>
            <div class="stat-value">12%</div>
            <div class="stat-footer">
                <span class="growth-tag">+2.4%</span>
                <span>since last month</span>
            </div>
        </div>
    </div>

    <!-- Main List Container (Mirroring Dashboard Grid Items) -->
    <section class="grid-item" style="margin-top: 32px; padding: 0; overflow: hidden; border: 1px solid var(--border-color); background: var(--white); border-radius: 24px;">
        <!-- Card Header with Search -->
        <div style="padding: 24px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; background: #FAFBFC;">
            <h2 style="font-size: 18px; font-weight: 600; margin: 0;">All Applicants List</h2>
            <div class="search-bar" style="width: 350px; background: white;">
                <i data-lucide="search" style="width: 16px; color: var(--text-light);"></i>
                <input type="text" placeholder="Quick search by name, position or email..." style="font-size: 13px;">
            </div>
        </div>

        <!-- Table View -->
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left; background: #FAFBFC;">
                        <th style="padding: 16px 24px; font-weight: 600; font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Applicant Info</th>
                        <th style="padding: 16px 24px; font-weight: 600; font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Position & Dept</th>
                        <th style="padding: 16px 24px; font-weight: 600; font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Type</th>
                        <th style="padding: 16px 24px; font-weight: 600; font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Stage Status</th>
                        <th style="padding: 16px 24px; font-weight: 600; font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Submission</th>
                        <th style="padding: 16px 24px; font-weight: 600; font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applicants as $applicant)
                        @php $latestApp = $applicant->applications->first(); @endphp
                        <tr style="border-bottom: 1px solid var(--border-color); transition: background 0.2s;" onmouseover="this.style.background='#F8F9FA'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 16px 24px;">
                                <div style="display: flex; align-items: center; gap: 14px;">
                                    <div style="width: 40px; height: 40px; border-radius: 12px; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; border: 1px solid rgba(42, 133, 255, 0.1);">
                                        {{ substr($applicant->first_name, 0, 1) }}{{ substr($applicant->last_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; font-size: 14px; color: var(--text-main);">{{ $applicant->full_name }}</div>
                                        <div style="font-size: 12px; color: var(--text-muted);">{{ $applicant->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 16px 24px;">
                                <div style="font-weight: 500; font-size: 14px; color: var(--text-main);">{{ $latestApp->jobOpening->position->title ?? 'N/A' }}</div>
                                <div style="font-size: 12px; color: var(--text-light);">{{ $latestApp->jobOpening->position->department->name ?? 'General' }}</div>
                            </td>
                            <td style="padding: 16px 24px;">
                                @if($applicant->applicant_type === 'current_teacher')
                                    <span style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 8px; background: #FFF9E6; color: #D4A106; font-size: 11px; font-weight: 600;">
                                        <i data-lucide="refresh-cw" style="width: 10px;"></i> Staff Reapp
                                    </span>
                                @else
                                    <span style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 8px; background: #E6F0FF; color: var(--primary); font-size: 11px; font-weight: 600;">
                                        <i data-lucide="user-plus" style="width: 10px;"></i> New App
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 16px 24px;">
                                <span class="status-tag {{ Str::contains($latestApp->current_stage ?? '', 'Interview') ? 'in-progress' : ($latestApp->decision_status === 'Hired' ? 'completed' : 'pending') }}" style="padding: 6px 12px; border-radius: 10px;">
                                    {{ $latestApp->current_stage ?? 'Pending' }}
                                </span>
                            </td>
                            <td style="padding: 16px 24px; font-size: 14px; color: var(--text-muted);">
                                {{ $applicant->created_at->format('M d, Y') }}
                            </td>
                            <td style="padding: 16px 24px; text-align: right;">
                                <a href="{{ route('applicants.show', $applicant->id) }}" class="btn btn-secondary" style="display: inline-flex; padding: 8px 16px; border-radius: 10px; text-decoration: none; font-size: 13px; border-width: 1px;">
                                    Review Details <i data-lucide="chevron-right" style="width: 14px;"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 64px 24px; text-align: center;">
                                <div style="background: #F8F9FA; width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                                    <i data-lucide="users" style="width: 32px; height: 32px; color: var(--text-light);"></i>
                                </div>
                                <h3 style="font-size: 16px; font-weight: 600; color: var(--text-main); margin-bottom: 4px;">No applicants found</h3>
                                <p style="font-size: 14px; color: var(--text-light);">Try adjusting your filters or search terms.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination (Same style as dashboard) -->
        <div style="padding: 24px; border-top: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; background: #FAFBFC;">
            <div style="font-size: 14px; color: var(--text-muted);">
                Showing <b>{{ $applicants->firstItem() }}</b> to <b>{{ $applicants->lastItem() }}</b> of <b>{{ $applicants->total() }}</b> applicants
            </div>
            <div class="pagination-container">
                {{ $applicants->links() }}
            </div>
        </div>
    </section>
@endsection
