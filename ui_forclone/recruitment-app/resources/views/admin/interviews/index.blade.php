@extends('layouts.recruitment')

@section('content')
    <section class="dashboard-hero">
        <div class="hero-text">
            <h1>Interview Schedule</h1>
            <p>Track and manage all upcoming panel and demo interviews.</p>
        </div>
    </section>

    <section class="grid-item project-list" style="margin-top: 24px;">
        <div class="section-header">
            <h2>Upcoming Interviews</h2>
        </div>
        <div class="projects">
            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <thead>
                    <tr style="text-align: left; border-bottom: 1px solid #EFEFEF;">
                        <th style="padding: 12px 16px; font-weight: 600; font-size: 14px; color: var(--text-muted);">APPLICANT</th>
                        <th style="padding: 12px 16px; font-weight: 600; font-size: 14px; color: var(--text-muted);">TYPE</th>
                        <th style="padding: 12px 16px; font-weight: 600; font-size: 14px; color: var(--text-muted);">DATE & TIME</th>
                        <th style="padding: 12px 16px; font-weight: 600; font-size: 14px; color: var(--text-muted);">STATUS</th>
                        <th style="padding: 12px 16px; font-weight: 600; font-size: 14px; color: var(--text-muted);">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($interviews as $interview)
                        <tr style="border-bottom: 1px solid #F9F9F9;">
                            <td style="padding: 16px;">
                                <div style="font-weight: 600; font-size: 14px;">{{ $interview->application->applicant->full_name }}</div>
                                <div style="font-size: 12px; color: var(--text-muted);">{{ $interview->application->jobOpening->position->title }}</div>
                            </td>
                            <td style="padding: 16px; font-size: 14px;">
                                {{ ucfirst($interview->type) }}
                            </td>
                            <td style="padding: 16px; font-size: 14px;">
                                {{ \Carbon\Carbon::parse($interview->scheduled_at)->format('M d, Y @ H:i') }}
                            </td>
                            <td style="padding: 16px;">
                                <span class="status-tag {{ $interview->status === 'Completed' ? 'completed' : 'pending' }}">
                                    {{ $interview->status }}
                                </span>
                            </td>
                            <td style="padding: 16px;">
                                <a href="{{ route('interviews.show', $interview->id) }}" class="btn-add-small outline" style="text-decoration: none;">
                                    {{ $interview->status === 'Completed' ? 'View Result' : 'Enter Score' }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 40px; text-align: center; color: var(--text-muted);">
                                <i data-lucide="calendar" style="width: 48px; height: 48px; opacity: 0.2; margin-bottom: 12px;"></i>
                                <p>No interviews scheduled yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div style="margin-top: 20px;">
                {{ $interviews->links() }}
            </div>
        </div>
    </section>
@endsection
