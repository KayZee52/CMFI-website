@extends('layouts.recruitment')

@section('content')
    <!-- Header Section -->
    <section class="dashboard-hero">
        <div class="hero-text">
            <h1>Job Openings</h1>
            <p>Manage and track teaching vacancies for the 2026/2027 academic session.</p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('job-openings.create') }}" class="btn btn-primary" style="text-decoration: none;">
                <i data-lucide="plus-circle"></i> Create New Opening
            </a>
        </div>
    </section>

    @if(session('success'))
        <div style="background: #E6F4EA; border-left: 4px solid #28A745; color: #1E7E34; padding: 16px 24px; border-radius: 12px; margin-top: 32px; display: flex; align-items: center; gap: 12px;">
            <i data-lucide="check-circle" style="width: 20px;"></i>
            <span style="font-size: 14px; font-weight: 500;">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Openings Card -->
    <section class="grid-item" style="margin-top: 32px; padding: 0; overflow: hidden; border: 1px solid var(--border-color); background: var(--white); border-radius: 24px;">
        <div style="padding: 24px; border-bottom: 1px solid var(--border-color); background: #FAFBFC; display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 18px; font-weight: 600; margin: 0;">Active Vacancies</h2>
            <div style="display: flex; gap: 12px;">
                <div class="search-bar" style="width: 280px; background: white;">
                    <i data-lucide="search" style="width: 16px; color: var(--text-light);"></i>
                    <input type="text" placeholder="Search positions..." style="font-size: 13px;">
                </div>
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left; background: #FAFBFC;">
                        <th style="padding: 16px 24px; font-weight: 600; font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Position Details</th>
                        <th style="padding: 16px 24px; font-weight: 600; font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Department</th>
                        <th style="padding: 16px 24px; font-weight: 600; font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Vacancies</th>
                        <th style="padding: 16px 24px; font-weight: 600; font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Status</th>
                        <th style="padding: 16px 24px; font-weight: 600; font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Closing Date</th>
                        <th style="padding: 16px 24px; font-weight: 600; font-size: 12px; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($openings as $opening)
                        <tr style="border-bottom: 1px solid var(--border-color); transition: background 0.2s;" onmouseover="this.style.background='#F8F9FA'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 20px 24px;">
                                <div style="display: flex; align-items: center; gap: 14px;">
                                    <div style="width: 40px; height: 40px; border-radius: 12px; background: #F4F7F6; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                                        <i data-lucide="briefcase"></i>
                                    </div>
                                    <div style="font-weight: 600; font-size: 14px; color: var(--text-main);">{{ $opening->position->title }}</div>
                                </div>
                            </td>
                            <td style="padding: 20px 24px;">
                                <span style="font-size: 14px; color: var(--text-muted);">{{ $opening->position->department->name }}</span>
                            </td>
                            <td style="padding: 20px 24px;">
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <b style="font-size: 14px; color: var(--text-main);">{{ $opening->vacancies }}</b>
                                    <span style="font-size: 12px; color: var(--text-light);">spots</span>
                                </div>
                            </td>
                            <td style="padding: 20px 24px;">
                                <span class="status-tag {{ $opening->status === 'Open' ? 'completed' : 'pending' }}" style="padding: 6px 12px; border-radius: 10px;">
                                    {{ ucfirst($opening->status) }}
                                </span>
                            </td>
                            <td style="padding: 20px 24px;">
                                <div style="font-size: 14px; color: var(--text-muted); display: flex; align-items: center; gap: 6px;">
                                    <i data-lucide="calendar" style="width: 14px; opacity: 0.5;"></i>
                                    {{ $opening->closing_date ? \Carbon\Carbon::parse($opening->closing_date)->format('M d, Y') : 'Ongoing' }}
                                </div>
                            </td>
                            <td style="padding: 20px 24px; text-align: right;">
                                <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                    <a href="{{ route('job-openings.edit', $opening->id) }}" class="btn-add-small" style="padding: 8px; border-radius: 10px; text-decoration: none;">
                                        <i data-lucide="edit-3" style="width: 16px;"></i>
                                    </a>
                                    <form action="{{ route('job-openings.destroy', $opening->id) }}" method="POST" onsubmit="return confirm('Archive this job opening?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-add-small" style="padding: 8px; border-radius: 10px; color: #FF6A55; border-color: #FFEAE8; background: #FFEAE8;">
                                            <i data-lucide="trash-2" style="width: 16px;"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 64px 24px; text-align: center;">
                                <div style="background: #F8F9FA; width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                                    <i data-lucide="briefcase" style="width: 32px; height: 32px; color: var(--text-light);"></i>
                                </div>
                                <h3 style="font-size: 16px; font-weight: 600; color: var(--text-main); margin-bottom: 4px;">No job openings found</h3>
                                <p style="font-size: 14px; color: var(--text-light);">Start by creating your first vacancy for the new session.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
