@extends('layouts.recruitment')

@section('content')
    <section class="dashboard-hero">
        <div style="display: flex; align-items: center; gap: 20px;">
            <a href="{{ route('applicants.index') }}" class="icon-btn" style="background: white;"><i data-lucide="arrow-left"></i></a>
            <div class="hero-text">
                <h1>{{ $applicant->full_name }}</h1>
                <p>Application Reference: <span style="color: var(--primary); font-weight: 600;">{{ $applicant->applications->first()->reference_number }}</span></p>
            </div>
        </div>
        <div class="hero-actions">
            <button class="btn btn-secondary"><i data-lucide="mail"></i> Message</button>
            <button class="btn btn-primary"><i data-lucide="check-circle"></i> Update Stage</button>
        </div>
    </section>

    <div class="dashboard-grid" style="grid-template-columns: 2fr 1fr; gap: 24px; margin-top: 24px;">
        <!-- Left Column: Details -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            <!-- Profile Summary -->
            <section class="grid-item" style="padding: 24px;">
                <div class="section-header">
                    <h2>Profile Summary</h2>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 16px;">
                    <div>
                        <p style="font-size: 12px; color: var(--text-muted); margin: 0;">Email</p>
                        <p style="font-size: 14px; font-weight: 500; margin: 4px 0;">{{ $applicant->email }}</p>
                    </div>
                    <div>
                        <p style="font-size: 12px; color: var(--text-muted); margin: 0;">Phone</p>
                        <p style="font-size: 14px; font-weight: 500; margin: 4px 0;">{{ $applicant->phone }}</p>
                    </div>
                    <div>
                        <p style="font-size: 12px; color: var(--text-muted); margin: 0;">Applicant Type</p>
                        <p style="font-size: 14px; font-weight: 500; margin: 4px 0;">{{ ucfirst(str_replace('_', ' ', $applicant->applicant_type)) }}</p>
                    </div>
                    @if($applicant->staff_id)
                    <div>
                        <p style="font-size: 12px; color: var(--text-muted); margin: 0;">Staff ID</p>
                        <p style="font-size: 14px; font-weight: 500; margin: 4px 0;">{{ $applicant->staff_id }}</p>
                    </div>
                    @endif
                </div>
                <div style="margin-top: 20px;">
                    <p style="font-size: 12px; color: var(--text-muted); margin: 0;">Bio / Statement</p>
                    <p style="font-size: 14px; line-height: 1.6; margin: 8px 0;">{{ $applicant->bio ?? 'No bio provided.' }}</p>
                </div>
            </section>

            <!-- Documents -->
            <section class="grid-item" style="padding: 24px;">
                <div class="section-header">
                    <h2>Uploaded Documents</h2>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 16px;">
                    @foreach($applicant->applications->first()->documents as $doc)
                        <div style="display: flex; align-items: center; gap: 12px; padding: 12px; border: 1px solid #EFEFEF; border-radius: 12px;">
                            <i data-lucide="file-text" style="color: var(--primary);"></i>
                            <div style="flex: 1;">
                                <p style="font-size: 13px; font-weight: 600; margin: 0;">{{ $doc->document_type }}</p>
                                <p style="font-size: 11px; color: var(--text-muted); margin: 0;">{{ $doc->original_filename }}</p>
                            </div>
                            <a href="#" class="icon-btn-small" style="color: var(--primary);"><i data-lucide="download" style="width: 16px;"></i></a>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Interviews -->
            <section class="grid-item" style="padding: 24px;">
                <div class="section-header">
                    <h2>Interview History</h2>
                    <a href="{{ route('interviews.create', ['application_id' => $applicant->applications->first()->id]) }}" class="btn-add-small outline" style="text-decoration: none;"><i data-lucide="calendar"></i> Schedule</a>
                </div>
                <div style="margin-top: 16px;">
                    @forelse($applicant->applications->first()->interviews as $interview)
                        <div style="padding: 16px; border-bottom: 1px solid #F9F9F9;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-weight: 600; font-size: 14px;">{{ ucfirst($interview->type) }} Interview</span>
                                <span class="status-tag {{ $interview->status === 'Completed' ? 'completed' : 'pending' }}">{{ $interview->status }}</span>
                            </div>
                            <p style="font-size: 12px; color: var(--text-muted); margin: 4px 0;">{{ $interview->scheduled_at->format('M d, Y @ H:i') }}</p>
                        </div>
                    @empty
                        <p style="color: var(--text-muted); font-size: 14px; text-align: center; padding: 20px 0;">No interviews recorded.</p>
                    @endforelse
                </div>
            </section>
        </div>

        <!-- Right Column: Sidebar Actions & Notes -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            <!-- Application Status -->
            <section class="grid-item" style="padding: 24px; background: var(--primary); color: white;">
                <h3 style="margin: 0; font-size: 16px;">Current Stage</h3>
                <div style="margin: 16px 0; font-size: 24px; font-weight: 700;">
                    {{ $applicant->applications->first()->current_stage }}
                </div>
                <div style="width: 100%; height: 6px; background: rgba(255,255,255,0.2); border-radius: 3px; overflow: hidden;">
                    <div style="width: 40%; height: 100%; background: white;"></div>
                </div>
                <p style="font-size: 12px; margin-top: 12px; opacity: 0.8;">Next expected step: Phone Screening</p>
            </section>

            <!-- Messaging Section -->
            <section class="grid-item" style="padding: 24px;">
                <div class="section-header">
                    <h2>Send Notification</h2>
                </div>
                <div style="margin-top: 16px;">
                    <form action="#" method="POST" onsubmit="alert('Notification request sent to gateway (Placeholder)'); return false;">
                        <div class="form-group">
                            <textarea placeholder="Type your message here..." style="width: 100%; padding: 12px; border: 1.5px solid #EFEFEF; border-radius: 12px; font-family: inherit; font-size: 13px;"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">
                            <i data-lucide="send" style="width: 14px;"></i> Send WhatsApp/SMS
                        </button>
                    </form>
                </div>
            </section>

            <!-- Screening Notes -->
            <section class="grid-item" style="padding: 24px;">
                <div class="section-header">
                    <h2>Notes</h2>
                    <button class="btn-add-small"><i data-lucide="plus"></i></button>
                </div>
                <div style="margin-top: 16px; display: flex; flex-direction: column; gap: 12px;">
                    @foreach($applicant->applications->first()->notes as $note)
                        <div style="padding: 12px; background: #F8F9FA; border-radius: 12px;">
                            <p style="font-size: 13px; margin: 0; line-height: 1.5;">{{ $note->content }}</p>
                            <div style="display: flex; justify-content: space-between; margin-top: 8px; font-size: 11px; color: var(--text-muted);">
                                <span>{{ $note->user->name }}</span>
                                <span>{{ $note->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Quick Decision -->
            <section class="grid-item" style="padding: 24px; border: 2px dashed #EFEFEF; background: transparent;">
                <h3 style="margin: 0 0 16px 0; font-size: 16px; text-align: center;">Hiring Decision</h3>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <button class="btn btn-primary" style="width: 100%;">Shortlist</button>
                    <button class="btn btn-secondary" style="width: 100%; background: #FF6A55; color: white;">Reject</button>
                    <button class="btn btn-secondary" style="width: 100%;">Put on Hold</button>
                </div>
            </section>
        </div>
    </div>
@endsection
