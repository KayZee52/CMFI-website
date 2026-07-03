@extends('layouts.recruitment')

@section('content')
    <!-- Dashboard-style Header -->
    <section class="dashboard-hero">
        <div class="hero-text">
            <h1>Job Openings</h1>
            <p>Manage teaching vacancies and track recruitment status for each position.</p>
        </div>
        <div class="hero-actions">
            @if(auth()->user()->hasRole(['super_admin', 'hr_admin']))
                <a href="{{ route('job-openings.create') }}" class="btn btn-primary" style="text-decoration: none;">
                    <x-icon name="dashboard" class="w-4 h-4" /> Add New Opening
                </a>
            @endif
        </div>
    </section>

    <!-- Stats Overview (Dashboard Style) -->
    <div class="stats-grid" style="margin-top: 32px;">
        <div class="stat-card dark">
            <div class="stat-header">
                <span>Total Vacancies</span>
                <div class="arrow-icon">
                    <x-icon name="briefcase" />
                </div>
            </div>
            <div class="stat-value">{{ $stats['vacancies'] }}</div>
            <div class="stat-footer">
                <span>Across all open positions</span>
            </div>
            <div class="card-bg-waves"></div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span>Open Openings</span>
                <div class="arrow-icon">
                    <x-icon name="calendar" />
                </div>
            </div>
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-footer">
                <span>Currently accepting applications</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span>Dept. Breakdown</span>
                <div class="arrow-icon">
                    <x-icon name="dashboard" />
                </div>
            </div>
            <div class="stat-value">{{ \App\Models\Department::count() }}</div>
            <div class="stat-footer">
                <span>Active departments hiring</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span>Academic Year</span>
                <div class="arrow-icon">
                    <x-icon name="calendar" />
                </div>
            </div>
            <div class="stat-value" style="font-size: 24px; padding: 12px 0;">2026/2027</div>
            <div class="stat-footer">
                <span>Active recruitment cycle</span>
            </div>
        </div>
    </div>

    <!-- Shadcn-inspired Table Section -->
    <div class="table-container" style="margin-top: 32px; box-shadow: var(--shadow-md);">
        <div class="list-header">
            <h2>Active Vacancies List</h2>
            <div class="search-bar" style="width: 380px; background: white; border-radius: 10px; padding: 8px 16px; border: 1px solid #E2E8F0;">
                <x-icon name="search" class="w-4 h-4" style="color: #64748B;" />
                <input type="text" placeholder="Filter positions or departments..." style="font-size: 13px; color: #1E293B;">
            </div>
        </div>

        <table class="premium-table">
            <thead>
                <tr>
                    <th>Position Details</th>
                    <th>Department</th>
                    <th>Spots</th>
                    <th>Status</th>
                    <th>Closing Date</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($openings as $opening)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 36px; height: 36px; border-radius: 10px; background: #F1F5F9; display: flex; align-items: center; justify-content: center; color: var(--primary); border: 1px solid #E2E8F0;">
                                    <x-icon name="briefcase" class="w-5 h-5" />
                                </div>
                                <div style="font-weight: 600; font-size: 14px; color: #0F172A;">{{ $opening->position->title }}</div>
                            </div>
                        </td>
                        <td>
                            <span style="font-size: 14px; color: #475569;">{{ $opening->position->department->name }}</span>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <span style="font-weight: 700; font-size: 14px; color: #0F172A;">{{ $opening->vacancies }}</span>
                                <span style="font-size: 12px; color: #94A3B8;">slots</span>
                            </div>
                        </td>
                        <td>
                            <span class="status-tag {{ $opening->status === 'open' ? 'completed' : 'pending' }}" style="padding: 4px 10px; border-radius: 6px; font-size: 11px;">
                                {{ ucfirst($opening->status) }}
                            </span>
                        </td>
                        <td>
                            <div style="font-size: 13px; color: #64748B; display: flex; align-items: center; gap: 6px;">
                                <x-icon name="calendar" class="w-4 h-4" style="opacity: 0.5;" />
                                {{ $opening->closing_date ? \Carbon\Carbon::parse($opening->closing_date)->format('M d, Y') : 'Ongoing' }}
                            </div>
                        </td>
                        <td style="text-align: right;">
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                <a href="{{ route('job-openings.edit', $opening->id) }}" class="btn-action">
                                    Edit
                                </a>
                                <form action="{{ route('job-openings.destroy', $opening->id) }}" method="POST" onsubmit="return confirm('Archive this job opening?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action" style="color: #EF4444; border-color: #FEE2E2; background: #FEF2F2;">
                                        Archive
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 80px 24px; text-align: center;">
                            <div style="background: #F8FAFC; width: 56px; height: 56px; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; border: 1px solid #F1F5F9;">
                                <x-icon name="briefcase" class="w-6 h-6" style="color: #94A3B8;" />
                            </div>
                            <h3 style="font-size: 16px; font-weight: 600; color: #0F172A; margin-bottom: 4px;">No job openings found</h3>
                            <p style="font-size: 14px; color: #64748B;">Start by creating your first vacancy for the new session.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="padding: 20px 24px; border-top: 1px solid #F1F5F9; background: #FAFBFC;">
            {{ $openings->links() }}
        </div>
    </div>
@endsection
