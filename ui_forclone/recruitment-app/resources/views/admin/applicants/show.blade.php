@extends('layouts.recruitment')

@section('content')
    <!-- Detail Hero Section -->
    <section class="dashboard-hero">
        <div style="display: flex; align-items: center; gap: 24px;">
            <a href="{{ route('applicants.index') }}" class="btn-add-small" style="padding: 12px; border-radius: 50%; text-decoration: none;">
                <i data-lucide="arrow-left" style="width: 20px;"></i>
            </a>
            <div class="hero-text">
                <h1 style="display: flex; align-items: center; gap: 12px;">
                    {{ $applicant->full_name }}
                    @if($applicant->applicant_type === 'current_teacher')
                        <span style="font-size: 12px; padding: 4px 10px; border-radius: 8px; background: #FFF9E6; color: #D4A106; font-weight: 600;">Internal Staff</span>
                    @endif
                </h1>
                <p>Application ID: <b style="color: var(--text-main);">{{ $applicant->applications->first()->reference_number }}</b> • Submitted {{ $applicant->applications->first()->submitted_at->format('M d, Y') }}</p>
            </div>
        </div>
        <div class="hero-actions">
            <button class="btn btn-secondary">
                <i data-lucide="mail"></i> Message
            </button>
            <div class="dropdown-wrapper" style="position: relative;">
                <form action="{{ route('applications.update-stage', $applicant->applications->first()->id) }}" method="POST" id="stage-form">
                    @csrf
                    <select name="current_stage" onchange="document.getElementById('stage-form').submit()" 
                            style="padding: 12px 20px; border-radius: 14px; border: 2px solid var(--primary); background: white; font-weight: 600; color: var(--primary); font-family: inherit; cursor: pointer; appearance: none; padding-right: 40px;">
                        @php $stages = ['Application Received', 'Phone Screening', 'Shortlisted', 'Interviewing', 'Demo / Observation', 'Background Check', 'Offer Sent', 'Hired / Contract Signed', 'Rejected']; @endphp
                        @foreach($stages as $stage)
                            <option value="{{ $stage }}" {{ $applicant->applications->first()->current_stage === $stage ? 'selected' : '' }}>{{ $stage }}</option>
                        @endforeach
                    </select>
                    <i data-lucide="chevron-down" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: var(--primary); width: 18px;"></i>
                </form>
            </div>
        </div>
    </section>

    <div class="dashboard-grid" style="grid-template-columns: 2fr 1fr; gap: 32px; margin-top: 32px; align-items: start;">
        <!-- Main Content -->
        <div style="display: flex; flex-direction: column; gap: 32px;">
            
            <!-- Information Tabs -->
            <div x-data="{ tab: 'details' }" class="grid-item" style="padding: 0; overflow: hidden; border-radius: 24px; border: 1px solid var(--border-color); background: white;">
                <!-- Tab Headers -->
                <div style="display: flex; background: #FAFBFC; border-bottom: 1px solid var(--border-color); padding: 0 12px;">
                    <button @click="tab = 'details'" :class="tab === 'details' ? 'active-tab' : 'inactive-tab'" style="padding: 20px 24px; font-weight: 600; font-size: 14px; border: none; cursor: pointer; background: none; border-bottom: 2px solid transparent; transition: all 0.3s;">
                        Profile Details
                    </button>
                    <button @click="tab = 'documents'" :class="tab === 'documents' ? 'active-tab' : 'inactive-tab'" style="padding: 20px 24px; font-weight: 600; font-size: 14px; border: none; cursor: pointer; background: none; border-bottom: 2px solid transparent; transition: all 0.3s;">
                        Documents <span style="background: var(--border-color); color: var(--text-muted); font-size: 10px; padding: 2px 6px; border-radius: 6px; margin-left: 6px;">{{ $applicant->applications->first()->documents->count() }}</span>
                    </button>
                    <button @click="tab = 'interviews'" :class="tab === 'interviews' ? 'active-tab' : 'inactive-tab'" style="padding: 20px 24px; font-weight: 600; font-size: 14px; border: none; cursor: pointer; background: none; border-bottom: 2px solid transparent; transition: all 0.3s;">
                        Interviews History
                    </button>
                </div>

                <!-- Tab Content -->
                <div style="padding: 32px;">
                    <!-- Details Content -->
                    <div x-show="tab === 'details'">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px;">
                            <div class="info-block">
                                <label style="display: block; font-size: 11px; font-weight: 700; color: var(--text-light); text-transform: uppercase; margin-bottom: 8px;">Full Name</label>
                                <p style="font-size: 15px; font-weight: 500; margin: 0; color: var(--text-main);">{{ $applicant->full_name }}</p>
                            </div>
                            <div class="info-block">
                                <label style="display: block; font-size: 11px; font-weight: 700; color: var(--text-light); text-transform: uppercase; margin-bottom: 8px;">Applied For</label>
                                <p style="font-size: 15px; font-weight: 500; margin: 0; color: var(--text-main);">{{ $applicant->applications->first()->jobOpening->position->title ?? 'N/A' }}</p>
                            </div>
                            <div class="info-block">
                                <label style="display: block; font-size: 11px; font-weight: 700; color: var(--text-light); text-transform: uppercase; margin-bottom: 8px;">Email Address</label>
                                <p style="font-size: 15px; font-weight: 500; margin: 0; color: var(--primary);">{{ $applicant->email }}</p>
                            </div>
                            <div class="info-block">
                                <label style="display: block; font-size: 11px; font-weight: 700; color: var(--text-light); text-transform: uppercase; margin-bottom: 8px;">Phone Number</label>
                                <p style="font-size: 15px; font-weight: 500; margin: 0; color: var(--text-main);">{{ $applicant->phone }}</p>
                            </div>
                        </div>
                        <div style="margin-top: 32px; padding-top: 32px; border-top: 1px solid var(--border-color);">
                            <label style="display: block; font-size: 11px; font-weight: 700; color: var(--text-light); text-transform: uppercase; margin-bottom: 12px;">Candidate Bio / Statement</label>
                            <p style="font-size: 15px; line-height: 1.8; color: var(--text-muted); margin: 0;">{{ $applicant->bio ?? 'No biological information provided by the candidate.' }}</p>
                        </div>
                    </div>

                    <!-- Documents Content -->
                    <div x-show="tab === 'documents'">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            @forelse($applicant->applications->first()->documents as $doc)
                                <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; border: 1px solid var(--border-color); border-radius: 16px; transition: border 0.3s;" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border-color)'">
                                    <div style="display: flex; align-items: center; gap: 16px;">
                                        <div style="width: 44px; height: 44px; border-radius: 12px; background: #F4F7F6; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                                            <i data-lucide="file-text"></i>
                                        </div>
                                        <div>
                                            <p style="font-size: 14px; font-weight: 600; margin: 0;">{{ $doc->document_type }}</p>
                                            <p style="font-size: 11px; color: var(--text-light); margin: 0;">{{ $doc->original_filename }}</p>
                                        </div>
                                    </div>
                                    <a href="#" class="btn-add-small" style="padding: 8px; border-radius: 10px;">
                                        <i data-lucide="download" style="width: 16px;"></i>
                                    </a>
                                </div>
                            @empty
                                <p style="grid-column: span 2; text-align: center; color: var(--text-light); padding: 40px 0;">No documents uploaded.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Interviews Content -->
                    <div x-show="tab === 'interviews'">
                        <div style="display: flex; flex-direction: column; gap: 16px;">
                            @forelse($applicant->applications->first()->interviews as $interview)
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px; background: #FAFBFC; border-radius: 20px;">
                                    <div style="display: flex; align-items: center; gap: 20px;">
                                        <div style="width: 48px; height: 48px; border-radius: 50%; background: white; border: 1px solid var(--border-color); display: flex; align-items: center; justify-content: center; color: var(--primary);">
                                            <i data-lucide="mic"></i>
                                        </div>
                                        <div>
                                            <h4 style="margin: 0; font-size: 15px; font-weight: 600;">{{ ucfirst($interview->type) }} Interview</h4>
                                            <p style="margin: 4px 0 0; font-size: 12px; color: var(--text-light);">{{ $interview->scheduled_at->format('M d, Y @ H:i') }}</p>
                                        </div>
                                    </div>
                                    <div style="text-align: right;">
                                        <span class="status-tag {{ $interview->status === 'Completed' ? 'completed' : 'pending' }}" style="padding: 6px 14px; font-size: 11px;">{{ $interview->status }}</span>
                                        <div style="margin-top: 8px;">
                                            <a href="#" style="font-size: 12px; font-weight: 600; color: var(--primary); text-decoration: none;">View Scorecard</a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 40px 0;">
                                    <p style="color: var(--text-light); font-size: 14px; margin-bottom: 20px;">No interviews scheduled yet.</p>
                                    <a href="{{ route('interviews.create', ['application_id' => $applicant->applications->first()->id]) }}" class="btn btn-primary" style="display: inline-flex; text-decoration: none;">
                                        <i data-lucide="plus"></i> Schedule First Interview
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes System -->
            <div class="grid-item" style="padding: 32px; border-radius: 24px; border: 1px solid var(--border-color); background: white;">
                <div class="section-header" style="margin-bottom: 24px;">
                    <h2>Internal Notes & Logs</h2>
                    <button class="btn-add-small"><i data-lucide="plus"></i> Add Note</button>
                </div>
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    @foreach($applicant->applications->first()->notes as $note)
                        <div style="display: flex; gap: 16px; padding: 20px; background: {{ $note->type === 'system' ? '#F4F7F6' : '#FFFFFF' }}; border: 1px solid {{ $note->type === 'system' ? 'transparent' : var(--border-color) }}; border-radius: 20px;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: {{ $note->type === 'system' ? 'var(--primary-dark)' : 'var(--primary)' }}; color: white; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i data-lucide="{{ $note->type === 'system' ? 'cpu' : 'user' }}" style="width: 14px;"></i>
                            </div>
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                                    <span style="font-weight: 600; font-size: 13px;">{{ $note->type === 'system' ? 'System Log' : $note->user->name }}</span>
                                    <span style="font-size: 11px; color: var(--text-light);">{{ $note->created_at->diffForHumans() }}</span>
                                </div>
                                <p style="margin: 0; font-size: 14px; line-height: 1.6; color: var(--text-muted);">{{ $note->content }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div style="display: flex; flex-direction: column; gap: 32px;">
            
            <!-- Quick Actions Card -->
            <div class="grid-item" style="padding: 32px; background: linear-gradient(135deg, hsl(223, 100%, 15%), hsl(223, 100%, 25%)); color: white; border: none; border-radius: 24px;">
                <h3 style="margin: 0; font-size: 18px; font-weight: 600;">Hiring Decision</h3>
                <p style="font-size: 13px; opacity: 0.7; margin: 8px 0 24px;">Record the final outcome for this candidate.</p>
                
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <form action="{{ route('applications.decision', $applicant->applications->first()->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="decision_status" value="Shortlisted">
                        <button type="submit" class="btn" style="width: 100%; background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.2); justify-content: center;">
                            <i data-lucide="star"></i> Add to Shortlist
                        </button>
                    </form>

                    <form action="{{ route('applications.decision', $applicant->applications->first()->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="decision_status" value="Hired">
                        <button type="submit" class="btn" style="width: 100%; background: var(--primary); color: white; border: none; justify-content: center; font-weight: 700;">
                            <i data-lucide="check-circle"></i> Hire Candidate
                        </button>
                    </form>

                    <div x-data="{ open: false }">
                        <button @click="open = !open" class="btn" style="width: 100%; background: #FF6A55; color: white; border: none; justify-content: center;">
                            <i data-lucide="x-circle"></i> Reject Candidate
                        </button>
                        <div x-show="open" x-transition style="margin-top: 12px; background: rgba(255,255,255,0.1); padding: 16px; border-radius: 16px;">
                            <form action="{{ route('applications.decision', $applicant->applications->first()->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="decision_status" value="Rejected">
                                <textarea name="rejection_reason" placeholder="Reason for rejection (sent to candidate)..." style="width: 100%; height: 80px; padding: 12px; border-radius: 12px; border: none; font-size: 12px; margin-bottom: 12px;"></textarea>
                                <button type="submit" class="btn btn-secondary" style="width: 100%; font-size: 12px; border-color: rgba(255,255,255,0.3); color: white;">Confirm Rejection</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Department Sync -->
            <div class="grid-item" style="padding: 24px; border-radius: 24px; border: 1px solid var(--border-color); background: white;">
                <h4 style="margin: 0 0 16px; font-size: 14px; font-weight: 600;">Departmental Info</h4>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 36px; height: 36px; border-radius: 50%; background: #F4F7F6; display: flex; align-items: center; justify-content: center; color: var(--text-muted);">
                        <i data-lucide="building-2" style="width: 18px;"></i>
                    </div>
                    <div>
                        <p style="font-size: 14px; font-weight: 600; margin: 0;">{{ $applicant->applications->first()->jobOpening->position->department->name ?? 'N/A' }}</p>
                        <p style="font-size: 12px; color: var(--text-light); margin: 0;">Managed by Dept Head</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .active-tab {
            color: var(--primary) !important;
            border-bottom: 2px solid var(--primary) !important;
        }
        .inactive-tab {
            color: var(--text-light) !important;
        }
        .inactive-tab:hover {
            color: var(--text-muted) !important;
        }
        .info-block label {
            letter-spacing: 0.5px;
        }
    </style>
@endsection
