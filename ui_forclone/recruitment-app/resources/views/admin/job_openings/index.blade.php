@extends('layouts.recruitment')

@section('content')
    <section class="dashboard-hero">
        <div class="hero-text">
            <h1>Job Openings</h1>
            <p>Manage teaching vacancies for the current academic year.</p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('job-openings.create') }}" class="btn btn-primary"><i data-lucide="plus"></i> New Opening</a>
        </div>
    </section>

    @if(session('success'))
        <div class="alert alert-success" style="background: #E8F5E9; color: #1B5E3F; padding: 16px; border-radius: 12px; margin-top: 24px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <section class="grid-item project-list" style="margin-top: 24px;">
        <div class="section-header">
            <h2>Current Openings</h2>
        </div>
        <div class="projects">
            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <thead>
                    <tr style="text-align: left; border-bottom: 1px solid #EFEFEF;">
                        <th style="padding: 12px 16px; font-weight: 600; font-size: 14px; color: var(--text-muted);">POSITION</th>
                        <th style="padding: 12px 16px; font-weight: 600; font-size: 14px; color: var(--text-muted);">DEPARTMENT</th>
                        <th style="padding: 12px 16px; font-weight: 600; font-size: 14px; color: var(--text-muted);">VACANCIES</th>
                        <th style="padding: 12px 16px; font-weight: 600; font-size: 14px; color: var(--text-muted);">STATUS</th>
                        <th style="padding: 12px 16px; font-weight: 600; font-size: 14px; color: var(--text-muted);">CLOSING DATE</th>
                        <th style="padding: 12px 16px; font-weight: 600; font-size: 14px; color: var(--text-muted);">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($openings as $opening)
                        <tr style="border-bottom: 1px solid #F9F9F9;">
                            <td style="padding: 16px; font-weight: 600; font-size: 14px;">
                                {{ $opening->position->title }}
                            </td>
                            <td style="padding: 16px; font-size: 14px;">
                                {{ $opening->position->department->name }}
                            </td>
                            <td style="padding: 16px; font-size: 14px;">
                                {{ $opening->vacancies }}
                            </td>
                            <td style="padding: 16px;">
                                <span class="status-tag {{ $opening->status === 'open' ? 'completed' : 'pending' }}">
                                    {{ ucfirst($opening->status) }}
                                </span>
                            </td>
                            <td style="padding: 16px; font-size: 14px; color: var(--text-muted);">
                                {{ $opening->closing_date ? \Carbon\Carbon::parse($opening->closing_date)->format('M d, Y') : 'N/A' }}
                            </td>
                            <td style="padding: 16px; display: flex; gap: 8px;">
                                <a href="{{ route('job-openings.edit', $opening->id) }}" class="btn-add-small outline" style="text-decoration: none;"><i data-lucide="edit-2" style="width: 14px;"></i></a>
                                <form action="{{ route('job-openings.destroy', $opening->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-add-small outline" style="color: #FF6A55; border-color: #FF6A55;"><i data-lucide="trash-2" style="width: 14px;"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 40px; text-align: center; color: var(--text-muted);">
                                <i data-lucide="briefcase" style="width: 48px; height: 48px; opacity: 0.2; margin-bottom: 12px;"></i>
                                <p>No job openings found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div style="margin-top: 20px;">
                {{ $openings->links() }}
            </div>
        </div>
    </section>
@endsection
