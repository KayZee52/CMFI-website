@extends('layouts.recruitment')

@section('content')
    <section class="dashboard-hero">
        <div class="hero-text">
            <h1>Applicants</h1>
            <p>Manage and review all teacher applications.</p>
        </div>
        <div class="hero-actions">
            <button class="btn btn-secondary"><i data-lucide="filter"></i> Filter</button>
            <button class="btn btn-primary"><i data-lucide="download"></i> Export List</button>
        </div>
    </section>

    <section class="grid-item project-list" style="margin-top: 24px;">
        <div class="section-header">
            <h2>All Applicants</h2>
            <div class="search-bar" style="margin-left: auto; max-width: 300px;">
                <i data-lucide="search" style="width: 16px; color: #9A9FA5;"></i>
                <input type="text" placeholder="Quick search...">
            </div>
        </div>
        <div class="projects">
            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <thead>
                    <tr style="text-align: left; border-bottom: 1px solid #EFEFEF;">
                        <th style="padding: 12px 16px; font-weight: 600; font-size: 14px; color: var(--text-muted);">APPLICANT</th>
                        <th style="padding: 12px 16px; font-weight: 600; font-size: 14px; color: var(--text-muted);">POSITION</th>
                        <th style="padding: 12px 16px; font-weight: 600; font-size: 14px; color: var(--text-muted);">TYPE</th>
                        <th style="padding: 12px 16px; font-weight: 600; font-size: 14px; color: var(--text-muted);">STAGE</th>
                        <th style="padding: 12px 16px; font-weight: 600; font-size: 14px; color: var(--text-muted);">DATE</th>
                        <th style="padding: 12px 16px; font-weight: 600; font-size: 14px; color: var(--text-muted);">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applicants as $applicant)
                        @php $latestApp = $applicant->applications->first(); @endphp
                        <tr style="border-bottom: 1px solid #F9F9F9;">
                            <td style="padding: 16px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 36px; height: 36px; border-radius: 50%; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px;">
                                        {{ substr($applicant->first_name, 0, 1) }}{{ substr($applicant->last_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; font-size: 14px;">{{ $applicant->full_name }}</div>
                                        <div style="font-size: 12px; color: var(--text-muted);">{{ $applicant->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 16px;">
                                <div style="font-size: 14px;">{{ $latestApp->jobOpening->position->title ?? 'N/A' }}</div>
                                <div style="font-size: 12px; color: var(--text-muted);">{{ $latestApp->jobOpening->position->department->name ?? '' }}</div>
                            </td>
                            <td style="padding: 16px;">
                                <span class="growth-tag {{ $applicant->applicant_type === 'current_teacher' ? 'secondary' : '' }}" style="font-size: 11px;">
                                    {{ $applicant->applicant_type === 'current_teacher' ? 'Staff Reapp' : 'New App' }}
                                </span>
                            </td>
                            <td style="padding: 16px;">
                                <span class="status-tag {{ Str::contains($latestApp->current_stage ?? '', 'Interview') ? 'in-progress' : ($latestApp->decision_status === 'Hired' ? 'completed' : 'pending') }}">
                                    {{ $latestApp->current_stage ?? 'Pending' }}
                                </span>
                            </td>
                            <td style="padding: 16px; font-size: 14px; color: var(--text-muted);">
                                {{ $applicant->created_at->format('M d, Y') }}
                            </td>
                            <td style="padding: 16px;">
                                <a href="{{ route('applicants.show', $applicant->id) }}" class="btn-add-small outline" style="text-decoration: none; padding: 4px 12px; font-size: 12px;">Review</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 40px; text-align: center; color: var(--text-muted);">
                                <i data-lucide="users" style="width: 48px; height: 48px; opacity: 0.2; margin-bottom: 12px;"></i>
                                <p>No applicants found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div style="margin-top: 20px;">
                {{ $applicants->links() }}
            </div>
        </div>
    </section>
@endsection
