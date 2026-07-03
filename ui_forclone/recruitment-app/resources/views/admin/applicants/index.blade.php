@extends('layouts.recruitment')

@section('content')
    <!-- Header Section -->
    <section class="dashboard-hero">
        <div class="hero-text">
            <h1>Applicants</h1>
            <p>Manage and review teacher applications across all departments.</p>
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

    <!-- Applicants Card Container -->
    <section class="grid-item" style="margin-top: 32px; padding: 0; overflow: hidden; border: 1px solid var(--border-color); background: var(--white); border-radius: 24px;">
        <!-- Card Header with Search -->
        <div style="padding: 24px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; background: #FAFBFC;">
            <h2 style="font-size: 18px; font-weight: 600; margin: 0;">All Applicants</h2>
            <div class="search-bar" style="width: 320px; background: white;">
                <i data-lucide="search" style="width: 16px; color: var(--text-light);"></i>
                <input type="text" placeholder="Quick search name or email..." style="font-size: 13px;">
            </div>
        </div>

        <!-- Table View -->
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left; background: #FAFBFC;">
                        <th style="padding: 16px 24px; font-weight: 600; font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Applicant</th>
                        <th style="padding: 16px 24px; font-weight: 600; font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Position / Dept</th>
                        <th style="padding: 16px 24px; font-weight: 600; font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Type</th>
                        <th style="padding: 16px 24px; font-weight: 600; font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Status Stage</th>
                        <th style="padding: 16px 24px; font-weight: 600; font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Applied Date</th>
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
                                <div style="font-weight: 500; font-size: 14px;">{{ $latestApp->jobOpening->position->title ?? 'N/A' }}</div>
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
                                    Review <i data-lucide="chevron-right" style="width: 14px;"></i>
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

        <!-- Pagination -->
        <div style="padding: 24px; border-top: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; background: #FAFBFC;">
            <div style="font-size: 14px; color: var(--text-muted);">
                Showing <b>{{ $applicants->firstItem() }}</b> to <b>{{ $applicants->lastItem() }}</b> of <b>{{ $applicants->total() }}</b> results
            </div>
            <div class="pagination-container">
                {{ $applicants->links() }}
            </div>
        </div>
    </section>
@endsection
